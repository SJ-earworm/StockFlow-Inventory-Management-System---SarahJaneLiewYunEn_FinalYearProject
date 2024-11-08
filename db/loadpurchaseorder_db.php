<?php
    require("dbConnect.php");
    // require("app_config/session_handling.php");
    session_start();
    $userID = $_SESSION['userID'];

    // debugging
    if (!isset($userID)) {
        echo json_encode(["userID error: " => mysqli_error($con)]);
        exit;
    }

    header("Content-Type: application/json");

    // retrieving orderid
    $orderID = '';
    if (isset($_GET['orderID'])) {
        $orderID = $_GET['orderID'];
    }

    // Purchase_Order
    $query = "SELECT 
                v.name, 
                po.order_total,
                po.date_ordered,
                po.deadline
            FROM Purchase_Order po
            JOIN Vendor v ON po.vendorID = v.vendorID
            WHERE po.orderID = ?";
            // WHERE po.storeID = (SELECT storeID FROM User WHERE userID = ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();
    $mainDetails = $result->fetch_assoc();


    // Purchase_Order_Items
    $query = "SELECT 
                poi.newitemSKU, 
                p.prod_name,
                poi.quantity,
                poi.unit_price,
                poi.extended_price
            FROM Purchase_Order_Items poi
            JOIN Purchase_Order po ON poi.orderID = po.orderID
            JOIN Product p ON p.productID = poi.productID
            WHERE po.orderID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();
    $poItems = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            $poItems[] = $row;
        }
    } else {
        echo json_encode(["Error: " => mysqli_error($con)]);
        exit;
    }

    $response = [
        "po" => $mainDetails,
        "orderdetails" => $poItems
    ];

    echo json_encode($response);
?>