<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Making Budget — BuildSmart</title>

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

/* --- HEADER --- */
.stage-title {
  text-align: center;
  color: var(--orange);
  font-size: 2rem;
  margin-top: 40px;
}

.stage-desc {
  text-align: center;
  color: #555;
  font-size: 1rem;
  margin-bottom: 30px;
}

/* --- GRID LAYOUT --- */
.stage-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
  gap: 25px;
  padding: 30px 8%;
}

/* --- CARD DESIGN --- */
.budget-card {
  border: 2px solid #f0f0f0;
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 3px 10px rgba(0,0,0,0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
}

.budget-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

.budget-card img {
  width: 100%;
  height: 190px;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.budget-card:hover img {
  transform: scale(1.05);
}

.card-content {
  padding: 20px;
}

.card-content h3 {
  color: var(--green);
  font-size: 1.2rem;
  margin-bottom: 10px;
}

.card-content p {
  color: #444;
  font-size: 0.95rem;
  line-height: 1.5;
}

/* --- BUTTON --- */
.next-btn {
  display: block;
  width: fit-content;
  margin: 40px auto 0;
  background: linear-gradient(90deg, var(--orange), var(--green));
  color: white;
  padding: 12px 30px;
  border-radius: 25px;
  text-decoration: none;
  font-weight: bold;
  transition: 0.3s;
}

.next-btn:hover {
  opacity: 0.9;
  transform: scale(1.05);
}

/* --- RESPONSIVE --- */
@media (max-width: 768px) {
  .stage-title {
    font-size: 1.6rem;
  }
  .card-content h3 {
    font-size: 1.1rem;
  }
}
</style>
</head>

<body>

<h1 class="stage-title">💰 Making Budget</h1>
<p class="stage-desc">A well-planned budget keeps your project realistic, organized, and financially secure from start to finish.</p>

<div class="stage-grid">

  <div class="budget-card">
    <img src="https://images.unsplash.com/photo-1565514020179-026b92b3ee61?auto=format&fit=crop&w=800&q=60" alt="Estimate Costs">
    <div class="card-content">
      <h3>Estimate Total Cost</h3>
      <p>Include land price, materials, labor, architect fees, and approvals. Add a 10–15% safety margin for unexpected expenses.</p>
    </div>
  </div>

  <div class="budget-card">
    <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=800&q=60" alt="Material Planning">
    <div class="card-content">
      <h3>Plan Material Expenses</h3>
      <p>Research material options — bricks, cement, tiles — and compare suppliers to balance cost and quality effectively.</p>
    </div>
  </div>

  <div class="budget-card">
    <img src="https://images.unsplash.com/photo-1581091870622-1e7f50b22d96?auto=format&fit=crop&w=800&q=60" alt="Labor and Workforce">
    <div class="card-content">
      <h3>Labor & Contractor Charges</h3>
      <p>Include contractor payment structure, daily wage labor, and overtime costs to maintain transparent project budgeting.</p>
    </div>
  </div>

  <div class="budget-card">
    <img src="https://images.unsplash.com/photo-1605733160314-4fc7fab6a3b3?auto=format&fit=crop&w=800&q=60" alt="Tracking Budget">
    <div class="card-content">
      <h3>Track & Adjust Regularly</h3>
      <p>Keep reviewing your budget after each stage. Adjust funds based on current expenses to stay within the financial limit.</p>
    </div>
  </div>

</div>

<a href="#" class="next-btn">Next Stage → Design & Planning</a>

</body>
</html>
