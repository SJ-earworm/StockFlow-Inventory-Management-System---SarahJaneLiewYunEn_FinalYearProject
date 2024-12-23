<?php
    require("db/dbConnect.php");
    require("app_config/session_handling.php");
    require("db/session_handling_db.php");  // retrieving current userID from database

    // If user is an admin, call admin page
    // else, call staff page
    if ($user_type == 'admin') {
        include("admin/index_admin.php");
    } else if ($user_type == 'staff') {
        include("staff/index_staff.php");
    } else {
        // users who somehow snuck in without an account
        echo "Error 404. No account detected. Please create an account.";
    }
?>