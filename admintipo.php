<?php
if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 3){
    $sql ="SELECT * FROM tipologia where estado=1 order by  nometipo asc";
    $result=$link->query($sql);
?>

<body style="background-color: white!important;">
   
    <div id="confirm-dialog" style="display: none;">
        <div class="confirm-dialog-content">
            <h2>Confirmação</h2>
            <p id="confirm-message"></p><br>
            <button id="confirm-ok" class="btn btn-success">OK</button>
            <button id="confirm-cancel" class="btn btn-danger">Cancelar</button>
        </div>
    </div>
    <button class="instipo" onclick="window.location.href='inserir_tipo.php'">+</button>
        <div id="resultados" class="table-responsive">
            <?php
                if($result->num_rows>0){
                    echo "<div class='table-responsive'>";
                    echo "<table class='ctab2 table table-bordedred table-striped'>";
                    echo "<thead>";
                    echo"<tr>";
                    echo"<th>Tipologia</th>";
                    echo"<th class='peq'>Opções</th>";
                    echo"</tr>";
                    echo"</thead>";
                    echo"</tbody>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['nometipo']. "</td>";
                        echo "<td class='peq'>";
                        echo "<a href='update_tipo.php? id=".$row['id']."'class='btn btn-info'><i class='bi bi-pencil'></i></a>";
                        echo "<a href='deletetipo.php? id=".$row['id']."'class='btn btn-danger'><i class='bi bi-trash'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                    $result->free();
                }
                else {
                    echo "<img src='img/noresult.png'>";
                }
            ?>
        </div>
</body>


<?php
}
?>




