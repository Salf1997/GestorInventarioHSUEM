$(document).ready(function(){
    getWarnings();
    getAlertas();
    modalBorrarUpload();
    $('#boton_csv').click(function(){
        nombreFichero();
    });
    
    $('#boton_borrar').click(function(){
        tabla=$('#nombre_tabla').text();
        $.confirm({
            title: 'Borrar datos de la tabla '+tabla,
            content: '¿Estás seguro de que quieres borrar todos los datos de la tabla '+tabla+'?',
            buttons: {
                cancelar: function () {}, 
                Continuar: function () {
                borrarDatos(tabla);
                }
            }
        });
    });
});

function getWarnings(){
    $.ajax({
        type: 'POST',
        url: 'php/tablas/consultar_warnings.php',
        data: "activo=1&warnings='si'",
        success:function(data){
            $('#warnings').html(data);
       }
    });
}

function getAlertas(){
    $.ajax({
        type: 'POST',
        url: 'php/tablas/consultar_warnings.php',
        data: "activo=1",
        success:function(data){
            $('#alerta').html(data);
       }
    });
}

function borrarDatos(tabla){
    $.ajax({
      type: 'POST',
      url: 'php/truncate.php',
      data: "tabla="+tabla,
      success:function(html){
        if (html==1){
          $('#modal_subir').modal('toggle');
          $('#cuerpo_tabla').empty();
          cargarTabla(1);
        } else {
          console.log(html);
          $.alert({
            columnClass:'col-md-6 col-md-offset-3',
            icon: 'fa fa-warning',
            title: '¡Error!',
            content: 'Ha ocurrido un error al borrar la tabla '+tabla+'.',
          });
        }
      }
    });
  }

function modalBorrarUpload(){
    var modal ='<div role="document" class="modal-dialog"><div class="modal-content">';
    modal +='<div class="ribbon-primary text-uppercase">Subir datos o Borrar tabla</div>';
    modal +='<div class="modal-body"><div class="align-items-center">';
    modal +='<form id="form_subir" action="php/upload.php" enctype="multipart/form-data" method="post">';
    modal +='<div class="form-group">Seleccionar archivo<br><input type="file" name="file" id="file" class="input-large" accept=".csv, text/csv"><br></div>';
    modal +='<div class="form-group">Seleccionar tabla donde insertar:<br><select name="tabla"><option value="producto">Productos</option><option value="proveedor">Proveedores</option></select></div>';
    modal +='<div class="form-group"><input type="submit" id="boton_subir" name="Import" class="btn btn-primary" value="Importar">';
    modal +='&nbsp;<input type="button" id="boton_borrar" class="btn btn-primary" value="Borrar datos"> </div>';
    modal +='</form>';
    modal +='</div></div></div></div>';

    $("#modal_subir").html(modal);
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

    download_csv(csv.join("\n"), filename);
}


function download_csv(csv, filename) {
  var csvFile;
  var downloadLink;

  csvFile = new Blob([csv], {type: "text/csv"});

  downloadLink = document.createElement("a");

  downloadLink.download = filename;

  downloadLink.href = window.URL.createObjectURL(csvFile);

  downloadLink.style.display = "none";

  document.body.appendChild(downloadLink);

  downloadLink.click();
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
          var jc = this;
          this.$content.find('form').on('submit', function (e) {
              e.preventDefault();
              jc.$$formSubmit.trigger('click');
          });
      }
  });
}