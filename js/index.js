$(document).on('submit','#inicioSesion', function(event){
    event.preventDefault();

    $.ajax({
        url:'php/inicioSesion.php',
        type:'POST',
        dataType:'json',
        data:$(this).serialize(),
        beforeSend:function(){
            $('#error').removeClass('alert alert-danger');
            $('#error').empty();
        }
    }).done(function(respuesta){
        if(respuesta.tipo.includes("1")==true){
            location.href='admin.php';
        }else if(respuesta.tipo.includes("2")==true){
            location.href='inicio.php';
        }else{
            $('#error').addClass('alert alert-danger');
            $('#error').html(respuesta.tipo);
        };
    });
});
