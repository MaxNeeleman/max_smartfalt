<?php
    // VARS
    if (str_contains(__DIR__ , 'htdocs')) {
        define('ROOT_URL', 'http://localhost/smartfalt/');
    }
    else {
        define('ROOT_URL', __DIR__ . '/' );
    }

    $page_Title = "Smartfalt - Nu ook met PHP!";
    $page_Description = "Smartfalt houdt zich bezig met het innoveren van ons wegennet. Wij pakken mobiliteit, bereikbaarheid en veiligheid aan met smart toepassingen in combinatie met duurzame energie.";
    $page_Keywords = "smartfalt, roads, infra, infrastructure, innovation, smart, mobility, solar, wind, future, innovatie, mobiliteit, infrastructuur, vernieuwing";
    $page_Language = "nl";

    // REQUIRES
    require_once ('db/connect_' . $_SERVER['HTTP_HOST'] . '.php');

