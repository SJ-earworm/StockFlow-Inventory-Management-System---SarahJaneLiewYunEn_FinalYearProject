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
            include("web_components/admin_header.php");
        ?>

        <!-- temporary, for debugging -->
        <?php
            // echo "logged in user: " . $userID . "</br>";
        ?>
        
        <!-- Page title -->
        <div class="main-content">
            <div style="position: fixed; height: 81%; width: 88%; margin-left: 0px; border: 1px solid black;">
                <!-- COLUMN HEADER SECTION -->
                <div class="above-col-header">
                    <!-- page title -->
                    <h1 style="padding-left: 0.3%; margin-bottom: 10px;">Purchase Orders</h1>

                    <!-- buttons -->
                    <div class="item-cat-btn-div" style="width: 250px; left: 36%;">
                        <!-- Add item button-->
                        <a href="addnewitem.php" style="margin: 0; padding: 0; text-decoration: none;">
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

                <div class="main-space-area">
                    <!-- purchase order list -->
                    <div class="purchase-order-list-pane">
                        <div class="po-pane-header"><span style="margin-left: 18px; background-color: transparent;">Orders</span></div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Javascript -->
        <script>
            // panel visibiltiy
            

            // NEW CATEGORY NAME: form submission
            document.getElementById('newCategoryForm').addEventListener('submit', function(e) {
                e.preventDefault();  // preventing default submit sequence

                // creating FormData object for the target form
                // const formData = new FormData(this);
                // note: FormData is a js object that automatically fetches all the form data in key-value pairs
                //       (especially if you have many fields) so you won't have to manually retrieve each input value

                // manually putting form data into an object to be sent over to backend
                const formData = {
                    newcatname: this.catname.value
                };
                console.log(formData);

                // sending form data to backend file
                fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/addnewcategory_db.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())  // retrieving response from backend
                // .then(data => console.log(data))  // debugging
                .then(data => {
                    const message = document.getElementById('successErrorStatus');

                    if (data.status == 'success') {
                        // clear input field
                        this.catname.value = '';

                        message.innerHTML = data.message;
                        message.style.color = 'green';
                        message.style.backgroundColor = '#9CFFB0';
                        message.style.visibility = 'visible';
                        // hiding message after 3s
                        setTimeout(() => {
                            message.style.visibility = 'hidden';
                        }, 3000);
                    } else {
                        message.innerHTML = data.message;
                        message.style.color = 'black';
                        message.style.backgroundColor = '#FF9999';
                        message.style.visibility = 'visible';
                        // hiding message after 3s
                        setTimeout(() => {
                            message.style.visibility = 'hidden';
                        }, 3000);

                        // logging backend error to console
                        console.log(data.log);
                    }
                })
                .catch(error => console.error('Error: ', error));
            });
        </script>
    </body>
</html>