<?php
require_once("conexao.php");
if(isset($_SESSION["tipo"])&&$_SESSION["tipo"]==3||isset($_SESSION["tipo"])&&$_SESSION["tipo"]==2){
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(!empty($_POST["tipo"])&&!empty($_POST["loc"])){
            $sql="INSERT INTO casas (descricao,tipologia,quartos,localizacao,preco,titulo,rua,espaco,proprietario)  VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt=mysqli_prepare($link,$sql);
            if(empty($_POST["quartos"])){
                $quar=null;
            }
            else{
                $quar="T".$_POST["quartos"];
            }
            
            $stmt->bind_param("sisiisssi",$_POST["descricao"],$_POST["tipo"],$quar,$_POST["loc"],$_POST["preco"],$_POST["titulo"],$_POST["rua"],$_POST["espaco"],$_SESSION["id"]);
            //mandar imagens
            if (isset($_FILES["arquivos"])&&isset($_POST["principal"])) {
                echo $_POST["principal"];
                $stmt->execute();
                $casa = mysqli_insert_id($link);
                $diretorio = 'imgcasa/';
                if (!is_dir($diretorio)) {
                    mkdir($diretorio, 0777, true);
                }
                $stmt->close();
                $marq=0;
                foreach ($_FILES["arquivos"]["name"] as $key => $nome_arquivo) {
                    $uploadfile = $diretorio . basename($_FILES["arquivos"]["name"][$key]);
                    $novoNome = 'casa_'.$casa.'_'.basename($_FILES["arquivos"]["name"][$key]);
                    if (move_uploaded_file($_FILES["arquivos"]["tmp_name"][$key], $diretorio . $novoNome)) {
                        echo $nome_arquivo;
                        $importancia = 0;
                        if($_FILES["arquivos"]["name"][$key]==$_POST["principal"]&&$importancia==0){
                            $importancia = 1;
                        }
                        $sql = "INSERT INTO imgcasa (source, importancia, casa) VALUES (?, ?, ?)";
                        $stmt = $link->prepare($sql);
                        $stmt->bind_param("sii", $novoNome, $importancia, $casa);
                        $stmt->execute();
                        if ($stmt->affected_rows > 0) {
                            $marq=1;
                        } else {
                            echo "Erro ao salvar o arquivo $nome_arquivo: " . $link->error;
                        }
                    } else {
                        echo "Erro ao upload do arquivo $nome_arquivo!";
                    }
                }
                if ($marq==1){
                    header("Location:index.php");
                }

            }
            else{
                echo  "Erro ao enviar imagens";

            }
        }
        else{
            echo  "Erro ao enviar dados";

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar casa</title><link rel="icon" type="image/png"  href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
        include("nav.php");
    ?>
    <div class="container">
        <div class="card">
            <form action="<?php echo $_SERVER["PHP_SELF"]?>" id="formulario" method="post" enctype="multipart/form-data">
                <label>Título</label>
                <input type="text" class="form-control" name="titulo" required>
                <select name="tipo" class="form-select" id="" required>
                    <option value="0">Escolha o tipo de casa</option>
                    <?php
                        $sql="SELECT * FROM tipologia";
                        $result=mysqli_query($link,$sql);
                        while($row=mysqli_fetch_assoc($result)){
                            echo "<option value='".$row["id"]."'>".$row["nometipo"]."</option>";
                        }
                    ?>
                </select>
                <label>Preço</label>
                <input type="number" class="form-control" name="preco" required>
                <label>Espaço</label>
                <input type="text" class="form-control" name="espaco" id="" required>
                <label>Quartos</label>
                <input type="number" class="form-control" name="quartos">
                <label>Descrição</label>
                <textarea class="descricao form-control" name="descricao" required></textarea>
                <label>Localização</label>
                <select id="distrito" class="form-select">
                    <option value="0">Escolha o Distrito</option>
                    <?php
                        $sql="SELECT DISTINCT Designação_DT as nome,Distrito_DT as id FROM populacaoresidentefreguesia order by nome ";
                        $result=mysqli_query($link,$sql);
                        while($row=mysqli_fetch_assoc($result)){
                            echo "<option value='".$row["id"]."'>".$row["nome"]."</option>";
                        }
                    ?>
                </select>
                <select class="form-select" id="concelho">
                    <option value="0">Escolha o Concelho</option>
                </select>
                <select class="form-select" id="fregue" name="loc">
                    <option value="0">Escolha a Freguesia</option>
                </select>
                <input class="form-control" type="text" name="rua" placeholder="Morada" required>
                
                <label>Imagens</label>
                <div class="dropzone">
                    <input type="file" name="arquivos[]" id="arquivos" multiple required>
                    <p>Drag and drop files here or click to select</p>
                </div>
                <div id="lista-arquivos"></div>
                <input type="hidden" name="principal" id="principal" value="">
                <input type="submit">
                <a href="index.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>
<script src="js/js.js"></script>
<script>

const dropzone = document.querySelector('.dropzone');
const input = document.querySelector('#arquivos');
const listaArquivos = document.getElementById('lista-arquivos');

let arquivos = [];
let principal = null;

dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('dragover');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('dragover');
});

dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    const files = e.dataTransfer.files;
    arquivos = [...arquivos, ...files];
    updateFileList(arquivos);
});

input.addEventListener('change', () => {
    const files = input.files;
    arquivos = [...arquivos, ...files];
    updateFileList(arquivos);
});

function updateFileList(files) {
    listaArquivos.innerHTML = '';
    files.forEach((file, index) => {
        const nomeArquivo = document.createElement('span');
        nomeArquivo.textContent = file.name;
        const botaoRemover = document.createElement('button');
        botaoRemover.textContent = 'Remover';
        botaoRemover.addEventListener('click', () => {
            arquivos.splice(index, 1);
            updateFileList(arquivos);
        });
        const botaoPrincipal = document.createElement('button');
        botaoPrincipal.textContent = 'Principal';
        botaoPrincipal.addEventListener('click', () => {
            principal = index;
            document.getElementById("principal").value=file.name;
            updateFileList(arquivos);
        });
        const botaoVisualizar = document.createElement('button');
        botaoVisualizar.textContent = 'Visualizar';
        botaoVisualizar.addEventListener('click', () => {
            visualizarImagem(file);
        });
        const divArquivo = document.createElement('div');
        divArquivo.appendChild(nomeArquivo);
        divArquivo.appendChild(botaoRemover);
        divArquivo.appendChild(botaoPrincipal);
        divArquivo.appendChild(botaoVisualizar);
        if (index === principal) {
            divArquivo.style.color = 'blue';
            botaoPrincipal.style.display = 'none';
        }
        listaArquivos.appendChild(divArquivo);
    });
    const dt = new DataTransfer();
    files.forEach(file => {
        dt.items.add(file);
    });
    input.files = dt.files;
}


function visualizarImagem(file) {
    const imagemContainer = document.createElement('div');
    imagemContainer.style.position = 'fixed';
    imagemContainer.style.top = '50%';
    imagemContainer.style.left = '50%';
    imagemContainer.style.transform = 'translate(-50%, -50%)';
    imagemContainer.style.background = 'rgba(0, 0, 0, 0.5)';
    imagemContainer.style.padding = '20px';
    imagemContainer.style.borderRadius = '10px';
    imagemContainer.style.boxShadow = '0 0 10px rgba(0, 0, 0, 0.5)';
    imagemContainer.style.zIndex = '1000';

    const imagem = document.createElement('img');
    imagem.src = URL.createObjectURL(file);
    imagem.style.maxWidth = '90%';
    imagem.style.maxHeight = '90%';
    imagem.style.objectFit = 'contain';

    const botaoFechar = document.createElement('button');
    botaoFechar.textContent = 'X';
    botaoFechar.style.position = 'absolute';
    botaoFechar.style.top = '10px';
    botaoFechar.style.right = '10px';
    botaoFechar.style.cursor = 'pointer';
    botaoFechar.addEventListener('click', () => {
        imagemContainer.remove();
    });

    imagemContainer.appendChild(imagem);
    imagemContainer.appendChild(botaoFechar);
    document.body.appendChild(imagemContainer);
}

// Quando o formulário é enviado
document.getElementById('formulario').addEventListener('submit', (e) => {
  const arquivo = document.getElementById('arquivos').files[0];
  if (arquivo) {
    console.log('Arquivo selecionado:', arquivo);
  } else {
    console.log('Nenhum arquivo selecionado');
  }
  const formData = new FormData();
  formData.append('arquivos', arquivo);
  fetch(window.location.href, {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));
});
dropzone.addEventListener('click', () => {
    input.click();
});
</script>
<?php 
}else{
    die("não tem acesso a esta página");
}
?>