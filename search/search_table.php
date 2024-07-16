        <!-- ADMIN CSS -->
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
            td:hover {
                box-shadow: inset 0 0 0 50px #ffb703;
                font-weight: bold;
            }

            tr:hover {
                box-shadow: inset 0 0 0 50px #ffb703;
                font-style: italic;
            }

            .sticky-col {
                /* TODO: Dit werkt niet helemaal lekker nog... */
                position: sticky;
                left: 0;
                z-index: 1;
                background-color: #fff;
                width: 150px;
            }

            #search_overview {
                scroll-margin-top: 72px;
            }

            #navbar, .navbar {
                z-index: 1000;
            }
        </style>
        <!-- /ADMIN CSS -->
        
        <!-- SEARCH SECTION -->
        <section id='section-admin-search'>
            <div class='container bg-cornflower rounded-3 my-5 p-3'>
                <div class="table-container">
                <h1 class='fw-bold'>Resultaten</h1>
                <p>Gelieve zoekgeschiedenis te verwijderen mocht er iets met ons gebeuren.</p>
                    <table class="table table-hover table-striped table-bordered table-responsive text-nowrap bg-cornflower table-scroll">
                        <thead class="table-selective">
                            <tr>
                                <th scope="col" class="sticky-col">Zoek ID</th>
                                <th scope="col">Zoekopdracht</th>
                                <th scope="col"><i class="bi bi-file-earmark-x"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $search) { ?>
                                <tr>
                                    <td><?php echo $search['ZoekId']; ?></td>
                                    <td><?php echo $search['ZoekOpdracht']; ?></td>
                                    <td>
                                        <a href="index.php?id=<?php echo $search['ZoekId']; ?>">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- /SEARCH SECTION -->