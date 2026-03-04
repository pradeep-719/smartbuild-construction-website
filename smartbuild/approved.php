<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Approval Stage — BuildSmart</title>

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

.section {
  max-width: 1000px;
  margin: 50px auto;
  padding: 20px;
}

.header {
  text-align: center;
  margin-bottom: 35px;
}

.header h2 {
  color: var(--orange);
  font-size: 2rem;
  margin-bottom: 8px;
}

.header p {
  color: #666;
  font-size: 1rem;
}

/* grid layout */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 25px;
}

/* each card */
.card {
  border: 1px solid #e5e5e5;
  border-top: 5px solid var(--green);
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 3px 10px rgba(0,0,0,0.06);
  transition: 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

/* icon */
.card img {
  width: 60px;
  height: 60px;
  object-fit: contain;
  margin-bottom: 12px;
  transition: 0.3s ease;
}

.card:hover img {
  transform: scale(1.1) rotate(3deg);
}

/* title + text */
.card h3 {
  color: var(--green);
  font-size: 1.1rem;
  margin-bottom: 8px;
}

.card p {
  color: #444;
  font-size: 0.93rem;
  line-height: 1.5;
}

/* next button */
.next-btn {
  display: block;
  width: fit-content;
  margin: 45px auto 0;
  background: linear-gradient(90deg, var(--orange), var(--green));
  color: #fff;
  padding: 12px 28px;
  border-radius: 25px;
  font-weight: 600;
  font-size: 0.95rem;
  text-decoration: none;
  transition: 0.3s ease;
}

.next-btn:hover {
  opacity: 0.9;
  transform: scale(1.05);
}

/* responsive */
@media (max-width:600px){
  .header h2{
    font-size:1.6rem;
  }
}
</style>
</head>

<body>
<section class="section">
  <div class="header">
    <h2>Approval Stage</h2>
    <p>Before breaking ground, secure all legal permissions and ensure your project meets regulations.</p>
  </div>

  <div class="grid">
    <div class="card">
      <img src="https://cdn-icons-png.flaticon.com/512/2767/2767006.png" alt="Documents">
      <h3>1. Prepare Documents</h3>
      <p>Collect land records, design blueprints, and safety certificates before submission.</p>
    </div>

    <div class="card">
      <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Submission">
      <h3>2. Submit Plans</h3>
      <p>Submit your designs to local authorities for building and layout approval.</p>
    </div>

    <div class="card">
      <img src="https://cdn-icons-png.flaticon.com/512/1048/1048953.png" alt="Inspection">
      <h3>3. Safety Inspection</h3>
      <p>Officials review your project for environmental and safety compliance.</p>
    </div>

    <div class="card">
      <img src="https://cdn-icons-png.flaticon.com/512/3159/3159310.png" alt="Permit">
      <h3>4. Building Permit</h3>
      <p>Once approved, you’ll receive the official permit to start construction.</p>
    </div>
  </div>

  <a href="construction.php" class="next-btn">Next Stage → Construction</a>
</section>
</body>
</html>
