-- -------------------------------------------------------------------------------
-- DDL: DATA DEFINITION LANGUAGE -> Aanmaken van de tabellen binnen de database --
-- -------------------------------------------------------------------------------

DROP DATABASE IF EXISTS `SMARTFALT`;
CREATE DATABASE `SMARTFALT`;

USE `SMARTFALT`;

CREATE TABLE `ROLLEN` (
    `RolId` INT(1) NOT NULL PRIMARY KEY,
    `TypeRol` VARCHAR(30)
);

CREATE TABLE `ACCOUNTS` (
    `AccountId` INT(8) ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Profielfoto` BLOB,
    `Gebruikersnaam` VARCHAR(30) NOT NULL,
    `Wachtwoord` VARCHAR(64) NOT NULL,
    `Voornaam` VARCHAR(30),
    `Achternaam` VARCHAR(50),
    `Geslacht` VARCHAR(1),
    `Adres` VARCHAR(250),
    `Woonplaats` VARCHAR(50),
    `Postcode` VARCHAR(6),
    `GebDatum` DATE,
    `Emailadres` VARCHAR(50) NOT NULL,
    `Telefoonnummer` VARCHAR(15),
    `IBAN` VARCHAR(18),
    `RolId` INT(1),
    CONSTRAINT `fk_Accounts_Rollen` FOREIGN KEY (`RolId`) REFERENCES `ROLLEN`(`RolId`) ON UPDATE CASCADE ON DELETE SET NULL
);


CREATE TABLE `ABONNEMENTTYPES` (
    `TypeId` INT(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Omschrijving` VARCHAR(255),
    `Looptijd` VARCHAR(20),
    `Prijs` DECIMAL(8,2)
);

CREATE TABLE `BESTELLINGEN` (
    `BestellingId` INT(8) ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `AccountId` INT(8) ZEROFILL,
    `Besteldatum` DATE NOT NULL,
    `TypeId` INT(1),
    CONSTRAINT `fk_Bestellingen_Accounts` FOREIGN KEY (`AccountId`) REFERENCES `ACCOUNTS`(`AccountId`) ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT `fk_Bestellingen_Abonnementtypes` FOREIGN KEY (`TypeId`) REFERENCES `ABONNEMENTTYPES`(`TypeId`) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE `ABONNEMENTEN` (
    `AbonnementId` INT(2) NOT NULL PRIMARY KEY,
    `IngangsDatum` DATE,
    `Actief` BOOLEAN,
    `BestellingId` INT(8) ZEROFILL,
    CONSTRAINT `fk_Abonnementen_Bestellingen` FOREIGN KEY (`BestellingId`) REFERENCES `BESTELLINGEN`(`BestellingId`) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE `INCASSOS` (
    `IncassoId` INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `BankAkkoord` BOOLEAN,
    `AbonnementId` INT(2),
    CONSTRAINT `fk_Incassos_Abonnementen` FOREIGN KEY (`AbonnementId`) REFERENCES `ABONNEMENTEN`(`AbonnementId`) ON UPDATE CASCADE ON DELETE SET NULL
);


CREATE TABLE `FACTUREN` (
    `FactuurId` INT(10) ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FactuurDatum` DATE NOT NULL,
    `FactuurBedrag` DECIMAL(8, 2) NOT NULL,
    `Voldaan` BOOLEAN,
    `BestellingId` INT(8) ZEROFILL,
    CONSTRAINT `fk_Facturen_Bestellingen` FOREIGN KEY (`BestellingId`) REFERENCES `BESTELLINGEN`(`BestellingId`) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE `AFBEELDINGEN` (
    `PictureId` INT(8) ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `AccountId` INT(8) ZEROFILL,
    `ProfilePicture` LONGBLOB,
    CONSTRAINT `fk_ProfilePictures_Accounts` FOREIGN KEY (`AccountId`) REFERENCES `ACCOUNTS`(`AccountId`) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE `ZOEKEN` (
    `ZoekId` INT(10) ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ZoekOpdracht` TEXT NOT NULL
);

/*
 Alternatieve methode om PRIMARY of FOREIGN KEY kolommen aan te maken:

 ALTER TABLE `BESTELLINGEN`
 ADD PRIMARY KEY (`OrderNummer`);
 COMMIT;
 
 ALTER TABLE `FACTUREN`
 ADD CONSTRAINT FOREIGN KEY (`factuurNummer`) REFERENCES `ABONNEMENTEN(`AbonnementsType`) ON UPDATE CASCADE ON DELETE SET NULL;
 COMMIT;
 */


-- STORED PROCEDURES

DELIMITER $$
CREATE PROCEDURE MaakAccount (
    IN `AccountId` INT(8),
    IN `Gebruikersnaam` VARCHAR(30),
    IN `Wachtwoord` VARCHAR(64),
    IN `Voornaam` VARCHAR(30),
    IN `Achternaam` VARCHAR(30),
    IN `Geslacht` VARCHAR(1),
    IN `Woonplaats` VARCHAR(50),
    IN `Postcode` VARCHAR(6),
    IN `GebDatum` DATE,
    IN `Emailadres` VARCHAR(50),
    IN `Telefoonnummer` VARCHAR(15),
    IN `IBAN` VARCHAR(18),
    IN `RolId` INT(1)
)
BEGIN
    INSERT INTO `ACCOUNTS` (`AccountId`, `Gebruikersnaam`, `Wachtwoord`, `Voornaam`, `Achternaam`, `Geslacht`, `Woonplaats`, `Postcode`, `GebDatum`, `Emailadres`, `Telefoonnummer`, `IBAN`, `RolId`)
    VALUES (`AccountId`, `Gebruikersnaam`, `Wachtwoord`, `Voornaam`, `Achternaam`, `Geslacht`, `Woonplaats`, `Postcode`, `GebDatum`, `Emailadres`, `Telefoonnummer`, `IBAN`, `RolId`);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE PlaatsBestelling (
    IN `BestellingId` INT(8),
    IN `AccountId` INT(8),
    IN `Besteldatum` DATE,
    IN `TypeId` INT(1)
)
BEGIN
    INSERT INTO `BESTELLINGEN` (`BestellingId`, `AccountId`, `Besteldatum`, `TypeId`)
    VALUES (`BestellingId`, `AccountId`, `Besteldatum`, `TypeId`);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE ActiveerAbonnement (
    IN `AbonnementId` INT(2),
    IN `IngangsDatum` DATE,
    IN `Actief` BOOLEAN,
    IN `BestellingId` INT(8)
)
BEGIN
    INSERT INTO `ABONNEMENTEN` (`AbonnementId`, `IngangsDatum`, `Actief`, `BestellingId`)
    VALUES (`AbonnementId`, `IngangsDatum`, `Actief`, `BestellingId`);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `GetBestellingenEnFacturen` (
    IN `pAccountId` INT(8)
)
BEGIN
    SELECT `BESTELLINGEN`.`BestellingId`, `BESTELLINGEN`.`Besteldatum`, `FACTUREN`.`FactuurId`, `FACTUREN`.`FactuurDatum`, `FACTUREN`.`FactuurBedrag`, `FACTUREN`.`Voldaan`
    FROM `BESTELLINGEN`
    LEFT JOIN `FACTUREN` ON `BESTELLINGEN`.`BestellingId` = `FACTUREN`.`BestellingId`
    WHERE `BESTELLINGEN`.`AccountId` = pAccountId;
END$$
DELIMITER ;


-- STORED FUNCTIONS

DELIMITER $$
CREATE FUNCTION BetalingVoldaan (invoer_Factuurid INT) RETURNS BOOLEAN
BEGIN
  UPDATE `FACTUREN` SET `Voldaan` = true WHERE `Factuurid` = invoer_Factuurid;
  RETURN true;
END$$
DELIMITER ;

DELIMITER $$
CREATE FUNCTION TotaalActieveAbonnementen() RETURNS INT
BEGIN
  DECLARE totaal INT;
  SELECT COUNT(*) INTO totaal FROM `ABONNEMENTEN` WHERE `Actief` = true;
  RETURN totaal;
END$$
DELIMITER ;

-- TRIGGERS

DROP TRIGGER IF EXISTS WijzigenPrijs;
DELIMITER $$
CREATE TRIGGER WijzigenPrijs BEFORE UPDATE ON `ABONNEMENTTYPES`
FOR EACH ROW
BEGIN
    IF NEW.Prijs <> OLD.Prijs THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Prijs kan niet worden aangepast';
    END IF;
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS WijzigenRol;
DELIMITER $$
CREATE TRIGGER WijzigenRol BEFORE UPDATE ON `ACCOUNTS`
FOR EACH ROW
BEGIN
    IF OLD.RolId IN (3,4) AND NEW.RolId IN (1,2) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'RolId kan niet worden gewijzigd van Klant (3) of Leverancier (4) naar Administrator (1) of Werknemer (2)';
    END IF;
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS UpdateIngangsdatum;
DELIMITER $$
CREATE TRIGGER UpdateIngangsdatum BEFORE INSERT ON `ABONNEMENTEN`
FOR EACH ROW 
BEGIN
    IF NEW.IngangsDatum <> now() THEN
        SET NEW.IngangsDatum = now();
    END IF;
END $$
DELIMITER ;
