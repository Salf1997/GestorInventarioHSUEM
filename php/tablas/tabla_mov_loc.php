<?php

function fecha($fechaI){
	$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	$dia = date('d',strtotime($fechaI));
	$mes = date('n',strtotime($fechaI));
	$anio = date('Y',strtotime($fechaI));
	$fecha_format = $dia." de ".$meses[$mes-1]." de ".$anio;
	return $fecha_format;
}

function encontrarLugar($con,$lugar,$tabla){
	if($tabla=="balda"):
		$nombre = "nombre_Balda";
		$id = "idBalda";
	else:
		$nombre = "nombre_Aula";
		$id = "idAula";
	endif;

	$sql="SELECT $nombre FROM $tabla WHERE $id='$lugar'";
	$result= mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($result);

	if($tabla=="aula"):
		$tabla="Sala";
	else:
		$tabla="Balda";
	endif;
	
	return $tabla." ".$row[$nombre];
}


function baldaoaula($lugar, $con){
	$balda   = 'b_';
	$pos = strpos($lugar, $balda);
	if ($pos !== false):
		$baldaTemp = preg_split("/b_/",$lugar);
		$baldaN=encontrarLugar($con, $baldaTemp[1], 'balda');
		return $baldaN;
	elseif(strpos($lugar, "No")!==false):
		return "Sin Stock";
	elseif(strpos($lugar,"Sin")!==false):
		return "No asignado";
	elseif(strpos($lugar,"Borrado")!==false):
		return "Balda borrada";
	else:
		$aulaTemp = preg_split("/a_/",$lugar);
		$aulaN=encontrarLugar($con, $aulaTemp[1], 'aula');
		return $aulaN;
	endif;
}

	require('../db.php');

	if(isset($_POST["consulta"])):
		$consulta=$_POST["consulta"];
	else:
		$consulta="";
	endif;

	if($consulta==""):
		$sel_query="SELECT `movimiento_localizacion`.`idMovimiento_Localizacion`, `movimiento_localizacion`.`localizacion_Inicial`, `movimiento_localizacion`.`localizacion_Final`, `movimiento_localizacion`.`Producto_id_Producto`, `movimiento_localizacion`.`fecha_mov_loc`,`producto`.`nombre_Producto`, `producto`.`descripcion_Producto`
		FROM `movimiento_localizacion`
		JOIN `producto` ON `movimiento_localizacion`.`Producto_id_Producto`=`producto`.`id_Producto`
		ORDER BY `idMovimiento_Localizacion` DESC";
	else:
		$sel_query="SELECT `movimiento_localizacion`.`idMovimiento_Localizacion`, `movimiento_localizacion`.`localizacion_Inicial`, `movimiento_localizacion`.`localizacion_Final`, `movimiento_localizacion`.`Producto_id_Producto`, `movimiento_localizacion`.`fecha_mov_loc`,`producto`.`nombre_Producto`, `producto`.`descripcion_Producto`
		FROM `movimiento_localizacion`
		JOIN `producto` ON `movimiento_localizacion`.`Producto_id_Producto`=`producto`.`id_Producto`
		WHERE `movimiento_localizacion`.`localizacion_Inicial` LIKE '%$consulta%' OR `movimiento_localizacion`.`localizacion_Final` LIKE '%$consulta%' 
		OR `movimiento_localizacion`.`fecha_mov_loc` LIKE '%$consulta%' OR `producto`.`nombre_Producto` LIKE '%$consulta%' OR `producto`.`descripcion_Producto` LIKE '%$consulta%'
		ORDER BY `idMovimiento_Localizacion` DESC";
	endif;

	$result= mysqli_query($con,$sel_query);
	if($result):		
		while($row = mysqli_fetch_assoc($result)) {	
			$loc_In=baldaoaula($row["localizacion_Inicial"], $con);
			$loc_Fin=baldaoaula($row["localizacion_Final"], $con);
			echo '<tr><td>'.$row["nombre_Producto"].'</td>';
			echo '<td>'.$row["descripcion_Producto"].'</td>';
			echo '<td>'.$loc_In.'</td>';
			echo '<td>'.$loc_Fin.'</td>';
			echo '<td>'.fecha($row["fecha_mov_loc"]).'</td></tr>';
			$loc_In="";
		}
	else:
		echo "error";
	endif;

	mysqli_close($con);
?>