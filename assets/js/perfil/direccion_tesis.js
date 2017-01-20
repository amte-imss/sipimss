$(function () {
    if($('#btn_agregar_direccion_tesis_modal').length){
        $('#btn_agregar_direccion_tesis_modal').on('click', function() {
            data_ajax(site_url+'/perfil/direccion_tesis_formulario/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_editar_dt').length){
        $('.btn_editar_dt').on('click', function() {
            data_ajax(site_url+'/perfil/direccion_tesis_formulario/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_eliminar_dt').length){
        /*$('.btn_eliminar_dt').on('click', function() {
            data_ajax(site_url+'/perfil/eliminar_direccion_tesis/'+$(this).attr('data-value'), null, '#modal_content');
        });*/
        $('.btn_eliminar_dt').on('click', function(e) {
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
                        /*try {
                            //var json = $.parseJSON(response);
                            recargar_opcion_menu_mostrar_mensaje('seccion_direccion_tesis', response.result, response.msg);
                        } catch (e) {
                            $('#mensaje').html(response);
                        }*/
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
            //$(this).off(e);
        });
    }
    ///////////Validación
    /*if($('.btn_validar_dt').length){
        $('.btn_validar_dt').on('click', function() {
            data_ajax(site_url+'/perfil/direccion_tesis_detalle/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }*/
});
function ver_dt(elemento){
    data_ajax(site_url+'/perfil_registro/direccion_tesis_detalle/'+$(elemento).attr('data-value'), null, '#modal_content');
}