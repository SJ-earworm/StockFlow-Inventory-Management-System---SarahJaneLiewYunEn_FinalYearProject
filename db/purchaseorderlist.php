<?php
    require("dbConnect.php");
    require("app_config/session_handling.php");

    $query = "SELECT orderID FROM Purchase_Order WHERE storeID = (SELECT storeID FROM User WHERE userID = ?) ORDER BY orderID DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<ul class="po-pane-ul" data-orderID="' .$row['orderID']. '">PO_' .$row['orderID']. '</ul>';
        }
    }
?>