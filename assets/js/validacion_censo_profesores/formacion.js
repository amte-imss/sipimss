$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    /*///////////Validación
    if($('.btn_ver_fs').length){
        $('.btn_ver_fs').on('click', function() {
            data_ajax(site_url+'/validacion_censo_profesores/formacion_salud_detalle/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_validar_fs').length){
        $('.btn_validar_fs').on('click', function() {
            data_ajax(site_url+'/validacion_censo_profesores/formacion_salud_detalle/'+$(this).attr('data-value')+'/'+$(this).attr('data-valid'), null, '#modal_content');
        });
    }
    if($('.btn_ver_fd').length){
        $('.btn_ver_fd').on('click', function() {
            data_ajax(site_url+'/validacion_censo_profesores/formacion_docente_detalle/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_validar_fd').length){
        $('.btn_validar_fd').on('click', function() {
            data_ajax(site_url+'/validacion_censo_profesores/formacion_docente_detalle/'+$(this).attr('data-value')+'/'+$(this).attr('data-valid'), null, '#modal_content');
        });
    }*/
});
function ver_fs(elemento){
    data_ajax(site_url+'/validacion_censo_profesores/formacion_salud_detalle/'+$(elemento).attr('data-value'), null, '#modal_content');
}
function validar_fs(elemento){
    data_ajax(site_url+'/validacion_censo_profesores/formacion_salud_detalle/'+$(elemento).attr('data-value')+'/'+$(elemento).attr('data-valid'), null, '#modal_content');
}
function ver_fd(elemento){
    data_ajax(site_url+'/validacion_censo_profesores/formacion_docente_detalle/'+$(elemento).attr('data-value'), null, '#modal_content');
}
function validar_fd(elemento){
    data_ajax(site_url+'/validacion_censo_profesores/formacion_docente_detalle/'+$(elemento).attr('data-value')+'/'+$(elemento).attr('data-valid'), null, '#modal_content');
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
