<?php
require('../db.php');

$consulta ="";

if(isset($_POST['buscar'])){
    $buscar = stripcslashes($_POST['buscar']);
} else {
    $buscar="";
}


if ($buscar==""){
    $sel_query="SELECT `idUsuario`, `nombre_Usuario`, `apellidos_Usuario`, `email_Usuario`, `usuario_has_rol`.`activo`, `rol`.`nombre_Rol` FROM `usuario` JOIN `usuario_has_rol` ON `usuario_has_rol`.`Usuario_idUsuario`=`usuario`.`idUsuario` JOIN `rol` ON `rol`.`idRol`=`usuario_has_rol`.`Rol_idRol` ORDER BY nombre_Usuario ASC";
    $consulta = '1';
} else {
    $sel_query="SELECT `idUsuario`, `nombre_Usuario`, `apellidos_Usuario`, `email_Usuario`, `usuario_has_rol`.`activo`, `rol`.`nombre_Rol` FROM `usuario` JOIN `usuario_has_rol` ON `usuario_has_rol`.`Usuario_idUsuario`=`usuario`.`idUsuario` JOIN `rol` ON `rol`.`idRol`=`usuario_has_rol`.`Rol_idRol` WHERE `idUsuario` LIKE '%$buscar%' OR `nombre_Usuario` LIKE '%$buscar%' OR  `apellidos_Usuario` LIKE '%$buscar%' 
    OR  `email_Usuario` LIKE '%$buscar%' OR  `nombre_rol` LIKE '%$buscar%' ORDER BY nombre_Usuario ASC";
    $consulta = '1';
}   

if($consulta=='1'){
    $result= mysqli_query($con,$sel_query);
    while($row = mysqli_fetch_assoc($result)) {
        $idUs=$row['idUsuario'];
        echo '<tr id="'.$row['idUsuario'].'">';
        echo '<td>'.$row["idUsuario"].'</td>';
        echo '<td>'.$row["nombre_Usuario"].'</td>';
        echo '<td>'.$row["apellidos_Usuario"].'</td>';
        echo '<td>'.$row["email_Usuario"].'</td>';
        echo '<td>'.$row["nombre_Rol"].'</td>';
        if($row["activo"]=='1'){
            echo '<td>S&iacute</td>';
        } else {
            echo '<td>No</td>';
        }
        echo '.<td><a onClick="a_onClick(`'.$row["idUsuario"].'`,`'.$row["nombre_Usuario"].'`,`'.$row["apellidos_Usuario"].'`,`'.$row["email_Usuario"].'`,`'.$row["nombre_Rol"].'`,`'.$row["activo"].'`)" data-toggle="modal" data-target="#mod_usuario" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td>';   	
    } 
}
    
mysqli_close($con);
?>