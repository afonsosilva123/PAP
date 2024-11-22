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
        <select id="funcao" class="search form-select" name="funcao">
        <option value="">Todas as funções</option>
        <?php
        $sql = "SELECT * FROM funcao";
        $result = mysqli_query($link, $sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['id_funcao']."'>".$row['funcao']."</option>";
        }
        ?>
    </select>
    <select id="aceito" class="search form-select" name="aceito">
        <option value="">Todos os status</option>
        <option value="1">Aceitos</option>
        <option value="0">Não aceitos</option>
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

<script>
$(document).ready(function() {
    $.ajax({
        type: 'POST',
        url: 'buscauti.php',
        data: {busca: '', funcao: '', aceito: ''},
        success: function(data) {
            $('#resultados').html(data);
        }
    });

    $('#busca').on('keyup', function() {
        var busca = $(this).val();
        var funcao = $('#funcao').val();
        var aceito = $('#aceito').val();
        $.ajax({
            type: 'POST',
            url: 'buscauti.php',
            data: {busca: busca, funcao: funcao, aceito: aceito},
            success: function(data) {
                $('#resultados').html(data);
            }
        });
    });

    $('#funcao').on('change', function() {
        var busca = $('#busca').val();
        var funcao = $(this).val();
        var aceito = $('#aceito').val();
        $.ajax({
            type: 'POST',
            url: 'buscauti.php',
            data: {busca: busca, funcao: funcao, aceito: aceito},
            success: function(data) {
                $('#resultados').html(data);
            }
        });
    });

    $('#aceito').on('change', function() {
        var busca = $('#busca').val();
        var funcao = $('#funcao').val();
        var aceito = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'buscauti.php',
            data: {busca: busca, funcao: funcao, aceito: aceito},
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