<?php
    require("dbConnect.php");
    session_start();
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        // setting JSON header for sending status message to frontend
        // header("Content-Type: application/json");
        // debugging
        // echo json_encode(['status' => 'success', 'message' => 'message went through']);
        // exit;
        // array for carrying status & message
        $response = [];

        // Retrieving userID
        $userID = $_SESSION['userID'];
        // echo "userID: " . $userID;

        // Retrieving productID
        $productID = '';
        if (isset($_GET['ID'])) {
            $productID = $_GET['ID'];
        }

        // Retrieving user input data from edititem.php form
        $p_name = $_REQUEST['productname'];
        $brand = $_REQUEST['brand'];
        $serial_no = $_REQUEST['serialno'];
        $sku = $_REQUEST['sku'];
        $u_price = $_REQUEST['unitprice'];
        $quantity = $_REQUEST['quantity'];  // new
        $vendorID = $_REQUEST['vendor'];  // new
        $p_typeID = $_REQUEST['prodtype'];  // new
        $intcasted_ptypeID = intval($p_typeID);  // converting dropdown value to integer (cos <select> values are returned as strings)
        $p_category = $_REQUEST['prodcat'] ?? '--';  // new
        $logs = $_REQUEST['itemeditlog'];

        // debugging
        echo 'categoryID: ' . $p_category . '<br/>';

        // retrieving user input
        // $input = json_decode(file_get_contents('php://input'), true);  // extracting the key-value pairs sent over via JSON
        // $p_name = $input['productname'];
        // $brand = $input['brand'];
        // $serial_no = $input['serialno'];
        // $sku = $input['sku'];
        // $u_price = $input['unitprice'];
        // $quantity = $input['quantity'];  // new
        // $vendorID = $input['vendor'];  // new
        // $p_type = $input['prodtype'];  // new
        // $p_category = $input['prodcat'];  // new
        // $logs = $input['itemeditlog'];

        if ($serial_no == '' || $serial_no == null) {
            $serial_no = '-';
        }

        // Updating Product row
        $query = "UPDATE Product SET prod_name = ?, brand = ?, serial_no = ?, SKU = ?, unit_price = ?, quantity = ?, storeID = (SELECT storeID FROM User WHERE userID = ?)
                    WHERE productID = ?";

        $stmt_product = $con->prepare($query);
        $stmt_product->bind_param("ssssdiii", $p_name, $brand, $serial_no, $sku, $u_price, $quantity, $userID, $productID);
        if ($stmt_product->execute()) {
            echo "Updated Product table <br/>";
            // $response['successStatus'] = 'success';

            // close db connection
            $stmt_product->close();
        } else {
            echo "Couldn't update product table." . mysqli_error($con) . '<br/>';
            die();
            // $response['failStatus'] = 'fail';
            // $response['error'] = mysqli_error($con);
        }


        // Updating vendor in Vendor_Product_Link table
        $query = "UPDATE Vendor_Product_Link SET vendorID = ? WHERE productID = ?";    // link productID to the INSERT

        $stmt_vendorprodlink = $con->prepare($query);
        $stmt_vendorprodlink->bind_param("ii", $vendorID, $productID);
        if ($stmt_vendorprodlink->execute()) {
            echo "Updated vendor in Vendor_Product_Link. <br/>";
            // $response['successStatus'] = 'success';
        } else {
            echo "Failed to update vendor" . mysqli_error($con) . '<br/>';
            die();
            // $response['failStatus'] = 'fail';
            // $response['error'] = mysqli_error($con);
        }


        // updating product type
        // if ($p_type !== '' && $p_type !== null) {
            $query = "UPDATE Product_Type_Link SET prodtypeID = ? WHERE productID = ?";

            $stmt_prodtype = $con->prepare($query);
            $stmt_prodtype->bind_param("ii", $intcasted_ptypeID, $productID);
            if ($stmt_prodtype->execute()) {
                echo "Product Type updated. <br/>";
                // $response['successStatus'] = 'success';
            } else {
                echo "Failed to update Product Type" . mysqli_error($con) . '<br/>';
                die();
                // $response['failStatus'] = 'fail';
                // $response['error'] = mysqli_error($con);
            }
        // }

        
        // inserting product category (if have)
        if ($p_category !== '--' && $p_category !== null) {
            $query = "UPDATE Product_Category_Link SET categoryID = ? WHERE productID = ?";

            $stmt_prodtype = $con->prepare($query);
            $stmt_prodtype->bind_param("ii", $p_category, $productID);
            if ($stmt_prodtype->execute()) {
                echo "Product Category updated. <br/>";
                // $response['successStatus'] = 'success';
            } else {
                echo "Failed to update Product Category" . mysqli_error($con) . '<br/>';
                die();
                // $response['failStatus'] = 'fail';
                // $response['error'] = mysqli_error($con);
            }
        }


        // Inserting into Activity Log table
        $query = "INSERT INTO Activity_Log (userID, action) VALUES (?,?)";

        $stmt_product = $con->prepare($query);
        $stmt_product->bind_param("is", $userID, $logs);
        if ($stmt_product->execute()) {
            echo "Inserted Activity Log. <br/>";
            // $response['successStatus'] = 'success';

            // close db connection
            $stmt_product->close();
            header("Location: ../managestocks.php");
            die();
        } else {
            echo "Couldn't insert activity log." . mysqli_error($con) . '<br/>';
            die();
            // $response['failStatus'] = 'fail';
            // $response['error'] = mysqli_error($con);
        }

        // sending success/fail status response to frontend
        // echo json_encode($response);
    }

?>