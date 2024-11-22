<?php
require_once "conexao.php";
if(isset($_SESSION["tipo"])&&$_SESSION["tipo"]==3) {
    if (isset($_GET["id"])){
        $sql = "SELECT nome,email,telefone,funcao_id FROM utilizadores  where id=?";
        if($stmt=$link->prepare($sql)){
            $stmt->bind_param("i", $_GET["id"]);
            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows==1){
                    $stmt->bind_result($para_nome,$para_email,$para_tel,$funcao);
                    $stmt->fetch();
                    $_SESSION["update"]=$_GET["id"];
                }else{
                    echo "Erro! Informação não encontrada";
                    exit();
                } 
            } else{
                echo "Erro! Tente mais tarde";
                    exit();
            }
            $stmt->close();
        } 
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(!empty($_POST["nome"])&&!empty($_POST["email"])&&!empty($_POST["tel"])&&!empty($_POST["funcao"])){
            $sql= "UPDATE utilizadores SET nome=?, email=?,telefone=?, funcao_id=? WHERE id=?";
            
            if($stmt=$link->prepare($sql)){
                $stmt->bind_param("ssiii",$_POST["nome"],$_POST["email"],$_POST["tel"],$_POST["funcao"],$_SESSION["update"]);
                $stmt->execute();
                if($stmt->error){
                    echo "Erro!".$stmt->error;
                    exit();
                }
                else{
                    header("location: admin.php?admin=uti");
                    exit();
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Modificar Dados do Produto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="../img/logo_site.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body class="up">
    <?php
        include "nav.php";
    ?>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">
                            <div class="page-header">
                                <h1>Modificar Dados do Utilizador</h1>                                                                                                                                                                                                                                                                                                                                                                
                            </div>
                            <form action='<?php echo $_SERVER["PHP_SELF"]?>'method="post">
                            <div class="form-group"> 
                            <input type="text" name="nome" class="form-control" required value="<?php echo $para_nome;?>">
                            <input type="email" name="email" class="form-control" required  value="<?php echo $para_email;?>">
                            <input type="number" name="tel" class="form-control" max=999999999 min=100000000 required value="<?php echo $para_tel;?>">
                            <select id="" name="funcao" class="form-select" style="margin-top: 2px">
                                <?php
                                    $sql = "SELECT * FROM funcao";
                                    $result = $link->query($sql);
                                ?>
                                <?php
                                    while ($row= $result->fetch_assoc()) {
                                        $selected = ($row["id_funcao"] == $funcao) ? 'selected' : '';
                                        echo '<option value="' . $row["id_funcao"] . '" ' . $selected . '>' . $row["funcao"] . '</option>';
                                    }
                                ?>
                            </select>
                            <input type="submit" value="Alterar">
                            <a href="admin.php?admin=uti" class="butaodireita">Cancelar</a><br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    }
    else {
        die("Não tem acesso a esta página");
    }
?>