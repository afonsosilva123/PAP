<?php
require_once "conexao.php";
if(isset($_SESSION["tipo"])&&$_SESSION["tipo"]==3) {
    if (isset($_GET["id"])){
        $e=1;
        $sql = "SELECT titulo,descricao,localizacao,tipologia,quartos,preco,estado,rua,espaco,proprietario,Distrito_DT,Concelho_CC FROM casas a  left join populacaoresidentefreguesia e on e.populacaoresidentefreguesia_id=a.localizacao where id=?";
        if($stmt=$link->prepare($sql)){
            $stmt->bind_param("i", $_GET["id"]);
            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows==1){
                    $stmt->bind_result($para_nome,$descricao,$loca,$tipo,$quartos,$preco,$estado,$rua,$espaco,$propri,$distrito,$concelho);
                    $stmt->fetch();
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
            $sql= "UPDATE casas SET titulo=?, preco=?,espaco=?, quartos=?, tipologia=?, localizacao=?, proprietario=?, rua=?, estado=?, descricao=? WHERE id=?";
            if($_POST["propri"]==""){
                $_POST["propri"]=null;
            }
            if(empty($_POST["quartos"])){
                $_POST["quartos"]=null;
            }
            if($stmt=$link->prepare($sql)){
                $stmt->bind_param("sissiiisisi",$_POST["nome"],$_POST["preco"],$_POST["espaco"],$_POST["quartos"],$_POST["tipo"],$_POST["loc"],$_POST["propri"],$_POST["rua"],$_POST["estado"],$_POST["descricao"],$_GET["id"]);
                $stmt->execute();
                if($stmt->error){
                    echo "Erro!".$stmt->error;
                    exit();
                }
                else{
                    header("location: admin.php?admin=casa");
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
    <title>Modificar Dados da Moradia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="img/logo.png">
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
                                <h1>Modificar Dados da Moradia</h1>                                                                                                                                                                                                                                                                                                                                                                
                            </div>
                            <form action='<?php echo $_SERVER["REQUEST_URI"]?>'method="post" id="formulario">
                                <div class="form-group"> 
                                    <input type="text" name="nome" class="form-control" required value="<?php echo $para_nome;?>">
                                    <input type="number" name="preco" class="form-control" required  value="<?php echo $preco;?>">
                                    <input type="text" name="espaco" class="form-control" required value="<?php echo $espaco;?>">
                                    <select name="quartos"  required class="form-select" style="margin-top: 2px">
                                        <?php
                                            $sql="SELECT nquartos as nome,id as id FROM quartos order by nome";
                                            $result = $link->query($sql);
                                        ?>
                                        <?php
                                            while ($row= $result->fetch_assoc()) {
                                                $selected = ($row["id"] == $quartos) ? 'selected' : '';
                                                echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["nome"] . '</option>';
                                            }
                                        ?>
                                    </select>

                                    <select id="" name="tipo" class="form-select" style="margin-top: 2px">
                                        <?php
                                            $sql = "SELECT * FROM tipologia";
                                            $result = $link->query($sql);
                                        ?>
                                        <?php
                                            while ($row= $result->fetch_assoc()) {
                                                $selected = ($row["id"] == $tipo) ? 'selected' : '';
                                                echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["nometipo"] . '</option>';
                                            }
                                        ?>
                                    </select>
                                    <select id="distrito" class="form-select" style="margin-top: 2px">
                                        <?php
                                            $sql="SELECT DISTINCT Designação_DT as nome,Distrito_DT as id FROM populacaoresidentefreguesia order by nome";
                                            $result = $link->query($sql);
                                        ?>
                                        <?php
                                            while ($row= $result->fetch_assoc()) {
                                                $selected = ($row["id"] == $distrito) ? 'selected' : '';
                                                echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["nome"] . '</option>';
                                            }
                                        ?>
                                    </select>
                                    <select id="concelho" class="form-select" style="margin-top: 2px">
                                        <?php
                                            $sql="SELECT DISTINCT Designação_CC as nome,Concelho_CC as id FROM populacaoresidentefreguesia where Distrito_DT=$distrito order by nome";
                                            $result = $link->query($sql);
                                        ?>
                                        <?php
                                            while ($row= $result->fetch_assoc()) {
                                                $selected = ($row["id"] == $concelho) ? 'selected' : '';
                                                echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["nome"] . '</option>';
                                            }
                                        ?>
                                    </select>
                                    <select name="loc" id="fregue" required class="form-select" style="margin-top: 2px">
                                        <?php
                                            $sql="SELECT Designação_FR as nome,populacaoresidentefreguesia_id as id FROM populacaoresidentefreguesia where Concelho_CC=$concelho order by nome";
                                            $result = $link->query($sql);
                                        ?>
                                        <?php
                                            while ($row= $result->fetch_assoc()) {
                                                $selected = ($row["id"] == $loca) ? 'selected' : '';
                                                echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["nome"] . '</option>';
                                            }
                                        ?>
                                    </select>
                                    <input type="text" name="rua" class="form-control" required value="<?php echo $rua;?>">
                                    <div class="input-group">
                                    <select id="emailSelect" name="propri" class="form-select" style="width: 60%;">
                                        <?php
                                            $sql = "SELECT id, email FROM utilizadores";
                                            $result = $link->query($sql);
                                            while ($row= $result->fetch_assoc()) {
                                                if($e==1){
                                                    $selected = ($row["id"] == $propri) ? 'selected' : '';
                                                    if($selected=='selected')
                                                    $e++;
                                                }
                                                else{
                                                    $selected = ($row["id"] == -111) ? 'selected' : '';
                                                }
                                                echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["email"] . '</option>';
                                            }
                                        ?>
                                    </select>
                                        <input type="text" id="search" class="form-control"  placeholder="Pesquisar email" autocomplete="off" aria-label="Pesquisar email">                                       
                                    </div>
                                    <textarea name="descricao" class="form-control" placeholder="Descrição" id=""><?php echo  $descricao;?></textarea>
                                    <select id="selectcolor" class="form-select" name="estado">
                                        <option value="2" class="greenop" <?php if($estado==2){echo "selected";}?>>Disponivel</option>
                                        <option value="1" class="orangeop" <?php if($estado==1){echo "selected";}?>>Indisponivel no site</option>
                                        <option value="0" class="redop" <?php if($estado==0){echo "selected";}?>>Não aparecer site</option>
                                    </select>
                                    <br><input type="submit" value="Alterar">
                                    <a href="admin.php?admin=casa" class="butaodireita">Cancelar</a><br>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
const select = document.getElementById('selectcolor');

function updateSelectColor() {
    const selectedOption = select.options[select.selectedIndex];
    select.style.color = ''; 
    if (selectedOption.classList.contains('greenop')) {
        select.style.color = 'green';
    } else if (selectedOption.classList.contains('orangeop')) {
        select.style.color = 'orange';
    } else if (selectedOption.classList.contains('redop')) {
        select.style.color = 'red';
    }
}

select.addEventListener('change', updateSelectColor);

updateSelectColor();
$(document).ready(function() {
    var allOptions = $('#emailSelect option').clone();
    $('#search').on('input', function() {
        var selectedOption = $('#emailSelect option:selected').clone();
        var searchTerm = $(this).val().toLowerCase();
        var exactMatches = [];
        var startsWithMatches = [];
        var containsMatches = [];
        var ncontainsMatches = [];
        $('#emailSelect').empty();
        
        var marc=0
        
        console.log(selectedOption.text());
        
        // Filtra as opções
        allOptions.each(function() {
            var email = $(this).text().toLowerCase(); 
            if($(this).val()!=selectedOption.val()){
                if (email === searchTerm) {
                    exactMatches.push($(this).clone()); 
                    marc=1
                } else if (email.startsWith(searchTerm)) {
                    startsWithMatches.push($(this).clone());   
                    marc=1
                } else if (email.includes(searchTerm)) {
                    containsMatches.push($(this).clone());               
                    marc=1 
                }else {
                    ncontainsMatches.push($(this).clone()); 
                }
            }else{
                if (email.includes(searchTerm)){
                    marc=1
                }
            }
        });
        $('#emailSelect').empty(); 
        if (selectedOption.length) {
            $('#emailSelect').append(selectedOption); 
        }
        exactMatches.forEach(function(option) {
            $('#emailSelect').append(option);
        });

        startsWithMatches.forEach(function(option) {
            $('#emailSelect').append(option);
        });

        containsMatches.forEach(function(option) {
            $('#emailSelect').append(option);
        });

        if (exactMatches.length === 0 && startsWithMatches.length === 0 && containsMatches.length === 0&&marc==0) {
            $('#emailSelect').append('<option value="" disabled>Nenhum resultado encontrado</option>');
        }
        if (searchTerm === "") {
            ncontainsMatches.forEach(function(option) {
            $('#emailSelect').append(option);
        });
        }
        $('#emailSelect').prop('selectedIndex', 0);
    });
});
</script>



<script src="js/js.js"></script>
</html>
<?php
    }
    else {
        die("Não tem acesso a esta página");
    }
?>