cargarTabla(1);

$(document).ready(function(){
    $("#act1").change(function(){
        if($(this).prop("checked") == true){
            $("#cuerpo_tabla").empty();
            cargarTabla(0);
        }else{
            $("#cuerpo_tabla").empty();
            cargarTabla(1);
        }
    });
    $('#add_boton').click(function(){
        var nombre = $('#name').val();
        if(validar(nombre)==1 && validar($('#mail').val())==1){
          $.confirm({
            title: 'Nuevo producto',
            content: '¿Estás seguro de que quieres añadir el producto?',
            buttons: {
                cancelar: function () {}, 
                Continuar: function () {
                  datos = $('#form_anadir').serialize();
                  anadirProveedor(datos);
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
        if( validar($('#nombre_mod').val())==1 && validar($('#mail_mod').val())==1){
          $.confirm({
            title: '¿Estás seguro?',
            content: '¿Estás seguro de que quieres modificar el producto?',
            buttons: {
              cancelar: function () {},
              Continuar: function () {
                datos = $('#form_modificar').serialize();
                modificarProveedor(datos);
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
        buscarProveedor(valor, 0);
    }else{
        $("#cuerpo_tabla").empty();
        buscarProveedor(valor,1);
    }
});

function a_onClick(id, nombre, email, telefono, codigo, activo) {
    $('#id_mod').val(id);
    $('#nombre_mod').val(nombre);
    $('#mail_mod').val(email);
    $('#telefono_mod').val(telefono);
    $('#cp_mod').val(codigo);
    if(activo==0){
        $("#actividad").val("0");
    } else {
        $("#actividad").val("1");
    }
}

function cargarTabla(actividad){
    var idAula=$('#nombreAula').attr("valor");
    $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_proveedores.php',
        data: "activo="+actividad,
        success:function(html){
            $('#cuerpo_tabla').html(html);
        }
    });

  }

function buscarProveedor(consulta, actividad) {
    $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_proveedores.php',
        data: 'consulta='+consulta+"&activo="+actividad,
        }).done(function(respuesta){
            $('#cuerpo_tabla').html(respuesta);
        }).fail(function(){
            console.log('error');
        });
}

function anadirProveedor(datos){
    $.ajax({
        type: 'POST',
        url: 'php/inserciones/nuevo_proveedor.php',
        data: datos,
        success:function(html){
          if (html==1){
            $('#nuevo_prov').modal('toggle');
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
              content: 'Ha ocurrido un error al añadir el proveedor.',
            });
          }
        }
    });
}

function modificarProveedor(datos){
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_proveedor.php',
      data: datos,
      success:function(html){
          console.log(html);
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

function validar(nombre){
  var valido;
  if (nombre == "" || nombre.length == 0 || nombre == null){
    valido = 0;
  } else {
    valido = 1;
  }
  return valido;
}