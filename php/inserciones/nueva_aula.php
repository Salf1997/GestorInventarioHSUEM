<?php
  require('../db.php');

  if(isset($_POST['nombre'])) { 	
    $nombre = $_POST["nombre"];
  }
  if(isset($_POST['tipo'])) { 
    $tipo = $_POST["tipo"];
  } else{
    $tipo="";
  }

  $sql1 ="SELECT MAX(idAula) as 'contar' FROM `aula`";
  $result1= mysqli_query($con,$sql1);
  $row = mysqli_fetch_assoc($result1);
  $count = $row["contar"];
  $count = $count +1;

  $sql2 = "INSERT INTO `aula`(`idAula`, `nombre_Aula`, `tipo_Aula`) VALUES ('$count', '$nombre','$tipo')";
  
  if(!mysqli_query($con,$sql2)){
    echo "Error Description: ". mysqli_error($con);
  } else{
    echo "1";
  }

  mysqli_close($con);
?>