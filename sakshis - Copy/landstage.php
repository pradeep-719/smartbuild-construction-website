<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Land Stage — BuildSmart</title>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">
<style>
:root {
  --orange: #ff8c00;
  --green: #2ecc71;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

.stage-wrapper {
  max-width: 900px;
  margin: 50px auto;
  padding: 20px;
}

/* Header */
.stage-header {
  text-align: center;
  margin-bottom: 40px;
}

.stage-header h1 {
  color: var(--orange);
  font-size: 2.4rem;
  margin-bottom: 10px;
}

.stage-header p {
  color: #555;
  font-size: 1.05rem;
}

/* Timeline */
.timeline {
  position: relative;
  margin-top: 40px;
  padding-left: 25px;
}

.timeline::before {
  content: "";
  position: absolute;
  left: 20px;
  top: 0;
  bottom: 0;
  width: 4px;
  background: linear-gradient(var(--orange), var(--green));
  border-radius: 10px;
}

/* Step Card */
.step-card {
  background: #fff;
  position: relative;
  margin-bottom: 35px;
  padding: 25px 25px 25px 60px;
  border-radius: 14px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.step-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Circle icon on timeline */
.step-icon {
  position: absolute;
  top: 25px;
  left: -5px;
  width: 35px;
  height: 35px;
  border-radius: 50%;
  background: var(--green);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  box-shadow: 0 0 0 4px #fff;
}

/* Step content */
.step-card h3 {
  color: var(--green);
  margin-bottom: 10px;
  font-size: 1.3rem;
}

.step-card p {
  color: #444;
  line-height: 1.7;
  font-size: 1.05rem;
}

/* Next Button */
.next-btn {
  display: block;
  width: fit-content;
  margin: 40px auto 0;
  padding: 12px 30px;
  border-radius: 25px;
  background: linear-gradient(90deg, var(--orange), var(--green));
  color: white;
  font-weight: bold;
  text-decoration: none;
  transition: 0.3s ease;
}

.next-btn:hover {
  transform: scale(1.05);
  opacity: 0.9;
}

/* Responsive */
@media (max-width: 600px) {
  .timeline::before {
    left: 10px;
  }
  .step-card {
    padding: 20px 20px 20px 45px;
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

<section class="stage-wrapper">
  <div class="stage-header">
    <h1>🏡 Land Stage</h1>
    <p>Understanding and securing the right land is the foundation of your successful construction journey.</p>
  </div>

  <div class="timeline">
    <div class="step-card">
      <div class="step-icon">1</div>
      <h3>Identify Suitable Land</h3>
      <p>Start by exploring plots that align with your project’s needs — location, connectivity, and budget. Consider soil quality, drainage, and availability of utilities like water and power.</p>
    </div>

    <div class="step-card">
      <div class="step-icon">2</div>
      <h3>Verify Land Ownership</h3>
      <p>Confirm the rightful owner through government land records. Check for encumbrances, loans, or disputes before proceeding with any deal.</p>
    </div>

    <div class="step-card">
      <div class="step-icon">3</div>
      <h3>Complete Legal Documentation</h3>
      <p>Hire a legal professional to verify the title deed, tax history, and zoning regulations. Ensure all required documents are accurate and up-to-date.</p>
    </div>

    <div class="step-card">
      <div class="step-icon">4</div>
      <h3>Finalize and Register Purchase</h3>
      <p>Once verified, execute the sale deed, pay the stamp duty, and register the property under your name officially to avoid future legal complications.</p>
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
