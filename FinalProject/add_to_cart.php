<?php
session_start();
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve product id and quantity from the form
    $product_id = intval($_POST['PRODUCT_ID']);
    $quantity   = intval($_POST['quantity']);
    if ($quantity < 1) {
        $quantity = 1;
    }
    
    // Get the user's SESSION_ID (the order id) from the USER table
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT SESSION_ID FROM USER WHERE USER_ID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($session_order_id);
    $stmt->fetch();
    $stmt->close();
    
    if (!$session_order_id) {
        
        die("No active order session found for this user.");
    }
    
    // Retrieve the product's unit price from the PRODUCTS table
    $stmt = $db->prepare("SELECT PRICE FROM PRODUCTS WHERE PRODUCT_ID = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();
    
    if (!$price) {
        die("Product not found.");
    }
    
    // Check if this product is already in the SESSION_ITEMS for this session
    $stmt = $db->prepare("SELECT QUANTITY FROM SESSION_ITEMS WHERE SESSION_ID = ? AND PRODUCT_ID = ?");
    $stmt->bind_param("ii", $session_order_id, $product_id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // If the product exists in the cart, update the quantity
        $stmt->bind_result($existing_quantity);
        $stmt->fetch();
        $new_quantity = $existing_quantity + $quantity;
        $stmt->close();
        
        $stmt_update = $db->prepare("UPDATE SESSION_ITEMS SET QUANTITY = ? WHERE SESSION_ID = ? AND PRODUCT_ID = ?");
        $stmt_update->bind_param("iii", $new_quantity, $session_order_id, $product_id);
        $stmt_update->execute();
        $stmt_update->close();
    } else {
        $stmt->close();
        $stmt_insert = $db->prepare("INSERT INTO SESSION_ITEMS (PRODUCT_ID, SESSION_ID, QUANTITY, PRICE) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("iiid", $product_id, $session_order_id, $quantity, $price);
        $stmt_insert->execute();
        $stmt_insert->close();
    }
    
    // Redirect back to the referring page (so the cart page does not open automatically)
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: landing_page.php");
    }
    exit();
}
?>