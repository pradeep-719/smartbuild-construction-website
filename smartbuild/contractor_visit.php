<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "usersss");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ✅ Contractor Login Check
if (!isset($_SESSION['email'])) {
    echo "Contractor not logged in!";
    exit();
}

$contractor_email = $_SESSION['email'];

// ✅ Step 1: Get Contractor Details
$getContractor = mysqli_query($conn, "SELECT id, CName, visit_form_filled FROM contractor WHERE Cemail='$contractor_email'");
$contractorData = mysqli_fetch_assoc($getContractor);

if (!$contractorData) {
    die("Contractor not found!");
}

$contractor_id = $contractorData['id'];
$contractor_name = $contractorData['CName'];
$formFilled = $contractorData['visit_form_filled'];

// ✅ Step 2: Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = trim($_POST['user_email']);
    $cost = mysqli_real_escape_string($conn, $_POST['cost']);
    $agree = mysqli_real_escape_string($conn, $_POST['agree']);
    $upi = mysqli_real_escape_string($conn, $_POST['upi'] ?? '');
    $completion_date = mysqli_real_escape_string($conn, $_POST['completion_date'] ?? '');
    $photo = $_FILES['visit_photo']['name'];

    // Input validation
    if (empty($user_email) || !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('❌ Please enter a valid user email.');</script>";
        exit();
    }

    // Handle photo upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    $target_file = $target_dir . time() . "_" . basename($photo);
    move_uploaded_file($_FILES['visit_photo']['tmp_name'], $target_file);

    // ✅ CASE 1: If contractor selects "NO"
    if (strtolower($agree) === 'no') {
        // Delete only this contractor-user pair safely
        mysqli_query($conn, "DELETE FROM user_contractor_status 
                             WHERE contractor_id='$contractor_id' 
                             AND user_id=(SELECT id FROM usertab WHERE Uemail='$user_email' LIMIT 1)");
        mysqli_query($conn, "DELETE FROM contractor_user_response 
                             WHERE contractor_id='$contractor_id' 
                             AND user_id=(SELECT id FROM usertab WHERE Uemail='$user_email' LIMIT 1)");

        // Reset form status
        mysqli_query($conn, "UPDATE contractor SET visit_form_filled = 0 WHERE id='$contractor_id'");

        echo "<script>
            alert('❌ User rejected your proposal. Only this request has been deleted. You can try again with another user.');
            window.parent.postMessage('visitFormSubmitted', '*');
            setTimeout(() => window.location.href = 'docu.php', 1000);
        </script>";
        exit();
    }

    // ✅ CASE 2: If contractor selects "YES"
    $insert = "INSERT INTO visit_form 
               (contractor_email, user_email, cost, user_decision, upi, completion_date, photo)
               VALUES ('$contractor_email', '$user_email', '$cost', '$agree', '$upi', '$completion_date', '$target_file')";
    mysqli_query($conn, $insert);

    // Update form filled flag
    mysqli_query($conn, "UPDATE contractor SET visit_form_filled = 1 WHERE id='$contractor_id'");

    echo "<script>
        alert('✅ User accepted! Project completion date recorded. After completion, 25% will be deducted from your account.');
        window.parent.postMessage('visitFormSubmitted', '*');
        setTimeout(() => window.location.href = 'docu.php', 1000);
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contractor Visit Form</title>
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f2f2f2;
  padding: 20px;
}
.wrapper {
  background: white;
  border-radius: 10px;
  padding: 25px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  width: 100%;
  max-width: 500px;
  margin: 30px auto;
}
.wrapper h2 {
  text-align: center;
  color: #222;
  margin-bottom: 20px;
}
label {
  font-weight: 500;
  margin-top: 10px;
  display: block;
  color: #444;
}
input, select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  margin-top: 5px;
  font-size: 14px;
}
button {
  margin-top: 20px;
  width: 100%;
  background: #007bff;
  color: white;
  border: none;
  padding: 12px;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
}
button:hover { background: #0056b3; }
.hidden { display: none; }
</style>
</head>
<body>

<div class="wrapper">
  <h2>Contractor Visit Form</h2>

  <?php if ($formFilled): ?>
    <p style="text-align:center; color:green; font-weight:500;">✅ You have already submitted your visit form.</p>
  <?php else: ?>
  
  <form id="visitForm" method="POST" enctype="multipart/form-data">
    <label>Contractor Email</label>
    <input type="email" name="contractor_email" value="<?= htmlspecialchars($contractor_email) ?>" readonly>

    <label>User Email (Enter Manually)</label>
    <input type="email" name="user_email" placeholder="Enter user email" required>

    <label>Estimated Cost</label>
    <input type="number" name="cost" required>

    <label>Contractor Visit Photo</label>
    <input type="file" name="visit_photo" accept="image/*" required>

    <label>Did the user agree to work with you?</label>
    <select name="agree" id="agreeSelect" required>
      <option value="">Select</option>
      <option value="yes">Yes</option>
      <option value="no">No</option>
    </select>

    <div id="upiRow" class="hidden">
      <label>Contractor UPI ID</label>
      <input type="text" id="upi" name="upi" placeholder="example@upi">
    </div>

    <div id="completionRow" class="hidden">
      <label>Expected Project Completion Date</label>
      <input type="date" id="completion_date" name="completion_date">
    </div>

    <button type="submit" name="submit">Submit Visit</button>
  </form>

  <?php endif; ?>
</div>

<script>
const agreeSelect = document.getElementById('agreeSelect');
const upiRow = document.getElementById('upiRow');
const upiInput = document.getElementById('upi');
const completionRow = document.getElementById('completionRow');
const completionInput = document.getElementById('completion_date');

agreeSelect?.addEventListener('change', function() {
  if (this.value === 'yes') {
    upiRow.classList.remove('hidden');
    completionRow.classList.remove('hidden');
    upiInput.required = true;
    completionInput.required = true;
  } else {
    upiRow.classList.add('hidden');
    completionRow.classList.add('hidden');
    upiInput.required = false;
    completionInput.required = false;
    upiInput.value = '';
    completionInput.value = '';
  }
});

document.getElementById('visitForm')?.addEventListener('submit', function(e) {
  const agree = agreeSelect.value;
  const userEmail = document.querySelector('input[name="user_email"]').value.trim();

  if (!userEmail) {
    e.preventDefault();
    alert('Please enter user email!');
    return;
  }

  if (agree === '') {
    e.preventDefault();
    alert('Please select Yes or No before submitting.');
  } else if (agree === 'no') {
    alert('❌ User rejected — only this contractor-user pair will be deleted.');
  }
});
</script>

</body>
</html>
