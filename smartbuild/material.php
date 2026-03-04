<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "usersss");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SmartBuild | Materials</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="material.css" />

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background:  #f0f2f5;
      margin: 0;
      padding: 0;
    }

    /* Navbar */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
        background-color:#fff;
      padding: 10px 30px;
      color:black;
      font-weight: bold;
    }
    .navbar img {
      width: 40px;
      margin-right: 10px;
      border-radius: 50%;
    }
    .navbar .logo {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #fff;
      font-size: 22px;
    }
    .nav-links a {
      color: #fff;
      text-decoration: none;
      margin: 0 12px;
      font-weight: 500;
    }
    .nav-links a:hover {
      text-decoration: underline;
    }
    .search {
      width: 260px;
      padding: 6px 10px;
      border: 2px solid #ffb347;
      border-radius: 20px;
      outline: none;
    }

    /* Container */
    .container {
      display: flex;
      margin-top: 20px;
      padding: 20px;
      gap: 25px;
    }

    /* Filters */
    .filters {
      flex: 1;
      background: #fff;
      border: 1px solid #ffd9b3;
      border-radius: 12px;
      padding: 15px;
      max-width: 230px;
      height: fit-content;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .filters h3, .filters h4 {
      color: #ff9100;
    }

    /* Product Section */
    .product-section {
      flex: 4;
    }
    .sort-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #fff;
      padding: 10px 20px;
      border-radius: 12px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    /* Product Grid */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
    }
    .product-card {
      background: #fff;
      border: 1px solid #ffd9b3;
      border-radius: 12px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: 0.3s ease;
    }
    .product-card:hover {
      transform: scale(1.03);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .product-card img {
      width: 100%;
      height: 150px;
      object-fit: contain;
      border-radius: 10px;
      margin-bottom: 10px;
    }
    .product-card h4 {
      color: #333;
      margin-bottom: 5px;
    }
    .product-card p {
      color: #666;
      font-size: 14px;
      margin: 3px 0;
    }
    .product-card button {
      margin-top: 10px;
      background: #ff9100;
      color: white;
      border: none;
      padding: 7px 15px;
      border-radius: 20px;
      cursor: pointer;
      transition: 0.2s;
    }
    .product-card button:hover {
      background: #e67e00;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <a href="#" class="logo">
      <img src="https://thumbs2.imgbox.com/26/2d/fxicueNg_t.jpg" alt="">
      SmartBuild
    </a>

    <select class="location">
      <option>Mumbai</option>
      <option>Pune</option>
      <option>Delhi</option>
    </select>

    <input type="text" placeholder="Search for materials..." class="search" id="searchBox"/>

    <div class="nav-links">
      <a href="#">Home</a>
      <a href="#">Material</a>
      <a href="#">🛒 Cart (<span id="cartCount">0</span>)</a>
      <a href="#">Login</a>
    </div>
  </div>

  <!-- Main -->
  <div class="container">
    <!-- Filters -->
    <div class="filters">
      <h3>Filter</h3>
      <input type="text" placeholder="Search brands..." id="brandSearchInput" />
      <div id="brandCheckboxes">
        <label><input type="checkbox" class="brand-filter" value="Ajooba" checked> Ajooba</label><br>
        <label><input type="checkbox" class="brand-filter" value="Magic" checked> Magic</label><br>
        <label><input type="checkbox" class="brand-filter" value="Asian" checked> Asian</label><br>
        <label><input type="checkbox" class="brand-filter" value="Dulux" checked> Dulux</label><br>
      </div>

      <h4>Price Range</h4>
      ₹<span id="minPrice">0</span> - ₹<span id="maxPrice">1000</span><br>
      <input type="range" id="priceRange" min="0" max="10000" value="10000" />

      <h4>Customer Rating</h4>
      <label><input type="radio" name="rating" class="rating-filter" value="0" checked> All Ratings</label><br>
      <label><input type="radio" name="rating" class="rating-filter" value="3"> 3★ & above</label><br>
      <label><input type="radio" name="rating" class="rating-filter" value="4"> 4★ & above</label><br>
      <label><input type="radio" name="rating" class="rating-filter" value="5"> 5★ only</label>
    </div>

    <!-- Product Section -->
    <div class="product-section">
      <div class="sort-options">
        <h3>Paint Products</h3>
        <div>
          Sort By:
          <select id="sort-select">
            <option value="default">Relevance</option>
            <option value="low">Price — Low to High</option>
            <option value="high">Price — High to Low</option>
          </select>
        </div>
      </div>

      <div class="product-grid" id="product-grid">
        <!-- JS will load products here -->
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="material.js"></script>
</body>
</html>
