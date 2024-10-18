<?php
    require("db/dbConnect.php");
    require("app_config/session_handling.php");
?>

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
            // echo "logged in user: " . $userID . "</br>";
        ?>
        
        <!-- Page title -->
        <div class="main-content">
            <h1 style="padding-left: 2%; margin-bottom: 10px;">Stock List</h1>

            <div style="display: flex">
                <div>
                    <div style="inline-flex">
                        <!-- Potential hot selling items in the next n periods -->
                        <!-- DEFAULT: 3 months -->
                        <form action="db/forecast_sequence.php" method="post">
                            <select name="forecastperiod">
                                <option value="14"> 2 weeks </option>
                                <option value="31"> 1 month </option>
                                <option value="100" selected> 3 months </option>
                                <option value="182"> 6 months </option>
                                <option value="366"> 1 year </option>
                                <option value="547"> 1.5 years </option>
                                <option value="730"> 2 years </option>
                            </select>
                            <button class="orange-button" type="submit"> Go </button>
                        </form>
                        <!-- options (if cannot dropdown): 2 weeks, 1 month, 3 months, 6 months, 1 year, 1.5 years, 2 years -->
                    </div>

                    <!-- forecast graph -->
                    <div id="forecastGraph"></div>
                </div>


                <div>
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
                </div>
            </div>
        </div>


        <!-- Javascript -->
        <script>
            // fetching forecast result after page loads
            window.addEventListener('DOMContentLoaded', (event) => {
                fetch('forecast_sequence.php')
                    .then(response =>response.json)
                    .then(data => {
                        // checking result in console
                        console.log(data);

                        // sending returned python data into the 'forecastGraph' div
                        document.getElementById.innerHTML = data;
                    })
                    .catch(error => console.error("Javascript error: ", error));
            });
        </script>
    </body>
</html>