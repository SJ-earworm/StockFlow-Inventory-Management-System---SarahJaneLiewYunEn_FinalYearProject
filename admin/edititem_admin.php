<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>Edit item</title>

        <!--css stylesheet-->
        <link rel="stylesheet" type="text/css" href="style.css">

        <!-- settings icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!-- Header -->
        <?php
            include('web_components/admin_header.php');
        ?>

        <?php
            // temporary, for debugging
            // echo "logged in user: " . $userID . "</br>";
            if (isset($_GET['ID'])) {
                $productID = $_GET['ID'];
            }
            // echo "productID: " . $productID . "</br>";
            include('db/importproductdetails.php');
            // debugging
            // echo 'pcategoryID: ' . $p_categoryID . '<br/>';
            // echo 'category: ' . $p_categoryname . '<br/>';
        ?>

        <!-- Input fields -->
        <form id="editItemForm" action="db/edititem_db.php?ID=<?php echo $productID ?>" method="post" enctype="multipart/form-data" class="edit-item-form">
            <!-- Upload image -->
            <!-- <input type="file" name="pd-image" id="files">
            <label for="files">Choose Image (jpeg, jpg or png file types only)</label> -->
            <div class="horizontal-container" style="margin: 10px;">
                <!-- Product name -->
                <div class="vertical-container" style="width: 24%;">
                    <label>Product Name</label>
                    <input type="text" name="productname" value="<?php echo $p_name; ?>"  id="pName" placeholder="Product name *" autocomplete="off" style="width: 100%; margin-left: 5px" required />
                </div>
                <!-- Brand -->
                <div class="vertical-container" style="width: 18%;">
                    <label>Brand</label>
                    <input type="text" name="brand" value="<?php echo $brand; ?>" id="pBrand" placeholder="Brand *" autocomplete="off" style="width: 100%;" required />
                </div>
                <!-- Serial number -->
                <div class="vertical-container" style="width: 18%;">
                    <label>Serial No.</label>
                    <input type="text" name="serialno" value="<?php echo $serial_no; ?>" id="pSerialNo" placeholder="Serial number" autocomplete="off" style="width: 100%;" />
                </div>
            </div>
            <div class="horizontal-container" style="margin: 10px;">
                <!-- Stock Keeping Unit -->
                <div class="vertical-container" style="width: 18%;">
                    <label>Stock Keeping Unit (SKU)</label>
                    <input type="text" name="sku" value="<?php echo $SKU; ?>" id="pSKU" placeholder="Stock Keeping Unit (SKU) *" autocomplete="off" style="width: 100%;" required />
                </div>
                <!-- Unit price -->
                <div class="vertical-container" style="width: 18%;">
                    <label>Unit price</label>
                    <input type="text" name="unitprice" value="<?php echo $u_price; ?>" id="pPrice" placeholder="Unit price *" autocomplete="off" style="width: 100%;" required />
                </div>
                <!-- No. of stock -->
                <div class="horizontal-container" style="width: 280px; align-items: center;">
                    <span>No. of stock</span>
                    <input type="number" name="quantity" id="setQuantity" value="<?php echo $quantity; ?>" min="1" style="border: 1.5px solid black; height: 30px; width: 70px; vertical-align: middle;">
                </div>
                <!-- Vendor dropdown -->
                <select name="vendor" class="edititem-dropdowns" required>
                    <option value="" disabled selected hidden required>Vendor *</option>
                    <?php
                        include('db/vendorlist.php');
                    ?>
                </select>
            </div>
            <?php  // debugging
                // echo $userID;
            ?>
            <div class="horizontal-container" style="margin: 15px 2px;">
                <!-- Product type -->
                <div class="horizontal-container" style="width: 398px">
                    <!-- Dropdown -->
                    <div style="vertical-container">
                        <label style="margin-bottom: 8px">Product type</label>
                        <select name="prodtype" class="edititem-dropdowns" style="margin-top: 8px">
                            <!-- <option value="" disabled selected hidden>Product type</option> -->
                            <?php
                                include('db/prodtypelist.php');
                            ?>
                        </select>
                    </div>
                    <!-- Edit button -->
                    <button class="edititem-buttons" style="margin-top: 22px">Edit product types</button>
                </div>

                <!-- Product category -->
                <div class="horizontal-container" style="width: 398px">
                    <!-- Dropdown -->
                    <div class="vertical-container">
                        <label style="margin-bottom: 8px">Product category</label>
                        <select name="prodcat" class="edititem-dropdowns">
                            <option value="" style="color: grey;" disabled selected hidden>Category</option>
                            <?php
                                include('db/categorylist.php');
                            ?>
                        </select>
                    </div>
                    <!-- Edit button -->
                    <button class="edititem-buttons" style="margin-top: 22px" onclick="toggleAddEditPanel()">Edit categories</button>
                </div>
            </div>


            <!-- Action performed / item edit logging -->
            <textarea name="itemeditlog" placeholder="Action performed / changes made *" class="edititem-log-textarea" required></textarea>

            <!-- Save button -->
            <button type="submit" onClick="updateQuantity()" class="orange-button edititem-save-btn" style="height: 40px;">Save</button>
        </form>



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
                                <button type="submit" class="add-edit-yes-btn">Yes</button>
                                <button class="add-edit-no-btn" onclick="handleCancel()">No</button>
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




        <!-- Javascript -->
        <script>
            // quantity box
            // setting new user input value before sending form over to backend
            function updateQuantity() {
                // accessing input field
                var quantInputField = document.getElementById('setQuantity');

                // retrieve current value in field
                var quantity = quantInputField.value;

                // updating quanity set
                quantInputField.value = quantity;
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
        </script>
    </body>
</html>