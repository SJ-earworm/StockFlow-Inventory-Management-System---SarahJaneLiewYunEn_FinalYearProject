<?php
    // mysqli_report(mysqli_report_ALL);

    require("dbConnect.php");
    session_start();
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        // Retrieving userID
        $userID = $_SESSION['userID'];
        // echo "userID: " . $userID;

        // Retrieving user input data from edititem.php form
        $p_name = $_REQUEST['productname'];
        $brand = $_REQUEST['brand'];
        $serial_no = $_REQUEST['serialno'] ?? '--';
        $sku = $_REQUEST['sku'];
        $u_price = $_REQUEST['unitprice'];
        $quantity = $_REQUEST['quantity'];
        $vendorID = $_REQUEST['vendor'];
        $p_typeID = $_REQUEST['prodtype'];
        $intcasted_ptypeID = intval($p_typeID);  // converting dropdown value to integer (cos <select> values are returned as strings)
        $p_category = $_REQUEST['prodcat'] ?? '--';  // new
        $logs = $_REQUEST['itemeditlog'];

        // if ($serial_no == '' || $serial_no == null) {
        //     $serial_no = '-';
        // }

        // if ($p_type == '' || $p_type == null) {
        //     $p_type = '';
        // }

        // if ($p_category == '' || $p_category == null) {
        //     $p_category = '';
        // }

        // Inserting into Product table
        $query = "INSERT INTO Product (prod_name, brand, serial_no, SKU, unit_price, quantity, storeID) 
                    SELECT ?,?,?,?,?,?, storeID FROM User WHERE userID = ?";

        $stmt_product = $con->prepare($query);
        $stmt_product->bind_param("ssssdii", $p_name, $brand, $serial_no, $sku, $u_price, $quantity, $userID);
        if ($stmt_product->execute()) {
            echo "Inserted items into Product table <br/>";

            // close db connection
            $stmt_product->close();
        } else {
            echo "Couldn't insert prod_name, brand, serial_no, SKU & unit_price into Product table." . mysqli_error($con) . '<br/>';
            die();
        }

        // holding the inserted product's productID
        $insertedProductID = $con->insert_id;
        // note: insert_id is a command for retrieving the autoincremented id that was just created in the current session
        echo "the last inserted productID: " . $insertedProductID . "<br/>";


        // if (mysqli_query($con, $query)) {
        //     // test for now
        //     echo "successfully saved to Product db!";


        //     // javascript popup saying item successfully saved
        //     // header("Location: managestock.php");
        //     // die;
        // } else {
        //     echo "Error: " . mysqli_error($con);
        // }


        // inserting vendor & productID into Vendor_Product_Link table
        // $query = "INSERT INTO Vendor_Product_Link (vendorID, productID)
        //         SELECT ?, productID FROM Product WHERE prod_name = ?";    // link productID to the INSERT

        $query = "INSERT INTO Vendor_Product_Link (vendorID, productID) VALUES (?, ?)";

        $stmt_vendorprodlink = $con->prepare($query);
        $stmt_vendorprodlink->bind_param("ii", $vendorID, $insertedProductID);
        if ($stmt_vendorprodlink->execute()) {
            echo "Linked vendor to the product. <br/>";
        } else {
            echo "Failed to link vendor to the product" . mysqli_error($con) . '<br/>';
            die();
        }


        // inserting product type
        // if ($p_type !== '' && $p_type !== null) {
            // $query = "INSERT INTO Product_Type_Link (prodtypeID, productID, storeID) 
            //     SELECT 
            //         (SELECT prodtypeID FROM Product_Type WHERE prod_type = ?
            //             AND storeID IN (SELECT storeID FROM User WHERE userID = ?)) AS prodtypeID,
            //         (SELECT productID FROM Product WHERE prod_name = ?
            //             AND storeID IN (SELECT storeID FROM User WHERE userID = ?)) AS productID,
            //         (SELECT storeID FROM Store WHERE storeID IN (SELECT storeID FROM User WHERE userID = ?)) AS storeID";
                    // note: having multiple SELECT subqueries requires 'AS' to distinguish which query is for which column

            // debugging
            echo "prodtypeID chosen: " . $intcasted_ptypeID . "<br/>";

            $query = "INSERT INTO Product_Type_Link (prodtypeID, productID, storeID) 
            SELECT ?, ?, 
                (SELECT storeID FROM Store WHERE storeID IN (SELECT storeID FROM User WHERE userID = ?)) AS storeID";
                // note: having multiple SELECT subqueries requires 'AS' to distinguish which query is for which column

            $stmt_prodtype = $con->prepare($query);
            $stmt_prodtype->bind_param("iii", $intcasted_ptypeID, $insertedProductID, $userID);
            if ($stmt_prodtype->execute()) {
                echo "Product Type set. <br/>";
            } else {
                echo 'Else block entered. <br/>';
                $query = "SELECT prodtypeID FROM Product_Type WHERE prod_type = ?";
                $stmt_prodtype = $con->prepare($query);
                $stmt_prodtype->bind_param("s", $p_type);
                $stmt_prodtype->execute();
                $stmt_prodtype->bind_result($ptypeID_from_db);
                if ($stmt_prodtype->fetch()) {
                    echo "Product type entered: " . $p_type;
                    echo 'ProductID saved into db: ' . $ptypeID_from_db;
                }
                echo "Failed to set Product Type" . mysqli_error($con) . '<br/>';
                die();
            }
        // }

        
        // inserting product category (if have)
        // if ($p_category !== '--' && $p_category !== null) {
        //     $query = "INSERT INTO Product_Category_Link (categoryID, productID) 
        //         SELECT 
        //             (SELECT categoryID FROM Product_Category WHERE category = ?
        //                 AND storeID IN (SELECT storeID FROM User WHERE userID = ?)) AS categoryID,
        //             (SELECT productID FROM Product WHERE prod_name = ?
        //                 AND storeID IN (SELECT storeID FROM User WHERE userID = ?)) AS productID";

        //     $stmt_prodtype = $con->prepare($query);
        //     $stmt_prodtype->bind_param("sisi", $p_category, $userID, $p_name, $userID);
        //     if ($stmt_prodtype->execute()) {
        //         echo "Product Category set. <br/>";
        //     } else {
        //         echo "Failed to set Product Category" . mysqli_error($con) . '<br/>';
        //         die();
        //     }
        // }


        // Inserting into Activity Log table
        $query = "INSERT INTO Activity_Log (userID, action) VALUES (?,?)";

        $stmt_product = $con->prepare($query);
        $stmt_product->bind_param("is", $userID, $logs);
        if ($stmt_product->execute()) {
            echo "Inserted Activity Log. <br/>";

            // close db connection
            $stmt_product->close();
            header("Location: ../managestocks.php");
        } else {
            echo "Couldn't insert activity log." . mysqli_error($con) . '<br/>';
            die();
        }

        // if (mysqli_query($con, $query)) {
        //     // test for now
        //     echo "successfully saved to Activity Log db!";


        //     // javascript popup saying item successfully saved
        //     // header("Location: managestock.php");
        //     // die;
        // } else {
        //     echo "Error: " . mysqli_error($con);
        // }
    }

?>