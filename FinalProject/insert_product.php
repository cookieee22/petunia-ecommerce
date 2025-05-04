<?php
session_start(); // Start the session
require 'config.php';
include('header.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Petunia - Insert Product</title>
  <style>
    body {
      background-color: #e3bff2;
      font-family: Arial, sans-serif;
    }
  </style>
</head>
<body>
  <h1>Petunia - Insert Product</h1>
  <?php include('header.php'); ?>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $product_name = trim($_POST['product_name']);
    $description  = trim($_POST['description']);
    $quantity     = intval($_POST['quantity']);
    $price        = floatval($_POST['price']);

    if (!$product_name || $quantity < 0) {
      echo "<p style='color: red;'>Please enter a valid product name and ensure quantity is non-negative.</p>";
    } else {
      // Include the centralized database connection.
      require 'config.php';

      // INSERT query using the PRODUCTS table.
      $stmt = $db->prepare("INSERT INTO PRODUCTS (PRODUCT_NAME, DESCRIPTION, INVENTORY_COUNT, PRICE) VALUES (?, ?, ?, ?)");
      if (!$stmt) {
        echo "<p style='color: red;'>Prepare failed: " . $db->error . "</p>";
      } else {
        // Bind parameters (string, string, integer, double)
        $stmt->bind_param("ssid", $product_name, $description, $quantity, $price);
        if ($stmt->execute()) {
          echo "<p style='color: green;'><strong>$product_name</strong> has been added to the PRODUCTS table. Quantity: $quantity | Price: $" . number_format($price, 2) . "</p>";
        } else {
          echo "<p style='color: red;'>Error adding product: " . $stmt->error . "</p>";
        }
        $stmt->close();
      }
      $db->close();
    }
  }
  ?>

  <!-- Display the input form -->
  <form action="insert_product.php" method="post">
    <p>Product Name:<br> <input type="text" name="product_name" required></p>
    <p>Description:<br> <textarea name="description" rows="3" cols="40"></textarea></p>
    <p>Quantity:<br> <input type="number" name="quantity" min="0" required></p>
    <p>Price ($):<br> <input type="text" name="price" required></p>
    <p><input type="submit" value="Add Product"></p>
  </form>
</body>
</html>
