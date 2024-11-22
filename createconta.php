<?php
require_once("conexao.php");
require 'PHPMailer/src/Exception.php'; 

require 'PHPMailer/src/PHPMailer.php'; 

require 'PHPMailer/src/SMTP.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    $sql = "SELECT * FROM utilizadores WHERE email='$email'";
    $result = mysqli_query($link, $sql);
    $passe=password_hash($pass,PASSWORD_DEFAULT);
    if (mysqli_num_rows($result) == 0) {
        // Create a new user
        if(!isset($_POST["tel"])){
            $_POST["tel"]=null;
        }
        $sql = "INSERT INTO utilizadores (email, senha,nome,telefone,funcao_id) VALUE (?,?,?,?,?)";
        $stmt=mysqli_prepare($link,$sql);
        $stmt->bind_param("sssii",$email,$passe,$_POST["nome"], $_POST["tel"],$_POST["tipo"]);
        /*
        $mail = new PHPMailer();
        
        $mail->isSMTP();
        
        
        $mail->SMTPAuth =true;
        
        $mail->SMTPSecure='tls';
    
        $mail->Host = 'localhost'; //servidor de envio
    
        $mail->Port = 587; //porta
    
        $mail->IsHTML(true);
    
        $mail->CharSet='UTF-8'; // acentos
 
        $mail->Username='prismadeviragem.web@gmail.com'; //username
 
        $mail->Password="melhorcasa.123"; 
      
        $mail->SetFrom('prismadeviragem.web@gmail.com', 'Prisma de viragem'); 

        $mail->AddAddress($email); // e-mail destino 
 
        $mail->addBCC(''); 
        
        $mail->Subject = 'Prisma de viragem | Mensagem '; //Assunto da Mensagem 
        
        $mail->Body = "Quem Mandou foi o Afonso"; // Corpo da Mensagem 
        
        if(!$mail->Send()) { 
        
         $error = 'Mail error: '.$mail->ErrorInfo; 
        echo  $error; 

        
        } else { 
        
         $error = 'Mensagem enviada!'; 
        
         echo '<h1>'.$error.'</h1>'; 
         mysqli_query($link, $sql);
        
        } */
        $stmt->execute();
        header("Location:index.php");
    } else {
        echo "Email já existe!";
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
                 <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
                    <input type="email" name="email" class="form-control" placeholder="email*" required>
                    <input type="text" name="nome" class="form-control" placeholder="nome*" required>
                    <input type="tel" name="tel" class="form-control" placeholder="telefone" >
                     <input type="password" class="form-control" placeholder="password*" name="pass"  required>
                    <select name="tipo" class="form-select" required>
                        <option value="1">Cliente</option>
                        <option value="2">Vendedor</option>
                    </select>
                    <div style="font-size: 13px; display:flex; align-items:center; gap:5px; margin:20px;"><input type="checkbox" required id="">  Aceito os termos da Política de Privacidade</div>
                     <input type="submit" style="width:100%;" value="Criar">
                 </form>
             </div>
        </div>
    </center>
</body>
</html>