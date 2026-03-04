<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic EMI Calculator</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    
    <style>
        :root {
            --primary-color: #ff8c00; /* Orange */
            --secondary-color: #28a745; /* Green */
            --background-color: #f8f9fa;
            --card-background: #ffffff;
            --text-color: #343a40;
            --border-radius: 8px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --base-font-size: 16px; /* Increased base font size */
        }

        /* Removed 'body' styling as requested. */

        .calculator-container {
            /* Increased max-width from 500px to 650px */
            max-width: 650px; 
            margin: 20px auto;
            background: var(--card-background);
            padding: 30px; /* Increased padding slightly */
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            font-size: var(--base-font-size); /* Apply base font size */
        }

        /* Header */
        .calculator-header {
            display: flex;
            align-items: center;
            justify-content: center;
            /* Increased header font size */
            font-size: 32px; 
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 25px; 
        }
        .calculator-header span {
            margin-left: 10px;
        }

        /* Input Grid */
        .input-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px; /* Increased gap */
            margin-bottom: 20px;
        }
        
        .input-group {
            display: flex;
            flex-direction: column;
        }

        label {
            /* Increased label font size */
            font-size: 16px; 
            margin-bottom: 8px;
            color: var(--text-color);
        }

        input[type="number"] {
            padding: 12px; /* Increased input padding */
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 17px; /* Increased input text size */
        }

        /* Calculate Button */
        #calculateBtn {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 20px; /* Increased button padding */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px; /* Increased button font size */
            font-weight: bold;
            width: 100%;
            margin-bottom: 30px;
            transition: background-color 0.3s;
        }
        #calculateBtn:hover {
            background-color: #cc6c00;
        }
        
        /* Hide results by default */
        .results-section {
            display: none;
        }
        
        /* Results Box */
        .emi-result-header {
            text-align: center;
            color: var(--secondary-color);
            /* Increased header font size */
            font-size: 18px; 
            font-weight: bold;
            margin-bottom: 15px;
        }
        .results-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .result-box {
            background-color: #e6f7ff;
            border: 1px solid #ccc;
            padding: 15px 10px; /* Increased padding */
            border-radius: 4px;
            text-align: center;
        }
        .result-box.monthly-emi {
            background-color: #e3f3e9; 
            border-color: var(--secondary-color);
        }
        .result-box .label {
            /* Increased label font size */
            font-size: 14px; 
            color: #6c757d;
        }
        .result-box .value {
            /* Increased value font size */
            font-size: 22px; 
            font-weight: bold;
            color: var(--text-color);
            margin-top: 5px;
        }

        /* Amortization Table */
        .amortization-section h3, .chart-section h3 {
            display: flex;
            align-items: center;
            /* Increased section header font size */
            font-size: 20px; 
            margin-bottom: 15px;
        }
        .amortization-section h3 { color: var(--secondary-color); }
        .chart-section h3 { color: var(--primary-color); } 
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            /* Increased table font size */
            font-size: 15px; 
        }
        table th {
            background-color: var(--secondary-color);
            color: white;
            padding: 12px; /* Increased table header padding */
            text-align: right;
        }
        table td {
            border: 1px solid #dee2e6;
            padding: 10px; /* Increased table cell padding */
            text-align: right;
        }
        table td:first-child, table th:first-child {
             text-align: center;
        }
        
        /* Chart Size Control */
        .chart-container {
            width: 50%; /* Adjusted width to keep the smaller look within a wider container */
            margin: 0 auto;
        }
        #emiChart {
            max-width: 100%;
            height: auto;
        }

        .chart-legend {
            text-align: center;
            margin-top: 10px;
        }
        .legend-item {
            display: inline-block;
            margin: 0 10px;
            font-size: 15px; /* Increased legend font size */
        }
        .legend-item span {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 5px;
            border-radius: 50%;
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
                <a href="material.php"><b>Materials</b></a>
                
                <a href="alllogin.php" class="btn btn-sm btn-outline"><b>Login /Sign up</b></a>
                
            </nav>
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

<div class="calculator-container">
    <div class="calculator-header">
        <span style="font-size: 20px;">&#x1f4b8;</span>
        <span>SmartBuild EMI Calculator</span>
    </div>

    <form id="emiForm">
        <div class="input-grid">
            <div class="input-group">
                <label for="loanAmount">Loan Amount (₹):</label>
                <input type="number" id="loanAmount" placeholder="e.g., 500000" required>
            </div>
            <div class="input-group">
                <label for="downPayment">Down Payment (₹):</label>
                <input type="number" id="downPayment" placeholder="e.g., 20000">
            </div>
            <div class="input-group">
                <label for="annualRate">% Interest Rate (per annum):</label>
                <input type="number" id="annualRate" step="0.01" placeholder="e.g., 8.5" required>
            </div>
            <div class="input-group">
                <label for="loanYears">Tenure (Years):</label>
                <input type="number" id="loanYears" placeholder="e.g., 20">
            </div>
            <div class="input-group">
                <label for="loanMonths">Tenure (Months):</label>
                <input type="number" id="loanMonths" placeholder="e.g., 60" required>
            </div>
        </div>
        <button type="submit" id="calculateBtn">
            <span style="margin-right: 5px;">&#x24D8;</span> Calculate EMI
        </button>
    </form>

    <div id="resultsSection" class="results-section">
        
        <div class="emi-result-section">
            <div class="emi-result-header">
                <span style="margin-right: 5px;">&#x1f4c8;</span> EMI Result
            </div>
            <div class="results-grid" id="resultsGrid">
                <div class="result-box monthly-emi">
                    <div class="label">Monthly EMI</div>
                    <div class="value" id="monthlyEMI"></div>
                </div>
                <div class="result-box">
                    <div class="label">Total Amount Paid</div>
                    <div class="value" id="totalAmountPaid"></div>
                </div>
                <div class="result-box">
                    <div class="label">Total Interest</div>
                    <div class="value" id="totalInterest"></div>
                </div>
            </div>
        </div>

        <div class="amortization-section">
            <h3>&#x2705; Amortization (First 12 Months)</h3>
            <table id="amortizationTable">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>EMI (₹)</th>
                        <th>Principal (₹)</th>
                        <th>Interest (₹)</th>
                        <th>Balance (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>
        
        <div class="chart-section">
            <h3>&#x1f4b0; Principal vs Interest</h3>
            <div class="chart-container">
                <canvas id="emiChart"></canvas>
            </div>
            <div class="chart-legend">
                <div class="legend-item"><span style="background-color: #ff8c00;"></span> Principal</div>
                <div class="legend-item"><span style="background-color: #28a745;"></span> Interest</div>
            </div>
        </div>
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





  let myChart;
    const CHART_COLOR_PRIMARY = '#ff8c00';
    const CHART_COLOR_SECONDARY = '#28a745';

    // Format ₹ amount with commas
    const formatCurrency = (amount) => {
        const num = Number(amount) || 0;
        return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };

    // Main calculation
    function calculateEMI() {
        const loanAmount = parseFloat(document.getElementById('loanAmount').value) || 0;
        const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
        const annualRate = parseFloat(document.getElementById('annualRate').value) || 0;
        const years = parseInt(document.getElementById('loanYears').value) || 0;
        const months = parseInt(document.getElementById('loanMonths').value) || 0;

        const principal = loanAmount - downPayment;
        const totalMonths = (years * 12) + months;

        if (loanAmount <= 0 || principal <= 0) {
            alert('⚠️ Please enter valid Loan Amount greater than Down Payment.');
            document.getElementById('resultsSection').style.display = 'none';
            if (myChart) myChart.destroy();
            return;
        }
        if (totalMonths <= 0) {
            alert('⚠️ Please enter a valid tenure (years or months).');
            document.getElementById('resultsSection').style.display = 'none';
            if (myChart) myChart.destroy();
            return;
        }
        if (annualRate < 0) {
            alert('⚠️ Interest rate cannot be negative.');
            document.getElementById('resultsSection').style.display = 'none';
            if (myChart) myChart.destroy();
            return;
        }

        const monthlyRate = annualRate / 12 / 100;
        let EMI;

        if (monthlyRate === 0) {
            EMI = principal / totalMonths;
        } else {
            const power = Math.pow(1 + monthlyRate, totalMonths);
            EMI = principal * monthlyRate * (power / (power - 1));
        }

        const totalPaymentEMIs = EMI * totalMonths;
        const totalInterest = totalPaymentEMIs - principal;
        const totalAmountPaid = downPayment + totalPaymentEMIs;

        document.getElementById('monthlyEMI').textContent = `₹ ${formatCurrency(EMI)}`;
        document.getElementById('totalAmountPaid').textContent = `₹ ${formatCurrency(totalAmountPaid)}`;
        document.getElementById('totalInterest').textContent = `₹ ${formatCurrency(totalInterest)}`;

        document.getElementById('resultsSection').style.display = 'block';

        generateAmortization(EMI, principal, monthlyRate, totalMonths);
        updateChart(principal, totalInterest);
    }

    // ✅ Full Amortization table (no 12-month limit)
    function generateAmortization(EMI, principal, monthlyRate, totalMonths) {
        const tableBody = document.getElementById('amortizationTable').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

        let remaining = principal;

        for (let i = 1; i <= totalMonths; i++) {
            const interest = remaining * monthlyRate;
            let principalPaid = EMI - interest;

            if (i === totalMonths) principalPaid = remaining;
            if (principalPaid > remaining) principalPaid = remaining;

            remaining -= principalPaid;
            if (remaining < 0.00001) remaining = 0;

            const row = tableBody.insertRow();
            row.insertCell().textContent = i;
            row.insertCell().textContent = `₹ ${formatCurrency(EMI)}`;
            row.insertCell().textContent = `₹ ${formatCurrency(principalPaid)}`;
            row.insertCell().textContent = `₹ ${formatCurrency(interest)}`;
            row.insertCell().textContent = `₹ ${formatCurrency(remaining)}`;
        }

        // Change heading dynamically
        document.querySelector('.amortization-section h3').innerHTML = 
            `&#x2705; Amortization (${totalMonths} Months)`;
    }

    // Pie chart: Principal vs Interest
    function updateChart(principal, interest) {
        const ctx = document.getElementById('emiChart').getContext('2d');
        if (myChart) myChart.destroy();

        myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Principal', 'Interest'],
                datasets: [{
                    data: [principal, interest],
                    backgroundColor: [CHART_COLOR_PRIMARY, CHART_COLOR_SECONDARY],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false }
                }
            }
        });
    }

    // Event Listener for form submission
    document.getElementById('emiForm').addEventListener('submit', function(e) {
        e.preventDefault();
        calculateEMI();
    });
</script>

</body>
</html>