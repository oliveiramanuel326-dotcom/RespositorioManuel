<?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $documento_suporte = $_POST['documento_suporte'];
        $descricao_servico = $_POST['descricao_servico'];
        $fornecedor = $_POST['fornecedor'];
        $valor = $_POST['valor'];
        $moeda = $_POST['moeda'];
        $numero_documento = $_POST['numero_documento'];
        $data_entrega_dfc = $_POST['data_entrega_dfc'];
        $data_emissao_pagamento = $_POST['data_emissao_pagamento'];

        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE documentos SET documento_suporte = ?, descricao_servico = ?, fornecedor = ?, valor = ?, moeda = ?, numero_documento = ?, data_entrega_dfc = ?, data_emissao_pagamento = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $documento_suporte, $descricao_servico, $fornecedor, $valor, $moeda, $numero_documento, $data_entrega_dfc, $data_emissao_pagamento, $id);
        $stmt->execute();

        echo "Documento editado com sucesso!";
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Buscar documento pelo ID para preencher formulario
        $conn = connectDB();
        $result = $conn->query("SELECT * FROM documentos WHERE id = $id");
        $documento = $result->fetch_assoc();
    }
?>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $documento['id']; ?>">
    <label for="documento_suporte">Documento de Suporte</label>
    <input type="text" name="documento_suporte" value="<?php echo $documento['documento_suporte']; ?>" required><br>
    <label for="descricao_servico">Descrição do Serviço</label>
    <textarea name="descricao_servico" required><?php echo $documento['descricao_servico']; ?></textarea><br>
    <label for="fornecedor">Fornecedor</label>
    <input type="text" name="fornecedor" value="<?php echo $documento['fornecedor']; ?>" required><br>
    <label for="valor">Valor</label>
    <input type="number" name="valor" value="<?php echo $documento['valor']; ?>" required><br>
    <label for="moeda">Moeda</label>
    <input type="text" name="moeda" value="<?php echo $documento['moeda']; ?>" required><br>
    <label for="numero_documento">Número do Documento</label>
    <input type="text" name="numero_documento" value="<?php echo $documento['numero_documento']; ?>" required><br>
    <label for="data_entrega_dfc">Data de Entrega</label>
    <input type="date" name="data_entrega_dfc" value="<?php echo $documento['data_entrega_dfc']; ?>" required><br>
    <label for="data_emissao_pagamento">Data de Emissão do Pagamento</label>
    <input type="date" name="data_emissao_pagamento" value="<?php echo $documento['data_emissao_pagamento']; ?>"><br>
    <button type="submit">Salvar Alterações</button>
</form>
