$(document).ready(function(){
    var datos="";
    cargarInformes();
    $('#add_boton').click(function(){
        datos = $('#form_anadir').serialize();
        anadirInf(datos);
      /*$('#mod_boton').click(function(){
        $.confirm({
            columnClass:'col-md-6 col-md-offset-3',
            title: 'Modificar usuario',
            content: '¿Estás seguro de que quieres modificar los datos de este usuario?',
            buttons: {
                cancelar: function () {},
                Continuar: function () {
                    datos = $('#form_modificar').serialize();
                    modificarUsuario(datos);
                }
            }
        });
      });*/
    });
  });
    /*function a_onClick(idusuario, nombre, apellido, email, rol, activo) {
      $('#empleado_mod').val(idusuario);
      $('#nombre_mod').val(nombre);
      $('#apellido_mod').val(apellido);
      $('#email_mod').val(email);
      $('#rol_mod').val(rol);
      if (activo=='1'){
          $("#actividad option[value='1']").attr("selected", true);
      } else {
          $("#actividad option[value='0']").attr("selected", true);
      }
    }*/
    
    $(document).on('keyup', '#busqueda', function(){
      var valor = $(this).val();
      buscarInforme(valor);
    });
    
    function buscarInforme(consulta) {
      $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_pedidos.php',
        dataType: 'html',
        data: 'buscar='+consulta,
        }).done(function(respuesta){
          $('#cuerpo_tabla').html(respuesta);
        });
    }
    function cargarInformes(){
      $.ajax({
          type: 'POST',
          url: 'php/tablas/tabla_informes.php',
          success:function(html){
              $('#cuerpo_tabla').html(html);
          }, error:function(html){
            console.log(html);
          }
      });
    }
   
    function anadirInf(datos){
      var idUsuario=$("#idUsuario_1").attr('valor');
      console.log(datos);
      var fecha = fechaHoy();
      datos = datos+'&fecha='+fecha+'&Usuario='+idUsuario;
      console.log(datos);
      $.ajax({
        type: 'POST',
        url: 'php/inserciones/nuevo_informe.php',
        dataType:'json',
        data: datos})
        .done(function(respuesta){
          $('#nuevo_informe').modal('toggle');
          $('#cuerpo_tabla').empty();
          cargarInformes();
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