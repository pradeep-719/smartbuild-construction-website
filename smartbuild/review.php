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

// Agar order id session me hai tabhi details dikhayenge
if (!isset($_SESSION['last_order_id'])) {
    die("No recent order found.");
}

$order_id = $_SESSION['last_order_id'];

// Order details fetch
$stmt = $conn->prepare("SELECT o.id, o.payment_method, o.total_amount, o.created_at, a.name, a.phone, a.address, a.city, a.state, a.zip 
    FROM orders o 
    JOIN addressbook a ON o.address_id = a.id 
    WHERE o.id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();
$stmt->close();

// Order items fetch
$stmt = $conn->prepare("SELECT product_name, quantity, price FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$itemsResult = $stmt->get_result();
$items = $itemsResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Review</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .container { max-width: 700px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        h2 { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        .total { font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <h2>✅ Order Placed Successfully</h2>
        <p><b>Order ID:</b> #<?php echo $order['id']; ?></p>
        <p><b>Name:</b> <?php echo $order['name']; ?></p>
        <p><b>Phone:</b> <?php echo $order['phone']; ?></p>
        <p><b>Address:</b> <?php echo $order['address'] . ", " . $order['city'] . ", " . $order['state'] . " - " . $order['zip']; ?></p>
        <p><b>Payment Method:</b> <?php echo $order['payment_method']; ?></p>
        <p><b>Date:</b> <?php echo $order['created_at']; ?></p>

        <h3>🛒 Order Items</h3>
        <table>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price (₹)</th>
            </tr>
            <?php foreach($items as $item): ?>
            <tr>
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['price'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2" class="total">Total Amount</td>
                <td><b>₹<?php echo number_format($order['total_amount'], 2); ?></b></td>
            </tr>
        </table>
  <form action="invoice.php" method="POST">
            <button type="submit" class="btn">Place Order</button>
        </form>
    </div>
</body>
</html>