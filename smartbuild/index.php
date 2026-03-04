<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartBuild | Login & Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f2f3f7;
      padding: 20px;
    }

    .container {
      width: 950px;
      max-width: 100%;
      display: flex;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
      overflow: hidden;
      transition: 0.3s;
      position: relative;
    }

    .image-side {
      flex: 1;
      background: url('https://media.giphy.com/media/l43OIxOfy2O1h2X711/giphy.gif') center/cover no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.8rem;
      font-weight: 600;
      text-align: center;
      padding: 20px;
      letter-spacing: 1px;
    }

    .form-side {
      flex: 1.2;
      padding: 50px;
      background: #fff;
      position: relative;
    }

    .tabs {
      display: flex;
      justify-content: space-around;
      margin-bottom: 25px;
      border-bottom: 2px solid #eee;
    }

    .tab {
      flex: 1;
      text-align: center;
      font-weight: 600;
      padding: 12px;
      cursor: pointer;
      color: #555;
      transition: all 0.3s;
      border-bottom: 3px solid transparent;
    }

    .tab.active {
      color: #0078ff;
      border-color: #0078ff;
    }

    .form {
      display: none;
      animation: fadeIn 0.4s ease;
    }

    .form.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
      color: #333;
    }

    .form input, .form select {
      width: 100%;
      padding: 14px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 15px;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form input:focus, .form select:focus {
      outline: none;
      border-color: #0078ff;
      box-shadow: 0 0 6px rgba(0,120,255,0.25);
    }

    .form button {
      width: 100%;
      padding: 14px;
      background-color: #0078ff;
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      margin-top: 15px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .form button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(0,120,255,0.25);
    }

    .form p {
      text-align: center;
      margin-top: 18px;
      color: #555;
      font-size: 0.9rem;
    }

    .form p a {
      color: #0078ff;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
    }

    .form p a:hover {
      text-decoration: underline;
    }

    .scrollable {
      max-height: 400px;
      overflow-y: auto;
      padding-right: 10px;
    }

    .scrollable::-webkit-scrollbar {
      width: 6px;
    }

    .scrollable::-webkit-scrollbar-thumb {
      background: #0078ff;
      border-radius: 10px;
    }

    @media (max-width: 850px) {
      .container { flex-direction: column; }
      .image-side { display: none; }
      .form-side { padding: 35px 25px; }
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- LEFT -->
    <div class="image-side">
    
    </div>

    <!-- RIGHT -->
    <div class="form-side">
      <div class="tabs">
        <div class="tab active" id="loginTab">Sign In</div>
        <div class="tab" id="registerTab">Sign Up</div>
      </div>

      <!-- LOGIN FORM -->
      <form id="loginForm" class="form active" action="usersub.php" method="POST">
        <h2>Customer Login</h2>
        <input type="email" name="Uemail" placeholder="Enter Email" required>
        <input type="password" name="Upassword" placeholder="Enter Password" required>
        <button type="submit" name="login">Login</button>
        <p><a id="forgotLink">Forgot Password?</a></p>
        <p>Don’t have an account? <a href="inserts.php" id="showRegister">Create one</a></p>
      </form>

      <!-- REGISTER FORM -->
      <form id="registerForm" class="form" action="inserts.php" method="POST">
        <h2>Customer Register page</h2>
        <div class="scrollable">
          <input type="text" name="UName" placeholder="Full Name" required>
          <input type="email" name="Uemail" placeholder="Email Address" required>
          <input type="password" name="Upassword" placeholder="Create Password" required>
          <input type="text" name="Contact" placeholder="Contact Number" required>
          <input type="text" name="Address" placeholder="Full Address" required>
          <input type="text" name="Purpose" placeholder="Requirements (e.g. Renovation, Tiles)" required>
          <label style="font-size:14px;color:#555;">Date of Birth</label>
          <input type="date" name="DOB" required>
          <input type="text" name="Country" placeholder="Country" required>
          <input type="text" name="State" placeholder="State" required>
        </div>
        <button type="submit" name="submit">Register</button>
        <p>Already have an account? <a href="#" id="showLogin">Login here</a></p>
      </form>
    </div>
  </div>

  <script>
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const showRegister = document.getElementById('showRegister');
    const showLogin = document.getElementById('showLogin');

    // Switch between tabs
    function showForm(type) {
      if (type === 'login') {
        loginTab.classList.add('active');
        registerTab.classList.remove('active');
        loginForm.classList.add('active');
        registerForm.classList.remove('active');
      } else {
        registerTab.classList.add('active');
        loginTab.classList.remove('active');
        registerForm.classList.add('active');
        loginForm.classList.remove('active');
      }
    }

    loginTab.addEventListener('click', () => showForm('login'));
    registerTab.addEventListener('click', () => showForm('register'));
    showRegister.addEventListener('click', e => { e.preventDefault(); showForm('register'); });
    showLogin.addEventListener('click', e => { e.preventDefault(); showForm('login'); });

    // === DIRECT REDIRECT TO password.php ===
    const forgotLink = document.getElementById('forgotLink');
    forgotLink.addEventListener('click', () => {
      window.location.href = "password.php";
    });
  </script>
</body>
</html>
