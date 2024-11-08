<?php
    require("db/dbConnect.php");
?>

<!DOCTYPE html>
<html lang="utf=8">
    <head>
        <title>Sign Up: Stockflow</title>

        <!--css stylesheet-->
        <link rel="stylesheet" type="text/css" href="style.css">

        <!-- icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <!-- Logo + Sign Up title -->
        <div style="display: flex; flex-direction: column; justify-content: space-between; align-items: center; margin: 0px auto; width: 60%;">
            <div style="display: flex; flex-direction: row; justify-conent: space-between; width: 684px; align-items: center;">
                <img src="images/logo_light.png"/> <!-- add this to img for testing -> style="border: 1px solid blue" -->
                <span style="margin: 9px 0px 0px -10px; font-size: 410%; font-weight: 700;">Sign Up</span>
            </div>

            <!-- Input fields -->
            <form action="db/signup_db.php" method="post" style="margin: 0 auto; width: 45%;">
                <!-- Store name -->
                <input type="text" name="storename" placeholder="Store Name" autocomplete="off" required />
                <span style="display: flex; flex-direction: row; width: 104%; margin: 0;">
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
                <div class="password-container" style="width: 108%;">
                    <input type="password" name="password" id="psword" oninput="validatePw()" onfocus="toggleValidationOn()" onblur="toggleValidationOff()" placeholder="Password" autocomplete="off" required />
                    <i><img src="images/eye-solid.png" id="showPassword" onclick="passwordVisibility()" style="max-width: 20px; color: grey; position: absolute; right: 36%; margin-top: 0.7%" /></i>
                </div>
                <!-- Confirm Password -->
                <div class="password-container" style="width: 108%;">
                    <input type="password" name="confirmpassword" id="pswordCfm" placeholder="Confirm Password" autocomplete="off" required />
                    <i><img src="images/eye-solid.png" id="showPassword" onclick="cfmPasswordVisibility()" style="max-width: 20px; color: grey; position: absolute; right: 36%; margin-top: 0.7%" /></i>
                </div>
                <!-- Sign up button -->
                <button class="button-log-sign" style="height: 40px; width: 100%"><span class="btntext">Sign Up</span></button>
            </form>

            <!-- ADD PASSWORD STRENGTH -->
            <div id="validation" class="validation">
                <li>
                    <ul id="lengthCheck"><i class="fa fa-close"></i>Has at least 8 characters</ul>
                    <ul id="upperCaseCheck"><i class="fa fa-close"></i>Has at least 1 upper case letter</ul>
                    <ul id="lowerCaseCheck"><i class="fa fa-close"></i>Has at least 1 lower case letter</ul>
                    <ul id="numberCheck"><i class="fa fa-close"></i>Has at least 1 number</ul>
                    <ul id="specialCharCheck"><i class="fa fa-close"></i>Has at least 1 special character (!,@,$,-,+)</ul>
                </li>
            </div>

            <!-- Link to login.php -->
            <a href="login.php" style="width: 100%; margin-top: 30px;"><p align="center">Have an account? Log In instead</p></a>
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
                    eyecon.style = 'max-width: 23px; color: grey; position: absolute; right: 36%; margin-top: 0.7%';
                } else {
                    password.type = 'password';
                    eyecon.src = 'images/eye-solid.png';
                    eyecon.style = 'max-width: 20px; color: grey; position: absolute; right: 36%; margin-top: 0.7%';
                }
            }

            function cfmPasswordVisibility() {
                var passwordConfirm = document.getElementById('pswordCfm');

                if (passwordConfirm.type === 'password') {
                    passwordConfirm.type = 'text';
                    eyecon.src = 'images/eye-slash-solid.png';
                    eyecon.style = 'max-width: 23px; color: grey; position: absolute; right: 36%; margin-top: 0.7%';
                } else {
                    passwordConfirm.type = 'password';
                    eyecon.src = 'images/eye-solid.png';
                    eyecon.style = 'max-width: 20px; color: grey; position: absolute; right: 36%; margin-top: 0.7%';
                }
            }

            function toggleValidationOn() {
                // if (document.getElementById('validation').style.display == 'none') {
                    document.getElementById('validation').style.display = 'block';
                // } else {
                //     document.getElementById('validation').style.display = 'none';
                // }
            }

            function toggleValidationOff() {
                // if (document.getElementById('validation').style.display == 'block') {
                    document.getElementById('validation').style.display = 'none';
                // }
            }

            // password validation
            function validatePw() {
                // retrieve input
                const input = document.getElementById('psword').value;

                // criterias
                const lengthCheck = document.getElementById('lengthCheck');
                const upperCaseCheck = document.getElementById('upperCaseCheck');
                const lowerCaseCheck = document.getElementById('lowerCaseCheck');
                const numberCheck = document.getElementById('numberCheck');
                const specialCharCheck = document.getElementById('specialCharCheck');
                // retrieve corresponding <i> tags
                const licon = lengthCheck.querySelector('i');
                const ucicon = upperCaseCheck.querySelector('i');
                const lcicon = lowerCaseCheck.querySelector('i');
                const ncicon = numberCheck.querySelector('i');
                const scicon = specialCharCheck.querySelector('i');

                const hasMinLength = input.length >= 8;
                const hasUpperCase = /[A-Z]/.test(input);
                const hasLowerCase = /[a-z]/.test(input);
                const hasInteger = /\d/.test(input);
                const hasSpecialCharacter = /[!@#$%^&*(),.?":{}|<>]/.test(input);

                if (hasMinLength) {
                    licon.classList.remove('fa-close');
                    licon.classList.add('fa-check');
                    licon.classList.add('valid');
                } else {
                    licon.classList.remove('fa-check');
                    licon.classList.add('fa-close');
                    licon.classList.add('invalid');
                }

                if (hasUpperCase) {
                    ucicon.classList.remove('fa-close');
                    ucicon.classList.add('fa-check');
                } else {
                    ucicon.classList.remove('fa-check');
                    ucicon.classList.add('fa-close');
                }

                if (hasLowerCase) {
                    lcicon.classList.remove('fa-close');
                    lcicon.classList.add('fa-check');
                } else {
                    lcicon.classList.remove('fa-check');
                    lcicon.classList.add('fa-close');
                }

                if (hasInteger) {
                    ncicon.classList.remove('fa-close');
                    ncicon.classList.add('fa-check');
                } else {
                    ncicon.classList.remove('fa-check');
                    ncicon.classList.add('fa-close');
                }

                if (hasSpecialCharacter) {
                    scicon.classList.remove('fa-close');
                    scicon.classList.add('fa-check');
                } else {
                    scicon.classList.remove('fa-check');
                    scicon.classList.add('fa-close');
                }
            }
        </script>
    </body>
</html>