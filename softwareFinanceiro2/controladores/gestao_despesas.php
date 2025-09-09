<?php
require_once '../conexaoDB/connectDB.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria = $_POST['categoria'] ?? '';
    $valor = floatval($_POST['valor'] ?? 0);
    $quantidade = trim($_POST['quantidade'] ?? '');
    $moeda = $_POST['moeda'] ?? 'MZN';
    $taxa_cambio = floatval($_POST['taxa_cambio'] ?? 1);
    $data = $_POST['data'] ?? date('Y-m-d');
    $fornecedor = trim($_POST['fornecedor'] ?? '');
    $responsavel = trim($_POST['responsavel'] ?? '');
    $status = $_POST['status'] ?? 'pendente';
    $documento_suporte = trim($_POST['documento_suporte'] ?? '');

    // Validação básica
    if (empty($descricao) || $valor <= 0) {
        echo json_encode(["success" => false, "message" => "Descricao e valor são obrigatórios!"]);
        exit;
    }
    /*
    if (empty($descricao) || $data <= 0) {
        echo json_decode(["success" => false, "message" => "Data nao pode exceder mais de 4 numeros!"]);
        exit;
    }
    */
    
    $valor_mzn = ($moeda !== 'MZN') ? $valor * $taxa_cambio : $valor;

    try {
        if (!empty($id)) {
            // Atualizar despesa
            $sql = "UPDATE despesas SET descricao=?, categoria=?, valor=?, moeda=?, taxa_cambio=?, valor_mzn=?, data=?, fornecedor=?, responsavel=?, status=?, documento_suporte=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdssdsssssi", $descricao, $categoria, $valor, $moeda, $taxa_cambio, $valor_mzn, $data, $fornecedor, $responsavel, $status, $documento_suporte, $id);
        } else {
            // Inserir nova despesa
            $sql = "INSERT INTO despesas (descricao, categoria, valor, moeda, taxa_cambio, valor_mzn, data, fornecedor, responsavel, status, documento_suporte) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdssdsssss", $descricao, $categoria, $valor, $moeda, $taxa_cambio, $valor_mzn, $data, $fornecedor, $responsavel, $status, $documento_suporte);
        }

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => empty($id) ? "Despesa adicionada com sucesso!" : "Despesa atualizada com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao processar a despesa: " . $stmt->error]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erro no servidor: " . $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Método inválido!"]);
}
?>