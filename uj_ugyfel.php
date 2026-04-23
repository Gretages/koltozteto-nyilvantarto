<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Új ügyfél felvétele</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; max-width: 600px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        input[type="submit"] { margin-top: 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
        .siker { color: green; background: #e8f5e9; padding: 10px; border: 1px solid green; }
        .hiba { color: red; background: #ffebee; padding: 10px; border: 1px solid red; }
        .menu { margin-bottom: 20px; padding: 10px; background: #eee; }
    </style>
</head>
<body>

<div class="menu">
    <a href="index.php">← Vissza a listához</a>
</div>

<h1>Új ügyfél rögzítése</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Adatok begyűjtése
    $nev = $_POST['nev'];
    $cim = $_POST['cim'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];

    $conn = pg_connect("host=localhost port=5432 dbname=YOUR_DB user=YOUR_USER password=YOUR_PASSWORD");

    if (!$conn) {
        echo "<div class='hiba'>Hiba a kapcsolódáskor!</div>";
    } else {
        $sql = "INSERT INTO ugyfelek (nev, cim, email, telefon) VALUES ($1, $2, $3, $4)";
        $result = pg_query_params($conn, $sql, array($nev, $cim, $email, $telefon));

        if ($result) {
            echo "<div class='siker'>Sikeres felvétel: $nev!</div>";
        } else {
            echo "<div class='hiba'>Hiba történt a mentéskor.</div>";
        }
        pg_close($conn);
    }
}
?>

<form method="post" action="">
    <label for="nev">Név:</label>
    <input type="text" id="nev" name="nev" required placeholder="Pl. Kiss János">

    <label for="cim">Cím:</label>
    <input type="text" id="cim" name="cim" required placeholder="Pl. 1117 Budapest...">

    <label for="email">E-mail cím:</label>
    <input type="email" id="email" name="email" required placeholder="pelda@email.hu">

    <label for="telefon">Telefonszám:</label>
    <input type="text" id="telefon" name="telefon" required placeholder="06301234567">

    <input type="submit" value="Ügyfél Mentése">
</form>

</body>
</html>
