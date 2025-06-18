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


    $sql = "DELETE FROM beoordeling WHERE film_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $film_id);
    $stmt->execute();


    $sql = "DELETE FROM film WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $film_id);
    $stmt->execute();

    echo "<p>Film is verwijderd. <a href='index.php'>Terug naar overzicht</a></p>";
} else {
    echo "<p>Geen film geselecteerd voor verwijdering.</p>";
}

$conn->close();
?>
