<?php
require("conexao.php");

if (isset($_POST['busca'])) {
    $busca = mysqli_real_escape_string($link, $_POST['busca']);
    $funcao = mysqli_real_escape_string($link, $_POST['funcao']);
    $aceito = mysqli_real_escape_string($link, $_POST['aceito']);

    $sql = "SELECT * FROM utilizadores a INNER JOIN funcao i ON i.id_funcao = a.funcao_id";
    $condicoes = array();
    $condicoes1 = array();
    
    if ($funcao != '') {
        $condicoes1[] = "a.funcao_id = '$funcao'";
    }
    if ($aceito != '') {
        $condicoes1[] = "a.aceito = '$aceito'";
    }
    if (!empty($busca)) {
        if (count($condicoes1)>0){
            $condicoes[]="email LIKE '%$busca%' AND ".implode(" AND ", $condicoes1);
            $condicoes[]="nome LIKE '%$busca%' AND ".implode(" AND ", $condicoes1);
            $condicoes[]="telefone LIKE '%$busca%' AND ".implode(" AND ", $condicoes1);
        }
        else{
            $condicoes[]="email LIKE '%$busca%'";
            $condicoes[]="nome LIKE '%$busca%'";
            $condicoes[]="telefone LIKE '%$busca%'";
        }
        if (count($condicoes) > 0) {
            $sql .= " WHERE " . implode(" OR ", $condicoes);
        }
    }
    else{
        if (count($condicoes1) > 0) {
            $sql .= " WHERE " . implode(" AND ", $condicoes1);
        }
    }
    
    $sql.=" order by id ASC";
    $result = mysqli_query($link, $sql);

    $result = mysqli_query($link, $sql);
    $result = mysqli_query($link, $sql);
    if ($result->num_rows > 0) {
        echo "<table class='ctab2 table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Email</th>";
        echo "<th>Nome</th>";
        echo "<th>Telefone</th>";
        echo "<th>Função</th>";
        echo "<th class='peq'>Opções</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo $row["aceito"] == 1 ? "<tr>" : "<tr class='naceito'>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['nome']."</td>";
            echo "<td>".$row['telefone']."</td>";
            echo "<td>".$row['funcao']."</td>";
            echo "<td class='peq'>";
            if($row["id"]!=$_SESSION["id"]){
                if ($row["aceito"] == 1) {
                    echo "<a onclick=\"confirmacao('Tem certeza que deseja desativar esta conta?', 'aceito.php?id=".$row['id']."')\" class='btn btn-success'><i class='bi bi-check2'></i></a>";
                } else {
                    echo "<a href='aceito.php? id=".$row['id']."' class='btn btn-danger'><i class='bi bi-x-lg'></i></a>";
                }
            }
            echo "<a href='updateuti.php? id=".$row['id']."' class='btn btn-info'><i class='bi bi-pencil'></i></a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<img src='img/noresult.png'>";
    }
}

?>