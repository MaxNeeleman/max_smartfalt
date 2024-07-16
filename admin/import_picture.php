<?php
    require_once('../config.php');
    require_once('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once('../db/db_connect.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // CHECK FOR ERRORS
        if (isset($_FILES["profielImg"]) && $_FILES["profielImg"]["error"] == 0) {

            // ALLOWED FILES (MIME TYPES) -> https://developer.mozilla.org/en-US/docs
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            
            // STORE FILE INFORMATION
            $filename = $_FILES["profielImg"]["name"];
            $filetype = $_FILES["profielImg"]["type"];
            $filesize = $_FILES["profielImg"]["size"];

            // VERIFY FILE EXTENSION 
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!array_key_exists($ext, $allowed)) {
                $_SESSION['error_message'] = "Error: Geen geldige afbeeldingsindeling of bestandsformaat!";
                header("Location: account_error.php");
                exit;
            }

            // VERIFY FILE SIZE (MAX 1MB) -> https://stackoverflow.com/questions/49444995/php-limit-upload-size-validation
            $maxsize = 1 * 1024 * 1024;
            if ($filesize > $maxsize) {
                $_SESSION['error_message'] = "Error: Het plaatje is groter dan 1 MB!";
                header("Location: account_error.php");
                exit;
            }

            // VERIFY MIME TYPES -> https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types
            if (in_array($filetype, $allowed)) {

                // CONVERT IMAGE TO BASE64 BINARY -> https://www.codespeedy.com/how-to-convert-an-image-to-binary-image-in-php/
                $imageData = file_get_contents($_FILES["profielImg"]["tmp_name"]);

                // GET ACCOUNTID FROM MODAL
                $accountId = $_POST['accountId'];

                // INSERT IMAGE DATA INTO DATABASE
                $query = "INSERT INTO AFBEELDINGEN (AccountId, ProfilePicture) VALUES (?, ?)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$accountId, $imageData]);

                header("Location: account_admin.php");
                exit;
            } else {
                $_SESSION['error_message'] = "Error: Tijdens het uploaden van het bestand zijn fouten ontstaan. Probeer het opnieuw.";
                header("Location: account_error.php");
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Error: " . $_FILES["profielImg"]["error"];
            header("Location: account_error.php");
            exit;
        }
    }
?>