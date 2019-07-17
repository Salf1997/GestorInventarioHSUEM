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
    $sel_query="SELECT `idInforme`, `nombre_Informe`, `tipo_Informe`, `fecha_Creacion`, `Usuario_idUsuario`, `nombre_Usuario`, `apellidos_Usuario` FROM `informe` 
    JOIN `usuario` ON  `usuario`.`idUsuario`=`informe`.`Usuario_idUsuario` 
    order by fecha_Creacion DESC";
    $consulta = '1';
} else {
    $sel_query="SELECT `idInforme`, `nombre_Informe`, `tipo_Informe`, `fecha_Creacion`, `Usuario_idUsuario`, `nombre_Usuario`, `apellidos_Usuario` FROM `informe` 
    JOIN `usuario` ON  `usuario`.`idUsuario`=`informe`.`Usuario_idUsuario` 
    WHERE `fecha_Creacion` LIKE '%$buscar%' OR  `nombre_usuario` LIKE '%$buscar%' 
    OR  `apellidos_Usuario` LIKE '%$buscar%' OR  `nombre_Informe` LIKE '%$buscar%' OR  `tipo_Informe` LIKE '%$buscar%'
    ORDER BY fecha_Creacion ASC";
    $consulta = '1';
}   

if($consulta=='1'){
    $result= mysqli_query($con,$sel_query);
    while($row = mysqli_fetch_assoc($result)) {
        $fecha=fecha($row["fecha_Creacion"]);
        $idUs=$row['idInforme'];
        echo '<tr id="'.$row['idInforme'].'">';
        echo '<td>'.$row["idInforme"].'</td>';
        echo '<td>'.$row["nombre_Informe"].'</td>';
        echo '<td>'.$row["tipo_Informe"].'</td>';
        echo '<td>'.$fecha.'</td>';
        echo '<td>'.$row["nombre_Usuario"].' '.$row["apellidos_Usuario"].'</td>';
        echo '.<td><a href="" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td>';   	
    } 
} else {
    echo "Error: ".mysqli_error($con);
}
    
mysqli_close($con);

?>