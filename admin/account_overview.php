        <!-- ADMIN TABLE -->
        <section id="section-account-overview" class="mt-5 bg-cornflower">
            <div class="table-wrapper">
                <div class="table-container">
                    <table class="table table-hover table-striped table-bordered table-responsive text-nowrap bg-cornflower table-scroll">
                        <thead class="table-selective">
                            <tr>
                                <th scope="col" class="sticky-col">AccountId</th>
                                <th scope="col">Profielfoto</th>
                                <th scope="col">Gebruikersnaam</th>
                                <th scope="col">Wachtwoord</th>
                                <th scope="col">Voornaam</th>
                                <th scope="col">Achternaam</th>
                                <th scope="col">Geslacht</th>
                                <th scope="col">Adres</th>
                                <th scope="col">Woonplaats</th>
                                <th scope="col">Postcode</th>
                                <th scope="col">Geboortedatum</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Telefoon</th>
                                <th scope="col">IBAN</th>
                                <th scope="col">Rol</th>
                                <th scope="col"><i class="bi bi-receipt"></i></th>
                                <th scope="col"><i class="bi bi-pencil-square"></i></th>
                                <th scope="col"><i class="bi bi-file-earmark-x"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $account) { ?>
                                <tr>
                                    <th scope="row" class="bg-tangerine sticky-col"><?php echo $account['AccountId']; ?></th>
                                    <td>
                                        <div class="container-profielImg">
                                            <?php if (!empty($account['ProfilePicture'])) { ?>
                                                <!-- CONVERT BASE64 BACK TO IMAGE ->  https://www.codespeedy.com/how-to-convert-an-image-to-binary-image-in-php/ -->
                                                <img src="data:image/jpeg;base64, <?php echo base64_encode($account['ProfilePicture']); ?>" alt="Profielplaatje" class="profielImg">
                                            <?php } else { ?>
                                                <button type="button" class="imgButton btn btn-selective border border-dark" data-bs-toggle="modal" data-bs-target="#uploadImageModal" data-account-id="<?php echo $account['AccountId']; ?>">
                                                    <i class="bi bi-person-circle"></i>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="fw-bold"><?php echo $account['Gebruikersnaam']; ?></td>
                                    <td><?php echo $account['Wachtwoord']; ?></td>
                                    <td><?php echo $account['Voornaam']; ?></td>
                                    <td><?php echo $account['Achternaam']; ?></td>
                                    <td><?php echo $account['Geslacht']; ?></td>
                                    <td><?php echo $account['Adres']; ?></td>
                                    <td><?php echo $account['Woonplaats']; ?></td>
                                    <td><?php echo $account['Postcode']; ?></td>
                                    <td><?php echo $account['GebDatum']; ?></td>
                                    <td><a href="mailto:<?php echo $account['Emailadres']; ?>?subject=Mail%20van%20Smartfalt"><?php echo $account['Emailadres']; ?></a></td>
                                    <td><?php echo $account['Telefoonnummer']; ?></td>
                                    <td><?php echo $account['IBAN']; ?></td>
                                    <td><?php echo $account['RolId']; ?></td>
                                    <td><a href="<?php echo ROOT_URL; ?>admin/account_details.php?id=<?php echo $account['AccountId']; ?>" title="DETAILS: <?php echo $account['Voornaam'] . ' ' . $account['Achternaam']; ?>"><i class="bi bi-receipt"></i></a></td>
                                    <td><a href="<?php echo ROOT_URL; ?>admin/account_edit.php?id=<?php echo $account['AccountId']; ?>" title="EDIT: <?php echo $account['Voornaam'] . ' ' . $account['Achternaam']; ?>"><i class="bi bi-pencil-square"></i></a></td>
                                    <td><a href="<?php echo ROOT_URL; ?>admin/account_delete.php?id=<?php echo $account['AccountId']; ?>" title="DELETE: <?php echo $account['Voornaam'] . ' ' . $account['Achternaam']; ?>"><i class="bi bi-file-earmark-x"></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <a href="<?php echo ROOT_URL; ?>admin/account_new.php" class="btn btn-selective border border-dark my-2 fw-bold mx-1">Nieuw account maken</a>
                <a href="export_csv.php" class="btn btn-selective border border-dark my-2 fw-bold mx-1">Exporteer Data</a>
                <button type="button" class="btn btn-selective border border-dark my-2 fw-bold mx-1" data-bs-toggle="modal" data-bs-target="#importModal">Importeer Data</button>
            </div>
        </section>
        <!-- /ADMIN TABLE -->

        <!-- IMPORT CSV MODAL -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Upload CSV Bestand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="import_csv.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input class="form-control" type="file" id="csvfile" name="csvfile">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-selective border border-dark my-2 fw-bold">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /IMPORT CSV MODAL -->

        <!-- IMPORT PROFILE PICTURE MODAL -->
        <div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadImageModalLabel">Profielplaatje uploaden</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="import_picture.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input class="form-control" type="file" id="profielImg" name="profielImg">
                            </div>
                            <input type="hidden" id="accountId" name="accountId">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-selective border border-dark my-2 fw-bold">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /IMPORT PROFILE PICTURE MODAL -->

        <!-- ADMIN TABLE SCRIPT -->
        <script>
            $(document).ready(function() {
                $('#uploadImageModal').on('show.bs.modal', function(event) {
                    
                    // MODAL BUTTON LOCATION
                    var button = $(event.relatedTarget);

                    // GET ACCOUNTID
                    var accountId = button.data('account-id');

                    // SET MODAL
                    var modal = $(this);
                    modal.find('#accountId').val(accountId);
                });
            });
        </script>
        <!-- /ADMIN TABLE SCRIPT -->
