<?php
    require('../db.php');
    
    $aula=$_GET['idAula'];
    $producto=$_GET['idproducto'];

    $sel_query="SELECT `producto`.`id_Producto`, `producto`.`nombre_Producto`, `producto_has_aula`.`cantidad_Producto` 
        FROM `producto_has_aula` 
        JOIN `aula` ON `producto_has_aula`.`Aula_idAula`=`aula`.`idAula` 
        JOIN `producto` ON `producto_has_aula`.`Producto_id_Producto`=`producto`.`id_Producto` 
        WHERE `aula`.`idAula`='$aula' AND `producto`.`id_Producto`='$producto' LIMIT 1";

    $result= mysqli_query($con,$sel_query);
    if ($result){
        $json = "[ ";
        while($row = mysqli_fetch_assoc($result)) {
            $json = $json.'{"idProducto":"'.$row["id_Producto"].'","nombre":"'.$row["nombre_Producto"].'","cantidad":"'.$row["cantidad_Producto"].'"},'; 	
        }
        $json = substr($json, 0, -1)."]";
        echo json_encode($json);
    } else {
        echo mysqli_error($con);
    }
	
?>