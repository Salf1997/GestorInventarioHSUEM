<?php
  require('../db.php');

  if(isset($_POST['idAlmacen'])) { 	
    $idA = $_POST["idAlmacen"];
  }
  if(isset($_POST['identificador_mod'])) { 
    $idB = $_POST["identificador_mod"];
  }
  if(isset($_POST['nombre_mod'])) { 
    $nombre = $_POST["nombre_mod"];
  }
  if(isset($_POST['borrar'])) { 
    $borrar=1;
  }else {
    $borrar = 0;
  }
  $exito = 1;

  if ($borrar==1){
    $fecha = $_POST['fecha'];
    $sql_i="SELECT `Producto_id_Producto`, `cantidad_Producto_Baldas` FROM `balda_has_producto` WHERE `Balda_idBalda`='$idB'";
    $result_i=mysqli_query($con,$sql_i);
    if(mysqli_num_rows($result_i)>0):
      //Si hay productos dentro de cada balda, se asigna el movimiento y se borra
      while($row2 = mysqli_fetch_assoc($result_i)){
        $idProd = $row2['Producto_id_Producto'];
        $cantidad = $row2['cantidad_Producto_Baldas'];
        $localizacionI = 'Borrado';
        $localizacionF = 'Sin';

        $sql_count_cant ="SELECT MAX(idMovimiento_Cantidad) as 'contar' FROM `movimiento_cantidad`";
        $result_count_cant= mysqli_query($con,$sql_count_cant);
        $row_count_cant = mysqli_fetch_assoc($result_count_cant);
        $count_count_cant = $row_count_cant["contar"];
        $count_count_cant = $count_count_cant +1;


        $sql_cant="INSERT INTO `movimiento_cantidad`(`idMovimiento_Cantidad`, `cantidad_Final`, `Producto_id_Producto`, `fecha_mov_cant`) 
            VALUES ($count_count_cant,$cantidad,$idProd,$fecha)";
        if(!mysqli_query($con,$sql_cant)):
            echo mysqli_error($con);
        endif;

        $sql_count_loc ="SELECT MAX(idMovimiento_Localizacion) as 'contar' FROM `movimiento_localizacion`";
        $result_count_loc= mysqli_query($con,$sql_count_loc);
        $row_count_loc = mysqli_fetch_assoc($result_count_loc);
        $count_count_loc = $row_count_loc["contar"];
        $count_count_loc = $count_count_loc +1;

        $sql_loc="INSERT INTO `movimiento_localizacion`(`idMovimiento_Localizacion`, `localizacion_Inicial`, `localizacion_Final`, `Producto_id_Producto`, `fecha_mov_loc`) 
            VALUES ($count_count_loc,'$localizacionI','$localizacionF',$idProd,$fecha)";

        if(!mysqli_query($con,$sql_loc)):
            echo mysqli_error($con);
        endif;
      }
      //BORRANDO PRODUCTOS DE BALDA
      $sql_p2 = "DELETE FROM `balda_has_producto` WHERE `Balda_idBalda`='$idB'";
      mysqli_query($con,$sql_p2);
    endif;
    $sql1 = "DELETE FROM `balda` WHERE `idBalda`= '$idB'";
    if(mysqli_query($con,$sql1)){
        echo $exito;
    } else {
      $exito = 0;
      echo $exito;
    }
  } else {
    $sql2 = "UPDATE `balda` SET  `nombre_Balda`= '$nombre' WHERE `idBalda`= '$idB' AND `Almacen_idAlmacen`='$idA'";
    if(mysqli_query($con,$sql2)){
        echo $exito;
    } else {
      $exito = 0;
      echo $exito;
      echo mysqli_error($con);
    }
  }
  mysqli_close($con);
?>