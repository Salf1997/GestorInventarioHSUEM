<?php
require('../db.php');

function salas(){
        
}

$aceptar="";
$aula=$_POST['idAula'];
if(isset($_POST['consulta'])){
        $consulta=stripcslashes($_POST['consulta']);
} else{
        $consulta="";
}

if ($consulta==""){
        $sel_query="SELECT `producto`.`id_Producto`,`aula`.`nombre_Aula`, `producto`.`descripcion_Producto`, `producto`.`nombre_Producto`, `producto_has_aula`.`cantidad_Producto`, `producto`.`stock_Producto`
         FROM `producto_has_aula` JOIN `aula` ON `producto_has_aula`.`Aula_idAula`=`aula`.`idAula` JOIN `producto` ON `producto_has_aula`.`Producto_id_Producto`=`producto`.`id_Producto` WHERE `aula`.`idAula`='$aula'";
        $aceptar = '1';
} else {
        $sel_query="SELECT `producto`.`id_Producto`,`aula`.`nombre_Aula`, `producto`.`descripcion_Producto`, `producto`.`nombre_Producto`, `producto_has_aula`.`cantidad_Producto`, `producto`.`stock_Producto`
            FROM `producto_has_aula` JOIN `aula` ON `producto_has_aula`.`Aula_idAula`=`aula`.`idAula` JOIN `producto` ON `producto_has_aula`.`Producto_id_Producto`=`producto`.`id_Producto` 
            WHERE (`aula`.`idAula`='$aula') AND (`producto`.`descripcion_Producto` LIKE '%$consulta%' OR `producto`.`nombre_Producto` LIKE '%$consulta%' OR `producto_has_aula`.`cantidad_Producto` LIKE '%$consulta%');";

        $aceptar = '1';
}   



if ($aceptar=='1'){
        $result= mysqli_query($con,$sel_query);
        if($result):
                while($row = mysqli_fetch_assoc($result)) {
                        if($row["cantidad_Producto"] > 0) {
                                $sql_Salas="SELECT `producto`.`stock_Producto`, SUM(`producto_has_aula`.`cantidad_Producto`) as 'SumaSala' FROM `producto`
                                JOIN `producto_has_aula` ON `producto_has_aula`.`Producto_id_Producto`=`producto`.`id_Producto`
                                WHERE `producto`.`id_Producto`='".$row['id_Producto']."'";
                                $sql_almacen="SELECT `almacen`.`nombre_Almacen`, `balda`.`nombre_balda` ,`balda_has_producto`.`Balda_idBalda` FROM `producto`
                                JOIN `balda_has_producto` ON `balda_has_producto`.`Producto_id_Producto`=`producto`.`id_Producto`
                                JOIN `balda` ON `balda`.`idBalda`=`balda_has_producto`.`Balda_idBalda`
                                JOIN `almacen` ON `almacen`.`idAlmacen`=`balda`.`Almacen_idAlmacen`
                                WHERE `producto`.`id_Producto`='".$row['id_Producto']."'";

                                $result2= mysqli_query($con,$sql_Salas);
                                $result3= mysqli_query($con, $sql_almacen);
                                if($result2 && $result3):
                                        $row2 = mysqli_fetch_assoc($result2);
                                        $row3 = mysqli_fetch_assoc($result3);
                                        $sumaSala = $row2['SumaSala'];
                                        $stock = $row2['stock_Producto'];
                                        $stockT = $stock-$sumaSala;

                                        $nombreAl = $row3['nombre_Almacen'];
                                        $nombreB = $row3['nombre_balda'];
                                        $idB = $row3['Balda_idBalda'];
                                        $locI = $nombreAl."-".$nombreB;
                                else:
                                        echo mysqli_error($con);
                                endif;

                                echo '<tr id="'.$row['id_Producto'].'">';
                                echo '<td>'.$row["nombre_Producto"].'</td>';
                                if($row["descripcion_Producto"]==""){
                                echo "<td>-</td>";
                                } else {
                                echo '<td>'.$row["descripcion_Producto"].'</td>';
                                }
                                echo '<td>'.$row["cantidad_Producto"].'</td>';
                                echo '.<td><a id="boton_modificar" onClick="a_onClick('.$row["id_Producto"].','.$aula.',`'.$row["nombre_Producto"].'`,'.$row["cantidad_Producto"].','.$stockT.',`'.$locI.'`, '.$idB.')" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td></tr>';   	
                        }         
                }
        else:
                echo mysqli_error($con);
        endif;
}
mysqli_close($con);
?>