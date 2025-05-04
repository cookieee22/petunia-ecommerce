<?php
// config.php
$db = new mysqli('localhost', 'benavip1_finalproj', 'finalproj123', 'benavip1_Petunia');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>