<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">orderoverzicht</a>';
    require_once ('../config.php');
    $page_Title = 'Smartfalt - Orderoverzicht';
    require_once ('../site/site_header_order.php');
    require_once ('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once ('order_orders.php');
    require_once ('order_databases.php');

    // NEW DATABASE INSTANCE
    $db = new Databases(DB_HOST, DB_NAME, DB_USER, DB_PASS);

    // NEW ORDERS INSTANCE
    $orders = new Orders($db->getPDO());

    // FETCH ORDERS
    $results = $orders->fetchOrders();
?>

        <!-- ORDERS CSS -->
        <style>
            body {
                font-family: apertura, sans-serif;
                font-weight: 700;
                font-style: normal;
                max-width: 100%;
                height: 100%;
                padding-top: 80px;
            }

            a {
                text-decoration: none !important;
                color: inherit;
                cursor: pointer;
            }

            a:hover {
                color: black;
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

            td:hover {
                box-shadow: inset 0 0 0 50px #ffb703;
                font-weight: bold;
            }

            tr:hover {
                box-shadow: inset 0 0 0 50px #ffb703;
                font-style: italic;
            }

            .success:hover {
                box-shadow: inset 0 0 0 50px lightgreen;
            }
            
            .attention:hover {
                box-shadow: inset 0 0 0 50px lightgoldenrodyellow;
            }

            .danger:hover {
                box-shadow: inset 0 0 0 50px lightcoral;
            }

            #order_overview {
                scroll-margin-top: 72px;
            }

            #navbar, .navbar {
                z-index: 1000;
            }
        </style>
        <!-- /ORDERS CSS -->

        <!-- ORDERS SECTION -->
        <section id="section-order-overview" class="mt-5 bg-cornflower">
            <div class="table-wrapper">
                <div class="table-container">
                    <table class="table table-hover table-striped table-bordered table-responsive text-nowrap bg-cornflower table-scroll">
                        <thead class="table-selective">
                            <tr>
                                <th scope="col"><i class="bi bi-calendar3 mx-2"></i> Besteldatum</th>
                                <th scope="col"><i class="bi bi-person-square mx-2"></i> AccountId</th>
                                <th scope="col"><i class="bi bi-person-rolodex mx-2"></i> Naam</th>
                                <th scope="col"><i class="bi bi-list-ul mx-2"></i> Abonnement</th>
                                <th scope="col"><i class="bi bi-list-ul mx-2"></i> BestellingId</th>
                                <th scope="col"><i class="bi bi-receipt mx-2"></i> FactuurId</th>
                                <th scope="col"><i class="bi bi-receipt mx-2"></i> Factuurbedrag</th>
                                <th scope="col"><i class="bi bi-receipt mx-2"></i> Factuurdatum</th>    
                                <th scope="col"><i class="bi bi-cash-coin mx-2"></i> Voldaan</th>
                                <th scope="col"><i class="bi bi-cash-coin mx-2"></i> IncassoId</th>
                                <th scope="col"><i class="bi bi-bank2 mx-2"></i> BankAkkoord</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $order) { ?>
                                <tr>
                                    <?php echo isset($order['Besteldatum']) ? '<th scope="row" class="bg-tangerine">' . $order['Besteldatum'] . '</th>' : '<th class="row text-center"><i class="bi bi-question-circle text-warning" title="Geen gegevens gevonden"></i></th>'; ?>
                                    <td class="fw-bold"><a href="<?php echo ROOT_URL;?>admin/account_edit.php?id=<?php echo $order['AccountId']; ?>" title="EDIT: <?php echo $order['Voornaam'] . ' ' . $order['Achternaam']; ?>"><?php echo $order['AccountId']; ?></a></td>
                                    <td class="fst-italic"><a href="mailto:<?php echo $order['Emailadres']; ?>?subject=Mail%20van%20Smartfalt" title="Stuur mail naar: <?php echo $order['Emailadres']; ?>"><?php echo $order['Voornaam'] . ' ' . $order['Achternaam']; ?></a></td>
                                    <?php 
                                        switch ($order['TypeId']) {
                                            case 1: echo '<td>Evenement (Eenmalig)</td>'; break;
                                            case 2: echo '<td>Parkeergarage (Maand)</td>'; break;
                                            case 3: echo '<td>Parkeergarage (Kwartaal)</td>'; break;
                                            case 4: echo '<td>Overheid (Jaar)</td>'; break;
                                            default;
                                                echo '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>';
                                            break; 
                                        } 
                                    ?>
                                    <?php echo isset($order['BestellingId']) ? '<td><a href="' . ROOT_URL . 'orders/order_bestellingen.php?bestellingid=' . $order['BestellingId'] . '" title="VIEW: Bestelling ' . $order['BestellingId'] . ' van ' . $order['Voornaam'] . ' ' . $order['Achternaam'] . ' ">' . $order['BestellingId'] . '</a></td>' : '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                    <?php echo isset($order['FactuurId']) ? '<td><a href="' . ROOT_URL . 'orders/order_facturen.php?factuurid=' . $order['FactuurId'] . '" title="VIEW: Factuur ' . $order['FactuurId'] . ' van ' . $order['Voornaam'] . ' ' . $order['Achternaam'] . ' "> ' . $order['FactuurId'] . '</a></td>' : '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                    <?php echo isset($order['FactuurBedrag']) ? '<td class="d-flex justify-content-between"><div style="width: 15px; text-align: right;">€</div><div>' . $order['FactuurBedrag'] . '</div>' : '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                    <?php echo isset($order['FactuurDatum']) ? '<td class="text-center">' . $order['FactuurDatum'] . '</td>': '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                    <?php echo isset($order['Voldaan']) ? ($order['Voldaan'] == '1' ? '<td class="text-center success"><i class="bi bi-check-circle" title="Factuur is voldaan"></i></td>' : '<td class="text-center danger"><i class="bi bi-x-circle" title="Factuur is niet voldaan"></i></td>') : '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                    <?php echo isset($order['IncassoId']) ? '<td>'. $order['IncassoId'] . '</td>' : '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                    <?php echo isset($order['BankAkkoord']) ? ($order['BankAkkoord'] == '1' ? '<td class="text-center success"><i class="bi bi-check-circle" title="Er is een bankakkoord op de incasso"></i></td>' : '<td class="text-center danger"><i class="bi bi-x-circle" title="Er is geen bankakkoord op de incasso"></i></td>') : '<td class="text-center attention"><i class="bi bi-question-circle" title="Geen gegevens gevonden"></i></td>'; ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <a href="<?php echo ROOT_URL;?>orders/order_new.php" class="btn btn-selective border border-dark my-2 fw-bold">Nieuwe order maken</a>
            </div>
        </section>
        <!-- /ORDERS SECTION -->

<?php
    // LOAD FOOTER
    require_once ('../site/site_footer.php');

    // CLEAN UP
    $stmt = null;
    $pdo = null;