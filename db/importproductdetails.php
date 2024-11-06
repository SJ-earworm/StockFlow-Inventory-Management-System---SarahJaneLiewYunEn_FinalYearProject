<?php
    $query = "SELECT 
                p.SKU,
                p.prod_name,
                p.serial_no,
                p.brand,
                ptl.prodtypeID,
                pt.prod_type,
                COALESCE (pcl.categoryID, '--') AS categoryID,  -- if data doesn't exist, set '--' default return value
                COALESCE (pc.category, '--') AS category,   -- if data doesn't exist, set '--' default return value
                p.unit_price,
                p.quantity,
                vpl.vendorID
                -- v.name
            FROM 
                Product p
            JOIN
                Product_Type_Link ptl ON p.productID = ptl.productID
            JOIN
                Product_Type pt ON ptl.prodtypeID = pt.prodtypeID
            LEFT JOIN
                Product_Category_Link pcl ON pcl.productID = p.productID
            LEFT JOIN
                Product_Category pc ON pc.categoryID = pcl.categoryID
            JOIN
                Vendor_Product_Link vpl ON p.productID = vpl.productID
            WHERE
                p.productID = ?";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $stmt->bind_result($SKU, $p_name, $serial_no, $brand, $p_typeID, $p_typename, $p_categoryID, $p_categoryname, $u_price, $quantity, $vendorID);
    $stmt->fetch();
?>