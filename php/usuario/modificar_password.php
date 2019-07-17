<?php
  require('../db.php');
  
  if(isset($_POST['identificador'])) { 	
    $id = $_POST["identificador"];
  }
  if(isset($_POST['nueva'])) { 	
    $pass = $_POST["nueva"];
  }
  
  $pass_enc = password_hash($pass, PASSWORD_BCRYPT);

  $sql = "UPDATE `usuario` SET `password_Usuario`='$pass_enc', `reset`='1' WHERE `idUsuario`='$id'";
  
  if (mysqli_query($con,$sql)){
    $result= mysqli_query($con,$sql);
    session_start();
    $_SESSION['reset']='1';
    echo 'true';
  } else {
      echo mysqli_error($con);
  }
  mysqli_close($con);
?>
