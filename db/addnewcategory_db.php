<?php
    require("dbConnect.php");
    session_start();

    // debugging
    // echo "you're viewing: addnewcategory_db";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // setting JSON header for sending status message to frontend
        header("Content-Type: application/json");
        // debugging
        // echo json_encode(['status' => 'success', 'message' => 'message went through']);
        // exit;
        // array for carrying status & message
        $response_msg = [];

        // retrieving userID
        $userID = $_SESSION['userID'];

        // retrieving user input
        $input = json_decode(file_get_contents('php://input'), true);  // extracting the key-value pairs sent over via JSON
        $category_name = $input['newcatname'];

        $query = "INSERT INTO Product_Category (category, storeID) SELECT ?, storeID FROM User WHERE userID = ?";
        
        $stmt = $con->prepare($query);
        $stmt->bind_param("si", $category_name, $userID);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Successfully added new category';
            
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Failed to add new category';
            $response['log'] = mysqli_error($con);

            // echo 'failed to insert new category name: ' . mysqli_error($con);
            // die();
        }

        echo json_encode($response);
        // header("Location: ../managestocks.php");
        exit;
    }
?>