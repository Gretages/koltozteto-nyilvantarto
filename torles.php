<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $conn = pg_connect("host=localhost port=5432 dbname=YOUR_DB user=YOUR_USER password=YOUR_PASSWORD");
    
    if ($conn) {
        pg_query_params($conn, "DELETE FROM ugyfelek WHERE id = $1", array($id));
        pg_close($conn);
    }
}
header("Location: index.php");
exit();
?>
