<?php 
session_start(); 
include('config.php');

// Ensure the $db object is valid
if ($db === null) {
    error_log("Database connection failed in config.php");
    die("Database connection failed.");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Petunia</title>
  <style>
    body { 
      font-family: Arial, sans-serif; 
      margin: 0;
      padding: 0;
    }
    
    .navbar {
      background-color: #333;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }
    .navbar-left, .navbar-right {
      display: flex;
      align-items: center;
    }
    .navbar a {
      display: block;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }
    .navbar a:hover {
      background-color: red;
    }
    /* Dropdown */
    .dropdown {
      position: relative;
      display: inline-block;
    }
    .dropdown .dropbtn {
      background-color: #333;
      border: none;
      font-size: 16px;
      color: #f2f2f2;
      padding: 14px 16px;
      font-family: inherit;
      margin: 0;
      cursor: pointer;
    }
    .dropdown:hover .dropbtn {
      background-color: red;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      text-align: left;
    }
    .dropdown-content a:hover {
      background-color: darkgoldenrod;
    }
    .dropdown:hover .dropdown-content {
      display: block;
    }
    body {
      padding-top: 50px;
    }
  </style>
</head>
<body>

<?php
$user_role = null;

// Check if the session is active and user_id is set
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Get the role of the logged-in user from the database
    if ($stmt = $db->prepare("SELECT ROLE_TYPE FROM USER WHERE USER_ID = ?")) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($role);

        // Fetch the role
        if ($stmt->fetch()) {
            $user_role = $role;
        } else {
            // Log or display an error if the role wasn't fetched
            error_log("Error: User role not found for user_id: $user_id");
        }
        $stmt->close();
    } else {
        // Log an error if the query preparation fails
        error_log("Error: Failed to prepare SQL statement.");
    }
} else {
    // Log or display an error if no user_id in session
    error_log("Error: No user_id found in session.");
}
?>

<div class="navbar">
  <div class="navbar-left">
    <a href="landing_page.php">Home</a>
    <a href="aboutPetunia.php">About</a>

    <?php
    // If the user is an employee no dropdown
    if ($user_role === 'Employee') {
        echo '<a href="search_generic.php">Product (Search)</button></a>';
    } else {
        // Shows the Products dropdown for non-employees
        echo '
        <div class="dropdown">
          <button class="dropbtn">
            Products 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="display_pictures.php">All</a>
            <a href="display_pictures.php?category=Shirts">Shirts</a>
            <a href="display_pictures.php?category=Hats">Hats</a>
            <a href="display_pictures.php?category=Beanies">Beanies</a>
            <a href="display_pictures.php?category=Blankets">Blankets</a>
            <a href="display_pictures.php?category=Seeds/Flowers">Misc</a>
          </div>
        </div>';
    }
    ?>

    <?php
    // Show cart for everyone except employees
    if ($user_role !== 'Employee') {
        echo '<a href="cart.php">Cart</a>';
    }

    // Show insert_product link only for employees
    if ($user_role === 'Employee') {
        echo '<a href="insert_product.php">Insert Product</a>';
    }
    ?>
  </div>

  <div class="navbar-right">
    <?php
      if (isset($_SESSION['user_id'])) {
          echo '<a href="logout.php">Log Out</a>';
      } else {
          echo '<a href="login.php">Log In</a>';
          echo '<a href="create_account.php">Create Account</a>';
      }
    ?>
  </div>
</div>


</body>
</html>
