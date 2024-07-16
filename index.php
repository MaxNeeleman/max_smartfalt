<?php
    // Error reporting 
    // Log locatie => {XAMMP dir}\apache\logs\error.log  ||  {XAMPP dir}\php\logs\php_error.log (als dir niet bestaat, handmatig aanmaken daarna wordt log gemaakt)
    if($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "127.0.0.1" ) { error_reporting(E_ALL); }
    else { error_reporting(E_ERROR | E_PARSE); }

    // Session control
    session_start();

    // Load Website
    // require_once __DIR__ .'site/site_header'; <-- is dit een oplossing? Gaat fout bij lokaal werken
    require_once('config.php');
    require_once('db/db_connect.php');
    require_once('site/site_header.php');
    require_once('site/site_body.php');
    require_once('site/site_footer.php');

