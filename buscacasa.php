<?php
require("conexao.php");

if (isset($_POST['busca'])) {
    $busca = mysqli_real_escape_string($link, $_POST['busca']);
    $tipo = mysqli_real_escape_string($link, $_POST['tipo']);
    $distrito = mysqli_real_escape_string($link, $_POST['distrito']);
    $concelho = mysqli_real_escape_string($link, $_POST['concelho']);
    $fregue = mysqli_real_escape_string($link, $_POST['fregue']);
    $dist= mysqli_real_escape_string($link, $_POST['dist']);
    $sql = "SELECT *, a.id as idcasa, e.id as iduti,a.estado as estado FROM casas a LEFT JOIN populacaoresidentefreguesia i ON i.populacaoresidentefreguesia_ID = a.localizacao LEFT JOIN tipologia on a.tipologia=tipologia.id left join utilizadores e on e.id=a.proprietario inner join quartos q on q.id=a.quartos";
    $condicoes = array();
    $condicoes1 = array();
    if ($dist != '') {
        if($dist==1){
            $condicoes1[] = "a.estado = 2";
        }
        else{
            $condicoes1[] = "a.estado != 2";
        }
    }
    if ($tipo != '') {
        $condicoes1[] = "a.tipologia = '$tipo'";
    }
    if ($distrito != '') {
        $condicoes1[] = "i.Distrito_DT = '$distrito'";
    }
    if ($concelho != ''&&is_numeric($concelho)) {
        $condicoes1[] = "i.Concelho_CC = '$concelho'";
    }
    if ($fregue != '' &&is_numeric($fregue)) {

        $condicoes1[] = "i.populacaoresidentefreguesia_id = '$fregue'";
    }
    if (!empty($busca)) {
        if (count($condicoes1)>0){
            if (mb_substr($busca, -1) == '€') {
                $busca1 = mb_substr($busca, 0, -1, 'UTF-8');
                $condicoes[]="preco LIKE '%$busca1%' AND ".implode(" AND ", $condicoes1);
            } 
            else{
                $condicoes[]="e.email LIKE '%$busca%' AND ".implode(" AND ", $condicoes1);
                $condicoes[]="titulo LIKE '%$busca%' AND ".implode(" AND ", $condicoes1);
                $condicoes[]="espaco LIKE '%$busca%' AND ".implode(" AND ", $condicoes1);
                $condicoes[]="rua LIKE '%$busca%' AND ".implode(" AND ", $condicoes1);
            }
            
        }
        else{
            if (mb_substr($busca, -1) == '€'){
                $busca1 = mb_substr($busca, 0, -1, 'UTF-8');
                $condicoes[]="preco LIKE '%$busca1%'";
            } 
            else{
                $condicoes[]="email LIKE '%$busca%'";
                $condicoes[]="titulo LIKE '%$busca%'";
                $condicoes[]="espaco LIKE '%$busca%'";
                $condicoes[]="rua LIKE '%$busca%'";
            }
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
    
    $sql.=" order by a.id ASC";
    $result = mysqli_query($link, $sql);
    if ($result->num_rows > 0) {
        echo "<table class='ctab2 table table-bordered table-striped casatable'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Titulo</th>";
        echo "<th>Preço</th>";
        echo "<th>Distrito</th>";
        echo "<th>Concelho</th>";
        echo "<th>Freguesia</th>";
        echo "<th>Rua</th>";
        echo "<th>Tipo</th>";
        echo "<th>Email</th>";
        echo "<th class='peq2'>Opções</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo $row["estado"] == 2 ? "<tr>" : "<tr class='naceito'>";
            echo "<td>".$row['titulo']."</td>";
            echo "<td>".$row['preco']."€</td>";
            echo "<td>".$row['Designação_DT']."</td>";
            echo "<td>".$row['Designação_CC']."</td>";
            echo "<td>".$row['Designação_FR']."</td>";
            echo "<td>".$row['rua']."</td>";
            echo "<td>".$row['nometipo']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td class='peq2'>";
            if ($row["estado"] == 2) {
                echo "<a onclick=\"confirmacao('Tem certeza que deseja tirar do site (irá aparecer transparente por uma semana)?', 'aceitocasa.php?id=".$row['idcasa']."')\" class='btn btn-success'><i class='bi bi-check2'></i></a>";
            } else {
                echo "<a onclick=\"confirmacao('Tem certeza que deseja que apareça outra vez no site?', 'aceitocasa.php?id=".$row['idcasa']."')\"class='btn btn-danger'><i class='bi bi-x-lg'></i> </a>";
            }
            echo "<a href='vercasa.php? id=".$row['idcasa']."' class='btn btn-info'><i class='bi bi-info-circle'></i></a>";
            echo "<a href='updatecasa.php? id=".$row['idcasa']."' class='btn btn-info'><i class='bi bi-pencil'></i></a>";
            

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