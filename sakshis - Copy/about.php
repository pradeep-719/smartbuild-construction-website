<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About SmartBuild - Our Story and Mission</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">
	 <style>
        /* Base Styles for Readability */
        /* Note: We avoid 'body' but apply general styles to an outer div */
        .about-page-wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #444; /* Darker text */
            background-color: #f7f9fc; /* Very light, cool background */
        }
        
        /* Header Styling */
        .about-hea {
            //background-color: #1a3c58; /* Deep Blue (Strong base) */
            color: white;
            padding: 60px 20px;
            text-align: center;
        }
        .about-hea h1 {
            margin: 0;
            font-size: 3em;
            letter-spacing: 1px;
        }

        /* Main Content Grid/Layout */
        .content-area {
            width: 90%; /* Responsive width */
            max-width: 1200px; /* Maximize readability on huge screens */
            margin: 0 auto;
            padding: 30px 0;
        }
        
        /* Section Styling */
        .about-section {
            padding: 50px 0;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .about-section h2 {
            color: #e87b00; /* Warm Orange (Accent) */
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
        }
        
        .text-block {
            padding: 0 40px;
            text-align: justify;
        }

        /* Responsive Core Values (Flexbox) */
        .value-list {
            list-style: none;
            padding: 0 20px;
            margin: 0;
            display: flex;
            flex-wrap: wrap; /* Allows wrapping on small screens */
            justify-content: center;
            gap: 20px; /* Space between value items */
        }
        
        .value-list li {
            background-color: #fef8f0; /* Very light orange background */
            padding: 25px;
            border: 1px solid #ffcc80;
            border-radius: 8px;
            /* Flex basis for responsiveness */
            flex-basis: calc(33.333% - 20px); /* 3 items per row on large screens */
            box-sizing: border-box;
            text-align: center;
        }
        .value-list li h3 {
            color: #1a3c58;
            margin-top: 0;
        }

        /* CTA Button */
        .cta-button {
            display: inline-block;
            margin: 20px auto;
            padding: 15px 30px;
            text-align: center;
            background-color: #e87b00;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }
        .cta-button:hover {
            background-color: #c96800;
            transform: translateY(-2px);
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .about-hea h1 {
                font-size: 2em;
            }
            .value-list li {
                flex-basis: calc(50% - 20px); /* 2 items per row on tablets */
            }
        }
        @media (max-width: 480px) {
            .value-list li {
                flex-basis: 100%; /* 1 item per row on phones */
            }
            .text-block {
                padding: 0 20px;
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



    <div class="about-page-wrapper">

        <hea class="about-hea">
            <h1>About SmartBuild - Our Story and Mission</h1>
        </hea>

        <div class="content-area">

            <section id="story-mission" class="about-section">
                <h2>Our Story & Mission</h2>
                <div class="text-block">
                    <p>The journey of **SmartBuild** began in [Year] right here in **Dombivli, Maharashtra**, by a team of forward-thinking engineers and construction veterans. We saw an opportunity to modernize the local building landscape by integrating **advanced construction technology** with an unwavering commitment to quality and transparency. Our initial focus was on residential projects, quickly earning a reputation for reliability and innovative design.</p>
                    <p>Our mission is simple yet powerful: **To be the leading construction and design firm in the region, recognized for building structures that stand the test of time, both structurally and aesthetically.** We approach every project, whether a custom home, a commercial complex, or a vital renovation, as a partnership. Our goal is to transform your conceptual vision into a physical reality, on time and within budget, with zero compromise on safety or quality.</p>
                </div>
            </section>
            
            <hr>

            <section id="values" class="about-section">
                <h2>Our Core Values</h2>
                <ul class="value-list">
                    <li>
                        <h3>Integrity & Transparency</h3>
                        <p>Honest communication, detailed cost breakdowns, and project updates ensure complete client confidence.</p>
                    </li>
                    <li>
                        <h3>Engineering Excellence</h3>
                        <p>Superior construction techniques, high-grade materials, and rigorous quality control for structures built for the future.</p>
                    </li>
                    <li>
                        <h3>Client-Centric Approach</h3>
                        <p>Continuous dialogue and tailored solutions ensure the construction experience is seamless and meets your specific goals.</p>
                    </li>
                    <li>
                        <h3>Innovation & Efficiency</h3>
                        <p>Utilizing sustainable materials and advanced project management software to deliver efficiently.</p>
                    </li>
                    <li>
                        <h3>Safety First</h3>
                        <p>Maintaining strict safety protocols on every site; the well-being of all involved is our top priority.</p>
                    </li>
                </ul>
            </section>

            <hr>

            <section id="community" class="about-section">
                <h2>Our Community Commitment</h2>
                <div class="text-block">
                    <p>SmartBuild is not just a business operating in Dombivli; we are a deeply rooted member of the community. We are dedicated to contributing to the growth and development of Maharashtra.</p>
                    <ul>
                        <li>**Local Sourcing:** We partner with **local suppliers and contractors** in the MMR to support regional commerce and ensure rapid material delivery.</li>
                        <li>**Job Creation:** We provide training and employment opportunities, helping to cultivate a skilled workforce in the local construction sector.</li>
                        <li>**Sustainable Building:** We promote **eco-friendly and energy-efficient building practices** to enhance the sustainability of regional infrastructure.</li>
                    </ul>
                </div>
            </section>

            <hr>

            <section id="team-cta" class="about-section" style="text-align: center;">
                <h2>Ready to Start Your Project?</h2>
                <p>Our strength lies in our people. SmartBuild is led by certified engineers and seasoned project managers who bring decades of combined experience. Learn more about the experts who make your construction vision a reality.</p>
                <a href="team.php" class="cta-button" style="margin-right: 20px;">View Our Team Page</a>
                <a href="contractorfro.php" class="cta-button" style="background-color: #1a3c58;"> Client Testimonials</a>
            </section>

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