$(document).ready(function(){
    var datos="";
    cargarUsuarios();
      $('#add_boton').click(function(){
        var rol = [];
      
        var valido = validar($('#nombre').val(), $('#apellido').val(), $('#email').val());

        if(valido == 1){
          if ($('#admin_an').is(':checked') || $('#tec_an').is(':checked')) {
            $.confirm({
                title: '¿Estás seguro?',
                content: '¿Estás seguro de que quieres añadir a este usuario?',
                buttons: {
                  cancelar: function () {},
                  Continuar: function () {
                      datos = $('#form_anadir').serialize();
                      anadirUsuario(datos);
                    }
                }
              });
          } else {
              $.alert({
                  columnClass:'col-md-6 col-md-offset-3',
                  icon: 'fa fa-warning',
                  title: 'Sin roles seleccionados',
                  content: 'Por favor, seleccione al menos un rol.',
              });
          }
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: 'Campos incompletos',
            content: 'Por favor, rellene todos los campos.',
          });
        }
        
      });
      $('#mod_boton').click(function(){

        var valido = validar($('#nombre_mod').val(), $('#apellido_mod').val(), $('#email_mod').val());

        if(valido == 1){
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
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: 'Campos incompletos',
            content: 'Por favor, rellene todos los campos.',
          });
        }
      });


      $('#restablecer_boton').click(function(){
        $.confirm({
          columnClass:'col-md-6 col-md-offset-3',
          title: 'Restablecer contraseña',
          content: '¿Estás seguro de que quieres restablecer la contraseña de este usuario?',
          buttons: {
              cancelar: function () {},
              Continuar: function () {
                  datos = $('#form_modificar').serialize()+"&restablecer_boton='si'";
                  modificarUsuario(datos);
              }
          }
      });
      });

  });

  function validar(nombre, apellido, email){
    var valido= 1;
    if(nombre==""||apellido==""||email==""){
      valido = 0;
    }
    return valido;
  }

  function a_onClick(idusuario, nombre, apellido, email, rol, activo) {
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
  }
  
  $(document).on('keyup', '#busqueda', function(){
    var valor = $(this).val();
      buscarUsuarios(valor);
  });
  
  function buscarUsuarios(consulta) {
    $.ajax({
      type: 'POST',
      url: 'php/usuario/usuarios.php',
      dataType: 'html',
      data: 'buscar='+consulta,
      }).done(function(respuesta){
        $('#cuerpo_tabla').html(respuesta);
      });
  }
  function cargarUsuarios(){
    $.ajax({
        type: 'POST',
        url: 'php/usuario/usuarios.php',
        success:function(html){
            $('#cuerpo_tabla').html(html);
        }
    });
  }
 
  function anadirUsuario(datos){
    $.ajax({
        type: 'POST',
        url: 'php/usuario/nuevo_usuario.php',
        dataType:'html',
        data: datos,
    }).done(function(html){
      if(html.includes("Error")){
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: 'Usuario ya existente',
            content: 'Por favor, verifica que el número de empleado sea el correcto o que esté ya registrado en la web.',
          });
      } else {
          $('#nuevo_usuario').modal('toggle');
          $('#cuerpo_tabla').empty();
          cargarUsuarios();
      }
    }).fail(function(html){
      console.log(html);
    });
  }
  function modificarUsuario(datos){
    $.ajax({
      type: 'POST',
      url: 'php/usuario/modificar_usuario.php',
      data: datos,
      success:function(html){
        $('#mod_usuario').modal('toggle');
        $('#cuerpo_tabla').empty();
        cargarUsuarios();
      }
    });
  }