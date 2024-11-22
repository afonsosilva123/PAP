<nav>
    <div class="navp">
    <a href="index.php" class="logo"><img src="img/Logo.jpg">Prisma de Viragem</a> 
    <button class="menu" onclick="navapa()"><i class="bi bi-three-dots"></i></button>
    </div>
    <ul class="ulrow" id="ulrow">
        <li class="nav-item">
            <a href="index.php">Home</a>
        </li>
        <?php if(isset($_SESSION["tipo"])&&$_SESSION["tipo"]==3){?>
          <li class="nav-item">
            <a href="admin.php">Admin</a>
        </li>
          <?php } ?>
          <li class="navfim"> <?php if(!isset($_SESSION["id"])){ ?><button onclick="window.location.href='iniciarsessao.php'">Iniciar Sessão</button><?php } else{ echo '<a onclick="navap()">'.$_SESSION["nome"].'</a>';}?> <ul style="display: none !important; " id="ap"><li><a href="logout.php">Terminar sessão</a></li></ul></li>
    </ul> 
    
</nav>
<script>
    i=1
    a=1
    function navap(){
        if(i%2==0)document.getElementById("ap").style.setProperty("display", "none", "important");
        else document.getElementById("ap").style.setProperty("display", "flex", "important");
        i++;
    }
    function navapa(){
        if(a%2==0){
            document.getElementById("ulrow").style.setProperty("display", "none", "important");
            document.querySelector('nav').style.paddingBottom=0+"px";
        }
        else{ 
            document.getElementById("ulrow").style.setProperty("display", "flex", "important");
            document.querySelector('nav').style.paddingBottom=10+"px";
        }

        a++;
    }
</script>