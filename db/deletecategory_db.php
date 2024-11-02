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
        $categoryID = $input['deleteCatID'];

        $query = "DELETE FROM Product_Category WHERE categoryID = ?";
        
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $categoryID);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Category deleted';
            
        } else {
            $response['status'] = 'fail';
            $response['message'] = "Couldn't delete category";
            $response['log'] = mysqli_error($con);

            // echo 'failed to insert new category name: ' . mysqli_error($con);
            // die();
        }

        echo json_encode($response);
        // header("Location: ../managestocks.php");
        exit;
    }
?>