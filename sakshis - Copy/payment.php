<?php
session_start();
$host = "localhost";
$user = "root"; 
$pass = ""; 
$dbname = "my_db";

$conn = new mysqli($host, $user, $pass, $dbname);

// Connection check
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Address ID
    $address_id = $_POST['address_id'] ?? null;

    // Payment method
    $payment_method = $_POST['payment'] ?? '';

    // Cart JSON
    $cartJson = $_POST['cart_json'] ?? '[]';
    $cart = json_decode($cartJson, true);

    // Total
    $totalAmount = $_POST['total_amount'] ?? 0;

    if ($address_id && $payment_method) {
        $conn->begin_transaction();

        try {
            // Insert order into the 'orders' table
            $stmt = $conn->prepare("INSERT INTO orders (address_id, payment_method, total_amount) VALUES (?, ?, ?)");
            $stmt->bind_param("isd", $address_id, $payment_method, $totalAmount);
            $stmt->execute();
            $order_id = $stmt->insert_id;
            $stmt->close();

            // Insert order items into the 'order_items' table (only if cart not empty)
            if (!empty($cart)) {
                $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
                foreach ($cart as $item) {
                    $name = $item['name'];
                    $qty  = $item['quantity'];
                    $price = $item['price'];
                    $stmt->bind_param("isid", $order_id, $name, $qty, $price);
                    $stmt->execute();
                }
                $stmt->close();
            }

            $conn->commit();

            // Save order id for review.php
            $_SESSION['last_order_id'] = $order_id;

            header("Location: review.php");
            exit;

        } catch (Exception $e) {
            $conn->rollback();
            die("Order failed: " . $e->getMessage());
        }
    } else {
        die("Missing order details.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .box {
            background: #fff;
            width: 420px;
            max-width: 90%;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }
        h2 {
            margin: 0 0 10px;
            font-size: 1.7rem;
            font-weight: 700;
            color: #333;
        }
        .muted {
            color: #757575;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }
        .row { margin: 15px 0; }
        button {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 10px;
            background: #4CAF50;
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>💳 Payment Method</h2>
        <p class="muted">Total payable: <b>₹<span id="total-amount-display">0.00</span></b></p>
        <form method="POST" action="payment.php" id="payForm">

            <div class="row"><label><input type="radio" name="payment" value="Card" required onchange="toggleCardFields()"> Credit/Debit Card</label></div>
            <div class="row"><label><input type="radio" name="payment" value="PayPal" onchange="toggleCardFields()"> PayPal</label></div>
            <div class="row"><label><input type="radio" name="payment" value="COD" onchange="toggleCardFields()"> Cash on Delivery</label></div>

            <div id="cardFields" style="display:none;">
                <div class="row"><input type="text" name="card_number" placeholder="Card Number (demo)"></div>
                <div class="row"><input type="text" name="expiry" placeholder="MM/YY"></div>
                <div class="row"><input type="password" name="cvv" placeholder="CVV"></div>
            </div>

            <input type="hidden" name="address_id" id="address_id_hidden" value="<?php echo $_SESSION['address_id'] ?? ''; ?>">
            <input type="hidden" name="cart_json" id="cart_json_hidden">
            <input type="hidden" name="total_amount" id="total_amount_hidden">

            <button type="submit">Continue to Review ➜</button>
        </form>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const totalAmountElement = document.getElementById('total-amount-display');
    const totalAmountHidden = document.getElementById('total_amount_hidden');
    const addressIdHidden = document.getElementById('address_id_hidden');
    const cartJsonHidden = document.getElementById('cart_json_hidden');

    // Get data from localStorage
    const addressData = JSON.parse(localStorage.getItem('address_data'));
    const cartData = JSON.parse(localStorage.getItem('cart')) || [];
    const calculatedAmount = localStorage.getItem('totalAmount');

    // Load address ID (fallback to session if localStorage empty)
    if (addressData && addressData.id) {
        addressIdHidden.value = addressData.id;
    }

    // Load cart data
    cartJsonHidden.value = JSON.stringify(cartData);

    // Load total amount
    if (calculatedAmount) {
        const cleanAmount = parseFloat(calculatedAmount);
        totalAmountElement.textContent = cleanAmount.toFixed(2);
        totalAmountHidden.value = cleanAmount.toFixed(2);
    } else {
        totalAmountElement.textContent = "0.00";
        totalAmountHidden.value = "0.00";
    }
});

// Card fields toggle
function toggleCardFields() {
    const cardFields = document.getElementById("cardFields");
    const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
    cardFields.style.display = (paymentMethod === "Card") ? "block" : "none";
}
</script>
</body>
</html>