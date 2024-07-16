<?php
    class Orders {
        private $pdo;
        private $bestellingid;

        public function __construct($pdo, $bestellingid) {
            $this->pdo = $pdo;
            $this->bestellingid = $bestellingid;
        }

        public function fetchInvoice() {
            $stmt = $this->pdo->prepare("SELECT 
            `FACTUREN`.*, `BESTELLINGEN`.`TypeId` 
            FROM `FACTUREN`
            INNER JOIN `BESTELLINGEN` ON `FACTUREN`.`BestellingId` = `BESTELLINGEN`.`BestellingId`
            WHERE `FACTUREN`.`BestellingId` = :bestellingid");
            $stmt->bindParam(':bestellingid', $this->bestellingid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function fetchOrders() {
            $stmt = $this->pdo->prepare("SELECT `bestellingen`.*
                FROM `bestellingen`
                JOIN `facturen` ON `bestellingen`.`BestellingId` = `facturen`.`BestellingId`
                WHERE `bestellingen`.`BestellingId` = :bestellingid");
            $stmt->bindParam(':bestellingid', $this->bestellingid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function fetchAccounts() {
            $stmt = $this->pdo->prepare("SELECT `bestellingen`.`BestellingId`, `bestellingen`.`AccountId`, `accounts`.`Voornaam`, `accounts`.`Achternaam` FROM `bestellingen` JOIN `accounts` ON `bestellingen`.`AccountId` = `accounts`.`AccountId` WHERE `bestellingen`.`BestellingId` = :bestellingid");
            $stmt->bindParam(':bestellingid', $this->bestellingid, PDO::PARAM_INT);
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
    $page_Title = "Smartfalt - Orders - Bestellingdetails";
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Orders</a> > Bestelling';
    require_once ('../site/site_header_order.php');
    require_once ('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once ('../db/db_connect.php');

    // ERROR HANDLING
    if (!isset($_GET['bestellingid'])) {
        $_SESSION['error_message'] = "Er bestaat geen bestelling met ID: " . $_GET['bestellingid'];
        header("Location: order_error.php");
        exit();
    }

    // GET POST DATA
    $bestellingid = $_GET['bestellingid'];

    // GET DATA FROM SQL
    $order = new Orders($pdo, $bestellingid);
    $facturen = $order->fetchInvoice();
    $orders = $order->fetchOrders();
    $accounts = $order->fetchAccounts();
?>
        
        <!-- ADMIN CSS -->
        <style>
            body {
                font-family: apertura, sans-serif;
                font-weight: 700;
                font-style: normal;
                max-width: 100%;
                height: 100%;
                padding-top: 80px;
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

            .sticky-col {
                /* TODO: Dit werkt niet helemaal lekker nog... */
                position: sticky;
                left: 0;
                z-index: 1;
                background-color: #fff;
                width: 150px;
            }

            td:hover {
                box-shadow: inset 0 0 0 50px #ffb703;
                font-weight: bold;
            }

            tr:hover {
                box-shadow: inset 0 0 0 50px #ffb703;
                font-style: italic;
            }

            .success:hover {
                box-shadow: inset 0 0 0 50px lightgreen;
            }
            
            .attention:hover {
                box-shadow: inset 0 0 0 50px lightgoldenrodyellow;
            }

            .danger:hover {
                box-shadow: inset 0 0 0 50px lightcoral;
            }

            #order_overview {
                scroll-margin-top: 72px;
            }

            #navbar, .navbar {
                z-index: 1000;
            }
        </style>
        <!-- /ADMIN CSS -->

        <!-- ADMIN SECTION -->
        <section id="section-order-bestellingdetails" class="mt-5 bg-cornflower">
            <div class="table-wrapper">
                <div class="table-container">
                    <table class="table table-hover table-striped table-bordered table-responsive text-nowrap bg-cornflower table-scroll">
                        <thead class="table-selective">
                            <tr>
                                <th scope="col"><i class="bi bi-list-ul mx-2"></i> BestellingId</th>
                                <th scope="col"><i class="bi bi-person-square mx-2"></i> AccountId</th>
                                <th scope="col"><i class="bi bi-calendar3 mx-2"></i> Besteldatum</th>
                                <th scope="col"><i class="bi bi-person-rolodex mx-2"></i> Naam</th>
                                <th scope="col"><i class="bi bi-list-ul mx-2"></i> Abonnement</th>
                                <th scope="col"><i class="bi bi-receipt mx-2"></i> Factuur</th>
                                <th scope="col"><i class="bi bi-cash-coin mx-2"></i> Voldaan</th>
                                <th scope="col"><i class="bi bi-receipt"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($facturen as $factuur) { ?>
                            <tr>
                                <?php echo isset($orders['BestellingId']) ? '<td class="bg-tangerine">' . $orders['BestellingId'] . '</td>' : '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                <td class="fw-bold"><a href="<?php echo ROOT_URL;?>admin/account_edit.php?id=<?php echo $accounts['AccountId']; ?>" title="EDIT: <?php echo $accounts['Voornaam'] . ' ' . $accounts['Achternaam']; ?>"><?php echo $accounts['AccountId']; ?></a></td>
                                <?php echo isset($orders['Besteldatum']) ? '<td>' . $orders['Besteldatum'] . '</td>' : '<td class="text-center"><i class="bi bi-question-circle text-warning" title="Geen gegevens gevonden"></i></td>'; ?>
                                <td><?php echo $accounts['Voornaam'] . ' ' . $accounts['Achternaam']; ?></td>
                                <?php
                                switch ($factuur['TypeId']) {
                                    case 1: echo '<td>Evenement (Eenmalig)</td>'; break;
                                    case 2: echo '<td>Parkeergarage (Maand)</td>'; break;
                                    case 3: echo '<td>Parkeergarage (Kwartaal)</td>'; break;
                                    case 4: echo '<td>Overheid (Jaar)</td>'; break;
                                    default:
                                        echo '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>';
                                    break;
                                }
                                ?>
                                <?php echo isset($factuur['FactuurId']) ? '<td><a href="' . ROOT_URL . 'orders/order_facturen.php?factuurid=' . $factuur['FactuurId'] . '" title="VIEW: Factuur ' . $factuur['FactuurId'] . ' van ' . $accounts['Voornaam'] . ' ' . $accounts['Achternaam'] . ' "> ' . $factuur['FactuurId'] . '</a></td>' : '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                <?php echo isset($factuur['Voldaan']) ? ($factuur['Voldaan'] == '1' ? '<td class="text-center success"><i class="bi bi-check-circle" title="Factuur is voldaan"></i></td>' : '<td class="text-center danger"><i class="bi bi-x-circle" title="Factuur is niet voldaan"></i></td>') : '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                <td><a href="<?php echo ROOT_URL;?>orders/order_facturen_edit.php?factuurid=<?php echo $factuur['FactuurId']; ?>" title="EDIT: Factuur bewerken van <?php echo $accounts['Voornaam'] . ' ' . $accounts['Achternaam']; ?>"><i class="bi bi-receipt"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <a href="<?php echo ROOT_URL;?>orders/order_new.php" class="btn btn-selective border border-dark my-2 fw-bold">Nieuwe factuur maken</a>
            </div>
        </section>
        <!-- /ADMIN SECTION -->
<?php
    // LOAD FOOTER
    require_once ('../site/site_footer.php');

    // CLEAN UP
    $stmt = null;
    $pdo = null;