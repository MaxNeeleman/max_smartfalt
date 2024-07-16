<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Admin</a> > Account Aanmaken';
    require_once ('../config.php');
    require_once ('../site/site_header_admin.php');
    require_once ('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once ('../db/db_connect.php');


    // CONNECT DB
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "ERROR: Kan geen verbinding met de database maken. " . $e->getMessage();
        header("Location: account_error.php");
        exit();
    }

    // SUBMIT DATA
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // SQL STATEMENT
            $sql = "INSERT INTO `accounts` (`Gebruikersnaam`, `Wachtwoord`, `Voornaam`, `Achternaam`, `Geslacht`, `Adres`, `Woonplaats`, `Postcode`, `GebDatum`, `Emailadres`, `Telefoonnummer`, `IBAN`, `RolId`) VALUES (:username, :password, :firstname, :lastname, :gender, :address, :city, :zip, :dob, :mail, :phone, :iban, :role)";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $_POST['firstname'], PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $_POST['lastname'], PDO::PARAM_STR);
            $stmt->bindParam(':gender', $_POST['gender'], PDO::PARAM_STR);
            $stmt->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
            $stmt->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
            $stmt->bindParam(':zip', $_POST['zip'], PDO::PARAM_STR);
            $stmt->bindParam(':dob', $_POST['dob'], PDO::PARAM_STR);
            $stmt->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
            $stmt->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
            $stmt->bindParam(':iban', $_POST['iban'], PDO::PARAM_STR);
            $stmt->bindParam(':role', $_POST['role'], PDO::PARAM_STR);

            // EXECUTE STATEMENT
            $stmt->execute();
            echo "New record created successfully.";
        } catch(PDOException $e) {
            $_SESSION['error_message'] = "ERROR: Kan onderstaande statement niet uitvoeren.<br>$sql" . $e->getMessage();
            header("Location: account_error.php");
            exit();
        }
    }
?>

        <!-- ACCOUNT NEW FORM -->
        <div class="container bg-cornflower rounded-3 my-5 p-3">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="username"><span class="fw-bold">Gebruikersnaam<span>:</label>
                    <input type="text" class="form-control border-dark" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="firstname"><span class="fw-bold">Wachtwoord<span>:</label>
                    <input type="password" class="form-control border-dark" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="firstname"><span class="fw-bold">Voornaam<span>:</label>
                    <input type="text" class="form-control border-dark" id="firstname" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="lastname"><span class="fw-bold">Achternaam<span>:</label>
                    <input type="text" class="form-control border-dark" id="lastname" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="gender"><span class="fw-bold">Geslacht<span>:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-m" value="m">
                        <label class="form-check-label" for="gender-m">M (Man)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-f" value="v">
                        <label class="form-check-label" for="gender-f">F (Vrouw)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-x" value="x">
                        <label class="form-check-label" for="gender-x">X (Anders)</label>
                    </div>
                </div>
                    <div class="form-group">
                    <label for="address"><span class="fw-bold">Adres<span>:</label>
                    <input type="text" class="form-control border-dark" id="address" name="address">
                </div>
                <div class="form-group">
                    <label for="zip"><span class="fw-bold">Postcode<span>:</label>
                    <input type="text" class="form-control border-dark" id="zip" name="zip">
                </div>
                <div class="form-group">
                    <label for="city"><span class="fw-bold">Woonplaats<span>:</label>
                    <input type="text" class="form-control border-dark" id="city" name="city">
                </div>
                <div class="form-group">
                    <label for="dob"><span class="fw-bold">Geboortedatum<span>:</label>
                    <input type="date" class="form-control border-dark" id="dob" name="dob">
                </div>
                <div class="form-group">
                    <label for="mail"><span class="fw-bold">E-Mailadres<span>:</label>
                    <input type="text" class="form-control border-dark" id="mail" name="mail" required>
                </div>
                <div class="form-group">
                    <label for="phone"><span class="fw-bold">Telefoonnummer<span>:</label>
                    <input type="text" class="form-control border-dark" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="phone"><span class="fw-bold">IBAN<span>:</label>
                    <input type="text" class="form-control border-dark" id="iban" name="iban">
                </div>
                <div class="form-group">
                    <label for="role"><span class="fw-bold">Rol<span>:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role-1" value="1" required>
                        <label class="form-check-label" for="role-m">Administrator</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role-2" value="2" required>
                        <label class="form-check-label" for="role-f">Medewerker</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role-3" value="3" required>
                        <label class="form-check-label" for="role-x">Klant</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="role-4" value="4" required>
                        <label class="form-check-label" for="role-x">Levernancier</label>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-selective border border-dark my-2 fw-bold" name="submit" value="Indienen">
                    <button type="button" class="btn btn-selective border border-dark m-2 fw-bold" onclick="goBack()">Terug</button>
                </div>
            </form>
        </div>
        <!-- /ACCOUNT NEW FORM -->

        <!-- ACCOUNT NEW SCRIPTS -->
        <script>
            // GO BACK
            function goBack() {
                window.location.href = 'account_admin.php';
            }
        </script>
        <!-- /ACCOUNT NEW SCRIPTS -->

<?php
    // CLEAN UP
    unset($pdo);
    require_once ('../site/site_footer.php');
?>