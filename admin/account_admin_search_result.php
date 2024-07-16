<?php
// START SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// LOAD WEBSITE
$admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Accountoverzicht</a> > <a href="account_admin_search_result.php">Account Resultaten</a>';
require_once('../config.php');
$page_Title = 'Smartfalt - Zoekresultaten';
require_once('../site/site_header_admin.php');
require_once('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
require_once('../db/db_connect.php');
?>

        <!-- SEARCH FUNCTION FOR ADMIN PAGE -->
        <section id="section-admin-search">
            <div class="container bg-cornflower rounded-3 my-5 p-3">
                <h1 class="fw-bold">Resultaten</h1>

                <?php
                    if (isset($_POST['admin-search-btn'])) {
                        $search = $_POST['admin-search'];
                        $sql = "SELECT * FROM accounts WHERE Gebruikersnaam LIKE :search OR Voornaam LIKE :search OR Achternaam LIKE :search OR Emailadres LIKE :search OR Telefoonnummer LIKE :search OR IBAN LIKE :search";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
                        $stmt->execute();

                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $queryResult = $stmt->rowCount();

                        // ZOEKRESULKTATEN TOEVOEGEN IN "ZOEKEN" DATABASE
                        $insertSql = "INSERT INTO zoeken (ZoekOpdracht) VALUES (:ZoekOpdracht)";
                        $insertStmt = $pdo->prepare($insertSql);
                        $insertStmt->bindValue(':ZoekOpdracht', $search, PDO::PARAM_STR);
                        $insertStmt->execute();

                        // FILTEREN OP EERSTE LETTER ANDERS LAAT HIJ ALLE RESULTATEN ZIEN MET EEN SPECIFIEKE LETTER ERIN
                        if (strlen($search) === 1) {
                            $filteredResults = [];
                            foreach ($results as $result) {
                                if (strcasecmp(substr($result['Gebruikersnaam'], 0, 1), $search) === 0
                                    || strcasecmp(substr($result['Voornaam'], 0, 1), $search) === 0
                                    || strcasecmp(substr($result['Achternaam'], 0, 1), $search) === 0) {
                                        $filteredResults[] = $result;
                                    }
                                }
                    
                            $results = $filteredResults;
                            }

                        //ALS DE QUERYRESULT MEER DAN 0 ROWS OPGEEFT, DAN LAAT HIJ DE TABEL ZIEN VAN 'account_overview.php'
                        if ($queryResult > 0) {
                            require_once('account_overview.php'); 
                        } else {
                            echo "<p>Geen resultaten</p>";
                        }
                    }
                ?>
            </div>
        </section>
        <!-- /SEARCH FUNCTION FOR ADMIN PAGE -->
