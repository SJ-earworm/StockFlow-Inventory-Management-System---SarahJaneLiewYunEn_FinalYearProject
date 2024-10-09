<?php
    // require session handling file
    require("db/dbConnect.php");
    require("app_config/session_handling.php");
    require("db/session_handling_db.php");
?>

<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>Edit item</title>

        <!--css stylesheet-->
        <link rel="stylesheet" type="text/css" href="style.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!-- Logo + Sign Up title -->
        <div style="display: flex; justify-content: center; align-item: center; margin-left: -2.7%;">
            <div style="display: flex; align-items: center;">
                <img src="images/logo_light.png"/> <!-- add this to img for testing -> style="border: 1px solid blue" -->
                <span style="margin-top: 2%; font-size: 410%; font-weight: 700;">Sign Up</span>
            </div>
        </div>

        <!-- temporary, for debugging -->
        <?php
            echo "logged in user: " . $userID . "</br>";
        ?>

        <!-- Input fields -->
        <form action="db/edititem_db.php" method="post" enctype="multipart/form-data">
            <!-- Upload image -->
            <input type="file" name="pd-image" id="files">
            <label for="files">Choose Image (jpeg, jpg or png file types only)</label>
            <!-- Product name -->
            <input type="text" name="productname" placeholder="Product name *" autocomplete="off" required />
            <!-- Brand -->
            <input type="text" name="brand" placeholder="Brand *" autocomplete="off" required />
            <!-- Serial number -->
            <input type="text" name="serialno" placeholder="Serial number" autocomplete="off" />
            <!-- Batch number -->
            <input type="text" name="batchno" placeholder="Batch number" autocomplete="off" />
            <!-- Stock Keeping Unit -->
            <input type="text" name="sku" placeholder="Stock Keeping Unit (SKU) *" autocomplete="off" required />
            <!-- Unit price -->
            <input type="text" name="unitprice" placeholder="Unit price *" autocomplete="off" required />
            <!-- No. of stock -->
            <!-- Vendor dropdown -->
            <!-- Product type -->
                <!-- Dropdown -->
                <!-- Edit button -->

            <!-- Product category -->
                <!-- Dropdown -->
                <!-- Edit button -->


            <!-- Action performed / item edit logging -->
            <textarea name="itemeditlog" placeholder="Action performed / changes made *" required></textarea>

            <!-- Save button -->
            <button type="submit" class="button-log-sign" style="height: 40px; width: 100%"><span class="btntext">Sign Up</span></button>
        </form>




        <!-- Javascript -->
        <script>

        </script>
    </body>
</html>