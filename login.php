<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // CONNECT DB
    require_once "db/db_connect.php";

    // CREATE RESPONSE ARRAY
    $response = array();
 
    // CHECK POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['username']) || empty($_POST['password'])) {
        $response['error'] = 'Onjuiste invoer!';
        echo json_encode($response);
        exit();
    }

    // STORE CREDENTIALS
    $username = $_POST['username'];
    $password = $_POST['password'];

    // CHECK CREDENTIALS
    try {
        // PREPARE SQL
        $sql = "SELECT * FROM accounts WHERE Gebruikersnaam = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // ERROR HANDLING
        if ($stmt->rowCount() !== 1) {
            throw new Exception('Geen gebruiker gevonden met deze gebruikersnaam');
        }

        $row = $stmt->fetch();
        if ($password !== $row['Wachtwoord']) {
            throw new Exception('Verkeerd wachtwoord');
        }

        // GET PROFILE PICTURE IF AVAILABLE
        $pic = "SELECT * FROM afbeeldingen WHERE AccountId = :accountid";
        $stmt2 = $pdo->prepare($pic);
        $stmt2->bindParam(':accountid', $row['AccountId'], PDO::PARAM_STR);
        $stmt2->execute();
        $row2 = $stmt2->fetch();

        // CHECK PROFILE PICTURE
        if ($stmt2->rowCount() === 1) {
            $_SESSION['ProfilePic'] = $row2['ProfilePicture'];
        } 

        // SET SESSION DATA
        $_SESSION['AccountId'] = $row['AccountId'];
        $_SESSION['Gebruikersnaam'] = $row['Gebruikersnaam'];
        $_SESSION['RolId'] = $row['RolId'];

        // SEND RESPONSE
        $response['success'] = true;

    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

    // OUTPUT RESULT FOR DEBUG
    if ($response['success'] === true) {
        header('Location: ' . ROOT_URL . 'index.php');
        exit();
    } else {
        // ERROR HANDLING
        $_SESSION['error_message'] = $response['error'];
        header("Location: error.php");
        exit();
    }    
?>
