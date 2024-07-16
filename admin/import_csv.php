<?php
    // CHECK IF FILE IS CSV
    if ($_FILES['csvfile']['error'] == 0 && pathinfo($_FILES['csvfile']['name'], PATHINFO_EXTENSION) == 'csv') {
        
        // LOAD DATA
        $name = $_FILES['csvfile']['tmp_name'];
        $csv = array_map('str_getcsv', file($name));
        
        // REMOVE HEADERS FROM FILE
        array_shift($csv);

        // CONNECT DB
        require_once('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
        require_once('../db/db_connect.php');
    
        // PREPARE SQL
        foreach ($csv as $row) {
            $stmt = $pdo->prepare("INSERT INTO accounts (AccountId, Gebruikersnaam, Wachtwoord, Voornaam, Achternaam, Geslacht, Adres, Woonplaats, Postcode, GebDatum, Emailadres, Telefoonnummer, IBAN, RolId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($row);
        }
    
        // GO BACK
        header('Location: account_admin.php');
    }
?>