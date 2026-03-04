<?php
session_start();
$con = new mysqli("localhost", "root", "", "my_db");

if ($con->connect_error) {
    die("DB Connection Error: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Safe access (agar value nahi aayi toh default blank/zero set hoga)
    $payment_method = $_POST['payment_method'] ?? '';
    $total_amount   = $_POST['total_amount'] ?? 0;
    $cart_data      = $_POST['cart_data'] ?? '';

    // Address session me hona chahiye
    if (!isset($_SESSION['address_id'])) {
        die("Error: Address ID missing.");
    }
   $address_id = $_SESSION['address_id'] ?? 0;


    $shipping_date = date('Y-m-d', strtotime('+3 days'));
    $status = "Pending";

    // Cart data ko array me convert karo
    $cart_array = [];
    if ($cart_data) {
        $cart_array = json_decode($cart_data, true);
    }

    $con->begin_transaction();

    try {
        // Orders table me insert
        $stmt = $con->prepare("INSERT INTO orders (address_id, total_amount, payment_method, status, shipping_date) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idsss", $address_id, $total_amount, $payment_method, $status, $shipping_date);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Order_items table me insert
        if (!empty($cart_array)) {
            $stmt_items = $con->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) 
                                         VALUES (?, ?, ?, ?)");
            foreach ($cart_array as $item) {
                $stmt_items->bind_param("isid", $order_id, $item['name'], $item['quantity'], $item['price']);
                $stmt_items->execute();
            }
            $stmt_items->close();
        }

        $con->commit();

        // Local storage clear
        echo '<script>localStorage.removeItem("cart"); localStorage.removeItem("totalAmount");</script>';

        header("Location: invoice.php?order_id=" . $order_id);
        exit();
    } catch (Exception $e) {
        $con->rollback();
        die("Order Failed: " . $e->getMessage());
    }
}
?>
