<?php
    require("db/dbConnect.php");
?>

<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>Log In: Stockflow</title>

        <!--css stylesheet-->
        <link rel="stylesheet" type="text/css" href="style.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!-- Logo + Log In title -->
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin: 0px auto; width: 50%;">
            <div style="display: flex; flex-direction: row; justify-conent: space-between; width: 650px; align-items: center;">
                <img src="images/logo_light.png"/> <!-- add this to img for testing -> style="border: 1px solid blue" -->
                <span style="margin: 9px 0px 0px -10px; font-size: 410%; font-weight: 700;">Log In</span>
            </div>
        

            <!-- Input fields -->
            <form action="db/login_db.php" method="post" style="margin: 0 auto; width: 47%;">
                <!-- Email -->
                <input type="text" name="email" placeholder="Email" autocomplete="off" required />
                <!-- Password -->
                <div class="password-container">
                    <input type="password" name="password" id="psword" placeholder="Password" autocomplete="off" required />
                    <i><img src="images/eye-solid.png" id="showPassword" onclick="passwordVisibility()" style="max-width: 20px; color: grey; position: absolute; right: 37.8%; margin-top: 0.7%" /></i>
                </div>
                <button class="button-log-sign" style="height: 40px; width: 100%"><span class="btntext">Log In</span></button>
            </form>

            <!-- Link to signup.php -->
            <a href="signup.php" style="width: 100%; margin-top: 30px"><p align="center">Don't have an account? Sign up for one</p></a>
        </div>


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