<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orcamento_total = $_POST['orcamento_total'];
    $valor_usado = $_POST['valor_usado'];

    $conn = connectDB();
    $stmt = $conn->prepare("INSERT INTO orcamentos (orcamento_total, valor_usado) VALUES (?, ?)");
    $stmt->bind_param("dd", $orcamento_total, $valor_usado);
    $stmt->execute();

    echo "Orçamento criado com sucesso!";
}
?>

<form method="POST">
    <label for="orcamento_total">Oraamento Total</label>
    <input type="number" name="orcamento_total" required><br>
    <label for="valor_usado">Valor Usado</label>
    <input type="number" name="valor_usado" required><br>
    <button type="submit">Criar Orcamento</button>
</form>
