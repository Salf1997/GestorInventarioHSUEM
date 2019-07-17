<?php
	require('../db.php');
	$exito=1;

	if(isset($_POST['consulta'])):
		$consulta = $_POST['consulta'];
	else:
		$consulta = "";
	endif;

	if($consulta==""):
		$sel_query="SELECT `idAula`, `nombre_Aula`, `tipo_Aula` FROM aula ORDER BY tipo_Aula ASC";
	else:
		$sel_query="SELECT `idAula`, `nombre_Aula`, `tipo_Aula` FROM aula 
		JOIN `producto_has_aula` ON `producto_has_aula`.`Aula_idAula`=`aula`.`idAula` 
		JOIN `producto` ON `Producto_id_Producto`=`id_Producto` 
		WHERE (`nombre_Aula` LIKE '%$consulta%' OR `tipo_Aula` LIKE '%$consulta%') 
		OR (nombre_Producto IN (SELECT `nombre_Producto` FROM `producto` WHERE `nombre_Producto` LIKE '%$consulta%')) 
		OR (descripcion_Producto IN (SELECT `descripcion_Producto` FROM `producto` WHERE `descripcion_Producto` LIKE '%$consulta%'))
		GROUP BY `nombre_Aula` 
		ORDER BY tipo_Aula ASC ";
	endif;

	$result= mysqli_query($con,$sel_query);
	if($result):
		while($row = mysqli_fetch_assoc($result)) {			
			echo '<tr idAula="'.$row["idAula"].'">';
			echo '<td>'.$row["nombre_Aula"].'</td>';
			echo '<td>'.$row["tipo_Aula"].'</td>';
			echo '<td><a data-toggle="modal" data-target="#modal_modificar" onClick="a_onClick('.$row["idAula"].',`'.$row["nombre_Aula"].'`,`'.$row["tipo_Aula"].'`)" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td>';
			echo '<td><a href="productos_aula.php?idAula='.$row["idAula"].'" class="btn btn-template-outlined"><i class="fa fa-link"></i></a></td></tr>';
		}
	else:
		echo "error";
	endif;

	mysqli_close($con);
?>