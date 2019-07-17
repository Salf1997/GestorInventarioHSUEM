<?php
  require('../db.php');
  
  if(isset($_POST['id_mod'])) { 	
    $id = $_POST["id_mod"];
  }
  if(isset($_POST['nombre_mod'])) { 	
    $nombre = $_POST["nombre_mod"];
  }
  if(isset($_POST['mail_mod'])) { 
    $mail = $_POST["mail_mod"];
  }
  if(isset($_POST['telefono_mod'])) { 
    $telefono = $_POST["telefono_mod"];
  }
  if(isset($_POST['cp_mod'])) { 
    $cp = $_POST["cp_mod"];
  }

  if(isset($_POST['actividad'])) { 
    $actividad = $_POST["actividad"];
  }

  $exito=1;

  $sql = "UPDATE `proveedor` SET `nombre_Proveedor`='$nombre',`email_Proveedor`='$mail',`telefono_Proveedor`='$telefono',`codigoP_Proveedor`='$cp', `actividad`='$actividad' WHERE `idProveedor`='$id'";
  
  if(mysqli_query($con,$sql)):
    echo $exito;
  else:
    $exito = 0;
    echo $exito;
  endif;

  mysqli_close($con);
?>
