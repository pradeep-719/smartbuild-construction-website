<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) die("Connection Failed: " . $conn->connect_error);

// Fetch contractors
$sql = "SELECT * FROM contractor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contractors</title>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">
<style>
/* Wrapper for contractor cards */
.contractor-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    padding: 30px;
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

/* Individual Contractor Card */
.contractor-card {
    background: #fff;
    width: 250px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    overflow: hidden;
    text-align: center;
    padding: 20px;
    transition: transform 0.2s, box-shadow 0.2s;
}
.contractor-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}

.contractor-card img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    cursor: pointer;
    margin-bottom: 12px;
    border: 3px solid #ff6600;
}

.contractor-card h3 {
    margin: 5px 0;
    font-size: 20px;
    color: #ff6600;
    font-weight: bold;
    text-transform: uppercase;
}

.contractor-card p {
    font-size: 14px;
    margin: 3px 0;
    color: #555;
}

.view-btn {
    margin-top: 12px;
    background: #ff6600;
    color: white;
    border: none;
    padding: 7px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}
.view-btn:hover { background:#e65c00; }

/* ===== Image Modal ===== */
.img-modal {
    display:none;
    position:fixed;
    z-index:1000;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.8);
    justify-content:center;
    align-items:center;
    cursor: zoom-out;
}
.img-modal img {
    max-width:90%;
    max-height:90%;
    object-fit:contain;
    border-radius:12px;
    cursor: zoom-in;
    transition: transform 0.3s ease;
}
.img-modal img.zoomed {
    max-width:none;
    max-height:none;
    width:auto;
    height:auto;
    transform: scale(1.5);
    cursor: zoom-out;
}

/* ===== Detail Modal ===== */
.detail-modal {
    display:none;
    position:fixed;
    z-index:1001;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    padding:20px;
    overflow-y:auto;
}
.detail-modal .modal-content {
    background:white;
    padding:25px;
    max-width:600px;
    width:100%;
    border-radius:12px;
    position:relative;
    text-align:center;
    border-top:6px solid #ff6600;
    box-shadow:0 8px 25px rgba(0,0,0,0.2);
    animation: fadeIn 0.3s ease;
}
.detail-modal .close-btn {
    position:absolute;
    top:12px;
    right:18px;
    font-size:24px;
    cursor:pointer;
    color:#333;
}
.detail-modal img {
    width:140px;
    height:140px;
    object-fit:cover;
    border-radius:50%;
    margin-bottom:15px;
    border:3px solid #ff6600;
}
.detail-modal h2 {
    margin:5px 0;
    font-size:22px;
    color:#ff6600;
    font-weight:bold;
    text-transform:uppercase;
}
.detail-modal .info-grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
    text-align:left;
    margin-top:15px;
    font-size:14px;
    color:#333;
}
.detail-modal .info-grid div {
    word-break: break-word;
}
.detail-modal .full-width {
    grid-column: span 2;
    word-break: break-word;
}
.detail-modal button {
    margin-top:20px;
    padding:10px 20px;
    background:#ff6600;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-weight:bold;
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
}
.detail-modal button:hover { background:#e65c00; }

@keyframes fadeIn {
    0% {opacity:0; transform:translateY(-10px);}
    100% {opacity:1; transform:translateY(0);}
}

@media (max-width:768px){
    .contractor-wrapper {
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }
    .contractor-card { width: 90%; }
    .detail-modal .modal-content { padding:20px; }
    .detail-modal img { width:100px; height:100px; }
    .detail-modal h2 { font-size:20px; }
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
               
                <a href="contractors.php"><b>Contractors</b></a>
              <a href="http://localhost/buildsmart-frontend/home.php">Materials</a>
                
                <a href="alllogin.php" class="btn btn-sm btn-outline"><b>Login /Sign up</b></a>
                
            </nav>
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

<h2 style="text-align:center; padding:20px; background:#2ecc71; color:white; margin:0;">Contractors Details</h2>
<div class="contractor-wrapper">
<?php if($result->num_rows>0){
while($row = $result->fetch_assoc()){
    $detailModalId = "detail_".$row['id'];
    $imgSrc = htmlspecialchars($row['ProfileImage']);
    ?>
<div class="contractor-card">
    <img src="<?= $imgSrc ?>" alt="Profile" onclick="openImageModal('<?= $imgSrc ?>')">
    <h3><?= htmlspecialchars($row['CName']) ?></h3>
    <p><b>Country:</b> <?= htmlspecialchars($row['Country']) ?></p>
    <p><b>State:</b> <?= htmlspecialchars($row['State']) ?></p>
    <button class="view-btn" onclick="openDetailModal('<?= $detailModalId ?>')">View More</button>
</div>

<!-- Detail Modal -->
<div id="<?= $detailModalId ?>" class="detail-modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeDetailModal('<?= $detailModalId ?>')">&times;</span>
        <img src="<?= $imgSrc ?>" alt="Profile">
        <h2><?= htmlspecialchars($row['CName']) ?></h2>
        <div class="info-grid">
            <div><span style="color:#ff6600;">📧</span> <b>Email:</b> <?= htmlspecialchars($row['Cemail']) ?></div>
            <div><span style="color:#ff6600;">📞</span> <b>Contact:</b> <?= htmlspecialchars($row['Contact']) ?></div>
            <div><span style="color:#ff6600;">🌍</span> <b>Country:</b> <?= htmlspecialchars($row['Country']) ?></div>
            <div><span style="color:#ff6600;">📍</span> <b>State:</b> <?= htmlspecialchars($row['State']) ?></div>
            <div class="full-width"><span style="color:#ff6600;">🏠</span> <b>Address:</b> <?= htmlspecialchars($row['Address']) ?></div>
            <div class="full-width"><span style="color:#ff6600;">🛠️</span> <b>Purpose:</b> <?= htmlspecialchars($row['Purpose']) ?></div>
        </div>
        <button onclick="closeDetailModal('<?= $detailModalId ?>')">Close</button>
    </div>
</div>

<?php } } else { ?>
<p style="text-align:center; font-size:16px; color:#555;">No contractors found.</p>
<?php } ?>
</div>

<!-- Image Modal -->
<div id="imageModal" class="img-modal" onclick="closeImageModal()">
    <img id="modalImage" src="" alt="Full Image">
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



const modalImg = document.getElementById('modalImage');

function openImageModal(src){
    modalImg.src = src;
    modalImg.classList.remove('zoomed');
    document.getElementById('imageModal').style.display = 'flex';
}

// Toggle zoom
modalImg.onclick = function(e){
    e.stopPropagation();
    modalImg.classList.toggle('zoomed');
}

function closeImageModal(){
    document.getElementById('imageModal').style.display = 'none';
}

function openDetailModal(id){
    document.getElementById(id).style.display = 'flex';
}
function closeDetailModal(id){
    document.getElementById(id).style.display = 'none';
}

// Click outside modals to close
window.onclick = function(event){
    let details = document.getElementsByClassName('detail-modal');
    let imgModal = document.getElementById('imageModal');
    for(let d of details){
        if(event.target==d){ d.style.display='none'; }
    }
    if(event.target==imgModal){ imgModal.style.display='none'; }
}
</script>

</body>
</html>
