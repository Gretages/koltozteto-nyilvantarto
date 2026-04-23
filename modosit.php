<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Módosítás</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; max-width: 600px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; }
        input[type="submit"] { margin-top: 20px; background-color: #2196F3; color: white; border: none; padding: 10px; cursor: pointer; }
    </style>
</head>
<body>

<h1>Adatok módosítása</h1>

<?php
$conn = pg_connect("host=localhost port=5432 dbname=YOUR_DB user=YOUR_USER password=YOUR_PASSWORD");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nev = $_POST['nev'];
    $cim = $_POST['cim'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];

    $sql = "UPDATE ugyfelek SET nev=$1, cim=$2, email=$3, telefon=$4 WHERE id=$5";
    $result = pg_query_params($conn, $sql, array($nev, $cim, $email, $telefon, $id));

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Hiba a módosításkor.";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $res = pg_query_params($conn, "SELECT * FROM ugyfelek WHERE id = $1", array($id));
    $row = pg_fetch_assoc($res);
}
?>

<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    
    <label>Név:</label>
    <input type="text" name="nev" value="<?php echo $row['nev']; ?>" required>

    <label>Cím:</label>
    <input type="text" name="cim" value="<?php echo $row['cim']; ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>" required>

    <label>Telefon:</label>
    <input type="text" name="telefon" value="<?php echo $row['telefon']; ?>" required>

    <input type="submit" value="Módosítás mentése">
</form>
<br>
<a href="index.php">Mégse</a>

</body>
</html>
