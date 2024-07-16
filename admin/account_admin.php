<?php
    // START SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // LOAD WEBSITE
    $page_Title = 'Smartfalt - Admin';
    $admin_page_title = '<a href="../index.php">Smartfalt</a> > <a href="index.php">Accountoverzicht</a>';
    require_once('../config.php');
    require_once('../site/site_header_admin.php');
    require_once('../db/connect_' . $_SERVER['SERVER_NAME'] . '.php');
    require_once('../db/db_connect.php');

    // // SQL PREPARE DATA
    // $sql = "SELECT * FROM `accounts` ORDER BY `AccountId`;";

    // SQL PREPARE DATA
    $sql = "SELECT accounts.*, AFBEELDINGEN.ProfilePicture FROM accounts 
        LEFT JOIN AFBEELDINGEN ON accounts.AccountId = AFBEELDINGEN.AccountId 
        ORDER BY accounts.AccountId;";


    // GET DATA
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // LOAD TABLE
    require_once('account_overview.php');

?>
        <!-- ADMIN OVERVOEW SCRIPTS -->
        <script>
            // ON CLICK: DELETE ACCOUNT
            $(document).ready(function() {
                $("table").on("click", 'a[href*="account_delete.php"]', function(e) {
                    e.preventDefault();
                    
                    // SELECT ROW
                    let $row = $(this).closest("tr"); 
                    
                    // COLOR ROW
                    $row.css("background-color", "LightCoral"); 
                    
                    // GET URL
                    let url = $(this).attr("href"); 

                    // REMOVAL DELAY
                    setTimeout(function() {
                        $.ajax({
                            url: url,
                            type: "GET",
                            success: function() {
                                $row.remove();
                            },
                            error: function() {
                                $row.css("background-color", "");
                                alert("Onbekende fout tijdens het verwijderen van deze rij.");
                            },
                        });
                    }, 1000);
                });
            });
            // /ON CLICK: DELETE ACCOUNT

            // FIX SCROLL BAR
            const tableContainer = document.querySelector(".table-container");
            const table = document.querySelector(".table-scroll");

            table.addEventListener("scroll", () => {
                tableContainer.scrollTop = table.scrollTop;
            });
            
            // /FIX SCROLL BAR
        </script>
        <!-- /ADMIN OVERVIEW SCRIPTS -->

<?php
    // LOAD FOOTER
    require_once('../site/site_footer.php');

    // CLEAN UP
    $stmt = null;
    $pdo = null;
