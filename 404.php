<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once ('config.php');
    $page_Title = 'Smartfalt - Pagina niet gevonden';
    require_once ('site/site_header.php');
    require_once ('db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once ('db/db_connect.php');
?>

        <!-- ERROR -->
        <section id="error-404">
            <div class="container bg-cornflower m-5 p-3 rounded-3">
                <h1 class="text-outline"><strong>Oeps..</strong></h1>
                <p>Pagina niet gevonden!</p>
                <p><?php echo $_SERVER['REQUEST_URI']; ?> bestaat niet. Klik <a href="<?php dirname(ROOT_URL) ?>">hier</a> om terug naar de startpagina te keren.</p>
            </div>
        </section>
        <!-- /ERROR -->
<?php 
    require_once('site/site_footer.php');