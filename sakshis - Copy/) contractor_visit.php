<!-- Save as contractor_visit.php -->
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Contractor Visit Form</title>
<style>
  /* Simple responsive form */
  body{font-family: Arial, sans-serif; padding:20px; background:#f7f7f7}
  .card{max-width:560px;margin:0 auto;background:white;padding:20px;border-radius:8px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
  .card h2{margin-top:0}
  .row{margin-bottom:12px}
  label{display:block;margin-bottom:6px;font-weight:600}
  input[type="text"], input[type="number"], input[type="file"], textarea, select{
    width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;box-sizing:border-box
  }
  .inline{display:flex; gap:8px}
  .btn{display:inline-block;padding:10px 16px;border:none;background:#0b6efd;color:white;border-radius:6px;cursor:pointer}
  .btn:disabled{opacity:0.6;cursor:not-allowed}
  .hidden{display:none}
  .note{font-size:0.9rem;color:#555}
</style>
</head>
<body>
<div class="card">
  <h2>Contractor Visit Form</h2>
  <form id="visitForm" action="submit_visit.php" method="post" enctype="multipart/form-data">
    <!-- Hidden/available values depending on your app: user_id & contractor_id -->
    <input type="hidden" name="user_id" value="USER_123"> <!-- replace dynamically -->
    <input type="hidden" name="contractor_id" value="CONTRACTOR_456"> <!-- replace -->

    <div class="row">
      <label for="cost">Estimated Cost (INR)</label>
      <input id="cost" name="cost" type="number" step="0.01" min="0" placeholder="e.g. 1500.00" required>
    </div>

    <div class="row">
      <label for="photo">Contractor Visit Photo</label>
      <input id="photo" name="photo" type="file" accept="image/*" required>
      <div class="note">Please upload a clear photo of the visit/site.</div>
    </div>

    <div class="row">
      <label>Do you agree to hire this contractor?</label>
      <div class="inline">
        <label><input type="radio" name="agree" value="yes" required> Yes</label>
        <label><input type="radio" name="agree" value="no" required> No</label>
      </div>
    </div>

    <div class="row hidden" id="upiRow">
      <label for="upi">Contractor UPI ID (only if you chose Yes)</label>
      <input id="upi" name="contractor_upi" type="text" placeholder="example@upi">
    </div>

    <div class="row">
      <button type="submit" id="submitBtn" class="btn">Submit</button>
    </div>
  </form>
</div>

<script>
  // Show UPI field only when agree = yes
  const form = document.getElementById('visitForm');
  const upiRow = document.getElementById('upiRow');
  const upiInput = document.getElementById('upi');

  form.addEventListener('change', (e) => {
    if (e.target.name === 'agree') {
      if (e.target.value === 'yes') {
        upiRow.classList.remove('hidden');
        upiInput.required = true;
      } else {
        upiRow.classList.add('hidden');
        upiInput.required = false;
        upiInput.value = '';
      }
    }
  });

  form.addEventListener('submit', function(evt){
    // show alert/confirm before submit
    const agree = form.querySelector('input[name="agree"]:checked');
    if (!agree) {
      alert('Please select Yes or No.');
      evt.preventDefault();
      return;
    }

    if (agree.value === 'yes') {
      const confirmed = confirm('Dhyaan: Pura work hone ke baad aapke account se 25% amount cut jaayega. Kya aap confirm karte hain?');
      if (!confirmed) {
        evt.preventDefault();
        return;
      }
    } else {
      // If 'no' then still submit but no UPI required
      const confirmedNo = confirm('Aapne "No" chuna hai. Kya aap sure hain?');
      if (!confirmedNo) {
        evt.preventDefault();
        return;
      }
    }

    // Optional: disable submit to prevent double submit
    document.getElementById('submitBtn').disabled = true;
  });
</script>
</body>
</html>
