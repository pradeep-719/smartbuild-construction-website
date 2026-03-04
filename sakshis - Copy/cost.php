<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildBazaar - Your Smart Construction Partner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">

    <!-- Chart.js & PDF -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        :root {
            --bg: #fff7f0;
            --card: #ffffff;
            --muted: #555;
            --accent: #f97316;
            --accent2: #fb923c;
            --dark: #1e293b;
            font-family: "Poppins", sans-serif;
        }

        .main-wrap {
            margin: 0;
            min-height: 100vh;
          
            color: var(--dark);
            padding: 10px;
        }

        .wrapper-box {
            max-width: 950px;
            margin: 0 auto;
            padding: 20px;
        }

        heads {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .logs  {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            color: #fff;
            font-weight: 700;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 {
            margin: 0;
            font-size: 20px;
        }

        .muted {
            color: var(--muted);
            font-size: 13px;
        }

        .card {
            background: var(--card);
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 12px;
            align-items: center;
        }

        label {
            min-width: 130px;
            font-size: 14px;
            color: var(--muted);
        }

        select,
        input[type="number"],
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ffd4a8;
            border-radius: 8px;
            background: transparent;
        }

        .units {
            display: flex;
            gap: 8px;
            align-items: center;
            font-size: 13px;
            color: var(--muted);
        }

        .btnnn {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 14px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }

        .btnnn:hover {
            background: #d86412;
        }

        .btnnn.secondary {
            background: #fff4e6;
            color: var(--accent);
            border: 1px solid #ffd4a8;
        }

        .results {
            display: none;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s ease;
        }

        .results.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .chart-wrap {
            height: 320px;
            width: 100%;
            margin: 10px 0;
        }

        table.resource-table,
        table.grand-total-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.resource-table th,
        table.resource-table td,
        table.grand-total-table th,
        table.grand-total-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        table.resource-table th,
        table.grand-total-table th {
            background: #fff4e6;
            color: #333;
            font-weight: 600;
        }

        .grand-total {
            text-align: right;
            margin-top: 12px;
            font-size: 18px;
            font-weight: 700;
            color: var(--accent);
        }

        .charts-flex {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .charts-flex .chart-box {
            flex: 1 1 400px;
            min-width: 300px;
        }

        foot {
            text-align: center;
            margin: 20px 0;
            color: var(--muted);
            font-size: 13px;
        }

        @media(max-width:600px) {
            .form-row {
                flex-direction: column;
                align-items: flex-start;
            }

            label {
                min-width: 0;
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





<div class="main-wrap">
        <div class="wrapper-box">
            <heads>
                <div class="logs">BS</div>
                <div>
                    <h1>BuildSmart — Cost Calculator</h1>
                    <div class="muted">Estimate construction cost, timeline & resource allocation.</div>
                </div>
            </heads>

            <!-- INPUTS -->
            <div class="card">
                <h3>Project Inputs</h3>

                <div class="form-row">
                    <label>State</label>
                    <input id="state" type="text" placeholder="Enter State Name">
                </div>

                <div class="form-row">
                    <label>City</label>
                    <input id="city" type="text" placeholder="Enter City Name">
                </div>

                <div class="form-row">
                    <label>Area</label>
                    <input id="area" type="number" value="1000">
                    <div class="units">
                        <label><input type="radio" name="unit" value="sqft" checked> sq.ft</label>
                        <label><input type="radio" name="unit" value="sqm"> sq.m</label>
                    </div>
                </div>

                <div class="form-row">
                    <label>Quality</label>
                    <select id="quality">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Include compound wall?</label>
                    <select id="compound">
                        <option value="no" selected>No</option>
                        <option value="yes">Yes (+10%)</option>
                    </select>
                </div>

                <div class="form-row">
                    <button id="nextBtn" class="btnnn">Next →</button>
                    <button id="reset" class="btnnn secondary">Reset</button>
                </div>
            </div>

            <!-- RESULTS -->
            <div id="results" class="results card">
                <h3>Estimate Summary</h3>
                <div>Cost per sq.ft: <span id="costPer">—</span></div>
                <div>Total Estimated Cost: <span id="totalCost">—</span></div>
                <div>Area Used: <span id="usedArea" class="muted">—</span></div>
                <div>Location: <span id="locText" class="muted">—</span></div>
                <hr>

                <div class="charts-flex">
                    <div class="chart-box">
                        <h4>Phase-Wise Cost</h4>
                        <canvas id="phaseDonutChart"></canvas>
                    </div>
                    <div class="chart-box">
                        <h4>Timeline (Days)</h4>
                        <canvas id="timelineChart"></canvas>
                    </div>
                </div>

                <h4>Resource Allocation By Cost</h4>
                <div id="resourceTableArea"></div>

                <h4>Grand Total Breakdown</h4>
                <table class="grand-total-table">
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                    <tr>
                        <td>Material Cost</td>
                        <td id="materialCost">—</td>
                    </tr>
                    <tr>
                        <td>Labour Cost (40%)</td>
                        <td id="labourCost">—</td>
                    </tr>
                    <tr>
                        <td>Electrical (5%)</td>
                        <td id="electricalCost">—</td>
                    </tr>
                    <tr>
                        <td>Plumbing (5%)</td>
                        <td id="plumbingCost">—</td>
                    </tr>
                    <tr>
                        <td>Sanitary (5%)</td>
                        <td id="sanitaryCost">—</td>
                    </tr>
                    <tr>
                        <th>Grand Total</th>
                        <th id="finalGrandTotal">—</th>
                    </tr>
                </table>

                <div style="display:flex;gap:10px;margin-top:10px;flex-wrap:wrap;">
                    <button id="downloadBtn" class="btnnn">Download PDF</button>
                
                </div>
            </div>

            <foot>© 2025 BuildSmart — Cost Estimation</foot>
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
  




   const phasePercents = { "Foundation": 30, "Structure": 25, "Finishing": 30, "Services": 15 };
        const basePhaseDays = { "Foundation": 10, "Structure": 15, "Finishing": 12, "Services": 8 };

        const resources = [
            { name: "Cement", unit: "Bags", rate: { basic: 400, medium: 450, premium: 500 }, factor: 0.8 },
            { name: "Steel", unit: "Kg", rate: { basic: 70, medium: 80, premium: 90 }, factor: 6.0 },
            { name: "Bricks", unit: "Pieces", rate: { basic: 6, medium: 8, premium: 10 }, factor: 16.0 },
            { name: "Sand", unit: "Cft", rate: { basic: 40, medium: 50, premium: 60 }, factor: 1.6 },
            { name: "Paint", unit: "Litres", rate: { basic: 220, medium: 260, premium: 320 }, factor: 0.2 }
        ];

        const fmtINR = n => n.toLocaleString("en-IN", { style: "currency", currency: "INR", maximumFractionDigits: 0 });
        const sqmToSqft = a => a * 10.7639;

        const stateEl = document.getElementById('state'),
            cityEl = document.getElementById('city'),
            areaEl = document.getElementById('area'),
            qualityEl = document.getElementById('quality'),
            compoundEl = document.getElementById('compound'),
            resultsEl = document.getElementById('results'),
            resourceTableArea = document.getElementById('resourceTableArea'),
            costPerEl = document.getElementById('costPer'),
            totalCostEl = document.getElementById('totalCost'),
            usedAreaEl = document.getElementById('usedArea'),
            locText = document.getElementById('locText'),
            materialCostEl = document.getElementById('materialCost'),
            labourCostEl = document.getElementById('labourCost'),
            electricalCostEl = document.getElementById('electricalCost'),
            plumbingCostEl = document.getElementById('plumbingCost'),
            sanitaryCostEl = document.getElementById('sanitaryCost'),
            finalGrandTotalEl = document.getElementById('finalGrandTotal'),
            downloadBtn = document.getElementById('downloadBtn');

        let donutChart = null, timelineChart = null;

        function computeEstimate() {
            const s = stateEl.value.trim(), c = cityEl.value.trim();
            const u = document.querySelector('input[name="unit"]:checked').value;
            let area = parseFloat(areaEl.value) || 0;
            if (s === "" || c === "") { alert("Please enter both State and City."); return null; }
            if (area <= 0) { alert("Enter valid area"); return null; }
            if (u === "sqm") area = sqmToSqft(area);
            if (compoundEl.value === "yes") area *= 1.1;
            const qualityKey = qualityEl.value;
            return { state: s, city: c, area: Math.round(area), qualityKey };
        }

        function renderResults(e) {
            resultsEl.dataset.area = e.area;
            usedAreaEl.textContent = e.area + " sq.ft";
            locText.textContent = `${e.city}, ${e.state}`;
            createResourceTable(e.area, e.qualityKey);
            renderCharts(e.area);
            updateGrandTotal();
        }

        function createResourceTable(area, qualityKey) {
            const gradeMap = { low: 'basic', medium: 'medium', high: 'premium' };
            const selectedGrade = gradeMap[qualityKey] || 'medium';
            let html = `<table class="resource-table"><thead><tr><th>Resource</th><th>Quantity</th><th>Grade</th><th>Amount</th></tr></thead><tbody>`;
            resources.forEach((r, i) => {
                const qty = Math.round(area * r.factor);
                const amt = qty * r.rate[selectedGrade];
                html += `<tr data-index="${i}">
        <td>${r.name}</td><td>${qty.toLocaleString()} ${r.unit}</td>
        <td>
          <label><input type="radio" name="grade${i}" value="basic" ${selectedGrade === 'basic' ? 'checked' : ''}> Basic</label>
          <label><input type="radio" name="grade${i}" value="medium" ${selectedGrade === 'medium' ? 'checked' : ''}> Medium</label>
          <label><input type="radio" name="grade${i}" value="premium" ${selectedGrade === 'premium' ? 'checked' : ''}> Premium</label>
        </td>
        <td class="amt">${fmtINR(amt)}</td></tr>`;
            });
            html += `</tbody><tfoot><tr><th colspan="3" style="text-align:right;">Total Material Cost</th><th id="resourceTotalAmt">—</th></tr></tfoot></table>`;
            resourceTableArea.innerHTML = html;
            document.querySelectorAll('.resource-table input[type="radio"]').forEach(r => r.addEventListener('change', updateGrandTotal));
            updateGrandTotal();
        }

        function updateGrandTotal() {
            const area = parseFloat(resultsEl.dataset.area) || 0;
            let materialTotal = 0;
            document.querySelectorAll('.resource-table tbody tr[data-index]').forEach(row => {
                const i = row.dataset.index;
                const grade = document.querySelector(`input[name="grade${i}"]:checked`).value;
                const qty = parseFloat(row.children[1].textContent.replace(/[^0-9.]/g, "")) || 0;
                const resourceCost = qty * resources[i].rate[grade];
                materialTotal += resourceCost;
                row.children[3].textContent = fmtINR(resourceCost);
            });
            document.getElementById('resourceTotalAmt').textContent = fmtINR(materialTotal);

            const labourTotal = Math.round(materialTotal * 0.4);
            const electricalTotal = Math.round(materialTotal * 0.05);
            const plumbingTotal = Math.round(materialTotal * 0.05);
            const sanitaryTotal = Math.round(materialTotal * 0.05);
            const servicesTotal = electricalTotal + plumbingTotal + sanitaryTotal;
            const totalEstimated = materialTotal + labourTotal + servicesTotal;
            const costPerSqft = area > 0 ? Math.round(totalEstimated / area) : 0;

            materialCostEl.textContent = fmtINR(materialTotal);
            labourCostEl.textContent = fmtINR(labourTotal);
            electricalCostEl.textContent = fmtINR(electricalTotal);
            plumbingCostEl.textContent = fmtINR(plumbingTotal);
            sanitaryCostEl.textContent = fmtINR(sanitaryTotal);
            finalGrandTotalEl.textContent = fmtINR(totalEstimated);
            totalCostEl.textContent = fmtINR(totalEstimated);
            costPerEl.textContent = fmtINR(costPerSqft) + "/sq.ft";

            if (donutChart) {
                donutChart.data.datasets[0].data = [
                    Math.round(materialTotal * 0.3),
                    Math.round(materialTotal * 0.25),
                    Math.round(materialTotal * 0.3),
                    Math.round(materialTotal * 0.15)
                ];
                donutChart.update();
            }
        }

        function renderCharts(area) {
            const phaseCtx = document.getElementById('phaseDonutChart');
            const timelineCtx = document.getElementById('timelineChart');
            if (donutChart) donutChart.destroy();
            if (timelineChart) timelineChart.destroy();

            donutChart = new Chart(phaseCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(phasePercents),
                    datasets: [{
                        data: Object.values(phasePercents),
                        backgroundColor: ['#f97316', '#fb923c', '#fbbf24', '#94a3b8']
                    }]
                },
                options: { plugins: { legend: { position: 'bottom' } } }
            });

            const scale = area / 1000;
            const dynamicDays = {};
            for (let p in basePhaseDays) dynamicDays[p] = Math.round(basePhaseDays[p] * scale);
            const totalDays = Object.values(dynamicDays).reduce((a, b) => a + b, 0);

            timelineChart = new Chart(timelineCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(dynamicDays),
                    datasets: [{
                        label: 'Estimated Days',
                        data: Object.values(dynamicDays),
                        backgroundColor: '#f97316'
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: `⏱️ Total Construction Duration: ${totalDays} days`,
                            color: '#1e293b',
                            font: { size: 14, weight: 'bold' }
                        }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        document.getElementById('nextBtn').onclick = () => {
            const e = computeEstimate();
            if (e) {
                renderResults(e);
                resultsEl.classList.add('show');
                window.scrollTo({ top: resultsEl.offsetTop - 60, behavior: 'smooth' });
            }
        };

        document.getElementById('reset').onclick = () => {
            areaEl.value = 1000;
            qualityEl.value = "medium";
            compoundEl.value = "no";
            stateEl.value = "";
            cityEl.value = "";
            if (donutChart) donutChart.destroy();
            if (timelineChart) timelineChart.destroy();
            resultsEl.classList.remove('show');
        };

        downloadBtn.onclick = async () => {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({ orientation: 'p', unit: 'pt', format: 'a4' });
            await html2canvas(resultsEl, { scale: 2 }).then(canvas => {
                const img = canvas.toDataURL('image/png');
                const width = pdf.internal.pageSize.getWidth();
                const height = (canvas.height * width) / canvas.width;
                pdf.addImage(img, 'PNG', 20, 20, width - 40, height);
                pdf.save('BuildSmart_Estimate.pdf');
            });
        };



  </script>
</body>
</html>