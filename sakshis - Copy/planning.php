<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Planning Stage — BuildSmart</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">

<style>
:root {
  --orange: #ff8c00;
  --green: #27ae60;
  --light: #fffdf7;
  --text-dark: #2d3436;
  --text-light: #555;
  --shadow: rgba(0, 0, 0, 0.1);
}

/* ---------- MAIN SECTION ---------- */
.stage-section {
  max-width: 1050px;
  margin: 50px auto;
  padding: 40px 25px;
  background: var(--light);
  border-radius: 20px;
  box-shadow: 0 8px 25px var(--shadow);
  font-family: 'Segoe UI', Tahoma, sans-serif;
}

/* ---------- HEADER ---------- */
.stage-header {
  text-align: center;
  margin-bottom: 45px;
}

.stage-header h1 {
  color: var(--orange);
  font-size: 2.5rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  margin-bottom: 12px;
}

.stage-header p {
  color: var(--text-light);
  font-size: 1.15rem;
}

/* ---------- STEPS GRID ---------- */
.steps-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 30px;
}

/* ---------- STEP CARD ---------- */
.step-card {
  background: white;
  padding: 30px 25px;
  border-radius: 18px;
  border-top: 6px solid var(--green);
  box-shadow: 0 4px 15px var(--shadow);
  position: relative;
  transition: all 0.35s ease;
}

.step-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 22px rgba(0,0,0,0.15);
}

/* ---------- STEP NUMBER ---------- */
.step-num {
  position: absolute;
  top: -20px;
  left: 25px;
  background: var(--orange);
  color: white;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  font-weight: bold;
  font-size: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 3px 8px rgba(255,140,0,0.4);
}

/* ---------- STEP TEXT ---------- */
.step-card h3 {
  margin-top: 25px;
  color: var(--green);
  font-size: 1.35rem;
  font-weight: 600;
}

.step-card p {
  color: var(--text-dark);
  font-size: 1.05rem;
  line-height: 1.7;
  margin-top: 12px;
}

/* ---------- NEXT BUTTON ---------- */
.next-btn {
  display: block;
  width: fit-content;
  margin: 55px auto 0;
  background: linear-gradient(90deg, var(--orange), var(--green));
  color: white;
  padding: 14px 36px;
  border-radius: 30px;
  text-decoration: none;
  font-size: 1.1rem;
  font-weight: 600;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  transition: all 0.3s ease;
}

.next-btn:hover {
  opacity: 0.9;
  transform: scale(1.05);
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 700px) {
  .stage-header h1 {
    font-size: 1.9rem;
  }
  .stage-header p {
    font-size: 1rem;
  }
  .step-card {
    padding: 25px 20px;
  }
  .step-card h3 {
    font-size: 1.2rem;
  }
  .step-card p {
    font-size: 1rem;
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

  <section class="stage-section">
    <div class="stage-header">
      <h1>🏗️ Planning Stage</h1>
      <p>A great home starts with a solid plan. Here’s how you can structure your planning stage effectively.</p>
    </div>

    <div class="steps-grid">
      <div class="step-card">
        <div class="step-num">1</div>
        <h3>Define Your Budget</h3>
        <p>Begin by determining the total investment for your project — include the cost of land, materials, labor, permits, and a buffer for unexpected expenses.</p>
      </div>

      <div class="step-card">
        <div class="step-num">2</div>
        <h3>Concept & Design</h3>
        <p>Collaborate with your architect to create the ideal layout and structure. Focus on efficient use of space, ventilation, natural lighting, and design aesthetics.</p>
      </div>

      <div class="step-card">
        <div class="step-num">3</div>
        <h3>Obtain Approvals</h3>
        <p>Before starting construction, ensure all necessary government and municipal permissions are secured to avoid future legal or financial complications.</p>
      </div>

      <div class="step-card">
        <div class="step-num">4</div>
        <h3>Project Timeline</h3>
        <p>Plan every stage — from foundation to finishing — and set realistic completion dates. Tracking progress helps you stay within time and budget limits.</p>
      </div>
    </div>

  
  </section>
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
    </script>
</body>
</html>