<?php
//require_once("../config/config.php");
require_once ('conexao.php'); 
if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 3) {
    function legal_input($value) { 
        $value = trim($value); 
        $value = stripslashes($value); 
        $value = htmlspecialchars($value); 
        return $value; 
    } 
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $tipo=legal_input($_POST["nome"]);
        if(isset($_POST["nome"])){
                $sql="SELECT * FROM tipologia where nometipo='".$tipo."'";
                $result=$link->query($sql);
                if($result->num_rows==0){
                        $sql="INSERT INTO tipologia (nometipo) VALUES (?)";
                        if($stmt=$link->prepare($sql)){
                            $stmt->bind_param("s",$tipo);
                            if($stmt->execute()){
                                
                                $tipo = mysqli_insert_id($link);
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
                            else{
                                echo"Ocorreu um erro! Por favor tente novamente";
                            }
                            $stmt->close();
                }
            }
        $link->close();
        }
    }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Inserir Tipo de Casa</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.cdnfonts.com/css/games" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="img/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
<?php
    include "nav.php";
?>
    </br></br>
    <div id="confirm-dialog" style="display: none;">
        <div class="confirm-dialog-content">
            <h2>Confirmação</h2>
            <p id="confirm-message"></p><br>
            <button id="confirm-ok" class="btn btn-success">OK</button>
            <button id="confirm-cancel" class="btn btn-danger">Cancelar</button>
        </div>
    </div>
    <div class="container">
                <div class="card" >
                     <div class="card-body">
                        <div class="page-header">
                            <h1>Inserir Tipo de Casa</h1>
                        </div>
                        <p>Registo de Tipos de Casas.</p><br>
                        <form method="post" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <input  type="text" name="nome" class="form-control" placeholder="Nome do Tipo de Casa" required>
                                <div>
                                    <input type="checkbox" name="jardim"> Jardim
                                    <input type="checkbox" name="piscina"> Piscina
                                    <input type="checkbox" name="varanda"> Varanda
                                </div>
                                <div>
                                    <input type="checkbox" name="arreca"> Arrecadação
                                    <input type="checkbox" name="terraco"> Terraço
                                    <input type="checkbox" name="elevador"> Elevador
                                    <input type="checkbox" name="gar"> Garagem
                                </div>
                            <br>
                                <input type="submit" onclick="confirmacao(event)" class="btn btn-primary"  value="Inserir">

                                <a href="admin.php?admin=tipo" class="butaodireita">Cancelar</a><br>
                            </div>
                        </form>
                    <br>
                </div>
        </div>
    </div>
</body>
</html>
<script>
function confirmacao(event) {
    if(document.querySelector('input[name="nome"]').value!=""){
        event.preventDefault();
        document.getElementById("confirm-message").innerHTML = "Tem mesmo a certeza que deseja adicionar "+ document.querySelector('input[name="nome"]').value+" como um novo tipo de casa?";
        document.getElementById("confirm-ok").addEventListener("click", function() {
            document.getElementById("form").submit()
        });
        document.getElementById("confirm-cancel").addEventListener("click", function() {
            document.getElementById("confirm-dialog").style.display = "none";
        });
        document.getElementById("confirm-dialog").style.display = "block";
    }
}
</script>
<?php
    }
    else {
        die("Não tem acesso a esta mensagem");
    }
?>