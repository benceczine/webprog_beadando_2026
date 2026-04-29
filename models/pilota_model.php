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

// --- ÚJ FÜGGVÉNYEK A SZERKESZTÉSHEZ ÉS HOZZÁADÁSHOZ ---

// Egy pilóta lekérése ID alapján
function get_pilota_by_az($dbh, $id) {
    $stmt = $dbh->prepare("SELECT * FROM pilotak WHERE az = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Új pilóta hozzáadása
function pilota_hozzaadas($dbh, $nev, $nem, $szuldat, $nemzet) {
    $stmt = $dbh->prepare("INSERT INTO pilotak (nev, nem, szuldat, nemzet) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$nev, $nem, $szuldat, $nemzet]);
}

// Pilóta adatainak módosítása
function pilota_modositas($dbh, $id, $nev, $nem, $szuldat, $nemzet) {
    $stmt = $dbh->prepare("UPDATE pilotak SET nev = ?, nem = ?, szuldat = ?, nemzet = ? WHERE az = ?");
    return $stmt->execute([$nev, $nem, $szuldat, $nemzet, $id]);
}
?>