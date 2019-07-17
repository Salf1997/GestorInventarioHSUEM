<?php
  require('../db.php');
 
  if(isset($_POST['idBalda_mod'])) { 	
    $idBalda = $_POST["idBalda_mod"];
  }
  if(isset($_POST['identificador_mod'])) { 
    $idprod = $_POST["identificador_mod"];
  }
  if(isset($_POST['producto_mod'])) { 
    $producto = $_POST["producto_mod"];
  }
  if(isset($_POST['stock_mod'])) { 
    $cant = $_POST["stock_mod"];
  }

  $exito = 1;

  if ($cant<=0){
    $sql1 = "DELETE FROM `balda_has_producto` WHERE `Producto_id_Producto`= '$idprod' AND `Balda_idBalda` = '$idBalda'";
    if(mysqli_query($con,$sql1)){
      echo $exito;
    } else {
      $exito = 0;
      echo $exito;
    }
  } else {
    $sql2 = "UPDATE `balda_has_producto` SET  `cantidad_Producto_Baldas`= '$cant' WHERE `Producto_id_Producto`= '$idprod' AND `Balda_idBalda` = '$idBalda'";
    if(mysqli_query($con,$sql2)){
      echo $exito;
    } else {
      $exito = 0;
      echo $exito;
    }
  }
  mysqli_close($con);
?>