

<?php 
    require('db.php');

    if(isset($_POST['tabla'])):
        $tabla=$_POST['tabla'];
        $sql="TRUNCATE TABLE `$tabla`";

        $exito = 1;


        if(mysqli_query($con,$sql)):
            if(strpos($tabla,"producto")===true):
                $sql2="TRUNCATE TABLE `movimiento_localizacion`";
                $sql3="TRUNCATE TABLE `movimiento_cantidad`";
                $sql4="TRUNCATE TABLE `balda_has_producto`";
                $sql5="TRUNCATE TABLE `producto_has_aula`";
                if(mysqli_query($con,$sql2)):
                    if(mysqli_query($con,$sql3)):
                        if(mysqli_query($con,$sql4)):
                            if(mysqli_query($con,$sql5)):
                                echo $exito;
                            else:
                                echo mysqli_error($con);
                            endif;
                        else:
                            echo mysqli_error($con);
                        endif;
                    else:
                        echo mysqli_error($con);
                    endif;                                
                else:
                    echo mysqli_error($con);
                endif;
            else:
                echo $exito;
            endif;

        else:
            echo mysqli_error($con);
        endif;
    else:
        echo "La tabla no existe.";
    endif;
    
    mysqli_close($con);
?>