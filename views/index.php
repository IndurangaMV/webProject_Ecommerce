<?php
include "../config/session.php";
require_once "../config/connection.php";
// CHECK LOGIN

?>
<!DOCTYPE html>
<html>

<head>
    <title>Home - Gamma Electronics</title>
    <link rel="stylesheet" href="../assests/css/home.css">
</head>

<body>
    <?php include 'partials/header.php';
    ?>
    <div class="container">

        <div class="leftbar">
            <form>
                <label>Price</label>
                <div class="p-block" style="display:inline;">
                    <lable>from</lable>
                    <input type="number" name="min_price" placeholder="Min Price" />
                </div>
                <div class="p-block" style="display:inline;">
                    <lable>to</lable>
                    <input type="number" name="max_price" placeholder="Max Price" />
                </div>
                <input type="text" name="text" placeholder="Search products..." />
                <select name="category">
                    <option value="">All Categories</option>
                    <?php
                    $sql = "SELECT * FROM category";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <option value="<?php echo $row["c_id"]; ?>"><?php echo $row["c_name"]; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <label>Sort by price</label>
                <div style="display:inline;">
                    <input id="lh" type="radio" name="sort" value="asc" checked>
                    <label for="lh">Low to High</label>
                </div>
                <div style="display:inline;">
                    <input id="hl" type="radio" name="sort" value="desc">
                    <label for="hl">High to Low</label>
                </div>

                <button type="button" onclick="SearchProducts()">
                    Search
                </button>
            </form>
        </div>
        <div class="rightbar" id="product-container">
            <?php
            $sql = "SELECT * FROM category";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cat_id = $row["c_id"];
            ?>
                    <h3><?php echo $row["c_name"]; ?></h3>
                    <hr>
                    <?php
                    $sql2 = "SELECT * FROM product WHERE category=$cat_id";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                    ?>
                            <div class="product-card">
                                <h4><?php echo $row2["p_name"]; ?></h4>
                                <span>Rs. <?php echo $row2["price"]; ?></span><br>
                                <span style="color:yellowgreen"><?php echo $row2["qty"]; ?> items are available</span>
                            </div>
                    <?php
                        }
                    }
                    ?>

            <?php
                }
            }
            ?>
        </div>
    </div>

    <?php include 'partials/footer.php'; ?>
    <script src="../assests/js/home.js"></script>

</body>

</html>