<?php
    // retrieving logged in username
    $query = "SELECT name, storeID FROM User WHERE userID = ?";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($username, $storeID);
    if ($stmt->fetch()) {
        $stmt->close();  // closing connection before making next query
    } else {
        echo "Could not fetch username: " . mysqli_error($con);
    }

    // retrieving list of vendors
    $query = "SELECT 
                vsl.vendorID, 
                v.name 
            FROM Vendor_Store_Link vsl
            JOIN Vendor v ON vsl.vendorID = v.vendorID
            WHERE storeID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $storeID);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            $vendors [] = [
                'vendorID' => $row['vendorID'],
                'vendorName' => $row['name']
            ];
        }
    }
    

    // retrieving existing products
    $query = "SELECT productID, prod_name, brand FROM Product WHERE storeID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $storeID);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            $products [] = [
                'productID' => $row['productID'],
                'prod_name' => $row['prod_name'],
                'brand' => $row['brand'],
            ];
        }
    }
    $stmt->close();  // closing connection before making next query
?>