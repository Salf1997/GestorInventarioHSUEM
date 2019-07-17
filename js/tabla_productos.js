$(document).ready(function(){
    cargarTabla(1);
    $("#act1").change(function(){
        if($(this).prop("checked") == true){
            $("#cuerpo_tabla").empty();
            cargarTabla(0);
        }else{
            $("#cuerpo_tabla").empty();
            cargarTabla(1);
        }
    });

    $('#modal_nuevo').click(function(){
      proveedores();
    });

    $('#alertas_boton').click(function(){
      window.location.assign("alertas.php");
    });

    $('#add_boton').click(function(){
      var stock_0109 = parseFloat($('#stock_0109').val());
      var stock = parseFloat($('#stock').val());
      var stock_critico = parseFloat($('#stock_alerta').val());
      var stock_alerta = parseFloat($('#stock_critico').val());
      var precio = parseFloat($('#precio').val());
      var nombre = $('#nombre').val();
      var tipo = $('#tipo').val();

      if(validar(stock_0109)==1 && validar(stock)==1 && validar(stock_critico)==1 && validar(stock_alerta)==1 && validar(precio)
          && validarCampos(nombre)==1 && validarCampos(tipo)==1){
        $.confirm({
          title: 'Nuevo producto',
          content: '¿Estás seguro de que quieres añadir el producto?',
          buttons: {
              cancelar: function () {}, 
              Continuar: function () {
                datos = $('#form_anadir').serialize();
                anadirProducto(datos);
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

$(document).on('keyup', '#busqueda', function(){
    var valor = $(this).val();
    if($('#act1').prop("checked") == true){
        $("#cuerpo_tabla").empty();
        buscarProducto(valor, 0);
    }else{
        $("#cuerpo_tabla").empty();
        buscarProducto(valor,1);
    }
});



function a_onClick(id, nombre, stock, stock_minimo, stock_alerta, descripcion, tipo,activo){

    $('#idproducto_mod').val(id);
    $('#nombre_mod').val(nombre);
    $('#stock_mod').val(stock);
    $('#descripcion_mod').val(descripcion);
    $('#stock_minimo_mod').val(stock_minimo);
    $('#stock_alerta_mod').val(stock_alerta);
    $('#tipo_mod').val(tipo);
    if(activo=='1'){
        $('#actividad').val('1');
    } else{
        $('#actividad').val('0');
    }
}

function cargarTabla(actividad){
    $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_productos.php',
        data: "activo="+actividad,
        success:function(html){
            $('#cuerpo_tabla').html(html);
        }
    });
  }

function buscarProducto(consulta, actividad) {
    $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_productos.php',
        data: 'consulta='+consulta+'&activo='+actividad,
    }).done(function(respuesta){
        $('#cuerpo_tabla').html(respuesta);
    }).fail(function(){
        console.log('error');
    });
}

function anadirProducto(datos){
    $.ajax({
        type: 'POST',
        url: 'php/inserciones/nuevo_producto.php',
        data: datos,
        success:function(html){
            console.log(html);
          if (html==1){
            $('#nuevo_prod').modal('toggle');
            $('#cuerpo_tabla').empty();
            if($(this).prop("checked") == true){
                cargarTabla(0);
              }else{
                cargarTabla(1);
              }            
          } else {
            $.alert({
              columnClass:'col-md-6 col-md-offset-3',
              icon: 'fa fa-warning',
              title: '¡Error!',
              content: 'Ha ocurrido un error al añadir el producto. Verifica la información escrita.',
            });
          }
        }
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
          if($(this).prop("checked") == true){
            cargarTabla(0);
          }else{
            cargarTabla(1);
          }
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al modificar el producto de esta balda.',
          });
        }
      }
    });
}

function proveedores(){
  $.ajax({
    type: 'POST',
    url: 'php/tablas/tabla_proveedores.php',
    data: "info='Si'",
    success:function(html){
        $('#prov').html(html);
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