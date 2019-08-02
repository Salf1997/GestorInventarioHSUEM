<?php
  require('../db.php');
  
  if(isset($_POST['id_mod'])) { 	
    $id = $_POST["id_mod"];
  }
  if(isset($_POST['referencia_mod'])) { 	
    $ref = $_POST["referencia_mod"];
  }
  if(isset($_POST['nombre_mod'])) { 	
    $nombre = $_POST["nombre_mod"];
  }
  if(isset($_POST['stock_mod'])) { 
    $stock = $_POST["stock_mod"];
  } else{
    $stock = "0";
  }
  if(isset($_POST['stock_alerta_mod'])) { 
    $stock_a = $_POST["stock_alerta_mod"];
  } else{
    $stock_a = "0";
  }
  if(isset($_POST['stock_critico_mod'])) { 
    $stock_c = $_POST["stock_critico_mod"];
  } else{
    $stock_c = "0";
  }
  if(isset($_POST['tipo_mod'])) { 
    $tipo = $_POST["tipo_mod"];
  } else{
    $tipo="";
  }
  if(isset($_POST['descripcion_mod'])) { 
    $desc = $_POST["descripcion_mod"];
  }else{
    $desc="";
  }
  
  $exito=1;


  $sql = "UPDATE `producto` SET `nombre_Producto`='$nombre',`stock_Producto`='$stock',`stock_Minimo_Critico`='$stock_c',`stock_Alerta`='$stock_a',`tipo_producto`='$tipo',`descripcion_Producto`='$desc' WHERE `id_Producto`='$id'";
  
  if(mysqli_query($con,$sql)):
    echo $exito;
  else:
    echo mysqli_error($con);
  endif;

  mysqli_close($con);

?>