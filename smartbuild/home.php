<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildBazaar - Your Smart Construction Partner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stls.css">
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
              
           <a href="http://localhost/buildsmart-frontend/home.php">Materials</a>

                
                <a href="alllogin.php" class="btn btn-sm btn-outline"><b>Login /Sign up</b></a>
                
            </nav>
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <section id="hero" class="hero-section">
        <div class="container hero-main-content">
            <div class="hero-text">
                <h1>Building Your Vision, Brick by Brick.</h1>
                <p class="lead">Connect with top-rated contractors, source quality materials, and manage your construction projects effortlessly – all within your budget.</p>
                <div class="hero-actions">
                    <a href="#contractors" class="btn btn-primary btn-lg">Find a Contractor</a>
                    <a href="#materials" class="btn btn-secondary btn-lg">Browse Materials</a>
                </div>
            </div>
            <div class="hero-card">
                <h3>Get a Quick Project Estimate</h3>
                <form>
                    <div class="form-group">
                        <label for="construction-type">Construction Type</label>
                        <select id="construction-type">
                            <option value="home">Residential Home</option>
                            <option value="commercial">Commercial Building</option>
                            <option value="renovation">Renovation / Remodel</option>
                            <option value="foundation">Foundation Only</option>
                        </select>
                    </div>
                    <div class="input-row">
                        <div class="form-group">
                            <label for="area">Area (Sq.ft)</label>
                            <input type="number" id="area" placeholder="e.g., 1200" min="0">
                        </div>
                        <div class="form-group">
                            <label for="budget">Target Budget (₹)</label>
                            <input type="number" id="budget" placeholder="e.g., 500000" min="0">
                        </div>
                    </div>
                   
<button type="button" class="btn btn-dark btn-full-width"
        onclick="window.location.href='cost.php';">
    Calculate Estimate
</button>
      
                </form>
            </div>
        </div>
    </section>
<section class="building-tools">
            <div class="container">
                <h2>Homes Building tools to help start planning your home</h2>
                <p>Essential tools to help you take informed decisions while planning to build your home</p>
                <div class="tools-grid">
                    <div class="tool-card">
                        <i class="fas fa-calculator"></i>
                        <h3>Cost Calculator</h3>
                        <p>Every home-builder wants to build their dream home but do so without going over budget. By using the Cost Calculator, ...</p>
                        <a href="cost.php" class="arrow-btn"><i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="tool-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Store Locator</h3>
                        <p>It is important for a home builder to select the right products during the initial stages of constructing a ...</p>
                        <a href="strr.php" class="arrow-btn"><i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="tool-card">
                        <i class="fas fa-chart-line"></i>
                        <h3>Product Predictor</h3>
                        <p>For a home builder, it is important to find the right store where one can get all the valuable information</p>
                        <a href="predict.php" class="arrow-btn"><i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="tool-card">
                        <i class="fas fa-money-check-alt"></i>
                        <h3>EMI Calculator</h3>
                        <p>Taking a home loan is one of the best ways to finance home-building but home builders often ask how much</p>
                        <a href="emi.php" class="arrow-btn"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>


   <section class="home-building-stages-section">
        <div class="container">
            <div class="stages-card">
                <h3>Home Building Stages</h3>
                <ul>
                    <li>
                         <span> <i class="fas fa-pencil-ruler"></i>Planning</span>
                      <a href="planning.php"><i class="fas fa-chevron-right"></i></a>
                    </li>
                    <li>
                        <span><i class="fas fa-map-marked-alt"></i> Choosing Land</span>
                         <a href="landstage.php"><i class="fas fa-chevron-right"></i></a>
                    </li>
                    <li>
                        <span><i class="fas fa-calculator"></i> Making Budget</span>
                        <a href="cost.php"><i class="fas fa-chevron-right"></i></a>
                    </li>
                    <li>
                        <span><i class="fas fa-users"></i> Choosing Project</span>
                         <a href="showpro.php"><i class="fas fa-chevron-right"></i></a>
                    </li>
                    <li>
                        <span><i class="fas fa-boxes"></i> Selecting Material</span>
                        <a href="material.php"><i class="fas fa-chevron-right"></i></a>
                    </li>
                    <li>
                        <span><i class="fas fa-eye"></i> Supervising Work</span>
                        <a href="work.php"><i class="fas fa-chevron-right"></i></a>
                    </li>
                    <li>
                        <span><i class="fas fa-truck-moving"></i> Moving In</span>
                         <a href="move.php"><i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </section>



    <section id="contractors" class="top-rated-contractors">
        <div class="container">
            <h2 class="section-title">Meet Our Top-Rated Contractors</h2>
            <p class="subtitle">Verified professionals delivering excellence in every project.</p>
            <div class="top-rated-list">
                <div class="top-contractor-card">
                    <div class="contractor-header">
                        <img src="https://thumbs2.imgbox.com/58/94/2bllNi5Z_t.jpg" alt="Jane C. Construction Avatar">
                        <div class="contractor-details">
                            <h4>Jane C. Construction</h4>
                            <p class="specialty">Residential & Commercial Builds</p>
                        </div>
                        <div class="rating-display">
                            <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="location"><i class="fas fa-map-marker-alt"></i> Anytown</span>
                        </div>
                    </div>
                    <div class="top-contractor-review">
                        <p>"Jane C. made our house renovation so easy and stress-free. Highly recommend!"</p>
                        <div class="review-meta">
                           
                            <a href="#" class="btn btn-sm btn-outline">For Rennovation</a>
                        </div>
                    </div>
                </div>
                <div class="top-contractor-card">
                    <div class="contractor-header">
                        <img src="https://thumbs2.imgbox.com/31/20/Rxl0Jxyb_t.jpg" alt="Robert R. Mascry Avatar">
                        <div class="contractor-details">
                            <h4>Robert R. Mascry</h4>
                            <p class="specialty">Industrial & Infrastructure</p>
                        </div>
                        <div class="rating-display">
                            <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="location"><i class="fas fa-map-marker-alt"></i> Anytown</span>
                        </div>
                    </div>
                    <div class="top-contractor-review">
                        <p>"Excellent work on our commercial project! Professional and completed on time."</p>
                        <div class="review-meta">
                         
                            <a href="#" class="btn btn-sm btn-outline">For building Constructing</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="contractorfro.php" class="btn btn-primary">See All Contractors <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section id="materials" class="material-selection-section bg-light">
        <div class="container">
            <h2 class="section-title">Source Quality Materials Within Your Budget</h2>
            <p class="subtitle">Explore a diverse catalog of construction materials.</p>

          

            <div class="material-categories-grid">
                <div class="material-card">
                    <div class="material-header">Cement Category</div>
                    <div class="material-content">
                        <img src="https://thumbs2.imgbox.com/46/3c/XICaC6FG_t.png" alt="Cement">
                        <div class="material-details">
                            <h5>Original PPC Cement</h5>
                            <p>High-grade cement for robust and lasting foundations.</p>
                        </div>
                    </div>
                    <div class="material-price-select">
                        <span class="price">₹ 350/bag</span>
                      <a href="http://localhost/buildsmart-frontend/cement.php" class="btn btn-primary">Select Item</a>


                    </div>
                </div>


                <div class="material-card">
                    <div class="material-header">Paint Category</div>
                    <div class="material-content">
                        <img src="https://thumbs2.imgbox.com/35/6b/rd6jNjWe_t.png" alt="paint">
                        <div class="material-details">
                            <h5>Original Paints</h5>
                            <p>Premium quality, termite-resistant, and highly durable.</p>
                        </div>
                    </div>
                    <div class="material-price-select">
                        <span class="price">₹ 1200/sq.ft</span>
                            <a href="http://localhost/buildsmart-frontend/paints.php" class="btn btn-primary">Select Item</a>
                    </div>
                </div>



                <div class="material-card">
                    <div class="material-header">Sand Category</div>
                    <div class="material-content">
                        <img src="https://thumbs2.imgbox.com/83/19/JprFVn2c_t.jpg" alt="Sand">
                        <div class="material-details">
                            <h5>Vitrified Sand (2x2)</h5>
                            <p>Elegant finish, easy to maintain, perfect for modern interiors.</p>
                        </div>
                    </div>
                    <div class="material-price-select">
                        <span class="price">₹ 90/sq.ft</span>
                        <a href="http://localhost/buildsmart-frontend/sand.php" class="btn btn-primary">Select Item</a>
                    </div>
                </div>
               
                </div>
            </div>
         
    <div class="text-center mt-4">
                <a href="http://localhost/buildsmart-frontend/home.php" class="btn btn-primary">View Full Material Catalog <i class="fas fa-arrow-right"></i></a>

          
            </div>
        </div>
    </section>


    <section id="projects" class="recent-projects-gallery">
        <div class="container">
            <h2 class="section-title">Our Recent Projects Gallery</h2>
            <p class="subtitle">Showcasing excellence in residential and commercial construction.</p>
            <div class="recent-projects-grid">
                <div class="project-thumbnail">
                    <img src="https://thumbs2.imgbox.com/cc/88/UIdXDg0p_t.png" alt="Modern Family Home">
                    <div class="project-thumbnail-info">
                        <h4>Modern Family Home</h4>
                        <p>Complete new build with smart home features.</p>
                    </div>
                </div>
                <div class="project-thumbnail">
                    <img src="https://thumbs2.imgbox.com/f2/cc/pvJG56RV_t.jpeg" alt="Suburban Renovation">
                    <div class="project-thumbnail-info">
                        <h4>Suburban House Renovation</h4>
                        <p>Full interior and exterior remodel.</p>
                    </div>
                </div>
                <div class="project-thumbnail">
                    <img src="https://thumbs2.imgbox.com/e0/b4/GhLZdPby_t.jpg" alt="Commercial Office">
                    <div class="project-thumbnail-info">
                        <h4>Commercial Office Space</h4>
                        <p>Contemporary office fit-out and design.</p>
                    </div>
                </div>
                
            </div>
            <div class="text-center mt-4">
                <a href="showpro.php" class="btn btn-primary">View More Projects <i class="fas fa-images"></i></a>
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