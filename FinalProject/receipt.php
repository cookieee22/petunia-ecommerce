<?php
session_start();
require 'config.php';

$receipt_id = isset($_GET['receipt_id']) ? intval($_GET['receipt_id']) : 0;

if ($receipt_id <= 0) {
    die("Invalid receipt.");
}

// Get receipt info
$stmt = $db->prepare("SELECT RECEIPT_ID, ISSUED_AT, TOTAL_PAID FROM RECEIPT WHERE RECEIPT_ID = ?");
$stmt->bind_param("i", $receipt_id);
$stmt->execute();
$stmt->bind_result($receipt_id, $issued_at, $total_paid);
$stmt->fetch();
$stmt->close();

// Get receipt items
$query = "
    SELECT PRODUCT_NAME, PRICE, QUANTITY, SUBTOTAL
    FROM RECEIPT_ITEMS
    WHERE RECEIPT_ID = ?
";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $receipt_id);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt</title>
    <style>
        body { background-color: #e3bff2; font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .receipt-container { max-width: 700px; margin: 60px auto; background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        h1 { color: #28a745; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f0e0fa; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 20px; }
        .center { text-align: center; }
        .btn { padding: 10px 20px; background-color: #555; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px; display: inline-block; }
        .btn:hover { background-color: red; }
    </style>
</head>
<body>

<div class="receipt-container">
    <h1>Order Receipt</h1>
    <p><strong>Receipt #:</strong> <?php echo $receipt_id; ?></p>
    <p><strong>Order Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($issued_at)); ?></p>

    <table>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        <?php $hasItems = false; ?>
        <?php foreach ($cartItems as $item): ?>
            <?php $hasItems = true; ?>
            <tr>
                <td><?php echo htmlspecialchars($item['PRODUCT_NAME']); ?></td>
                <td><?php echo intval($item['QUANTITY']); ?></td>
                <td>$<?php echo number_format($item['PRICE'], 2); ?></td>
                <td>$<?php echo number_format($item['SUBTOTAL'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if (!$hasItems): ?>
        <p style="color: red; text-align: center; margin-top: 15px;">⚠️ No products found in receipt.</p>
    <?php endif; ?>

    <div class="total">Total Paid: $<?php echo number_format($total_paid, 2); ?></div>

    <div class="center">
        <a href="landing_page.php" class="btn">Back to Shop</a>
    </div>
</div>

</body>
</html>