<?php
session_start();
if (!isset($_SESSION['rol'])){
    header('Location: index.php');
} else {
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
            <!-- Navbar Header  --><a href="inicio.php" class="navbar-brand"><img src="images/logo_hsuem.png" alt="..."></a>
            <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
            <!-- Navbar Collapse -->
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a href="inicio.php" class="nav-link active">INICIO</a>
                </li>
                <li class="nav-item"><a href="productos.php" class="nav-link">Productos</a>
                </li>
                <li class="nav-item"><a href="proveedores.php" class="nav-link">Proveedores</a>
                </li>
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
                <li class="nav-item"><a href="pedidos.php" class="nav-link">Pedidos</a>
                </li>
                </ul>
                <div class="right-col d-flex align-items-lg-center flex-column flex-lg-row">
                    <div class="user dropdown show"><a id="alertas" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-bell"></i>
                        <div id="alerta" class="cart-no"></div>
                        <div aria-labelledby="alertas" class="dropdown-menu">
                            <div id="warnings" class="dropdown-item user-info">                                    
                            </div>
                        </div>
                    </div>
                    <div class="user dropdown show"><a id="usuario" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user"></i>
                        <div aria-labelledby="usuario" class="dropdown-menu">
                            <div class="dropdown-item user-info">
                                <div class="d-flex align-items-center">
                                    <div class="details d-flex">
                                        <div class="text"><strong>N&uacutemero de empleado:</strong><span class="info"><?php echo $_SESSION['idUsuario'];?></span></div></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="details d-flex">
                                        <div class="text"><strong>Nombre:</strong><span class="info"><?php echo $_SESSION['nombre'].' '.$_SESSION['apellidos'];?></span></div></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="details d-flex">
                                        <div class="text"><strong>Email:</strong><span class="info"><?php echo $_SESSION['email'];?></span></div></div>
                                </div>
                                <br>
                                <!--Modificar password y logout-->
                                <div class="dropdown-item CTA d-flex">
                                    <button data-toggle="modal" data-target="#modificar_contra" class="btn btn-primary" id="modificar">Mod. contrase&ntildea</button>
                                    <button type='submit' class="btn btn-primary" id="logout">Cerrar Sesi&oacuten</button>
                                    <a hidden href="" class=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    </header>

      <main>
      <section class="hero hero-page gray-bg padding-small">
            <div class="container">
              <div class="row d-flex">
                <div class="col-lg-9 order-2 order-lg-1">
                  <h1>&iquestQu&eacute quieres ver?</h1>
                </div>
              </div>
            </div>
        </section>
        <section>

        <?php
            if(strcmp($_SESSION['reset'],'0')===0):
        ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 CTA d-flex align-items-center justify-content-center">
                <p><i class="fa fa-warning"></i> Por favor, cambie la contraseña. Su cuenta es vulnerable. <i class="fa fa-warning"></i></p>
            </div>
            <div class="col-md-1"></div>
        </div>
        <?php
            endif;
        ?>
    
        <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-3">
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center"><img src="images/box-open-solid.svg" alt="productos" class="img-fluid">
                        <div class="hover-overlay d-flex align-items-center justify-content-center">
                            <div class="CTA d-flex align-items-center justify-content-center"><a href="productos.php" class="visit-product active"><i class="fas fa-search"></i>Visitar</a></div>
                        </div>
                        </div>
                        <div class="title"><a href="productos.php">
                            <h3 class="h6 text-uppercase no-margin-bottom">Productos</h3></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-3">
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center"><img src="images/store-alt-solid.svg" alt="proveedores" class="img-fluid">
                        <div class="hover-overlay d-flex align-items-center justify-content-center">
                            <div class="CTA d-flex align-items-center justify-content-center"><a href="proveedores.php" class="visit-product active"><i class="fas fa-search"></i>Visitar</a></div>
                        </div>
                        </div>
                        <div class="title"><a href="proveedores.php">
                            <h3 class="h6 text-uppercase no-margin-bottom">Proveedores</h3></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center"><img src="images/cubes-solid.svg" alt="movimiento localizacion" class="img-fluid">
                        <div class="hover-overlay d-flex align-items-center justify-content-center">
                            <div class="CTA d-flex align-items-center justify-content-center"><a href="mov_cantidad.php" class="visit-product active"><i class="fas fa-search"></i>Visitar</a></div>
                        </div>
                        </div>
                        <div class="title"><a href="mov_cantidad.php">
                            <h3 class="h6 text-uppercase no-margin-bottom">Movimientos de Productos</h3></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center"><img src="images/order.svg" alt="product" class="img-fluid">
                        <div class="hover-overlay d-flex align-items-center justify-content-center">
                            <div class="CTA d-flex align-items-center justify-content-center"><a href="pedidos.php" class="visit-product active"><i class="fas fa-search"></i>Visitar</a></div>
                        </div>
                        </div>
                        <div class="title"><a href="pedidos.php">
                            <h3 class="h6 text-uppercase no-margin-bottom">Pedidos</h3></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center"><img src="images/dolly-solid.svg" alt="movimiento cantidad" class="img-fluid">
                        <div class="hover-overlay d-flex align-items-center justify-content-center">
                            <div class="CTA d-flex align-items-center justify-content-center"><a href="mov_loc.php" class="visit-product active"><i class="fas fa-search"></i>Visitar</a></div>
                        </div>
                        </div>
                        <div class="title"><a href="mov_loc.php">
                            <h3 class="h6 text-uppercase no-margin-bottom">Movimientos entre Almacenes</h3></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-3">
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center"><img src="images/chalkboard-teacher-solid.svg" alt="salas" class="img-fluid">
                        <div class="hover-overlay d-flex align-items-center justify-content-center">
                            <div class="CTA d-flex align-items-center justify-content-center"><a href="aulas.php" class="visit-product active"><i class="fas fa-search"></i>Visitar</a></div>
                        </div>
                        </div>
                        <div class="title"><a href="aulas.php">
                            <h3 class="h6 text-uppercase no-margin-bottom">Salas</h3></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-3">
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center"><img src="images/warehouse-solid.svg" alt="product" class="img-fluid">
                        <div class="hover-overlay d-flex align-items-center justify-content-center">
                            <div class="CTA d-flex align-items-center justify-content-center"><a href="almacenes.php" class="visit-product active"><i class="fas fa-search"></i>Visitar</a></div>
                        </div>
                        </div>
                        <div class="title"><a href="almacenes.php">
                            <h3 class="h6 text-uppercase no-margin-bottom">Almacenes</h3></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <!--<div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-3">
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center"><img src="images/order.svg" alt="product" class="img-fluid">
                        <div class="hover-overlay d-flex align-items-center justify-content-center">
                            <div class="CTA d-flex align-items-center justify-content-center"><a href="pedidos.php" class="visit-product active"><i class="fas fa-search"></i>Visitar</a></div>
                        </div>
                        </div>
                        <div class="title"><a href="pedidos.php">
                            <h3 class="h6 text-uppercase no-margin-bottom">Pedidos</h3></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-3">
                <div class="item">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center"><img src="images/report.png" alt="product" class="img-fluid">
                        <div class="hover-overlay d-flex align-items-center justify-content-center">
                            <div class="CTA d-flex align-items-center justify-content-center"><a href="informes.php" class="visit-product active"><i class="fas fa-search"></i>Visitar</a></div>
                        </div>
                        </div>
                        <div class="title"><a href="informes.php">
                            <h3 class="h6 text-uppercase no-margin-bottom">Informes</h3></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div> -->
        </div>
        </section>
      </main>    
      <div id="scrollTop"><i class="fa fa-long-arrow-up"></i></div>


  <!--MODIFICAR CONTRASEÑA-->    
    <div id="modificar_contra" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="ribbon-primary text-uppercase">Modificar Contrase&ntildea</div>
          <div class="modal-body">
            <div class="align-items-center">
              <form id="form_modificar_contra" method='post'>
                <div class="details">
                  <div class="form-group">
                    <input type="text" name="identificador" id="identificador" hidden value="<?php echo $_SESSION['idUsuario'];?>">
                    Nueva Contrase&ntildea:<br>
                    <input type="text" id="nueva" name="nueva" required class="form-control input-sm form-control-sm"><br>
                    Repertir Contrase&ntildea:
                    <input type="text" id="nueva_comp" name="nueva_comp" required class="form-control input-sm form-control-sm"><br>
                    <div id="error"></div>
                    <br>
                    <input type="button" name="salir_modal" data-dismiss="modal" value="Cancelar">
                    <input type="reset" name="reset_boton" value="Borrar">
                    <input type="button" name="boton_mod_contra" id="boton_mod_contra" value="Modificar">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div> 

      <!--FOOTER-->
      <footer class="main-footer">
      <div class="copyrights">
          <div class="container">
          <div class="row d-flex align-items-center">
              <div class="text col-md-6">
                  <p>&copy; Sofía Alejandra López Fernández - Universidad Europea 2019</p>
              </div>
              <div class="col-md-4"></div>
              <div class="text col-md-2 clearfix">
                  <p><a href="contact.php">Informaci&oacuten</a></p>
              </div>
          </div>
          </div>
      </div>
      </footer>
    <!-- Javascript files-->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/popper.js/umd/popper.min.js"> </script>
    <script src="js/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/d62cab618e.js"></script>
    <script src="js/front.js"></script>
    <script src="js/usuario.js"></script>
  </body>
</html>
<?php 
}
?>