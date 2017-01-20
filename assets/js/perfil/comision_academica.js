$(function () {
    if($('.btn_agregar_comision_academica_modal').length){
        $('.btn_agregar_comision_academica_modal').on('click', function() {
            data_ajax(site_url+'/perfil/comision_academica_formulario/'+$(this).attr('data-com')+'/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_editar_ca').length){
        $('.btn_editar_ca').on('click', function() {
            data_ajax(site_url+'/perfil/comision_academica_formulario/'+$(this).attr('data-com')+'/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_eliminar_dt').length){
        $('.btn_eliminar_dt').on('click', function() {
            var data_value = $(this).attr('data-value');
            apprise(confirmar_eliminacion, {verify: true}, function(btnClick) {
                if (btnClick) {
                    $.ajax({
                        url: site_url + '/perfil/eliminar_direccion_tesis/'+data_value,
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
    ////Validación
    if($('.btn_validar_ca').length){
        $('.btn_validar_ca').on('click', function() {
            data_ajax(site_url+'/perfil/comision_academica_detalle/'+$(this).attr('data-com')+'/'+$(this).attr('data-value'), null, '#modal_content');
            //data_ajax(site_url+'/perfil/direccion_tesis_detalle/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
});
function ver_ca(elemento){
    data_ajax(site_url+'/perfil_registro/comision_academica_detalle/'+$(elemento).attr('data-com')+'/'+$(elemento).attr('data-value'), null, '#modal_content');
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