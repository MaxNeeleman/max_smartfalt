-- -----------------------------------------------------------------------------
-- DML: DATA MANIPULATION LANGUAGE -> Voeg data toe aan de bestaande tabellen --
-- -----------------------------------------------------------------------------
USE `SMARTFALT`;

INSERT INTO `ROLLEN` (`RolId`, `TypeRol`) VALUES ('1', 'Administrator'), ('2', 'Werknemer'), ('3', 'Klant'), ('4', 'Leverancier');

INSERT INTO `ACCOUNTS` (`AccountId`, `Gebruikersnaam`, `Wachtwoord`, `Voornaam`, `Achternaam`, `Geslacht`, `Woonplaats`, `Postcode`, `GebDatum`, `Emailadres`, `Telefoonnummer`, `RolId`, `IBAN`)
VALUES  ('1017', 'gvhamsteren', 'H@mst3r3n!', 'Gerrit', 'Hamsteren, van', 'm', 'Hamsterdam', '1200AA', '2001-03-24', 'gvhamsteren@mail.ru', '+316123789456', '3', 'NL91ABNA0417164300'),
        (NULL, 'prutten', 'Dit is niet jouw wachtwoord, vriend', 'Paul', 'Rutten', 'm', 'Dordrecht', '3315ZA', '1981-07-22', 'p.rutten@smartfalt.nl', '+314563423343', '4', 'NL52INGB0000000000'),
        (NULL, 'mneeleman', 'Wormlifematters', 'Max', 'Neeleman', 'm', 'Nijbijgelegen', '1234AA', '1999-12-07', 'm.neeleman@smartfalt.nl', '+31621343129', '2', 'NL31RABO0123456789'),
        (NULL, 'nrattansingh', 'Ja toch, niet dan?', 'Neesha', 'Rattansingh', 'v', 'Rotterdam', '3300ZX', '2001-08-19', 'n.rattansingh@smartfalt.nl', '+313452345234', '2', 'NL90SNSB0918273645'),
        (NULL, 'drisovic', 'JavaScriptM@ster123', 'Denis', 'Risovic', 'm', 'Zwijndrecht', '3350GS', '1998-10-03', 'd.risovic@smartfalt.nl', '+31322345232', '3', 'NL73KNAB0604511557');

INSERT INTO `ABONNEMENTTYPES` (`TypeId`, `Omschrijving`, `Looptijd`, `Prijs`) VALUES
(1, 'Evenement', 'Eenmalig', 500.00),
(2, 'Parkeergarage', '1 maand', 250.00),
(3, 'Parkeergarage: voordeling', '1 kwartaal', 700.00),
(4, 'Gemeentes en de overheid', '1 jaar', 5000.00);

INSERT INTO `BESTELLINGEN` (`BestellingId`, `AccountId`, `Besteldatum`, `TypeId`) VALUES
(1, 1017, '2022-01-01', 1),
(2, 1018, '2022-02-01', 2),
(3, 1019, '2022-03-01', 3),
(4, 1020, '2022-03-15', 1);

INSERT INTO `ABONNEMENTEN` (`AbonnementId`, `IngangsDatum`, `Actief`, `BestellingId`) VALUES
(1, '2022-01-01', true, 1),
(2, '2022-02-01', true, 2),
(3, '2022-03-01', false, 3);


INSERT INTO `INCASSOS` (`IncassoId`, `BankAkkoord`, `AbonnementId`) VALUES 
(1, true, 1),
(2, true, 2),
(3, false, 3);

INSERT INTO `FACTUREN` (`FactuurId`, `FactuurDatum`, `FactuurBedrag`, `Voldaan`, `BestellingId`) VALUES
(1, '2022-01-01', 500.00, true, 1),
(2, '2022-02-01', 250.00, true, 2), 
(3, '2022-03-01', 700.00, false, 3);