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
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
        <title><?php echo $page_Title ?></title>
    </head>
    <!-- /HEADER -->

    <body class="bg-prussian">
        <!-- NAVBAR -->
        <nav id="navbar" class="navbar navbar-expand-lg navbar-dark fixed-top bg-prussian p-0">
            <div class="container-fluid p-0">
                <a class="navbar-brand" href="<?php echo ROOT_URL; ?>index.php">
                    <img src="<?php echo ROOT_URL; ?>img/Smartfalt-logo2.png" alt="Smartfalt Logo" class="smartfalt-logo animated-logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mx-3" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li>
                            <div id="google_translate_element"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-statement">Statement</a></li>
                        <li class="nav-item"><a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-tarieven">Tarieven</a></li>
                        <li class="nav-item"><a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-about">Over ons</a></li>
                        <li class="nav-item"><a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-faq">F.A.Q.</a></li>
                        <li class="nav-item"><a class="nav-link text-cornflower" href="<?php echo ROOT_URL; ?>index.php#section-contact">Contact</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-cornflower" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Downloads</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item nav-link text-selective fw-bold" href="<?php echo ROOT_URL; ?>dl/moodboard.pdf" target="_blank">Moodboard</a></li>
                                <li><a class="dropdown-item nav-link text-selective fw-bold" href="<?php echo ROOT_URL; ?>dl/siteplan.pdf" target="_blank">Siteplan</a></li>
                                <li><a class="dropdown-item nav-link text-selective fw-bold" href="<?php echo ROOT_URL; ?>dl/ondernemingsplan.pdf" target="_blank">Ondernemingsplan</a></li>
                                <li><a class="dropdown-item nav-link text-selective fw-bold" href="<?php echo ROOT_URL; ?>dl/presentatie.pptx" target="_blank">Presentatie</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-cornflower" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if(isset($_SESSION['AccountId'])): ?>
                                <?php if(isset($_SESSION['ProfilePic'])): ?>
                                    <img src="data:image/jpeg;base64, <?php echo base64_encode($_SESSION['ProfilePic']); ?>" width="25px" height="25px" alt="Profile Picture" class="profile-pic">
                                <?php else: ?>
                                    <i class="bi bi-person-check"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <i class="bi bi-person-circle"></i>
                            <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                <?php if(isset($_SESSION['AccountId'])): ?>
                                    <?php if($_SESSION['RolId'] === 1): ?>
                                        <li><a class="dropdown-item nav-link text-selective fw-bold" href="<?php echo ROOT_URL; ?>admin/">Admin Dashboard</a></li> 
                                        <li><a class="dropdown-item nav-link text-selective fw-bold" href="<?php echo ROOT_URL; ?>search/">Zoekgeschiedenis</a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item nav-link text-selective fw-bold" href="<?php echo ROOT_URL; ?>orders/">Orderoverzicht</a></li>
                                    <hr>
                                    <li><a class="dropdown-item nav-link text-selective fw-bold" href="<?php echo ROOT_URL; ?>logout.php">Logout</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item nav-link text-selective fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /NAVBAR -->

        <!-- LOGIN MODAL -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Inloggen bij Smartfalt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="loginForm" action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Gebruikersnaam</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Wachtwoord</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                            <button type="submit" class="btn btn-selective border border-dark my-2 fw-bold">Inloggen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /LOGIN MODAL -->

        <!-- LOGIN SCRIPT -->
        <script>
            $(document).ready(function() {
                $('#loginForm').on('submit', function(event) {
                    event.preventDefault();
                    this.submit();
                });
            });
        </script>
        <!-- /LOGIN SCRIPT -->

