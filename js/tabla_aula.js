$(document).ready(function(){
    cargarTabla();
    $('#an_boton').click(function(){
      if(validar($('#nombre_an').val())==1 && validar($('#tipo_an').val())==1){
        $.confirm({
          title: 'Nuevo producto',
          content: '¿Estás seguro de que quieres añadir la Sala "'+$('#nombre_an').val()+'"?',
          buttons: {
            cancelar: function () {}, 
            Continuar: function () {
              datos = $('#form_anadir').serialize();
              anadirSala(datos);
            }
          }
        });

      }else{
        $.alert({
          icon: 'fa fa-warning',
          title: '¡Error!',
          content: 'Alguno de los campos introducidos están vacíos o son incorrectos.',
        });
      } 
    });

    $('#mod_boton').click(function(){
      if(validar($('#nombre_mod').val())==1 && validar($('#tipo_mod').val())==1){
        $.confirm({
          title: 'Nuevo producto',
          content: '¿Estás seguro de que quieres modificar la Sala "'+$('#nombre_mod').val()+'"?',
          buttons: {
            cancelar: function () {}, 
            Continuar: function () {
              datos = $('#form_modificar').serialize();
              modificarSala(datos);
            }
          }
        });

      }else{
        $.alert({
          icon: 'fa fa-warning',
          title: '¡Error!',
          content: 'Alguno de los campos introducidos están vacíos o son incorrectos.',
        });
      } 
    });
});

function cargarTabla(actividad){
  $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_aula.php',
      data: "activo="+actividad,
      success:function(html){
          $('#cuerpo_tabla').html(html);
      }
  });
}

function a_onClick(id, nombre, tipo){
  $('#id_mod').val(id);
  $('#nombre_mod').val(nombre);
  $('#tipo_mod').val(tipo);
}

$(document).on('keyup', '#busqueda', function(){
  var valor = $(this).val();
  $("#cuerpo_tabla").empty();
  buscarSala(valor);
});

function buscarSala(consulta) {
  $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_aula.php',
      data: 'consulta='+consulta,
  }).done(function(respuesta){
      $('#cuerpo_tabla').html(respuesta);
  }).fail(function(){
      console.log('error');
  });
}

function validar(campo){
  var valido;
  if (campo == "" || campo.length == 0 || campo == null)
  {
    valido = 0;
  } else {
    valido = 1;
  }
  return valido;
}

function anadirSala(datos){
  $.ajax({
    type: 'POST',
    url: 'php/inserciones/nueva_aula.php',
    data: datos,
    success:function(html){
        console.log(html);
      if (html==1){
        $('#nueva_aula').modal('toggle');
        $('#cuerpo_tabla').empty();
        cargarTabla(0);          
      } else {
        $.alert({
          columnClass:'col-md-6 col-md-offset-3',
          icon: 'fa fa-warning',
          title: '¡Error!',
          content: 'Ha ocurrido un error al añadir la sala. Verifica la información escrita.',
        });
      }
    }
  });
}

function modificarSala(datos){
  $.ajax({
    type: 'POST',
    url: 'php/editar/editar_aula.php',
    data: datos,
    success:function(html){
        console.log(html);
      if (html==1){
        $('#modal_modificar').modal('toggle');
        $('#cuerpo_tabla').empty();
        cargarTabla(0);          
      } else {
        $.alert({
          columnClass:'col-md-6 col-md-offset-3',
          icon: 'fa fa-warning',
          title: '¡Error!',
          content: 'Ha ocurrido un error al modificar la sala. Verifica la información escrita.',
        });
      }
    }
  });
}