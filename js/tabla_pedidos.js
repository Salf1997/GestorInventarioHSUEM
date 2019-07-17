$(document).ready(function(){
  var datos="";
  cargarPedidos();
  $( "#titulacion_tipo" ).change(function() {
    var tipo_titulacion = $('#titulacion_tipo option:selected').val();
	  cursos(tipo_titulacion);
  });
  $( "#titulacion_tipo_mod" ).change(function() {
    var tipo_titulacion =$('#titulacion_tipo_mod option:selected').val();
	  cursos(tipo_titulacion);
  });
  $( "#nombre_tit_mod_desp" ).change(function() {
    var titulacion = $('#nombre_tit_mod_desp option:selected').attr('nombre');
    var curso =$('#nombre_tit_mod_desp option:selected').attr('curso');
    $("#nombre_tit_mod").val(titulacion);
    $("#num_cursos_mod").val(curso);
  });
  $( "#titulacion" ).change(function() {
	  titulacion();
	});
  $('#add_boton').click(function(){
      datos = $('#form_anadir').serialize();
      anadirPedido(datos);
  });
  $('#add_curso_boton').click(function(){
    datos = $('#form_anadir_curso').serialize();
    anadircurso(datos);
  });
  $('#delete_curso_boton').click(function(){
    datos = "borrar='si'"+$('#form_modificar_curso').serialize();
    modCurso(datos);
  });
  $('#mod_curso_boton').click(function(){
    datos = $('#form_modificar_curso').serialize();
    console.log(datos);
    modCurso(datos);
  });
});
  
  $(document).on('keyup', '#busqueda', function(){
    var valor = $(this).val();
      buscarPedidos(valor);
  });

  function modCurso(datos){
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_curso.php',
      dataType:'html',
      data: datos
    }).done(function(respuesta){
      console.log(respuesta);
      $('#mod_curso').modal('toggle');
    });
  }

  function anadircurso(datos){
    $.ajax({
      type: 'POST',
      url: 'php/inserciones/nuevo_curso.php',
      dataType:'html',
      data: datos
    }).done(function(respuesta){
      $('#nuevo_curso').modal('toggle');
    });
  }
  
  function buscarPedidos(consulta) {
    $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_pedidos.php',
      dataType: 'html',
      data: 'buscar='+consulta,
      }).done(function(respuesta){
        $('#cuerpo_tabla').html(respuesta);
      });
  }
  function cargarPedidos(){
    $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_pedidos.php',
        success:function(html){
            $('#cuerpo_tabla').html(html);
        }, error:function(html){
          console.log(html);
        }
    });
  }
 
  function anadirPedido(datos){
    var idUsuario=$("#idUsuario_1").attr('valor');
    var fecha = fechaHoy();
    datos = datos+'&fecha='+fecha+'&Usuario='+idUsuario;
    console.log(datos);
    $.ajax({
      type: 'POST',
      url: 'php/inserciones/nuevo_pedido.php',
      dataType:'html',
      data: datos})
      .done(function(respuesta){
        console.log(respuesta);
        $('#nuevo_pedido').modal('toggle');
        $('#cuerpo_tabla').empty();
        cargarPedidos();
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

  function cursos(tipo){
    
    datos="tipo="+tipo;
    $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_intermedia_pedidos.php',
      dataType:'html',
      data: datos
    }).done(function(respuesta){
        $('#titulacion').html(respuesta);
        $('#nombre_tit_mod_desp').html(respuesta);
    });
  }


  function titulacion(){
    var curso = $('#titulacion option:selected').attr('curso');
    var option="<option disabled selected>Elige un curso</option>";
    for(var i=0; i<curso;i++){
      j = i+1;
      option+="<option value='"+j+"'>"+j+"</option>";
    }
    $('#titulacion_curso').html(option);
  }