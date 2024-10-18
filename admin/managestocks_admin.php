<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>Manage Stocks</title>

        <!--css stylesheet-->
        <link rel="stylesheet" type="text/css" href="style.css">

        <!-- settings icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!-- Header -->
        <?php
            include("web_components/admin_header.php");
        ?>

        <!-- temporary, for debugging -->
        <?php
            echo "logged in user: " . $userID . "</br>";
        ?>
        
        <!-- Page title -->
        <div class="main-content">
            <h1 style="padding-left: 2%; margin-bottom: 10px;">Stock List</h1>

            <!-- Add item button-->
            <a href="edititem.php">
                <button>Add item +</button>
            </a>

            <!-- Orange header line 1 -->
            <hr class="col-header-ln-1">
            <div class="mng-stock-grid" style="margin: 0 2.7%;">
                <!-- Column headers -->
                <span>Stock Keeping Unit</span>
                <span>Product Name</span>
                <span>Serial No.</span>
                <span>Batch No.</span>
                <span>Brand</span>
                <span>Product Type</span>
                <span>Unit Price</span>
                <span>Stock Count</span>
                <span>Vendor</span>
            </div>
            <hr class="col-header-ln-1">

            <!-- Stock list -->
            <?php
                include("db/stocklist.php");
            ?>
        </div>

        <!-- Add item button-->
        <!-- <a href="edititem.php">
            <button>Add item +</button>
        </a> -->

        <!-- Orange header line 1 -->
        <!-- <hr class="col-header-ln-1">
        <div class="mng-stock-grid" style="margin: 0 2.7%;"> -->
            <!-- Column headers -->
            <!-- <span>Stock Keeping Unit</span>
            <span>Product Name</span>
            <span>Serial No.</span>
            <span>Batch No.</span>
            <span>Brand</span>
            <span>Product Type</span>
            <span>Unit Price</span>
            <span>Stock Count</span>
            <span>Vendor</span>
        </div>
        <hr class="col-header-ln-1"> -->

        <!-- Stock list -->
        <?php
            // include("db/stocklist.php");
        ?>

        <!-- <div class="mng-stock-grid" style=" padding: 10px; height: 14px;">
            <span class="grid-element">hello world my name is Luca</span>
            <span class="grid-element">askldjf asdfjkads kf klasdjfsd jaf Name</span>
            <span class="grid-element">asldkjf asdf jklsdfsdfrlkhj sdfs jkldf No.</span>
            <span class="grid-element">sdk;fj skl jdflsdjf lksd jfsd klfsdf No.</span>
            <span class="grid-element">sd kljfsjd fklsj dfsjdfl jsdlkfjsd jkf</span>
            <span class="grid-element">sdlkfj klsdfkl sd fksd jflksdj fskld jfl Type</span>
            <span class="grid-element">sdlkfj skdjf sdkl fjsdkl fjsdklfskldfjsd Count</span>
            <span class="grid-element">asd;kfljsdlfkj sdklfj klsdf jsd fjs Price</span>
            <span class="grid-element">sdkl jfdkls fjdks jfkldsf sd kljf</span>
        </div>

        <hr class="list-divider"> -->


        <!-- Javascript -->
        <script>
        </script>
    </body>
</html>