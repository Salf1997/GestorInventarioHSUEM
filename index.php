<?php
session_start();
if (!isset($_SESSION['idrol'])){
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestor de Inventario HSUEM</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
    <!-- Google fonts - Poppins-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.red.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="images/uemico.ico">
    <!-- Modernizr-->
    <script src="js/modernizr.custom.79639.js"></script>


  </head>
  <body>
     <!-- navbar-->
     <header class="header">
        <nav class="navbar navbar-expand-lg">
          <div class="container-fluid">  
            <!-- Navbar Header  --><a href="index.html" class="navbar-brand"><img src="images/logo_hsuem.png" alt="..."></a>
            <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
            <!-- Navbar Collapse -->
            <div id="navbarCollapse" class="collapse navbar-collapse">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a href="index.php" class="nav-link active">Home</a>
                </li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Informaci&oacuten</a>
                </li>
              </div>
            </div>
          </div>
        </nav>
      </header>
    
    <section class="padding-small">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="block">
              <div class="block-header">
                <h5>Inicio de Sesión</h5>
              </div>
              <div class="block-body"> 
               <hr>
                <form id="inicioSesion" action="" method="POST">
                  <div class="form-group">
                      <label for="rol" class="form-label">Tipo de Usuario</label>
                      <select class="bootstrap-select" name="rol" id="tipoUs">
                        <option value="2">Técnico</option>
                        <option value="1">Administrador</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="usuario" class="form-label">Número de Empleado</label>
                    <input required name="usuario" id="usuario" type="text" class="form-control" pattern="[0-9]{1,}" title="Número de empleado">
                  </div>
                  <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input required name="password" id="password" type="password" class="form-control">
                  </div>
                  <div id="error"></div>
                  <div class="form-group text-center">
                    <button type="submit" id='inicia' class="btn btn-primary"><i class="fa fa-sign-in"></i> Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">
              <div class="block-body"> 
                  <h1 class="lead">Facultad de Ciencias Biomédicas y de la Salud</h1>
              </div>
            </div>
            <div class="row">
              <div class="block-body"> 
                <p class="lead">¿Eres un empleado del Hospital Simulado y no tienes acceso?</p>
                <p class="text-muted">Para tener acceso, deberás ponerte en contacto con los responsables 
                de esta p&aacutegina web. Tras darte acceso, deberás cambiar tu contraseña para más seguridad.</p>
                <p class="text-muted">Si es tu primera vez en este portal, introduce tu n&uacutemero de empleado o expediente académico.</p>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer-->
    <footer class="main-footer">
      <div class="copyrights">
        <div class="container">
          <div class="row d-flex align-items-center">
            <div class="text col-md-6">
              <p>&copy; Sofía Alejandra López Fernández - Universidad Europea 2019</p>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- Javascript files-->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/popper.js/umd/popper.min.js"> </script>
    <script src="js/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie/jquery.cookie.js"> </script>
    <script src="https://kit.fontawesome.com/d62cab618e.js"></script>
    <script src="js/index.js"></script>
  </body>
</html>
<?php
} else {
  echo $_SESSION['rol'];
  if($_SESSION['idrol']=='2'){
    header("Location: inicio.php");
  } elseif ($_SESSION['idrol']=='1') {
    header("Location: admin.php");
  }
}
?>