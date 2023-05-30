<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Admin</a> > Account Verwijderen';
    require_once ('../config.php');
    require_once ('../site/site_admin_header.php');
    require_once ('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');

    // CHECK ID
    if (!isset($_GET['id'])) {
        $_SESSION['error_message'] = "Geen account geselecteerd om te verwijderen.";
        header("Location: account_error.php");
        exit;
    }

    $id = $_GET['id'];

    // CONNECT NAAR DB
    try {
        $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "Kan geen verbinding maken met de database: " . $e->getMessage();
        header("Location: account_error.php");
        exit;
    }

    // STATEMENT
    $stmt = $connection->prepare("DELETE FROM `accounts` WHERE `Id` = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $_SESSION['success_message'] = "Record successfully deleted.";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Fout tijdens het verwijderen van de record: " . $e->getMessage();
        header("Location: account_error.php");
        exit;
    }

    // REDIRECT
    header("Location: account_admin.php");
    exit;
  
    // CLEAN UP
    $stmt = null;
    $connection = null;
    require_once ('../site/site_footer.php');
?>

?>