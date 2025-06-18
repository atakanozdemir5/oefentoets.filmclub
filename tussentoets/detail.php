<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'filmclub';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $film_id = $_GET['id'];


    $sql = "SELECT * FROM film WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $film_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $film = $result->fetch_assoc();
        echo "<h1>Beoordelingen voor " . $film['titel'] . "</h1>";


        echo "<a href='delete.php?id=" . $film['id'] . "' onclick='return confirm(\"Weet je zeker dat je deze film wilt verwijderen?\");'>Verwijder deze film</a> | ";
        echo "<a href='update.php?id=" . $film['id'] . "'>Bewerk deze film</a><br><br>";

        // Haal beoordelingen op
        $sql = "SELECT * FROM beoordeling WHERE film_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $film_id);
        $stmt->execute();
        $beoordelingen = $stmt->get_result();

        if ($beoordelingen->num_rows > 0) {
            while ($row = $beoordelingen->fetch_assoc()) {
                echo "<p>Cijfer: " . $row['cijfer'] . " | Opmerking: " . $row['opmerking'] . "</p>";
            }
        } else {
            echo "<p>Geen beoordelingen voor deze film.</p>";
        }
    } else {
        echo "<p>Film niet gevonden.</p>";
    }

    $conn->close();
} else {
    echo "<p>Geen film geselecteerd.</p>";
}
?>
