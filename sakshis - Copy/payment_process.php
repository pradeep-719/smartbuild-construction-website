<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "my_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Form से data पकड़ना
$payment_method = $_POST['payment'] ?? 'COD';
$address_id = $_POST['address_id'] ?? null;
$total_amount = $_POST['total_amount'] ?? 0;
$cart_json = $_POST['cart_json'] ?? '[]';
$cart = json_decode($cart_json, true);

// अगर cart खाली है तो error
if (empty($cart)) {
    die("Cart is empty. <a href='cart.html'>Go back to cart</a>");
}

// Step 1: Insert into orders
$order_sql = "INSERT INTO orders (address_id, payment_method, total_amount, status) VALUES (?, ?, ?, 'Pending')";
$stmt = $conn->prepare($order_sql);
$stmt->bind_param("isd", $address_id, $payment_method, $total_amount);
$stmt->execute();
$order_id = $stmt->insert_id;

// Step 2: Insert each item into order_items
$item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt_item = $conn->prepare($item_sql);

foreach ($cart as $item) {
    $product_id = $item['id'];
    $quantity = $item['quantity'];
    $price = $item['price'];
    $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);
    $stmt_item->execute();
}

// Step 3: Save order id in session
$_SESSION['last_order_id'] = $order_id;

// Step 4: Redirect to review.php
header("Location: review.php");
exit;
