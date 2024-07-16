<?php
    require_once('config.php');
    require_once('db/db_connect.php');
    require_once('site/site_header.php');
?>

    <div class="container">
        <form class="position-absolute top-50 start-50 translate-middle" action="index.php">
            <h1> Mail Verzonden! </h1>
            <button class="btn btn-selective btn-lg" type="submit">Terug naar homepage</button>
        </form>
    </div>

<?php
    require_once('site/site_footer.php');
?>