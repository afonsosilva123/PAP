<?php
require_once("conexao.php");
if(!isset($_POST["email"], $_POST["pass"])){
    die("Preenha os dedos do utilizador");
}
if($stmt=$link->prepare("SELECT id,senha, funcao_id, nome,aceito,telefone FROM utilizadores WHERE email=?")){
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
        $stmt->bind_result($id,$senha,$funcao,$nome,$aceito,$telefone);
        $stmt->fetch();
        $comparacao = password_verify($_POST["pass"], $senha);
        if($comparacao){
            if($aceito==1){
                session_regenerate_id();
                $_SESSION["log-in"] = TRUE;
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["nome"] = $nome;
                $_SESSION["tel"] = $telefone;
                $_SESSION["id"] = $id;
                $_SESSION["tipo"] = $funcao;
                header("Location:index.php");
            }
            else{
                echo "A sua conta ainda não foi aprovada";
            }
        }
        else{
            echo"Password Incorreta";
        }
    }else{
        echo "Login errado";
    }
    $stmt->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>
    <link rel="stylesheet" href="css/estilo1.css">
</head>
<body class="idd d">
    <p><button id="buton" onclick="window.location.href='index.php'">Voltar</button></p>
</body>
</html>