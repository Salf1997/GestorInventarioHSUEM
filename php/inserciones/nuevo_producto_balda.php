<?php
  require('../db.php');
 
  if(isset($_POST['idBalda_an'])) { 	
    $balda = $_POST["idBalda_an"];
  }
  if(isset($_POST['producto_an'])) { 
    $prod = $_POST["producto_an"];
  }
  if(isset($_POST['stock_an'])) { 
    $cant = $_POST["stock_an"];
  }

  $sql1 ="SELECT MAX(id_Producto_Balda) as 'contar' FROM `balda_has_producto`";
  $result1= mysqli_query($con,$sql1);
  $row = mysqli_fetch_assoc($result1);
  $count = $row["contar"];
  $count = $count +1;

  $sql2 = "INSERT INTO `balda_has_producto`(`id_Producto_Balda`,`Producto_id_Producto`, `Balda_idBalda`, `cantidad_Producto_Baldas`) VALUES ('$count','$prod','$balda','$cant')";

  /*$sql3 ="SELECT COUNT(idMovimiento_Localizacion) as 'contar' FROM `movimiento_localizacion`";
  $result2= mysqli_query($con,$sql3);
  $row2 = mysqli_fetch_assoc($result2);
  $count2 = $row2["contar"];
  $count2 = $count2 +1;
  
  $sql4 = "INSERT INTO `movimiento_localizacion`(`idMovimiento_Localizacion`, `localizacion_Inicial`, `localizacion_Final`, `Producto_id_Producto`, `fecha_mov_loc`) VALUES ($count2,'b_1','b_$balda',[value-4],[value-5])";
  */
  if(mysqli_query($con,$sql2)){
    echo '1';
  } else {
      echo "Descripcion: " . mysqli_error($con);
  }

  mysqli_close($con);
?>