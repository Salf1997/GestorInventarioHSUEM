

<?php 
    require('db.php');

    if(isset($_POST['tabla'])):
        $tabla=$_POST['tabla'];
        $sql="TRUNCATE TABLE `$tabla`";

        $exito = 1;

        if(mysqli_query($con,$sql)):
            echo $exito;
        else:
            echo mysqli_error($con);
        endif;
    else:
        echo "La tabla no existe.";
    endif;
    
    mysqli_close($con);
?>