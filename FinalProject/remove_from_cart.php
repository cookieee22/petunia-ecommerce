<?php
session_start();
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['PRODUCT_ID'])) {
    die("No product specified for removal.");
}

$product_id = intval($_POST['PRODUCT_ID']);
$user_id    = $_SESSION['user_id'];

// Get the user's SESSION_ID from the USER table
$stmt = $db->prepare("SELECT SESSION_ID FROM USER WHERE USER_ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($session_order_id);
$stmt->fetch();
$stmt->close();

if (!$session_order_id) {
    die("No active order session found.");
}

// Delete the product from SESSION_ITEMS for this session
$stmt_del = $db->prepare("DELETE FROM SESSION_ITEMS WHERE SESSION_ID = ? AND PRODUCT_ID = ?");
$stmt_del->bind_param("ii", $session_order_id, $product_id);
$stmt_del->execute();
$stmt_del->close();

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>