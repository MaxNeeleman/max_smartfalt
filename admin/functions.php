<?php
    // ALLE FUNCTIONS HIERIN KOMEN UIT DE LOSSE PHP-BESTANDEN (VAN PROCEDURAL NAAR OBJECT-ORIENTATED OMGEZET)

    class Accounts {
        protected $pdo;

        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        // account_admin.php
        public function getAccounts()
        {
            $sql = "SELECT accounts.*, AFBEELDINGEN.ProfilePicture FROM accounts 
                LEFT JOIN AFBEELDINGEN ON accounts.AccountId = AFBEELDINGEN.AccountId 
                ORDER BY accounts.AccountId;";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // account_delete.php
        function deleteAccount(int $accountId) : bool
        {
            $stmt = $this->pdo->prepare("DELETE FROM `accounts` WHERE `AccountId` = :accountid");
            $stmt->bindParam(':accountid', $accountId, PDO::PARAM_INT);
        
            try {
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                error_log("Error deleting account: " . $e->getMessage());
                return false;
            }
        }
        
        // account_new.php
        function createAccount(array $accountDetails): bool
        {
            $sql = "INSERT INTO `accounts` (`Gebruikersnaam`, `Wachtwoord`, `Voornaam`, `Achternaam`, `Geslacht`, `Adres`, `Woonplaats`, `Postcode`, `GebDatum`, `Emailadres`, `Telefoonnummer`, `IBAN`, `RolId`) 
            VALUES (:username, :password, :firstname, :lastname, :gender, :address, :city, :zip, :dob, :mail, :phone, :iban, :role)";
        
            $stmt = $this->pdo->prepare($sql);
        
            foreach ($accountDetails as $key => $value) {
                $stmt->bindValue(':'.$key, $value);
            }
        
            try {
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                error_log("Error creating account: " . $e->getMessage());
                return false;
            }
        }
    }