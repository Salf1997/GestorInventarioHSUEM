$(document).ready(function(){
    var datos="";
    var id=$('#idPedido_').attr("valor");
    cargarProducto();
    datosPedido(id);
      $("#select_form").change(function(){
          colocarCantidad_Desc();
      });
      $('#nuevoProd').click(function(){
        productosActivos();
      });

      $('#add_boton').click(function(){
        var stock = parseFloat($('#stock_an').val());
        var valido = validar(stock);
        if (valido==1){
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
            content: 'El stock introducido es incorrecto.',
          });
        }
      });
      $('#mod_boton').click(function(){
        var stock = parseFloat($('#stock_mod').val());
        var valido = validar(stock);
        if (valido==1){
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
            content: 'El stock introducido es incorrecto.',
          });
        }
      });
      $('#del_boton').click(function(){
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿Estás seguro de que quieres eliminar el producto del pedido?',
          buttons: {
            cancelar: function () {},
            Continuar: function () {
              datos = $('#form_modificar').serialize();
              eliminarProducto(datos);
            }
          }
        });
      });

      $('#borrarTodo_boton').click(function(){
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿Estás seguro de que quieres eliminar el pedido completo?',
          buttons: {
            No: function () {},
            Si: function () {
              eliminarPedido(id);
            }
          }
        });
      });

      $('#csv_boton').click(function(){
        nombreFichero();
      });

      $('#atras_boton').click(function(){
        window.location.assign("pedidos.php");
      });

      $('#entregado_boton').click(function(){
        fecha = fechaHoy();
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿El pedido ha sido entregado?',
          buttons: {
            No: function () {},
            Si: function () {
              datos = "idPedido_mod="+id+"&fecha='"+fecha+"'&completado='si'";
              $.ajax({
                type: 'POST',
                url: 'php/editar/editar_producto_pedido.php',
                data: datos,
                success:function(html){
                  if (html==1){
                    $('#info_pedido').empty();
                    datosPedido(id);
                    $("#entregado_boton").prop("disabled",true);
                    $("#mod_boton").prop("disabled",true);
                    $("#add_boton").prop("disabled",true);
                  } else {
                    $.alert({
                      columnClass:'col-md-6 col-md-offset-3',
                      icon: 'fa fa-warning',
                      title: '¡Error!',
                      content: 'Ha ocurrido un error al modificar el pedido. Por favor, comprueba que haya productos en el pedido.',
                    });
                  }
                }
              });
            }
          }
        });
      });
  });

  $(document).on('keyup', '#busqueda', function(){
    var valor = $(this).val();
      buscarProducto(valor);
  });

  function validar(stock){ 
    var valido;
    if(stock<=0 || isNaN(stock)){
      valido = 0;
    } else {
      valido = 1;
    }
    return valido;
  }

  function nombreFichero(){
    $.confirm({
      title: 'Nombre del archivo',
      content: '' +
      '<form action="" class="formName">' +
      '<div class="form-group">' +
      '<label>¿Con qué nombre desea guardar el CSV?</label>' +
      '<input type="text" placeholder="Nombre SIN la extension .CSV" class="name form-control" required />' +
      '</div>' +
      '</form>',
      buttons: {
          cancelar: function () {
            //close
          },
          formSubmit: {
              text: 'Aceptar',
              action: function () {
                  var nombre = this.$content.find('.name').val();
                  if(!nombre){
                      $.alert('Introduzca un nombre válido.');
                      return false;
                  } else {
                    $.confirm({
                      title: '¿Estás seguro?',
                      content: '¿Quieres exportar en CSV el pedido con el nombre "'+nombre+'.csv"?',
                      buttons: {
                        cancelar: function () {},
                        Continuar: function () {
                          var html = $('#tabla').html();
                          html += '<table><tr></tr></table>';
                          html += $('#tabla_info').html();
                          export_table_to_csv(html,nombre+".csv");
                        }
                      }
                    });
                  }
              }
          },
      },
      onContentReady: function () {
          // bind to events
          var jc = this;
          this.$content.find('form').on('submit', function (e) {
              // if the user submits the form by pressing enter in the field.
              e.preventDefault();
              jc.$$formSubmit.trigger('click'); // reference the button and click it
          });
      }
  });
  }
  
  function datosPedido(id){
    $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_producto_pedido.php',
      dataType: 'html',
      data: 'idPedido='+id+'&info="si'
      }).done(function(respuesta){
        $('#info_pedido').html(respuesta);
      }).fail(function(){
        console.log('error');
    });
  }

  function a_onClick(idProducto, nombreProd, descripcion, cantidad) {
    $('#identificador_mod').val(idProducto);
    $('#producto_mod').val(nombreProd);
    $('#stock_mod').val(cantidad);
    $('#descripcion_mod').val(descripcion);
  }

  function productosActivos(){
    var id=$('#idPedido_').attr("valor");
    datos="productosAcc='si&idPedido="+id;
    $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_producto_pedido.php',
      dataType: 'html',
      data: datos
      }).done(function(respuesta){
        $('#select_form').html(respuesta);
      });
  }
  
  function colocarCantidad_Desc(){
    var cantidad = $('#select_form option:selected').attr('cantidad');
    $('#cantidad').text(cantidad);
    var descripcion = $('#select_form option:selected').attr('descripcion');
    if(descripcion==""){
      $('#descripcion').text("-");
    } else{
      $('#descripcion').text(descripcion);
    }
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
  
  function buscarProducto(consulta) {
    var id=$('#idPedido_').attr("valor");
    $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_producto_pedido.php',
      dataType: 'html',
      data: 'idPedido='+id+'&consulta='+consulta
      }).done(function(respuesta){
        $('#cuerpo_tabla').html(respuesta);
      }).fail(function(){
        console.log('error');
      });
  }
  function cargarProducto(){
    var id=$('#idPedido_').attr("valor");
    $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_producto_pedido.php',
        data: 'idPedido='+id,
        success:function(html){
            $('#cuerpo_tabla').html(html);
        }
    });
  }
  function anadirProducto(datos){
    $.ajax({
        type: 'POST',
        url: 'php/inserciones/nuevo_producto_pedido.php',
        data: datos,
        success:function(html){
          if (html==1){
            $('#nuevo_prod').modal('toggle');
            $('#cuerpo_tabla').empty();
            cargarProducto();
          } else {
            $.alert({
              columnClass:'col-md-6 col-md-offset-3',
              icon: 'fa fa-warning',
              title: '¡Error!',
              content: 'Ha ocurrido un error al añadir el producto al pedido.',
            });
          }
        }
    });
  }
  function modificarProductos(datos){
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_producto_pedido.php',
      data: datos,
      success:function(html){
        if (html==1){
          $('#modal_modificar').modal('toggle');
          $('#cuerpo_tabla').empty();
          cargarProducto();
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al modificar el producto de este pedido.',
          });
        }
      }
    });
  }
  
  function eliminarProducto(datos){
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_producto_pedido.php',
      data: datos+"&borrar='Si'",
      success:function(html){
        if (html==1){
          $('#modal_modificar').modal('toggle');
          $('#cuerpo_tabla').empty();
          cargarProducto();
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al eliminar el producto de esta pedido.',
          });
        }
      }
    });
  }

  function eliminarPedido(id){
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_producto_pedido.php',
      data: "idPedido_mod="+id+"&borrarTodo='Si'",
      success:function(html){
        console.log(html);
        if (html==1){
          window.location.assign("pedidos.php");
        } else {
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al eliminar el pedido.',
          });
        }
      }
    });
  }

function export_table_to_csv(html, filename) {
	var csv = [];
	var rows = document.querySelectorAll("table tr");
	
    for (var i = 0; i < rows.length; i++) {
		var row = [], cols = rows[i].querySelectorAll("td, th");
		
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
		csv.push(row.join(","));		
	}

    // Download CSV
    download_csv(csv.join("\n"), filename);
}


function download_csv(csv, filename) {
  var csvFile;
  var downloadLink;

  // CSV FILE
  csvFile = new Blob([csv], {type: "text/csv"});

  // Download link
  downloadLink = document.createElement("a");

  // File name
  downloadLink.download = filename;

  // We have to create a link to the file
  downloadLink.href = window.URL.createObjectURL(csvFile);

  // Make sure that the link is not displayed
  downloadLink.style.display = "none";

  // Add the link to your DOM
  document.body.appendChild(downloadLink);

  // Lanzamos
  downloadLink.click();
}