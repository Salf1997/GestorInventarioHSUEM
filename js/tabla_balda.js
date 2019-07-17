$(document).ready(function(){
    var datos="";
    cargarBaldas();
      $('#add_boton').click(function(){
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿Estás seguro de que quieres añadir esta balda?',
          buttons: {
            cancelar: function () {
            },Continuar: function () {
                datos = $('#form_anadir').serialize();
                anadirBalda(datos);
              }
          }
        });
      });
      $('#delete_boton').click(function(){
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿Estás seguro de que quieres borrar la balda y todos los elementos que se encuentran en ella?',
          buttons: {
            cancelar: function () {},
            Continuar: function () {
              borrarBalda();
            }
          }
        });
      });
      $('#mod_boton').click(function(){
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿Estás seguro de que quieres modificar la balda?',
          buttons: {
            cancelar: function () {},
            Continuar: function () {
              datos = $('#form_modificar').serialize();
              modificarBalda(datos);
            }
          }
        });
      });
      
  });
  function a_onClick(idBalda, nombre) {    
    $('#identificador_mod').val(idBalda);
    $('#nombre_mod').val(nombre);
  }
  
  $(document).on('keyup', '#busqueda', function(){
    var valor = $(this).val();
      buscarBalda(valor);
  });
  
  function buscarBalda(consulta) {
    var id = $('#id_Almacen').attr('valor');
    $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_baldas.php',
      dataType: 'html',
      data: 'buscar='+consulta+'&idAlmacen='+id,
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
  function cargarBaldas(){
    var id = $('#id_Almacen').attr('valor');
    $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_baldas.php',
        data: 'idAlmacen='+id,
        success:function(html){
            $('#cuerpo_tabla').html(html);
        }
    });
  }

  function anadirBalda(datos){
    var id = $('#id_Almacen').attr('valor');
    $.ajax({
        type: 'POST',
        url: 'php/inserciones/nueva_balda.php',
        data: datos+"&idAlmacen="+id,
        success:function(html){
          if (html == 0){
            $('#nueva_balda').modal('toggle');
            $('#cuerpo_tabla').empty();
            cargarBaldas(); 
          } else {
            $.alert({
              columnClass:'col-md-6 col-md-offset-3',
              icon: 'fa fa-warning',
              title: '¡Error!',
              content: 'Ya existe una balda con ese nombre.',
            });
          }
        }
    });
  }

  
  function borrarBalda(){
    var almacen = $('#identificador_mod').val();
    var id = $('#id_Almacen').attr('valor');
    var fecha = fechaHoy();
    var datos1 = "identificador_mod="+almacen+"&borrar=1&idAlmacen="+id+"&fecha='"+fecha+"'";
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_baldas.php',
      data: datos1,
      success:function(html){
        if (html == 1){
          $('#modal_modificar').modal('toggle');
          $('#cuerpo_tabla').empty();
          cargarBaldas();
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al borrar la balda.',
          });
        }
      }
    });
  }
  function modificarBalda(datos){
    var id = $('#id_Almacen').attr('valor');
    
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_baldas.php',
      data: datos+'&idAlmacen='+id,
      success:function(html){
        if (html == 1){
          $('#modal_modificar').modal('toggle');
          $('#cuerpo_tabla').empty();
          cargarBaldas();
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al modificar la balda.',
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