<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Prisma de Viragem</title>
    <link rel="icon" type="image/png"  href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
        include("nav.php");
    ?>
    <center>
        <div class="cardlogin" style="margin-top:40px;">
            <h5><img src="img/Logo.jpg">Prisma de Viragem</h5>
            <br><br>
            <div class="card-body">
                <form action="elogin.php" method="post">
                    <input type="email" class="form-control" required placeholder="email" name="email">
                    <input type="password" class="form-control" required placeholder="password" name="pass" id=""><br>
                    <input type="submit" style="width:100%" value="Entrar">
                    <br><br>
                    Não tem uma conta?<a href="createconta.php">Crie uma!!!</a>
                </form>
            </div>
        </div>
        </center>
</body>
</html>