<?php
session_start();
require 'config.php'; 

$category_filter = "";
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $search = $db->real_escape_string($_GET['category']);
    $category_filter = "WHERE CATEGORY LIKE '%$search%' OR PRODUCT_NAME LIKE '%$search%' OR DESCRIPTION LIKE '%$search%'";
}

$sql = "SELECT PRODUCT_ID, PRODUCT_NAME, CATEGORY, DESCRIPTION, PRICE, IMAGES FROM PRODUCTS $category_filter";
$result = $db->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Petunia Online Shop</title>
  <style>
    body {
      background-color: #e3bff2; /* pink background */
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    /* Header styling */
    .header {
      background-color: #333;
      color: #fff;
      padding: 10px 20px;
      display: flex;
      align-items: center;
    }
    .header a {
      color: #fff;
      text-decoration: none;
      margin-right: 15px;
      padding: 8px 10px;
      background-color: #555;
      border-radius: 4px;
    }
    .header a:hover {
      background-color: red;
    }
    .title-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
    }
    .title-container h1 {
      margin: 0;
    }
    .action-buttons {
      display: flex;
      align-items: center;
    }
    .action-buttons form {
      margin: 0 10px 0 0;
    }
    .action-buttons input[type="text"] {
      padding: 6px;
      border: none;
      border-radius: 4px;
      margin-right: 5px;
    }
    .btn {
      padding: 6px 10px;
      border: none;
      border-radius: 4px;
      background-color: #555;
      color: #fff;
      cursor: pointer;
    }
    .btn:hover {
      background-color: red;
    }
    /* Category dropdown styling */
    .dropdown {
      position: relative;
      display: inline-block;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #fff;
      min-width: 150px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      border-radius: 4px;
      z-index: 1;
    }
    .dropdown-content a {
      color: #333;
      padding: 10px 12px;
      text-decoration: none;
      display: block;
    }
    .dropdown-content a:hover {
      background-color: #e3bff2; 
    }
    .dropdown:hover .dropdown-content {
      display: block;
    }
    .products {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin: 20px auto;
    }
    .product-card {
      background-color: #e3bff2;
      padding: 10px;
      margin: 10px;
      width: 200px;
      text-align: center;
    }
    .product-card img {
      width: 150px;
      border: 1px solid #ccc;
      margin-bottom: 5px;
    }
    .loginPrompt {
      background: #f8f8f8;
      padding: 5px;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <div class="header">
      <a href="landing_page.php">Home</a>
      <a href="aboutPetunia.php">About</a>
      <a href="cart.php">View Cart</a>
  </div>
  
  <div class="title-container">
      <h1>Petunia's Online Shop</h1>
      <div class="action-buttons">
        <!-- Search Form -->
        <form action="display_pictures.php" method="get">
          <input type="text" name="category" placeholder="Search by category, name, or description" 
            value="<?php echo isset($_GET['category']) ? htmlspecialchars($_GET['category']) : ''; ?>">
          <input type="submit" class="btn" value="Search">
        </form>
        <div class="dropdown">
          <button class="btn">Categories</button>
          <div class="dropdown-content">
            <a href="display_pictures.php">All</a>
            <a href="display_pictures.php?category=Shirts">Shirts</a>
            <a href="display_pictures.php?category=Hats">Hats</a>
            <a href="display_pictures.php?category=Beanies">Beanies</a>
            <a href="display_pictures.php?category=Blankets">Blankets</a>
            <a href="display_pictures.php?category=Seeds/Flowers">Misc</a>
          </div>
        </div>
      </div>
  </div>
  
  <div class="products">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $img   = "Images/" . htmlspecialchars($row["IMAGES"]);
            $name  = htmlspecialchars($row["PRODUCT_NAME"]);
            $cat   = htmlspecialchars($row["CATEGORY"]);
            $desc  = htmlspecialchars($row["DESCRIPTION"]);
            $price = number_format($row["PRICE"], 2);
            $id    = intval($row["PRODUCT_ID"]);

            echo '<div class="product-card">';
              echo "<img src=\"$img\" alt=\"$name\" /><br/>";
              echo "<strong>$name</strong><br/>";
              echo "<span style='font-size: small; color: #555;'>Category: $cat</span><br/>";
              echo "<em>$desc</em><br/>";
              echo "<span>\$$price</span><br/><br/>";

              if (isset($_SESSION['user_id'])) {
                  echo "<form method='POST' action='add_to_cart.php'>";
                  echo "<input type='hidden' name='PRODUCT_ID' value='$id'>";
                  echo "Qty: <input type='number' name='quantity' min='1' value='1' style='width:50px;' required><br/><br/>";
                  echo "<input type='submit' value='Add to Cart' class='btn'>";
                  echo "</form>";
              } else {
                  echo "<div class='loginPrompt'><a href='login.php'>Login to buy</a></div>";
              }
            echo '</div>';
        }
    } else {
        echo "<p>No products found.</p>";
    }
    $db->close();
    ?>
  </div>
</body>
</html>