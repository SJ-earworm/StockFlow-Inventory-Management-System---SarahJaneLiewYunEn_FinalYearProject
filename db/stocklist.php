<?php
    require("db/dbConnect.php");
    require("app_config/session_handling.php");

    $query = "SELECT * FROM Product WHERE storeID = (SELECT storeID FROM User WHERE userID = ?)";  // selecting all the products 
                                                                                                   // saved into the store's profile
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="mng-stock-grid" style=" padding: 10px; height: 14px;">';
            echo '  <span class="grid-element">' . $row['SKU'] . '</span>';
            echo '  <span class="grid-element">' . $row['prod_name'] . '</span>';
            echo '  <span class="grid-element">' . $row['serial_no'] . '</span>';
            echo '  <span class="grid-element">' . $row['batch_no'] . '</span>';
            echo '  <span class="grid-element">' . $row['brand'] . '</span>';
            echo '  span class="grid-element">' . $row['prod_type'] . '</span>';
            echo '  <span class="grid-element">' . $row['unt_price'] . '</span>';
            echo '  <span class="grid-element">' . $row['quantity'] . '</span>';
            echo '  <span class="grid-element">Vendor</span>';    // this is for the vendor
            echo '</div>';

            echo '<hr class="list-divider">';
        }
    } else {
        echo "Couldn't fetch stock list";
    }
?>