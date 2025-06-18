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


    $film_sql = "SELECT * FROM film WHERE id = $film_id";
    $film_result = $conn->query($film_sql);
    $film = $film_result->fetch_assoc();


    $rating_sql = "SELECT * FROM beoordeling WHERE film_id = $film_id";
    $rating_result = $conn->query($rating_sql);


    $avg_rating_sql = "SELECT AVG(cijfer) AS avg_rating FROM beoordeling WHERE film_id = $film_id";
    $avg_rating_result = $conn->query($avg_rating_sql);
    $avg_rating = $avg_rating_result->fetch_assoc()['avg_rating'] ?? 'Geen beoordelingen';
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Beoordelingen</title>
</head>
<body>

<h1>Beoordelingen voor: <?php echo $film['titel']; ?> (<?php echo $film['genre']; ?>)</h1>


<p><strong>Gemiddeld cijfer: </strong><?php echo number_format($avg_rating, 1); ?></p>


<h2>Beoordelingen</h2>
<table border="1">
    <thead>
    <tr>
        <th>Cijfer</th>
        <th>Opmerking</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($rating_result->num_rows > 0) {
        while ($row = $rating_result->fetch_assoc()) {
            echo "<tr>
                        <td>" . $row['cijfer'] . "</td>
                        <td>" . $row['opmerking'] . "</td>
                    </tr>";
        }
    } else {
        echo "<tr><td colspan='2'>Geen beoordelingen beschikbaar</td></tr>";
    }
    ?>
    </tbody>
</table>


<a href="tussentoets/index.php">Terug naar overzicht</a>

</body>
</html>

<?php
$conn->close();
?>
