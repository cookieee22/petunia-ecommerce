<?php
// Include the header and database connection
include('header.php');
include('config.php');

// Handle search request
$search_results = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch data from form
    $search_type = $_POST['searchtype'];
    $search_term = $_POST['searchterm'];
    
    // Prepare query based on search type
    if ($search_type == 'product_name') {
        $query = "SELECT * FROM products WHERE product_name LIKE ?";
    } elseif ($search_type == 'description') {
        $query = "SELECT * FROM products WHERE description LIKE ?";
    } else {
        $query = "SELECT * FROM products"; // Default: show all products
    }
    
    // Prepare and execute the query
    if ($stmt = $db->prepare($query)) {
        $like_search_term = "%" . $search_term . "%";
        $stmt->bind_param("s", $like_search_term);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch results
        if ($result->num_rows > 0) {
            $search_results = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $search_results = [];
        }
        
        $stmt->close();
    }
}
?>

<html>
<head>
  <title>Product Catalog Search</title>
  <style>
    body {
        background-color: #e3bff2;
    }
  </style>
</head>
<body>

<h1>Product Catalog Search</h1>

<?php include('header.php'); ?>

<!-- Display the button for showing all products -->
<form action="results.php" method="post">
   <!--  <input type="submit" name="show_all" value="Show All Products">--> 
   <!-- this is broken--> 
</form>
<!-- Display the search form -->
<form action="results.php" method="post">
    Choose Search Type:<br />
    <select name="searchtype">
      <option value="product_name">Product Name</option>
      <option value="description">Description</option>
    </select>
    <br /><br />
    
    Enter Search Term:<br />
    <input name="searchterm" type="text" size="40">
    <br /><br />
    
    <input type="submit" name="submit" value="Search">
</form>

<!-- Display search results -->
<?php if ($search_results !== null): ?>
    <h3>Search Results:</h3>
    <?php if (count($search_results) > 0): ?>
        <ul>
            <?php foreach ($search_results as $product): ?>
                <li>
                    <strong><?php echo htmlspecialchars($product['product_name']); ?></strong><br>
                    <em><?php echo htmlspecialchars($product['description']); ?></em><br>
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" width="100"><br>
                    Price: $<?php echo htmlspecialchars($product['price']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No results found for your search.</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
