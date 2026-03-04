<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🏠 Home Build Predictor</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    .main-wrapper {
    
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .predictor-box {
      background: #fff;
      width: 100%;
      max-width: 550px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(255, 152, 0, 0.3);
      padding: 35px;
      transition: all 0.3s ease;
    }

    .predictor-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(255, 152, 0, 0.4);
    }

    h1 {
      text-align: center;
      color: #f57c00;
      font-size: 1.9rem;
      margin-bottom: 8px;
    }

    p {
      text-align: center;
      color: #8d6e63;
      margin-bottom: 25px;
      font-size: 0.95rem;
    }

    label {
      display: block;
      font-weight: 600;
      color: #4e342e;
      margin-bottom: 6px;
    }

    select,
    input {
      width: 100%;
      padding: 12px 14px;
      font-size: 1rem;
      border: 1.5px solid #ffb74d;
      border-radius: 8px;
      margin-bottom: 20px;
      background: #fffaf3;
      transition: 0.3s;
    }

    select:focus,
    input:focus {
      border-color: #f57c00;
      box-shadow: 0 0 8px rgba(245, 124, 0, 0.4);
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #ff9800;
      color: #fff;
      font-size: 1.05rem;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
      letter-spacing: 0.5px;
    }

    button:hover {
      background: #f57c00;
      transform: scale(1.02);
    }

    .result {
      display: none;
      margin-top: 25px;
      background: #fff3e0;
      border-left: 5px solid #ff9800;
      padding: 18px;
      border-radius: 8px;
      color: #e65100;
      font-size: 1rem;
      line-height: 1.6;
      animation: fadeIn 0.5s ease;
    }

    h3 {
      color: #f57c00;
      margin-bottom: 8px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>

  <header class="header">
        <div class="container">
            <a href="#" class="logo">
                <img src="https://thumbs2.imgbox.com/26/2d/fxicueNg_t.jpg" alt=" ">
                SmartBuild

   </a>
            <nav class="nav-links">
                <a href="home.php"><b>Home</b></a>
               
                <a href="contractorfro.php"><b>Contractors</b></a>
                <a href="material.php"><b>Materials</b></a>
                
                <a href="alllogin.php" class="btn btn-sm btn-outline"><b>Login /Sign up</b></a>
                
            </nav>
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

  <div class="main-wrapper">
    <div class="predictor-box">
      <h1>🏠 Home Build Predictor</h1>
      <p>Get smart product recommendations for your construction journey.</p>

      <label for="phase">Select your current phase:</label>
      <select id="phase">
        <option value="">-- Select Phase --</option>
        <option value="planning">Planning</option>
        <option value="construction">Construction</option>
        <option value="finishing">Finishing</option>
        <option value="maintenance">Maintenance</option>
      </select>

      <label for="budget">Enter your estimated budget (₹):</label>
      <input type="number" id="budget" placeholder="e.g. 500000" />

      <label for="type">Type of Building:</label>
      <select id="type">
        <option value="">-- Select Type --</option>
        <option value="residential">Residential</option>
        <option value="commercial">Commercial</option>
      </select>

      <button onclick="predict()">Predict Recommendation</button>

      <div id="result" class="result"></div>
    </div>
  </div>




 <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <h4>  SmartBuild</h4>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="team.php">Our Team</a></li>
                    <li><a href="ceareer.php">Careers</a></li>
                   
                  
                </ul>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="home.php">Home Construction</a></li>
                    <li><a href="showpro.php">Commercial Projects</a></li>
                 <li><a href="contractorfro.php">Client Testimonials</a></li>
                 
                </ul>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <ul>
                    
                    <li><a href="material.php">Material Catalog</a></li>
                    <li><a href="guide.php">Building Guides</a></li>
                   
                    <li><a href="remark.php">Help Center</a></li>
                    
                </ul>
            </div>
            <div class="footer-col">
                <h4>Connect With Us</h4>
                <p><i class="fas fa-map-marker-alt"></i> 123  SmartBuild St, Dombivli, MH 421201</p>
                <p><i class="fas fa-phone"></i> <a href="tel:+919876543210">+91 98765 43210</a></p>
                <p><i class="fas fa-envelope"></i> <a href="mailto:info@SmartBuild.com">info@  SmartBuild.com</a></p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2025   SmartBuild. All rights reserved.</p>
                <ul class="footer-legal-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </footer>



  <script>
   // JavaScript for Mobile Navigation Toggle
        const mobileMenu = document.getElementById('mobile-menu');
        const navLinks = document.querySelector('.nav-links');

        mobileMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Optional: Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });

                // Close mobile menu after clicking a link
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                }
            });
        });

        // JavaScript for FAQ Accordion
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.closest('.faq-item');
                faqItem.classList.toggle('active');
                // Optional: Close other open FAQ items
                faqQuestions.forEach(item => {
                    if (item !== question && item.closest('.faq-item').classList.contains('active')) {
                        item.closest('.faq-item').classList.remove('active');
                    }
                });
            });
        });

        // Dynamic Progress Bar for "Track My Work" (Example) - Not directly used in this improved HTML, but kept for reference
        // You would typically update this based on backend data for a real application
        const progressSegment = document.querySelector('.progress-segment'); // This element isn't in the new HTML, but keep the JS if you plan to re-add.
        const progressSteps = document.querySelectorAll('.progress-step'); // Same as above.

        function updateProgressBar(activeStepIndex) {
            if (progressSteps.length > 0) { // Check if elements exist before trying to manipulate them
                progressSteps.forEach((step, index) => {
                    if (index <= activeStepIndex) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });

                const totalSteps = progressSteps.length;
                let percentage = 0;
                if (activeStepIndex >= 0) {
                    percentage = (activeStepIndex / (totalSteps - 1)) * 100;
                }
                if (progressSegment) { // Check if progressSegment exists
                    progressSegment.style.width = `${percentage}%`;
                }
            }
        }

        // Set initial progress (e.g., Work Started is the 3rd step, index 2)
        // You would change this value based on actual project status
        // updateProgressBar(2); // Commented out as the element is not present in the HTML


    function predict() {
      const phase = document.getElementById("phase").value;
      const budget = parseInt(document.getElementById("budget").value);
      const type = document.getElementById("type").value;
      const result = document.getElementById("result");

      if (!phase || !budget || !type) {
        alert("⚠️ Please fill all fields before predicting!");
        return;
      }

      let msg = `<h3>🔍 Prediction Result:</h3>`;

      if (phase === "planning")
        msg += `<p>You're in the <b>planning</b> phase — focus on soil testing, layout, and strong foundation materials like premium cement.</p>`;
      else if (phase === "construction")
        msg += `<p>Currently in <b>construction</b> — prioritize concrete mix, TMT bars, and waterproofing for durability.</p>`;
      else if (phase === "finishing")
        msg += `<p>In <b>finishing</b> phase — go for high-quality paints, tiles, and aesthetic design materials.</p>`;
      else
        msg += `<p><b>Maintenance</b> phase — use crack sealers, waterproof coatings, and surface protectors for longevity.</p>`;

      if (budget < 500000)
        msg += `<p>💰 <b>Low budget</b> — prefer reliable yet affordable brands without compromising strength.</p>`;
      else if (budget > 1500000)
        msg += `<p>💎 <b>High budget</b> — explore premium brands, smart home features, and designer finishes.</p>`;
      else
        msg += `<p>⚖️ <b>Medium budget</b> — choose a balanced mix of performance and aesthetics.</p>`;

      if (type === "residential")
        msg += `<p>🏡 For <b>homes</b>, focus on comfort and safety — use quality flooring, waterproofing, and eco-friendly paints.</p>`;
      else
        msg += `<p>🏢 For <b>commercial</b> buildings, durability and top-class finishing should be your priorities.</p>`;

      result.innerHTML = msg;
      result.style.display = "block";
    }
  </script>

</body>

</html>
