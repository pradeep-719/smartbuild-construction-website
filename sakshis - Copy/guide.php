<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Testimonials - SmartBuild Experts</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">

   <style>
        /* Base Styles */
        .testimonials-page-wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #444;
            background-color: #f7f9fc;
        }
        
        /* Header Styling (Deep Blue) */
        .testimonials-header {
         
            color: black;
            padding: 60px 20px;
            text-align: center;
        }
        .testimonials-header h1 {
            margin: 0;
            font-size: 3em;
        }
        .testimonials-header p {
            font-size: 1.2em;
            margin-top: 10px;
            opacity: 0.9;
        }

        /* Main Content Area */
        .content-area {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px 0;
        }
        
        h2 {
            color: #e87b00; /* Warm Orange Accent */
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.2em;
        }

        /* Testimonials Grid */
        .testimonial-grid {
            display: grid;
            /* 3 columns on large screens, auto-adjusting for space */
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 30px;
            margin-bottom: 50px;
        }

        /* Individual Testimonial Card Styling */
        .testimonial-card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #e87b00; /* Warm Orange accent line */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .quote {
            font-size: 1.1em;
            font-style: italic;
            color: #555;
            margin-bottom: 20px;
        }

        .client-info {
            text-align: right;
            border-top: 1px dashed #eee;
            padding-top: 10px;
        }
        .client-info strong {
            display: block;
            color: #1a3c58; /* Deep Blue name */
            font-size: 1.1em;
        }
        .client-info span {
            font-size: 0.9em;
            color: #888;
        }

        /* CTA Section Styling */
        .cta-section {
            text-align: center;
            padding: 50px 20px;
            background-color: #1a3c58; /* Deep Blue background */
            color: white;
            border-radius: 10px;
        }
        .cta-section h3 {
            font-size: 1.8em;
            margin-bottom: 15px;
        }
        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #e87b00;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 1.1em;
            transition: background-color 0.2s;
        }
        .cta-button:hover {
            background-color: #c96800;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 650px) {
            .testimonial-grid {
                /* On smaller screens, switch to 1 column */
                grid-template-columns: 1fr;
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
    <div class="testimonials-page-wrapper">

        <hea class="testimonials-header">
            <h1>Hear From Our Happy Clients</h1>
            <p>The true measure of our success is the satisfaction of the families and businesses we build for.</p>
        </hea>

        <div class="content-area">

            <section id="client-stories">
                <h2>Real Results, Real Satisfaction</h2>
                
                <div class="testimonial-grid">
                    
                    <div class="testimonial-card">
                        <p class="quote">"SmartBuild turned our dream home into a reality. The quality of work, adherence to the timeline, and professionalism of the entire team were truly outstanding. Highly recommended for custom home construction in Dombivli!"</p>
                        <div class="client-info">
                            
                            <span>Residential Client, Khoni</span>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <p class="quote">"We partnered with SmartBuild for our new office complex, and their project management was impeccable. They handled all the permitting and engineering complexities seamlessly. A reliable partner for commercial projects."</p>
                        <div class="client-info">
                           
                            <span>CEO, TechNova Solutions</span>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <p class="quote">"What impressed us most was the **transparency** in budgeting and the continuous updates. There were no hidden costs or surprises, which is rare in this industry. We felt completely secure throughout the process."</p>
                        <div class="client-info">
                            
                            <span>Bungalow Owner, Kalyan</span>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <p class="quote">"The structural integrity and finish quality are top-notch. They used sustainable and superior materials, exactly as promised. Our building is a testament to SmartBuild's commitment to long-term quality."</p>
                        <div class="client-info">
                           
                            <span>Apartment Building Developer</span>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <p class="quote">"We needed a Vastu-compliant design that didn't compromise on modern aesthetics. SmartBuild's architects achieved this balance perfectly, delivering a beautiful and harmonious living space."</p>
                        <div class="client-info">
                          
                            <span>Custom Home Client</span>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <p class="quote">"They completed the shell structure ahead of schedule! Their efficiency and coordination on-site meant we could move into the finishing phase earlier than anticipated. Excellent work, team!"</p>
                        <div class="client-info">
                            
                            <span>Residential Investor</span>
                        </div>
                    </div>
                    
                </div>
            </section>
            
            <hr>

          

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
    </script>
</body>
</html>