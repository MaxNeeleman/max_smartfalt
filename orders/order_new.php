<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $page_Title = 'Smartfalt - Nieuwe Order';
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Orders</a> > Order Aanmaken';
    require_once ('../config.php');
    require_once ('../site/site_header_order.php');
    require_once('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once('../db/db_connect.php');
    require_once ('order_orders.php');

    // SET VARS
    $accountId = $typeId = $orderDate = $factuurBedrag = "";

    // CONNECT DB
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "ERROR: Kan geen verbinding met de database maken. " . $e->getMessage();
        header("Location: account_error.php");
        exit();
    }

    // GET ACCOUNTS
    $accounts = [];
    $query = "SELECT * FROM accounts";
    $result = $pdo->query($query);

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $accounts[] = $row;
    }

    // SUBMIT DATA
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // SQL STATEMENT (BESTELLING)
            $sql = "INSERT INTO `bestellingen` (`AccountId`, `Besteldatum`, `TypeId`) VALUES (:accountid, :besteldatum, :typeid)";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':accountid', $_POST['accountid'], PDO::PARAM_STR);
            $stmt->bindParam(':besteldatum', $_POST['orderdate'], PDO::PARAM_STR);
            $stmt->bindParam(':typeid', $_POST['typeid'], PDO::PARAM_STR);

            // EXECUTE STATEMENT (BESTELLING)
            $stmt->execute();

            // GET LAST ID
            $bestellingId = $pdo->lastInsertId();
            
            // SET FACTUUR BEDRAG
            switch ($_POST['typeid']) {
                case '1': $factuurBedrag = 500.00; break;
                case '2': $factuurBedrag = 250.00; break;
                case '3': $factuurBedrag = 700.00; break;
                case '4': $factuurBedrag = 5000.00; break;
                default: $factuurBedrag = 0.00; break;
            }

            // SET FACTUUR DATUM
            $factuurDatum = $_POST['orderdate'];
            
            // FACTUUR IS NIET VOLDAAN NOG
            $voldaan = 0;
            
            // SQL STATEMENT (FACTUUR)
            $sql = "INSERT INTO `facturen` (`FactuurDatum`, `FactuurBedrag`, `Voldaan`, `BestellingId`) VALUES (:factuurdatum, :factuurbedrag, :voldaan, :bestellingid)";
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':factuurdatum', $factuurDatum, PDO::PARAM_STR);
            $stmt->bindParam(':factuurbedrag', $factuurBedrag, PDO::PARAM_STR);
            $stmt->bindParam(':voldaan', $voldaan, PDO::PARAM_INT);
            $stmt->bindParam(':bestellingid', $bestellingId, PDO::PARAM_INT);
            
            // EXECUTE STATEMENT (FACTUUR)
            $stmt->execute();
            
            header("Location: order_admin.php");
            exit();
        } catch(PDOException $e) {
            $_SESSION['error_message'] = "ERROR: Kan onderstaande statement niet uitvoeren.<br>$sql" . $e->getMessage();
            header("Location: order_error.php");
            exit();
        }
    }

?>

        <!-- HTML FORM SECTION -->
        <div class="container bg-cornflower rounded-3 my-5 p-3">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="accountid"><span class="fw-bold">Account ID<span>:</label>
                    <?php if (empty($accounts)) { ?>
                        <p class="text-muted">Geen accounts gevonden!</p>
                    <?php } else { ?>
                        <select class="form-select border border-dark" id="accountid" name="accountid">
                            <?php foreach ($accounts as $account) { ?>
                                <option value="<?php echo $account['AccountId']; ?>">
                                    <?php echo $account['AccountId'] . ' (' . $account['Voornaam'] . ' ' . $account['Achternaam'] . ')'; ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="typeid"><span class="fw-bold">Soort abonnement<span>:</label>
                    <select class="form-select border border-dark" id="typeid" name="typeid" required>
                        <option value="1">Evenement (Eenmalig)</option>
                        <option value="2">Parkeergarage (Maand)</option>
                        <option value="3">Parkeergarage (Kwartaal)</option>
                        <option value="4">Overheid (Jaar)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="orderdate"><span class="fw-bold">Order Date<span>:</label>
                    <input type="date" class="form-control border-dark" id="orderdate" name="orderdate" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-selective border border-dark my-2 fw-bold" name="submit" value="Submit">
                </div>
            </form>
        </div>
        <!-- /HTML FORM SECTION -->

<?php
    // LOAD FOOTER
    require_once ('../site/site_footer.php');

    // CLEAN UP
    $stmt = null;
    $pdo = null;
?>