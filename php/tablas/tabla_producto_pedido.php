<?php
function fecha($fechaI){
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        $dia = date('d',strtotime($fechaI));
        $mes = date('n',strtotime($fechaI));
        $anio = date('Y',strtotime($fechaI));
        $fecha_format = $dia." de ".$meses[$mes-1]." de ".$anio;
        return $fecha_format;
}

require('../db.php');

$aceptar="";
$pedido=$_POST['idPedido'];
if(isset($_POST['consulta'])){
        $consulta=stripcslashes($_POST['consulta']);
} else{
        $consulta="";
}
if(isset($_POST['info'])):
        $sel_query="SELECT `idPedido`, `Curso_idCurso`, `nombreCurso`, `Curso_numCurso`, `fecha_Creacion`, `fecha_Completado`, `Completado` FROM `pedido` 
        JOIN `curso` ON  `curso`.`idCurso`=`pedido`.`Curso_idCurso`
        WHERE `idPedido`='$pedido'
        ORDER BY idPedido ASC";

        $result= mysqli_query($con,$sel_query);
        $row = mysqli_fetch_assoc($result);
        $fecha= fecha($row["fecha_Creacion"]);
        $idUs=$row['idPedido'];
        echo '<tr>';
        echo '<td>'.$row["nombreCurso"].'</td>';
        echo '<td>'.$row["Curso_numCurso"].'</td>';
        echo '<td>'.$fecha.'</td>';
        if ($row["Completado"]==0){
                echo '<td>-</td>';
        }else {
                echo '<td>'.fecha($row["fecha_Completado"]).'</td>';
        }
        echo '</tr>';

        session_start();
        $_SESSION['Completado']=$row["Completado"];

elseif(isset($_POST['productosAcc'])):
        $pedido=$_POST['idPedido'];
        $sel_query="SELECT `id_Producto`, `nombre_Producto`, `descripcion_Producto`, `stock_Producto` FROM `producto` WHERE `producto`.`id_Producto` 
        NOT IN (SELECT `producto_has_pedido`.`Producto_id_Producto` FROM `producto_has_pedido` WHERE `producto_has_pedido`.`Pedido_idPedido`='$pedido')";
        $result= mysqli_query($con,$sel_query);
        if($result):
                $option="";
                echo '<option selected disabled>Seleccione un producto</option>';
                while($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="'.$row['id_Producto'].'" name="'.$row['id_Producto'].'"';
                        echo 'cantidad="'.$row['stock_Producto'].'"';
                        echo 'descripcion="'.$row['descripcion_Producto'].'">';
                        echo $row['nombre_Producto']; 
                        echo '</option>';
                }
        else:
                echo mysqli_error($con);
        endif;

else:
        if ($consulta==""){
                $sel_query="SELECT `producto`.`id_Producto`,`producto`.`descripcion_Producto`, `producto`.`nombre_Producto`, `cantidad_Producto_Pedido`, `producto`.`precio` FROM `producto_has_pedido` 
                JOIN `pedido` ON `pedido`.`idPedido`=`producto_has_pedido`.`Pedido_idPedido` 
                JOIN `producto` ON `producto_has_pedido`.`Producto_id_Producto`=`producto`.`id_Producto` 
                WHERE (`pedido`.`idPedido`='$pedido') ORDER BY `nombre_Producto` ASC";
                $aceptar = '1';
        } else {
                $sel_query="SELECT `producto`.`id_Producto`,`producto`.`descripcion_Producto`, `producto`.`nombre_Producto`, `cantidad_Producto_Pedido`, `producto`.`precio` FROM `producto_has_pedido` 
                JOIN `pedido` ON `pedido`.`idPedido`=`producto_has_pedido`.`Pedido_idPedido` 
                JOIN `producto` ON `producto_has_pedido`.`Producto_id_Producto`=`producto`.`id_Producto` 
                WHERE (`pedido`.`idPedido`='$pedido') 
                AND (`producto`.`descripcion_Producto` LIKE '%$consulta%' OR `producto`.`nombre_Producto` LIKE '%$consulta%' OR `cantidad_Producto_Pedido` LIKE '%$consulta%') 
                ORDER BY `nombre_Producto` ASC";

                $aceptar = '1';
        }   
        $totalProductos=0.0;
        $total=0.0;
        

        if ($aceptar=='1'){
                $result= mysqli_query($con,$sel_query);
                if($result):            
                while($row = mysqli_fetch_assoc($result)) {
                        $precio = $row['precio'];
                        $total = $row["cantidad_Producto_Pedido"]*$precio;
                        $totalProductos = $total+$totalProductos;
                        echo '<tr id="'.$row['id_Producto'].'">';
                        echo '<td>'.$row["nombre_Producto"].'</td>';
                        if($row["descripcion_Producto"]==""){
                        echo "<td>-</td>";
                        } else {
                        echo '<td>'.$row["descripcion_Producto"].'</td>';
                        }
                        echo '<td>'.$row["cantidad_Producto_Pedido"].'</td>';
                        echo '<td>'.$precio.'</td>';
                        echo '<td>'.$total.'</td>';
                        echo '.<td><a producto="'.$row['id_Producto'].'" onClick="a_onClick('.$row["id_Producto"].',`'.$row["nombre_Producto"].'`,`'.$row["descripcion_Producto"].'`,'.$row["cantidad_Producto_Pedido"].')" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td></tr>';   	        
                }
                echo '<tr id="total"><td></td><td></td><td></td><td>TOTAL</td><td>'.$totalProductos.'</td><td>€</td></tr>';
                else:
                echo "Error: ". mysqli_error($con);
                endif;
        }
endif;
mysqli_close($con);
?>