<?php
	require('../db.php');

	$consulta="";

	if(isset($_POST['consulta'])):
		$consulta =stripcslashes($_POST['consulta']);
	else:
		$consulta="";
	endif;

	if(isset($_POST['activo'])):
		if($_POST['activo']==1):
			$activo = 1;
		else:
			$activo = 0;
		endif;
	endif;

	$ok = 0;

	if ($consulta==""):
		$sel_query="SELECT `id_Producto`, `nombre_Producto`, `stock_0109`, `stock_Producto`, `stock_Minimo_Critico`, `stock_Alerta`, `tipo_producto`, `descripcion_Producto`, `activo` FROM producto ORDER BY `nombre_Producto` ASC";
		$ok = 1;
	else:
		$sel_query="SELECT `id_Producto`, `nombre_Producto`, `stock_0109`, `stock_Producto`, `stock_Minimo_Critico`, `stock_Alerta`, `tipo_producto`, `descripcion_Producto`, `activo` FROM producto 
		WHERE (`id_Producto` LIKE '%$consulta%' OR `nombre_Producto` LIKE '%$consulta%' 
		OR `stock_Producto` LIKE '%$consulta%' OR `stock_Minimo_Critico` LIKE '%$consulta%' 
		OR `stock_Alerta` LIKE '%$consulta%' OR `tipo_producto` LIKE '%$consulta%' 
		OR `descripcion_Producto` LIKE '%$consulta%') ORDER BY `nombre_Producto` ASC";
		$ok = 1;
	endif;
	
	if($ok==1):
		$result= mysqli_query($con,$sel_query);
		if($result):
			if(mysqli_num_rows($result)>0):
				while($row = mysqli_fetch_assoc($result)){	
					if($activo==1){
						if($row["activo"] == 1){
							echo '<tr id="'.$row['id_Producto'].'">';
							echo '<td>'.$row["id_Producto"].'</td>';
							echo '<td>'.$row["nombre_Producto"].'</td>';
							echo '<td>'.$row["stock_0109"].'</td>';
							echo '<td>'.$row["stock_Producto"].'</td>';
							echo '<td>'.$row["tipo_producto"].'</td>';
							echo '<td>'.$row["descripcion_Producto"].'</td>';
							echo '<td>S&iacute</td>';
							echo '<td><a onClick="a_onClick('.$row["id_Producto"].',`'.$row["nombre_Producto"].'`,`'.$row["stock_Producto"].'`,`'.$row["stock_Minimo_Critico"].'`,`'.$row["stock_Alerta"].'`,`'.$row["descripcion_Producto"].'`,`'.$row["tipo_producto"].'`,`'.$row["activo"].'`)" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td></tr>';   	
						}
					}
					else{
						echo '<tr id="'.$row['id_Producto'].'">';
						echo '<td>'.$row["id_Producto"].'</td>';
						echo '<td>'.$row["nombre_Producto"].'</td>';
						echo '<td>'.$row["stock_0109"].'</td>';
						echo '<td>'.$row["stock_Producto"].'</td>';
						echo '<td>'.$row["tipo_producto"].'</td>';
						echo '<td>'.$row["descripcion_Producto"].'</td>';
						if($row["activo"]=="0"){
							echo "<td>No</td>";
						} else {
							echo '<td>S&iacute</td>';
						}
						echo '<td><a onClick="a_onClick('.$row["id_Producto"].',`'.$row["nombre_Producto"].'`,`'.$row["stock_Producto"].'`,`'.$row["stock_Minimo_Critico"].'`,`'.$row["stock_Alerta"].'`,`'.$row["descripcion_Producto"].'`,`'.$row["tipo_producto"].'`,`'.$row["activo"].'`)" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td></tr>';   	
					}
				}
			else:
				echo "No hay elementos con estas características.";
			endif;
		else:
			echo mysqli_error($con);
		endif;
	endif;
	mysqli_close($con);	
?>