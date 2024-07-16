-- -----------------------------------------------------------------------------
-- DML: DATA MANIPULATION LANGUAGE -> Voeg data toe aan de bestaande tabellen --
-- -----------------------------------------------------------------------------
USE `SMARTFALT`;

INSERT INTO `ROLLEN` (`RolId`, `TypeRol`) VALUES ('1', 'Administrator'), ('2', 'Werknemer'), ('3', 'Klant'), ('4', 'Leverancier');

INSERT INTO `ACCOUNTS` (`AccountId`, `Gebruikersnaam`, `Wachtwoord`, `Voornaam`, `Achternaam`, `Geslacht`, `Adres`, `Woonplaats`, `Postcode`, `GebDatum`, `Emailadres`, `Telefoonnummer`, `IBAN`, `RolId`)
VALUES
    ('00001018','psmit', 'password2', 'Pieter', 'Smit', 'M', 'Hoofdweg 10', 'Rotterdam', '3011BB', '1972-12-02', 'psmit@email.nl', '0623456789', 'NL03ABNA0234567890', 2),
    ('00001017','jdevries', 'password1', 'Jan', 'de Vries', 'M', 'Kerkstraat 1', 'Amsterdam', '1011AA', '1985-01-20', 'jdevries@email.nl', '0612345678', 'NL02ABNA0123456789', 1),
    ('00001019','mdejong', 'password3', 'Marieke', 'de Jong', 'F', 'Dorpsstraat 20', 'Utrecht', '3511CC', '1980-03-03', 'mdejong@email.nl', '0634567890', 'NL04ABNA0345678901', 3),
    ('00001020','kvandijk', 'password4', 'Klaas', 'van Dijk', 'M', 'Nieuwstraat 30', 'Den Haag', '2511DD', '1990-04-04', 'kvandijk@email.nl', '0645678901', 'NL05ABNA0456789012', 4),
    ('00001021','vdeboer', 'password5', 'Vera', 'de Boer', 'F', 'Schoolstraat 40', 'Groningen', '9711EE', '1987-05-05', 'vdeboer@email.nl', '0656789012', 'NL06ABNA0567890123', 1),
    ('00001022','bmeijer', 'password6', 'Bram', 'Meijer', 'M', 'Kanaalstraat 50', 'Eindhoven', '5611FF', '1992-06-06', 'bmeijer@email.nl', '0667890123', 'NL07ABNA0678901234', 2),
    ('00001023','fvanbeek', 'password7', 'Femke', 'van Beek', 'F', 'Molenweg 60', 'Tilburg', '6011GG', '1993-07-07', 'fvanbeek@email.nl', '0678901234', 'NL08ABNA0789012345', 3),
    ('00001024','gdehaan', 'password8', 'Gerard', 'de Haan', 'M', 'Marktstraat 70', 'Almere', '1311HH', '1991-08-08', 'gdehaan@email.nl', '0689012345', 'NL09ABNA0890123456', 4),
    ('00001025','hvandam', 'password9', 'Hanneke', 'van Dam', 'F', 'Stationsweg 80', 'Breda', '4811II', '1986-09-09', 'hvandam@email.nl', '0690123456', 'NL10ABNA0901234567', 1),
    ('00001026','jvisser', 'password10', 'Joost', 'Visser', 'M', 'Beekstraat 90', 'Nijmegen', '5911JJ', '1984-10-10', 'jvisser@email.nl', '0701234567', 'NL11ABNA1012345678', 2);


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