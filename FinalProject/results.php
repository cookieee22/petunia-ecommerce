<?php
session_start(); // Start the session
require 'config.php';
include('header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $productId = (int)$_POST['product_id'];

    if ($_POST['action'] === 'update_name') {
        $newName = trim($_POST['new_name']);
        $stmt = $db->prepare("UPDATE PRODUCTS SET PRODUCT_NAME = ? WHERE PRODUCT_ID = ?");
        $stmt->bind_param("si", $newName, $productId);
        $stmt->execute();
        echo htmlspecialchars($newName);
        exit;
    }

    if ($_POST['action'] === 'update_inventory') {
        $direction = $_POST['direction'];
        $operator = ($direction === 'increment') ? '+' : '-';
        $stmt = $db->prepare("UPDATE PRODUCTS SET INVENTORY_COUNT = INVENTORY_COUNT $operator 1 WHERE PRODUCT_ID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        $stmt = $db->prepare("SELECT INVENTORY_COUNT FROM PRODUCTS WHERE PRODUCT_ID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->bind_result($newCount);
        $stmt->fetch();
        echo $newCount;
        exit;
    }
}

// Normal search logic
$searchtype = $_POST['searchtype'] ?? '';
$searchterm = trim($_POST['searchterm'] ?? '');

$allowed_fields = ['product_name', 'description'];
if (!$searchtype || !$searchterm || !in_array($searchtype, $allowed_fields)) {
    echo "Invalid search. Please go back and try again.";
    exit;
}

$query = "SELECT * FROM PRODUCTS WHERE $searchtype LIKE ?";
$stmt = $db->prepare($query);
$like_term = "%$searchterm%";
$stmt->bind_param("s", $like_term);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 1) {
    echo "<p>No results found for <strong>" . htmlspecialchars($searchterm, ENT_QUOTES, 'UTF-8') . "</strong>.</p>";
} else {
    while ($row = $result->fetch_assoc()):
?>
    <div class="product" id="product-<?= $row['PRODUCT_ID'] ?>">
      <p>
        <strong>Product:</strong>
        <span class="product-name"><?= htmlspecialchars($row['PRODUCT_NAME']) ?></span>
      </p>

      <input type="text" class="name-input" placeholder="New name" />
      <button onclick="updateName(<?= $row['PRODUCT_ID'] ?>)">Change Name</button>

      <p>
        <strong>Inventory:</strong>
        <span class="inventory-count"><?= (int)$row['INVENTORY_COUNT'] ?></span>
      </p>

      <button onclick="updateInventory(<?= $row['PRODUCT_ID'] ?>, 'increment')">+</button>
      <button onclick="updateInventory(<?= $row['PRODUCT_ID'] ?>, 'decrement')">−</button>
    </div>
<?php
    endwhile;
}
$db->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Petunia Product Search Results</title>
  <style>
    .product {
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 10px;
      max-width: 500px;
    }
    .product input {
      margin-top: 5px;
    }
    body {
      background-color: #e3bff2;
    }
  </style>
</head>
<body>

<script>
function updateName(productId) {
  const container = document.getElementById(`product-${productId}`);
  const input = container.querySelector('.name-input');
  const newName = input.value.trim();
  if (!newName) return;

  fetch('results.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'update_name',
      product_id: productId,
      new_name: newName
    })
  })
  .then(res => res.text())
  .then(updatedName => {
    container.querySelector('.product-name').textContent = updatedName;
    input.value = '';
  });
}

function updateInventory(productId, direction) {
  const container = document.getElementById(`product-${productId}`);

  fetch('results.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'update_inventory',
      product_id: productId,
      direction: direction
    })
  })
  .then(res => res.text())
  .then(updatedCount => {
    container.querySelector('.inventory-count').textContent = updatedCount;
  });
}
</script>

</body>
</html>


