$(document).ready(function(){
    cargarTabla();

    $('#mod_boton').click(function(){
        var stock = parseFloat($('#stock_mod').val());
        var stock_critico = parseFloat($('#stock_alerta_mod').val());
        var stock_alerta = parseFloat($('#stock_minimo_mod').val());
        var nombre = $('#nombre_mod').val();
        var tipo = $('#tipo_mod').val();
        if(validar(stock)==1 && validar(stock_critico)==1 && validar(stock_alerta)==1 && validarCampos(nombre)==1 && validarCampos(tipo)==1){
          $.confirm({
            title: '¿Estás seguro?',
            content: '¿Estás seguro de que quieres modificar el producto?',
            buttons: {
              cancelar: function () {},
              Continuar: function () {
                datos = $('#form_modificar').serialize();
                modificarProductos(datos);
              }
            }
          });
        } else {
          $.alert({
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Alguno de los campos introducidos están vacíos o son incorrectos.',
          });
        }
        
      }); 
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

function modificarProductos(datos){
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_producto.php',
      data: datos,
      success:function(html){
        if (html==1){
            $('#modal_modificar').modal('toggle');
            $('#cuerpo_tabla').empty();
            cargarTabla();
        } else {
            console.log(html);
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al modificar el producto.',
          });
        }
      }
    });
}

function validar(stock){ 
    var valido;
    if(stock<=0 || isNaN(stock)){
      valido = 0;
    } else {
      valido = 1;
    }
    return valido;
  }
  
  function validarCampos(campo){
    var valido;
    if (campo == "" || campo.length == 0 || campo == null)
    {
      valido = 0;
    } else {
      valido = 1;
    }
    return valido;
  }