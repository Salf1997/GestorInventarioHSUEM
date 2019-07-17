<?php

require("../db.php");

if(isset($_POST['fecha'])):
    $fecha = stripslashes($_POST['fecha']);
else:
    $fecha="";
endif;
if(isset($_POST['cantidad'])):
    $cantidad = stripslashes($_POST['cantidad']);
else:
    $cantidad="";
endif;
if(isset($_POST['localizacionF'])):
    $localizacionF = stripslashes($_POST['localizacionF']);
else:
    $localizacionF="";
endif;
if(isset($_POST['localizacionI'])):
    $localizacionI = stripslashes($_POST['localizacionI']);
else:
    $localizacionI="";
endif;
if(isset($_POST['idProd'])):
    $id = stripslashes($_POST['idProd']);
else:
    $id="";
endif;


$sql_count_cant ="SELECT MAX(idMovimiento_Cantidad) as 'contar' FROM `movimiento_cantidad`";
$result_count_cant= mysqli_query($con,$sql_count_cant);
$row_count_cant = mysqli_fetch_assoc($result_count_cant);
$count_count_cant = $row_count_cant["contar"];
$count_count_cant = $count_count_cant +1;


$sql_cant="INSERT INTO `movimiento_cantidad`(`idMovimiento_Cantidad`, `cantidad_Final`, `Producto_id_Producto`, `fecha_mov_cant`) 
    VALUES ($count_count_cant,$cantidad,$id,$fecha)";
if(mysqli_query($con,$sql_cant)):
    echo '1 ';
else:
    echo mysqli_error($con);
endif;

$sql_count_loc ="SELECT MAX(idMovimiento_Localizacion) as 'contar' FROM `movimiento_localizacion`";
$result_count_loc= mysqli_query($con,$sql_count_loc);
$row_count_loc = mysqli_fetch_assoc($result_count_loc);
$count_count_loc = $row_count_loc["contar"];
$count_count_loc = $count_count_loc +1;

$sql_loc="INSERT INTO `movimiento_localizacion`(`idMovimiento_Localizacion`, `localizacion_Inicial`, `localizacion_Final`, `Producto_id_Producto`, `fecha_mov_loc`) 
    VALUES ($count_count_loc,$localizacionI,$localizacionF,$id,$fecha)";

if(mysqli_query($con,$sql_loc)):
    echo ' 2';
else:
    echo mysqli_error($con);
endif;



?>