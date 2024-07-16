<?php
    class Orders {
        private $pdo;
    
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
    
        public function fetchOrders() {
            $sql = "SELECT 
                    `BESTELLINGEN`.`Besteldatum`, 
                    `BESTELLINGEN`.`AccountId`,
                    `ACCOUNTS`.`Voornaam`,
                    `ACCOUNTS`.`Achternaam`,
                    `ACCOUNTS`.`Emailadres`,
                    `BESTELLINGEN`.`TypeId`,
                    `BESTELLINGEN`.`BestellingId`,
                    `FACTUREN`.`FactuurId`,
                    `FACTUREN`.`FactuurDatum`,
                    `FACTUREN`.`FactuurBedrag`,
                    `FACTUREN`.`Voldaan`,
                    `INCASSOS`.`IncassoId`,
                    `INCASSOS`.`BankAkkoord`
                FROM `BESTELLINGEN`
                LEFT JOIN `ACCOUNTS` ON `BESTELLINGEN`.`AccountId` = `ACCOUNTS`.`AccountId`
                LEFT JOIN `FACTUREN` ON `BESTELLINGEN`.`BestellingId` = `FACTUREN`.`BestellingId`
                LEFT JOIN `ABONNEMENTEN` ON `BESTELLINGEN`.`BestellingId` = `ABONNEMENTEN`.`BestellingId`
                LEFT JOIN `INCASSOS` ON `ABONNEMENTEN`.`AbonnementId` = `INCASSOS`.`AbonnementId`
                ORDER BY `BESTELLINGEN`.`Besteldatum`;";
            
            // SQL PREPARE DATA
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createNewOrder($accountId, $typeId, $orderDate) {
            // SQL PREPARE DATA
            $sql = "INSERT INTO BESTELLINGEN (AccountId, TypeId, Besteldatum, FactuurBedrag)
                    VALUES (:accountId, :typeId, :orderDate)";
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->bindParam(':accountId', $accountId);
            $stmt->bindParam(':typeId', $typeId);
            $stmt->bindParam(':orderDate', $orderDate);
    
            $stmt->execute();
            return true;
        }

        public function fetchInvoice() {
            $stmt = $this->pdo->prepare("SELECT 
            `FACTUREN`.*, `BESTELLINGEN`.`TypeId` 
            FROM `FACTUREN`
            INNER JOIN `BESTELLINGEN` ON `FACTUREN`.`BestellingId` = `BESTELLINGEN`.`BestellingId`
            WHERE `FACTUREN`.`BestellingId` = :bestellingid");
            $stmt->bindParam(':bestellingid', $this->bestellingid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function fetchAccounts() {
            $stmt = $this->pdo->prepare("SELECT `bestellingen`.`BestellingId`, `bestellingen`.`AccountId`, `accounts`.`Voornaam`, `accounts`.`Achternaam` FROM `bestellingen` JOIN `accounts` ON `bestellingen`.`AccountId` = `accounts`.`AccountId` WHERE `bestellingen`.`BestellingId` = :bestellingid");
            $stmt->bindParam(':bestellingid', $this->bestellingid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }