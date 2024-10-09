<?php
    require("dbConnect.php");
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        // Retrieving user input data from edititem.php form
        $p_name = $_REQUEST['productname'];
        $brand = $_REQUEST['brand'];
        $serial_no = $_REQUEST['serialno'];
        $batch_no = $_REQUEST['batchno'];
        $sku = $_REQUEST['sku'];
        $u_price = $_REQUEST['unitprice'];
        $logs = $_REQUEST['itemeditlog'];

        // Inserting into Product table
        $query = "INSERT INTO Product (prod_name, brand, serial_no, batch_no, SKU, unit_price) 
                    VALUES ('$p_name', '$brand', '$serial_no', '$batch_no', '$sku', '$u_price')";

        if (mysqli_query($con, $query)) {
            // test for now
            echo "successfully saved to Product db!";


            // javascript popup saying item successfully saved
            // header("Location: managestock.php");
            // die;
        } else {
            echo "Error: " . mysqli_error($con);
        }

        // Inserting into Activity Log table
        $query = "INSERT INTO Activity_Log (action) VALUES ('$logs')";

        if (mysqli_query($con, $query)) {
            // test for now
            echo "successfully saved to Activity Log db!";


            // javascript popup saying item successfully saved
            // header("Location: managestock.php");
            // die;
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }

?>