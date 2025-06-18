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

    // Haal de huidige gegevens van de film op
    $sql = "SELECT * FROM film WHERE id = $film_id";
    $result = $conn->query($sql);
    $film = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titel = $_POST['titel'];
    $genre = $_POST['genre'];

    // Update de film
    $update_sql = "UPDATE film SET titel = ?, genre = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $titel, $genre, $film_id);

    if ($stmt->execute()) {
        echo "<p>Film bijgewerkt: " . $titel . " | Genre: " . $genre . "</p>";
    } else {
        echo "<p style='color: red;'>Er is een fout opgetreden bij het bijwerken van de film: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Bewerken</title>
</head>
<body>

<h1>Film Bewerken</h1>

<form method="POST" action="tussentoets/update.php?id=<?php echo $film['id']; ?>">
    <label>Titel:</label><br>
    <input type="text" name="titel" value="<?php echo $film['titel']; ?>" required><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre" value="<?php echo $film['genre']; ?>" required><br><br>

    <input type="submit" value="Bewerken">
</form>

<a href="tussentoets/index.php">Terug naar overzicht</a>

</body>
</html>

<?php
$conn->close();
?>
