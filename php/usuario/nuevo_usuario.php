<?php
require('../db.php');


function selectUsRol($con){
    $sql1 ="SELECT COUNT(id_Usuario_Rol) as 'contar' FROM `usuario_has_rol`";
    $result1= mysqli_query($con,$sql1);
    $row = mysqli_fetch_assoc($result1);
    $count = $row["contar"];
    $count = $count +1;

    return $count;
}

function countRoles($con,$usuario, $rol){
    $select = "SELECT COUNT(idUsuario) AS 'contar' FROM `usuario` JOIN `usuario_has_rol` ON `usuario_has_rol`.`Usuario_idUsuario`=`usuario`.`idUsuario` WHERE idUsuario='$usuario' AND Rol_idRol='$rol'";
    $result_select= mysqli_query($con,$select);
    $row_select=mysqli_fetch_assoc($result_select);
    $contador_select=$row_select['contar'];

    return $contador_select;
}

function digitos($number) {
    return strlen($number);
  }  

$num = $_POST['empleado'];

$nombre = $_POST['nombre'];

$apellido = $_POST['apellido'];

$email = $_POST['email'];

if(isset($_POST['rol_ad'])):
    $admin = "ok";
else:
    $admin="";
endif;
if(isset($_POST['rol_tc'])):
    $tec = "ok";
else:
    $tec = "";
endif;

$digit = digitos($num);

if($digit>=6):
    $pass = $num;
else:
    $pass = $num.$num;
endif;

$pas = password_hash($pass, PASSWORD_BCRYPT);

$comprobacion= "SELECT (SELECT COUNT(idUsuario) FROM `usuario` JOIN `usuario_has_rol` ON `usuario_has_rol`.`Usuario_idUsuario`=`usuario`.`idUsuario` WHERE idUsuario='$num' AND Rol_idRol='1')+(SELECT COUNT(idUsuario) FROM `usuario` JOIN `usuario_has_rol` ON `usuario_has_rol`.`Usuario_idUsuario`=`usuario`.`idUsuario` WHERE idUsuario='$num' AND Rol_idRol='2')AS 'contar'";

$result_comp= mysqli_query($con,$comprobacion);
$row_comp=mysqli_fetch_assoc($result_comp);
$contador_comp=$row_comp['contar'];

if(empty($contador_comp)):
    $insercion="INSERT INTO `usuario`(`idUsuario`, `nombre_Usuario`, `apellidos_Usuario`, `email_Usuario`, `password_Usuario`, `reset`) VALUES ($num,'$nombre','$apellido','$email','$pas', '0')";
    if (mysqli_query($con,$insercion)){
        $result= mysqli_query($con,$insercion);
    
        $count = selectUsRol($con);
    
        $insercion3="";
        if($admin=='ok' && $tec==''){
            $insercion2 = "INSERT INTO `usuario_has_rol`(`id_Usuario_Rol`, `Usuario_idUsuario`, `Rol_idRol`,`activo`) VALUES ('$count','$num',1,1)";
        } if ($tec=="ok" && $admin==''){
            $insercion2 = "INSERT INTO `usuario_has_rol`(`id_Usuario_Rol`, `Usuario_idUsuario`, `Rol_idRol`,`activo`) VALUES ('$count','$num',2,1)";
        } if ($tec=="ok" && $admin=="ok"){
            $count2 = $count +1;
            $insercion2 = "INSERT INTO `usuario_has_rol`(`id_Usuario_Rol`, `Usuario_idUsuario`, `Rol_idRol`,`activo`) VALUES ('$count','$num',1,1)";
            $insercion3 = "INSERT INTO `usuario_has_rol`(`id_Usuario_Rol`, `Usuario_idUsuario`, `Rol_idRol`,`activo`) VALUES ('$count2','$num',2,1)";
            $result3= mysqli_query($con,$insercion3);
        }
        $result2= mysqli_query($con,$insercion2);
    
    } else {
        echo "Error: ".mysqli_error($con);
    }

elseif($contador_comp==1):
    if($admin<>'' && $tec==''):
        //primero verificamos que no existe un rol de administrador de ese usuario
        $contador_select=countRoles($con,$num,1);

        $count = selectUsRol($con);

        //Si existe ya un usuario, error
        if($contador_select==0):
            $insercion2 = "INSERT INTO `usuario_has_rol`(`id_Usuario_Rol`, `Usuario_idUsuario`, `Rol_idRol`,`activo`) VALUES ('$count','$num','1',1)";
        else:
            echo 'Error1: Usuario existente.';
        endif;
    elseif ($tec<>"" && $admin==''):
        //primero verificamos que no existe un rol de tecnico de ese usuario
        $contador_select=countRoles($con,$num,2);

        $count = selectUsRol($con);

        echo 'contador_select= '.$contador_select;
        echo 'count= '.$count;

        //Si existe ya un usuario, error
        if($contador_select==0):
            $insercion2 = "INSERT INTO `usuario_has_rol`(`id_Usuario_Rol`, `Usuario_idUsuario`, `Rol_idRol`,`activo`) VALUES ('$count','$num','2',1)";
            echo $insercion2;
        else:
            echo 'Error: Usuario existente.';
        endif;  
    else:
    
        echo "Error: ".mysqli_error($con);
    endif;
    $result2= mysqli_query($con,$insercion2);
else:
    echo 'Error: Usuario existente.';
endif;


?>