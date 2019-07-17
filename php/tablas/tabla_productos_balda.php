<?php
require('../db.php');

$aceptar="";
$balda=$_POST['idBalda'];
if(isset($_POST['consulta'])){
        $consulta=stripcslashes($_POST['consulta']);
} else{
        $consulta="";
}

if ($consulta==""){
        $sel_query="SELECT `producto`.`id_Producto`,`balda`.`nombre_Balda`,`producto`.`stock_Producto`,`producto`.`descripcion_Producto`, `producto`.`nombre_Producto`, `balda_has_producto`.`cantidad_Producto_Baldas` 
        FROM `balda_has_producto` JOIN `balda` ON `balda_has_producto`.`Balda_idBalda`=`balda`.`idBalda` JOIN `producto` ON `balda_has_producto`.`Producto_id_Producto`=`producto`.`id_Producto` 
        WHERE (`balda`.`idBalda`='$balda')";
        $aceptar = '1';
} else {
        $sel_query="SELECT `producto`.`id_Producto`,`balda`.`nombre_Balda`,`producto`.`descripcion_Producto`, `producto`.`nombre_Producto`, `balda_has_producto`.`cantidad_Producto_Baldas` 
            FROM `balda_has_producto` JOIN `balda` ON `balda_has_producto`.`Balda_idBalda`=`balda`.`idBalda` JOIN `producto` ON `balda_has_producto`.`Producto_id_Producto`=`producto`.`id_Producto` 
            WHERE (`balda`.`idBalda`='$balda') AND (`producto`.`descripcion_Producto` LIKE '%$consulta%' OR `producto`.`nombre_Producto` LIKE '%$consulta%' OR `balda_has_producto`.`cantidad_Producto_Baldas` LIKE '%$consulta%')";

        $aceptar = '1';
}   



if ($aceptar=='1'){
        $result= mysqli_query($con,$sel_query);
                    
        while($row = mysqli_fetch_assoc($result)) {
                $stock_producto=$row['stock_Producto'];
                $sumaSala=0;
                $stock_baldas=0;

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

                echo '<tr id="'.$row['id_Producto'].'">';
                echo '<td>'.$row["nombre_Producto"].'</td>';
                if($row["descripcion_Producto"]==""){
                echo "<td>-</td>";
                } else {
                echo '<td>'.$row["descripcion_Producto"].'</td>';
                }
                echo '<td>'.$row["cantidad_Producto_Baldas"].'</td>';
                echo '.<td><a producto="'.$row['id_Producto'].'" onClick="a_onClick('.$row["id_Producto"].',`'.$row["nombre_Producto"].'`,`'.$row["descripcion_Producto"].'`,'.$row["cantidad_Producto_Baldas"].','.$stock_total_no_asignado.')" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td></tr>';   	              
        }
        if($row==0){
            echo 'No hay existencias.';
        }
        
} else {
    echo $aceptar;
}
mysqli_close($con);
?>