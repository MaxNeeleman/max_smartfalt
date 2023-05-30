<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    require_once ('../config.php');
    $page_Title = "Smartfalt - Admin - Account Bewerken";
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Admin</a> > Account bewerken';
    require_once ('../site/site_admin_header.php');

    $id = $_GET['id'];

    // CONNECT NAAR DB
    try {
        $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "Kan geen verbinding maken met de database: " . $e->getMessage();
        header("Location: account_error.php");
        exit;
    }

    // SUBMIT FORM
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = strip_tags(trim($_POST['username']));
        $password = strip_tags(trim($_POST['password']));
        $firstname = strip_tags(trim($_POST['firstname']));
        $lastname = strip_tags(trim($_POST['lastname']));
        $gender = strip_tags(trim($_POST['gender']));
        $address = strip_tags(trim($_POST['address']));
        $zip = strip_tags(trim($_POST['zip']));
        $city = strip_tags(trim($_POST['city']));
        $country = strip_tags(trim($_POST['country']));
        $dob = strip_tags(trim($_POST['dob']));
        $mail = strip_tags(trim($_POST['mail']));
        $phone = strip_tags(trim($_POST['phone']));
        $iban = strip_tags(trim($_POST['iban']));

        $update_sql = "UPDATE `accounts` SET `Username` = :username, `Password` = :password, `Firstname` = :firstname, `Lastname` = :lastname, `Gender` = :gender, `Address` = :address, `Zip` = :zip, `City` = :city, `Country` = :country, `DOB` = :dob, `Mail` = :mail, `Phone` = :phone, `IBAN` = :iban WHERE `Id` = :id;";
        $stmt = $connection->prepare($update_sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':iban', $iban);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            if ($stmt->execute()) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record.";
            }
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Foutmelding opgetreden: " . $e->getMessage();
            header("Location: account_error.php");
            exit;
        }
    }

    // SQL QUERY
    $stmt = $connection->prepare("SELECT * FROM `accounts` WHERE `Id` = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if($stmt->rowCount() == 0) {
        // Zet error message in session
        $_SESSION['error_message'] = "Er bestaat geen account met dit ID.";
        header('Location: account_error.php');
        exit;
    }

    // GET DATA
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
?>


        <!-- EDIT FORM -->
        <div class="container bg-cornflower rounded-3 my-5 p-3">
            <form action="account_edit.php?id=<?php echo $id; ?>" method="POST">
                <div class="form-group">
                    <label class="text-prussian" for="username"><strong>Gebruikersnaam</strong>:</label>
                    <input type="text" class="form-control border border-dark" id="username" name="username" value="<?php echo $account['Username']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="password"><strong>Wachtwoord</strong>:</label>
                    <input type="password" class="form-control border border-dark" id="password" name="password" value="<?php echo $account['Password']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="firstname"><strong>Voornaam</strong>:</label>
                    <input type="text" class="form-control border border-dark" id="firstname" name="firstname" value="<?php echo $account['Firstname']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="lastname"><strong>Achternaam</strong>:</label>
                    <input type="text" class="form-control border border-dark" id="lastname" name="lastname" value="<?php echo $account['Lastname']; ?>">
                </div>
                <div class="form-group">
                    <label for="gender"><strong>Geslacht</strong>:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-m" value="M" <?php echo ($account['Gender'] === 'M') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gender-m">M (Man)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-f" value="F" <?php echo ($account['Gender'] === 'F') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gender-f">F (Vrouw)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender-x" value="X" <?php echo ($account['Gender'] === 'X') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gender-x">X (Anders)</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="address"><strong>Adres</strong>:</label>
                    <input type="text" class="form-control border border-dark" id="address" name="address" value="<?php echo $account['Address']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="zip"><strong>Postcode</strong>:</label>
                    <input type="text" class="form-control border border-dark" id="zip" name="zip" value="<?php echo $account['Zip']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="city"><strong>Woonplaats</strong>:</label>
                    <input type="text" class="form-control border border-dark" id="city" name="city" value="<?php echo $account['City']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="country"><strong>Land</strong>:</label>
                    <input type="text" class="form-control border border-dark" id="country" name="country" value="<?php echo $account['Country']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="dob"><strong>Geboortedatum</strong>:</label>
                    <input type="date" class="form-control border border-dark" id="dob" name="dob" value="<?php echo $account['DOB']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="mail"><strong>E-mailadres</strong>:</label>
                    <input type="email" class="form-control border border-dark" id="mail" name="mail" value="<?php echo $account['Mail']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="phone"><strong>Telefoonnummer</strong>:</label>
                    <input type="tel" class="form-control border border-dark" id="phone" name="phone" value="<?php echo $account['Phone']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-prussian" for="iban"><strong>IBAN</strong>:</label>
                    <input type="tel" class="form-control border border-dark" id="iban" name="iban" value="<?php echo $account['IBAN']; ?>">
                </div>
                <button type="submit" id="submit-button" class="btn btn-selective border border-dark my-2"><strong>Indienen</strong></button>
                <button type="button" class="btn btn-selective border border-dark m-2" onclick="goBack()"><strong>Terug</strong></button>
            </form>
        </div>
        <!-- /EDIT FORM -->

        <!-- SCRIPT -->
        <script>
            // Haal formulier gegevens op
            var form = document.querySelector('form');
            var submitButton = document.getElementById('submit-button');

            // Maak een kopie om te vergelijken (of er iets gewijzigd is)
            var formData = new FormData(form);

            // Zet 'submit' knop uit (tot er daadwerkelijk iets veranderd is)
            submitButton.disabled = true;

            // Event listener voor aanpassingen aan het formulier
            form.addEventListener('input', function() {
                var newFormData = new FormData(form);
                for(var [key, val] of newFormData.entries()) {
                    if(val != formData.get(key)) {
                        submitButton.disabled = false;
                        break;
                    }
                }
            });

            // Event listener voor het indienen van het formulier
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Zet de knop uit
                submitButton.disabled = true;

                // AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open(form.method, form.action);
                xhr.onreadystatechange = function() {
                    if(xhr.readyState == 4 && xhr.status == 200) {
                        formData = new FormData(form);
                        submitButton.innerHTML = '> Aanpassing voltooid..';
                        setTimeout(function() {
                            submitButton.disabled = true;
                            submitButton.innerHTML = 'Indienen';
                        }, 3000);
                    }
                    else if(xhr.readyState == 4) {
                        submitButton.innerHTML = '> Aanpassing mislukt..';
                        setTimeout(function() {
                            submitButton.disabled = true;
                            submitButton.innerHTML = 'Indienen';
                        }, 3000);
                    }
                }
                xhr.send(new FormData(form));
            });

            // GO BACK
            function goBack() {
               window.history.back();
            }
        </script>
        <!-- /SCRIPT -->

<?php
    // CLEAN UP
    if(isset($connection)) {
        unset($connection);
    }
    require_once ('../site/site_footer.php');
?>
