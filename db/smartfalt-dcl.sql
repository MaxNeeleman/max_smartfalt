-- -------------------------------------------------------------------------------------
-- DCL: DATA CONTROL LANGUAGE -> Zet rechten op verschillende niveaus van de database --
-- -------------------------------------------------------------------------------------
USE `SMARTFALT`;

-- Controleer of user al bestaat
SELECT user FROM mysql.user WHERE user = 'SmartfaltAdmin';
DROP USER IF EXISTS 'SmartfaltAdmin'@'localhost';

-- Maak nieuwe user aan
CREATE USER 'SmartfaltAdmin'@'localhost' IDENTIFIED BY 'R0@dtoth3future!';
GRANT ALL PRIVILEGES ON `SMARTFALT`.* TO 'SmartfaltAdmin'@'localhost';

