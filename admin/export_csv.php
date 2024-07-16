<?php
    // DEFINE CSV HEADER
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

    $output = fopen('php://output', 'w');

    // You may want to write column names as the first line of output here.
    fputcsv($output, array('AccountId', 'Gebruikersnaam', 'Wachtwoord', 'Voornaam', 'Achternaam', 'Geslacht', 'Adres', 'Woonplaats', 'Postcode', 'GebDatum', 'Emailadres', 'Telefoonnummer', 'IBAN', 'RolId'));

    // GET DATA
    require_once('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once('../db/db_connect.php');
    $stmt = $pdo->prepare("SELECT * FROM `accounts` ORDER BY `AccountId`;");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // EXPORT DATA
    foreach ($data as $row)
    {
        fputcsv($output, $row);
    }

