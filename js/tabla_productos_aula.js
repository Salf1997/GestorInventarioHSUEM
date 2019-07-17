$(document).ready(function(){
    var datos="";
    cargarProducto();
  
    $('#add_boton').click(function(){
      var stock_aula = parseInt($('#stock_an').val());
      var stock_prod = parseInt($('#cantidad').text());
      var valido = validacion(stock_aula, stock_prod);
      var idProd= $('#select_form option:selected').val();
      var idBalda = $('#select_form option:selected').attr('idB');
      var locI = "b_"+idBalda;
      var locF = "a_"+$('#aula').val();

      if(valido == 1){
        $.confirm({
          title: 'Nuevo producto',
          content: '¿Estás seguro de que quieres añadir el producto?',
          buttons: {
              cancelar: function () {}, 
              Continuar: function () {
                datos = $('#form_anadir').serialize();              
                $('#cuerpo_tabla').empty();

                datos = datos+"&idBalda_an="+idBalda+"&balda='si'";;
                console.log(datos);
                anadirProducto(datos);
                modificarBaldaProd(datos);
                anadirMovimiento(stock_aula, locF, locI, idProd);
              }
          }
        });
      } else if(valido == 2){
        $.confirm({
          title: '¡Stock máximo alcanzado!',
          content: 'Vas a colocar todo el stock en esta aula. ¿Quieres continuar?',
          buttons: {
              cancelar: function () {},
              Continuar: function () {
                datos = $('#form_anadir').serialize(); 
                var idBalda = $('#select_form option:selected').attr('idB');
                datos = datos+"&idBalda_an="+idBalda+"&balda='si'";
                console.log(datos);
                $('#cuerpo_tabla').empty();
                anadirProducto(datos);
                modificarBaldaProd(datos);
                anadirMovimiento(stock_aula, locF, locI, idProd);
              }
          }
        });
      } 
      else {
        $.alert({
          title: '¡Error!',
          icon: 'fa fa-warning',
          content: 'Verifique la información dada.',
        });
      }
    });

    $('#mod_boton').click(function(){
      var stock_prod = parseInt($('#cantidad_mod').text());
      var cantidad_actual = parseInt($("#cantidad_actual").text());
      var modificar ="";

      var idProd = $('#identificador_mod').val();
      var stock_aula = parseInt($('#stock_mod').val());
      var locI = "b_"+$('#idBalda_mod').val();
      var locF = "a_"+$('#idAula_mod').val();

      var valido;
      if(stock_aula<cantidad_actual){
        modificar ="&prod='si'";
        valido = validacion(stock_aula, stock_prod);
      } else if(stock_aula==cantidad_actual){
        valido=0;
      } else{
        modificar="&balda='si'";
        stock_n=stock_aula-cantidad_actual;
        valido = validacion(stock_n, stock_prod);
      }

      if(valido == 1){
        $.confirm({
          title: '¿Estás seguro?',
          content: '¿Estás seguro de que quieres modificar el producto?',
          buttons: {
            cancelar: function () {},
            Continuar: function () {
              datos = $('#form_modificar').serialize();
              datos = datos+modificar;
              $('#cuerpo_tabla').empty();
              modificarProductos(datos);
              modificarBaldaProd(datos);
              anadirMovimiento(stock_aula, locF, locI, idProd);
            }
          }
        });
      }
      else if(valido == 2){
        $.confirm({
          title: '¡Stock máximo alcanzado!',
          content: 'Vas a colocar todo el stock en esta aula. ¿Quieres continuar?',
          buttons: {
            cancelar: function () {},
            Continuar: function () {
              datos = $('#form_modificar').serialize();
              datos = datos+modificar;
              $('#cuerpo_tabla').empty();
              modificarProductos(datos);
              modificarBaldaProd(datos);
              anadirMovimiento(stock_aula, locF, locI, idProd);
            }
          }
        });
      } else if(valido == 3){
        $.confirm({
          closeIcon: true,
          title: 'Confirmación',
          icon: 'fa fa-question-circle',
          content: '¿Se ha acabado todo el stock en esta aula?',
          buttons: {
            Si: {
              text:"Sí",
              action: function () {
                datos = $('#form_modificar').serialize();
                datos = datos+modificar;
                $('#cuerpo_tabla').empty();
                modificarProductos(datos);
                modificarBaldaProd(datos);
                anadirMovimiento(stock_aula, "No", locF, idProd);
              }
            },
            No: {
              text:"No, lo devolveré a su almacén",
              action: function () {
                datos = $('#form_modificar').serialize();
                datos = datos+"&baldasuma='si'";
                $('#cuerpo_tabla').empty();
                modificarProductos(datos);
                modificarBaldaProd(datos);
                anadirMovimiento(cantidad_actual, locI, locF, idProd);
              }
            }
          }
        });
      }  else {
        $.alert({
          title: '¡Error!',
          icon: 'fa fa-warning',
          content: 'Verifique la información dada.',
        });
      }
    });
    $('#boton_nuevo').click(function(){
      productosCargaModal();
    });

    $('#boton_modificar').click(function(){
      //REVISAR ESTO
      var idProd = $('#identificador_mod').val();
      var stock_prod = parseInt($('#cantidad_mod').text());
      calcularCantidad(stock_prod,idProd);
    });

    $("#select_form").change(function(){
      colocarCantidad_Desc();
  });
});

$(document).on('keyup', '#busqueda', function(){
  var valor = $(this).val();
    buscarProducto(valor);
});

function a_onClick(idProducto, idAula, nombreProd, cantidad, stock,locI,idB) {
  $('#identificador_mod').val(idProducto);
  $('#producto_mod').val(nombreProd);
  $('#cantidad_actual').html(cantidad);
  $('#idAula_mod').val(idAula);
  $('#cantidad_mod').html(stock);
  $('#almacen_mod').text(locI);
  $('#idBalda_mod').val(idB);
}

function colocarCantidad_Desc(){
      var cant = $('#select_form option:selected').attr('cantidad');
      var locI = $('#select_form option:selected').attr('locI');
      var val = $('#select_form option:selected').attr('valor');
      calcularCantidad(cant, val);      
      var descripcion = $('#select_form option:selected').attr('descripcion');
      if(descripcion==""){
        $('#descripcion').text("-");
      } else{
        $('#descripcion').text(descripcion);
      }
      $('#almacen_an').text(locI);

}

function validacion(stock_aula, stock_prod){
  var valido;
    if(stock_aula > stock_prod){
      valido = 0;
    } else if(stock_aula == stock_prod){
      valido=2;
    } else if(stock_aula < stock_prod){
      valido=1;
    }
    if(stock_aula==0){
      valido = 3;
    }
    return valido;
}

function buscarProducto(consulta) {
  var idAula=$('#nombreAula').attr("valor");
  $.ajax({
    type: 'POST',
    url: 'php/tablas/tabla_productos_aula.php',
    dataType: 'html',
    data: 'idAula='+idAula+'&consulta='+consulta
    }).done(function(respuesta){
      $('#cuerpo_tabla').html(respuesta);
    });
}
function cargarProducto(){
  var idAula=$('#nombreAula').attr("valor");
  $.ajax({
      type: 'POST',
      url: 'php/tablas/tabla_productos_aula.php',
      data: 'idAula='+idAula,
      success:function(html){
          $('#cuerpo_tabla').html(html);
      }
  });
}

function productosCargaModal(){
  var idAula=$('#nombreAula').attr("valor");
  console.log(idAula);
  $.ajax({
    type: 'POST',
    url: 'php/tablas/consultar_producto_aula.php',
    data: 'idAula='+idAula,
    success:function(html){
      $('#cantidad').text("");
      $('#descripcion').text("");
      $('#select_form').html(html);
    }
});
}

function anadirProducto(datos){
  $.ajax({
      type: 'POST',
      url: 'php/inserciones/nuevo_producto_aula.php',
      data: datos,
      success:function(html){
        console.log(html);
        $('#nuevo_prod').modal('toggle');
        $('#cuerpo_tabla').empty();
        cargarProducto(); 
      }
  });
}

function modificarProductos(datos){
  var prod = $('#identificador').val();
  $.ajax({
    type: 'POST',
    url: 'php/editar/editar_producto_aula.php',
    data: datos,
    success:function(html){
      $('#modal_modificar').modal('toggle');
      $('#cuerpo_tabla').empty();
      cargarProducto();
    }
  });
}

function calcularCantidad(cant, valor){
  var val;
  $.ajax({
    type: 'POST',
    url: 'php/tablas/consultar_producto_aula.php',
    data: "sala='Si'&idProd="+valor+"&stock="+cant,
    success:function(html){
      val=muestramelo(cant,html);
    }
  });
  return val;
}

function muestramelo(cant,sala){
  cantidadTotal=cant-sala;
  $('#cantidad').html(cantidadTotal);
  $('#cantidad_mod').html(cantidadTotal);
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
    success:function(html){}
});
}