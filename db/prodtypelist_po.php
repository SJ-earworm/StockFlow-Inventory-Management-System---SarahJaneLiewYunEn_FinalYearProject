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
            $count = 1;

            // skipping prodtype '--', not printing that out
            if ($row['prod_type'] === '--'){
                continue;  // cut the current loop & skip to next iteration
            }

            echo '<div style="margin-bottom: -7px; display: flex; align-items: center; background-color: transparent;">';
            echo '    <input type="checkbox" id="check' .$count. '" value="' .$row['prodtypeID']. '" style="margin-top: 10px" />';
            echo '    <label for="check' .$count. '" style="background-color: transparent;">' .$row['prod_type']. '</label>';
            echo '</div>';

            $count++;
        }
    } else {
        echo "Couldn't fetch products";
    }

    // close db connection
    $stmt->close();
?>