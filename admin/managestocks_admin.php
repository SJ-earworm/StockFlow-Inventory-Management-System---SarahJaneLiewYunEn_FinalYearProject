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
        <div id="mainContentSpace" class="main-content" style="">
            <div style="position: fixed; height: 99%; width: 90%; margin-left: 0px">
                <!-- COLUMN HEADER SECTION -->
                <div class="above-col-header">
                    <!-- page title -->
                    <h1 style="padding-left: 0.3%; margin-bottom: 10px;">Stock List</h1>

                    <!-- buttons -->
                    <div class="item-cat-btn-div">
                        <!-- Add item button-->
                        <a href="addnewitem.php" style="margin: 0; padding: 0; text-decoration: none;">
                            <button>Add item +</button>
                        </a>
                        <!-- Add category button-->
                        <a href="#" onclick="toggleAddEditPanel()" style="margin: 0; padding: 0; text-decoration: none;">
                            <button>Add category +</button>
                        </a>
                    </div>

                    <form action="" method="get" class="search-filter-div">
                        <!-- Search bar -->
                        <i class='fas fa-search' style="left: 52%; margin-top: 8px; font-size: 12px"></i>
                        <input type="text" name="search" placeholder="Search" autocomplete="off" class="list-search-bar" style="padding: 7px 0px; padding-left: 24px;">
                        <!-- Filter button -->
                        <i class="fas fa-filter" style="font-size: 16px"></i>
                    </form>
                </div>


                <!-- Orange header line 1 -->
                <hr class="col-header-ln-1">
                <div class="mng-stock-grid" style="margin: 0 2.7%;">
                    <!-- Column headers -->
                    <span>Stock Keeping Unit</span>
                    <span>Product Name</span>
                    <span>Serial No.</span>
                    <span>Brand</span>
                    <span>Product Type</span>
                    <span>Unit Price</span>
                    <span>Stock Count</span>
                    <span>Vendor</span>
                </div>
                <hr class="col-header-ln-1">

                <div style="overflow-y: auto; height: 68%;">
                    <!-- Stock list -->
                    <?php
                        include("db/stocklist.php");
                    ?>
                </div>
            </div>



            <!-- add category panel -->
            <div id="addEditCategoryPanel" class="add-edit-category-panel">
                <!-- close button -->
                <!-- <i class="fa fa-close" style="top: 20px; right: 20px; font-size: 28px;"></i> -->
                <!-- switching between configuring category names/categories & items under the category -->
                <div style="display: flex; flex-direction: row; justify-content: space-between; width: 75%;">
                    <button id="addEditTab" class="cat-tab" style="background-color: #FA673E; color: #F1EFE6;" onclick="toggleAddEditActive()">Add/Edit Category Names</button>
                    <button id="adjustTab" class="cat-tab" onclick="toggleAdjustActive()">Adjust Products</button>
                </div>
                <!-- ADD/EDIT CATEGORY NAMES -->
                <!-- add new category -->
                <div id="addEditCatnamesPane" class="add-edit-catnames-pane">
                    <span class="section-title" style="top: -7px; left: -2px;">Add New Category</span>
                    <div class="horizontal-container add-category-section">    
                        <span style="width: 110px; margin-top: 10px">Category name: </span>
                        <!-- saving new category to database -->
                        <form id="newCategoryForm" name="newcatname" method="post" style="width: 400px;">
                            <input type="text" name="catname" style="width: 290px" placeholder="Enter new category" />
                            <!-- save button -->
                            <button type="submit" class="save-btn">Save</button>
                        </form>
                    </div>
                    <!-- rename/delete existing category -->
                    <div class="horizontal-container edit-category-section">
                        <span class="section-title" style="top: -5px; left: -5px;">Edit Categories</span>
                        <div style="display: block;">
                            <span>Select category to edit:</span>
                            <select id="existingCategory" style="margin: 8px 0px; width: 160px;">
                                <?php
                                    include("db/categorylist.php");
                                ?>
                            </select>
                            <div class="horizontal-container">
                                <button class="rename-btn" onclick="toggleRenamePanel()">Rename</button>
                                <button class="delete-btn" onclick="toggleDeletePanel()">Delete</button>
                            </div>
                        </div>
                        <!-- RENAME/DELETE PANEL -->
                        <!-- rename -->
                        <div id="renamePanel" class="rename-panel">
                            <span style="width: 220px; margin: 10px; background-color: transparent;">New category name: </span>
                            <form id="renameCategoryForm" name="renamecat" method="post" style="width: 280px; border: background-color: transparent;">
                                <input type="text" name="catrename" style="background-color: transparent; height: 25px; width: 180px" placeholder="New category name" />
                                <!-- save button -->
                                <button type="submit" class="save-btn">Save</button>
                            </form>
                        </div>
                        <!-- delete -->
                        <div id="deletePanel" class="delete-panel">
                            <span style="text-align: center; width: 220px; margin: 10px; background-color: transparent">Are you sure you want to delete this category?</span>
                            <form id="deleteCategoryForm" name="deletecat" method="post" style="width: 350px; background-color: transparent">
                                <!-- yes/no button -->
                                <div style="display: flex; flex-direction: row; width: 120px; justify-content: space-between; margin-left: 110px;">
                                    <button type="submit" class="yes-btn">Yes</button>
                                    <button class="no-btn" onclick="handleCancel()">No</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- ADJUST PRODUCTS PANE -->
                <!-- <div class="adjust-products-pane"> -->
                    <!-- dropdown section -->
                    <!-- <div style="display: flex; flex-direction: row; justify-content: center; align-items: center; width: 70%; height: 45px; border: 1px solid black">
                        <span>Assigning products to category:</span>
                        <select id="assignToCategory">
                            <?php
                                // include("db/categorylist.php");
                            ?>
                        </select>
                    </div> -->
                    <!-- product list displayed here -->
                    <!-- <div id="productsMinipane" class="products-minipane"></div>
                </div> -->

                <!-- DEBUGGING -->
                <div id="adjustProductsPane" class="adjust-products-pane">
                    <!-- dropdown section -->
                    <div style="display: flex; flex-direction: row; justify-content: center; align-items: center; width: 70%; height: 45px; border: 1px solid black">
                        <span>Assigning products to category:</span>
                        <form action="db/stocklist_adjustproductspane.php" method="post">
                            <select id="assignToCategory" name="assigncategory">
                                <?php
                                    include("db/categorylist.php");
                                ?>
                            </select>
                            <button type="submit">test</button>
                        </form>
                    </div>
                    <!-- product list displayed here -->
                    <div id="productsMinipane" class="products-minipane"></div>
                </div>


                <button class="close-btn" onclick="toggleAddEditPanel()">Close</button>
            </div>


            <!-- success/error status -->
            <div id="successErrorStatus" class="success-error-status"></div>
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


            // DELETE PRODUCT ROW
            function handleDeleteItem() {
                const itemToDelete = document.getElementById('itemToDelete').value;

                // manually putting form data into an object to be sent over to backend
                const formData = {
                    productID: this.value
                };
                console.log(formData);

                // sending form data to backend file
                fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/deleteitem_db.php', {
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
            }

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


            // RENAME CATEGORY: form submission
            document.getElementById('renameCategoryForm').addEventListener('submit', function(e) {
                e.preventDefault();  // preventing default submit sequence

                // creating FormData object for the target form
                // const formData = new FormData(this);
                // note: FormData is a js object that automatically fetches all the form data in key-value pairs
                //       (especially if you have many fields) so you won't have to manually retrieve each input value

                // fetching old category name
                const oldName = document.getElementById('existingCategory');
                // manually putting form data into an object to be sent over to backend
                const formData = {
                    oldcatID: oldName.value,
                    newcatname: this.catrename.value
                };
                console.log(formData);

                // sending form data to backend file
                fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/editcategory_db.php', {
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
                        this.catrename.value = '';

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


            // DELETE CATEGORY: form submission
            document.getElementById('deleteCategoryForm').addEventListener('submit', function(e) {
                e.preventDefault();  // preventing default submit sequence

                // creating FormData object for the target form
                // const formData = new FormData(this);
                // note: FormData is a js object that automatically fetches all the form data in key-value pairs
                //       (especially if you have many fields) so you won't have to manually retrieve each input value

                // fetching old category name
                const deleteCatID = document.getElementById('existingCategory');
                // manually putting form data into an object to be sent over to backend
                const formData = {
                    deleteCatID: deleteCatID.value
                };
                console.log(formData);

                // sending form data to backend file
                fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/deletecategory_db.php', {
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
                        message.innerHTML = data.message;
                        message.style.color = 'green';
                        message.style.backgroundColor = '#9CFFB0';
                        message.style.visibility = 'visible';
                        deletePanel.style.visibility = 'hidden';
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



            // ADJUST PRODUCTS DATALIST
            // for loading product list upon page load + changing displayed list upon category change
            // document.addEventListener('DOMContentLoaded', function() {
            //     // const categoryToEdit = this.value;
            //     function loadProductList(categoryID) {
            //         const sendData = {
            //             selectedCategory: categoryID
            //         };

            //         fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/stocklist_adjustproductspane.php', {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json'
            //             },
            //             body: JSON.stringify(sendData)
            //         })
            //         .then(response => response.json())  // retrieving response from backend
            //         .then(data => {
            //             const productsMinipane = document.getElementById('productsMinipane');
            //             productsMinipane.innerHTML = '';   // Clearing entire pane of previous data

            //             if (data.status == 'success') {
            //                 productsMinipane.innerHTML = data.message;  // populating the pane with returned data
            //                 console.log(data.message);
            //                 // productsMinipane.innerHTML = 'test';
            //             }

            //             // if error
            //             if (data.status == 'fail') {
            //                 console.log(data.message);
            //             }
            //         })
            //         .catch(error => console.error('Error: ', error));
            //     }

            //     // default render (initial page load)
            //     const defaultCategorySel = document.getElementById('assignToCategory').value;
            //     loadProductList(defaultCategorySel);  // calling the function

            //     // on change category select
            //     document.getElementById('assignToCategory').addEventListener('change', function(e) {
            //         loadProductList(this.value);
            //     })
            // });
        </script>
    </body>
</html>