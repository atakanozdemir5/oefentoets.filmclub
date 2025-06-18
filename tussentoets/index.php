
<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'filmclub';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}


$sql = "SELECT * FROM film";
$result = $conn->query($sql);

echo "<h1>Alle Films</h1>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>Film: " . $row['titel'] . " | Genre: " . $row['genre'] .
            " | <a href='detail.php?id=" . $row['id'] . "'>Bekijk beoordelingen</a></p>";
    }
} else {
    echo "Geen films gevonden.";
}

$conn->close();
?>

<?php

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}


$sql = "SELECT COUNT(*) AS total_films FROM film";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo "<p>Totaal aantal films: " . $row['total_films'] . "</p>";

$conn->close();
?>



