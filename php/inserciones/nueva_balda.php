<?php
  require('../db.php');
  $fallo = 0;

  if(isset($_POST['idAlmacen'])) { 	
    $id = $_POST["idAlmacen"];
  }
  if(isset($_POST['nombre'])) { 	
    $nombre = $_POST["nombre"];
  }

  $sql = "SELECT MAX(idBalda) as 'contar' FROM `balda`  WHERE `nombre_Balda` LIKE '$nombre' AND `Almacen_idAlmacen`='$id'";
  $result= mysqli_query($con,$sql);
  $row_res= mysqli_fetch_assoc($result);
  $count_res = $row_res["contar"];

  if ($count_res==0){
    $sql1 ="SELECT MAX(idBalda) as 'contar' FROM `balda`";
    $result1= mysqli_query($con,$sql1);
    $row = mysqli_fetch_assoc($result1);
    $count = $row["contar"];
    $count = $count +1;
  
    $sql2 = "INSERT INTO `balda`(`idBalda`, `nombre_Balda`, `Almacen_idAlmacen`) VALUES ('$count', '$nombre','$id')";
    
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