<?php
    $rootConfig = __DIR__ . '/config.php';
    $relativeConfig = __DIR__ . '/../config.php';

    // CHECK ABSOLUTE OR RELATIVE PATH IN USE
    if (file_exists($rootConfig)) {
        require_once($rootConfig);
    } elseif (file_exists($relativeConfig)) {
        require_once($relativeConfig);
    } else {
        // OH NOES!!1one
        die('Configuratiebestand \'config.php\' niet gevonden.');
    }


    # CONNECT DB -> https://phpdelusions.net/pdo
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "ERROR: Kan geen verbinding met de database maken. " . $e->getMessage();
        header("Location: error.php");
        exit();
    }