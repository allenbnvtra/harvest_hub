<?php
include_once "./../config/dbCon.php";

$searchQuery = isset($_POST["search"]) ? $_POST["search"] : '';
$minPrice = isset($_GET['min']) ? $_GET['min'] : '';
$maxPrice = isset($_GET['max']) ? $_GET['max'] : '';
$shippedFrom = isset($_GET['shipped']) ? $_GET['shipped'] : '';

$whereClause = '';

if (!empty($searchQuery)) {
    $whereClause .= " AND p.product_name LIKE '%$searchQuery%'";
}

if (!empty($minPrice) && !empty($maxPrice)) {
    $whereClause .= " AND p.price BETWEEN $minPrice AND $maxPrice";
} else if (!empty($minPrice)) {
    $whereClause .= " AND p.price >= $minPrice";
} else if (!empty($maxPrice)) {
    $whereClause .= " AND p.price <= $maxPrice";
}

if (!empty($shippedFrom)) {
    $whereClause .= " AND p.location LIKE '%$shippedFrom%'";
}

$sql = "SELECT p.* FROM products p WHERE 1=1 $whereClause GROUP BY p.product_id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $image_url = "../admin/function/" . $row['image_url'];
?>
<a href="/project/client/pages/productDetails.php?product_id=<?php echo $row['product_id']; ?>" class="product-card">
    <div class="image_container">
        <img src="<?php echo $image_url; ?>" alt="">
    </div>
    <div class="product_details">
        <h5 class="product_title"><?php echo $row['product_name']; ?></h5>
        <h5 class="product_price"><?php echo '₱' . $row['price']; ?></h5>
        <h5 style="font-size: 13px; color: #838383; margin-top: -10px; text-decoration: line-through;">
            ₱<?php echo $row['previous_price']; ?></h5>
        <h5 class="product_location">
            <span class="material-symbols-outlined">
                location_on
            </span>
            <?php echo $row['location']; ?>
        </h5>
    </div>
</a>
<?php
    }
} else {
    echo "No products found.";
}

mysqli_free_result($result);
mysqli_close($conn);
?>