<?php
    require("dbConnect.php");

    // go into db, retrieve vendors
    $query = "SELECT v.name, v.vendorID
        FROM Vendor_Store_Link vpl
        JOIN Vendor v ON vpl.vendorID = v.vendorID
        JOIN Store s ON vpl.storeID = s.storeID
        WHERE vpl.storeID IN (
            SELECT storeID
            FROM User
            WHERE userID = ?
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
            if ($vendorID !== '' || $vendorID !== null) {
                if ($row['vendorID'] === $vendorID)
                    $selected = 'selected';
            }

            echo '<option value="' . $row['vendorID'] . '"' . $selected . '>'. $row['name'] .'</option>';
        }
    } else {
        echo 'No vendors found.';
    }

    // close db connection
    $stmt->close();
?>