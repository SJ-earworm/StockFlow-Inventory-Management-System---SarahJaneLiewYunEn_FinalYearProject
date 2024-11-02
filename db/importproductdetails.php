<?php
    $query = "SELECT 
                p.SKU,
                p.prod_name,
                p.serial_no,
                p.brand,
                ptl.prodtypeID,
                p.unit_price,
                p.quantity,
                vpl.vendorID
                -- v.name
            FROM 
                Product p
            JOIN
                Product_Type_Link ptl ON p.productID = ptl.productID
            JOIN
                Vendor_Product_Link vpl ON p.productID = vpl.productID
            WHERE
                p.productID = ?";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $stmt->bind_result($SKU, $p_name, $serial_no, $brand, $p_typeID, $u_price, $quantity, $vendorID);
    $stmt->fetch();
?>