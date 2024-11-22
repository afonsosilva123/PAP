<?php 
include("conexao.php");
$sql="SELECT  *, casas.id as idcasa, tipologia.estado as estadotipo, casas.estado as estadocasa from casas left join populacaoresidentefreguesia on populacaoresidentefreguesia_id=localizacao inner join tipologia on tipologia.id=casas.tipologia LEFT JOIN 
            imgcasa i ON i.casa = casas.id AND i.importancia = 1 inner join quartos q on q.id=casas.quartos where casas.estado!=0";
$result = mysqli_query($link, $sql);
$casas = [];
while($row = mysqli_fetch_assoc($result)){
    $casa_id = $row['idcasa'];
    if (!isset($casas[$casa_id])) {
        $casas[$casa_id] = [
            'id' => $row['idcasa'],
            'titulo' => $row['titulo'],
            'tipologia' => $row['nometipo'],
            'descricao' => $row['descricao'],
            'quartos' => $row['nquartos'],
            'localizacao' => $row['Designação_DT']." ".$row['Designação_CC']." ".$row['Designação_FR']." ".$row['rua'],
            'preco' => $row['preco'],
            'estado' => $row["estadocasa"],
            'espaco' => $row["espaco"]."m2",
            'imagens' => $row["source"]

        ];
            
    }
}
        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Prisma de Viragem</title>
    <link rel="icon" type="image/png"  href="img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php
        include("nav.php");
    ?>
    <button id="indexfilter"> <i class="bi bi-list"></i> </button>
    <?php if(isset($_SESSION["tipo"])&&$_SESSION["tipo"]!=1){
    ?>
    <div class="pop-up">
        <button class="anuncio" id="popup" onclick="window.location.href='criarcasa.php'" >Anunciar</button>
        <button class="esconder" id="popupes"><svg id="popupicon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left roteted" viewBox="0 0 16 16">
  <path d="M10 12.796V3.204L4.519 8zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753"/>
</svg></button>
    </div>
    <?php } ?>
    <div class="container loja">
        <?php foreach ($casas as $casa): 
            if($casa["estado"]==2){?>
            <div class='card1'>
                <div class="card-images1">
                    <img src="<?php echo "imgcasa/".$casa['imagens']; ?>"  alt="Imagem da casa">
                </div>
                <div class="card-text">
                    <div class="card-header1">
                        <h3 class="ddd" style="margin-right: auto;"><b><a href="casas.php?id=<?php echo $casa["id"];?>" ><?php echo htmlspecialchars($casa['titulo']); ?></a></b></h3>
                        <div><b><?php echo htmlspecialchars($casa['preco']); ?>€</b></div>
                    </div>

                    <div class="card-body1">
                        
                        <div class="asas">
                            <div class="truncate">
                                <?php echo htmlspecialchars($casa['descricao']); ?>
                            </div>
                            
                            <div class="truncate">Localização: <?php echo htmlspecialchars($casa['localizacao']);?></div> 
                            <div><?php echo htmlspecialchars($casa['tipologia']); ?> <?php echo htmlspecialchars($casa['quartos']); ?> <?php echo htmlspecialchars($casa['espaco']); ?></div>
                        </div>

                    </div>
                </div>
            </div>
            <?php }else{?>
                <div class='card1 opa'>
                    <div class="card-images1">
                        <img src="<?php echo "imgcasa/".$casa['imagens']; ?>"  alt="Imagem da casa">
                    </div>
                    <div class="card-text">
                        <div class="card-header1">
                            <h3 class="ddd" style="margin-right: auto;"><b><a href="casas.php?id=<?php echo $casa["id"];?>" ><?php echo htmlspecialchars($casa['titulo']); ?></a></b></h3>
                            <div><b><p class='vendido'>Vendido</p></b></div>
                        </div>
                        <div class="card-body1">
                        
                        <div class="asas">
                            <div class="truncate">
                                <?php echo htmlspecialchars($casa['descricao']); ?>
                            </div>
                            
                            <div class="truncate">Localização: <?php echo htmlspecialchars($casa['localizacao']);?></div> 
                            <div><?php echo htmlspecialchars($casa['tipologia']); ?> <?php echo htmlspecialchars($casa['quartos']); ?> <?php echo htmlspecialchars($casa['espaco']); ?></div>
                        </div>

                    </div>
                    </div>
                </div>
        <?php   }
        endforeach; ?>
    </div>
    
    
    
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="js/js.js"></script>
</html>