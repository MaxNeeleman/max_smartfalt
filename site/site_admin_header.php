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
        <style>
            a {
                 text-decoration: none !important;
                color: inherit;
                cursor: pointer;
            }
        </style>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-prussian p-0">
            <div class="container-fluid p-0">
                <a class="navbar-brand" href="<?php echo ROOT_URL; ?>index.php">
                    <img src="<?php echo ROOT_URL; ?>img/Smartfalt-logo2.png" alt="Smartfalt Logo" class="smartfalt-logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-3 justify-content-end" id="navbarNavDropdown">
                    <h2 class="text-end text-outline"><strong><?php echo $admin_page_title ;?></strong></h2>
                </div>
            </div>
        </nav>
        <!-- /NAVBAR -->
