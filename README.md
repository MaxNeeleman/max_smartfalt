# 🛣️ Smartfalt
Smartfalt Git Hub voor Avans  
Web: https://smartfalt.azurewebsites.net  

> **Remember**: Commit before you quit!  

## 🧑‍💻 Project Team:
- Max Neeleman
- Neesha Rattansingh
- Denis Risovic
- Paul Rutten

## 💻 Gebruikte middelen:
- Azure Web + DB module
- XAMMPP (Apache, MySql, PHP 8.2.4)
- Visual Studio Code
- GitHub Desktop

## ✅ To-do
Wat moet er nog gebeuren voor onze assessment?  
Algemeen:  
- [X] ~~Sync met Azure voor hosting~~ (done: https://smartfalt.azurewebsites.net/)

### Denis
### Max
### Neesha
### Paul
- [ ] Bekijken welke pagina's nog meer object orientated gemaakt kunnen worden
- [X] ~~account_edit.php geeft nog errors na het updaten van een account~~
- [X] ~~Verder gaan met indexpagina optimalizatie~~
    - [X] ~~`Terug` buttons blijven zichtbaar~~
- [X] ~~Edit/Delete buttons in admin pagina werkend maken~~
- [ ] Azure gebruikt _nginx_ ipv _apache_, `.htaccess` gaat daar niet werken (zie: https://azureossd.github.io/2021/09/02/php-8-rewrite-rule/)
- [ ] `.htaccess` bestand nakijken om _404 errors_ af te vangen

## 📝 Changelog
Hier houden wij onze changes bij.

### 2023-06-04 - PR
- Facturenoverzicht afgerond

### 2023-06-01 - PR
- Facturenoverzicht uitgewerkt

### 2023-05-31 - PR
- Orderoverzicht gemaakt (flink stoeien met SQL)
- Adminpagina code iets strakker gemaakt
- Pagina object orientated gemaakt (voor unit testing)
- Indexpagina is nu bijna ziekelijk perfect... (sorry Neesha 😁)

### 2023-05-29 - PR
- Eindelijk alles werkend met betrekking tot het admin gedeelte
- Eerste opzet voor inlogsysteem lijkt te werken (nu nog iets met de output doen)
- Overzicht bestellingen en facturen aan de admin-pagina toegevoegt
- Code verbeteringen doorgevoerd

### 2023-05-29 - NR
- Aantal pogingen gedaan tot vertalen zonder Google, dit moet echter per stukje tekst helemaal handmatig gedaan worden en wordt een erg rommelige code
- Google Translator toegevoegd

### 2023-05-28 - PR
- Loginpagina proberen te maken (nog niet werkend)
- Adminpagina cleanups

### 2023-05-27 - PR
- Admin pagina geoptimaliseerd
- Edit/Delete knoppen werkend gemaakt
- Nieuw account pagina aangemaakt
- Error pagina gemaakt
- Enorm zitten stoeien met CSS om sticky headers goed te krijgen
- JavaScript toegevoegd met een beetje AJAX 

### 2023-05-25 - PR
- Admin pagina gemaakt
- SQL query en data ophalen gelukt
- Paar minor aanpassingen in de body gemaakt (background color, nav-bar links en margins)
- Volledige redesign indexpagina
    - DIVjes nagelopen
    - Code optimalizatie
    - Bootstrap optimalizatie
### 2023-05-21 - PR
- Hosting via Azure geregeld
- Herindeling mapppenstructuur (website stond in een submap, wat niet handig is)
- Toevoegen `.htaccess` bestand, voor nu om 404 errors af te vangen
- Toevoegen site variabelen
- Opsplitsen van `index.html` in `header.php`, `body.php` en `footer.php`
