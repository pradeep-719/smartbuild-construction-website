<?php
// PHP code for form processing goes at the very top
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con = new mysqli("localhost", "root", "", "my_db");
    if ($con->connect_error) {
        die("DB Connection Error: " . $con->connect_error);
    }

    $name = $_POST['name'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $zip = $_POST['zip'] ?? '';
    $email = $_POST['email'] ?? '';
    $country = $_POST['country'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $stmt = $con->prepare("INSERT INTO addressbook (name, lname, address, city, state, zip, email, country, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $lname, $address, $city, $state, $zip, $email, $country, $phone);
  $_SESSION['address_id'] = $stmt->insert_id;  // 👈 yaha session me save karo
    if ($stmt->execute()) {
        $address_id = $con->insert_id;
        $address_data = [
            'id' => $address_id,
            'name' => $name,
            'lname' => $lname,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'email' => $email,
            'country' => $country,
            'phone' => $phone
        ];
        
        echo '<script>';
        echo 'localStorage.setItem("address_data", JSON.stringify(' . json_encode($address_data) . '));';
        echo 'window.location.href = "payment.php";';
        echo '</script>';
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Shipping Address</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .checkout-step { transition: all 0.3s ease; }
        .checkout-step.active { border-color: #4f46e5; }
        .checkout-step.completed { border-color: #10b981; }
        .form-input:focus { box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3); }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between">
                    <div class="checkout-step flex flex-col items-center w-1/3">
                        <div class="w-10 h-10 rounded-full border-2 border-indigo-600 bg-white flex items-center justify-center font-medium mb-2">1</div>
                        <span class="text-sm font-medium text-indigo-600">Shipping Address</span>
                    </div>
                    <div class="checkout-step flex flex-col items-center w-1/3">
                        <div class="w-10 h-10 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center font-medium mb-2">2</div>
                        <span class="text-sm font-medium text-gray-500">Payment</span>
                    </div>
                    <div class="checkout-step flex flex-col items-center w-1/3">
                        <div class="w-10 h-10 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center font-medium mb-2">3</div>
                        <span class="text-sm font-medium text-gray-500">Review</span>
                    </div>
                </div>
            </div>
            <div id="addressStep" class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Shipping Information</h2>
                <form id="addressForm" method="POST" action="">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" name="name" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input" required>
                        </div>
                        <div>
                            <label for="lname" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" name="lname" id="lname" class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                            <input type="text" name="address" id="address" class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input" required>
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" name="city" id="city" class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input" required>
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                            <input type="text" name="state" id="state" class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input" required>
                        </div>
                        <div>
                            <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">ZIP/Postal Code</label>
                            <input type="text" name="zip" id="zip" class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input" required>
                        </div>
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <select id="country" name="country" class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input" required>
                                <option value="">Select</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="UK">United Kingdom</option>
                                <option value="AU">Australia</option>
                            </select>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg form-input" required>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Continue to Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>