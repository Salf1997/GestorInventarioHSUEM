<?php
require('../db.php');

if(isset($_POST['buscar'])){
    $buscar = stripcslashes($_POST['buscar']);
} else {
    $buscar="";
}

if ($buscar==""){
    $sel_query="SELECT * FROM `almacen`";
} else {
    $sel_query="SELECT * FROM `almacen` WHERE `nombre_Almacen` LIKE '%$buscar%' OR `localizacion_Almacen` LIKE '%$buscar%'";
}   
$result= mysqli_query($con,$sel_query);
    
while($row = mysqli_fetch_assoc($result)) {
    echo '<tr id="'.$row['idAlmacen'].'">';
    echo '<td>'.$row["idAlmacen"].'</td>';
    echo '<td>'.$row["nombre_Almacen"].'</td>';
    echo '<td>'.$row["localizacion_Almacen"].'</td>';
    echo '.<td><a onClick="a_onClick(`'.$row["idAlmacen"].'`,`'.$row["nombre_Almacen"].'`,`'.$row["localizacion_Almacen"].'`)" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td>';   	
    echo '.<td><a href="baldas.php?idAlmacen='.$row["idAlmacen"].'" class="btn btn-template-outlined"><i class="fa fa-link"></i></a></td></tr>';   	

} 

mysqli_close($con);
?>