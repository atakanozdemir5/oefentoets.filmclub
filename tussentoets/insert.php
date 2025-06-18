<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'filmclub';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titel = $_POST['titel'];
    $genre = $_POST['genre'];


    if (empty($titel) || empty($genre)) {
        echo "<p style='color: red;'>Titel en Genre zijn verplicht!</p>";
    } else {

        $sql = "SELECT * FROM film WHERE titel = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $titel);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p style='color: red;'>Deze film bestaat al!</p>";
        } else {
            // Voeg de film toe aan de database
            $sql = "INSERT INTO film (titel, genre) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $titel, $genre);

            if ($stmt->execute()) {
                echo "<p>Film toegevoegd: " . $titel . " | Genre: " . $genre . "</p>";
            } else {
                echo "<p style='color: red;'>Er is een fout opgetreden bij het toevoegen van de film: " . $stmt->error . "</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Toevoegen</title>
</head>
<body>

<h1>Voeg een nieuwe film toe</h1>

<form method="POST" action="tussentoets/insert.php">
    <label>Titel:</label><br>
    <input type="text" name="titel" required><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre" required><br><br>

    <input type="submit" value="Toevoegen">
</form>

<a href="tussentoets/index.php">Terug naar overzicht</a>

</body>
</html>

<?php
$conn->close();
?>
