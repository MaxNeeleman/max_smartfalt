<?php
// CONNECT DB
require_once "../db/db_connect.php";
?>

<!DOCTYPE html>
<html lang="<?php echo $page_Language ?>">
<!-- ADMIN HEADER -->

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Smartfalt">
    <meta name="keywords" content="<?php echo $page_Keywords ?>">
    <meta name="description" content="<?php echo $page_Description ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo ROOT_URL; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL; ?>css/main.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/jlb2xtz.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>img/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    <title><?php echo $page_Title ?></title>
</head>
<!-- /ADMIN HEADER -->

<body class="bg-prussian">

    <!-- ADMIN HEADER CSS -->
    <style>
        body {
            font-family: apertura, sans-serif;
            font-weight: 700;
            font-style: normal;
            max-width: 100%;
            height: 100%;
            /* padding-top: 80px; */
        }

        a {
            text-decoration: none !important;
            color: inherit;
            cursor: pointer;
        }

        a:hover {
            color: black;
        }

        .table-wrapper {
            position: relative;
            max-width: 100%;
            overflow: auto;
        }

        .table-container {
            overflow-x: auto;
            overflow-y: scroll;
            max-height: 80vh;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .table-container thead th {
            position: sticky;
            top: 0;
            background-color: #ffb703;
            z-index: 2;
        }

        td:hover {
            box-shadow: inset 0 0 0 50px #ffb703;
            font-weight: bold;
        }

        tr:hover {
            box-shadow: inset 0 0 0 50px #ffb703;
            font-style: italic;
        }

        .sticky-col {
            /* TODO: Dit werkt niet helemaal lekker nog... */
            position: sticky;
            left: 0;
            z-index: 1;
            background-color: #fff;
            width: 150px;
        }

        #account_overview {
            scroll-margin-top: 72px;
        }

        #navbar,
        .navbar {
            z-index: 1000;
        }

        .container-profielImg {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profielImg {
            width: 20px;
            height: 20px;
        }
    </style>
    <!-- /ADMIN HEADER CSS -->

    <!-- ADMIN HEADER NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-prussian p-0">
        <div class="container-fluid p-0">
            <a class="navbar-brand" href="<?php echo ROOT_URL; ?>index.php">
                <img src="<?php echo ROOT_URL; ?>img/Smartfalt-logo2.png" alt="Smartfalt Logo" class="smartfalt-logo animated-logo">
            </a>
            <div class="input-group">
                <form action="../admin/account_admin_search_result.php" method="POST" class="d-flex">
                    <input class="form-control me-2" type="search" id="admin-search" name="admin-search" placeholder="Zoeken op de website..">
                    <button type="submit" name="admin-search-btn" class="rounded-2 btn btn-selective"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <div id="google_translate_element"></div>
            <div class="mx-3 justify-content-end text-nowrap">
                <h2 class="text-end"><strong><?php echo $admin_page_title; ?></strong></h2>
            </div>
        </div>
    </nav>
    <!-- /ADMIN HEADER NAVBAR -->