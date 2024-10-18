<?php

    // initialising server variables
    $dbServer = "localhost";
    $dbUsername = "root";
    $dbPassword = "";

    // establishing connection with localhost phpMyAdmin
    $con = mysqli_connect($dbServer, $dbUsername, $dbPassword);

    // check connection
    if (!$con) {
        die("Couldn't connect to database: " . mysqli_connect_error());
    }

    
    $query = "CREATE DATABASE IF NOT EXISTS `stockflowFINALYEARPROJECT_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        echo "Database created successfully! <br/>";
    }
    else {
        echo "Error creating database: " . mysqli_error($con);
    }
    
    
    // close connection before reconnecting to localhost & locating the specific server
    $con->close();
    

    // reconnecting to localhost and selecting the `stockflowFINALYEARPROJECT_db` database
    $con = mysqli_connect($dbServer, $dbUsername, $dbPassword, 'stockflowFINALYEARPROJECT_db');

    // check connection
    if ($con) {
        echo "Connected to stockflowFINALYEARPROJECT_db <br/>";
    } else {
        die("Couldn't connect to stockflowFINALYEARPROJECT_db: " . mysqli_connect_error());
    }



    // ------------------------------------------- creating the database tables ----------------------------------------------



    // creating db tables
    // Vendor table
    $query = "CREATE TABLE IF NOT EXISTS `Vendor` (
        `vendorID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `address_line1` varchar(255) NOT NULL,
        `address_line2` varchar(255) NOT NULL,
        `city` varchar(255) NOT NULL,
        `ZIP_code` int(5) NOT NULL,
        `state` varchar(255) NOT NULL,
        `country` varchar(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (mysqli_query($con, $query)) {
        echo "'Vendor' table created successfully! <br/>";
    } else {
        echo "Error creating 'Vendor' table: " . mysqli_error($con);
    }



    // Store table
    $query = "CREATE TABLE IF NOT EXISTS `Store` (
        `storeID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `contact` varchar(255) NOT NULL,
        `address_line1` varchar(255) NOT NULL,
        `address_line2` varchar(255) NOT NULL,
        `city` varchar(255) NOT NULL,
        `ZIP_code` int(5) NOT NULL,
        `state` varchar(255) NOT NULL,
        `country` varchar(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (mysqli_query($con, $query)) {
        echo "'Store' table created successfully! <br/>";
    } else {
        echo "Error creating 'Store' table: " . mysqli_error($con);
    }

    // inserting hard coded companies
    $query = "INSERT INTO `Store` (`name`, `email`, `contact`, `address_line1`, `address_line2`, `city`, `ZIP_code`, `state`, `country`) 
    VALUES ('Shine Mart', 'shinemart@mail.com', '+603 445 2345', '14, Argon Rd', 'Taman Lerang', 'Cheras', '56000', 'Kuala Lumpur', 'Malaysia'),
           ('Yeet Hei Shop', 'yeethei@mail.com', '+604 123 7289', 'Queensbay Mall', 'Persiaran Bayan Indah', 'Bayan Lepas', '11900', 'Pulau Pinang', 'Malaysia'),
           ('MetMart', 'metmart@mail.com', '+603 998 7383', '20, Arranged Yoe', 'Jalan Silang', 'Cyber City', '18099', 'Ipoh', 'Malaysia'),
           ('Doorstop', 'ds@mail.com', '+604 893 2345', '32-38, Jalan Perai Jaya 2', 'Neon City District', 'Perai', '13700', 'Pulau Pinang', 'Malaysia')";

    if (mysqli_query($con, $query)) {
        echo "Successfully hardcoded store details";
    } else {
        echo "Error hardcoding store details: " . mysqli_error($con);
    }



    // User table
    $query = "CREATE TABLE IF NOT EXISTS `User` (
        `userID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `user_type` varchar(255) NOT NULL,
        `storeID` bigint(20) UNSIGNED NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`storeID`) REFERENCES `Store` (`storeID`) ON DELETE CASCADE ON UPDATE CASCADE
    )";

    if (mysqli_query($con, $query)) {
        echo "'User' table created successfully! <br/>";
    } else {
        echo "Error creating 'User' table: " . mysqli_error($con);
    }



    // Product Category table
    $query = "CREATE TABLE IF NOT EXISTS `Product_Category` (
        `categoryID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `category` varchar(255) DEFAULT '-'
    )";

    if (mysqli_query($con, $query)) {
        echo "'Product_Category' table created successfully! <br/>";
    } else {
        echo "Error creating 'Product_Category' table: " . mysqli_error($con);
    }



    // Product table
    $query = "CREATE TABLE IF NOT EXISTS `Product` (
        `productID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `prod_name` varchar(255) NOT NULL,
        `serial_no` varchar(255) NOT NULL,
        `SKU` varchar(255) NOT NULL,
        `brand` varchar(255) NOT NULL,
        `prod_type` varchar(255) NOT NULL,
        `unit_price` decimal(10,2) NOT NULL,
        `quantity` int(5) NOT NULL,
        -- `categoryID` bigint(20) UNSIGNED NOT NULL,
        `storeID` bigint(20) UNSIGNED NOT NULL,
        -- `vendorID` bigint(20) UNSIGNED NOT NULL,
        `date_in` DATETIME,
        `date_out` DATETIME,
        `time_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        -- FOREIGN KEY (`categoryID`) REFERENCES `Product_Category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE,
        -- FOREIGN KEY (`vendorID`) REFERENCES `Vendor` (`vendorID`) ON DELETE CASCADE ON UPDATE CASCADE
    )";

    if (mysqli_query($con, $query)) {
        echo "'Product' table created successfully! <br/>";
    } else {
        echo "Error creating 'Product' table: " . mysqli_error($con);
    }



    // Sales table
    $query = "CREATE TABLE IF NOT EXISTS `Sales` (
        `salesID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `userID` bigint(20) UNSIGNED NOT NULL,
        `total_paid` decimal(10,2) NOT NULL,
        `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`userID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
        )";

    if (mysqli_query($con, $query)) {
        echo "'Sales' table created successfully! <br/>";
    } else {
        echo "Error creating 'Sales' table: " . mysqli_error($con);
    }



    // Sales Item Link table
    $query = "CREATE TABLE IF NOT EXISTS `Sales_Item_Link` (
        `salesID` bigint(20) UNSIGNED NOT NULL,
        `productID` bigint(20) UNSIGNED NOT NULL,
        `quantity_bought` int(5) NOT NULL,
        FOREIGN KEY (`salesID`) REFERENCES `Sales` (`salesID`) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`productID`) REFERENCES `Product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE
        )";

    if (mysqli_query($con, $query)) {
        echo "'Sales_Item_Link' table created successfully! <br/>";
    } else {
        echo "Error creating 'Sales_Item_Link' table: " . mysqli_error($con);
    }



    // Purchase Order table
    // **deletedVendor to store names of inactive/deleted Vendors
    // **deleteditemSKU to store SKU of items ordered before that were deleted
    $query = "CREATE TABLE IF NOT EXISTS `Purchase_Order` (
        `orderID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `vendorID` bigint(20) UNSIGNED NOT NULL,
        `deletedVendor` varchar(255),
        `productID` bigint(20) UNSIGNED NOT NULL,
        `storeID` bigint(20) UNSIGNED NOT NULL,
        `newitemSKU` varchar(255) DEFAULT '-',
        `deleteditemSKU` varchar(255) DEFAULT '-',
        `quantity` int(10) NOT NULL,
        `unit_price` decimal(10,2) NOT NULL,
        `extended_price` decimal(10,2) NOT NULL,
        `order_total` decimal(10,2) NOT NULL,
        `order_status` varchar(255),
        `date_ordered` DATETIME,
        `date_update` DATETIME,
        `date_fulfiled` DATETIME,
        FOREIGN KEY (`vendorID`) REFERENCES `Vendor` (`vendorID`) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`productID`) REFERENCES `Product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`storeID`) REFERENCES `Store` (`storeID`) ON DELETE CASCADE ON UPDATE CASCADE
    )";

    if (mysqli_query($con, $query)) {
        echo "'Purchase_Order' table created successfully! <br/>";
    } else {
        echo "Error creating 'Purchase_Order' table: " . mysqli_error($con);
    }



    // Activity Log table
    $query = "CREATE TABLE IF NOT EXISTS `Activity_Log` (
        `logID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        -- `productID` bigint(20) UNSIGNED NOT NULL,
        `userID` bigint(20) UNSIGNED NOT NULL,
        `deleted_user` varchar(255) DEFAULT '-',
        `action` text NOT NULL,
        `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        -- FOREIGN KEY (`productID`) REFERENCES `Product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`userID`) REFERENCES `User` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
    )";

    if (mysqli_query($con, $query)) {
        echo "'Activity Log' table created successfully! <br/>";
    } else {
        echo "Error creating 'Activity Log' table: " . mysqli_error($con);
    }



    // closing the database connection
    mysqli_close($con);
?>