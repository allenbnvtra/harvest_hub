<?php
include_once "./../config/dbCon.php";

$search_query = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $search_query = $_POST["search"];
}

$sql = "SELECT p.*, AVG(r.rating) AS avg_rating FROM products p LEFT JOIN Ratings r ON p.product_id = r.product_id";
if (!empty($search_query)) {
    $sql .= " WHERE p.product_name LIKE '%$search_query%'";
}
$sql .= " GROUP BY p.product_id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $image_url = "../admin/function/" . $row['image_url'];
        ?>
<a href="/project/client/pages/productDetails.php?product_id=<?php echo $row['product_id']; ?>" class="product-card">
    <div class="image_container">
        <!-- Use the constructed image URL -->
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
        <div class="ratings_container">
            <div class="ratings">
                <?php
                        $avg_rating = round($row['avg_rating']);
                        for ($i = 0; $i < 5; $i++) {
                            if ($i < $avg_rating) {
                                echo '<span class="filled-star">&#9733;</span>';
                            } else {
                                echo '<span class="empty-star">&#9733;</span>';
                            }
                        }
                        ?>
            </div>
            <h5>(<?php echo $avg_rating; ?>)</h5>
        </div>
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