<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

//Get SESSION_ID
$getSession = $db->prepare("SELECT SESSION_ID FROM USER WHERE USER_ID = ?");
$getSession->bind_param("i", $userId);
$getSession->execute();
$getSession->bind_result($sessionId);
$getSession->fetch();
$getSession->close();

if (!$sessionId) {
    die("Session ID not found for user.");
}

//Check if SESSION_ITEMS has products
$checkCart = $db->prepare("SELECT COUNT(*) FROM SESSION_ITEMS WHERE SESSION_ID = ?");
$checkCart->bind_param("i", $sessionId);
$checkCart->execute();
$checkCart->bind_result($cartCount);
$checkCart->fetch();
$checkCart->close();

if ($cartCount <= 0) {
    die("Your cart is empty. Please add items before placing an order.");
}

//Calculate total
$getTotal = $db->prepare("
    SELECT SUM(p.PRICE * si.QUANTITY)
    FROM SESSION_ITEMS si
    JOIN PRODUCTS p ON si.PRODUCT_ID = p.PRODUCT_ID
    WHERE si.SESSION_ID = ?
");
$getTotal->bind_param("i", $sessionId);
$getTotal->execute();
$getTotal->bind_result($cartTotal);
$getTotal->fetch();
$getTotal->close();

if ($cartTotal === null || $cartTotal <= 0) {
    die("Something went wrong calculating your cart total.");
}

//Insert into RECEIPT
$insertReceipt = $db->prepare("
    INSERT INTO RECEIPT (SESSION_ID, ISSUED_AT, TOTAL_PAID)
    VALUES (?, NOW(), ?)
");
$insertReceipt->bind_param("id", $sessionId, $cartTotal);
$insertReceipt->execute();
$receiptId = $insertReceipt->insert_id;
$insertReceipt->close();

//AUTO-CREATE RECEIPT_ITEMS TABLE IF NEEDED
$db->query("
    CREATE TABLE IF NOT EXISTS RECEIPT_ITEMS (
        RECEIPT_ITEM_ID INT AUTO_INCREMENT PRIMARY KEY,
        RECEIPT_ID INT,
        PRODUCT_NAME VARCHAR(255),
        PRICE DECIMAL(10,2),
        QUANTITY INT,
        SUBTOTAL DECIMAL(10,2)
    )
");

//Copy cart items to RECEIPT_ITEMS
$cartItems = $db->prepare("
    SELECT p.PRODUCT_NAME, p.PRICE, si.QUANTITY, (p.PRICE * si.QUANTITY) AS Total
    FROM SESSION_ITEMS si
    JOIN PRODUCTS p ON si.PRODUCT_ID = p.PRODUCT_ID
    WHERE si.SESSION_ID = ?
");
$cartItems->bind_param("i", $sessionId);
$cartItems->execute();
$itemsResult = $cartItems->get_result();

while ($item = $itemsResult->fetch_assoc()) {
    $insertItem = $db->prepare("
        INSERT INTO RECEIPT_ITEMS (RECEIPT_ID, PRODUCT_NAME, PRICE, QUANTITY, SUBTOTAL)
        VALUES (?, ?, ?, ?, ?)
    ");
    $insertItem->bind_param(
        "isdid",
        $receiptId,
        $item['PRODUCT_NAME'],
        $item['PRICE'],
        $item['QUANTITY'],
        $item['Total']
    );
    $insertItem->execute();
}
$cartItems->close();

// Clear cart
$clearCart = $db->prepare("DELETE FROM SESSION_ITEMS WHERE SESSION_ID = ?");
$clearCart->bind_param("i", $sessionId);
$clearCart->execute();
$clearCart->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation - Petunia Online Shop</title>
    <style>
        body {
            background-color: #e3bff2;
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
        }
        .header {
            background-color: #333;
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }
        .header a {
            color: #fff; text-decoration: none;
            margin-right: 15px; padding: 8px 10px;
            background-color: #555;
            border-radius: 4px;
        }
        .header a:hover { background-color: red; }
        .confirmation-container {
            background-color: white;
            max-width: 600px;
            margin: 80px auto;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 { color: #28a745; }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #555;
            color: #fff; text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .btn:hover { background-color: red; }
    </style>
</head>
<body>

<div class="header">
    <a href="landing_page.php">Home</a>
    <a href="aboutPetunia.php">About</a>
    <a href="cart.php">View Cart</a>
</div>

<div class="confirmation-container">
    <h1>Thank You for Your Order!</h1>
    <p>Your order has been successfully placed.</p>
    <p>Total charged: <strong>$<?php echo number_format($cartTotal, 2); ?></strong></p>
    <a href="landing_page.php" class="btn">Continue Shopping</a>
    <a href="receipt.php?receipt_id=<?php echo $receiptId; ?>" class="btn">View Receipt</a>
</div>

</body>
</html>