<?php
// CHECK SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// EMD SESSOPM
session_destroy();

// GO TO SITE
header('Location: index.php');