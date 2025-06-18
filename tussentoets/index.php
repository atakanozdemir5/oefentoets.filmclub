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
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmclub - Overzicht</title>
</head>
<body>

<h1>Filmclub - Overzicht</h1>


<a href="tussentoets/insert.php">Voeg een nieuwe film toe</a>
<br><br>


<table border="1">
    <thead>
    <tr>
        <th>Titel</th>
        <th>Genre</th>
        <th>Aantal Beoordelingen</th>
        <th>Gemiddeld Cijfer</th>
        <th>Acties</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $film_id = $row['id'];


            $rating_sql = "SELECT AVG(cijfer) AS avg_rating FROM beoordeling WHERE film_id = $film_id";
            $rating_result = $conn->query($rating_sql);
            $avg_rating = $rating_result->fetch_assoc()['avg_rating'] ?? 'Geen beoordelingen';


            $count_sql = "SELECT COUNT(*) AS count FROM beoordeling WHERE film_id = $film_id";
            $count_result = $conn->query($count_sql);
            $count = $count_result->fetch_assoc()['count'];

            echo "<tr>
                        <td>" . $row['titel'] . "</td>
                        <td>" . $row['genre'] . "</td>
                        <td>" . $count . "</td>
                        <td>" . $avg_rating . "</td>
                        <td>
                            <a href='tussentoets/detail.php?id=$film_id'>Bekijk Beoordelingen</a> | 
                            <a href='tussentoets/update.php?id=$film_id'>Bewerken</a> | 
                            <a href='tussentoets/delete.php?id=$film_id'>Verwijderen</a>
                        </td>
                    </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Geen films gevonden</td></tr>";
    }
    ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>
