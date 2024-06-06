<?php
$host = "mysql-anouck.alwaysdata.net";
$user = "anouck_lpdwca23";
$passwd = "g2P56klB9200";
$db = "anouck_lpdwca23";

$mysqliObject = new mysqli($host, $user, $passwd, $db);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($mysqliObject->connect_errno) {
    echo "Erreur de connexion à la base de données : " . $mysqliObject->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $mysqliObject->real_escape_string($_POST['nom']);
    $prenom = $mysqliObject->real_escape_string($_POST['prenom']);
    $adulte = intval($_POST['adulte']);
    $enfant = intval($_POST['enfant']);
    $date_arrivee = $mysqliObject->real_escape_string($_POST['date_arrivee']);
    $date_depart = $mysqliObject->real_escape_string($_POST['date_depart']);
    $options = $mysqliObject->real_escape_string($_POST['options']);

    $code_reservation = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10);

    $query = "INSERT INTO BDD_Reservation_Hotel (nom, prenom, adulte, enfant, date_arrivee, date_depart, options, code_reservation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqliObject->prepare($query);
    $stmt->bind_param("ssiiisss", $nom, $prenom, $adulte, $enfant, $date_arrivee, $date_depart, $options, $code_reservation);

    if ($stmt->execute()) {
        echo "Réservation effectuée avec succès. Votre code de réservation est : $code_reservation";
    } else {
        echo "Erreur lors de la réservation : " . $mysqliObject->error;
    }

    $stmt->close();
}

$mysqliObject->close();
?>
