<?php
    require("db/dbConnect.php");
    require("app_config/session_handling.php");  // retrieving current userID
    require("db/session_handling_db.php");  // retrieving system user type

    // If user is an admin, call admin page
    // else, call staff page
    if ($user_type == 'admin') {
        include("admin/managestocks_admin.php");
    } else if ($user_type == 'staff') {
        include("staff/managestocks_staff.php");
    } else {
        // users who somehow snuck in without an account
        echo "Error 404. No account detected. Please create an account.";
    }
?>