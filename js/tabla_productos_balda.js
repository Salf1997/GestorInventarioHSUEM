$(document).ready(function(){
    var datos="";
    cargarProducto();
      
    $('#add_boton').click(function(){
      var stock_balda = parseInt($('#stock_an').val());
      var stock_prod = parseInt($('#select_form option:selected').attr('cantidad'));
      var valido = validacion(stock_balda, stock_prod);

      var idProd = $('#select_form option:selected').val();
      var locF="b_"+$('#nombreBalda').attr("valor");

      datos = $('#form_anadir').serialize();

      if(valido == 0){
        $.alert({
          icon: "fa fa-warning",
          title: '¡No hay existencias!',
          content: 'No hay existencias suficientes que traspasar a esta aula.',
        });
      } else if( valido == 1 ){
        $.confirm({
          title: '¡Stock máximo alcanzado!',
          content: 'Vas a colocar todo el stock en esta balda. ¿Quieres continuar?',
          buttons: {
              cancelar: function () {},
              Continuar: function () {
                $('#cuerpo_tabla').empty();
                anadirProducto(datos);
                anadirMovimiento(stock_balda,locF, "Sin", idProd);
              }
          }
        });
      } else if( valido == 2){
        $.confirm({
          title: 'Nuevo producto',
          content: '¿Estás seguro de que quieres añadir el producto?',
          buttons: {
              cancelar: function () {}, 
              Continuar: function () {
                $('#cuerpo_tabla').empty();
                anadirProducto(datos);
                anadirMovimiento(stock_balda,locF, "Sin", idProd);
              }
          }
        });
      } else if(valido == 3){
        $.alert({
          icon: "fa fa-warning",
          title: '¡Stock no válido!',
          content: 'Intentas introducir 0 stock. Por favor, introduce una cantidad válida.',
        });
      }
    });
    $('#mod_boton').click(function(){
      var stock_balda = parseInt($('#stock_mod').val());
      var stock_prod = parseInt($('#cantidad_disponible').text());
      var actual = parseInt($('#cantidad_actual').text());
      var valido = validacionMod(stock_balda, stock_prod,actual);

      var idProd = $('#identificador_mod').val();
      var locF="b_"+$('#nombreBalda').attr("valor");

      datos = $('#form_modificar').serialize();

      if(valido == 0){
        $.alert({
          icon: "fa fa-warning",
          title: '¡No hay existencias!',
          content: 'No hay existencias suficientes que traspasar a esta aula.',
        });
      } else if( valido == 1 ){
        $.confirm({
          title: '¡Stock máximo alcanzado!',
          content: 'Vas a colocar todo el stock en esta balda. ¿Quieres continuar?',
          buttons: {
              cancelar: function () {},
              Continuar: function () {
                $('#cuerpo_tabla').empty();
                modificarProductos(datos);
                anadirMovimiento(stock_balda,locF, "Sin", idProd);
              }
          }
        });
      } else if( valido == 2){
        $.confirm({
          title: 'Nuevo producto',
          content: '¿Estás seguro de que quieres modificar el producto?',
          buttons: {
              cancelar: function () {}, 
              Continuar: function () {
                $('#cuerpo_tabla').empty();
                modificarProductos(datos);
                anadirMovimiento(stock_balda,locF, "Sin", idProd);
              }
          }
        });
      } else if(valido == 3){
        $.confirm({
          closeIcon: true,
          title: 'Confirmación',
          columnClass: 'col-md-6 col-md-offset-3',
          icon: 'fa fa-question-circle',
          content: '¿Se ha acabado parte o todo el stock de este producto?',
          buttons: {
            Si: {
              text:"Sí",
              action: function () {
                var stock_val=actual-stock_balda;
                datos = datos+"&prod='si'&stock_resta="+stock_val;
                $('#cuerpo_tabla').empty();
                modificarProductos(datos);
                modificarBaldaProd(datos);
                anadirMovimiento(stock_balda,"No", locF, idProd);
              }
            },
            No: {
              text:"No, lo quiero mover de almacén.",
              action: function () {
                $.confirm({
                  title: 'Confirmación',
                  content: '¿Estás seguro de que quieres desasignar este stock a esta balda?',
                  buttons: {
                    Si: {
                      text:"Sí",
                      action: function () {
                        $('#cuerpo_tabla').empty();
                        modificarProductos(datos);
                        anadirMovimiento(stock_balda,locF, "Sin", idProd);
                      }
                    },
                    No: function () {}
                  }
                });
              }
            }
          }
        });
      } else{
        $.alert({
          icon: "fa fa-warning",
          title: '¡Error!',
          content: 'El valor introducido en Stock no es correcto.',
        });
      }
    });

    $("#select_form").change(function(){
      colocarCantidad_Desc();
    });

    $("#btn_anadir").click(function(){
      productosModal();
    });

  });
  $(document).on('keyup', '#busqueda', function(){
    var valor = $(this).val();
      buscarProducto(valor);
  });
  
  function a_onClick(idProducto, nombreProd, descripcion, cantidad, stockProd) {
    $('#identificador_mod').val(idProducto);
    $('#producto_mod').val(nombreProd);
    $('#cantidad_actual').text(cantidad);
    $('#descripcion_mod').val(descripcion);
    $('#cantidad_disponible').text(stockProd);
    cantidadesAsignadas(idProducto);
  }
  
  function colocarCantidad_Desc(){
        var cant = $('#select_form option:selected').attr('cantidad');
        $('#cantidad').text(cant);
        var stock_total = $('#select_form option:selected').attr('stock_tot');
        $('#stock_total').text(stock_total);
        var descripcion = $('#select_form option:selected').attr('descripcion');
        if(descripcion==""){
          $('#descripcion').text("-");
        } else{
          $('#descripcion').text(descripcion);
        }
        var valor= $('#select_form option:selected').val();
        cantidadesAsignadas(valor);
  }

  function cantidadesAsignadas(idProducto){
    $.ajax({
      type: 'POST',
      url: 'php/tablas/consultar_producto_balda.php',
      data: 'idProducto='+idProducto,
      success:function(html){
          $('#lugar').html(html);
          $('#lugar_mod').html(html);
      }
  });
  }

  function productosModal(){
    var idBalda=$('#nombreBalda').attr("valor");
    $.ajax({
        type: 'POST',
        url: 'php/tablas/consultar_producto_balda.php',
        data: 'idBalda='+idBalda,
        success:function(html){
            $('#select_form').html(html);
        }
    });
  }
  
  function validacion(stock_balda, stock_prod){
    var valido = 0;
      if(stock_balda > stock_prod){
        valido =0;
      } else if(stock_balda == stock_prod){
        valido = 1;
      } else if(stock_balda < stock_prod){
        valido = 2;
      }   
      
      if(stock_balda==0 || isNaN(stock_balda)==true){
        valido = 3;
      }

      return valido;
  }

  function validacionMod(stock_balda, stock_prod, actual){
    
    var valido = 0;
    var comp = stock_prod+actual;
    if(stock_balda > stock_prod){
      valido =0;
    }
    if(stock_balda == comp){
      valido = 1;
    }
    if(stock_balda < stock_prod && stock_balda > actual){
      valido = 2;
    }   
    if(stock_balda==0 || stock_balda < actual){
      valido = 3;
    }
    if(isNaN(stock_balda)==true || actual == stock_balda){
      valido=4;
    }

    return valido;
  }
  
  function buscarProducto(consulta) {
    var idBalda=$('#nombreBalda').attr("valor");

    $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_productos_balda.php',
      dataType: 'html',
      data: 'idBalda='+idBalda+'&consulta='+consulta
      }).done(function(respuesta){
        $('#cuerpo_tabla').html(respuesta);
      }).fail(function(){
        console.log('error');
      });
  }
  function cargarProducto(){
    var idBalda=$('#nombreBalda').attr("valor");
    $.ajax({
        type: 'POST',
        url: 'php/tablas/tabla_productos_balda.php',
        data: 'idBalda='+idBalda,
        success:function(html){
            $('#cuerpo_tabla').html(html);
        }
    });
  }
  function anadirProducto(datos){
    $.ajax({
        type: 'POST',
        url: 'php/inserciones/nuevo_producto_balda.php',
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
              content: 'Ha ocurrido un error al añadir el producto a esta balda.',
            });
          }
        }
    });
  }
  function modificarProductos(datos){
    var prod = $('#identificador_mod').val();
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_producto_balda.php',
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
            content: 'Ha ocurrido un error al modificar el producto de esta balda.',
          });
        }
      }
    });
  }

  function anadirMovimiento(cantidad, locF, locI, idProd){
    console.log("anadirMovimiento");
    fecha=fechaHoy();
     datos = "fecha='"+fecha+"'&cantidad="+cantidad+"&localizacionF='"+locF+"'&localizacionI='"+locI+"'&idProd="+idProd;
    
    $.ajax({
      type: 'POST',
      url: 'php/inserciones/nuevo_movimiento.php',
      data: datos,
      success:function(html){
        console.log(html);
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

  function modificarBaldaProd(datos){
    $.ajax({
      type: 'POST',
      url: 'php/editar/editar_balda_productos_aula.php',
      data: datos,
      success:function(html){
        console.log("modificarProductoBalda: "+html);
      }
  });
  }