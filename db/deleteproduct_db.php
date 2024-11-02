<?php
    require("dbConnect.php");
    session_start();
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {

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
        if ($serial_no == '' || $serial_no == null) {
            $serial_no = '-';
        }

        // Updating Product row
        $query = "DELETE FROM Product WHERE prod_name = ?, brand = ?, serial_no = ?, SKU = ?, unit_price = ?, quantity = ?, storeID = (SELECT storeID FROM User WHERE userID = ?)
                    WHERE productID = ?";

        $stmt_product = $con->prepare($query);
        $stmt_product->bind_param("ssssdiii", $productID);
        if ($stmt_product->execute()) {
            echo "Updated Product table <br/>";

            // close db connection
            $stmt_product->close();
        } else {
            echo "Couldn't update product table." . mysqli_error($con) . '<br/>';
            die();
        }


        // Updating vendor in Vendor_Product_Link table
        $query = "UPDATE Vendor_Product_Link SET vendorID = ? WHERE productID = ?";    // link productID to the INSERT

        $stmt_vendorprodlink = $con->prepare($query);
        $stmt_vendorprodlink->bind_param("ii", $vendorID, $productID);
        if ($stmt_vendorprodlink->execute()) {
            echo "Updated vendor in Vendor_Product_Link. <br/>";
        } else {
            echo "Failed to update vendor" . mysqli_error($con) . '<br/>';
            die();
        }


        // updating product type (if have)
        if ($p_type !== '' && $p_type !== null) {
            $query = "UPDATE Product_Type_Link SET prodtypeID = ? WHERE productID = ?";

            $stmt_prodtype = $con->prepare($query);
            $stmt_prodtype->bind_param("ii", $p_type, $productID);
            if ($stmt_prodtype->execute()) {
                echo "Product Type updated. <br/>";
            } else {
                echo "Failed to update Product Type" . mysqli_error($con) . '<br/>';
                die();
            }
        }

        
        // inserting product category (if have)
        if ($p_category !== '' && $p_category !== null) {
            $query = "UPDATE Product_Category_Link SET categoryID = ? WHERE productID = ?";

            $stmt_prodtype = $con->prepare($query);
            $stmt_prodtype->bind_param("ii", $p_category, $productID);
            if ($stmt_prodtype->execute()) {
                echo "Product Category updated. <br/>";
            } else {
                echo "Failed to update Product Category" . mysqli_error($con) . '<br/>';
                die();
            }
        }


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
    }

?>