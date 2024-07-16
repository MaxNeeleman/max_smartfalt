<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once('../config.php');
    require_once('order_admin.php');
