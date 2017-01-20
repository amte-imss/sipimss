var seccion_seleccionada;
$(document).ready(function () {
    $("#btn_informacion_general_personal").on('click', function () {
        //alert($("#form_informacion_general").attr("action"));
        var action = $("#form_informacion_general").attr("action");
        var form_data = $("#form_informacion_general").serialize();
        $.ajax({
            url: action,
            data: form_data,
            method: 'POST',
            beforeSend: function (xhr) {
                $('#seccion_info_general').html(create_loader());
            }
        })
                .done(function (response) {
                    //alert(response)
                    try {
                        var resp = $.parseJSON(response);
                        $('#msg_general').show();
                        $('#msg_general').text(resp.message);
                        //alert($('#msg_general').attr("class"));
                        if (resp.result == true) {
                            $('#msg_general').addClass('alert-success');
                        } else {
                            $('#msg_general').addClass('alert-danger');
                        }
                        setTimeout("$('#msg_general').hide()", 5000);
                        recargar_fecha_ultima_actualizacion();//Recarga la fecha de la ultima actualización del modulo perfil
                        $("#seccion_info_general").html(resp.content);
                    } catch (e) {
                        $("#seccion_info_general").html(response);
                    }

                })
                .fail(function (jqXHR, response) {
                    $('#msg_general').removeClass('alert-success').addClass('alert-danger');
                    $('#msg_general').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                })
                .always(function () {
                    remove_loader();
                });
    });
});



$(function () {
    $('#btnEditarNombre').on('click', function () {
        var isReadOnly = $('.nameFields').prop('readonly');
        $('.nameFields').prop('readonly', !isReadOnly);
    });

    $("ul.nav-pills > li > a").on("shown.bs.tab", function (e) {
//      alert(window.location.href);
//        var scrollposition = $(document).scrollTop();
        var id = jQuery(e.target).attr("href").substr(1);//Obtiene el texto del href
        window.location.hash = id;
        if (id === 'seccion_validar') {
            if(seccion_seleccionada !== id){//Si es diferente, recarga la sección validar
                cargar_datos_menu_perfil(id);
            }
        } else {
            if (id.indexOf('seccion') > -1 && array_menu_perfil_validar.indexOf(id) < 0) {
//            alert(array_menu_perfil_validar.indexOf(id));
                //alert();
                array_menu_perfil_validar.push(id);
                //Separar en 4, 0controlador; 1nombre del método ajax; 2nombre del formulario; 3nombre del div
//            var cad = hrutes[id];
//            var cad_split = cad.split(":");
////            data_ajax(site_url + '/validacion_censo_profesores/get_data_ajax_actividad/', '#form_actividad_docente', '#get_data_ajax_actividad');
//            data_ajax(site_url + '/' + cad_split[0] + '/' + cad_split[1], cad_split[2], cad_split[3]);
                cargar_datos_menu_perfil(id);
            }
        }
        seccion_seleccionada = id;
//        $(document).scrollTop(scrollposition);
    });

    var hash = window.location.hash;
    $('.nav.nav-pills a[href="' + hash + '"]').tab('show', function () {
        $(document).scrollTop();
    });


});

/**
 * 
 * @param {type} id del botón menú, si es NULL, no se recargará la info del cuerpo 
 * @param {type} is_success false, si es un error, true si es correcto 
 * @param {type} mensaje que se mostrará en el iv de mensajes 
 * @returns 0 
 */
function recargar_opcion_menu_mostrar_mensaje(id, is_success, mensaje) {
    var class_tipo = (is_success) ? 'alert-success' : 'alert-danger';
    $('#mensaje_error_index').html(mensaje);
    $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-success').addClass(class_tipo);
    $('#div_error_index').show();
    $('#modal_censo').modal('toggle');
    setTimeout("$('#div_error_index').hide()", 6000);
    if (id !== null) {
        cargar_datos_menu_perfil(id);
    }
    recargar_fecha_ultima_actualizacion();
}

/**
 * 
 * @param {type} el identificador se compone de tres elementos o argumentos, que 
 * se encuentran separados por el caracter ":" 1er_arg=metódo, 2do_arg=formulario
 * y 3er_arg=div, ejemplo a continuación:
 * "get_data_ajax_actividad:#form_actividad_docente:#get_data_ajax_actividad"
 * @returns {undefined}
 */
function cargar_datos_menu_perfil(id) {
//    alert(id);
    try {
        var cadena = hrutes[id];
        var cad_split = cadena.split(":");
//        alert('comprueba.....');
        data_ajax(site_url + '/' + cad_split[0] + '/' + cad_split[1], cad_split[2], cad_split[3]);
    } catch (e) {//Carga los datos de la recarga de la páginas
        var URLactual = window.location;
        URLactual = String(URLactual);
        var pag = URLactual.split("#");
        if (pag.length === 2) {
            var menu = pag[1];
            data_ajax(site_url + '/validacion_censo_profesores/' + menu, '', '#' + menu);
//            array_menu_perfil_validar();
        }

    }
}

function recargar_fecha_ultima_actualizacion() {

    var a = hrutes['seccion_info_general'];
    var cad_split = a.split(":");
    $.ajax({
        url: site_url + '/' + cad_split[0] + '/get_fecha_ultima_actualizacion',
        method: 'POST',
        beforeSend: function (xhr) {
//            $('#modal_content').html(create_loader());
        }
    })
            .done(function (response) {
                var response_json = $.parseJSON(response);//
                $('#fecha_ultima_actualizacion').text(response_json.fecha_ult_act);
            })
            .fail(function (jqXHR, response) {
//                $('#div_error').show();
//                $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
//                $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
            })
            .always(function () {
                remove_loader();
            });

}