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

$consulta ="";

if(isset($_POST['buscar'])){
    $buscar = stripcslashes($_POST['buscar']);
} else {
    $buscar="";
}

if ($buscar==""){
    $sel_query="SELECT `idPedido`, `Curso_idCurso`, `nombreCurso`, `Curso_numCurso`, `fecha_Creacion`, `fecha_Completado`, `Completado`, `Usuario_idUsuario`, `nombre_Usuario`, `apellidos_Usuario` FROM `pedido` 
    JOIN `usuario` ON  `usuario`.`idUsuario`=`pedido`.`Usuario_idUsuario` 
    JOIN `curso` ON  `curso`.`idCurso`=`pedido`.`Curso_idCurso` 
    order by FIELD(Completado,'0') DESC";
    $consulta = '1';
} else {
    $sel_query="SELECT `idPedido`, `Curso_idCurso`, `nombreCurso`, `Curso_numCurso`, `fecha_Creacion`, `fecha_Completado`, `Completado`, `Usuario_idUsuario`, `nombre_Usuario`, `apellidos_Usuario` FROM `pedido` 
    JOIN `usuario` ON  `usuario`.`idUsuario`=`pedido`.`Usuario_idUsuario` 
    JOIN `curso` ON  `curso`.`idCurso`=`pedido`.`Curso_idCurso` 
    WHERE `fecha_Creacion` LIKE '%$buscar%' OR `fecha_Completado` LIKE '%$buscar%' OR  `nombre_usuario` LIKE '%$buscar%' 
    OR  `apellidos_Usuario` LIKE '%$buscar%' OR  `nombreCurso` LIKE '%$buscar%' OR  `Curso_numCurso` LIKE '%$buscar%'
    ORDER BY FIELD(Completado,'0') ASC";
    $consulta = '1';
}   

if($consulta=='1'){
    $result= mysqli_query($con,$sel_query);
    if($result):
        while($row = mysqli_fetch_assoc($result)) {
            $fecha=fecha($row["fecha_Creacion"]);
            $idUs=$row['idPedido'];
            echo '<tr id="'.$row['idPedido'].'">';
            echo '<td>'.$row["idPedido"].'</td>';
            echo '<td>'.$row["nombreCurso"].'</td>';
            echo '<td>'.$row["Curso_numCurso"].'</td>';
            echo '<td>'.$fecha.'</td>';
            if ($row["Completado"]==0){
                echo '<td>-</td>';
            }else {
                echo '<td>'.fecha($row["fecha_Completado"]).'</td>';
            }
            echo '<td>'.$row["nombre_Usuario"].' '.$row["apellidos_Usuario"].'</td>';
            echo '.<td><a href="productos_pedido.php?idPedido='.$row['idPedido'].'" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td>';   	
        } 
    else:
        echo "Error: ".mysqli_error($con);
    endif;
} else {
    echo "Error: ".mysqli_error($con);
}
    
mysqli_close($con);

?>