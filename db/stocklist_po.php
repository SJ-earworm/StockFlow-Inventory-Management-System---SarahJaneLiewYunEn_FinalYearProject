<?php
    require("dbConnect.php");
    require("app_config/session_handling.php");

    // debugging
    // echo "logged in user from stocklist.php: " . $userID . '</br>';

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_REQUEST['search']) && $_REQUEST['search'] !== '' && $_REQUEST['search'] !== null) {    // isset condition to avoid undefined array message
        // debugging
        // echo "search query is running. <br/>";
        
        // when search bar is used
        // retrieving search query input
        $searchInput = $_REQUEST['search'];
        $searchInputWithWildcards = '%'. $searchInput . '%';

        $query = "SELECT 
                p.productID,
                p.SKU,
                p.prod_name,
                p.serial_no,
                p.brand,
                pt.prod_type,
                p.unit_price,
                p.quantity,
                v.name
            FROM 
                Product p
            LEFT JOIN
                Product_Type_Link ptl ON p.productID = ptl.productID
            LEFT JOIN
                Product_Type pt ON ptl.prodtypeID = pt.prodtypeID
            LEFT JOIN
                Vendor_Product_Link vpl ON p.productID = vpl.productID
            LEFT JOIN
                Vendor v ON vpl.vendorID = v.vendorID
            WHERE
                p.storeID IN (
                    SELECT storeID 
                    FROM User 
                    WHERE userID = ?
                )
                AND (
                    p.SKU LIKE ? OR
                    p.prod_name LIKE ? OR
                    p.serial_no LIKE ? OR
                    p.brand LIKE ? OR
                    pt.prod_type LIKE ? OR
                    v.name LIKE ?
                )
            ORDER BY p.prod_name ASC";  // selecting all the products 


        $stmt = $con->prepare($query);
        $stmt->bind_param("issssss", $userID, $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards);

    } else {
        // debugging
        // echo "regular query is running. </br>";

        $query = "SELECT 
                p.productID,
                p.SKU,
                p.prod_name,
                p.serial_no,
                p.brand,
                COALESCE (pt.prod_type, '--') AS prod_type,
                -- (SELECT pt.prod_type 
                --     FROM Product_Type pt 
                --     WHERE pt.prodtypeID = ptl.prodtypeID) AS prod_type,
                p.unit_price,
                p.quantity,
                v.name
                -- GROUP_CONCAT(DISTINCT v.name SEPARATOR ', ') AS vendors
            FROM 
                Product p
            LEFT JOIN
                Product_Type_Link ptl ON p.productID = ptl.productID
            LEFT JOIN
                Product_Type pt ON ptl.prodtypeID = pt.prodtypeID
            JOIN
                Vendor_Product_Link vpl ON p.productID = vpl.productID
            JOIN
                Vendor v ON vpl.vendorID = v.vendorID
            WHERE
                p.storeID IN (
                    SELECT storeID 
                    FROM User 
                    WHERE userID = ?
                )
                -- AND p.productID IS NOT NULL
            ORDER BY p.prod_name ASC";  // selecting all the products 

        
        // default query
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $userID);
    }

    $stmt->execute();

    // debugging
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        while($row = $result->fetch_assoc()) {
            // storiing SKU, prod_name & unit_price into key-value pairs array
            // $POAutofill = [
            //     'SKU' => $row['SKU'],
            //     'prod_name' => $row['prod_name'],
            //     'unit_price' => $row['unit_price']
            // ];

            // DEBUGGING
            // echo "POAutofill SKU: " . $POAutofill['SKU'];

            // encoding array data into JSON for td fill later
            // $POAutofillJSON = htmlspecialchars(json_encode($POAutofill), ENT_QUOTES, 'UTF-8');
            // htmlspecialchars is to convert escape characters into their HTML versions (e.g. '&' -> '&amp;') to prevent cross-site scripting (XSS)/SQL injection
            // ENT_QUOTES & UTF-8 comes tgt with htmlspecialchars to make the conversion to HTML characters work

            // debugging
            // echo "JSON ver.: " . $POAutofillJSON;

            echo '<div class="po-grid po-grid-row" style=" padding: 10px 0px; height: 14px;" ';
            echo 'data-product-SKU="' .htmlspecialchars($row['SKU']). '" ';                 // passing product data
            echo 'data-product-prodname="' .htmlspecialchars($row['prod_name']). '" ';      // in custom 'value-holders'
            echo 'data-product-uprice="' .htmlspecialchars($row['unit_price']). '" ';
            echo 'data-product-brandAsKey="' .htmlspecialchars($row['brand']). '">';   // data-(product-*) is a custom 'value holder' cos <div> doesn't support 'value'
            echo '  <span class="po-grid-element">' . $row['prod_name'] . '</span>';  // Product Name
            echo '  <span class="po-grid-element">' . $row['SKU'] . '</span>';  // SKU
            echo '  <span class="po-grid-element">' . $row['brand'] . '</span>';  // Brand
            // echo '  <span class="grid-element">' . $row['unit_price'] . '</span>';  // Unit Price
            echo '</div>';

            echo '<hr class="list-divider">';

            // debugging: force exit loop after printing 1 row
            // break;
        }
    } else {
        echo "Couldn't fetch stock list";
    }
?>