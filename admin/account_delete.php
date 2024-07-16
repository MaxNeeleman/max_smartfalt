<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $page_title = 'Smartfalt - Admin - Account Verwijderen';
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Admin</a> > Account Verwijderen';
    require_once ('../config.php');
    require_once ('../site/site_header_admin.php');
    require_once ('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once ('../db/db_connect.php');

    // GET SUBMITTED ID
    if (!isset($_GET['id'])) {
        $_SESSION['error_message'] = "Geen account geselecteerd om te verwijderen.";
        header("Location: account_error.php");
        exit;
    } else {
        $accountid = $_GET['id'];
    }

    // STATEMENT
    $stmt = $pdo->prepare("DELETE FROM `accounts` WHERE `AccountId` = :accountid");
    $stmt->bindParam(':accountid', $accountid, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $_SESSION['success_message'] = "Record successfully deleted.";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Fout tijdens het verwijderen van de record: " . $e->getMessage();
        header("Location: account_error.php");
        exit;
    }

    // // REDIRECT
    // header("Location: account_admin.php");
    // exit;
  
    // CLEAN UP
    $stmt = null;
    $pdo = null;
    require_once ('../site/site_footer.php');