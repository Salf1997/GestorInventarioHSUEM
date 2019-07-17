
$(function () {

    utils();


    $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function (event) {
        event.preventDefault();
        event.stopPropagation();

        $(this).siblings().toggleClass("show");


        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
            $('.dropdown-submenu .show').removeClass("show");
        });

    });


    $('i.delete').on('click', function () {
        $(this).parents('.item').fadeOut();
    });

    // ------------------------------------------------------- //
    // Scroll to top button
    // ------------------------------------------------------ //
    $(window).on('scroll', function () {
        if ($(window).scrollTop() >= 1500) {
            $('#scrollTop').fadeIn();
        } else {
            $('#scrollTop').fadeOut();
        }
    });


    $('#scrollTop').on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 1000);
    });
});


$('#modificar').click(function(event){
    event.preventDefault();
    $('#modificar_contra').modal('toggle');
});
$('#boton_mod_contra').click(function(event){
    event.preventDefault();
    comprobarContraseñas();
});
$('#logout').click( function(event){
    event.preventDefault();
    $.ajax({
        url:'php/logout.php',
        type:'POST',
        data:"",
    }).done(function(){
        location.href='index.php';
    }).fail(function(){
        console.log('error al cerrar sesión');
    });
});

function comprobarContraseñas(){
    $('#error').removeClass('alert alert-danger');
    var nueva = $('#nueva').val();
    var rep = $('#nueva_comp').val();

    if(nueva!==""){
        if(nueva == rep){
            realizarModificacion();
        } else{
            $('#error').addClass('alert alert-danger');
            $('#error').html('Las contraseñas no son iguales, inténtelo de nuevo.');
        }
    }
    else{
        $('#error').addClass('alert alert-danger');
        $('#error').html('No puede dejar los campos vacíos');
    }
}

function realizarModificacion(){
    $.ajax({
        url:'php/usuario/modificar_password.php',
        type:'POST',
        data:$('#form_modificar_contra').serialize(),
        beforeSend:function(){
        }
    }).done(function(respuesta){
        $('#modificar_contra').modal('toggle');
    }).fail(function(respuesta){
        console.log(respuesta);
    });
}

function utils() {

    /* click on the box activates the link in it */

    $('.box.clickable').on('click', function (e) {

        window.location = $(this).find('a').attr('href');
    });
    /* external links in new window*/

    $('.external').on('click', function (e) {

        e.preventDefault();
        window.open($(this).attr("href"));
    });
    /* animated scrolling */

    $('.scroll-to, .scroll-to-top').click(function (event) {

        var full_url = this.href;
        var parts = full_url.split("#");
        if (parts.length > 1) {

            scrollTo(full_url);
            event.preventDefault();
        }
    });
    function scrollTo(full_url) {
        var parts = full_url.split("#");
        var trgt = parts[1];
        var target_offset = $("#" + trgt).offset();
        var target_top = target_offset.top - 100;
        if (target_top < 0) {
            target_top = 0;
        }

        $('html, body').animate({
            scrollTop: target_top
        }, 1000);
    }
}