<?php require_once('header.php'); ?>

        <!-- ERROR -->
        <div class="bg-cornflower"></div>
            <h1>Oeps..</h1>
            <p>Pagina niet gevonden!</p>
            <p><?php echo $_SERVER['REQUEST_URI']; ?> bestaat niet. Klik <a href="/">hier</a> om terug naar de startpagina te keren.</p>
        </div>
        <!-- /ERROR -->
<?php require_once('footer.php'); ?>