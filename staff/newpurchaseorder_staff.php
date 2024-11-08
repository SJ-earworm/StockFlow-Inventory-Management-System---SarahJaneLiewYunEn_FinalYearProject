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
            include("web_components/staff_header.php");
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
                                <input type="date" value="<?php echo date('Y-m-d'); ?>" id="dateCreated" style="color: black; font-size: 18px; background-color: transparent; padding-left: 5px;" />
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
                                <select id="vendor" style="color: black; font-size: 18px;">
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
                                <input type="date" value="<?php echo date('Y-m-d', strtotime('+3 week')); ?>" id="deliverBy" style="color: black; font-size: 18px; margin: 2px 0px 0px 4px;" />
                            </div>                             <!-- pre-selecting date 3 weeks from now -->
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
                                    <th>Unit Price (RM)</th>
                                    <th>Total (RM)</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php
                                    for ($x = 0; $x < 4; $x++) {
                                        echo '<tr>';                                                                                             // data-prodattribute as the key in the key-value pair during saving-to-db-sequence
                                        echo '    <td contenteditable="true" id="tdcode' .$x. '" data-prodattribute="itemcode" onclick="togglePSelPanel(this)"></td>';
                                        // echo '    <input type="hidden" name="itemcode_' .$x. '" id="hiddencode' .$x. '" />';

                                        echo '    <td contenteditable="true" id="tdpname' .$x. '" data-prodattribute="prodname" onclick="togglePSelPanel(this)"></td>';
                                        // echo '    <input type="hidden" name="pname_' .$x. '" id="hiddenpname' .$x. '" />';

                                        echo '    <td contenteditable="true" oninput="autoupdateTotalPrice(this)" data-prodattribute="quantity" id="tdqty' .$x. '"></td>';
                                        // echo '    <input type="hidden" name="qty_' .$x. '" id="hiddenqty' .$x. '" />';

                                        echo '    <td contenteditable="true" id="tduprice' .$x. '" data-prodattribute="unitprice"></td>';
                                        // echo '    <input type="hidden" name="uprice_' .$x. '" id="hiddenuprice' .$x. '" />';

                                        echo '    <td contenteditable="true" id="tdtotprice' .$x. '" data-prodattribute="extprice"></td>';
                                        // echo '    <input type="hidden" name="totprice_' .$x. '" id="hiddentotprice' .$x. '" />';
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
                    <button class="create-po-btn" onclick="createPurchaseOrder()">Create purchase order</button>
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
                <h3 style="font-size: 35px; text-align: left; margin-bottom: 15px;">Product</h3>
                <!-- search bar -->
                <form action="" method="get" class="search-filter-div-po" style="left: 2%" onkeydown="preventClosePanel(event)">
                    <!-- Search bar -->
                    <i class='fas fa-search' id="searchField" style="left: 1%; margin-top: 8px; font-size: 12px"></i>
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
                    <td contenteditable="true" id="tdcode${rowCount}" data-prodattribute="itemcode" onclick="togglePSelPanel(this)"></td>

                    <td contenteditable="true" id="tdpname${rowCount}" data-prodattribute="prodname" onclick="togglePSelPanel(this)"></td>

                    <td contenteditable="true" oninput="autoupdateTotalPrice(this)" id="tdqty${rowCount}" data-prodattribute="quantity"></td>

                    <td contenteditable="true" id="tduprice${rowCount}" data-prodattribute="unitprice"></td>

                    <td contenteditable="true" id="tdtotprice${rowCount}" data-prodattribute="extprice"></td>
                `;

                // append row to the table
                tableBody.appendChild(createRow);
                // increase counter
                rowCount++;
            }


            // for pselectPanel
            const pselectPanel = document.getElementById('pselectPanel');
            const overlay = document.getElementById('overlay');

            // toggle visible/invisible product select panel
            function togglePSelPanel(td) {
                if (pselectPanel.style.visibility === 'hidden') {
                    pselectPanel.style.visibility = 'visible';
                    overlay.style.visibility = 'visible';

                } else {
                    pselectPanel.style.visibility = 'hidden';
                    overlay.style.visibility = 'hidden';
                }

                // retrieving <td> id
                const tdID = td.id;
                console.log('td clicked (togglePSelPanel): ' + tdID);
                document.getElementById('selectProduct').setAttribute('data-tdId', tdID);
            }


            // preventing submitting search query from closing panel
            function preventClosePanel(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();

                    // retrieving search query value
                    const searchQuery = document.getElementById('searchField').value.toLowerCase();

                    // simulating search thru hiding irrelevant items
                    const prodlist = document.querySelectorAll('.po-grid-row .po-grid');
                    prodlist.forEach(product => {
                        if (product.innerText.toLowerCase().includes(searchQuery)) {
                            product.style.display = '';
                        } else {
                            product.style.display = 'none';
                        }
                    });
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
                    // const productID = JSON.parse(clickedRow.dataset.productPOAutofill);  // retrieving the productID held by the custom 'value holder'
                    const selectedProduct = {
                        SKU: clickedRow.dataset.productSku,
                        prod_name: clickedRow.dataset.productProdname,
                        unit_price: clickedRow.dataset.productUprice,
                        brand_as_key: clickedRow.dataset.productBrandaskey
                    };
                    console.log(clickedRow.dataset.productSku);
                    console.log(clickedRow.dataset.productProdname);
                    console.log(clickedRow.dataset.productUprice);
                    console.log(clickedRow.dataset.productBrandaskey);
                    // console.log(clickedRow.dataset);

                    // highlighting row
                    clickedRow.style.backgroundColor = "#fa673e55";
                    // passing product to 'Select item' button
                    document.getElementById('selectProduct').setAttribute('data-product', JSON.stringify(selectedProduct));

                    // debugging
                    // console.log('productID clicked:' + productID);
                    // console.log(productID);
                    // console.log(productID.SKU);
                } else {
                    console.log("row wasn't clicked");
                }
            });


            // var for holding total price per item
            // let total = '';

            // inserting clicked product into table row
            function setTdData() {
                const selectedProduct = JSON.parse(document.getElementById('selectProduct').getAttribute('data-product'));
                const insertTD = document.getElementById('selectProduct').getAttribute('data-tdId');
                // debugging
                console.log('product: ' + selectedProduct.SKU);
                console.log('td insert: ' + insertTD);

                // extracting td id index (number)
                const tdIndexExtract = insertTD.match(/\d+/)[0];  // /\d+/ is an expression in js for finding numeric characters in a string   '\d' = mathes any digit from 0-9    '+' = allowing to match more individual digits (e.g. itemcode15 = '15' detected)
                                                                  // [0] takes the first full number match (e.g. captures '15' not just '1')
                                                    
                // inserting product data into <td>
                const itemcode = document.getElementById(`tdcode${tdIndexExtract}`);
                itemcode.innerHTML = '';  // clearing previous text
                itemcode.innerHTML = selectedProduct.SKU;

                const prodname = document.getElementById(`tdpname${tdIndexExtract}`);
                prodname.innerHTML = '';  // clearing previous text
                prodname.innerHTML = selectedProduct.prod_name;

                const unitprice = document.getElementById(`tduprice${tdIndexExtract}`);
                unitprice.innerHTML = '';
                unitprice.innerHTML = selectedProduct.unit_price;

                const defaultQty = document.getElementById(`tdqty${tdIndexExtract}`);
                defaultQty.innerHTML = '';
                defaultQty.innerHTML = 1;

                // passing in product brand to the productname td for backend query parameter
                prodname.setAttribute('data-brandAsKey', selectedProduct.brand_as_key);


                // autofill initial total price
                document.getElementById(`tdtotprice${tdIndexExtract}`).innerHTML = selectedProduct.unit_price;

                // close panel
                pselectPanel.style.visibility = 'hidden';
                overlay.style.visibility = 'hidden';
            }

            // calculate + auto update total price
            function autoupdateTotalPrice(qtyInput) {
                // const qtyInput = document.getElementById('');
                console.log(qtyInput.innerHTML);
                let qty = qtyInput.innerHTML;
                // const qtyFiltered = qty;
                // const defaultQty = 0;

                // extracting <td> id index
                const tdIndexExtractTOT = qtyInput.id.match(/\d+/)[0];

                // resetting input to 1 if field is empty or '0'Z
                if (qty < '1' || qty == '') {
                    // qtyInput.innerHTML = '1';
                    // defaultQty = 1
                    // qtyFiltered = defaultQty;
                    $qty = '1';
                    $qtyInput.innerHTML = '1';
                }

                // calculating total price & updating total price <td>
                const total = qty * document.getElementById(`tduprice${tdIndexExtractTOT}`).innerText;
                document.getElementById(`tdtotprice${tdIndexExtractTOT}`).innerHTML = '';  // clearing <td> first
                document.getElementById(`tdtotprice${tdIndexExtractTOT}`).innerHTML = total.toFixed(2);  // setting 2 decimal places for total
                console.log('total: ' + total);
            }

            
            // INSERTING PO TO DB
            // gathering the rows of data into arrays
            function compileFieldsArray() {
                const allRows = [];  // array for storing each compiled row
                let total_total = 0  // for final total accumulation
                let data = false  // to check if row has data

                // selecting all <tr> within <tbody>
                document.querySelectorAll('#tbody tr').forEach(row => {
                    const oneRow = {};  // object for storing key-value pairs from each td

                    // focusing on the <td>, looping thru each <td>
                    row.querySelectorAll('td').forEach(td => {
                        const key = td.getAttribute('data-prodattribute');  // retrieving the key name (key-value pair)
                        const value = td.innerHTML;  // inserting key-value pair into oneRow{} object

                        if (value) {
                            data = true  // data exists
                            // if (!data) {
                            //     return;  // end iteration of no value pulled from <td>
                            // }
                            // (contiuing if value exists)
                            // assigning value to its key
                            oneRow[key] = value;

                            // retrieving prodname <td>'s data-brandAsKey attribute
                            if (td.hasAttribute('data-brandAsKey')) {
                                oneRow['brandAsKey'] = td.getAttribute('data-brandAsKey');
                            }

                            // accumulating total-total (the final total)
                            if (key == 'extprice')
                            total_total += td.innerHTML;
                        }
                    });
                    
                    if (!data) {
                        return;  // end iteration if no value was pulled from <td>
                    }
                    allRows.push(oneRow);  // adding/appending the oneRow{} object to the allRows[] array
                });

                return { allRows, total_total };  // sending out allRows[] to the calling function
            }


            // sending to backend
            function createPurchaseOrder() {
                // retrieve date created, vendor name, deliver by
                const dateCreated = document.getElementById('dateCreated').value;
                const vendorID = document.getElementById('vendor').value;
                const deliverBy = document.getElementById('deliverBy').value;

                const { allRows, total_total } = compileFieldsArray();  // retrieving allRows[] from previous function

                const formData = {
                    datecreated: dateCreated,
                    vendorID: vendorID,
                    deliverby: deliverBy,
                    allrows: allRows,
                    totalamount: total_total
                };
                console.log(formData);
                // debugging, breakpoint
                // debugger;

                fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/createpurchaseorder_db.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.text())
                .then(data => {
                    // 1st insert
                    if (data.status1 == 'success') {
                        console.log(data.message1);
                    } else if (data.status1 == 'fail') {
                        console.log(data.message1);
                        console.log(data.log1);
                    }

                    // 2nd insert
                    if (data.status2 == 'success') {
                        console.log(data.message2);
                        // redirecting to purchaseorders.php
                        window.location.href = 'purchaseorders.php';
                    } else if (data.status2 == 'fail') {
                        console.log(data.message2);
                        console.log(data.log2);
                    }

                    // redirecting to purchaseorders.php
                    window.location.href = 'purchaseorders.php';
                    

                    // if (data.status1 === 'fail') {
                    //     console.error(data.message1, data.log1);
                    // } else {
                    //     console.log(data.message1);
                    // }

                    // if (data.status2 === 'fail') {
                    //     console.error(data.message2, data.log2);
                    // } else {
                    //     console.log(data.message2);
                    // }


                    // try {
                    //     const status = JSON.parse(data);

                    //     if (status.status == 'success') {
                    //         console.log(status.message);
                    //     } else {
                    //         console.log(status.message);
                    //         console.log(status.log);
                    //     }
                    // } catch (error) {
                    //     console.error('Error parsing JSON: ', error);
                    // }
                })
                .catch(error => console.error('Error: ', error));
            }
            
            // prodtype checkbox filtering
            // document.getElementById('ptypeCheckboxes').addEventListener('click', (event) => {
            //     // checking if clicked item is a checkbox
            //     if (event.target.type === 'checkbox') {
            //         // retrieving checkbox value (prodtypeID)
            //         const prodtypeID = event.target.value;
            //         // putting into form data
            //         const formData = {
            //             prodtypeID: prodtypeID
            //         };
            //         console.log(formData);

            //         // return prodtype filter
            //         fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/prodtypelist_po.php', {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json'
            //             },
            //             body: JSON.stringify(formData)
            //         })
            //         .then(response => response.json())  // retrieving response from backend
            //         // .then(data => console.log(data))  // debugging
            //         .then(data => {
            //             const message = document.getElementById('successErrorStatus');

            //             if (data.status == 'success') {
            //                 // clear input field
            //                 this.catname.value = '';

            //                 message.innerHTML = data.message;
            //                 message.style.color = 'green';
            //                 message.style.backgroundColor = '#9CFFB0';
            //                 message.style.visibility = 'visible';
            //                 // hiding message after 3s
            //                 setTimeout(() => {
            //                     message.style.visibility = 'hidden';
            //                 }, 3000);
            //             } else {
            //                 message.innerHTML = data.message;
            //                 message.style.color = 'black';
            //                 message.style.backgroundColor = '#FF9999';
            //                 message.style.visibility = 'visible';
            //                 // hiding message after 3s
            //                 setTimeout(() => {
            //                     message.style.visibility = 'hidden';
            //                 }, 3000);

            //                 // logging backend error to console
            //                 console.log(data.log);
            //             }
            //         })
            //         .catch(error => console.error('Error: ', error));
            //     }
            // });



            // NEW CATEGORY NAME: form submission
            // document.getElementById('newCategoryForm').addEventListener('submit', function(e) {
            //     e.preventDefault();  // preventing default submit sequence

            //     // creating FormData object for the target form
            //     // const formData = new FormData(this);
            //     // note: FormData is a js object that automatically fetches all the form data in key-value pairs
            //     //       (especially if you have many fields) so you won't have to manually retrieve each input value

            //     // manually putting form data into an object to be sent over to backend
            //     const formData = {
            //         newcatname: this.catname.value
            //     };
            //     console.log(formData);

            //     // sending form data to backend file
            //     fetch('http:/StockFlow IMS (FINAL YEAR PROJECT)/db/addnewcategory_db.php', {
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

            //         if (data.status == 'success') {
            //             // clear input field
            //             this.catname.value = '';

            //             message.innerHTML = data.message;
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
            //             console.log(data.log);
            //         }
            //     })
            //     .catch(error => console.error('Error: ', error));
            // });
        </script>
    </body>
</html>