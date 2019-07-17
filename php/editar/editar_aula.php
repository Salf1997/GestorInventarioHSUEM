<?php
  require('../db.php');

  if(isset($_POST['id_mod'])){
      $id = $_POST['id_mod'];
  }
  
  if(isset($_POST['nombre_mod'])) { 	
    $nombre = $_POST["nombre_mod"];
  }
  if(isset($_POST['tipo_mod'])) { 
    $tipo = $_POST["tipo_mod"];
  } else{
    $tipo="";
  }
  $sql = "UPDATE `aula` SET `nombre_Aula`='$nombre',`tipo_Aula`='$tipo' WHERE `idAula`='$id'";
  
  if(!mysqli_query($con,$sql)){
    echo("Error description: ". mysqli_error($con));
  } else{
    echo "1";
  }

  mysqli_close($con);

?>