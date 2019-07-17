<?php
session_start();
?>
<!DOCTYPE html>
<html lang="esp">
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
    <!-- TOGGLE BOOSTRAP -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- jQuery confirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="images/uemico.ico">
    <!-- Modernizr-->
    <script src="js/modernizr.custom.79639.js"></script>
  </head>
  <body>

  <?php
    if(!isset($_SESSION['rol'])):
      $navbar= '<!-- navbar-->
      <header class="header">
         <nav class="navbar navbar-expand-lg">
           <div class="container-fluid">  
             <!-- Navbar Header  --><a href="index.php" class="navbar-brand"><img src="images/logo_hsuem.png" alt="..."></a>
             <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
             <!-- Navbar Collapse -->
             <div id="navbarCollapse" class="collapse navbar-collapse">
               <ul class="navbar-nav mx-auto">
                 <li class="nav-item"><a href="index.php" class="nav-link active">Home</a>
                 </li>
              </ul>
               </div>
             </div>
           </div>
         </nav>
       </header>';
  elseif($_SESSION['rol']=='TÃ©cnico'):
    $navbar='<p id="idUsuario_1" valor="<?php echo $_SESSION["idUsuario"];?>"></p>
    <!-- navbar-->
    <header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">  
        <!-- Navbar Header  --><a href="inicio.php" class="navbar-brand"><img src="images/logo_hsuem.png" alt="..."></a>
        <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
        <!-- Navbar Collapse -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item"><a href="inicio.php" class="nav-link active">INICIO</a></li>
              <li class="nav-item"><a href="productos.php" class="nav-link">Productos</a></li>
              <li class="nav-item"><a href="proveedores.php" class="nav-link">Proveedores</a></li>
              <li class="nav-item dropdown"><a id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">Movimientos<i class="fa fa-angle-down"></i></a>
                  <ul aria-labelledby="navbarDropdownMenuLink" class="dropdown-menu">
                      <li><a href="mov_cantidad.php" class="dropdown-item">Cantidad</a></li>
                      <li><a href="mov_loc.php" class="dropdown-item">Localizaci&oacuten</a></li>
                  </ul>
              </li>
              <li class="nav-item dropdown"><a id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">Almacenamiento<i class="fa fa-angle-down"></i></a>
                  <ul aria-labelledby="navbarDropdownMenuLink" class="dropdown-menu">
                      <li><a href="aulas.php" class="dropdown-item">Salas</a></li>
                      <li><a href="almacenes.php" class="dropdown-item">Almacenes</a></li>
                  </ul>
              </li>
              <!--<li class="nav-item"><a href="informes.php" class="nav-link">Informes</a>
            </li>-->
              <li class="nav-item"><a href="pedidos.php" class="nav-link">Pedidos</a></li>
            </ul>
            <div class="right-col d-flex align-items-lg-center flex-column flex-lg-row">
            <div class="user dropdown show"><a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-bell"></i>
                        <div id="alerta" class="cart-no"></div>
                        <div aria-labelledby="usuario" class="dropdown-menu">
                            <div id="warnings" class="dropdown-item user-info">                                    
                            </div>
                        </div>
                    </div>    
            <div class="user dropdown show"><a id="usuario" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user"></i>
                    <div aria-labelledby="usuario" class="dropdown-menu">
                        <div class="dropdown-item user-info">
                            <div class="d-flex align-items-center">
                                <div class="details d-flex">
                                    <div class="text"><strong>N&uacutemero de empleado:</strong><span class="info">'.$_SESSION["idUsuario"].'</span></div></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="details d-flex">
                                    <div class="text"><strong>Nombre:</strong><span class="info">'.$_SESSION["nombre"]." ".$_SESSION["apellidos"].'</span></div></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="details d-flex">
                                    <div class="text"><strong>Email:</strong><span class="info">'.$_SESSION["email"].'</span></div></div>
                            </div>
                            <br>
                            <!--Modificar password y logout-->
                            <div class="dropdown-item CTA d-flex">
                                <button data-toggle="modal" data-target="#modificar_contra" class="btn btn-primary" id="modificar">Mod. contrase&ntildea</button>
                                <button type="submit" class="btn btn-primary" id="logout">Cerrar Sesi&oacuten</button>
                                <a hidden href="" class=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        </div>
    </nav>
    </header>';
  else:
    $navbar='<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">  
        <!-- Navbar Header  --><a href="#" class="navbar-brand"><img src="images/logo_hsuem.png" alt="..."></a>
        <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
        <!-- Navbar Collapse -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
            <li class="nav-item">
            
            <div class="right-col d-flex align-items-lg-center flex-column flex-lg-row">
                    <div class="user dropdown show"><a id="usuario" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user"></i> Administrador</a>
                        <div aria-labelledby="usuario" class="dropdown-menu">
                            <div class="dropdown-item user-info">
                                <div class="d-flex align-items-center">
                                    <div class="details d-flex">
                                        <div class="text"><strong>N&uacutemero de empleado:</strong><span class="info">'.$_SESSION["idUsuario"].'</span></div></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="details d-flex">
                                        <div class="text"><strong>Nombre:</strong><span class="info">'.$_SESSION["nombre"].' '.$_SESSION["apellidos"].'</span></div></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="details d-flex">
                                        <div class="text"><strong>Email:</strong><span class="info">'.$_SESSION["email"].'</span></div></div>
                                </div>
                                <br>
                                <!--Modificar password y logout-->
                                <div class="dropdown-item CTA d-flex">
                                    <button type="submit" href="#modificar_contra" class="btn btn-primary" id="modificar">Mod. contrase&ntildea</button>
                                    <button type="submit" class="btn btn-primary" id="logout">Cerrar Sesi&oacuten</button>
                                    <a hidden href="" class=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </li>
        </div>
        </div>
    </nav>
    </header>';
  endif;
      echo $navbar;
    ?>
    <main class="contact-page">
    <section class="hero hero-page gray-bg padding-small">
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-9 order-2 order-lg-1">
            <h1>Informaci&oacuten</h1>
          </div>
        </div>
      </div>
    </section>
      <section>
      <div class="container">
          <header>
            <p class="lead">
              Bienvend@ a la página de información del Gestor de Inventario HSUEM.
            </p>
          </header>
          <div class="row about-item">
            <div class="col-lg-8 col-sm-9">
              <p class="text-muted">Esta p&aacutegina ha sido creada como Proyecto de Fin de Grado de la alumna Sofía Alejandra López Fernández, en colaboración con el Hospital Simulado de la Universidad Europea de Madrid.</p>
            </div>
            <div class="col-lg-4 col-sm-3 d-none d-sm-flex align-items-center">
              <div class="about-icon ml-lg-0"><i class="fa fa-laptop-code"></i></div>
            </div>   
          </div>
          <div class="row about-item">
            <div class="col-lg-4 col-sm-3 d-none d-sm-flex align-items-center">
            <div class="image"><img src="images/hsimulado.jpg" alt="hospital simulado" class="img-fluid rounded-circle"></div>
            </div>
            <div class="col-lg-8 col-sm-9">
              <h2>El Hospital Simulado</h2>
              <p class="text-muted">La Universidad Europea de Madrid, como parte del apoyo en la enseñanza a sus alumnos, inauguró en 2016 el Hospital Simulado en sus instalaciones del Campus de Villaviciosa de Odón. Este hospital se utiliza como centro formativo para los futuros profesionales de la facultad de biomédicas y salud. Tan solo esta facultad recoge a 6000 alumnos de los cerca de 13000 que estudian en esta universidad.<p>
              <p class="text-muted">En el Hospital Simulado se realizan una gran variedad de prácticas orientadas a la formación de los alumnos de psicología, enfermería, medicina, etc. 
                Estas prácticas se realizan a modo de consultas con actores y materiales reales. 
                De ahí, la necesidad de poder utilizar un software hecho a su medida.
              </p>
            </div>
          </div>
          <div class="row about-item">
            <div class="col-lg-8 col-sm-9">
              <h2>Enlaces de inter&eacutes</h2>
              <p class="text-muted">Web de la Universidad Europea: <a href="https://universidadeuropea.es"><i class="fas fa-university"></i> Pincha aquí</a></p>
              <p class="text-muted">Web de la Facultad de Ciencias Biom&eacutedicas y Salud: <a href="https://biomedicasysalud.universidadeuropea.es"><i class="far fa-hospital"></i> Pincha aquí</a></p>
              <p class="text-muted">Gestor de ocupaci&oacuten del Hospital Simulado: <a href="https://esp.uem.es/Ocupacionhs"><i class="fas fa-chalkboard-teacher"></i> Pincha aquí</a></p>

              <p class="text-muted">Blackboard: <a href="https://uem.blackboard.com"><i class="fas fa-chalkboard"></i> Pincha aquí</a></p>


            </div>
            <div class="col-lg-4 col-sm-3 d-none d-sm-flex align-items-center">
            <div class="image"><img src="images/hsimulado2.jpg" alt="hospital simulado" class="img-fluid rounded-circle"></div>
            </div>   
          </div>
          <div class="row about-item">
            <div class="col-lg-4 col-sm-3 d-none d-sm-flex align-items-center">
              <div class="image"><img src="images/author.jpg" alt="" class="img-fluid rounded-circle"></div>
            </div>
            <div class="col-lg-8 col-sm-9">
              <h2>Sof&iacutea Alejandra L&oacutepez Fern&aacutendez</h2>

              <a href="https://www.linkedin.com/in/slopfer/" class="external linkedin"><i class="fab fa-linkedin"></i></a>
              <a href="https://www.linkedin.com/in/slopfer/">www.linkedin.com/in/slopfer</a>
              <p class="text-muted">Sof&iacutea L&oacutepez es alumna del &uacuteltimo curso del Grado en Ingenier&iacutea Inform&aacutetica de la Universidad Europea de Madrid.</p>
              <p class="text-muted">Como parte de su Trabajo de Fin de Carrera, se ha puesto en contacto con los responsables del Hospital Simulado de esta Universidad, y a través de su tutor, <strong>Borja Rodr&iacutegez Vila</strong>, ha podido llevar a cabo dicho proyecto aportando una soluci&oacuten fiable para su uso inmediato a trav&eacutes de esta p&aacutegina.<p>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php
    if(isset($_SESSION['rol'])):
      $modal = '<!--MODIFICAR CONTRASEÑA--> <div id="modificar_contra" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="ribbon-primary text-uppercase">Modificar Contrase&ntildea</div>
        <div class="modal-body">
        <div class="align-items-center">
        <form id="form_modificar_contra">
        <div class="details">
        <div class="form-group"><input type="text" name="identificador" id="identificador" hidden value="'.$_SESSION["idUsuario"].'">
        Nueva Contrase&ntildea:<br>
        <input type="text" id="nueva" name="nueva" required class="form-control input-sm form-control-sm"><br>
        Repertir Contrase&ntildea:
        <input type="text" id="nueva_comp" name="nueva_comp" required class="form-control input-sm form-control-sm"><br>
        <div id="error"></div>
        <br>
        <input type="button" name="salir_modal" data-dismiss="modal" value="Cancelar">
        <input type="reset" name="reset_boton" value="Borrar">
        <input type="button" name="boton_mod_contra" id="boton_mod_contra" value="Modificar">
        </div></div></form></div></div></div></div></div>';

         
    
                    
    else:
      $modal ="";
    endif;
    echo $modal;
    ?>
  <!--FOOTER-->
  <footer class="main-footer">
  <div class="copyrights">
      <div class="container">
      <div class="row d-flex align-items-center">
          <div class="text col-md-6">
              <p>&copy; Sofía Alejandra López Fernández - Universidad Europea 2019</p>
          </div>
          <div class="col-md-6"></div>
      </div>
      </div>
  </div>
  </footer>
<!-- Javascript files-->
<script src="js/jquery/jquery.min.js"></script>
<script src="js/popper.js/umd/popper.min.js"> </script>
<script src="js/bootstrap/js/bootstrap.min.js"></script>
<script src="js/jquery.cookie/jquery.cookie.js"> </script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://kit.fontawesome.com/d62cab618e.js"></script>
<script src="js/front.js"></script>
<script src="js/tabla_pedidos.js"></script>
<script src="js/usuario.js"></script>
</body>
</html>
