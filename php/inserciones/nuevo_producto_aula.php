<?php
  require('../db.php');
 
  if(isset($_POST['aula'])) { 	
    $aula = $_POST["aula"];
  }
  if(isset($_POST['producto'])) { 
    $prod = $_POST["producto"];
  }
  if(isset($_POST['stock'])) { 
    $cant = $_POST["stock"];
  }

  $sql1 ="SELECT MAX(id_Producto_Aula) as 'contar' FROM `producto_has_aula`";
  $result1= mysqli_query($con,$sql1);
  $row = mysqli_fetch_assoc($result1);
  $count = $row["contar"];
  $count = $count +1;

  $sql2 = "INSERT INTO `producto_has_aula`(`id_Producto_Aula`,`Producto_id_Producto`, `Aula_idAula`, `cantidad_Producto`) VALUES ('$count','$prod','$aula','$cant')";

  if(mysqli_query($con,$sql2)){
    echo "1";
  } else {
    echo "Descripcion: " . mysqli_error($con);
  }

  mysqli_close($con);
?>