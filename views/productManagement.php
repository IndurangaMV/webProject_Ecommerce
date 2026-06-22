<?php
//include "Partials/header.php";
include "../config/session.php";
require_once "../config/connection.php";

if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit;
}

/* =========================
   INPUTS
   ========================= */
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$category = isset($_GET['category']) ? $_GET['category'] : "";
$stock = isset($_GET['stock']) ? $_GET['stock'] : "";

/* =========================
   STATS
   ========================= */
$totalProducts = $conn->query("SELECT COUNT(*) AS total FROM product")
    ->fetch_assoc()['total'];

$totalCategories = $conn->query("SELECT COUNT(c_id) AS total FROM category")
    ->fetch_assoc()['total'];

// FIXED: Count both NULL and 0 as out of stock
$outOfStockCount = $conn->query("SELECT COUNT(*) AS total FROM product WHERE (qty = 0 OR qty IS NULL)")
    ->fetch_assoc()['total'];

/* =========================
   MAIN QUERY
   ========================= */
$sql = "SELECT product.*, category.c_name
        FROM product
        LEFT JOIN category
        ON product.category = category.c_id
        WHERE 1=1";

/* SEARCH */
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND LOWER(product.p_name) LIKE LOWER('$search%')";
}

/* CATEGORY FILTER */
if (!empty($category)) {
    $category = $conn->real_escape_string($category);
    $sql .= " AND product.category = '$category'";
}

/* STOCK FILTER */
if (!empty($stock)) {
    $stock = $conn->real_escape_string($stock);
    if ($stock === "outofstock") {
        // FIXED: Filters for both exactly 0 and NULL values
        $sql .= " AND (product.qty = 0 OR product.qty IS NULL)";
    }
    if ($stock === "instock") {
        $sql .= " AND product.qty > 0";
    }
}
$result = $conn->query($sql);

/* CATEGORY LIST */
$catList = $conn->query("SELECT * FROM category");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link rel="stylesheet" href="../assests/css/product.css">
</head>

<body>

<div class="container1">

    <h1>📦 Product Management</h1>

    <div class="stats">
        <div class="box">
            <p>Total Products</p>
            <h2><?php echo $totalProducts; ?></h2>
        </div>

        <div class="box">
            <p>Total Categories</p>
            <h2><?php echo $totalCategories; ?></h2>
        </div>

        <div class="box">
            <p>Out of Stock</p>
            <h2><?php echo $outOfStockCount; ?></h2>
        </div>
    </div>

    <div class="search-area">
        <form method="GET">
            <input type="text"
                   name="search"
                   placeholder="Search Product..."
                   value="<?php echo htmlspecialchars($search); ?>">

            <button type="submit">Search</button>

            <select name="category">
                <option value="">All Categories</option>
                <?php while ($cat = $catList->fetch_assoc()) { ?>
                    <option value="<?php echo $cat['c_id']; ?>"
                        <?php if ($category == $cat['c_id']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($cat['c_name']); ?>
                    </option>
                <?php } ?>
            </select>

            <select name="stock">
                <option value="">All Stock</option>
                <option value="instock" <?php if ($stock == "instock") echo "selected"; ?>>
                    In Stock
                </option>
                <option value="outofstock" <?php if ($stock == "outofstock") echo "selected"; ?>>
                    Out of Stock
                </option>
            </select>

            <button type="submit">Filter</button>

            <a href="productManagement.php">
                <button type="button">Reset</button>
            </a>
        </form>
    </div>

    <table class="table3">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Price (Rs.)</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['p_id']."</td>";
                echo "<td>".htmlspecialchars($row['p_name'])."</td>";
                echo "<td>".number_format($row['price'],2)."</td>";
                echo "<td>".htmlspecialchars($row['c_name'])."</td>";

                /* STOCK DISPLAY - FIXED to handle NULL values */
                echo "<td>";
                if ($row['qty'] == 0 || $row['qty'] === NULL) {
                    echo "<span style='color:red;font-weight:bold;'>Out of Stock</span>";
                } else {
                    echo $row['qty'];
                }
                echo "</td>";

                /* ACTIONS */
                echo "<td>
                        <button class='viewBtn' onclick='goToView(".$row['p_id'].")'>
                            View
                        </button>
                        <button class='deleteBtn' onclick='confirmDelete(".$row['p_id'].")'>
                            Delete
                        </button>
                      </td>";
               
            }
        } else {
            echo "<tr>
                    <td colspan='6' align='center'>
                        No products found
                    </td>
                  </tr>";
        }
        ?>
    </table>

</div>

<script>
function goToView(id){
    window.location.href = "viewProduct.php?id=" + id;
}

function confirmReject(id){
    if(confirm("Are you sure you want to delete this product?")){
        window.location.href = "deleteProduct.php?id=" + id;
    }
}
</script>

</body>
</html>