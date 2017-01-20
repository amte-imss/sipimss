/*$(function () {
    ///////////Validación
    if($('.btn_ver_ca').length){
        $('.btn_ver_ca').on('click', function() {
            data_ajax(site_url+'/validacion_censo_profesores/comision_academica_detalle/'+$(this).attr('data-com')+'/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_validar_ca').length){
        $('.btn_validar_ca').on('click', function() {
            data_ajax(site_url+'/validacion_censo_profesores/comision_academica_detalle/'+$(this).attr('data-com')+'/'+$(this).attr('data-value')+'?dv='+$(this).attr('data-valid'), null, '#modal_content');
            //data_ajax(site_url+'/perfil/direccion_tesis_detalle/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
});*/
function ver_ca(elemento){
    data_ajax(site_url+'/validacion_censo_profesores/comision_academica_detalle/'+$(elemento).attr('data-com')+'/'+$(elemento).attr('data-value'), null, '#modal_content');
}

function validar_ca(elemento){
    data_ajax(site_url+'/validacion_censo_profesores/comision_academica_detalle/'+$(elemento).attr('data-com')+'/'+$(elemento).attr('data-value')+'?dv='+$(elemento).attr('data-valid'), null, '#modal_content');
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