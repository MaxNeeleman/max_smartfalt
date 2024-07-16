<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Admin</a> > Foutmelding';
    $page_Title = 'Snartfalt - Admin - Foutmelding';
    require_once ('../config.php');
    require_once ('../site/site_header_admin.php');

    // GET ERROR
    $error_message = $_SESSION['error_message'] ?? "Er is een onbekende fout opgetreden.";

    // CLEAN UP
    unset($_SESSION['error_message']);
?>

        <!-- STYLE -->
        <style>
        .btn {
            width: 200px;
        }
        </style>
        <!-- /STYLE -->

        <!-- ERROR -->
        <section id="section-error">
            <div class="container bg-cornflower rounded-3 my-5 p-3">
                <p class="text-prussian fw-bold">Fout tijdens het uitvoeren van een script</p>
                <!-- Om cross-site scripting tegen te gaan. Bron: https://www.w3schools.com/PHP/func_string_htmlspecialchars.asp -->
                <p><?php echo htmlspecialchars($error_message); ?></p> 
            </div>
            <div class="container d-flex justify-content-center bg-cornflower rounded-3 my-5 p-3">
                <button type="button" class="btn btn-selective border border-dark m-2 fw-bold" onclick="goBack()">Terug</button>
            </div>
        </section>
        <!-- ERROR -->

        <!-- SCRIPT -->
        <script>
            // GO BACK
            function goBack() {
            window.history.back();
            }
        </script>
        <!-- /SCRIPT -->

<?php
    require_once ('../site/site_footer.php');
?>