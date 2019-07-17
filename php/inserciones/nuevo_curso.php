<?php
  require('../db.php');

  if(isset($_POST['nombre_tit'])) { 	
    $nombre = $_POST["nombre_tit"];
  }
  if(isset($_POST['num_cursos'])){
    $num = stripcslashes($_POST['num_cursos']);
  } else {
      $num="";
  }

  if(isset($_POST['titulacion_tipo_an'])){
      $tipo = stripcslashes($_POST['titulacion_tipo_an']);
  } else {
      $tipo="";
  }

  $sql1 ="SELECT MAX(idCurso) as 'contar' FROM `curso`";
  $result1= mysqli_query($con,$sql1);
  $row = mysqli_fetch_assoc($result1);
  $count = $row["contar"];
  $count = $count +1;

  $sql2 = "INSERT INTO `curso`(`idCurso`, `nombreCurso`, `numCurso`, `tipo`) VALUES ('$count','$nombre','$num', '$tipo')";
  
  if(mysqli_query($con,$sql2)){
    echo "1";
  } else {
    echo mysqli_error($con);
  }

  mysqli_close($con);
?>