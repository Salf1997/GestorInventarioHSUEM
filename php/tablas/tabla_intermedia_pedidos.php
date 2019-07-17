<?php
  require('../db.php');

  if(isset($_POST['tipo'])) { 
    $tipo = $_POST["tipo"];
  } else{
    $tipo="";
  }

if(!empty($tipo)):
    $sel_query="SELECT `idCurso`, `nombreCurso`, `numCurso`, `tipo` FROM `curso` WHERE `tipo`='$tipo' ORDER BY nombreCurso ASC";
    $result= mysqli_query($con,$sel_query);
    echo '<option disabled selected>Elige una titulaci&oacuten</option>';
    while($row = mysqli_fetch_assoc($result)) {
        echo '<option value="'.$row['idCurso'].'" nombre="'.$row['nombreCurso'].'" curso="'.$row['numCurso'].'">'.$row['nombreCurso'].'</option>';
    } 
endif;

  mysqli_close($con);
?>