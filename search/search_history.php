<?php
// START SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../db/db_connect.php');
?>


<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement
    $deleteSql = "DELETE FROM zoeken WHERE ZoekId = :id";
    $deleteStmt = $pdo->prepare($deleteSql);
    $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement
    if ($deleteStmt->execute()) {
        // Deletion successful
        echo '<script>alert("Resultaat succesvol verwijderd")</script>';
    } else {
        // Error occurred during deletion
        echo '<script>alert("Error, resultaat niet verwijderd")</script>';
    }
}


$sql = "SELECT * FROM zoeken ORDER BY ZoekId";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num = count($results);

if ($num > 0) {
    foreach ($results as $search) {
        include_once("search_table.php");
    }
} else {

    echo "<section id='section-admin-search'>
            <div class='container bg-cornflower rounded-3 my-5 p-3'>
                <h1 class='fw-bold'>Resultaten</h1>
                <p>Geen resultaten</p>
                </div>
</section>";
}

require_once("../site/site_footer.php");
