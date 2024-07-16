<?php
    class User {
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

        // UPDATE ACCOUNT
        public function updateAccount($accountData) {
            $update_sql = 
               "UPDATE `accounts` 
                SET `Gebruikersnaam` = :username, `Wachtwoord` = :password, `Voornaam` = :firstname, `Achternaam` = :lastname, `Geslacht` = :gender, `Adres` = :address, `Woonplaats` = :city, `Postcode` = :zip, `GebDatum` = :dob, `Emailadres` = :mail, `Telefoonnummer` = :phone, `IBAN` = :iban, `RolId` = :rolid 
                WHERE `AccountId` = :accountid;";
            $stmt = $this->pdo->prepare($update_sql);
        
            $accountData['accountid'] = $this->accountid;
        
            // REPORTING
            if ($stmt->execute($accountData)) {
                return "Account bijgewerkt";
            } else {
                throw new Exception("Fout tijdens het bijwerken van account.");
            }
        }
    }

    // SESSION CONTROL
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    require_once ('../config.php');
    $page_Title = "Smartfalt - Admin - Account Bewerken";
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Admin</a> > Account bewerken';
    require_once ('../site/site_header_admin.php');
    require_once ('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once ('../db/db_connect.php');

    // ERROR HANDLING
    if (!isset($_GET['id'])) {
        $_SESSION['error_message'] = "Er bestaat geen account met ID: $id";
        header("Location: account_error.php");
        exit();
    }

    // EDIT FORM FOR USER
    $accountManager = new User($pdo, $_GET['id']);

    $account = $accountManager->fetchAccount();
    if (!$account) {
        $_SESSION['error_message'] = "Er bestaat geen account met ID: " . $_GET['id'];
        header("Location: account_error.php");
        exit;        
    }

    // UPDATE USER
    try {
        $accountDataArray = [];
        foreach ($_POST as $key => $value) {
            $accountDataArray[$key] = strip_tags(trim($value));
        }
        if (count($accountDataArray) > 0) {
            echo $accountManager->updateAccount($accountDataArray);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Foutmelding opgetreden: " . $e->getMessage();
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
        <section id="section-account-edit">
            <div class="container bg-cornflower rounded-3 my-5 p-3">
                <form id="edit-form" action="account_edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="form-group">
                        <label class="text-prussian" for="username"><span class="fw-bold">Gebruikersnaam<span>:</label>
                        <input type="text" class="form-control border border-dark" id="username" name="username" value="<?php echo $account['Gebruikersnaam']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="password"><span class="fw-bold">Wachtwoord<span>:</label>
                        <input type="password" class="form-control border border-dark" id="password" name="password" value="<?php echo $account['Wachtwoord']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="firstname"><span class="fw-bold">Voornaam<span>:</label>
                        <input type="text" class="form-control border border-dark" id="firstname" name="firstname" value="<?php echo $account['Voornaam']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="lastname"><span class="fw-bold">Achternaam<span>:</label>
                        <input type="text" class="form-control border border-dark" id="lastname" name="lastname" value="<?php echo $account['Achternaam']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender"><span class="fw-bold">Geslacht<span>:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender-m" value="M" <?php echo ($account['Geslacht'] === 'M') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="gender-m">M (Man)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender-f" value="F" <?php echo ($account['Geslacht'] === 'F') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="gender-f">F (Vrouw)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender-x" value="X" <?php echo ($account['Geslacht'] === 'X') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="gender-x">X (Anders)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="address"><span class="fw-bold">Adres<span>:</label>
                        <input type="text" class="form-control border border-dark" id="address" name="address" value="<?php echo $account['Adres']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="city"><span class="fw-bold">Woonplaats<span>:</label>
                        <input type="text" class="form-control border border-dark" id="city" name="city" value="<?php echo $account['Woonplaats']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="zip"><span class="fw-bold">Postcode<span>:</label>
                        <input type="text" class="form-control border border-dark" id="zip" name="zip" value="<?php echo $account['Postcode']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="dob"><span class="fw-bold">Geboortedatum<span>:</label>
                        <input type="date" class="form-control border border-dark" id="dob" name="dob" value="<?php echo $account['GebDatum']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="mail"><span class="fw-bold">E-mailadres<span>:</label>
                        <input type="email" class="form-control border border-dark" id="mail" name="mail" value="<?php echo $account['Emailadres']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="phone"><span class="fw-bold">Telefoonnummer<span>:</label>
                        <input type="tel" class="form-control border border-dark" id="phone" name="phone" value="<?php echo $account['Telefoonnummer']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="text-prussian" for="iban"><span class="fw-bold">IBAN<span>:</label>
                        <input type="tel" class="form-control border border-dark" id="iban" name="iban" value="<?php echo $account['IBAN']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="roleid"><span class="fw-bold">Rol<span>:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rolid" id="role-1" value="1" <?php echo ($account['RolId'] == '1') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="role-1">Administrator</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rolid" id="role-2" value="2" <?php echo ($account['RolId'] == '2') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="role-2">Medewerker</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rolid" id="role-3" value="3" <?php echo ($account['RolId'] == '3') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="role-3">Klant</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rolid" id="role-4" value="4" <?php echo ($account['RolId'] == '4') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="role-4">Leverancier</label>
                        </div>
                    </div>
                    <button type="submit" id="submit-button" class="btn btn-selective border border-dark my-2 fw-bold">Indienen</button>
                    <button type="button" class="btn btn-selective border border-dark m-2 fw-bold" onclick="goBack()">Terug</button>
                </form>
            </div>
        </section>
        <!-- /EDIT FORM -->

        <!-- EDIT FORM -->
        <section id="section-account-edit">
            <div class="container bg-cornflower rounded-3 my-5 p-3">
                <form id="edit-form" action="account_edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
                            <button type="submit" id="submit-button" class="btn btn-selective border border-dark my-2 fw-bold">Indienen</button>
                    <button type="button" class="btn btn-selective border border-dark m-2 fw-bold" onclick="goBack()">Terug</button>
                </form>
            </div>
        </section>
        <!-- /EDIT FORM -->

        <!-- EDIT FORM SCRIPT -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // GET FORM DATA
                var $form = $('#edit-form');
                var $submitButton = $('#submit-button');

                // DISABLE SUBMIT
                $submitButton.prop('disabled', true);

                // Store initial form data
                var initialFormData = $form.serialize();

                // EVENT LISTENER FOR CHANGE
                $form.on('change input', function() {
                    var currentFormData = $form.serialize();

                    // Check if the form data has changed
                    if (initialFormData !== currentFormData) {
                        $submitButton.prop('disabled', false);
                    } else {
                        $submitButton.prop('disabled', true);
                    }
                });

                // EVENT LISTENER FOR SUBMIT
                $form.on('submit', function(event) {
                    event.preventDefault();

                    // DISABLE SUBMIT
                    $submitButton.prop('disabled', true);

                    // AJAX REQUEST
                    $.ajax({
                        url: $form.attr('action'),
                        type: $form.attr('method'),
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function() {
                            $submitButton.html('<span class="fst-italic">Aanpassing voltooid..</span>');
                            setTimeout(function() {
                                $submitButton.prop('disabled', true);
                                $submitButton.html('<span class="fw-bold">Indienen<span>');
                            }, 3000);
                        },
                        error: function() {
                            $submitButton.html('<span class="fst-italic">Aanpassing mislukt..</span>');
                            setTimeout(function() {
                                $submitButton.prop('disabled', true);
                                $submitButton.html('<span class="fw-bold">Indienen<span>');
                            }, 3000);
                        }
                    });
                });
            });

            // GO BACK
            function goBack() {
                window.location.href = 'account_admin.php';
            }
        </script>
        <!-- /EDIT FORM SCRIPT -->

<?php
// CLEAN UP
$stmt = null;
$pdo = null;

require_once('../site/site_footer.php');
?>