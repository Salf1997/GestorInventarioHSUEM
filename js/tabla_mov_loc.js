$(document).ready(function(){
    cargarTabla();
});

$(document).on('keyup', '#busqueda', function(){
  var valor = $(this).val();
  $("#cuerpo_tabla").empty();
  buscarMovimiento(valor);
});

function cargarTabla(){
  $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_mov_loc.php',
      success:function(html){
          $('#cuerpo_tabla').html(html);
      }
  });
}

function buscarMovimiento(consulta) {
  $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_mov_loc.php',
      data: 'consulta='+consulta,
  }).done(function(respuesta){
      $('#cuerpo_tabla').html(respuesta);
  }).fail(function(){
      console.log('error');
  });
}

