<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Design Stage — BuildSmart</title>
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
<section class="stage-wrapper">
  <div class="stage-header">
    <h1>🧱 Design Stage</h1>
    <p>Where your imagination takes shape — from blueprints to 3D models, bringing your dream home design to life.</p>
  </div>

  <div class="timeline">
    <div class="step-card">
      <div class="step-icon">1</div>
      <h3>Concept Planning</h3>
      <p>Begin by discussing your vision, lifestyle, and preferences with architects. This stage defines layout, room size, and overall aesthetics of your dream home.</p>
    </div>

    <div class="step-card">
      <div class="step-icon">2</div>
      <h3>Architectural Design</h3>
      <p>Architects prepare 2D layouts and elevations showing room distribution, window placements, and overall structure flow. These designs ensure space efficiency and comfort.</p>
    </div>

    <div class="step-card">
      <div class="step-icon">3</div>
      <h3>Structural Design</h3>
      <p>Structural engineers analyze load-bearing elements, columns, beams, and foundation plans to ensure your building is strong, safe, and compliant with construction codes.</p>
    </div>

    <div class="step-card">
      <div class="step-icon">4</div>
      <h3>3D Visualization</h3>
      <p>Visualize your project with realistic 3D renders and walkthroughs. This step helps you review materials, lighting, and space flow before construction begins.</p>
    </div>

    <div class="step-card">
      <div class="step-icon">5</div>
      <h3>Final Design Approval</h3>
      <p>After all revisions, finalize and approve your complete architectural and structural design package for submission and construction execution.</p>
    </div>
  </div>

  <a href="approved.php" class="next-btn">Next Stage → Approval Stage</a>
</section>
</body>
</html>
