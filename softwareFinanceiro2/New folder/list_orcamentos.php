<?php
    include 'db.php';

    $conn = connectDB();
    $result = $conn->query("SELECT * FROM orcamentos");

    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Total: " . $row['orcamento_total'] . " | Usado: " . $row['valor_usado'] . "<br>";
    }
?>
