<?php
require_once "conexao.php";
if(isset($_GET["id"])&&!empty($_GET["id"])&&$_SESSION["tipo"]==3){
    $sql="SELECT * FROM casas  WHERE tipologia =".$_GET["id"];
    $result=mysqli_query($link,$sql);
    if($result->num_rows==0){
        $sql="UPDATE tipologia set estado=0 WHERE id = ?";
         if($stmt=$link->prepare($sql)){
            $stmt->bind_param("i", $_GET["id"]) ;
            if($stmt->execute()){
              header("location: admin.php?admin=tipo");
                 exit();
            } else{
                echo "Ocorreu um erro! Por favor tente novamente.";
            }
        }
    }
    $stmt->close();
    $link->close();
} 
?>