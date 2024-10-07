<?php
  //Llamando a la cadena de conexión
  require_once("config/conexion.php");
  if(isset($_POST["enviar"]) and $_POST["enviar"]=="si"){
    require_once("models/Usuario.php");
    $usuario = new Usuario();
    $usuario->login();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>ENGIECERTI</title>
  <link rel="stylesheet" href="public/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="public/modules/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="public/modules/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="public/css/style.css">
  <link rel="stylesheet" href="public/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
    <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-body">
                <form action="#" method="post">
                    <div class="login-brand">
                        <img src="public/img/logo_principal.png" alt="logo" width="100" class="shadow-light rounded-circle">
                    </div>
                    <!-- Mensaje de error si los datos son incorrectos -->
                    <?php if(isset($_GET['m']) && $_GET['m'] == 1): ?>
                        <div class="alert alert-danger">
                            <strong>Error:</strong> Correo o contraseña incorrectos.
                        </div>
                    <?php endif; ?>
                    <!-- Mensaje de error si faltan campos -->
                    <?php if(isset($_GET['m']) && $_GET['m'] == 2): ?>
                        <div class="alert alert-warning">
                            <strong>Error:</strong> Por favor, rellene todos los campos.
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="email">Correo</label>
                        <input id="usu_correo" type="text" class="form-control" name="usu_correo" tabindex="1" required autofocus>
                        <div class="invalid-feedback">
                        Por favor, rellene su correo electrónico
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Contraseña</label>
                        <div class="float-right">
                            <a href="auth-forgot-password.html" class="text-small">
                            ¿Has olvidado tu contraseña?
                            </a>
                        </div>
                        </div>
                        <input id="usu_pass" type="password" class="form-control" name="usu_pass" tabindex="2" required>
                        <div class="invalid-feedback">
                        Por favor, rellene su contraseña
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="enviar" class="form-control" value="si"> 
                        <button type="submit" class="btn btn-lg btn-block" style="background-color: #33C4FF; color: white;" tabindex="4">
                            Ingresar
                        </button>
                    </div>
                </form>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              ¿No tienes una cuenta? <a href="registro.php">Crear Una</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="public/modules/jquery.min.js"></script>
  <script src="public/modules/popper.js"></script>
  <script src="public/modules/tooltip.js"></script>
  <script src="public/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="public/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="public/modules/moment.min.js"></script>
  <script src="public/js/stisla.js"></script>

  <script src="public/js/scripts.js"></script>
  <script src="public/js/custom.js"></script>
</body>
</html>