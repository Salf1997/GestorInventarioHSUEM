<?php
  require('../db.php');

  if(isset($_POST['nombre'])) { 	
    $nombre = $_POST["nombre"];
  }
  if(isset($_POST['stock_0109'])) { 
    $stock_19 = $_POST["stock_0109"];
  } else{
    $stock_19 = "0";
  }
  if(isset($_POST['stock'])) { 
    $stock = $_POST["stock"];
  } else{
    $stock = "0";
  }
  if(isset($_POST['stock_alerta'])) { 
    $stock_a = $_POST["stock_alerta"];
  } else{
    $stock_a = "0";
  }
  if(isset($_POST['stock_critico'])) { 
    $stock_c = $_POST["stock_critico"];
  } else{
    $stock_c = "0";
  }
  if(isset($_POST['tipo'])) { 
    $tipo = $_POST["tipo"];
  } else{
    $tipo="";
  }
  if(isset($_POST['descripcion'])) { 
    $desc = $_POST["descripcion"];
  }else{
    $desc="";
  }
  if(isset($_POST['idProv'])) { 
    $idProv = $_POST["idProv"];
  }else{
    $idProv="";
  }
  if(isset($_POST['precio'])) { 
    $precio = $_POST["precio"];
  }else{
    $precio="";
  }

  $sql1 ="SELECT MAX(id_Producto) as 'contar' FROM `producto`";
  $result1= mysqli_query($con,$sql1);
  $row = mysqli_fetch_assoc($result1);
  $count = $row["contar"];
  $count = $count +1;

  $exito=1;

  $sql2 = "INSERT INTO `producto`(`id_Producto`, `nombre_Producto`, `stock_0109`, `stock_Producto`, `stock_Minimo_Critico`, `stock_Alerta`, `tipo_producto`, `descripcion_Producto`, `Proveedor_idProveedor`, `precio`, `activo`) 
  VALUES ('$count','$nombre','$stock_19','$stock','$stock_c','$stock_a','$tipo','$desc','$idProv','$precio','1')";
  
  if(mysqli_query($con,$sql2)):
    echo $exito;
  else:
    $exito = 0;
    echo $sql2;
  endif;

  mysqli_close($con);


?>