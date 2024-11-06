<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>Purchase Orders</title>

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
            include("web_components/admin_header.php");
        ?>

        <!-- temporary, for debugging -->
        <?php
            // echo "logged in user: " . $userID . "</br>";
        ?>
        
        <!-- Page title -->
        <div class="main-content">
            <div style="position: fixed; height: 79%; width: 88%; margin-left: 0px;">
                <!-- TITLE + CREATE PURCHASE ORDER BUTTON + SEARCH FILTER -->
                <div class="above-col-header">
                    <!-- page title -->
                    <h1 style="padding-left: 0.3%; margin-bottom: 10px;">Purchase Orders</h1>

                    <!-- buttons -->
                    <div class="item-cat-btn-div" style="width: 250px; left: 36%;">
                        <!-- Add item button-->
                        <a href="newpurchaseorder.php" style="margin: 0; padding: 0; text-decoration: none;">
                            <button style="width: 190px">Create new purchase order</button>
                        </a>
                    </div>

                    <form action="" method="get" class="search-filter-div-po">
                        <!-- Search bar -->
                        <i class='fas fa-search' style="left: 1%; margin-top: 8px; font-size: 12px"></i>
                        <input type="text" name="search" placeholder="Search" autocomplete="off" class="list-search-bar-po" style="padding: 7px 0px; padding-left: 24px;">
                        <!-- Filter button -->
                        <i class="fas fa-filter" style="font-size: 16px; left: -9px"></i>
                    </form>
                </div>

                <div class="main-space-area horizontal-container" style="justify-content: space-between;">
                    <!-- PURCHASE ORDER PANE -->
                    <div class="purchase-order-list-pane">
                        <div class="po-pane-header"><span style="margin-left: 18px; background-color: transparent;">Orders</span></div>
                        <!-- purchase order list -->
                        <li class="po-pane-list-area">
                            <ul class="po-pane-ul">Dummy list</ul>
                            <ul class="po-pane-ul">Dummy list</ul>
                            <ul class="po-pane-ul">Dummy list</ul>
                        </li>
                    </div>

                    <!-- PURCHASE ORDER PDF VIEWER -->
                    <div class="po-viewer"></div>
                </div>
            </div>
        </div>


        <!-- Javascript -->
        <script>
            // setting active PO list (PO panel)
            document.querySelectorAll('.po-pane-ul').forEach(ul => {
                // adding click listner for each <ul>
                ul.addEventListener('click', () => {
                    // removing .active from all <ul>
                    document.querySelectorAll('.po-pane-ul').forEach(ulRemoveActive => {
                        ulRemoveActive.classList.remove('active');
                    });

                    // adding .active to the clicked <ul>
                    ul.classList.add('active');
                });
            });
        </script>
    </body>
</html>