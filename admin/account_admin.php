<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Accountoverzicht</a>';
    require_once ('../config.php');
    $page_Title = 'Smartfalt - Admin';
    require_once ('../site/site_admin_header.php');
    require_once ('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');

    // CONNECT NAAR DB
    try {
        $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL Query om data op te halen
        $sql = "SELECT * FROM `accounts` ORDER BY `Id`;";

        // Haal daadwerkelijk de data op
        $stmt = $connection->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "ERROR: Kan geen verbinding met de database maken. " . $e->getMessage();
        header("Location: account_error.php");
        exit();
    }
?>
        <style>
        a {
            text-decoration: none !important;
            color: inherit;
            cursor: pointer;
        }

        a:hover {
            color: orange;
        }

        .icon-edit {
            color: orange;
        }

        .icon-delete {
            color: orangered;
        }

        .table-wrapper {
            position: relative;
            max-width: 100%;
            overflow: auto;
        }

        .table-container {
            overflow-x: auto;
            overflow-y: scroll;
            max-height: 80vh;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .table-container thead th {
            position: sticky;
            top: 0;
            background-color: #ffb703;
            z-index: 2;
        }
        
        .sticky-col {
            /* TODO: Dit werkt niet helemaal lekker nog... */
            position: sticky;
            left: 0;
            z-index: 1;
            background-color: #fff;
            width: 150px;
        }

        #overview {
            scroll-margin-top: 72px;
        }

        #navbar, .navbar {
            z-index: 1000;
        }
        </style>

        <!-- ADMIN -->
        <section id="overview" class="mt-5 bg-cornflower">
            <div class="table-wrapper">
                <div class="table-container">
                    <table class="table table-hover text-nowrap bg-cornflower table-scroll">
                        <thead class="bg-selective">
                            <tr>
                                <th scope="col" class="sticky-col">ID</th>
                                <th scope="col" class="sticky-col">Gebruikersnaam</th>
                                <th scope="col">Wachtwoord</th>
                                <th scope="col">Voornaam</th>
                                <th scope="col">Achternaam</th>
                                <th scope="col">Geslacht</th>
                                <th scope="col">Adres</th>
                                <th scope="col">Postcode</th>
                                <th scope="col">Plaats</th>
                                <th scope="col">Land</th>
                                <th scope="col">Geb.Datum</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Telefoon</th>
                                <th scope="col">IBAN</th>
                                <th scope="col"><i class="bi bi-pencil-square"></i></th>
                                <th scope="col"><i class="bi bi-file-earmark-x"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $account) { ?>
                                <tr>
                                    <th scope="row" class="bg-tangerine sticky-col"><?php echo $account['Id']; ?></th>
                                    <td  class="sticky-col"><strong><?php echo $account['Username']; ?></strong></td>
                                    <td><?php echo $account['Password']; ?></td>
                                    <td><?php echo $account['Firstname']; ?></td>
                                    <td><?php echo $account['Lastname']; ?></td>
                                    <td><?php echo $account['Gender']; ?></td>
                                    <td><?php echo $account['Address']; ?></td>
                                    <td><?php echo $account['Zip']; ?></td>
                                    <td><?php echo $account['City']; ?></td>
                                    <td><?php echo $account['Country']; ?></td>
                                    <td><?php echo $account['DOB']; ?></td>
                                    <td><a href="mailto:<?php echo $account['Mail']; ?>?subject=Mail%20van%20Smartfalt"><?php echo $account['Mail']; ?></a></td>
                                    <td><?php echo $account['Phone']; ?></td>
                                    <td><?php echo $account['IBAN']; ?></td>
                                    <td><a href="account_edit.php?id=<?php echo $account['Id']; ?>"><i class="bi bi-pencil-square icon-edit"></i></a></td>
                                    <td><a href="account_delete.php?id=<?php echo $account['Id']; ?>"><i class="bi bi-file-earmark-x icon-delete"></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <a href="account_new.php" class="btn btn-selective border border-dark my-2"><strong>Nieuw account maken</strong></a>
            </div>
        </section>
        <!-- /ADMIN -->


        <!-- SCRIPT -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $('table').on('click', 'a[href*="account_delete.php"]', function(e) {
                    e.preventDefault();
                    var $row = $(this).closest('tr'); // Welke rij moet er verwijderd worden
                    $row.css('background-color', 'LightCoral'); // Geef deze rij een kleur
                    var url = $(this).attr('href'); // Haal de URL van de rij op

                    // Wacht met verwijderen
                    setTimeout(function() {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function() {
                                $row.remove();
                            },
                            error: function() {
                                $row.css('background-color', '');
                                alert('Onbekende fout tijdens het verwijderen van deze rij.');
                            }
                        });
                    }, 1000);
                });
            });

            // GO BACK
            function goBack() {
               window.history.back();
            }

            // TABLE HORIZONTAL SCROLL BAR FIX (?)
            const tableContainer = document.querySelector('.table-container');
            const table = document.querySelector('.table-scroll');

            table.addEventListener('scroll', () => {
            tableContainer.scrollTop = table.scrollTop;
            });
        </script>
         <!-- /SCRIPT -->

<?php
    // Clean up connection
    $stmt = null;
    $connection = null;
    require_once ('../site/site_footer.php');
?>
