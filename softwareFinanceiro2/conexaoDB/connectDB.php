<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function connectDB() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'sistema_gestao_financeira';
    $port = 3307;

    $conn = new mysqli($host, $user, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    return $conn;
}

$conn = connectDB();

?>
