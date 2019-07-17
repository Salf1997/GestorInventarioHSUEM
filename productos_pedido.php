<?php
  session_start();
  if (!isset($_SESSION['rol'])){
    header('Location: index.php');
} else {
    require('php/db.php');
    $pedido=$_GET['idPedido'];
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
      <!-- jQuery confirm -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
      <!--Boostrap Toggle-->
      <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
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
        </div>
    </nav>
    </header>
    <?php
      /*$comp = $_SESSION['Completado'];
      $valor="";
      if ($comp==1):
        $valor = "disabled";
      else:
        $valor="";
      endif;*/
    ?>
    <main>
    <section class="hero hero-page gray-bg padding-small">
        <div class="container">
          <div class="row d-flex">
            <div class="col-lg-9 order-2 order-lg-1">
              <h1 id="idPedido_" valor="<?php echo $pedido; ?>">
                  Productos - Pedido <?php echo $pedido; ?>
              </h1>
            </div>
            <div class="col-lg-3 text-right order-1 order-lg-2">
              <ul class="breadcrumb justify-content-lg-end">
                <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="pedidos.php">Pedidos</a></li>
                <li class="breadcrumb-item active">Pedido n&uacutemero <?php echo $pedido; ?></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <section>
      <div class="container">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-11">
            <table id="tabla_info"  class="table-responsive">
              <thead>
                <tr>
                  <th>Titulaci&oacuten</th>
                  <th>Curso</th>
                  <th>Fecha de creaci&oacuten</th>
                  <th>Fecha de entrega</th>
                </tr>
              </thead>
              <tbody id="info_pedido"></tbody>
            </table>
        </div>
      </div>
      <br>
      <div class="container">
            <div class="row">
              <div class="col-md-1"></div>
        <div class="col-md-4">
          <label class="form-label"><li class="fa fa-search"></li> Buscar:   </label>
          <input type="text" id="busqueda" title="Buscar proveedor" class="form-control"> 
        </div>
        <div class="col-md-3"></div>
          <div class="col-md-4">
              <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
                <button type="submit" id="nuevoProd" data-toggle="modal" data-target="#nuevo_prod" class="btn btn-template" <?php //echo $valor; ?>>A&ntildeadir nuevo producto al pedido<i class="fa fa-plus"></i></button>
              </div>
          </div>
        </div>
            <br>
      </div>

          <div class="container">
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-11">
                <table id="tabla"  class="table-responsive">
                  <thead>
                    <tr>
                      <th>Nombre Producto</th>
                      <th>Descripci&oacuten</th>
                      <th>Cantidad</th>
                      <th>Precio Unitario</th>
                      <th>Total</th>
                      <th>Modificar</th>
                    </tr>
                  </thead>
                  <tbody id="cuerpo_tabla"></tbody>
                </table>
            </div>
          </div>
          <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-2">
            <!--BOTON CSV-->
            <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
            <button type="submit" id="atras_boton" class="btn btn-template"><i class="fa fa-angle-double-left "></i> Volver atr&aacutes</button>
            </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2">
            <!--BOTON BORRAR TODO-->
            <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
            <button type="submit" id="borrarTodo_boton" class="btn btn-template"><i class="fa fa-trash"></i> Borrar pedido</button>
            </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2">
            <!--BOTON PEDIDO COMPLETADO-->
            <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
            <button type="submit" id="entregado_boton" class="btn btn-template" <?php //echo $valor; ?>><i class="fab fa-get-pocket"></i> Pedido Entregado</button>
            </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-2">
            <!--BOTON CSV-->
            <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
            <button type="submit" id="csv_boton" class="btn btn-template" ><i class="fa fa-file"></i> Exportar CSV</button>
            </div>
          </div>
          <div class="col-md-1"></div>
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
    <!--MODAL MODIFICAR PRODUCTO-->
    <div id="modal_modificar" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="ribbon-primary text-uppercase">Modificar cantidad de Producto</div>
            <div class="modal-body">
              <div class="align-items-center">
                <form id="form_modificar" method='post'>
                  <div class="details">
                    <div class="form-group">
                      <input type="text" name="identificador_mod" id="identificador_mod" required hidden>
                      Producto:<br>
                      <input type="text" name="producto_mod" class="form-control input-sm form-control-sm"  id="producto_mod" readonly><br>
                      Descripci&oacuten:<br>
                      <input type="text" name="descripcion_mod" class="form-control input-sm form-control-sm"  id="descripcion_mod" readonly><br>
                      Cantidad:<br>
                      <input type="text" name="stock_mod" id="stock_mod" class="form-control input-sm form-control-sm"  pattern="[0-9]+" required><br>
                      <input type="text" name="idPedido_mod" value="<?php echo $pedido; ?>" required hidden>
                    </div>
                    <input type="button" name="salir_modal" data-dismiss="modal" value="Cancelar">
                    <input type="button" name="del_boton" id="del_boton" value="Borrar producto">
                    <input type="button" name="mod_boton" id="mod_boton" value="Modificar">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>     
    <!--MODAL AÑADIR PRODUCTO-->
    <div id="nuevo_prod" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="ribbon-primary text-uppercase">A&ntildeadir Producto</div>
            <div class="modal-body"> 
              <div class="align-items-center">
                <form id="form_anadir"  METHOD="POST">
                  <div class="details">
                    <div class="form-group">
                      Producto:<br>
                      <select name="producto_an" id="select_form" form="form_anadir" class="boostrap-select" style="width: 300px">
                        <option selected disabled>Seleccione un producto</option>
                      
                      </select> <br>
                      Tipo:
                      <p id="descripcion"></p>
                      Stock actual:
                      <p id="cantidad"></p>
                      Cantidad:<br>
                      <input type="text" id="stock_an" name="stock_an" class="form-control input-sm form-control-sm" pattern="[0-9]+" value="" required pattern="[0-9]+">
                      <input type="text" name="idPedido_an" value="<?php echo $pedido ?>" required hidden>
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
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://kit.fontawesome.com/d62cab618e.js"></script>
    <script src="js/front.js"></script>
    <script src="js/tabla_productos_pedido.js"></script>
    <script src="js/usuario.js"></script>

  </body>
</html>
<?php 
}
?>