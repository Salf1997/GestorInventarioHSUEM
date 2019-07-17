<?php
	require('../db.php');

	if(isset($_POST['idAlmacen'])){
		$id = $_POST['idAlmacen'];
	}
	if(isset($_POST['buscar'])){
		$buscar = stripcslashes($_POST['buscar']);
	} else {
		$buscar="";
	}
	
	if ($buscar==""){
		$sel_query="SELECT `idBalda`, `nombre_Balda`, `Almacen_idAlmacen`, `nombre_Almacen` FROM `balda` JOIN `almacen` ON `almacen`.`idAlmacen`=`balda`.`Almacen_idAlmacen` WHERE `Almacen_idAlmacen`='$id'";
	} else {
		$sel_query="SELECT `idBalda`, `nombre_Balda`, `Almacen_idAlmacen`, `nombre_Almacen` FROM `balda` 
		JOIN `almacen` ON `almacen`.`idAlmacen`=`balda`.`Almacen_idAlmacen` 
		JOIN `balda_has_producto` ON `Balda_idBalda`=`idBalda` 
		JOIN `producto` ON `Producto_id_Producto`=`id_Producto` 
		WHERE (`Almacen_idAlmacen`='$id') 
		AND (`nombre_Balda` LIKE '%$buscar%' OR `nombre_Almacen` LIKE '%$buscar%') 
		OR (nombre_Producto IN (SELECT `nombre_Producto` FROM `producto` WHERE `nombre_Producto` LIKE '%$buscar%'))
		GROUP BY `nombre_Balda`";
	} 

	$result= mysqli_query($con,$sel_query);

	$contador=1;
		
	while($row = mysqli_fetch_assoc($result)) {
		echo '<tr id="'.$row['idBalda'].'">';
		echo '<td>'.$contador.'</td>';
		echo '<td>'.$row["nombre_Balda"].'</td>';
		echo '<td>'.$row["nombre_Almacen"].'</td>';
		echo '.<td><a onClick="a_onClick(`'.$row["idBalda"].'`,`'.$row["nombre_Balda"].'`)" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td>';   	
		echo '.<td><a href="productos_balda.php?idBalda='.$row["idBalda"].'&idAlmacen='.$id.'" class="btn btn-template-outlined"><i class="fa fa-link"></i></a></td></tr>';   	
		$contador=$contador+1;
	}

	
	mysqli_close($con);
?>