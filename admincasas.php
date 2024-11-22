<?php

if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == 3){
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
    <div class="input-group">
        <input type="search" id="busca"class="search form-control" placeholder="Pesquisa">
        <select id="tipo" class="search form-select" name="tipo">
            <option value="">Todas os Tipos</option>
            <?php
                $sql = "SELECT * FROM tipologia where estado!=0";
                $result = mysqli_query($link, $sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['id']."'>".$row['nometipo']."</option>";
                }
            ?>
        </select>
        <select id="distrito" class="search form-select" name="distrito">
            <option value="">Todos os Distritos</option>
            <?php
                $sql="SELECT DISTINCT Designação_DT as nome,Distrito_DT as id FROM populacaoresidentefreguesia order by nome ";
                $result=mysqli_query($link,$sql);
                while($row=mysqli_fetch_assoc($result)){
                    echo "<option value='".$row["id"]."'>".$row["nome"]."</option>";
                }
            ?>
        </select>
        <select id="concelho" class="search form-select" name="concelho">
            <option value="">Todos os Concelhos</option>
        </select>
        <select id="fregue" name="fregue" class="search form-select">
            <option value="">Todas as Freguesias</option>
        </select>
        <select id="disponiblidade" class="search form-select" name="aceito">
            <option value="">Todos os status</option>
            <option value="1">Disponivel</option>
            <option value="0">Não Disponivel</option>
        </select>
    </div>
        <div id="resultados" class="table-responsive">
            <!-- Resultados da busca serão inseridos aqui -->
        </div>
</body>
<script>
function confirmacao(mensagem, url) {
    document.getElementById("confirm-message").innerHTML = mensagem;
    document.getElementById("confirm-ok").addEventListener("click", function() {
        window.location.href = url;
    });
    document.getElementById("confirm-cancel").addEventListener("click", function() {
        document.getElementById("confirm-dialog").style.display = "none";
    });
    document.getElementById("confirm-dialog").style.display = "block";
}
</script>
<script src="js/js.js">
</script>
<script>
$(document).ready(function() {
    $.ajax({
        type: 'POST',
        url: 'buscacasa.php',
        data: {busca: '', distrito: '', concelho: '',fregue: '',tipo: '',dist:''},
        success: function(data) {
            $('#resultados').html(data);
        }
    });

    $('#busca').on('keyup', function() {
        var busca = $(this).val();
        var tipo = $('#tipo').val();
        var distrito = $('#distrito').val();
        var concelho = $('#concelho').val();
        var fregue = $('#fregue').val();
        var dist = $('#disponiblidade').val();
        $.ajax({
            type: 'POST',
            url: 'buscacasa.php',
            data: {busca: busca, tipo: tipo, fregue: fregue, concelho: concelho, distrito: distrito,dist:dist},
            success: function(data) {
                $('#resultados').html(data);
            }
        });
    });

    $('#tipo').on('change', function() {
        var busca = $('#busca').val();
        var tipo = $(this).val();
        var distrito = $('#distrito').val();
        var concelho = $('#concelho').val();
        var fregue = $('#fregue').val();
        var dist = $('#disponiblidade').val();
        $.ajax({
            type: 'POST',
            url: 'buscacasa.php',
            data: {busca: busca, tipo: tipo, fregue: fregue, concelho: concelho, distrito: distrito,dist:dist},
            success: function(data) {
                $('#resultados').html(data);
            }
        });
    });

    $('#distrito').on('change', function() {
        var busca = $('#busca').val();
        var tipo = $('#tipo').val();
        var distrito = $(this).val();
        var fregue = $('#fregue').val();
        var concelho = $('#concelho').val();
        var dist = $('#disponiblidade').val();
        $.ajax({
            type: 'POST',
            url: 'buscacasa.php',
            data: {busca: busca, tipo: tipo, fregue: fregue, concelho: concelho, distrito: distrito,dist:dist},
            success: function(data) {
                $('#resultados').html(data);
            }
        });
    });
    $('#concelho').on('change', function() {
        var busca = $('#busca').val();
        var tipo = $('#tipo').val();
        var concelho = $(this).val();
        var fregue = $('#fregue').val();
        var distrito = $('#distrito').val();
        var dist = $('#disponiblidade').val();
        $.ajax({
            type: 'POST',
            url: 'buscacasa.php',
            data: {busca: busca, tipo: tipo, fregue: fregue, concelho: concelho, distrito: distrito,dist:dist},
            success: function(data) {
                $('#resultados').html(data);
            }
        });
    });
    $('#fregue').on('change', function() {
        var busca = $('#busca').val();
        var tipo = $('#tipo').val();
        var concelho = $('#concelho').val();
        var fregue = $(this).val();
        var distrito = $('#distrito').val();
        var dist = $('#disponiblidade').val();
        $.ajax({
            type: 'POST',
            url: 'buscacasa.php',
            data: {busca: busca, tipo: tipo, fregue: fregue, concelho: concelho, distrito: distrito,dist:dist},
            success: function(data) {
                $('#resultados').html(data);
            }
        });
    });
    $('#disponiblidade').on('change', function() {
        var busca = $('#busca').val();
        var tipo = $('#tipo').val();
        var concelho = $('#concelho').val();
        var fregue = $('#fregue').val();
        var distrito = $('#distrito').val();
        var dist = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'buscacasa.php',
            data: {busca: busca, tipo: tipo, fregue: fregue, concelho: concelho, distrito: distrito,dist:dist},
            success: function(data) {
                $('#resultados').html(data);
            }
        });
    });
});
</script>

<?php
}
?>