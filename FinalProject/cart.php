<?php
session_start();
require 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Get the user's SESSION_ID (order id) from the USER table
$stmt = $db->prepare("SELECT SESSION_ID FROM USER WHERE USER_ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($session_order_id);
$stmt->fetch();
$stmt->close();

if (!$session_order_id) {
    die("No active cart found.");
}

// Query to join SESSION_ITEMS with PRODUCTS for details.
$query = "
    SELECT p.PRODUCT_NAME, p.PRICE, si.QUANTITY, (p.PRICE * si.QUANTITY) AS Total, p.PRODUCT_ID
    FROM SESSION_ITEMS si
    JOIN PRODUCTS p ON si.PRODUCT_ID = p.PRODUCT_ID
    WHERE si.SESSION_ID = ?
";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $session_order_id);
$stmt->execute();
$result = $stmt->get_result();

// Computes the grand total
$cartItems = $result->fetch_all(MYSQLI_ASSOC);
$grand_total = 0;
foreach ($cartItems as $item) {
    $grand_total += $item['Total'];
}

// Update the SESSION table (TOTAL_AMOUNT) with the cart's total
$stmt_update = $db->prepare("UPDATE `SESSION` SET TOTAL_AMOUNT = ? WHERE SESSION_ID = ?");
$stmt_update->bind_param("di", $grand_total, $session_order_id);
$stmt_update->execute();
$stmt_update->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Your Cart - Petunia</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #eee; }
    form { margin: 0; }
    input[type="submit"] { padding: 4px 8px; }
    .order-btn {
      margin-top: 20px;
      text-align: right;
    }
    .order-btn input[type="submit"] {
      padding: 10px 20px;
      font-size: 16px;
      background-color: green;
      color: #fff;
      border: none;
      cursor: pointer;
    }
    .order-btn input[type="submit"]:hover {
      background-color: darkgreen;
    }
  </style>
</head>
<body>
  <h1>Your Cart</h1>
  <table>
    <tr>
      <th>Product Name</th>
      <th>Unit Price</th>
      <th>Quantity</th>
      <th>Total</th>
      <th>Action</th>
    </tr>
    <?php foreach ($cartItems as $row): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['PRODUCT_NAME']); ?></td>
        <td>$<?php echo number_format($row['PRICE'], 2); ?></td>
        <td><?php echo intval($row['QUANTITY']); ?></td>
        <td>$<?php echo number_format($row['Total'], 2); ?></td>
        <td>
          <!-- Remove Button Form -->
          <form method="POST" action="remove_from_cart.php">
            <input type="hidden" name="PRODUCT_ID" value="<?php echo intval($row['PRODUCT_ID']); ?>">
            <input type="submit" value="Remove">
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="3" style="text-align:right;"><strong>Grand Total:</strong></td>
      <td colspan="2"><strong>$<?php echo number_format($grand_total, 2); ?></strong></td>
    </tr>
  </table> 

  <!-- Order Button --> 
  <div class="order-btn">
    <form method="POST" action="order.php">
      <input type="submit" value="Place Order">
    </form>
  </div>
</body>
</html>