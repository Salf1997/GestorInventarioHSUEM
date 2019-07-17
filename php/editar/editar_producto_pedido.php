<?php
  require('../db.php');
 
  if(isset($_POST['idPedido_mod'])) { 	
    $id = $_POST["idPedido_mod"];
  }
  if(isset($_POST['identificador_mod'])) { 
    $idprod = $_POST["identificador_mod"];
  }
  if(isset($_POST['producto_mod'])) { 
    $producto = $_POST["producto_mod"];
  }
  if(isset($_POST['stock_mod'])) { 
    $cant = $_POST["stock_mod"];
  }
  $exito = 1;
  if(isset($_POST['completado'])):

    $sql_count="SELECT COUNT(id_Pedido_Producto) as 'contar' FROM `producto_has_pedido` WHERE `Pedido_idPedido` = '$id'";
    $result = mysqli_query($con,$sql_count);
    $row = mysqli_fetch_assoc($result);
    $count = $row["contar"];
    if($count<>0):
      $fecha = stripslashes($_POST['fecha']);
      $sql2 = "UPDATE `pedido` SET  `fecha_Completado`=$fecha,`Completado`='1' WHERE `idPedido` = '$id'";
          if(mysqli_query($con,$sql2)):
            echo $exito;
          else:
            $exito = 0;
            echo $exito;
          endif;
    else:
      $exito = 0;
      echo $exito;
    endif;
  elseif(isset($_POST['borrarTodo'])): 
    $sql1 = "DELETE FROM `producto_has_pedido` WHERE `Pedido_idPedido` = '$id'";
    $sql2 = "DELETE FROM `pedido` WHERE `idPedido` = '$id'";
    if(mysqli_query($con,$sql1)):
      if(mysqli_query($con,$sql2)):
        echo $exito;
      else:
        $exito = 0;
        echo $exito;
      endif;
    else:
      $exito = 0;
      echo $exito;
    endif;
  else:
    if(isset($_POST['borrar'])):
        $sql1 = "DELETE FROM `producto_has_pedido` WHERE `Producto_id_Producto`= '$idprod' AND `Pedido_idPedido` = '$id'";
        if(mysqli_query($con,$sql1)):
          echo $exito;
        else:
          $exito = 0;
          echo $exito;
        endif;
    else:
        $sql2 = "UPDATE `producto_has_pedido` SET  `cantidad_Producto_Pedido`= '$cant' WHERE `Producto_id_Producto`= '$idprod' AND `Pedido_idPedido` = '$id'";
        if(mysqli_query($con,$sql2)):
          echo $exito;
        else:
          $exito = 0;
          echo $exito;
        endif;
    endif;
  endif;
  mysqli_close($con);
?>