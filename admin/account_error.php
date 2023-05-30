<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Admin</a> > Foutmelding';
    require_once ('../config.php');
    $page_Title = 'Snartfalt - Admin - Foutmelding';
    require_once ('../site/site_admin_header.php');

    // GET ERROR
    $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "Er is een onbekende fout opgetreden.";

    // CLEAN UP
    unset($_SESSION['error_message']);
?>

        <style>
        .btn {
            width: 200px; /* Adjust the width value as needed */
        }
        </style>

        <section id="error">
            <div class="container bg-cornflower rounded-3 my-5 p-3">
                <p class="text-prussian"><strong>Fout tijdens het uitvoeren van een script</strong></p>
                <!-- Om cross-site scripting tegen te gaan. Bron: https://www.w3schools.com/PHP/func_string_htmlspecialchars.asp -->
                <p><?php echo htmlspecialchars($error_message); ?></p> 
            </div>
            <div class="container d-flex justify-content-center bg-cornflower rounded-3 my-5 p-3">
                <button type="button" class="btn btn-selective border border-dark m-2" onclick="goBack()"><strong>Terug</strong></button>
            </div>
        </section>
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