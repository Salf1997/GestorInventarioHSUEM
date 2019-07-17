$(document).ready(function(){
    var datos="";
    cargarAlmacen();
      $('#add_boton').click(function(){
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿Estás seguro de que quieres añadir el almacén?',
          buttons: {
            cancelar: function () {
            },Continuar: function () {
                datos = $('#form_anadir').serialize();
                anadirAlmacen(datos);
              }
          }
        });
      });
      $('#delete_boton').click(function(){
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿Estás seguro de que quieres borrar el almacén y todos los elementos que se encuentran en él?',
          buttons: {
            cancelar: function () {},
            Continuar: function () {
              borrarAlmacen();
            }
          }
        });
      });
      $('#mod_boton').click(function(){
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿Estás seguro de que quieres modificar el almacén?',
          buttons: {
            cancelar: function () {},
            Continuar: function () {
              datos = $('#form_modificar').serialize();
              modificarAlmacen(datos);
            }
          }
        });
      });
      
  });
  function a_onClick(idAlmacen, nombre, localizacion) { 
    $('#identificador_mod').val(idAlmacen);
    $('#nombre_mod').val(nombre);
    $('#loc_mod').val(localizacion);
  }
  
  $(document).on('keyup', '#busqueda', function(){
    var valor = $(this).val();
      buscarAlmacen(valor);
  });
  
  function buscarAlmacen(consulta) {
    $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_almacenes.php',
      dataType: 'html',
      data: 'buscar='+consulta,
      }).done(function(respuesta){
        $('#cuerpo_tabla').html(respuesta);
      }).fail(function(respuesta){
        $.alert({
          columnClass:'col-md-6 col-md-offset-3',
          icon: 'fa fa-warning',
          title: '¡Error!',
          content: respuesta,
        });
      });
  }
  function cargarAlmacen(){
    $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_almacenes.php',
        success:function(html){
            $('#cuerpo_tabla').html(html);
        }
    });
  }

  function anadirAlmacen(datos){
    $.ajax({
        type: 'POST',
        url: 'php/inserciones/nuevo_almacen.php',
        data: datos,
        success:function(html){
          if (html == 0){
            $('#nuevo_almacen').modal('toggle');
            $('#cuerpo_tabla').empty();
            cargarAlmacen(); 
          } else {
            $.alert({
              columnClass:'col-md-6 col-md-offset-3',
              icon: 'fa fa-warning',
              title: '¡Error!',
              content: 'Ya existe un almacén con ese nombre.',
            });
          }
        }
    });
  }
  function borrarAlmacen(){
    var almacen = $('#identificador_mod').val();
    var fecha = fechaHoy();
    var datos1 = "identificador_mod="+almacen+"&borrar=1"+"&fecha='"+fecha+"'";
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_almacen.php',
      data: datos1,
      success:function(html){
        if (html == 1){
          $('#modal_modificar').modal('toggle');
          $('#cuerpo_tabla').empty();
          cargarAlmacen();
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al borrar el almacen.',
          });
        }
      }
    });
  }
  function modificarAlmacen(datos){
    var prod = $('#identificador').val();
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_almacen.php',
      data: datos,
      success:function(html){
        if (html == 1){
          $('#modal_modificar').modal('toggle');
          $('#cuerpo_tabla').empty();
          cargarAlmacen();
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al borrar el almacen.',
          });
        }
      }
    });
  }

  function fechaHoy(){
    var d = new Date();
    var year = d.getFullYear();
    var mes = d.getMonth();
    mes +=1;
    var dia = d.getDate();
    if(mes<10){
      mes ='0'+mes;
    }
    datos = year+'-'+mes+'-'+dia;
    return datos;
  }