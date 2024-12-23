<?php
    // require session handling file
    require("db/dbConnect.php");
    require("app_config/session_handling.php");
    require("db/session_handling_db.php");

    // If user is an admin, call admin page
    // else, call staff page
    if ($user_type == 'admin') {
        include("admin/edititem_admin.php");
    } else if ($user_type == 'staff') {
        // include("index_staff.php");
    } else {
        // users who somehow snuck in without an account
        echo "Error 404. No account detected. Please create an account.";
    }
?>