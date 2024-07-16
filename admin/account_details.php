<?php
    class Order {
        private $pdo;
        private $accountid;

        // NEW PDO
        public function __construct($pdo, $accountid) {
            $this->pdo = $pdo;
            $this->accountid = $accountid;
        }

        // GET ACCOUNT
        public function fetchAccount() {
            $stmt = $this->pdo->prepare("SELECT * FROM `accounts` WHERE `AccountId` = :accountid");
            $stmt->bindParam(':accountid', $this->accountid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // GET ORDERS AND INVOICES
        public function fetchOrdersAndInvoices() {
            $stmt = $this->pdo->prepare("CALL GetBestellingenEnFacturen(?)");
            $stmt->bindValue(1, $this->accountid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // SESSION CONTROL
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $page_Title = "Smartfalt - Admin - Account Details";
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Admin</a> > Details';
    require_once('../config.php');
    require_once('../site/site_header_admin.php');
    require_once('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once('../db/db_connect.php');

    // ERROR HANDLING
    if (!isset($_GET['id'])) {
        $_SESSION['error_message'] = "Er bestaat geen account met ID: $id";
        header("Location: account_error.php");
        exit();
    }

    // GET POST DATA
    $accountId = $_GET['id'];
    $order = new Order($pdo, $accountId);
    $results = $order->fetchOrdersAndInvoices();
    $account = $order->fetchAccount();

    // CREATE TABLE
    if (count($results) > 0) {
        ?>
            <!-- ACCOUNT DETAILS STYLE -->
            <style>
                body {
                    font-family: apertura, sans-serif;
                    font-weight: 700;
                    font-style: normal;
                    max-width: 100%;
                    height: 100%;
                    padding-top: 80px;
                }
                td:hover {
                    box-shadow: inset 0 0 0 50px #ffb703;
                    font-weight: bold;
                }

                tr:hover {
                    box-shadow: inset 0 0 0 50px #ffb703;
                    font-style: italic;
                }
            </style>
            <!-- /ACCOUNT DETAILS STYLE -->

            <!-- ACCOUNT DETAILS TABLE -->
            <section id="section-account-details" class="mt-5 bg-cornflower">
                <div class="table-wrapper">
                    <div class="table-container">
                        <table class="table table-hover text-nowrap bg-cornflower table-scroll">
                            <thead class="bg-selective">
                                <tr>
                                    <th scope="col">Account ID</th>
                                    <th scope="col">Naam</th>
                                    <th scope="col">Bestelling ID</th>
                                    <th scope="col">Besteldatum</th>
                                    <th scope="col">Factuur ID</th>
                                    <th scope="col">Factuurdatum</th>
                                    <th scope="col">Factuurbedrag</th>
                                    <th scope="col">Voldaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $accountData) { ?>
                                    <tr>
                                        <th scope="ror" class="bg-tangerine sticky-col"><a href="<?php echo ROOT_URL;?>admin/account_edit.php?id=<?php echo $account['AccountId']; ?>" title="EDIT: <?php echo $account['Voornaam'] . ' ' . $account['Achternaam']; ?>"><?php echo $account['AccountId']; ?></a></th>
                                        <td><?php echo $account['Voornaam'].' '.$account['Achternaam'];?></td>
                                        <td><?php echo $accountData['BestellingId'];?></td>
                                        <td><?php echo $accountData['Besteldatum'];?></td>
                                        <td><?php echo $accountData['FactuurId'];?></td>
                                        <td><?php echo $accountData['FactuurDatum'];?></td>
                                        <td class="d-flex justify-content-between">
                                            <div style="width: 15px;">€</div>
                                            <div><?php echo number_format($accountData['FactuurBedrag'], 2, ',', '.');?></div>
                                        </td>
                                        <td class="text-center"><?php if ($accountData['Voldaan'] == '1') { echo '<i class="bi bi-check-circle"></i>'; } else { echo '<i class="bi bi-x-circle"></i>'; } ;?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- /ACCOUNT DETAILS TABLE -->
        <?php
    } else {
        ?>
        
            <!-- DETAILS SECTION -->
            <section id="account_details" class="mt-5 bg-cornflower">
                <div class="container my-5 p-3 rounded-5 bg-cornflower">
                    <h2 class="pt-2 text-outline fw-bold">Geen gegevens</h2>
                    <p class="pb-1">Voor account <span class="fw-bold">'<?php echo $account['AccountId']; ?>'</span> zijn geen bestellingen gevonden.</p>
                    <button type="button" style="width: 200px" class="btn btn-selective border border-dark mt-1 mb-5 fw-bold" onclick="goBack()">Terug</button>
                </div>
            </section>
            <!-- /DETAILS SECTION -->

            <!-- DETAILS SCRIPTS -->
            <script>
                function goBack() {
                    window.location.href = 'account_admin.php';
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