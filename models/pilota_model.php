<?php
// models/pilota_model.php
function get_osszes_pilota($dbh) {
    $stmt = $dbh->query("SELECT * FROM pilotak ORDER BY nev ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function pilota_torles($dbh, $id) {
    $stmt = $dbh->prepare("DELETE FROM pilotak WHERE az = ?");
    return $stmt->execute([$id]);
}
?>