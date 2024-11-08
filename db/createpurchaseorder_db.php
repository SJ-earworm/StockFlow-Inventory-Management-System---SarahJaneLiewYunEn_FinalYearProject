<?php
    // mysqli_report(mysqli_report_ALL);

    require("dbConnect.php");
    session_start();
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        header("Content-Type: application/json");

        // Retrieving userID
        $userID = $_SESSION['userID'];
        // echo "userID: " . $userID;

        $input = json_decode(file_get_contents("php://input"), true);  // retrieving raw POST data & decoding from json
        // error_log($input);


        // Retrieving user input data from newpurchaseorder.php
        $date_created = $input['datecreated'];
        $vendorID = $input['vendorID'];
        $deliverby = $input['deliverby'];
        $total_price = floatval($input['totalamount']);  // casting to decimal
        $tablerows = $input['allrows'];

        // filtering out empty rows in $tablerows
        $tablerowsWithData = array_filter($tablerows, function($row) {
            return !empty(array_filter($row));  // removing all empty values (everything in this scenario)
        });


        // plan: insert into the main Purchase_Order table first, retrive the id with insert_id, then continue the rest?
        
        $response = [];
        // inserting into Purchase_Order
        $query = "INSERT INTO Purchase_Order (vendorID, order_total, date_ordered, deadline, storeID) 
                    SELECT ?, ?, ?, ?, storeID FROM User WHERE userID = ?"; 
        $stmt = $con->prepare($query);
        $stmt->bind_param("idssi", $vendorID, $total_price, $date_created, $deliverby, $userID);
        if ($stmt->execute()) {
            $response['status1'] = 'success';
            $response['message1'] = 'Inserted to Purchase Order table';
        } else {
            $response['status1'] = 'fail';
            $response['message1'] = 'Failed to insert into Purchase Order table';
            $response['log1'] = mysqli_error($con);
        }
        $stmt->close();

        $insertedOrderID = $con->insert_id;  // retrieving the created orderID for this session
        

        // inserting into Purchase_Order_Items
        $query = "INSERT INTO Purchase_Order_Items (orderID, newitemSKU, quantity, unit_price, extended_price, productID) 
                    SELECT ?, ?, ?, ?, ?, productID FROM Product WHERE prod_name = ? AND SKU = ? AND brand = ?";
        
        $stmt = $con->prepare($query);

        foreach ($tablerowsWithData as $row) {
            $stmt->bind_param("isiddsss", $insertedOrderID, $row['itemcode'], $row['quantity'], $row['unitprice'], 
                            $row['extprice'], $row['prodname'], $row['itemcode'], $row['brandAsKey']);
            if ($stmt->execute()) {
                $response['status2'] = 'success';
                $response['message2'] = 'Inserted to Purchase_Order_Items table';
            } else {
                $response['status2'] = 'fail';
                $response['message2'] = 'Failed to insert into Purchase_Order_Items table';
                $response['log2'] = mysqli_error($con);
            }
        }
        $stmt->close();
        echo json_encode($response);
        exit;
    }

?>