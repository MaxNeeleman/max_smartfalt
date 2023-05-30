<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    require_once ('../config.php');
    $page_Title = "Smartfalt - Admin - Account Aanmaken";
    $admin_page_title = '<a href="../index.php">Smartfalt</a> - <a href="index.php">Admin</a> - Account Aanmaken';
    require_once ('../site/site_admin_header.php');
    require_once ('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');

    // CONNECT NAAR DB
    try {
        $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "ERROR: Kan geen verbinding met de database maken. " . $e->getMessage();
        header("Location: account_error.php");
        exit();
    }

    // SUBMIT GEGEVENS
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // SQL statement
            $sql = "INSERT INTO `accounts` (`Username`, `Password`, `Firstname`, `Lastname`, `Gender`, `Address`, `Zip`, `City`, `Country`, `DOB`, `Mail`, `Phone`, `IBAN`) VALUES (:username, :password, :firstname, :lastname, :gender, :address, :zip, :city, :country, :dob, :mail, :phone, :iban)";

            $stmt = $connection->prepare($sql);

            $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $_POST['firstname'], PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $_POST['lastname'], PDO::PARAM_STR);
            $stmt->bindParam(':gender', $_POST['gender'], PDO::PARAM_STR);
            $stmt->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
            $stmt->bindParam(':zip', $_POST['zip'], PDO::PARAM_STR);
            $stmt->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
            $stmt->bindParam(':country', $_POST['country'], PDO::PARAM_STR);
            $stmt->bindParam(':dob', $_POST['dob'], PDO::PARAM_STR);
            $stmt->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
            $stmt->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
            $stmt->bindParam(':iban', $_POST['iban'], PDO::PARAM_STR);

            // Execute statement
            $stmt->execute();
            echo "New record created successfully.";
        } catch(PDOException $e) {
            die("ERROR: Could not execute $sql. " . $e->getMessage());
        }
    }
?>

        <!-- FORM -->
        <div class="container bg-cornflower rounded-3 my-5 p-3">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="username"><strong>Gebruikersnaam</strong>:</label>
                    <input type="text" class="form-control border-dark" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="firstname"><strong>Wachtwoord</strong>:</label>
                    <input type="password" class="form-control border-dark" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="firstname"><strong>Voornaam</strong>:</label>
                    <input type="text" class="form-control border-dark" id="firstname" name="firstname">
                </div>
                <div class="form-group">
                    <label for="lastname"><strong>Achternaam</strong>:</label>
                    <input type="text" class="form-control border-dark" id="lastname" name="lastname">
                </div>
                <div class="form-group">
                    <label for="gender"><strong>Geslacht</strong>:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-m" value="M">
                        <label class="form-check-label" for="gender-m">M (Man)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-f" value="F">
                        <label class="form-check-label" for="gender-f">F (Vrouw)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-x" value="X">
                        <label class="form-check-label" for="gender-x">X (Anders)</label>
                    </div>
                    </div>
                                <div class="form-group">
                    <label for="address"><strong>Adres</strong>:</label>
                    <input type="text" class="form-control border-dark" id="address" name="address">
                </div>
                <div class="form-group">
                    <label for="zip"><strong>Postcode</strong>:</label>
                    <input type="text" class="form-control border-dark" id="zip" name="zip">
                </div>
                <div class="form-group">
                    <label for="city"><strong>Woonplaats</strong>:</label>
                    <input type="text" class="form-control border-dark" id="city" name="city">
                </div>
                <div class="form-group">
                    <label for="city"><strong>Country</strong>:</label>
                    <input type="text" class="form-control border-dark" id="country" name="country">
                </div>
                <div class="form-group">
                    <label for="dob"><strong>Geboortedatum</strong>:</label>
                    <input type="date" class="form-control border-dark" id="dob" name="dob">
                </div>
                <div class="form-group">
                    <label for="mail"><strong>E-Mailadres</strong>:</label>
                    <input type="text" class="form-control border-dark" id="mail" name="mail">
                </div>
                <div class="form-group">
                    <label for="phone"><strong>Telefoonnummer</strong>:</label>
                    <input type="text" class="form-control border-dark" id="phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="phone"><strong>IBAN</strong>:</label>
                    <input type="text" class="form-control border-dark" id="iban" name="iban">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-selective border border-dark my-2 font-weight-bold" name="submit" value="Indienen">
                    <button type="button" class="btn btn-selective border border-dark m-2" onclick="goBack()"><strong>Terug</strong></button>
                </div>
            </form>
        </div>
        <!-- /FORM -->

        <!-- SCRIPTS -->
        <script>
            // GO BACK
            function goBack() {
               window.history.back();
            }
        </script>
        <!-- /SCRIPTS -->

<?php
    // CLEAN UP
    unset($connection);
    require_once ('../site/site_footer.php');
?>
