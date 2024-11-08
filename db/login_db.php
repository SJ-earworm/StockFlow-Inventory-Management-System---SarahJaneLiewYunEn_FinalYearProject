<?php
    require("dbConnect.php");
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        // Retrieving user input data from signup.php form
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];


        // Only if password has been confirmed entered correctly
        if (!empty($email) && !empty($password)) {
            // test
            echo "started if condition <br/>";

            // Retrieving user password from db for verification
            // $query = "SELECT password, userID FROM User WHERE email = ?";
            $query = "SELECT password, userID, email FROM User WHERE email = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($dbpassword, $userID, $dbemail);

            if ($stmt->fetch()) {
                // Close db connection
                $stmt->close();

                // If email doesn't exist, stop login process
                if ($email !== $dbemail) {
                    echo "Email not found. <br/>";
                    die();
                }

                // test
                // echo "Hashed pw from db: " . $dbpassword . "<br/>";
                // echo "verifying password... <br/>";

                // Verifying password
                if (password_verify($password, $dbpassword)) {
                    // Password match
                    // Start session
                    session_start();
                    $_SESSION['userID'] = $userID;
                    header("Location: ../index.php");
                    die();
                } else {
                    echo "Incorrect password";
                }
            } else {
                echo "User not found";
            }
        } else {
            echo "Email or password field not filled out!";
        }
    }

?>