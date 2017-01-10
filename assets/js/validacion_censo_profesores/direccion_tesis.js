$(function () {
    ///////////Validación
    /*if($('.btn_ver_dt').length){
        $('.btn_ver_dt').on('click', function() {
            data_ajax(site_url+'/validacion_censo_profesores/direccion_tesis_detalle/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }
    if($('.btn_validar_dt').length){
        $('.btn_validar_dt').on('click', function() {
            data_ajax(site_url+'/validacion_censo_profesores/direccion_tesis_detalle/'+$(this).attr('data-value')+'/'+$(this).attr('data-valid'), null, '#modal_content');
        });
    }*/
});
function ver_dt(elemento){
    data_ajax(site_url+'/validacion_censo_profesores/direccion_tesis_detalle/'+$(elemento).attr('data-value'), null, '#modal_content');
}

function validar_dt(elemento){
    data_ajax(site_url+'/validacion_censo_profesores/direccion_tesis_detalle/'+$(elemento).attr('data-value')+'/'+$(elemento).attr('data-valid'), null, '#modal_content');
}