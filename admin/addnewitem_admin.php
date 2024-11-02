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

        <!-- temporary, for debugging -->
        <?php
            // echo "logged in user: " . $userID . "</br>";
        ?>

        <!-- Input fields -->
        <form action="db/addnewitem_db.php" method="post" enctype="multipart/form-data" class="edit-item-form">
            <!-- Upload image -->
            <input type="file" name="pd-image" id="files">
            <label for="files">Choose Image (jpeg, jpg or png file types only)</label>
            <div class="horizontal-container" style="margin: 10px;">
                <!-- Product name -->
                <input type="text" name="productname" placeholder="Product name *" autocomplete="off" style="width: 24%;" required />
                <!-- Brand -->
                <input type="text" name="brand" placeholder="Brand *" autocomplete="off" style="width: 18%;" required />
                <!-- Serial number -->
                <input type="text" name="serialno" placeholder="Serial number" autocomplete="off" style="width: 18%;" />
            </div>
            <div class="horizontal-container" style="margin: 10px;">
                <!-- Stock Keeping Unit -->
                <input type="text" name="sku" placeholder="Stock Keeping Unit (SKU) *" autocomplete="off" style="width: 18%;" required />
                <!-- Unit price -->
                <input type="text" name="unitprice" placeholder="Unit price *" autocomplete="off" style="width: 18%;" required />
                <!-- No. of stock -->
                <div class="horizontal-container" style="width: 280px; align-items: center;">
                    <span>No. of stock</span>
                    <input type="number" name="quantity" id="setQuantity" value="1" min="1" style="border: 1.5px solid black; height: 30px; width: 70px; vertical-align: middle;">
                </div>
                <!-- Vendor dropdown -->
                <select name="vendor" class="edititem-dropdowns" id="dropdown" onChange="setSelectionColour" required>
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
                    <select name="prodtype" class="edititem-dropdowns" id="dropdown" onChange="setSelectionColour">
                        <option value="" style="color: gray;" disabled selected hidden>Product type</option>
                        <?php
                            include('db/prodtypelist.php');
                        ?>
                    </select>
                    <!-- Edit button -->
                    <button class="edititem-buttons">Edit product types</button>
                </div>

                <!-- Product category -->
                <div class="horizontal-container" style="width: 398px">
                    <!-- Dropdown -->
                    <select name="prodcat" class="edititem-dropdowns" id="dropdown" onChange="setSelectionColour">
                        <option value="" style="color: gray;" disabled selected hidden>Category</option>
                        <?php
                            include('db/categorylist.php');
                        ?>
                    </select>
                    <!-- Edit button -->
                    <button class="edititem-buttons">Edit categories</button>
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

            // configuring dropdown colour (setting placeholder to grey)
            function setSelectionColour() {
                const dropdown = document.getElementById('dropdown');

                if (dropdown.value === '') {
                    dropdown.style.color = "gray";
                } else {
                    dropdown.style.color = "black";
                }
            }

            // running the function when the page loads
            setSelectionColour();
        </script>
    </body>
</html>