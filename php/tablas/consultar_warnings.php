<?php
    function compara($stock, $stockA, $stockMin){
        $res=0;
        if ($stockA>=$stock):
            $res=1;
        elseif ($stockMin>=$stock):
            $res=1;
        endif;

        return $res;
    }

    function contador($contador,$stock, $stockA, $stockMin){
        if ($stockA>=$stock):
            $contador=$contador+1;
        elseif ($stockMin>=$stock):
            $contador=$contador+1;
        endif;

        return $contador;
    }

    function comparaAlertas($stock, $stockA, $stockMin){
        $res="";
        if ($stockA>=$stock):
            $res='<span class="yellow">';
        endif;
        if ($stockMin>=$stock):
            $res='<span class="red">'; 
        endif;

        return $res;
    }



    require('../db.php');
    
    $activo=$_POST['activo'];

    if(!isset($_POST['tabla'])):
        $sel_query="SELECT `id_Producto`, `nombre_Producto`, `stock_Producto`, `stock_Minimo_Critico`, `stock_Alerta` FROM producto WHERE activo=$activo";

        $result= mysqli_query($con,$sel_query);
        
        $warning="";
        $contador=0;
        $res=0;
        $mostrar = 0;
            if($result):
                if(mysqli_num_rows($result)>0):
                    if(isset($_POST['warnings']) && $mostrar<19):
                        echo '<div class="d-flex align-items-center"><div class="details d-flex"><div class="text">';
                        echo '<strong><i class="fa fa-warning"></i> Solo se muestra un máximo de 20 alertas. Para consultar las alertas, hágalo en la sección de Productos.</strong>';
                        echo '</div></div></div>';
                    endif;
                        while($row = mysqli_fetch_assoc($result)){	
                            $stock=$row['stock_Producto'];
                            $stockMin=$row['stock_Minimo_Critico'];
                            $stockA=$row['stock_Alerta'];
                            
                            $res = compara($stock,$stockA,$stockMin);
                            $contador = contador($contador,$stock,$stockA,$stockMin);
                            
                            if($res==1):
                                if(isset($_POST['warnings']) && $mostrar<19):
                                    echo '<div class="d-flex align-items-center"><div class="details d-flex">';
                                    echo '<div class="text"><span class="info">El producto "'.$row["nombre_Producto"].'" con ID('.$row['id_Producto'].') solo tiene '.$row["stock_Producto"].' unidades en stock.</span></div>';
                                    echo '</div></div>';
                                    $mostrar=$mostrar+1;
                                endif;
                            endif;
                        }
                        if(!isset($_POST['warnings'])):
                            echo $contador;
                        endif;
                else:
                    echo '<div class="d-flex align-items-center"><div class="details d-flex">';
                    echo "<div class='text'><span class='info'>No hay ninguna alerta.</span></div>";
                    echo '</div></div>';
                endif;
            else:
                
                echo "Error 1: ".mysqli_error($con);
            endif;
        else:
            $sel_query="SELECT `id_Producto`, `nombre_Producto`, `stock_0109`, `stock_Producto`, `stock_Minimo_Critico`, `stock_Alerta`, `tipo_producto`, `descripcion_Producto`, `activo` FROM producto";
            $result= mysqli_query($con,$sel_query);
            if($result):
                if(mysqli_num_rows($result)>0):
                    while($row = mysqli_fetch_assoc($result)){	
                        $stock=$row['stock_Producto'];
                        $stockMin=$row['stock_Minimo_Critico'];
                        $stockA=$row['stock_Alerta'];
                        $res = compara($stock,$stockA,$stockMin);
                        
                        if($res==1):
                            $color = comparaAlertas($stock, $stockA, $stockMin);
                            echo '<tr id="'.$row['id_Producto'].'">';
                            echo '<td>'.$color.$row["id_Producto"].'</span></td>';
                            echo '<td>'.$row["nombre_Producto"].'</td>';
                            echo '<td>'.$row["stock_0109"].'</td>';
                            echo '<td>'.$row["stock_Producto"].'</td>';
                            echo '<td>'.$row["tipo_producto"].'</td>';
                            echo '<td>'.$row["descripcion_Producto"].'</td>';
                            echo '<td><a onClick="a_onClick('.$row["id_Producto"].',`'.$row["nombre_Producto"].'`,`'.$row["stock_Producto"].'`,`'.$row["stock_Minimo_Critico"].'`,`'.$row["stock_Alerta"].'`,`'.$row["descripcion_Producto"].'`,`'.$row["tipo_producto"].'`)" data-toggle="modal" data-target="#modal_modificar" class="btn btn-template-outlined"><i class="fa fa-edit"></i></a></td></tr>';   	

                        endif;                        
                    }
                else:
                    echo "No hay elementos con estas características.";
                endif;
            else:
                echo mysqli_error($con);
            endif;
        endif;

	mysqli_close($con);	
?>