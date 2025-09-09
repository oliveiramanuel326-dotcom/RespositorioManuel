<?php
    include 'db.php';

    $conn = connectDB();
    $result = $conn->query("SELECT * FROM usuarios");

    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Nome: " . $row['nome'] . " | Permissão: " . $row['permissao'] . "<br>";
    }
?>
