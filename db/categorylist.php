<?php
    require("dbConnect.php");

    // go into db, retrieve product types saved by specific store
    $query = "SELECT categoryID, category FROM Product_Category 
        WHERE storeID = (
            SELECT storeID FROM User WHERE userID = ?
        )";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();  // fetching query result

    // if no category is set (for edititem.php), display '--' as disabled selected hidden
    if (isset($p_categoryID)) {
        if ($p_categoryID == '--' || $p_categoryID == null) {
            echo '<option value="" disabled selected hidden>--</option>';
        }
    }

    // populating dropdown with vendor names pulled from db
    if (mysqli_num_rows($result) > 0) {
        while($row = $result->fetch_assoc()) {
            // only for edititem_admin.php
            $selected = '';

            // for edititem.php
            if (isset($p_categoryID) && $row['categoryID'] == $p_categoryID) {
                $selected = 'selected';
            }

            echo '<option value="' . $row['categoryID'] . '" ' .$selected. '>'. $row['category'] .'</option>';
        }
    } else {
        echo '<option>-</option>';
    }

    // close db connection
    $stmt->close();
?>