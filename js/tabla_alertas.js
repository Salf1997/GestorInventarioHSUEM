$(document).ready(function(){
    cargarTabla();
});

function cargarTabla(){
    $.ajax({
        type: 'POST',
        url: 'php/tablas/consultar_warnings.php',
        data: "activo=1&tabla='si'",
        success:function(data){
            $('#cuerpo_tabla').html(data);
       }
    });
}

function a_onClick(id, nombre, stock, stock_minimo, stock_alerta, descripcion, tipo){

    $('#idproducto_mod').val(id);
    $('#nombre_mod').val(nombre);
    $('#stock_mod').val(stock);
    $('#descripcion_mod').val(descripcion);
    $('#stock_minimo_mod').val(stock_minimo);
    $('#stock_alerta_mod').val(stock_alerta);
    $('#tipo_mod').val(tipo);
}

$(document).on('keyup', '#busqueda', function(){
    var valor = $(this).val();
    buscarProducto(valor);
});

function buscarProducto(consulta) {
    $.ajax({
        type: 'POST',
        url: 'php/tablas/consultar_warnings.php',
        data: "activo=1&tabla='si'&consulta='"+consulta+"'",
    }).done(function(respuesta){
        $('#cuerpo_tabla').html(respuesta);
    }).fail(function(){
        console.log('error');
    });
}