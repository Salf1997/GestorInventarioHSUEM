<?php
require ('db.php');

function find_pass($con,$usuario,$pass){
    $queryCon='SELECT password_Usuario FROM usuario WHERE idUsuario="'.$usuario.'" LIMIT 1';
    $respuesta = mysqli_query($con,$queryCon);
    if(!$respuesta){
        echo json_encode(array('error'=> 'FALLANDO EN ENCONTRAR PASSWORD'));
    } if($user=mysqli_fetch_assoc($respuesta)) {
        return $user;
    }else{
        return false;
    }
}

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
    $con->set_charset('utf8');

    $usuario = $con->real_escape_string($_POST['usuario']);
    $pass = $con->real_escape_string($_POST['password']);
    $rol=$con->real_escape_string($_POST['rol']);

    $encontrado = find_pass($con,$usuario,$pass);
    if ($encontrado){
        if(password_verify($pass, $encontrado['password_Usuario'])){
            $query='SELECT `idUsuario`, `nombre_Usuario`, `apellidos_Usuario`, `email_Usuario`, `rol`.`idRol`, `rol`.`nombre_Rol`, `reset`
            FROM `usuario`
            JOIN `usuario_has_rol` ON `usuario_has_rol`.Usuario_idUsuario=`usuario`.`idUsuario`
            JOIN `rol` ON `rol`.`idRol` = `usuario_has_rol`.`Rol_idRol`
            WHERE `idUsuario`="'.$usuario.'"
            AND `password_Usuario` = "'.$encontrado['password_Usuario'].'"
            AND `rol`.`idRol`="'.$rol.'" AND `usuario_has_rol`.`activo`="1"';

            $nuevaconsulta = sprintf($query,$usuario,$encontrado['password_Usuario'],$rol);
        
            if(mysqli_query($con,$query)){      
                $resultado=mysqli_query($con,$query);
                if(mysqli_num_rows($resultado)>0):
                    $rows=mysqli_fetch_assoc($resultado);
                    session_start();
                    $_SESSION['idUsuario']=$rows['idUsuario'];
                    $_SESSION['nombre']=$rows['nombre_Usuario'];
                    $_SESSION['apellidos']=$rows['apellidos_Usuario'];
                    $_SESSION['email']=$rows['email_Usuario'];
                    $_SESSION['rol']=$rows['nombre_Rol'];
                    $_SESSION['idrol']=$rows['idRol'];
                    $_SESSION['reset']=$rows['reset'];
                    echo json_encode(array('tipo'=> $rows['idRol']));
                else:
                    echo json_encode(array('tipo'=> 'Datos de ingreso no válidos, inténtelo de nuevo.')); 
                endif;
            } else{
                echo $query;
            }
        } else{
            echo json_encode(array('tipo'=> 'Datos de ingreso no válidos, inténtelo de nuevo.')); 
        }
    }else{
        echo json_encode(array('tipo'=> 'Datos de ingreso no válidos, inténtelo de nuevo.')); 
    }
    $con->close();
}
?>

