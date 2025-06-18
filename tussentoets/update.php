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
    $film = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Bijwerken van de film
    $titel = $_POST['titel'];
    $genre = $_POST['genre'];

    if (empty($titel) || empty($genre)) {
        echo "<p style='color: red;'>Titel en Genre zijn verplicht!</p>";
    } else {
        $sql = "UPDATE film SET titel = ?, genre = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $titel, $genre, $film_id);
        $stmt->execute();

        echo "<p>Film bijgewerkt: " . $titel . " | Genre: " . $genre . "</p>";
    }
}
?>

<h1>Film Bewerken</h1>
<form method="POST" action="update.php?id=<?php echo $film['id']; ?>">
    <label>Titel:</label><br>
    <input type="text" name="titel" value="<?php echo $film['titel']; ?>" required><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre" value="<?php echo $film['genre']; ?>" required><br><br>

    <input type="submit" value="Bijwerken">
</form>

<a href="index.php">Terug naar overzicht</a>
