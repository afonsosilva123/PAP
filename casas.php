<?php
    require_once("conexao.php");
    if  (isset($_GET['id'])) {
        $sql="SELECT titulo,preco,nometipo,espaco,Designação_DT,Designação_CC,Designação_FR,descricao,quartos,rua
        from casas left join populacaoresidentefreguesia on populacaoresidentefreguesia_id=localizacao 
        inner join tipologia on tipologia.id=casas.tipologia where casas.id=?";
        if($stmt=$link->prepare($sql)){
            $stmt->bind_param("i", $_GET["id"]);
            if($stmt->execute()){
                $stmt->store_result();
                if ($stmt->num_rows == 0) {
                    echo "Nenhuma linha encontrada!";
                    exit();
                } elseif ($stmt->num_rows > 1) {
                    echo "Mais de uma linha encontrada!";
                    exit();
                } else {
                    $stmt->bind_result($titulo,$preco,$tipo,$espaco,$distrito,$concelho,$freguesia,$descricao,$quartos,$rua);
                    $stmt->fetch();
                }
                
            }else{
                echo "Erro informação!";
                exit();
            }
        }
        $sql="SELECT * FROM imgcasa WHERE  casa=".$_GET["id"]." order BY importancia DESC";
        $result =$link->query($sql);
        $img = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $img[] = $row['source'];
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo?></title>
    <link rel="icon" type="image/png"  href="img/logo.png">
    <link rel="stylesheet" href="css/stylecasa.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body >
    <?php
        include("nav.php");
    ?>
    <div class="ff">
        
        <div class="dados">
            <h1><?php echo $titulo?></h1><br>
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($img as $index => $imagem) { ?>
                        <div class="carousel-item <?php if ($index == 0) { echo "active"; } ?>">
                            <img src="imgcasa/<?php echo $imagem; ?>" class="d-block w-100" alt="<?php echo $titulo ?>">
                        </div>
                    <?php } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only"></span>
                </button>
            </div>
            <div class="carousel-thumbnails-container">
                <div class="carousel-thumbnails">
                    <?php foreach ($img as $index => $imagem) { ?>
                        <img src="imgcasa/<?php echo $imagem; ?>" alt="<?php echo $titulo ?>" data-target="#carouselExampleControls" data-slide-to="<?php echo $index ?>">
                    <?php } ?>
                </div>
            </div>
            <div class="body-text">
                <b><h2>Preço <?php  echo $preco?>€</h2></b>
                <h4>Área</h4>
                <?php echo "$espaco";?>
                <h4>Localização</h4>
                <?php echo $tipo." em ". $distrito." ".$concelho." ".$freguesia." ".$rua; ?>
                <h4><i class="fas fa-bed"></i> <b>:</b> <?php echo $quartos ?></h4>
                <h4>Descrição</h4>
                <?php echo $descricao ?>
            </div>
        </div>
        <div class="esq" >
            <h4>Envie uma mensagem</h4>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$('.carousel-thumbnails img').on('click', function() {
    var index = $(this).data('slide-to');
    $('#carouselExampleControls').carousel(index);
    $('.carousel-thumbnails img').removeClass('active');
    $(this).addClass('active');
});
$(document).ready(function() {
    // Seleciona a primeira imagem thumbnail como ativa
    $('.carousel-thumbnails img:first-child').addClass('active');   
    // Sincroniza o carousel com os thumbnails
    $('#carouselExampleControls').on('slide.bs.carousel', function(event) {
        var index = event.to;
        $('.carousel-thumbnails img').removeClass('active');
        $('.carousel-thumbnails img:eq(' + index + ')').addClass('active');
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>