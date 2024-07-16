<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    require_once ('config.php');
    $page_Title = 'Smartfalt - Foutmelding';
    require_once ('site/site_header.php');

    // GET ERROR
    $error_message = $_SESSION['error_message'] ?? "Er is een onbekende fout opgetreden.";

    // ERROR - LOGIN - EMPTY INPUT FIELDS
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        echo match ($error) {
            'emptyfields' => "<p>Je moet wel de inloggegevens invullen</p>",
            'wrongpassword' => "<p>Onjuiste combinatie gebruikersnaam en/of wachtwoord!</p>",
            'nouser' => "<p>Geen gebruikers gevonden!</p>",
            'sqlerror' => "<p>Probleem met connecten naar de database. Check de logs voor mogelijke oorzaken!</p>",
            default => "<p>Onbekende fout aangetroffen. Check de logs voor mogelijke oorzaken!</p>",
        };
    }

    // CLEAN UP
    unset($_SESSION['error_message']);
?>

        <style>
        .btn {
            width: 200px;
        }
        </style>

        <!-- ERROR -->
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
        <!-- /ERROR -->

        <!-- SCRIPT -->
        <script>
            // GO BACK
            function goBack() {
            window.history.back();
            }
        </script>
        <!-- /SCRIPT -->
<?php
    require_once ('site/site_footer.php');
    exit();
?>