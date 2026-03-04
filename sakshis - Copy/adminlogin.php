<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login / Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f0f2f5;
    }

    .main-container {
      display: flex;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      width: 800px;
      max-width: 95%;
    }

    .image-container {
      width: 400px;
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
        url('https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExdTZ0c2x0ZW00anllc3B5bjd1Y3hkbTVlM3U3bnNnYmxuamI0ajZ2ZyZlcD12MV9naWZzX3NlYXJjaCZjdD1n/l43OIxOfy2O1h2X711/giphy.gif')
        no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
      padding: 20px;
    }

    .form-container {
      width: 400px;
      padding: 40px;
    }

    .tabs {
      display: flex;
      justify-content: space-around;
      background: #f8f9fa;
      border-bottom: 2px solid #e9ecef;
      margin: 0 -40px 20px -40px;
      padding: 0 40px;
    }

    .tab-btn {
      flex: 1;
      padding: 15px;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      background: transparent;
      cursor: pointer;
      transition: all 0.3s ease;
      color: #6c757d;
    }

    .tab-btn.active {
      color: #ff8c00;
      border-bottom: 2px solid #ff8c00;
    }

    .form {
      display: none;
      animation: fadeIn 0.6s ease-in-out;
    }

    .form.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
      font-weight: 600;
    }

    .form input {
      width: 100%;
      padding: 15px;
      margin: 12px 0;
      border: 1px solid #ddd;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.3s ease;
      box-sizing: border-box;
    }

    .form input:focus {
      outline: none;
      border-color: #ff8c00;
      box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.2);
    }

    .form button {
      width: 100%;
      padding: 15px;
      margin-top: 20px;
      background-color: #ff8c00;
      border: none;
      border-radius: 10px;
      color: white;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .form button:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .form p {
      text-align: center;
      font-size: 0.9rem;
      margin-top: 20px;
      color: #666;
    }

    .form p a {
      color: #ff8c00;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .form p a:hover {
      color: #e67e00;
    }


  </style>
</head>
<body>

  <div class="main-container">
    <div class="image-container"></div>

    <div class="form-container">
      <div class="tabs">
        <button id="signInBtn" class="tab-btn active">Sign In</button>
        <button id="signUpBtn" class="tab-btn">Sign Up</button>
        <button id="signBtn" class="tab-btn">Material Admin</button>
      </div>

      <!-- USER LOGIN FORM -->
      <form id="login" class="form active" action="admintab.php" method="POST">
        <h2>Sign In</h2>
        <input type="email" name="Email" placeholder="Email" required>
        <input type="password" name="Password" placeholder="Password" required>
        <button type="submit" name="su">Login</button>
        <button type="button" onclick="window.location.href='home.php'">Go Back</button>
        <p>Don’t have an account? <a href="adinsert.php" id="createAccountLink">Create one</a></p>
      </form>

      <!-- MATERIAL ADMIN LOGIN -->
      <form id="logins" class="form" action="adminslogin.php" method="POST">
        <h2>Material Admin</h2>
        <input type="text" name="AdminID" placeholder="Enter Admin ID" required>
  <input type="password" name="Password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
        <button type="button" onclick="window.location.href='home.php'">Go Back</button>
      </form>

      <!-- REGISTER FORM -->
      <form id="register" class="form" action="adinsert.php" method="POST">
        <h2>Create an Account</h2>
        <input type="text" name="Name" placeholder="Full Name" required>
        <input type="email" name="Email" placeholder="Email" required>
        <input type="password" name="Password" placeholder="Password" required>

        <input type="hidden" id="Country" name="Country">
        <input type="hidden" id="State" name="State">

        <button type="submit" name="submit">Register</button>
        <button type="button" onclick="window.location.href='home.php'">Go Back</button>
        <p>Already have an account? <a href="#" id="loginLink">Login here</a></p>
      </form>
    </div>
  </div>

  <script>
    const signInBtn = document.getElementById('signInBtn');
    const signUpBtn = document.getElementById('signUpBtn');
    const signBtn = document.getElementById('signBtn');
    const createAccountLink = document.getElementById('createAccountLink');
    const loginLink = document.getElementById('loginLink');

    function showForm(formId, btn) {
      document.querySelectorAll(".form").forEach(form => form.classList.remove("active"));
      document.querySelectorAll(".tab-btn").forEach(tab => tab.classList.remove("active"));
      document.getElementById(formId).classList.add("active");
      btn.classList.add("active");
    }

    signInBtn.addEventListener('click', () => showForm('login', signInBtn));
    signUpBtn.addEventListener('click', () => showForm('register', signUpBtn));
    signBtn.addEventListener('click', () => showForm('logins', signBtn));

    createAccountLink.addEventListener('click', (e) => {
      e.preventDefault();
      showForm('register', signUpBtn);
    });

    loginLink.addEventListener('click', (e) => {
      e.preventDefault();
      showForm('login', signInBtn);
    });

    // Auto-fill location (IP based)
    fetch('https://ipapi.co/json/')
      .then(res => res.json())
      .then(data => {
        document.getElementById("Country").value = data.country_name;
        document.getElementById("State").value = data.region;
      })
      .catch(err => console.error("Location fetch failed", err));
  </script>

</body>
</html>
