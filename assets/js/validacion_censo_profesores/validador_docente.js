function envio_cambio_estado_validacion(element) {
    var a = hrutes['seccion_validar'];
    var cad_split = a.split(":");
    var obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var estado_cambio_cve = obj.data('estadocambiocve');
//    var tipo_transicion =obj.data('tipotransicion');
    var formData = $('#form_validar_docente').serialize();
    formData += '&estado_cambio_cve=' + estado_cambio_cve;
    $.ajax({
        url: site_url + '/' + cad_split[0] + '/enviar_cambio_estado_validacion',
        data: formData,
        method: 'POST',
        beforeSend: function (xhr) {
            $('#seccion_validar').html(create_loader());
        }
    })
            .done(function (response) {
                try {
                    var response = $.parseJSON(response);
                    if (response.result === 1) {
                        $('#mensaje_error_index').html(response.error);
                        $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-success').addClass('alert-' + response.tipo_msg);
                        $('#div_error_index').show();
                        setTimeout("$('#div_error_index').hide()", 5000);
                        try {
                            cargar_datos_menu_perfil();
                            funcion_buscar_docentes_validar();
                            array_menu_perfil_validar = new Array(11);
                        } catch (e) {
                            $('#seccion_validar').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                        }
                    } else {
                        $('#mensaje_error_index').html(response.error);
                        $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-success').addClass('alert-' + response.tipo_msg);
                        $('#div_error_index').show();
                        setTimeout("$('#div_error_index').hide()", 5000);
                        try {
                            cargar_datos_menu_perfil();
                        } catch (e) {
                            $('#seccion_validar').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                        }

                    }
                } catch (e) {
//                $('#seccion_validar').html(response);
                    $('#seccion_validar').html(response);

                }
            })
            .fail(function (jqXHR, response) {
//                $('#div_error').show();
                $('#seccion_validar').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
//                $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
            })
            .always(function () {
                remove_loader();
            });
}

//function envio_revision(element) {
//    var a = hrutes['seccion_validar'];
//    var cad_split = a.split(":");
//    var obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
//    var estado_cambio_cve = obj.data('estadocambiocve');
////    var tipo_transicion =obj.data('tipotransicion');
//    var formData = $('#form_validar_docente').serialize();
//    formData += '&estado_cambio_cve=' + estado_cambio_cve;
//    $.ajax({
//        url: site_url + '/' + cad_split[0] + '/cambiar_estado_revision_validador',
//        data: formData,
//        method: 'POST',
//        beforeSend: function (xhr) {
//            $('#seccion_validar').html(create_loader());
//        }
//    })
//            .done(function (response) {
//                try {
//                    var response = $.parseJSON(response);
//                    if (response.result === 1) {
//                        $('#mensaje_error_index').html(response.error);
//                        $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-success').addClass('alert-' + response.tipo_msg);
//                        $('#div_error_index').show();
//                        setTimeout("$('#div_error_index').hide()", 5000);
//                        try {
//                            cargar_datos_menu_perfil();
//                            funcion_buscar_docentes_validar();
//                        } catch (e) {
//                            $('#seccion_validar').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
//                        }
//                    } else {
//                        $('#mensaje_error_index').html(response.error);
//                        $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-success').addClass('alert-' + response.tipo_msg);
//                        $('#div_error_index').show();
//                        setTimeout("$('#div_error_index').hide()", 5000);
//
//                    }
//                } catch (e) {
////                $('#seccion_validar').html(response);
//                    $('#seccion_validar').html(response);
//
//                }
//            })
//            .fail(function (jqXHR, response) {
////                $('#div_error').show();
//                $('#seccion_validar').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
////                $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
//            })
//            .always(function () {
//                remove_loader();
//            });
//}




