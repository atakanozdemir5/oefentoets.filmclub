
<a href="insert.php">Voeg een nieuwe film toe</a>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titel = $_POST['titel'];
    $genre = $_POST['genre'];

    if (empty($titel) || empty($genre)) {
        echo "<p style='color: red;'>Titel en Genre zijn verplicht!</p>";
    } else {

        $conn = new mysqli($host, $user, $password, $dbname);
        $stmt = $conn->prepare("SELECT * FROM film WHERE titel = ?");
        $stmt->bind_param("s", $titel);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p style='color: red;'>De film bestaat al!</p>";
        } else {

            $stmt = $conn->prepare("INSERT INTO film (titel, genre) VALUES (?, ?)");
            $stmt->bind_param("ss", $titel, $genre);
            $stmt->execute();
            echo "<p>Film toegevoegd: " . $titel . " | Genre: " . $genre . "</p>";
        }

        $conn->close();
    }
}
?>

<form method="POST" action="insert.php">
    <label>Titel:</label><br>
    <input type="text" name="titel" required><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre" required><br><br>

    <input type="submit" value="Toevoegen">
</form>
