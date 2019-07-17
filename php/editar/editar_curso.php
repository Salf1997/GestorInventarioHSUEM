<?php
  require('../db.php');
  
  if(isset($_POST['titulacion_tipo_mod'])) { 	
    $tipo = $_POST["titulacion_tipo_mod"];
  }
  if(isset($_POST['nombre_tit_mod'])) { 	
    $nombre = $_POST["nombre_tit_mod"];
  }
  if(isset($_POST['num_cursos_mod'])) { 
    $cursos = $_POST["num_cursos_mod"];
  }
  if(isset($_POST['nombre_tit_mod_desp'])) { 
    $id = $_POST["nombre_tit_mod_desp"];
  }
  $exito=1;

  if(isset($_POST["borrar"])):
    $sql = "DELETE FROM `curso` WHERE idCurso=$id";   
  else:
    $sql = "UPDATE `curso` SET `nombreCurso`='$nombre',`numCurso`=$cursos,`tipo`=$tipo WHERE `idCurso`=$id";
  endif; 
  if(mysqli_query($con,$sql)):
    echo $exito;
  else:
    $exito = 0;
    echo $exito;
  endif;

  mysqli_close($con);
?>