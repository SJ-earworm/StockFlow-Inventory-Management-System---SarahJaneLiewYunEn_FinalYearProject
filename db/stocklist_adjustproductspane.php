<?php
    // debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require("dbConnect.php");
    // require("app_config/session_handling.php");
    session_start();
    $userID = $_SESSION['userID'];  // retrieving user ID

    // setting header for sending json data
    // header("Content-Type: application/json");
    // $jsondata = json_decode(file_get_contents("php://input"), true);
    // $selectedCategory = $jsondata['selectedCategory']; // category input

    // debugging
    $categoryID = $_REQUEST['assigncategory'];
    

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        // when search bar is used
        // retrieving search query input
        $searchInput = $_REQUEST['search'];
        $searchInputWithWildcards = '%'. $searchInput . '%';

        $query = "SELECT 
                p.productID,
                p.SKU,
                p.prod_name,
                pcl.categoryID  -- Product Category + Product Category Link linking --
            FROM 
                Product p
            JOIN
                Product_Category_Link pcl ON p.productID = pcl.productID
            WHERE
                p.storeID IN (
                    SELECT storeID 
                    FROM User 
                    WHERE userID = ?
                )
                AND 
                    pcl.categoryID = ?
                AND (
                    p.SKU LIKE ? OR
                    p.prod_name LIKE ?
                )
            ORDER BY p.prod_name ASC";  // selecting all the products 


        $stmt = $con->prepare($query);
        $stmt->bind_param("issssss", $userID, $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards, $searchInputWithWildcards);

    } else {
        $query = "SELECT 
                p.productID,
                p.SKU,
                p.prod_name,
                pcl.categoryID
            FROM 
                Product p
            JOIN
                Product_Category_Link pcl ON p.productID = pcl.productID
            WHERE
                p.storeID IN (
                    SELECT storeID 
                    FROM User 
                    WHERE userID = ?
                )
                AND 
                    pcl.categoryID = ?
                    
            ORDER BY p.prod_name ASC";  // selecting all the products 

        
        // default query
        $stmt = $con->prepare($query);
        $stmt->bind_param("ii", $userID, $categoryID);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    // function for collecting html scripts before sending to frontend (start buffering output, instead of sending it over to fronted immediately)
    // ob_start();
    $response = [];

    if (mysqli_num_rows($result) > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="mng-stock-grid row" style=" padding: 10px; height: 14px;">';
            echo '  <span class="grid-element">' . $row['SKU'] . '</span>';  // SKU
            echo '  <span class="grid-element">' . $row['prod_name'] . '</span>';  // Product Name
            echo '</div>';

            echo '<hr class="list-divider">';

            // debugging: force exit loop after printing 1 row
            // break;
        }

        $htmloutput = ob_get_clean(); // retrieving HTML output & cleaning buffer/data from ob_start()
        $response['status'] = 'success';
        $response['message'] = $htmloutput;  // sending the SKU & product name thru response[]
        // echo json_encode($response);
        die();  // debugging
    } else {
        $response['status'] = 'fail';
        $response['message'] = "Couldn't retrieve output: " . mysqli_error($con) . " why cannot join asjdflkajsdf";
        echo "Error: " . mysqli_error($con);
        // echo json_encode($response);
        // echo "Couldn't retrieve output: " . mysqli_error($con) . "<br/>";
        die();  // debugging
    }

    // $htmloutput = ob_get_clean();
    // echo $htmloutput;
    exit;
?>