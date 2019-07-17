<?php
require('../db.php');

if(isset($_POST['sala'])):
    $id = $_POST['idProd'];
    $stock = $_POST['stock'];
    $sql_Salas="SELECT `producto`.`id_Producto`, SUM(`producto_has_aula`.`cantidad_Producto`) as 'SumaSala' FROM `producto`
    JOIN `producto_has_aula` ON `producto_has_aula`.`Producto_id_Producto`=`producto`.`id_Producto`
    WHERE `producto`.`id_Producto`='$id'";
    $result= mysqli_query($con,$sql_Salas);
    if($result):
        $row = mysqli_fetch_assoc($result);
        $sumaSala = $row['SumaSala'];
        echo $sumaSala;
    else:
        echo mysqli_error($con);
    endif;

else:
    $aula=$_POST['idAula'];
    $sel_query="SELECT `id_Producto`, `nombre_Producto`, `descripcion_Producto`, `stock_Producto` FROM `producto` 
        WHERE `producto`.`id_Producto` NOT IN 
        (SELECT `producto_has_aula`.`Producto_id_Producto` FROM `producto_has_aula` 
        WHERE `producto_has_aula`.`Aula_idAula`='$aula')";
    $result= mysqli_query($con,$sel_query);
    if($result):
        echo '<option selected disabled>Seleccione un producto</option>';
        while($row = mysqli_fetch_assoc($result)) {
            $sql_almacen="SELECT `almacen`.`nombre_Almacen`, `balda`.`nombre_balda` ,`balda_has_producto`.`Balda_idBalda` FROM `producto`
                JOIN `balda_has_producto` ON `balda_has_producto`.`Producto_id_Producto`=`producto`.`id_Producto`
                JOIN `balda` ON `balda`.`idBalda`=`balda_has_producto`.`Balda_idBalda`
                JOIN `almacen` ON `almacen`.`idAlmacen`=`balda`.`Almacen_idAlmacen`
                WHERE `producto`.`id_Producto`='".$row['id_Producto']."'";
            $result3= mysqli_query($con, $sql_almacen);
            $row2 = mysqli_fetch_assoc($result3);

            $idB = $row2['Balda_idBalda'];
            $locI = $row2['nombre_Almacen']." - ".$row2['nombre_balda'];

            echo '<option value="'.$row['id_Producto'].'" idB="'.$idB.'" locI="'.$locI.'" name="'.$row['nombre_Producto'].'" cantidad="'.$row['stock_Producto'].'" descripcion="'.$row['descripcion_Producto'].'">'.$row['descripcion_Producto'].'</option>';
        }
    else:
            echo mysqli_error($con);
    endif;

endif;

mysqli_close($con);
?>