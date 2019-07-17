<?php
  require('../db.php');
  $fallo = 0;
  if(isset($_POST['nombre'])) { 	
    $nombre = $_POST["nombre"];
  }
  if(isset($_POST['loc'])) { 
    $tipo = $_POST["loc"];
  } else{
    $tipo="";
  }

  $sql = "SELECT MAX(idAlmacen) as 'contar' FROM `almacen` WHERE `nombre_Almacen` LIKE '$nombre'";
  $result= mysqli_query($con,$sql);
  $row_res= mysqli_fetch_assoc($result);
  $count_res = $row_res["contar"];

  if ($count_res==0){
    $sql1 ="SELECT COUNT(idAlmacen) as 'contar' FROM `almacen`";
    $result1= mysqli_query($con,$sql1);
    $row = mysqli_fetch_assoc($result1);
    $count = $row["contar"];
    $count = $count +1;
  
    $sql2 = "INSERT INTO `almacen`(`idAlmacen`, `nombre_Almacen`, `localizacion_Almacen`) VALUES ('$count', '$nombre','$tipo')";
    
    if(!mysqli_query($con,$sql2)){
      echo "Error Description: ". mysqli_error($con);
    } else{
      echo $fallo;
    }  
  } else {
      $fallo = 1;
      echo $fallo;
  }
  mysqli_close($con);
?>