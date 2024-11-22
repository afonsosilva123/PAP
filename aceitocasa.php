<?php
require("conexao.php");
if (isset($_GET["id"]) && isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 3) {
    $sql="SELECT * FROM casas WHERE id =".$_GET["id"];
    $result=mysqli_query($link,$sql);
    if($result->num_rows==1){
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($row["estado"]==2){
            $ac=1;
        }
        else{
            $ac=2;
        }
        $sql = "UPDATE casas set estado=? where id=?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ii",$ac, $_GET["id"]);
        try {
            $stmt->execute();
            header("Location: admin.php?admin=casa");
            exit();
        } catch (Exception $e) {
            echo "Ocorreu um erro - Tente Novamente";
            error_log($e->getMessage());
        }
    }
    else{
        echo "aaasasa";
    }
}
else{
    echo "aaaa";
}
?>