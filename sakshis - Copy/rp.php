<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="sty.css">
    <title>Modern Login Page</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="reg.php" method="POST">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <h4>Please Register Yourself First</h4>
                </div>
                <span>Use your email for registration</span>
                <input type="text" name="Name" placeholder="Name" required>
                <input type="email" name="Email" placeholder="Email" required>
                <input type="password" name="Password" placeholder="Password" required>

                <!-- Hidden fields for GPS location -->
                <input type="hidden" id="Country" name="Country">
                <input type="hidden" id="State" name="State">

                <button type="submit" name="submit">Sign Up</button>
            </form>
        </div>

        <div class="form-container sign-in">
            <form action="consub.php" method="POST">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <h4>Please Login Here</h4>
                </div>
                <span>Use your email and password</span>
                <input type="email" name="Email" placeholder="Email" required>
                <input type="password" name="Password" placeholder="Password" required>
                <a href="forgot_password.php">Forget Your Password?</a>
                <button type="submit" name="submit">Sign In</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>

    <!-- Location Auto-Fill Script -->
    <script>
        // Get location from IP (no GPS permission popup)
        fetch('https://ipapi.co/json/')
            .then(response => response.json())
            .then(data => {
                document.getElementById("Country").value = data.country_name;
                document.getElementById("State").value = data.region;
            })
            .catch(err => console.error("Location fetch failed", err));
    </script>

</body>
</html>
