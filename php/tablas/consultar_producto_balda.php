<?php
require('../db.php');

if(!isset($_POST['idProducto'])):
    $balda=$_POST['idBalda'];
    $sel_query="SELECT `producto`.`id_Producto`, `producto`.`nombre_Producto`, `producto`.`descripcion_Producto`, `producto`.`stock_Producto` FROM `producto`
    WHERE `producto`.`id_Producto`
    NOT IN (SELECT `balda_has_producto`.`Producto_id_Producto` FROM `balda_has_producto` WHERE `balda_has_producto`.`Balda_idBalda`='$balda')";
    $result= mysqli_query($con,$sel_query);
    if($result):
        echo '<option selected disabled>Seleccione un producto</option>';        
        while($row = mysqli_fetch_assoc($result)) {
            $stock_baldas=0;
            $sumaSala=0;
            $stock_producto=$row['stock_Producto'];

            $sql_almacen="SELECT SUM(`balda_has_producto`.`cantidad_Producto_Baldas`) as 'SumaBalda' FROM `balda_has_producto` 
            WHERE `balda_has_producto`.`Producto_id_Producto` ='".$row['id_Producto']."'";
            $result3= mysqli_query($con, $sql_almacen);
            if($result3):
                $row2 = mysqli_fetch_assoc($result3);
                $stock_baldas=$row2['SumaBalda'];
                
            else:
                echo mysqli_error($con);
            endif;

            $sql_Salas="SELECT `producto`.`id_Producto`, SUM(`producto_has_aula`.`cantidad_Producto`) as 'SumaSala' FROM `producto`
                JOIN `producto_has_aula` ON `producto_has_aula`.`Producto_id_Producto`=`producto`.`id_Producto`
                WHERE `producto`.`id_Producto`='".$row['id_Producto']."'";
                $result4= mysqli_query($con,$sql_Salas);
            if(mysqli_num_rows($result4)>0):
                $row3 = mysqli_fetch_assoc($result4);
                $sumaSala = $row3['SumaSala'];
            else:
                $sumaSala=0;
            endif;

            $stock_total_no_asignado=$stock_producto-$sumaSala-$stock_baldas;

            if($stock_total_no_asignado>0):
                echo '<option value="'.$row['id_Producto'].'" name="'.$row['nombre_Producto'].'" stock_tot="'.$stock_producto.'" cantidad="'.$stock_total_no_asignado.'" descripcion="'.$row['descripcion_Producto'].'">'.$row['descripcion_Producto'].'</option>';
            endif;
        }
    else:
            echo mysqli_error($con);
    endif;
else:
    $idProd=$_POST['idProducto'];
    $localizacion="";
    
    $sql_lugar_almacen="SELECT `almacen`.`nombre_Almacen`, `balda`.`nombre_balda`, `cantidad_Producto_Baldas` FROM `balda_has_producto` 
        JOIN `balda` ON `balda`.`idBalda`=`balda_has_producto`.`Balda_idBalda` 
        JOIN `almacen`ON `almacen`.`idAlmacen`=`balda`.`Almacen_idAlmacen`
        WHERE `balda_has_producto`.`Producto_id_Producto` ='$idProd'";
    $result3= mysqli_query($con, $sql_lugar_almacen);
    if($result3):
        while($row2 = mysqli_fetch_assoc($result3)){
            $localizacion=$localizacion.'<strong>Almacén:</strong> '.$row2['nombre_Almacen']."<strong> &nbsp; Balda:</strong> ".$row2['nombre_balda']."<strong> &nbsp; Cantidad:</strong> ".$row2['cantidad_Producto_Baldas']."<br>";
        }
    else:
        echo mysqli_error($con);
    endif;

    $sql_lugar_salas="SELECT `aula`.`nombre_Aula`, `producto_has_aula`.`cantidad_Producto` FROM `aula`
        JOIN `producto_has_aula` ON `producto_has_aula`.`Aula_idAula`=`aula`.`idAula`
        WHERE `producto_has_aula`.`Producto_id_Producto`='$idProd'";
    $result4= mysqli_query($con,$sql_lugar_salas);
    if($result4):
        while($row2 = mysqli_fetch_assoc($result4)){
            $localizacion=$localizacion.'<strong>Aula:</strong> '.$row2['nombre_Aula']."<strong> &nbsp; Cantidad:</strong> ".$row2['cantidad_Producto']."<br>";
        }
    else:
        echo mysqli_error($con);
    endif;

    echo $localizacion;

endif;


mysqli_close($con);
?>