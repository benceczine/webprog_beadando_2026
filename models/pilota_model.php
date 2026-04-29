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

function get_szurt_pilotak($dbh, $kereses) {
    // A LIKE operátorral és a % jelekkel keressük azokat, akiknek a nevében szerepel a beírt szó
    $sql = "SELECT * FROM pilotak WHERE nev LIKE ? ORDER BY nev ASC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['%' . $kereses . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>