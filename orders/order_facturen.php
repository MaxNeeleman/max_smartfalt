<?php
    class Invoices {
        private $pdo;
        private $factuurid;

        public function __construct($pdo, $factuurid) {
            $this->pdo = $pdo;
            $this->factuurid = $factuurid;
        }

        public function fetchInvoice() {
            $stmt = $this->pdo->prepare("SELECT * FROM `facturen` WHERE `FactuurId` = :factuurid");
            $stmt->bindParam(':factuurid', $this->factuurid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function fetchOrders() {
            $stmt = $this->pdo->prepare("SELECT *
                FROM `bestellingen`
                JOIN `facturen` ON `bestellingen`.`BestellingId` = `facturen`.`BestellingId`
                WHERE `facturen`.`FactuurId` = :factuurid");
            $stmt->bindParam(':factuurid', $this->factuurid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function fetchAccounts() {
            $stmt = $this->pdo->prepare("SELECT `bestellingen`.`BestellingId`, `bestellingen`.`AccountId`, `accounts`.`Voornaam`, `accounts`.`Achternaam`, `accounts`.`Adres`, `accounts`.`Postcode`, `accounts`.`Woonplaats`, `accounts`.`IBAN`, `accounts`.`Emailadres`
                FROM `bestellingen`
                JOIN `facturen` ON `bestellingen`.`BestellingId` = `facturen`.`BestellingId`
                JOIN `accounts` ON `bestellingen`.`AccountId` = `accounts`.`AccountId`
                WHERE `facturen`.`FactuurId` = :factuurid");
            $stmt->bindParam(':factuurid', $this->factuurid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    // SESSION CONTROL
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    require_once ('../config.php');
    $page_Title = "Smartfalt - Orders - Factuurdetails";
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Orders</a> > Facturen';
    require_once ('../site/site_header_admin.php');
    require_once ('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once ('../db/db_connect.php');

    // ERROR HANDLING
    if (!isset($_GET['factuurid'])) {
        $_SESSION['error_message'] = "Er bestaat geen factuur met ID: $factuurid";
        header("Location: order_error.php");
        exit();
    }

    // GET POST DATA
    $factuurid = $_GET['factuurid'];

    // GET DATA FROM SQL
    $invoice = new Invoices($pdo, $factuurid);
    $factuur = $invoice->fetchInvoice();
    $order = $invoice->fetchOrders();
    $account = $invoice->fetchAccounts();

    // CREATE TABLE
    if ($factuur !== false && count($factuur) > 0) {
        ?>
            <!-- ORDER DETAILS STYLE -->
            <style>
                body {
                    font-family: apertura, sans-serif;
                    font-weight: 700;
                    font-style: normal;
                }

                [id^="section-"] {
                    scroll-margin-top: 72px;
                }
            </style>
            <!-- /ORDER DETAILS STYLE -->

            <!-- ORDER DETAILS TABLE -->
            <section id="section-order-factuurdetails">
                <div class="container">
                    <div class="p-5 bg-light text-dark rounded-2">
                        <div class="d-flex align-items-center justify-content-around flex-row">
                            <div>
                                <img src="<?php echo ROOT_URL; ?>img/Smartfalt_Logo.png"/>
                            </div>
                            <div>
                                <form>
                                    <label for="bestellingid" class="fw-bold">Ordernummer:</label><input type="text" readonly class="form-control-plaintext" id="bestellingid" value="<?php echo $factuur['BestellingId']; ?>">
                                    <label for="factuurid" class="fw-bold">Factuurnummer:</label><input type="text" readonly class="form-control-plaintext" id="factuurid" value="<?php echo $factuur['FactuurId']; ?>">
                                    <label for="factuurdatum" class="fw-bold">Factuurdatum:</label><input type="text" readonly class="form-control-plaintext" id="factuurdatum" value="<?php echo $factuur['FactuurDatum']; ?>">
                                </form>
                            </div>
                        </div>
                        <div class="d-flex flex-row">
                            <div>
                                <p>
                                    <?php echo $account['Voornaam'] . ' ' . $account['Achternaam']; ?><br>
                                    <?php echo $account['Adres']; ?><br>
                                    <?php echo $account['Postcode'] . ' ' . $account['Woonplaats']; ?><br>
                                    <?php echo $account['Emailadres']; ?><br>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex flex-row">
                            <div><h1 class="fw-bold">Factuur</h1></div>
                        </div>
                        <div class="d-flex flex-row">
                            <div>
                                <p>Beste <?php echo $account['Voornaam'] . ' ' . $account['Achternaam']; ?>,</p>
                                <p>Op <?php echo $order['Besteldatum']; ?> heb je bij SMARTFALT de volgende bestelling geplaatst:</p>
                            </div>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Aantal</th>
                                            <th>Omschrijving</th>
                                            <th>Bedrag</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1x</td>
                                            <?php 
                                                switch ($order['TypeId']) {
                                                    case 1: echo '<td>Evenement (Eenmalig)</td>'; break;
                                                    case 2: echo '<td>Parkeergarage (Maand)</td>'; break;
                                                    case 3: echo '<td>Parkeergarage (Kwartaal)</td>'; break;
                                                    case 4: echo '<td>Overheid (Jaar)</td>'; break;
                                                    default;
                                                        echo '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>';
                                                    break; 
                                                } 
                                            ?>
                                            <td class="d-flex justify-content-between"><div style="width: 15px; text-align: right;">€</div><div><?php echo $factuur['FactuurBedrag']?></div></td>
                                        </tr>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex flex-row">
                            <p>Het totaalbedrag van € <?php echo $factuur['FactuurBedrag'];?> wordt binnen 30 dagen afgeschreven van rekeningnummer <?php echo $account['IBAN'];?>
                            <!-- <p><pre><?php var_dump($account) ?></pre></p> -->
                        </div>
                        <div class="d-flex justify-content-center flex-row py-3">
                            <div><h2 class="fw-bold">Hartelijk dank voor uw aankoop</h2></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /ORDER DETAILS TABLE -->
            <?php
    } else {
        ?>
        
        <!-- DETAILS SECTION -->
        <section id="order_details" class="mt-5 bg-cornflower">
            <div class="container my-5 p-3 rounded-5 bg-cornflower">
                <h2 class="pt-2 text-outline fw-bold">Geen gegevens</h2>
                <p class="pb-1">Voor de bestelling met <span class="fw-bold">'<?php echo $factuur['BestellingId']; ?>'</span> zijn geen facturen gevonden.</p>
                <hr>
                <p>Vardump van $factuur, $account en $order:</p>
                <p><pre><?php var_dump($factuur) ?></pre></p>
                <p><pre><?php var_dump($account) ?></pre></p>
                <p><pre><?php var_dump($order) ?></pre></p>
                <button type="button" style="width: 200px" class="btn btn-selective border border-dark mt-1 mb-5 fw-bold" onclick="goBack()">Terug</button>
                </div>
            </section>
            <!-- /DETAILS SECTION -->

            <!-- DETAILS SCRIPTS -->
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
            <!-- /DETAILS SCRIPTS -->
        <?php
    }

    // CLEAN UP
    $stmt = null;
    $pdo = null;

    // LOAD FOOTER
    require_once ('../site/site_footer.php');
?>