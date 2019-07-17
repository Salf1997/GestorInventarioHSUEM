<?php
  require('../db.php');
 
  if(isset($_POST['idAula'])) { 	
    $idAula = $_POST["idAula"];
  }
  if(isset($_POST['idProd'])) { 
    $idprod = $_POST["idProd"];
  }
  if(isset($_POST['producto'])) { 
    $producto = $_POST["producto"];
  }
  if(isset($_POST['stock'])) { 
    $cant = $_POST["stock"];
  }

  if ($cant<=0){
    $sql1 = "DELETE FROM `producto_has_aula` WHERE `Producto_id_Producto`= '$idprod' AND `Aula_idAula` = '$idAula'";
    if(mysqli_query($con,$sql1)){
      return true;
    } else {
        echo "Descripcion: " . mysqli_error($con);
    }
  } else {
    $sql2 = "UPDATE `producto_has_aula` SET  `cantidad_Producto`= '$cant' WHERE `Producto_id_Producto`= '$idprod' AND `Aula_idAula` = '$idAula'";
    if(mysqli_query($con,$sql2)){
      echo "UPDATE `producto_has_aula` SET  `cantidad_Producto`= '$cant' WHERE `Producto_id_Producto`= '$idprod' AND `Aula_idAula` = '$idAula'";
    } else {
      echo "Descripcion: " . mysqli_error($con);
    }
  }
  mysqli_close($con);
?>