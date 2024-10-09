<?php
    require("db/dbConnect.php");
?>

<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>Sign Up: Stockflow</title>

        <!--css stylesheet-->
        <link rel="stylesheet" type="text/css" href="style.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!-- Logo + Sign Up title -->
        <div style="display: flex; justify-content: center; align-item: center; margin-left: -2.7%;">
            <div style="display: flex; align-items: center;">
                <img src="images/logo_light.png"/> <!-- add this to img for testing -> style="border: 1px solid blue" -->
                <span style="margin-top: 2%; font-size: 410%; font-weight: 700;">Sign Up</span>
            </div>
        </div>

        <!-- Input fields -->
        <form action="db/signup_db.php" method="post" style="margin: 0 auto; width: 25%;">
            <!-- Store name -->
            <input type="text" name="storename" placeholder="Store Name" autocomplete="off" required />
            <span>
                <!-- User name -->
                <input type="text" name="username" placeholder="User Name" style="height: 40px; width: 72.6%;" autocomplete="off" required />
                <!-- User type -->
                <select name="usertype" style="height: 40px; width: 26%;" required >
                    <option value="" disabled selected hidden>User type</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                </select>
            </span>
            <!-- Email -->
            <input type="text" name="email" placeholder="Email" autocomplete="off" required />
            <!-- Password -->
            <div class="password-container">
                <input type="password" name="password" id="psword" placeholder="Password" autocomplete="off" required />
                <i><img src="images/eye-solid.png" id="showPassword" onclick="passwordVisibility()" style="max-width: 20px; color: grey; position: absolute; right: 38.5%; margin-top: 0.7%" /></i>
            </div>
            <!-- Confirm Password -->
            <div class="password-container">
                <input type="password" name="confirmpassword" id="psword" placeholder="Confirm Password" autocomplete="off" required />
                <i><img src="images/eye-solid.png" id="showPassword" onclick="passwordVisibility()" style="max-width: 20px; color: grey; position: absolute; right: 38.5%; margin-top: 0.7%" /></i>
            </div>
            <!-- Sign up button -->
            <button class="button-log-sign" style="height: 40px; width: 100%"><span class="btntext">Sign Up</span></button>
        </form>

        <!-- ADD PASSWORD STRENGTH -->
        <h1> PLS ADD PASSWORD STRENGTH VALIDATION</h1>

        <!-- Link to login.php -->
        <a href="login.php"><p align="center">Have an account? Log In instead</p></a>



        <!-- Javascript -->
        <script>
            var eyecon = document.getElementById('showPassword');

            // toggle show password
            function passwordVisibility() {
                var password = document.getElementById('psword');
                if (password.type === 'password') {
                    password.type = 'text';
                    eyecon.src = 'images/eye-slash-solid.png';
                    eyecon.style = 'max-width: 23px; color: grey; position: absolute; right: 38.45%; margin-top: 0.7%';
                } else {
                    password.type = 'password';
                    eyecon.src = 'images/eye-solid.png';
                    eyecon.style = 'max-width: 20px; color: grey; position: absolute; right: 38.5%; margin-top: 0.7%';
                }
            }
        </script>
    </body>
</html>