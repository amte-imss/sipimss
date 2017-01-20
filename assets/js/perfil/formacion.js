$(function () {
    if($('.btn_agregar_ejercicio').length){
        $('.btn_agregar_ejercicio').on('click', function() {
            var data_value = $("#ejercicio_profesional").val();
            $.ajax({
                url: site_url + '/perfil/formacion_ejercicio_profesional',
                method: 'POST',
                dataType: "json",
                data: { 'ejercicio_profesional': data_value },
                beforeSend: function(xhr) {
                    $('#mensaje1').html(create_loader());
                }
            })
            .done(function(response) {
                $('#mensaje1').html(response.msg);
                if(response.result==true){
                    $('#div_datos_salud').show();
                }
            })
            .fail(function(jqXHR, response) {
                $('#mensaje1').html(imprimir_resultado(response));
            })
            .always(function() {
                remove_loader();
                recargar_fecha_ultima_actualizacion();
            });

        });
    }
    if($('.btn_agregar_formacion_salud_modal').length){
        $('.btn_agregar_formacion_salud_modal').on('click', function() {
            data_ajax(site_url+'/perfil/formacion_salud_formulario/?es_inicial='+$(this).attr('data-value'), null, '#modal_content');
        });
    }
	  if($('.btn_agregar_formacion_docente_modal').length){
        $('.btn_agregar_formacion_docente_modal').on('click', function() {
            data_ajax(site_url+'/perfil/formacion_docente_formulario/', null, '#modal_content');
        });
    }
    if($('.btn_editar_fi').length){
        $('.btn_editar_fi').on('click', function() {
            data_ajax(site_url+'/perfil/formacion_salud_formulario/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_eliminar_fi').length){
        $('.btn_eliminar_fi').on('click', function(e) {
            var data_value = $(this).attr('data-value');
            apprise(confirmar_eliminacion, {verify: true}, function(btnClick) {
                if (btnClick) {
                    $.ajax({
                        url: site_url + '/perfil/eliminar_formacion_salud/'+data_value,
                        method: 'POST',
                        dataType: "json",
                        beforeSend: function(xhr) {
                            $('#mensaje1').html(create_loader());
                        }
                    })
                    .done(function(response) {
                        $('#mensaje1').html(imprimir_resultado(response));
                        if(response.result==true){
                            $('#tr_'+data_value).slideUp( "slow", function() { //Ocultar fila del registro
                                $('#tr_'+data_value).remove(); //Eliminar fila
                            });
                        }
                    })
                    .fail(function(jqXHR, response) {
                        $('#mensaje1').html(imprimir_resultado(response));
                    })
                    .always(function() {
                        remove_loader();
                        recargar_fecha_ultima_actualizacion();
                    });
                } else {
                    return false;
                }
            });
            //$(this).off(e);
        });
    }
    if($('.btn_editar_fd').length){
        $('.btn_editar_fd').on('click', function() {
            data_ajax(site_url+'/perfil/formacion_docente_formulario/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_eliminar_fd').length){
        $('.btn_eliminar_fd').on('click', function() {
            var data_value = $(this).attr('data-value');
            apprise(confirmar_eliminacion, {verify: true}, function(btnClick) {
                if (btnClick) {
                    $.ajax({
                        url: site_url + '/perfil/eliminar_formacion_docente/'+data_value,
                        method: 'POST',
                        dataType: "json",
                        beforeSend: function(xhr) {
                            $('#mensaje').html(create_loader());
                        }
                    })
                    .done(function(response) {
                        $('#mensaje').html(imprimir_resultado(response));
                        if(response.result==true){
                            $('#tr_'+data_value).slideUp( "slow", function() { //Ocultar fila del registro
                                $('#tr_'+data_value).remove(); //Eliminar fila
                            });
                        }
                    })
                    .fail(function(jqXHR, response) {
                        $('#mensaje').html(imprimir_resultado(response));
                    })
                    .always(function() {
                        remove_loader();
                        recargar_fecha_ultima_actualizacion();
                    });
                } else {
                    return false;
                }
            });
        });
    }
    ///////////Validación
    if($('.btn_validar_fs').length){
        $('.btn_validar_fs').on('click', function() {
            data_ajax(site_url+'/perfil/formacion_salud_detalle/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_validar_fd').length){
        $('.btn_validar_fd').on('click', function() {
            data_ajax(site_url+'/perfil/formacion_docente_detalle/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
});
function ver_fs(elemento){
    data_ajax(site_url+'/perfil_registro/formacion_salud_detalle/'+$(elemento).attr('data-value'), null, '#modal_content');
}
function ver_fd(elemento){
    data_ajax(site_url+'/perfil_registro/formacion_docente_detalle/'+$(elemento).attr('data-value'), null, '#modal_content');
}
function mostrar_horas_fechas(horas) {
    if (horas == 'none') {
        $('#div_horas_dedicadas').hide('slow');
        $('#fecha_inicio').show('slow');
        $('#fecha_fin').show('slow');
    } else {
        $('#div_horas_dedicadas').show('slow');
        $('#fecha_inicio').hide('slow');
        $('#fecha_fin').hide('slow');
    }
}
