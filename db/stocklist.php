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
        $stmt->bind_param("issssss", $userID, $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards, 
                            $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards);

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
            echo '<div class="mng-stock-grid row" style=" padding: 10px 0px; height: 14px;">';
            echo '  <span class="grid-element">' . $row['SKU'] . '</span>';  // SKU
            echo '  <span class="grid-element">' . $row['prod_name'] . '</span>';  // Product Name
            echo '  <span class="grid-element">' . $row['serial_no'] . '</span>';  // Serial Number
            echo '  <span class="grid-element">' . $row['brand'] . '</span>';  // Brand
            echo '  <span class="grid-element">' . (isset($row['prod_type']) ? $row['prod_type'] : '--') . '</span>';  // Product Type
            echo '  <span class="grid-element">' . $row['unit_price'] . '</span>';  // Unit Price
            echo '  <span class="grid-element">' . $row['quantity'] . '</span>';  //Stock Count
            echo '  <span class="grid-element">' . $row['name'] . '</span>';    // this is for the vendor
            
                    // edit / delete buttons
            echo '  <div class="edit-del-btn">';
                        // edit button
            echo '      <a href="edititem.php?ID=' . $row['productID'] . '">';
            echo '          <i class="fa fa-edit"></i>';
            echo '      </a>';
                        // delete button
            echo '      <button onclick="toggleConfirm()" id="itemToDelete" value="' . $row['productID'] . '">';
            echo '          <i class="fa fa-trash-o"></i>';
            echo '      </button>';
            echo '  </div>';
            echo '</div>';

            echo '<hr class="list-divider">';

            // debugging: force exit loop after printing 1 row
            // break;
        }
    } else {
        echo "Couldn't fetch stock list";
    }
?>