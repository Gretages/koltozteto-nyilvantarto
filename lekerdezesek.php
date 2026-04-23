<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Statisztikák</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .menu { margin-bottom: 20px; padding: 10px; background: #eee; }
    </style>
</head>
<body>

<div class="menu">
    <a href="index.php">← Vissza a listához</a> | 
    <a href="uj_ugyfel.php">Új ügyfél felvétele</a>
</div>

<h1>Vezetői Információs Rendszer (Lekérdezések)</h1>

<?php
$conn = pg_connect("host=localhost port=5432 dbname=YOUR_DB user=YOUR_USER password=YOUR_PASSWORD");

if (!$conn) {
    die("Hiba a kapcsolódáskor.");
}
// 1. LEKÉRDEZÉS - Ki mennyit keresett
echo "<h2>1. Alkalmazottak keresete (Összesítés)</h2>";
$sql1 = 'SELECT 
            a.nev AS "Dolgozó neve", 
            SUM(m.ledolgozott_ora) AS "Összes óra",
            SUM(m.ledolgozott_ora * a.oraber) AS "Összes kereset (Ft)"
         FROM alkalmazottak a
         JOIN munkavegzes m ON a.id = m.alkalmazott_id
         GROUP BY a.nev
         ORDER BY "Összes kereset (Ft)" DESC';

$res1 = pg_query($conn, $sql1);

echo "<table><tr><th>Dolgozó neve</th><th>Összes óra</th><th>Összes kereset (Ft)</th></tr>";
while ($row = pg_fetch_assoc($res1)) {
    echo "<tr>";
    echo "<td>" . $row['Dolgozó neve'] . "</td>";
    echo "<td>" . $row['Összes óra'] . "</td>";
    echo "<td>" . $row['Összes kereset (Ft)'] . " Ft</td>";
    echo "</tr>";
}
echo "</table>";

// 2. LEKÉRDEZÉS - Járművek kihasználtsága
echo "<h2>2. Járművek kihasználtsága (Csoportosítás)</h2>";
$sql2 = 'SELECT 
            j.tipus AS "Jármű típusa",
            j.rendszam AS "Rendszám",
            COUNT(m.id) AS "Megbízások száma"
         FROM jarmuvek j
         JOIN megbizasok m ON j.rendszam = m.jarmu_rendszam
         GROUP BY j.tipus, j.rendszam
         ORDER BY "Megbízások száma" DESC';

$res2 = pg_query($conn, $sql2);

echo "<table><tr><th>Jármű típusa</th><th>Rendszám</th><th>Megbízások száma</th></tr>";
while ($row = pg_fetch_assoc($res2)) {
    echo "<tr>";
    echo "<td>" . $row['Jármű típusa'] . "</td>";
    echo "<td>" . $row['Rendszám'] . "</td>";
    echo "<td>" . $row['Megbízások száma'] . " db</td>";
    echo "</tr>";
}
echo "</table>";

// 3. LEKÉRDEZÉS - Átlagon felüli kifizetések
echo "<h2>3. Átlagbér feletti dolgozók (Allekérdezés)</h2>";
$sql3 = 'SELECT nev, munkakor, oraber
         FROM alkalmazottak
         WHERE oraber > (SELECT AVG(oraber) FROM alkalmazottak)';

$res3 = pg_query($conn, $sql3);

echo "<table><tr><th>Név</th><th>Munkakör</th><th>Órabér</th></tr>";
while ($row = pg_fetch_assoc($res3)) {
    echo "<tr>";
    echo "<td>" . $row['nev'] . "</td>";
    echo "<td>" . $row['munkakor'] . "</td>";
    echo "<td>" . $row['oraber'] . " Ft</td>";
    echo "</tr>";
}
echo "</table>";

pg_close($conn);
?>

</body>
</html>
