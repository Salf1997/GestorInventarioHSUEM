<?php
  require('../db.php');

  if(isset($_POST['fecha'])) { 	
    $creacion = $_POST["fecha"];
  }
  if(isset($_POST['Usuario'])) { 
    $id = $_POST["Usuario"];
  }

  if(isset($_POST['nombre'])){
    $nombre = stripcslashes($_POST['nombre']);
  } else {
      $nombre="";
  }

  if(isset($_POST['tipo'])){
      $tipo = stripcslashes($_POST['tipo']);
  } else {
      $tipo="";
  }

  $sql1 ="SELECT MAX(idInforme) as 'contar' FROM `informe`";
  $result1= mysqli_query($con,$sql1);
  $row = mysqli_fetch_assoc($result1);
  $count = $row["contar"];
  $count = $count +1;

  $sql2 = "INSERT INTO `informe`(`idInforme`, `nombre_Informe`, `tipo_Informe`, `fecha_Creacion`, `contenido_Informe`, `Usuario_idUsuario`) VALUES ('$count','$nombre','$tipo', '$creacion','','$id')";
  
  if(mysqli_query($con,$sql2)){
    echo "1";
  } else {
    echo "0";
  }
  /*} else {
      echo "Descripcion: " . mysqli_error($con);
  }*/


  mysqli_close($con);
?>