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


    // populating dropdown with vendor names pulled from db
    if (mysqli_num_rows($result) > 0) {
        while($row = $result->fetch_assoc()) {
            // only for edititem_admin.php
            $selected = '';
            if ($categoryID !== '' || $categoryID !== null) {
                if ($row['categoryID'] === $categoryID)
                    $selected = 'selected';
            }

            echo '<option value="' . $row['categoryID'] . '"' . $selected . '>'. $row['category'] .'</option>';
        }
    } else {
        echo '<option>-</option>';
    }

    // close db connection
    $stmt->close();
?>