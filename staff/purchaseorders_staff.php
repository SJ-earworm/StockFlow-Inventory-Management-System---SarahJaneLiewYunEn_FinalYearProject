<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>Purchase Orders</title>

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
            include("web_components/staff_header.php");
        ?>

        <!-- temporary, for debugging -->
        <?php
            // echo "logged in user: " . $userID . "</br>";
        ?>
        
        <!-- Page title -->
        <div class="main-content">
            <div style="position: fixed; height: 79%; width: 88%; margin-left: 0px;">
                <!-- TITLE + CREATE PURCHASE ORDER BUTTON + SEARCH FILTER -->
                <div class="above-col-header">
                    <!-- page title -->
                    <h1 style="padding-left: 0.3%; margin-bottom: 10px;">Purchase Orders</h1>

                    <!-- buttons -->
                    <div class="item-cat-btn-div" style="width: 250px; left: 36%;">
                        <!-- Add item button-->
                        <a href="newpurchaseorder.php" style="margin: 0; padding: 0; text-decoration: none;">
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

                <div class="main-space-area horizontal-container" style="justify-content: space-between;">
                    <!-- PURCHASE ORDER PANE -->
                    <div class="purchase-order-list-pane">
                        <div class="po-pane-header"><span style="margin-left: 18px; background-color: transparent;">Orders</span></div>
                        <!-- purchase order list -->
                        <li class="po-pane-list-area">
                            <?php
                                include("db/purchaseorderlist.php");
                            ?>
                        </li>
                    </div>

                    <!-- PURCHASE ORDER VIEWER -->
                    <div id="poViewer" class="po-viewer vertical-container" style="display: flex; flex-direction: column;">
                        <div class="initial-details horizontal-container" style="margin: 20px 0px 30px 2px">
                            <div class="vertical-container" style="width: 420px;">
                                <!-- DATE -->
                                <div class="horizontal-container" style="width: 330px; margin-bottom: 15px">
                                    <label>Date created:</label>
                                    <span id="dateCreated">Date created</span>
                                </div>
                                <!-- VENDOR -->
                                <div class="horizontal-container" style="align-items: center; margin-bottom: 5px">
                                    <label>Vendor:</label>
                                    <span id="vendorName">vendor name</span>
                                </div>
                            </div>

                            <div class="vertical-container" style="width: 420px;">
                                <!-- DELIVER BY -->
                                <div class="horizontal-container" style="align-items: center; margin-botom: 5px;">
                                    <label style="margin-left: 4px;">Deliver by:</label>
                                    <span id="deliverBy">Date</span>
                                </div>
                            </div>
                        </div>

                        <div class="po-table" role="region" tabindex="0">
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
                                            echo '    <td id="tdcode' .$x. '" data-prodattribute="itemcode" onclick="togglePSelPanel(this)"></td>';
                                            // echo '    <input type="hidden" name="itemcode_' .$x. '" id="hiddencode' .$x. '" />';

                                            echo '    <td id="tdpname' .$x. '" data-prodattribute="prodname" onclick="togglePSelPanel(this)"></td>';
                                            // echo '    <input type="hidden" name="pname_' .$x. '" id="hiddenpname' .$x. '" />';

                                            echo '    <td oninput="autoupdateTotalPrice(this)" data-prodattribute="quantity" id="tdqty' .$x. '"></td>';
                                            // echo '    <input type="hidden" name="qty_' .$x. '" id="hiddenqty' .$x. '" />';

                                            echo '    <td id="tduprice' .$x. '" data-prodattribute="unitprice"></td>';
                                            // echo '    <input type="hidden" name="uprice_' .$x. '" id="hiddenuprice' .$x. '" />';

                                            echo '    <td id="tdtotprice' .$x. '" data-prodattribute="extprice"></td>';
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
                    </div>
                </div>
            </div>
        </div>


        <!-- Javascript -->
        <script>
            // setting active PO list (PO panel)
            document.querySelectorAll('.po-pane-ul').forEach(ul => {
                // adding click listner for each <ul>
                ul.addEventListener('click', () => {
                    // removing .active from all <ul>
                    document.querySelectorAll('.po-pane-ul').forEach(ulRemoveActive => {
                        ulRemoveActive.classList.remove('active');
                    });

                    // adding .active to the clicked <ul>
                    ul.classList.add('active');

                    // retrieving orderID from the clicked item
                    const orderID = ul.getAttribute('data-orderID');

                    fetch(`http:/StockFlow IMS (FINAL YEAR PROJECT)/db/loadpurchaseorder_db.php?orderID=${orderID}`)
                    .then(response => response.json())
                    .then(data => {
                        const { po, orderdetails } = data;
                        console.log(data);

                        // clearing main PO details first
                        document.getElementById('dateCreated').innerHTML = '';
                        document.getElementById('vendorName').innerHTML = '';
                        document.getElementById('deliverBy').innerHTML = '';

                        // populating main PO details
                        document.getElementById('dateCreated').innerHTML = po.date_ordered;
                        document.getElementById('vendorName').innerHTML = po.name;  // vendor name
                        document.getElementById('deliverBy').innerHTML = po.deadline;

                        // display table
                        // const poDisplay = document.getElementById('poViewer');
                        // if (poDisplay.style.visibility === 'hidden') {
                        //     poDisplay.style.visibility = 'visible';
                        // } else if (poDisplay.style.visibility === 'visible') {
                        //     poDisplay.style.visibility = 'hidden';
                        // }

                        fillTable(orderdetails, po.order_total);
                    })
                    .catch(error => console.error("Couldn't fetch table data", error));
                });
            });

            // function for filling table with PO data
            function fillTable(orderdetails, orderTotal) {
                const table = document.getElementById('tbody');
                table.innerHTML = '';  // clearing table data first

                orderdetails.forEach(rowIteration => {
                    // creating <tr>
                    const row = document.createElement('tr');

                    const itemcodeTd = document.createElement('td');
                    itemcodeTd.innerHTML = rowIteration.newitemSKU;

                    const prodnameTd = document.createElement('td');
                    prodnameTd.innerHTML = rowIteration.prod_name;

                    const qtyTd = document.createElement('td');
                    qtyTd.innerHTML = rowIteration.quantity;

                    const upriceTd = document.createElement('td');
                    upriceTd.innerHTML = rowIteration.unit_price;

                    const extpriceTd = document.createElement('td');
                    extpriceTd.innerHTML = rowIteration.extended_price;

                    // appending each <td> to the <tr>
                    row.appendChild(itemcodeTd);
                    row.appendChild(prodnameTd);
                    row.appendChild(qtyTd);
                    row.appendChild(upriceTd);
                    row.appendChild(extpriceTd);

                    // append the row to the table
                    table.appendChild(row);
                });
                // displaying total amount
                const orderTotalRow = document.createElement('tr');
                const orderTotalCell = document.createElement('td');
                orderTotalCell.setAttribute('colspan', 5);
                orderTotalCell.style.textAlign = 'right';
                orderTotalCell.innerHTML = 'Total: RM' + orderTotal;

                orderTotalRow.appendChild(orderTotalCell);
                table.appendChild(orderTotalRow);
            }
        </script>
    </body>
</html>