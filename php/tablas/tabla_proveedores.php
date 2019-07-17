<?php
	require('../db.php');

	if(isset($_POST['info'])):
		$sel_query="SELECT `idProveedor`, `nombre_Proveedor` FROM `proveedor` WHERE `actividad` LIKE '1'";
		$result= mysqli_query($con,$sel_query);
		echo '<option disabled selected>Elige un Proveedor</option>';
		while($row = mysqli_fetch_assoc($result)) {
			echo '<option value="'.$row['idProveedor'].'">'.$row['nombre_Proveedor'].'</option>';	
		}
	else:

		if(isset($_POST['activo'])):
			if($_POST['activo']==1):
				$activo = 1;
			else:
				$activo = 0;
			endif;
		endif;

		if(isset($_POST['consulta'])){
			$consulta=stripcslashes($_POST['consulta']);
		} else{
			$consulta="";
		}

		if ($consulta==""){
			$sel_query="SELECT `idProveedor`, `nombre_Proveedor`, `email_Proveedor`, `telefono_Proveedor`, `codigoP_Proveedor`, `actividad` FROM `proveedor`";
			$aceptar = '1';
		} else {
				$sel_query="SELECT `idProveedor`, `nombre_Proveedor`, `email_Proveedor`, `telefono_Proveedor`, `codigoP_Proveedor`, `actividad` FROM `proveedor` 
					WHERE (`idProveedor` LIKE '%$consulta%' OR `nombre_Proveedor` LIKE '%$consulta%' OR `email_Proveedor` LIKE '%$consulta%' 
					OR `telefono_Proveedor` LIKE '%$consulta%' OR `codigoP_Proveedor` LIKE '%$consulta%' OR `actividad` LIKE '%$consulta%');";
				$aceptar = '1';
		}  

		if ($aceptar=='1'){
			$result= mysqli_query($con,$sel_query);
			if($result):
				if(mysqli_num_rows($result)>0):
					while($row = mysqli_fetch_assoc($result)) {	
						if($activo==1){
							if($row["actividad"] == 1){
								echo '<tr id="'.$row['idProveedor'].'">';
								echo '<td>'.$row["idProveedor"].'</td>';
								echo '<td>'.$row["nombre_Proveedor"].'</td>';
								if($row["email_Proveedor"]==""){
									echo "<td>-</td>";
								} else {
									echo '<td>'.$row["email_Proveedor"].'</td>';
								}
								if($row["telefono_Proveedor"]=="0"){
								echo "<td>-</td>";
								} else {
								echo '<td>'.$row["telefono_Proveedor"].'</td>';
								}
								echo '<td>'.$row["codigoP_Proveedor"].'</td>';
								echo '<td>S&iacute</td>';
								echo '<td><a onClick="a_onClick('.$row["idProveedor"].',`'.$row["nombre_Proveedor"].'`,`'.$row["email_Proveedor"].'`,`'.$row["telefono_Proveedor"].'`,`'.$row["codigoP_Proveedor"].'`,'.$row["actividad"].')" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td></tr>';   	
							}
						}
						else{
							echo '<tr id="'.$row['idProveedor'].'">';
							echo '<td>'.$row["idProveedor"].'</td>';
							echo '<td>'.$row["nombre_Proveedor"].'</td>';
							if($row["email_Proveedor"]==""){
								echo "<td>-</td>";
							} else {
								echo '<td>'.$row["email_Proveedor"].'</td>';
							}
							if($row["telefono_Proveedor"]=="0"){
								echo "<td>-</td>";
							} else {
								echo '<td>'.$row["telefono_Proveedor"].'</td>';
							}
							echo '<td>'.$row["codigoP_Proveedor"].'</td>';
							if($row["actividad"]=="0"){
								echo "<td>No</td>";
							} else {
								echo '<td>S&iacute</td>';
							}
							echo '<td><a onClick="a_onClick('.$row["idProveedor"].',`'.$row["nombre_Proveedor"].'`,`'.$row["email_Proveedor"].'`,`'.$row["telefono_Proveedor"].'`,`'.$row["codigoP_Proveedor"].'`,'.$row["actividad"].')" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td></tr>';   	
						}
					}

				else:
					echo "No hay proveedores con estas características.";
				endif;
			else:
				echo mysqli_error($con);
			endif;
		} else {
			echo "Error";
		}
	endif;

	mysqli_close($con);
?>