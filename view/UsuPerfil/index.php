<?php
  //llamamos al archivo de conexion.php
  require_once("../../config/conexion.php");
  if(isset($_SESSION["usu_id"])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once("../html/MainHead.php"); ?>
  <title>EngieCerti::Perfil</title>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      
      <?php require_once("../html/MainHeader.php"); ?>
      <?php require_once("../html/MainMenu.php"); ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Mi Perfil</h1>
          </div>

          <div class="section-body">
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Capstone Project - Universidad Privada del Norte <div class="bullet"></div><a href="#"></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>

  <?php require_once("../html/MainJs.php"); ?>
</body>
</html>
<?php
  }else{
    //si no ha iniciado sesion se redireccionara a la ventana principal
    header("Location:".Conectar::ruta()."view/404/");
  }
?>