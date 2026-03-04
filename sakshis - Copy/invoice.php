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

// Check if a recent order ID exists in the session.
if (!isset($_SESSION['last_order_id'])) {
    die("❌ No recent order found. Please place an order first.");
}

$order_id = $_SESSION['last_order_id'];

// ================== FETCH ORDER + ADDRESS ==================
$stmt = $conn->prepare("SELECT o.id, o.payment_method, o.total_amount, 
    o.created_at, o.shipping_date, 
    a.name, a.phone, a.address, a.city, a.state, a.zip 
    FROM orders o 
    JOIN addressbook a ON o.address_id = a.id 
    WHERE o.id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();
$stmt->close();

// Agar order null aaya toh error show karo
if (!$order) {
    die("❌ Order not found in database for ID: " . $order_id);
}

// ================== FETCH ORDER ITEMS ==================
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
    <title>Order Invoice</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background: #f4f4f4; padding: 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { max-width: 800px; width: 100%; margin: auto; background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #28a745; margin-bottom: 20px; font-weight: 700; }
        .order-info p { margin: 5px 0; font-size: 16px; }
        .order-info p b { color: #555; width: 160px; display: inline-block; }
        h3 { margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #e9ecef; padding-bottom: 10px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #dee2e6; }
        th, td { padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; color: #495057; }
        .total { font-weight: bold; text-align: right; background-color: #e9f5e9; }
        .buttons-container { text-align: center; margin-top: 30px; }
        .btn { display: inline-block; padding: 12px 25px; margin: 0 10px; text-decoration: none; background-color: #007bff; color: white; border-radius: 5px; font-weight: bold; transition: background-color 0.3s ease; cursor: pointer; border: none; }
        .btn:hover { background-color: #0056b3; }
        .btn.print { background-color: #28a745; }
        .btn.print:hover { background-color: #218838; }
        @media print { body { background: #fff; } .container { box-shadow: none; border: none; } .buttons-container { display: none; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>✅ Order Placed Successfully</h2>
        <div class="order-info">
            <p><b>Order ID:</b> #<?php echo $order['id']; ?></p>
            <p><b>Name:</b> <?php echo htmlspecialchars($order['name']); ?></p>
            <p><b>Phone:</b> <?php echo htmlspecialchars($order['phone']); ?></p>
            <p><b>Address:</b> <?php echo htmlspecialchars($order['address'] . ", " . $order['city'] . ", " . $order['state'] . " - " . $order['zip']); ?></p>
            <p><b>Payment Method:</b> <?php echo htmlspecialchars($order['payment_method']); ?></p>
            <p><b>Order Date:</b> <?php echo htmlspecialchars($order['created_at']); ?></p> 
            <p><b>Shipping Date:</b> <?php echo $order['shipping_date'] ?? 'Not yet shipped'; ?></p>
        </div>

        <h3>🛒 Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($items) > 0): ?>
                    <?php foreach($items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo number_format($item['price'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" style="text-align:center; color:red;">⚠️ No items found for this order</td></tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2" class="total">Total Amount</td>
                    <td><b>₹<?php echo number_format($order['total_amount'], 2); ?></b></td>
                </tr>
            </tbody>
        </table>

        <div class="buttons-container">
            <button onclick="window.print()" class="btn print">Print This Receipt</button>
             <button class="btn print">Submit</button>
            <a href="cart.html" class="btn">Go Back</a>
         
        </div>
    </div>
</body>
</html>