<?php
    require('../db.php');

    $aula=$_POST['idAula'];
    $idProd=$_POST['idProd'];

    $sel_query="SELECT `producto`.`id_Producto`, `producto`.`nombre_Producto`, `producto_has_aula`.`cantidad_Producto` FROM `producto_has_aula` JOIN `aula` ON `producto_has_aula`.`Aula_idAula`=`aula`.`idAula` JOIN `producto` ON `producto_has_aula`.`Producto_id_Producto`=`producto`.`id_Producto` WHERE `aula`.`idAula`='$aula' AND `producto`.`id_Producto`='$idProd'";

    $result= mysqli_query($con,$sel_query);

    $json = "[ ";
        
    while($row = mysqli_fetch_assoc($result)) {
            $json = $json.'{"id":"'.$row["id_Producto"].'","producto":"'.$row["nombre_Producto"].'","cantidad":"'.$row["cantidad_Producto"].'"},'; 	
    }

    $json = substr($json, 0, -1)."]";

    echo utf8_encode($json);
?>
