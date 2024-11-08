<?php
    require("dbConnect.php");
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {


        // Retrieving user input data from signup.php form
        $store_name = $_REQUEST['storename'];
        $user_name = $_REQUEST['username'];
        $user_type = $_REQUEST['usertype'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $cpassword = $_REQUEST['confirmpassword'];


        // if password requirement is not met
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) 
            || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
                echo "Password did not meet requirement.";
                die();
            }


        // Checking if store exists
        $query = "SELECT COUNT(*) FROM Store WHERE name = ?";
        $stmt_store = $con->prepare($query);
        $stmt_store->bind_param("s", $store_name);
        $stmt_store->execute();
        $stmt_store->bind_result($strcount);
        $stmt_store->fetch();
        $stmt_store->close();
        if ($strcount < 1) {
            // Store does not exist message
            echo "Store not registered!";
            die();
        }


        // test
        // echo "Store count complete <br/>";


        // Checking if email exists
        $query = "SELECT COUNT(*) FROM User WHERE email = ?";
        $stmt_email = $con->prepare($query);
        $stmt_email->bind_param("s", $email);
        $stmt_email->execute();
        $stmt_email->bind_result($emcount);  // prepare to bind query result to created $count variable
        $stmt_email->fetch();  // query result returned from db
        $stmt_email->close();
        if ($emcount > 0) {
            // Email exists, use another email
            echo "Email exists! Please use another email.";
            die();
        }


        // test
        // echo "Email count complete <br/>";


        // Only if password has been confirmed entered correctly
        if ($password === $cpassword) {
            // PASSWORD HASHING & SALTING
            $hashedpw = password_hash($password, PASSWORD_BCRYPT);

            // Inserting into User table
            $query = "INSERT INTO User (name, user_type, email, password, storeID) 
                      SELECT ?, ?, ?, ?, storeID FROM Store WHERE name = ?";    // searching the Store table for the storeID based on store
                                                                                // name entered by user & linking the storeID to the User table

            $stmt_signup = $con->prepare($query);
            $stmt_signup->bind_param("sssss", $user_name, $user_type, $email, $hashedpw, $store_name);

            if ($stmt_signup->execute()) {

                // Close query statement
                $stmt_signup->close();

                // Redirecting to login page
                header("Location: ../login.php");
                die();
            } else {
                echo "Error: " . mysqli_error($con);
            }
            
        } else {
            echo "The passwords do not match.";
            die();
        }
    }

?>