<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>Manage Stocks</title>

        <!--css stylesheet-->
        <link rel="stylesheet" type="text/css" href="style.css">

        <!-- settings icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- magnifying glass icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!-- trash, edit, close button icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!-- Header -->
        <?php
            include("web_components/staff_header.php");
        ?>

        <!-- temporary, for debugging -->
        <?php
            // echo "logged in user: " . $userID . "</br>";
        ?>
        
        <!-- Page title -->
        <div class="main-content" style="height: 550px; width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <div style="display: flex; flex-direction: row; justify-content: space-between; height: 300px; width: 75%;">
                <a href="purchaseorders.php" style="text-decoration: none"><div class="purchase-order-link">Purchase <br/> Orders</div></a>
                <a href="#" style="text-decoration: none"><div class="vendors-link">Vendors</div></a>
            </div>
        </div>


        <!-- Javascript -->
        <script>
        </script>
    </body>
</html>