<?php

require('db.php');

if(isset($_POST['tabla'])):
    $tabla = $_POST['tabla'];
endif;

if(strcmp($tabla, "producto")===0):
    $sql1 ="SELECT MAX(id_Producto) as 'contar' FROM `producto`";  
else:
    $sql1 ="SELECT MAX(idProveedor) as 'contar' FROM `proveedor`";
endif;

$result1= mysqli_query($con,$sql1);
$row = mysqli_fetch_assoc($result1);
$count = $row["contar"];

$valido = 1;
$primera = true;

if(isset($_POST["Import"])){

    echo $_POST['tabla'];
    
    $filename=$_FILES["file"]["tmp_name"];		

    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ";")) !== FALSE && $valido==1){
            if($primera==TRUE){$primera=FALSE; continue;}
            else {
                $count= $count+1;

                if(strcmp($tabla, "producto")=== 0):
                    $sql = "INSERT INTO `producto`(`id_Producto`, `nombre_Producto`, `stock_0109`, `stock_Producto`, `stock_Minimo_Critico`, `stock_Alerta`, `tipo_producto`, `descripcion_Producto`, `Proveedor_idProveedor`, `precio`, `activo`)
                    VALUES ($count,'".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".$getData[9]."','".$getData[10]."')";
                else:
                    $sql = "INSERT INTO `proveedor`(`idProveedor`, `nombre_Proveedor`, `email_Proveedor`, `telefono_Proveedor`, `codigoP_Proveedor`, `actividad`)
                    VALUES ($count,'".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."')";
                endif;

                $result = mysqli_query($con, $sql);
                if(!isset($result)):
                    $valido=0;
                endif;
            }
        }
        fclose($file);	
    }
    if($valido == 1):
        if(strcmp($tabla, "producto")===0):
            echo "<script type=\"text/javascript\">
            window.location = \"../productos.php\"
            </script>"; 
        else:
            echo "<script type=\"text/javascript\">
            window.location = \"../proveedores.php\"
            </script>";
        endif;
       
    else:
        echo "Error: ".mysqli_error($con);
    endif;
     
}
mysqli_close($con);
?>