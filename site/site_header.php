<!DOCTYPE html>
<html lang="<?php echo $page_Language ?>">
    <!-- HEADER -->
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Smartfalt">
        <meta name="keywords" content="<?php echo $page_Keywords ?>">
        <meta name="description" content="<?php echo $page_Description ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo ROOT_URL; ?>css/style.css">
        <link rel="stylesheet" href="<?php echo ROOT_URL; ?>css/main.min.css">
        <link rel="stylesheet" href="https://use.typekit.net/jlb2xtz.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>img/favicon.ico">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>
        <title><?php echo $page_Title ?></title>
    </head>
    <!-- /HEADER -->

    <body class="bg-prussian">
        <!-- NAVBAR -->
        <nav id="navbar" class="navbar navbar-expand-lg navbar-dark fixed-top bg-prussian p-0">
            <div class="container-fluid p-0">
                <a class="navbar-brand" href="<?php echo ROOT_URL; ?>index.php">
                    <img src="<?php echo ROOT_URL; ?>img/Smartfalt-logo2.png" alt="Smartfalt Logo" class="smartfalt-logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-3" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-statement">Statement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-tarieven">Tarieven</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-about">Over ons</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-faq">F.A.Q.</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-contact">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-cornflower" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Downloads
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item nav-link text-selective" href="<?php echo ROOT_URL; ?>dl/moodboard.pdf" target="_blank">Moodboard</a></li>
                                <li><a class="dropdown-item nav-link text-selective" href="<?php echo ROOT_URL; ?>dl/siteplan.pdf" target="_blank">Siteplan</a></li>
                                <li><a class="dropdown-item nav-link text-selective" href="<?php echo ROOT_URL; ?>dl/ondernemingsplan.pdf" target="_blank">Ondernemingsplan</a></li>
                                <li><a class="dropdown-item nav-link text-selective" href="<?php echo ROOT_URL; ?>dl/presentatie.pptx" target="_blank">Presentatie</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /NAVBAR -->
