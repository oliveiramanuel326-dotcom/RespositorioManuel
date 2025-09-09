<?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $permissao = $_POST['permissao'];

        $conn = connectDB();
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, senha, permissao) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $senha, $permissao);
        $stmt->execute();

        echo "Usuário criado com sucesso!";
    }
?>

    <form method="POST">
        <label for="nome">Nome</label>
        <input type="text" name="nome" required><br>
        <label for="senha">Senha</label>
        <input type="password" name="senha" required><br>
        <label for="permissao">Permissao</label>
        <select name="permissao">
            <option value="user">Usuário</option>
            <option value="admin">Administrador</option>
        </select><br>
        <button type="submit">Criar Usuario</button>
    </form>
