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
            include('web_components/staff_header.php');
        ?>

        <?php
            // temporary, for debugging
            // echo "logged in user: " . $userID . "</br>";
            if (isset($_GET['ID'])) {
                $productID = $_GET['ID'];
            }
            // echo "productID: " . $productID . "</br>";
            include('db/importproductdetails.php');
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
                            <option value="" disabled selected hidden>Product type</option>
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
                    <button class="edititem-buttons" style="margin-top: 22px">Edit categories</button>
                </div>
            </div>


            <!-- Action performed / item edit logging -->
            <textarea name="itemeditlog" placeholder="Action performed / changes made *" class="edititem-log-textarea" required></textarea>

            <!-- Save button -->
            <button type="submit" onClick="updateQuantity()" class="orange-button edititem-save-btn" style="height: 40px;">Save</button>
        </form>




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


            // NEW CATEGORY NAME: form submission
            // document.getElementById('editItemForm').addEventListener('submit', function(e) {
            //     e.preventDefault();  // preventing default submit sequence

            //     // manually putting form data into an object to be sent over to backend
            //     const formData = {
            //         productname: this.productname.value,
            //         brand: this.brand.value,
            //         serialno: this.serialno.value,
            //         sku: this.sku.value,
            //         unitprice: this.unitprice.value,
            //         quantity: this.quantity.value,
            //         vendor: this.vendor.value,
            //         prodtype: this.prodtype.value,
            //         prodcat: this.prodcat.value,
            //         itemeditlog: this.itemeditlog.value
            //     };
            //     console.log(formData);

            //     // sending form data to backend file
            //     fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/addnewcategory_db.php?ID=<?php echo $productID ?>', {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json'
            //         },
            //         body: JSON.stringify(formData)
            //     })
            //     .then(response => response.json())  // retrieving response from backend
            //     // .then(data => console.log(data))  // debugging
            //     .then(data => {
            //         const message = document.getElementById('successErrorStatus');

            //         if (data.successStatus == 'success') {
            //             // redirect to managestocks.php

            //             message.innerHTML = "Successfully updated product details";
            //             message.style.color = 'green';
            //             message.style.backgroundColor = '#9CFFB0';
            //             message.style.visibility = 'visible';
            //             // hiding message after 3s
            //             setTimeout(() => {
            //                 message.style.visibility = 'hidden';
            //             }, 3000);
            //         } else {
            //             message.innerHTML = data.message;
            //             message.style.color = 'black';
            //             message.style.backgroundColor = '#FF9999';
            //             message.style.visibility = 'visible';
            //             // hiding message after 3s
            //             setTimeout(() => {
            //                 message.style.visibility = 'hidden';
            //             }, 3000);

            //             // logging backend error to console
            //             console.log(data.error);
            //         }
            //     })
            //     .catch(error => console.error('Error: ', error));
            // });
        </script>
    </body>
</html>