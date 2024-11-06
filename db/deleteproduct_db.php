<?php
    require("dbConnect.php");
    session_start();

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

        // retrieving productID to be deleted
        $input = json_decode(file_get_contents('php://input'), true);  // extracting the key-value pairs sent over via JSON
        $productID = $input['productID'];

        $query = "DELETE FROM Product WHERE productID = ?";
        
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $productID);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Successfully deleted product';
            
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Failed to delete product';
            $response['log'] = mysqli_error($con);

            // echo 'failed to insert new category name: ' . mysqli_error($con);
            // die();
        }

        echo json_encode($response);
        // header("Location: ../managestocks.php");
        exit;
    }
?>