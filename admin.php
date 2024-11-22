<?php
require("conexao.php");
if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 3){
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Admin</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background-color: white!important;">
    <?php include("nav.php"); ?>
    <div class="admin">
        <div class="adminmenu">
            <button <?php if(!isset($_GET["admin"])) echo"class='active'";?> onclick="window.location.href='admin.php'">Inicio</button>
            <button <?php if(isset($_GET["admin"])&&$_GET["admin"]=="uti") echo"class='active'";?> onclick="window.location.href='admin.php?admin=uti'">Gerir Utilizadores</button>
            <button <?php if(isset($_GET["admin"])&&$_GET["admin"]=="casa") echo"class='active'";?> onclick="window.location.href='admin.php?admin=casa'">Gerir Casas</button>
            <button <?php if(isset($_GET["admin"])&&$_GET["admin"]=="tipo") echo"class='active'";?> onclick="window.location.href='admin.php?admin=tipo'">Gerir Tipos de Casas</button>
        </div>
        <div class="admincontent <?php if(!isset($_GET["admin"])) echo 'adm';?>">
            <?php if(!isset($_GET["admin"])){?>
                    <h1>Página de gerenciamento do site</h1>
            <?php }else{
                    $admin = $_GET["admin"];
                    if($admin=="uti"){
                        include("adminuti.php");
                    }
                    else if($admin=="casa"){
                        include("admincasas.php");
                    }
                    else if($admin=="tipo"){
                        include("admintipo.php");
                    }
                    else echo"<h1>Página de gerenciamento do site</h1>";
                }
            ?>
        </div>
    </div>
</body>
</html>
<?php        
}
?>