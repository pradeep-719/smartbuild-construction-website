<?php
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_GET['email']) || empty($_GET['email'])) {
    die("<h3 style='color:red; text-align:center;'>❌ Contractor email missing in URL!</h3>
         <p style='text-align:center;'>Use like: userupload.php?email=contractor@gmail.com</p>");
}

$contractor_email = trim($_GET['email']);

// ✅ Fetch contractor name
$stmt = $conn->prepare("SELECT CName FROM contractor WHERE Cemail = ?");
$stmt->bind_param("s", $contractor_email);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows > 0) {
    $data = $res->fetch_assoc();
    $contractor_name = $data['CName'];
} else {
    die("<h3 style='color:red; text-align:center;'>❌ Contractor not found!</h3>");
}
$stmt->close();

// ✅ Fetch uploaded work using contractor_email
$stmt = $conn->prepare("SELECT worker_id, user_email, image_filename, description, log_datetime 
                        FROM track_updates 
                        WHERE contractor_email = ?
                        ORDER BY log_datetime DESC");
$stmt->bind_param("s", $contractor_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($contractor_name) ?> - Uploaded Work</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
/* === General Layout === */
body {
  font-family: "Poppins", sans-serif;
  background: #eef2ff;
  margin: 0;
  padding: 20px;
  overflow-x: hidden;
}
.container {
  max-width: 1250px;
  margin: 30px auto;
  background: #fff;
  border-radius: 15px;
  padding: 25px 30px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}
h2 {
  text-align: center;
  color: #ff7b00;
  margin-bottom: 25px;
  font-size: 1.7rem;
}

/* === Grid (3 per row desktop) === */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); /* ✅ smaller width */
  gap: 20px;
  justify-content: center;
}

/* === Card === */
.card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 3px 12px rgba(0,0,0,0.1);
  overflow: hidden;
  transition: transform 0.3s, box-shadow 0.3s;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 16px rgba(0,0,0,0.15);
}

/* === Image === */
.card img {
  width: 100%;
  height: 130px;  /* ✅ reduced height */
  object-fit: cover;
  border-bottom: 3px solid #ff7b00;
}

/* === Content === */
.card-content {
  padding: 10px 12px;
}
.card-content h4 {
  color: #ff7b00;
  font-size: 0.95rem;
  margin-bottom: 6px;
}
.card-content p {
  font-size: 0.85rem;
  color: #555;
  line-height: 1.4;
}
.date {
  font-size: 0.75rem;
  color: #888;
  margin-top: 6px;
}
.empty {
  text-align: center;
  font-size: 1rem;
  color: #777;
  margin-top: 30px;
}

/* === Responsive === */
@media (max-width: 992px) {
  .grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media (max-width: 600px) {
  .grid {
    grid-template-columns: 1fr;
  }
  .card img {
    height: 120px;
  }
}
</style>
</head>
<body>

<div class="container">
  <h2>📁 Work Uploaded by <?= htmlspecialchars($contractor_name) ?></h2>

  <div class="grid">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $worker = htmlspecialchars($row['worker_id']);
            $userEmail = htmlspecialchars($row['user_email']);
            $desc = htmlspecialchars($row['description']);
            $date = htmlspecialchars($row['log_datetime']);
            $imgPath = "uploads/" . htmlspecialchars($row['image_filename']);

            echo "
            <div class='card'>
              <img src='$imgPath' alt='Work Image'>
              <div class='card-content'>
                <h4>👷 Contractor: $worker</h4>
                <p>📧 Sent To: $userEmail</p>
                <p>$desc</p>
                <p class='date'>📅 Uploaded on: $date</p>
              </div>
            </div>";
        }
    } else {
        echo "<p class='empty'>No uploads found for this contractor.</p>";
    }
    ?>
  </div>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
