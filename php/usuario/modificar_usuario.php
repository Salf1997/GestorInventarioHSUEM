<?php
  require('../db.php');

  function digitos($number) {
    return strlen($number);
  }  
 
  if(isset($_POST['empleado_mod'])) { 	
    $id = $_POST["empleado_mod"];
  }
  if(isset($_POST['nombre_mod'])) { 
    $nombre = $_POST["nombre_mod"];
  }
  if(isset($_POST['apellido_mod'])) { 
    $apellido = $_POST["apellido_mod"];
  }
  if(isset($_POST['email_mod'])) { 
    $email = $_POST["email_mod"];
  }
  if (isset($_POST['actividad'])){
    $act =$_POST['actividad']; 
  }
  if (isset($_POST['rol_mod'])){
    if($_POST['rol_mod']=='Administrador'){
        $rol='1';
    } else {
        $rol='2';
    }
  }

if(isset($_POST['restablecer_boton'])):

  $digit = digitos($id);

  if($digit>=6):
      $pass = $id;
  else:
      $pass = $id.$id;
  endif;
  
  $pass_enc = password_hash($pass, PASSWORD_BCRYPT);

  $sql = "UPDATE `usuario` SET `password_Usuario`='$pass_enc', `reset`='0' WHERE `idUsuario`='$id'";
  
  if (mysqli_query($con,$sql)){
    $result= mysqli_query($con,$sql);
    session_start();
      $_SESSION['reset']='1';
    echo 'true';
  } else {
      echo mysqli_error($con);
  }

else:
  $sql = "UPDATE `usuario` SET `nombre_Usuario` ='$nombre', `apellidos_Usuario`='$apellido', `email_Usuario`='$email' WHERE `idUsuario`= '$id'";
  if(mysqli_query($con,$sql)){
      echo "exito";
  } else {
      echo "Descripcion: " . mysqli_error($con);
  }
  
  $sql2 = "UPDATE `usuario_has_rol` SET `activo` ='$act' WHERE `Usuario_idUsuario`= '$id' AND `Rol_idRol`='$rol'";
  if(mysqli_query($con,$sql2)){
      echo "exito";
  } else {
      echo "Descripcion: " . mysqli_error($con);
  }
endif;

mysqli_close($con);
?>