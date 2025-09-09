<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../conexaoDB/connectDB.php';

$conn = connectDB();

header('Content-Type: application/json');

$sql = "SELECT * FROM despesas ORDER BY data DESC";
$result = $conn->query($sql);

$despesas = [];
while ($row = $result->fetch_assoc()) {
    $despesas[] = $row;
}

echo json_encode(["success" => true, "despesas" => $despesas]);

$conn->close();

?>
