<?php
include 'db.php';

$conn = connectDB();

// Criar, editar ou excluir documentos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] == 'create') {
        // Criar novo documento
        $stmt = $conn->prepare("INSERT INTO documentos (documento_suporte, descricao_servico, fornecedor, valor, moeda, numero_documento, data_entrega_dfc, data_emissao_pagamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $_POST['documento_suporte'], $_POST['descricao_servico'], $_POST['fornecedor'], $_POST['valor'], $_POST['moeda'], $_POST['numero_documento'], $_POST['data_entrega_dfc'], $_POST['data_emissao_pagamento']);
        $stmt->execute();
    }

    if ($_POST['acao'] == 'edit') {
        // Editar documento pelo número do documento
        $stmt = $conn->prepare("UPDATE documentos SET documento_suporte = ?, descricao_servico = ?, fornecedor = ?, valor = ?, moeda = ?, data_entrega_dfc = ?, data_emissao_pagamento = ? WHERE numero_documento = ?");
        $stmt->bind_param("ssssssss", $_POST['documento_suporte'], $_POST['descricao_servico'], $_POST['fornecedor'], $_POST['valor'], $_POST['moeda'], $_POST['data_entrega_dfc'], $_POST['data_emissao_pagamento'], $_POST['numero_documento']);
        $stmt->execute();
    }

    if ($_POST['acao'] == 'delete') {
        // Excluir documento pelo número do documento
        $stmt = $conn->prepare("DELETE FROM documentos WHERE numero_documento = ?");
        $stmt->bind_param("s", $_POST['numero_documento']);
        $stmt->execute();
    }
}

// Listar documentos
$result = $conn->query("SELECT * FROM documentos");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Documentos</title>
    <script>
        function editarDocumento(numeroDocumento, documentoSuporte, descricaoServico, fornecedor, valor, moeda, dataEntrega, dataEmissao) {
            document.getElementById("acao").value = "edit";
            document.getElementById("numero_documento").value = numeroDocumento;
            document.getElementById("documento_suporte").value = documentoSuporte;
            document.getElementById("descricao_servico").value = descricaoServico;
            document.getElementById("fornecedor").value = fornecedor;
            document.getElementById("valor").value = valor;
            document.getElementById("moeda").value = moeda;
            document.getElementById("data_entrega_dfc").value = dataEntrega;
            document.getElementById("data_emissao_pagamento").value = dataEmissao;
            document.getElementById("btn-submit").textContent = "Atualizar Documento";
        }

        function excluirDocumento(numeroDocumento) {
            if (confirm("Tem certeza que deseja excluir este documento?")) {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "documentos.php";

                let inputAcao = document.createElement("input");
                inputAcao.type = "hidden";
                inputAcao.name = "acao";
                inputAcao.value = "delete";
                form.appendChild(inputAcao);

                let inputNumero = document.createElement("input");
                inputNumero.type = "hidden";
                inputNumero.name = "numero_documento";
                inputNumero.value = numeroDocumento;
                form.appendChild(inputNumero);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        form { margin: 20px 0; }
        button { padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .btn-delete { background-color: red; }
        .btn-delete:hover { background-color: darkred; }
    </style>
</head>
<body>

    <h1>Gestão de Documentos</h1>

    <!-- Formulário de Criação/Edição de Documento -->
    <h2 id="form-title">Criar Novo Documento</h2>
    <form method="POST">
        <input type="hidden" id="acao" name="acao" value="create">
        <label for="documento_suporte">Documento de Suporte</label>
        <input type="text" id="documento_suporte" name="documento_suporte" required><br>
        
        <label for="descricao_servico">Descrição do Serviço</label>
        <textarea id="descricao_servico" name="descricao_servico" required></textarea><br>

        <label for="fornecedor">Fornecedor</label>
        <input type="text" id="fornecedor" name="fornecedor" required><br>

        <label for="valor">Valor</label>
        <input type="number" id="valor" name="valor" required><br>

        <label for="moeda">Moeda</label>
        <input type="text" id="moeda" name="moeda" required><br>

        <label for="numero_documento">Número do Documento</label>
        <input type="text" id="numero_documento" name="numero_documento" required><br>

        <label for="data_entrega_dfc">Data de Entrega</label>
        <input type="date" id="data_entrega_dfc" name="data_entrega_dfc" required><br>

        <label for="data_emissao_pagamento">Data de Emissão do Pagamento</label>
        <input type="date" id="data_emissao_pagamento" name="data_emissao_pagamento"><br>

        <button type="submit" id="btn-submit">Criar Documento</button>
    </form>

    <!-- Tabela de Documentos -->
    <h2>Lista de Documentos</h2>
    <table>
        <tr>
            <th>Número do Documento</th>
            <th>Documento de Suporte</th>
            <th>Fornecedor</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['numero_documento']; ?></td>
            <td><?php echo $row['documento_suporte']; ?></td>
            <td><?php echo $row['fornecedor']; ?></td>
            <td><?php echo $row['valor']; ?></td>
            <td>
                <button onclick="editarDocumento(
                    '<?php echo $row['numero_documento']; ?>',
                    '<?php echo $row['documento_suporte']; ?>',
                    '<?php echo $row['descricao_servico']; ?>',
                    '<?php echo $row['fornecedor']; ?>',
                    '<?php echo $row['valor']; ?>',
                    '<?php echo $row['moeda']; ?>',
                    '<?php echo $row['data_entrega_dfc']; ?>',
                    '<?php echo $row['data_emissao_pagamento']; ?>'
                )">Editar</button>

                <button class="btn-delete" onclick="excluirDocumento('<?php echo $row['numero_documento']; ?>')">Excluir</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
