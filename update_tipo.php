<?php
require_once "conexao.php";
if(isset($_SESSION["tipo"])&&$_SESSION["tipo"]==3) {
    if (isset($_GET["id"])){
        $sql = "SELECT nometipo FROM tipologia  where id=?";
        if($stmt=$link->prepare($sql)){
            $stmt->bind_param("i", $_GET["id"]);
            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows==1){
                    $stmt->bind_result($para_nome);
                    $stmt->fetch();
                    $sql="SELECT idcol FROM tipologia_colunas where idtipo=".$_GET["id"];
                    $result=$link->query($sql);
                    $colunas = array();
                    while($row = $result->fetch_assoc()){
                        $colunas[] = $row;
                    }
                    echo "<script>console.log(" . json_encode($colunas) . ")</script>";
                    $idcols = array_column($colunas, 'idcol');
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
        if(!empty($_POST["nome"])){
            $sql= "UPDATE tipologia SET nometipo=? WHERE id=?";
            
            if($stmt=$link->prepare($sql)){
                $stmt->bind_param("si",$_POST["nome"],$_GET["id"]);
                $stmt->execute();
                if($stmt->error){
                    echo "Erro!".$stmt->error;
                    exit();
                }
                else{
                    
                    $sql="DELETE FROM tipologia_colunas WHERE idtipo=".$_GET["id"];
                    $link->query($sql);
                    $tipo =$_GET["id"];
                    if(isset($_POST["jardim"])){
                        $sql="INSERT INTO tipologia_colunas (idcol,idtipo) VALUES (1,".$tipo.")";
                        $result=$link->query($sql);
                    }
                    if(isset($_POST["piscina"])){
                        $sql="INSERT INTO tipologia_colunas (idcol,idtipo) VALUES (2,".$tipo.")";
                        $result=$link->query($sql);
                    }
                    if(isset($_POST["varanda"])){
                        $sql="INSERT INTO tipologia_colunas (idcol,idtipo) VALUES (3,".$tipo.")";
                        $result=$link->query($sql);
                    }
                    if(isset($_POST["arreca"])){
                        $sql="INSERT INTO tipologia_colunas (idcol,idtipo) VALUES (4,".$tipo.")";
                        $result=$link->query($sql);
                    }
                    if(isset($_POST["terraco"])){
                        $sql="INSERT INTO tipologia_colunas (idcol,idtipo) VALUES (5,".$tipo.")";
                        $result=$link->query($sql);
                    }
                    if(isset($_POST["elevador"])){
                        $sql="INSERT INTO tipologia_colunas (idcol,idtipo) VALUES (6,".$tipo.")";
                        $result=$link->query($sql);
                    }
                    if(isset($_POST["gar"])){
                        $sql="INSERT INTO tipologia_colunas (idcol,idtipo) VALUES (7,".$tipo.")";
                        $result=$link->query($sql);
                    }
                    header("location: admin.php?admin=tipo");
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
                            <form action='<?php echo $_SERVER["REQUEST_URI"]?>'method="post">
                            <div class="form-group"> 
                            <input type="text" name="nome" class="form-control" required value="<?php echo $para_nome;?>">
                            <div>
                                    <input type="checkbox" <?php if(in_array(1, $idcols)) echo "checked";?>  name="jardim"> Jardim
                                    <input type="checkbox" <?php if(in_array(2, $idcols)) echo "checked";?>  name="piscina"> Piscina
                                    <input type="checkbox" <?php if(in_array(3, $idcols)) echo "checked";?>  name="varanda"> Varanda
                                </div> 
                                <div> 
                                    <input type="checkbox" <?php if(in_array(4, $idcols)) echo "checked";?>  name="arreca"> Arrecadação
                                    <input type="checkbox" <?php if(in_array(5, $idcols)) echo "checked";?>  name="terraco"> Terraço
                                    <input type="checkbox" <?php if(in_array(6, $idcols)) echo "checked";?>  name="elevador"> Elevador
                                    <input type="checkbox" <?php if(in_array(7, $idcols)) echo "checked";?>  name="gar"> Garagem
                                </div>
                            <br>
                            <input type="submit" value="Alterar">
                            <a href="admin.php?admin=tipo" class="butaodireita">Cancelar</a><br>
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