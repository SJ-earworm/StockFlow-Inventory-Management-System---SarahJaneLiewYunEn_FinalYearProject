<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>New Purchase Order</title>

        <!--css stylesheet-->
        <link rel="stylesheet" type="text/css" href="style.css">

        <!-- settings icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- magnifying glass icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!-- trash, edit icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- close button -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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

        <?php
            require("db/importpurchaseorderdetails.php");
        ?>
        
        <!-- Page title -->
        <div class="main-content">
            <div style="position: fixed; height: 79%; width: 88%; margin-left: 0px;">
                <!-- TITLE + CREATE PURCHASE ORDER BUTTON + SEARCH FILTER -->
                <div class="above-col-header" style="justify-content: space-between; width: 100%; margin: 0px auto;">
                    <!-- page title -->
                    <h1 style="padding-left: 0.3%; margin-bottom: 10px;">New Purchase Order</h1>
                    <h2 style="margin-top: 15px;">Purchase Order: PO_1</h2>
                </div>

                <!-- PURCHASE ORDER SECTION -->
                <div class="main-space-area npo-text vertical-container" style="overflow-x: hidden; overflow-y: auto;">
                    <!-- date created + staff on duty + vendor + deliver by -->
                    <div class="initial-details horizontal-container">
                        <div class="vertical-container" style="width: 420px;">
                            <!-- DATE -->
                            <div class="horizontal-container" style="width: 330px; margin-bottom: 5px">
                                <label>Date created:</label>
                                <input type="text" value="<?php echo date('d-m-Y') ?>" style="color: black; font-size: 18px; border: none; background-color: transparent; padding-left: 5px;" disabled />
                            </div>

                            <!-- STAFF ON DUTY -->
                            <div class="horizontal-container" style="margin-bottom: 5px;">
                                <label style="margin-left: 4px;">Staff on duty:</label>
                                <input type="text" value="<?php echo $username ?>" style="color: black; font-size: 18px; border: none; padding-left: 0px; margin-left: 4px;" disabled />
                            </div>
                        </div>

                        <div class="vertical-container" style="width: 420px;">
                            <!-- VENDOR -->
                            <div class="horizontal-container" style="align-items: center; margin-bottom: 5px">
                                <label>Vendor:</label>
                                <select style="color: black; font-size: 18px;">
                                    <?php
                                        foreach ($vendors as $vendor) {
                                            echo '<option value="' . $vendor['vendorID'] . '">' . $vendor['vendorName'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <!-- DELIVER BY -->
                            <div class="horizontal-container" style="align-items: center; margin-botom: 5px;">
                                <label style="margin-left: 4px;">Deliver by:</label>
                                <input type="date" value="<?php echo date('Y-m-d'); ?>" style="color: black; font-size: 18px; margin: 2px 0px 0px 4px;" />
                            </div>
                        </div>
                    </div>


                    <!-- purchase order table -->
                    <div class="npo-table" role="region" tabindex="0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Product Name</th>
                                    <th>QTY</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php
                                    for ($x = 0; $x < 4; $x++) {
                                        echo '<tr>';
                                        echo '    <td contenteditable="true" oninput="updateHiddenInput(this, code' .$x. ')" id="tdcode' .$x. '" onclick="togglePSelPanel()"></td>';
                                        echo '    <input type="hidden" name="itemcode_' .$x. '" id="code' .$x. '" />';

                                        echo '    <td contenteditable="true" oninput="updateHiddenInput(this, pname' .$x. ')" id="tdpname' .$x. '" onclick="togglePSelPanel()"></td>';
                                        echo '    <input type="hidden" name="pname_' .$x. '" id="pname' .$x. '" />';

                                        echo '    <td contenteditable="true" oninput="updateHiddenInput(this, qty' .$x. ')" id="tdqty' .$x. '"></td>';
                                        echo '    <input type="hidden" name="qty_' .$x. '" id="qty' .$x. '" />';

                                        echo '    <td contenteditable="true" oninput="updateHiddenInput(this, uprice' .$x. ')" id="tduprice' .$x. '"></td>';
                                        echo '    <input type="hidden" name="uprice_' .$x. '" id="uprice' .$x. '" />';

                                        echo '    <td contenteditable="true" oninput="updateHiddenInput(this, totprice' .$x. ')" id="tdtotprice' .$x. '"></td>';
                                        echo '    <input type="hidden" name="totprice_' .$x. '" id="totprice' .$x. '" />';
                                        echo '</tr>';
                                    }
                                ?>

                                <!-- <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <button class="add-field-btn" onclick="addRow()">Add field+</button>

                    <!-- create purchase order button -->
                    <button class="create-po-btn">Create purchase order</button>
                </div>
            </div>
        </div>


        <!-- item select panel -->
        <div id="pselectPanel" class="pselect-panel-po">
            <!-- close panel button -->
            <div style="position: relative; left: 44%; margin: -40px 0px 20px; cursor: pointer;" onclick="togglePSelPanel()"><i class="material-icons" style="font-size: 37px">close</i></div>
            <!-- pane title + search bar -->
            <div class="horizontal-container" style="width: 95%; justify-content: space-between;">
                <!-- title -->
                <h3 style="font-size: 35px; text-align: left; margin-bottom: 15px;">Product<h3>
                <!-- search bar -->
                <form action="" method="get" class="search-filter-div-po" style="left: 2%">
                    <!-- Search bar -->
                    <i class='fas fa-search' style="left: 1%; margin-top: 8px; font-size: 12px"></i>
                    <input type="text" name="search" placeholder="Search" autocomplete="off" class="list-search-bar-po" style="padding: 7px 0px; padding-left: 24px;">
                    <!-- Filter button -->
                    <i class="fas fa-filter" style="font-size: 16px; left: -9px"></i>
                </form>
            </div>
            <div class="horizontal-container" style="justify-content: space-between; width: 870px;">
                <!-- product type pane CHECKBOXES -->
                <div id="ptypeCheckboxes" class="po-ptype-pane">
                    <div class="po-ptype-pane-header"><span style="background-color: transparent;">Product types</span></div>
                    <?php
                        include("db/prodtypelist_po.php");
                    ?>
                </div>
                <!-- product pane -->
                <div class="po-prod-pane">
                    <!-- Orange header line 1 -->
                <hr class="col-header-ln-1" style="border: 2px solid #FA673E">
                <div class="po-grid" style="margin: 0 2.7%;">
                    <!-- Column headers -->
                    <span>Product Name</span>
                    <span>Stock Keeping Unit</span>
                    <span>Brand</span>
                </div>
                <hr class="col-header-ln-1" style="border: 2px solid #FA673E">
                    <div id="stockListParent" class="po-prod-list-space">
                        <?php
                            include("db/stocklist_po.php");
                        ?>
                    </div>
                </div>
            </div>

            <button id="selectProduct" onclick="setTdData()" style="background-color: #FA673E; color: white; border: none; border-radius: 30px; padding: 10px 15px; position: relative; bottom: -4%; left: 39.5%; font-size: 18px">Select item</button>
        </div>
        <!-- overlay in the bg when panel is opened -->
        <div id="overlay" class="bg-overlay"></div>


        <!-- Javascript -->
        <script>
            // copying user input into the hidden input fields
            // CONTINUE HERE

            // add table row
            let rowCount = 4;  // starting count from 4
            function addRow() {
                const tableBody = document.getElementById('tbody');

                // creating new row
                const createRow = document.createElement('tr');
                createRow.innerHTML = `
                    <td contenteditable="true" oninput="updateHiddenInput(this, code${rowCount})" id="tdcode${rowCount}" onclick="togglePSelPanel()"></td>
                    <input type="hidden" name="itemcode_${rowCount}" id="code${rowCount}" />

                    <td contenteditable="true" oninput="updateHiddenInput(this, pname${rowCount})" id="tdpname${rowCount}" onclick="togglePSelPanel()"></td>
                    <input type="hidden" name="pname_${rowCount}" id="pname${rowCount}" />

                    <td contenteditable="true" oninput="updateHiddenInput(this, qty${rowCount})" id="tdqty${rowCount}"></td>
                    <input type="hidden" name="qty_${rowCount}" id="qty${rowCount}" />

                    <td contenteditable="true" oninput="updateHiddenInput(this, uprice${rowCount})" id="tduprice${rowCount}"></td>
                    <input type="hidden" name="uprice_${rowCount}" id="uprice${rowCount}" />

                    <td contenteditable="true" oninput="updateHiddenInput(this, totprice${rowCount})" id="tdtotprice${rowCount}"></td>
                    <input type="hidden" name="totprice_${rowCount}" id="totprice${rowCount}" />
                `;

                // append row to the table
                tableBody.appendChild(createRow);
                // increase counter
                rowCount++;
            }


            // toggle visible/invisible product select panel
            function togglePSelPanel() {
                const pselectPanel = document.getElementById('pselectPanel');
                const overlay = document.getElementById('overlay');

                if (pselectPanel.style.visibility === 'hidden') {
                    pselectPanel.style.visibility = 'visible';
                    overlay.style.visibility = 'visible';

                } else {
                    pselectPanel.style.visibility = 'hidden';
                    overlay.style.visibility = 'hidden';
                }
            }


            // retrieving clicked row + productID
            document.getElementById('stockListParent').addEventListener('click', (event) => {
                // checking if clicked item has .po-grid-row class
                if (event.target.closest('.po-grid-row')) {
                    // remove the 'select' effect from all rows
                    document.querySelectorAll('.po-grid-row').forEach(row => {
                        row.style.backgroundColor = 'transparent';
                    });

                    // retrieving clicked element (row)
                    const clickedRow = event.target.closest('.po-grid-row');
                    const productID = clickedRow.getAttribute('data-product-id');  // retrieving the productID held by the custom 'value holder'

                    // highlighting row
                    clickedRow.style.backgroundColor = "#fa673e55";
                    // passing productID to 'Select item' button
                    document.getElementById('selectProduct').value = productID;

                    // debugging
                    console.log('productID clicked:' + productID);
                } else {
                    console.log("row wasn't clicked");
                }
            });


            // inserting clicked product into table row
            function setTdData() {

            }

            
            // prodtype checkbox filtering
            document.getElementById('ptypeCheckboxes').addEventListener('click', (event) => {
                // checking if clicked item is a checkbox
                if (event.target.type === 'checkbox') {
                    // retrieving checkbox value (prodtypeID)
                    const prodtypeID = event.target.value;
                    // putting into form data
                    const formData = {
                        prodtypeID: prodtypeID
                    };
                    console.log(formData);

                    // return prodtype filter
                    fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/prodtypelist_po.php', {
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
            });



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