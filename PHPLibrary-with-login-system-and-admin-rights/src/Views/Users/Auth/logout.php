<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_SESSION['success_message']) && $_SESSION['success_message'] == 'You have changed your password. Log in with the new credentials!') {
        unset($_SESSION['user_id']);
    } else {
        session_destroy();
    }

    header("Location:login.php");
    die();
