<?php
  require('../db.php');
 
  if(isset($_POST['nombre'])) { 	
    $nombre = $_POST["nombre"];
  }
  if(isset($_POST['mail'])) { 
    $mail = $_POST["mail"];
  }
  if(isset($_POST['telefono'])) { 
    $telefono = $_POST["telefono"];
  }
  if(isset($_POST['cp'])) { 
    $cp = $_POST["cp"];
  }

  $exito =1;

  $sql1 ="SELECT MAX(idProveedor) as 'contar' FROM `proveedor`";
  $result1= mysqli_query($con,$sql1);
  $row = mysqli_fetch_assoc($result1);
  $count = $row["contar"];
  $count = $count +1;

  $sql2 = "INSERT INTO `proveedor`(`idProveedor`,`nombre_Proveedor`, `email_Proveedor`, `telefono_Proveedor`, `codigoP_Proveedor`, `actividad`) VALUES ('$count','$nombre','$mail','$telefono','$cp','1')";
  
  if(mysqli_query($con,$sql2)):
    echo $exito;
  else:
    $exito = 0;
    echo $exito;
  endif;

  mysqli_close($con);

?>
