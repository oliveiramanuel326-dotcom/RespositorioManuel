<?php
    include 'db.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Excluir documento pelo ID
        $conn = connectDB();
        $stmt = $conn->prepare("DELETE FROM documentos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo "Documento excluído com sucesso!";
    }
?>
