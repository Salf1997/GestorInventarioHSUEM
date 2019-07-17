<?php

function fecha($fechaI){
    $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    $dia = date('d',strtotime($fechaI));
    $mes = date('n',strtotime($fechaI));
    $anio = date('Y',strtotime($fechaI));
    $fecha_format = $dia." de ".$meses[$mes-1]." de ".$anio;
    return $fecha_format;
}

	require('../db.php');

	$exito =1;

	if(isset($_POST['consulta'])):
		$consulta=$_POST['consulta'];
	else:
		$consulta="";
	endif;

	if($consulta<>""):
		$sel_query="SELECT `movimiento_cantidad`.`cantidad_Final`, `movimiento_cantidad`.`Producto_id_Producto`, `movimiento_cantidad`.`fecha_mov_cant`,`producto`.`nombre_Producto`, `producto`.`descripcion_Producto`, `producto`.`stock_0109`
		FROM `movimiento_cantidad` 
		JOIN `producto` ON `movimiento_cantidad`.`Producto_id_Producto`=`producto`.`id_Producto`
		WHERE `movimiento_cantidad`.`cantidad_Final` LIKE '%$consulta%' OR `movimiento_cantidad`.`Producto_id_Producto` LIKE '%$consulta%' 
		OR `movimiento_cantidad`.`fecha_mov_cant` LIKE '%$consulta%' OR `producto`.`nombre_Producto` LIKE '%$consulta%' 
		OR `producto`.`descripcion_Producto` LIKE '%$consulta%' OR `producto`.`stock_0109` LIKE '%$consulta%'
		ORDER BY `fecha_mov_cant` DESC";
	else:
		$sel_query="SELECT `movimiento_cantidad`.`cantidad_Final`, `movimiento_cantidad`.`Producto_id_Producto`, `movimiento_cantidad`.`fecha_mov_cant`,`producto`.`nombre_Producto`, `producto`.`descripcion_Producto`, `producto`.`stock_0109`
		FROM `movimiento_cantidad` 
		JOIN `producto` ON `movimiento_cantidad`.`Producto_id_Producto`=`producto`.`id_Producto`
		ORDER BY `fecha_mov_cant` DESC";
	endif;

	$result= mysqli_query($con,$sel_query);
	if($result):
		while($row = mysqli_fetch_assoc($result)) {
			echo '<tr><td>'.$row["nombre_Producto"].'</td>';
			echo '<td>'.$row["descripcion_Producto"].'</td>';
			echo '<td>'.$row["stock_0109"].'</td>';
			echo '<td>'.fecha($row["fecha_mov_cant"]).'</td>';
			echo '<td>'.$row["cantidad_Final"].'</td></tr>';
		}
	else:
		echo mysqli_error($con);
	endif;


	mysqli_close($con);
?>