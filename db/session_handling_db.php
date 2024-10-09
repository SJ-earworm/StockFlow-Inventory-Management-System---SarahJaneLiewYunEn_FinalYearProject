<?php
    $query = "SELECT user_type FROM User WHERE userID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $stmt->bind_result($user_type);
    $stmt->fetch();
    $stmt->close();
?>