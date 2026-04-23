<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Költöztető Kft.</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 4px; color: white; margin-right: 5px; }
        .btn-edit { background-color: #2196F3; }
        .btn-delete { background-color: #f44336; }
        .menu { margin-bottom: 20px; padding: 10px; background: #eee; }
        .search-box { margin-bottom: 15px; padding: 10px; background: #e8f5e9; border: 1px solid #4CAF50; border-radius: 5px; display: inline-block; }
        input[type=text] { padding: 5px; width: 200px; }
        input[type=submit] { padding: 5px 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="menu">
    <a href="uj_ugyfel.php" style="font-weight:bold;">+ Új ügyfél felvétele</a> | 
    <a href="lekerdezesek.php">Statisztikák (Lekérdezések)</a>
</div>

<h1>Ügyfélnyilvántartás</h1>

<div class="search-box">
    <form method="GET" action="index.php">
        <label><b>Szűrés név alapján:</b></label>
        <input type="text" name="keres" placeholder="Írj be egy nevet..." value="<?php if(isset($_GET['keres'])) echo $_GET['keres']; ?>">
        <input type="submit" value="Keresés">
        <?php if(isset($_GET['keres'])) echo '<a href="index.php" style="margin-left:10px;">Szűrés törlése</a>'; ?>
    </form>
</div>

<?php
$conn = pg_connect("host=localhost port=5432 dbname=YOUR_DB user=YOUR_USER password=YOUR_PASSWORD");

if (!$conn) { die("Hiba a kapcsolódáskor."); }

// ALAPÉRTELMEZETT SQL
$sql = "SELECT * FROM ugyfelek";

// Szűrés
if (isset($_GET['keres']) && !empty($_GET['keres'])) {
    $keresett_nev = $_GET['keres'];
    $sql .= " WHERE nev ILIKE $1 ORDER BY id";
    $result = pg_query_params($conn, $sql, array('%' . $keresett_nev . '%'));
} else {
    // Ha nincs szűrés, listázunk mindent
    $sql .= " ORDER BY id";
    $result = pg_query($conn, $sql);
}

echo "<table>";
echo "<tr><th>ID</th><th>Név</th><th>Cím</th><th>Email</th><th>Telefon</th><th>Műveletek</th></tr>";

if (pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td><b>" . $row['nev'] . "</b></td>";
        echo "<td>" . $row['cim'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['telefon'] . "</td>";
        echo "<td>";
        echo "<a href='modosit.php?id=" . $row['id'] . "' class='btn btn-edit'>Módosít</a>";
        echo "<a href='torles.php?id=" . $row['id'] . "' class='btn btn-delete' onclick=\"return confirm('Biztosan törölni akarod?');\">Töröl</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6' style='text-align:center; color:red;'>Nincs a keresésnek megfelelő találat.</td></tr>";
}
echo "</table>";

pg_close($conn);
?>

</body>
</html>
