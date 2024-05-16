<?php
require_once './../config/dbCon.php';

$minPrice = $_POST['minPrice'];
$maxPrice = $_POST['maxPrice'];
$shippedFrom = $_POST['shippedFrom'];

$query = "SELECT * FROM products WHERE 1=1";

if (!empty($minPrice)) {
    $query .= " AND price >= '$minPrice'";
}

if (!empty($maxPrice)) {
    $query .= " AND price <= '$maxPrice'";
}

if (!empty($shippedFrom)) {
    $shippedFromStr = implode("','", $shippedFrom);
    $query .= " AND shipped_from IN ('$shippedFromStr')";
}

$result = mysqli_query($conn, $query);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);
?>