<?php

require_once "../config/connection.php";

// SQL QUERY
$sql = "SELECT * FROM product";

// EXECUTE QUERY
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Product Table</title>

    <link rel="stylesheet" href="style2.css">

</head>

<body>

    <h1>Product List</h1>

    <table>

        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Price</th>
        </tr>

        <?php

        // CHECK DATA AVAILABLE
        if ($result->num_rows > 0) {

            // FETCH ROWS
            while ($row = $result->fetch_assoc()) {

                echo "<tr>";

                echo "<td>" . $row["p_id"] . "</td>";

                echo "<td>" . $row["p_name"] . "</td>";

                echo "<td>" . $row["price"] . "</td>";

                echo "</tr>";
            }
        } else {

            echo "<tr>";
            echo "<td colspan='3'>No Data Found</td>";
            echo "</tr>";
        }

        ?>

    </table>
    <hr>
    <h1>Add New Product</h1>
    <form action="add_product.php" method="post">
        <label for="p_name">Product Name:</label>
        <input type="text" id="p_name" name="p_name" required><br><br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required><br><br>
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <?php
            // SQL QUERY
            $sql1 = "SELECT * FROM category";
            $result = $conn->query($sql1);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["c_id"] . "'>" . $row["c_name"] . "</option>";
                }
            }
            ?>
        </select><br><br>
        <label for="qty">Quantity:</label>
        <input type="number" id="qty" name="qty" min="0" required><br><br>
        <button type="button" onclick="addProduct()">Add Product</button>
    </form>
        <script src="test_script.js"></script>

</body>

</html>