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
    <!-- jQuery confirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
        <!-- Navbar Header  --><a href="#" class="navbar-brand"><img src="images/logo_hsuem.png" alt="..."></a>
        <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
        <!-- Navbar Collapse -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <div class="right-col d-flex align-items-lg-center flex-column flex-lg-row">
                      <div class="user dropdown show"><a id="usuario" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user"></i> Administrador
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
                                      <button type='submit' href="#modificar_contra" class="btn btn-primary" id="modificar">Mod. contrase&ntildea</button>
                                      <button type='submit' class="btn btn-primary" id="logout">Cerrar Sesi&oacuten</button>
                                      <a hidden href="" class=""></a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              </a>
            </li>
        </div>
        </div>
    </nav>
    </header>

      <main>
        <section>
            <div class="container">
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
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <label class="form-label"><li class="fa fa-search"></li> Buscar:   </label>
                        <input type="text" id="busqueda" title="Buscar proveedor" class="form-control"> 
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-4">
                        <div class="CTAs d-flex justify-content-between flex-column flex-lg-row"><a href="" data-toggle="modal" data-target="#nuevo_usuario" class="btn btn-template">A&ntildeadir nuevo usuario <i class="fa fa-plus"></i></a></div>
                    </div>
                </div>
                <br>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                    <table id="tabla" class="table-responsive">
                        <thead>
                            <tr>
                                <th>Numero de Empleado</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Activo</th>
                                <th>¿Dar de baja?</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo_tabla"></tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                    </div>
                </div>
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
    <!--NUEVO USUARIO--> 
      <div id="nuevo_usuario" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="ribbon-primary text-uppercase">A&ntildeadir Usuario</div>
            <div class="modal-body"> 
              <div class="align-items-center">
                <form id="form_anadir"  METHOD="POST">
                  <div class="details">
                    <div class="form-group">
                      N&uacutemero de Empleado:<br>
                      <input type="text" id="empleado" name="empleado" value="" required class="form-control input-sm form-control-sm" pattern="\d{1,50}"><br>
                      Nombre:<br>
                      <input type="text" id="nombre" name="nombre" value="" required class="form-control input-sm form-control-sm"><br>
                      Apellidos:<br>
                      <input type="text" id="apellido" name="apellido" value="" required class="form-control input-sm form-control-sm"><br>
                      Email:<br>
                      <input type="email" id="email" name="email" value="" required class="form-control input-sm form-control-sm"><br>
                      Asignar roles:<br>
                      <input type="checkbox" value="1" id="admin_an" name="rol_ad" title="Control de los usuarios"> Administrador
                      <input type="checkbox" value="2" id="tec_an" name="rol_tc" title="Control del stock"> T&eacutecnico
                    </div>
                    <input type="button" name="salir_modal" data-dismiss="modal" value="Cancelar">
                    <input type="button" name="add_boton" id="add_boton" value="Añadir">      
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--MODIFICAR USUARIO--> 
      <div id="mod_usuario" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="ribbon-primary text-uppercase">Modificar Usuario</div>
            <div class="modal-body"> 
              <div class="align-items-center">
                <form id="form_modificar"  METHOD="POST">
                  <div class="details">
                    <div class="form-group">
                      N&uacutemero de Empleado:<br>
                      <input readonly type="text" id="empleado_mod" name="empleado_mod" pattern="[0-9]{1,}" value="" required class="form-control input-sm form-control-sm"><br>
                      Nombre:<br>
                      <input type="text" id="nombre_mod" name="nombre_mod" value="" required class="form-control input-sm form-control-sm"><br>
                      Apellidos:<br>
                      <input type="text" id="apellido_mod" name="apellido_mod" value="" required class="form-control input-sm form-control-sm"><br>
                      Email:<br>
                      <input type="email" id="email_mod" name="email_mod" value="" required class="form-control input-sm form-control-sm"><br>
                      Rol:<br>
                      <input readonly type="text" id="rol_mod" name="rol_mod" value="" required class="form-control input-sm form-control-sm"><br>
                      &iquestMantener <strong>rol</strong> activo?
                      <select name="actividad" id="actividad" form="form_modificar">
                        <option value="1">S&iacute</option>
                        <option value="0">No</option>
                      </select> <br>
                    </div>
                    <input type="button" id="restablecer_boton" value="Restablecer Contraseña">    
                    <input type="button" name="salir_modal" data-dismiss="modal" value="Cancelar">
                    <input type="button" name="mod_boton" id="mod_boton" value="Modificar">      
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
    <script src="js/jquery.cookie/jquery.cookie.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://kit.fontawesome.com/d62cab618e.js"></script>
    <script src="js/usuario.js"></script>
    <script src="js/admin.js"></script>

  </body>
</html>
<?php 
}
?>