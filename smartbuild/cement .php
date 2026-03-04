<?php


// --- DATABASE CONNECTION ---
$conn = mysqli_connect("localhost", "root", "", "usersss");
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// --- FETCH ALL CEMENT PRODUCTS ---
$sql = "SELECT * FROM cement ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cement Products</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            background-color: #ffb300;
            color: white;
            padding: 20px 0;
            margin: 0;
        }
        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 40px;
        }
        .product-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
            transition: 0.3s;
        }
        .product-card:hover {
            transform: scale(1.03);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-info {
            padding: 15px;
        }
        .product-info h3 {
            margin: 10px 0;
            color: #333;
        }
        .product-info p {
            margin: 5px 0;
            color: #555;
        }
        .price {
            font-weight: bold;
            color: #ffb300;
        }
        .rating {
            color: #ffa41b;
        }
        .back-btn {
            display: block;
            margin: 0 auto 30px auto;
            text-align: center;
            background-color: #ffb300;
            color: white;
            border: none;
            padding: 10px 25px;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }
        .back-btn:hover {
            background-color: #ff9800;
        }
    </style>
</head>
<body>

    <h1>Cement Products</h1>
    <a href="addproduct.php" class="back-btn">➕ Add New Product</a>

    <div class="product-container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <div class="product-info">
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <p>Brand: <?= htmlspecialchars($row['brand']) ?></p>
                        <p class="price">₹<?= htmlspecialchars($row['price']) ?></p>
                        <p class="rating">⭐ <?= htmlspecialchars($row['rating']) ?>/5</p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; color:#777; font-size:18px;">No cement products available yet.</p>
        <?php endif; ?>
    </div>

</body>
</html>
