<?php
    include 'db.php';

    $conn = connectDB();
    $result = $conn->query("SELECT * FROM documentos");

    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Documento: " . $row['documento_suporte'] . " | Valor: " . $row['valor'] . " | Fornecedor: " . $row['fornecedor'] . "<br>";
    }

    include 'db.php';

    $conn = connectDB();
    $result = $conn->query("SELECT * FROM documentos");

    echo "<table>";
    echo "<tr><th>ID</th><th>Documento</th><th>Fornecedor</th><th>Ações</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['documento_suporte'] . "</td>";
        echo "<td>" . $row['fornecedor'] . "</td>";
        echo "<td>
                <a href='edit_documento.php?id=" . $row['id'] . "'>Editar</a> | 
                <a href='delete_documento.php?id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este documento?\");'>Excluir</a>
            </td>";
        echo "</tr>";
    }
    echo "</table>";
?>
