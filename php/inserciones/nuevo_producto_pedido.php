<?php
  require('../db.php');
 
  if(isset($_POST['idPedido_an'])) { 	
    $pedido = $_POST["idPedido_an"];
  }
  if(isset($_POST['producto_an'])) { 
    $prod = $_POST["producto_an"];
  }
  if(isset($_POST['stock_an'])) { 
    $cant = $_POST["stock_an"];
  }

  $sql1 ="SELECT MAX(`producto_has_pedido`.`id_Pedido_Producto`) AS 'contar' FROM `producto_has_pedido` ";
  $result1= mysqli_query($con,$sql1);
  $row = mysqli_fetch_assoc($result1);
  $count = $row["contar"];
  $count = $count +1;

  $sql2 = "INSERT INTO `producto_has_pedido`(`id_Pedido_Producto`, `Producto_id_Producto`, `Pedido_idPedido`, `cantidad_Producto_Pedido`) 
            VALUES ('$count','$prod','$pedido','$cant')";
  if(mysqli_query($con,$sql2)){
    echo '1';
  } else {
      echo "Descripcion: " . mysqli_error($con);
  }

  mysqli_close($con);
?>