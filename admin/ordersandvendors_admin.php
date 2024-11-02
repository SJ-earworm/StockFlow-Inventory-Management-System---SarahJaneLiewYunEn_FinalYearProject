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
        <div class="main-content" style="height: 550px; width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <div style="display: flex; flex-direction: row; justify-content: space-between; height: 300px; width: 75%;">
                <a href="purchaseorders.php" style="text-decoration: none"><div class="purchase-order-link">Purchase <br/> Orders</div></a>
                <a href="#" style="text-decoration: none"><div class="vendors-link">Vendors</div></a>
            </div>
        </div>


        <!-- Javascript -->
        <script>
            // panel visibiltiy
            const addEditCategoryPanel = document.getElementById('addEditCategoryPanel');
            const addEditTab = document.getElementById('addEditTab');
            const adjustTab = document.getElementById('adjustTab');
            const addEditCatnamesPane = document.getElementById('addEditCatnamesPane');
            const adjustProductsPane = document.getElementById('adjustProductsPane');
            const renamePanel = document.getElementById('renamePanel');
            const deletePanel = document.getElementById('deletePanel');


            // add/edit panel
            function toggleAddEditPanel() {
                if (addEditCategoryPanel.style.visibility == 'visible') {
                    addEditCategoryPanel.style.visibility = 'hidden';
                    addEditCatnamesPane.style.visibility = 'hidden';
                    adjustProductsPane.style.visibility = 'hidden';
                    renamePanel.style.visibility = 'hidden';
                    deletePanel.style.visibility = 'hidden';
                } else {
                    addEditCategoryPanel.style.visibility = 'visible';
                    addEditCatnamesPane.style.visibility = 'visible';
                    adjustProductsPane.style.visibility = 'hidden';
                }
            }

            // add/edit category tab
            function toggleAddEditActive() {
                if (addEditTab.style.backgroundcolor == 'transparent') {
                    addEditTab.style.backgroundcolor = '#FA673E';
                    addEditTab.style.color = '#F1EFE6';
                    addEditCatnamesPane.style.visibility = 'visible';
                    adjustProductsPane.style.visibility = 'hidden'
                    adjustTab.style.backgroundcolor = '#F1EFE6';
                    adjustTab.style.color = 'black';
                } else {
                    adjustTab.style.backgroundcolor = '#F1EFE6';
                    adjustTab.style.color = 'black';
                }
            }

            // adjust category tab
            // function toggleAdjustActive() {
            //     if (adjustTab.style.backgroundcolor == 'transparent') {
            //         adjustTab.style.backgroundcolor = '#FA673E';
            //         adjustTab.style.color = '#F1EFE6';
            //         addEditTab.style.backgroundcolor = '#F1EFE6';
            //         addEditTab.style.color = 'black';
            //     } else {
            //         addEditTab.style.backgroundcolor = '#F1EFE6';
            //         addEditTab.style.color = 'black';
            //     }
            // }

            // rename sub-panel
            function toggleRenamePanel() {
                if (renamePanel.style.visibility === 'hidden') {
                    renamePanel.style.visibility = 'visible';
                    deletePanel.style.visibility = 'hidden';
                } else {
                    deletePanel.style.visibility = 'hidden';
                }
            }

            // delete sub-panel
            function toggleDeletePanel() {
                if (deletePanel.style.visibility === 'hidden') {
                    deletePanel.style.visibility = 'visible';
                    renamePanel.style.visibility = 'hidden';
                } else {
                    renamePanel.style.visibility = 'hidden';
                }
            }

            // cancel delete
            function handleCancel() {
                deletePanel.style.visibility = 'hidden';
                
            }

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