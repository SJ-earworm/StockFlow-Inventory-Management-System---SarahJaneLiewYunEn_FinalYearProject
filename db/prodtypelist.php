<?php
    require("dbConnect.php");

    // go into db, retrieve product types saved by specific store
    $query = "SELECT prodtypeID, prod_type FROM Product_Type 
        WHERE storeID = (
            SELECT storeID FROM User WHERE userID = ?
        )
        ORDER BY prod_type ASC";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();  // fetching query result


    // populating dropdown with vendor names pulled from db
    if (mysqli_num_rows($result) > 0) {
        while($row = $result->fetch_assoc()) {
            $selected = '';

            // addnewitem.php
            // if ($row['prod_type'] == '--') {
            //     $selected = 'selected';
            // }
            
            // only for edititem_admin.php
            if (isset($p_typename) && $p_typename !== '--' && $p_typeID !== null) {
                if ($row['prodtypeID'] === $p_typeID)
                    $selected = 'selected';
            } else {
                // for addnewitem.php
                if ($row['prod_type'] == '--') {
                    $selected = 'selected';
                }
            }

            echo '<option value="' . $row['prodtypeID'] . '" ' . $selected . '>'. $row['prod_type'] .'</option>';
        }
    } else {
        echo '<option>-</option>';
    }

    // close db connection
    $stmt->close();
?>