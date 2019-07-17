<?php
  require('../db.php');

  if(isset($_POST['producto'])) { 
    $prod = $_POST["producto"];
  }
  if(isset($_POST['identificador_mod'])){
    $prod = $_POST["identificador_mod"];
  }
  if(isset($_POST['stock'])) { 
    $cant = $_POST["stock"];
  }

  if(isset($_POST['stock_resta'])){
    $cant=$_POST['stock_resta'];
  }

  if(isset($_POST['idBalda_an'])){
    $balda =$_POST['idBalda_an'];
  } else {
    $balda="";
  }

  $validoBalda=0;
  $validoProd=0;

  if(isset($_POST['balda'])):
    $sql_update1 = "SELECT `cantidad_Producto_Baldas` FROM `balda_has_producto` WHERE `Balda_idBalda`='$balda' AND `Producto_id_Producto`= '$prod' ";
    $result= mysqli_query($con,$sql_update1);
    $row = mysqli_fetch_assoc($result);
    $cantidadB = $row["cantidad_Producto_Baldas"];

    $nuevaCantidadB= intval($cantidadB)-intval($cant);

    $sql_update3 ="UPDATE `balda_has_producto` SET `cantidad_Producto_Baldas`=$nuevaCantidadB WHERE `Balda_idBalda`= '$balda' AND `Producto_id_Producto`='$prod' ";

    if (mysqli_query($con,$sql_update3)):
      $validoBalda=1;
    else:
      echo mysqli_error($con);
    endif;

  endif;

  if(isset($_POST['baldasuma'])):
    $sql_update1 = "SELECT `cantidad_Producto_Baldas` FROM `balda_has_producto` WHERE `Balda_idBalda`='$balda' AND `Producto_id_Producto`= '$prod' ";
    $result= mysqli_query($con,$sql_update1);
    $row = mysqli_fetch_assoc($result);
    $cantidadB = $row["cantidad_Producto_Baldas"];

    $nuevaCantidadB= intval($cantidadB)+intval($cant);

    $sql_update3 ="UPDATE `balda_has_producto` SET `cantidad_Producto_Baldas`=$nuevaCantidadB WHERE `Balda_idBalda`= '$balda' AND `Producto_id_Producto`='$prod' ";

    if (mysqli_query($con,$sql_update3)):
      $validoBalda=1;
    else:
      echo mysqli_error($con);
    endif;
  endif;
  
  if (isset($_POST['prod'])):
    $sql_update2 = "SELECT `stock_Producto` FROM `producto` WHERE `id_Producto`= '$prod' ";
    $result2= mysqli_query($con,$sql_update2);
    $row2 = mysqli_fetch_assoc($result2);
    $cantidadP = $row2["stock_Producto"];

    $nuevaCantidadP= intval($cantidadP)-intval($cant);


    $sql_update4 ="UPDATE `producto` SET `stock_Producto`=$nuevaCantidadP WHERE `id_Producto`='$prod' ";

    if (mysqli_query($con,$sql_update4)):
      $validoProd=1;
    else:
      echo mysqli_error($con);
    endif;

  endif;

  if($validoBalda==1):
    echo "validoBalda= ".$validoBalda;
  elseif($validoProd==1):
    echo "validoProd= ".$validoProd;
  endif;

  mysqli_close($con);
?>