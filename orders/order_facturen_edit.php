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
            $stmt = $this->pdo->prepare("SELECT `bestellingen`.`BestellingId`, `bestellingen`.`AccountId`, `accounts`.`Voornaam`, `accounts`.`Achternaam` FROM `bestellingen` JOIN `accounts` ON `bestellingen`.`AccountId` = `accounts`.`AccountId`");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function updateInvoice($factuurdatum, $factuurbedrag, $voldaan, $bestellingid) {
            $stmt = $this->pdo->prepare("UPDATE `facturen` SET `FactuurDatum` = :factuurdatum, `FactuurBedrag` = :factuurbedrag, `Voldaan` = :voldaan, `BestellingId` = :bestellingid WHERE `FactuurId` = :factuurid");
            $stmt->bindParam(':factuurdatum', $factuurdatum, PDO::PARAM_STR);
            $stmt->bindParam(':factuurbedrag', $factuurbedrag, PDO::PARAM_STR);
            $stmt->bindParam(':voldaan', $voldaan, PDO::PARAM_STR);
            $stmt->bindParam(':bestellingid', $bestellingid, PDO::PARAM_INT);
            $stmt->bindParam(':factuurid', $this->factuurid, PDO::PARAM_INT);
            return $stmt->execute();
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

    // GET POST DATA
    $factuurid = $_GET['factuurid'];

    // ERROR HANDLING
    if (!isset($_GET['factuurid'])) {
        $_SESSION['error_message'] = "Er bestaat geen factuur met ID: $factuurid";
        header("Location: order_error.php");
        exit();
    }

    // GET DATA FROM SQL
    $invoice = new Invoices($pdo, $factuurid);
    $factuur = $invoice->fetchInvoice();
    $order = $invoice->fetchOrders();

    // SUBMIT DATA TO SQL
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $factuurdatum = $_POST['factuurdatum'];
        $factuurbedrag = $_POST['factuurbedrag'];
        $voldaan = $_POST['voldaan'];
        $bestellingid = $_POST['bestellingid'];

        // UPDATE FACTUUR
        $invoice = new Invoices($pdo, $factuurid);
        $success = $invoice->updateInvoice($factuurdatum, $factuurbedrag, $voldaan, $bestellingid);

        if (!$success) {
            $_SESSION['error_message'] = "Onbekende fout tijdens het updaten van de factuur in de database..";
            header("Location: order_error.php");
            exit();
        }
    }
?>

        <!-- EDIT STYLE -->
        <style>
            body {
                font-family: apertura, sans-serif;
                font-weight: 700;
                font-style: normal;
                max-width: 100%;
                height: 100%;
                padding-top: 80px;
            }
        </style>
        <!-- /EDIT STYLE -->

        <!-- EDIT FORM -->
        <div class="container bg-cornflower rounded-3 my-5 p-3">
            <form action="order_facturen_edit.php?factuurid=<?php echo $_GET['factuurid']; ?>" method="POST">
                <div class="form-group">
                    <label class="text-prussian" for="factuurid"><span class="fw-bold">Factuurnummer<span>:</label>
                    <input type="text" readonly class="form-control border border-dark text-muted" id="factuurdid" name="factuurdid" value="<?php echo $factuur['FactuurId']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="factuurdatum"><span class="fw-bold">Factuurdatum<span>:</label>
                    <input type="date" class="form-control border border-dark" id="factuurdatum" name="factuurdatum" value="<?php echo $factuur['FactuurDatum']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="factuurbedrag"><span class="fw-bold">Factuurbedrag<span>:</label>
                    <input type="text" class="form-control border border-dark" id="factuurbedrag" name="factuurbedrag" value="<?php echo $factuur['FactuurBedrag']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="voldaan"><span class="fw-bold">Voldaan<span>:</label>
                    <input type="text" class="form-control border border-dark" id="voldaan" name="voldaan" value="<?php echo $factuur['Voldaan']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="bestellingid"><span class="fw-bold">Ordernummer<span>:</label>
                    <?php if (empty($order)) { ?>
                        <p class="text-muted">Geen orders gevonden!</p>
                    <?php } else { ?>
                        <select class="form-select border border-dark" id="bestellingid" name="bestellingid">
                            <?php foreach ($order as $row) { ?>
                                <option value="<?php echo $row['BestellingId']; ?>" <?php echo ($factuur['BestellingId'] == $row['BestellingId']) ? 'selected' : ''; ?>>
                                    <?php echo $row['BestellingId'] . ' (' . $row['AccountId'] . ': '. $row['Voornaam'] . ' ' . $row['Achternaam'] . ')'; ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                </div>
                <button type="submit" id="submit-button" class="btn btn-selective border border-dark my-2 fw-bold">Indienen</button>
                <button type="button" class="btn btn-selective border border-dark m-2 fw-bold" onclick="goBack()">Terug</button>
            </form>
        </div>
        <!-- /EDIT FORM -->

        <!-- EDIT FACTUREN SCRIPT -->
        <script>
        // GO BACK
            function goBack() {
                window.location.href = 'order_admin.php';
            }
        </script>
        <!-- /EDIT FACTUREN SCRIPT -->
