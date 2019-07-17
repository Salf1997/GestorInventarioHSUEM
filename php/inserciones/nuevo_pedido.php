<?php
  require('../db.php');

  if(isset($_POST['fecha'])) { 	
    $creacion = $_POST["fecha"];
  }
  if(isset($_POST['Usuario'])) { 
    $id = $_POST["Usuario"];
  }

  if(isset($_POST['titulacion'])){
    $titulacion = stripcslashes($_POST['titulacion']);
  } else {
      $titulacion="";
  }

  if(isset($_POST['titulacion_curso'])){
      $curso = stripcslashes($_POST['titulacion_curso']);
  } else {
      $curso="";
  }

  $sql1 ="SELECT MAX(idPedido) as 'contar' FROM `pedido`";
  $result1= mysqli_query($con,$sql1);
  $row = mysqli_fetch_assoc($result1);
  $count = $row["contar"];
  $count = $count +1;

  $sql2 = "INSERT INTO `pedido`(`idPedido`, `Curso_idCurso`, `Curso_numCurso`, `fecha_Creacion`, `fecha_Completado`, `Completado`, `Usuario_idUsuario`) VALUES ('$count','$titulacion','$curso', '$creacion','0000-00-00','0','$id')";
  
  if(mysqli_query($con,$sql2)){
    echo "1";
  } else {
    echo "0";
  }

  mysqli_close($con);
?>