var menu_busqueda_validar_censo = new Object();
menu_busqueda_validar_censo['matricula'] = 'Matrícula';
menu_busqueda_validar_censo['nombre'] = 'Nombre del empleado';

$(function() {
    if($('#btn_buscar_docentes_evaluacion').length){
        $('#btn_buscar_docentes_evaluacion').on('click', function() {
            data_ajax(site_url+'/evaluacion_docente/buscar_docentes_evaluacion', '#form_busqueda_docentes_evaluar', '#div_result_docentes_evaluacion');
        });
    }
    data_ajax(site_url+'/evaluacion_docente/buscar_docentes_evaluacion', '#form_busqueda_docentes_evaluar', '#div_result_docentes_evaluacion');
});

function funcion_buscar_docentes_evaluar() {
    var path = site_url + '/evaluacion_docente/buscar_docentes_evaluacion/0';
    var val_post = $('#form_busqueda_docentes_validar').serialize();
    data_ajax(path, '#form_busqueda_docentes_evaluar', '#div_result_docentes_evaluacion');
}

/**
 * 
 * @param {type} name Menu de opciónes de filtro
 * @returns {undefined}
 */
function funcion_menu_tipo_busqueda_evaluar_censo(name) {
    var text = menu_busqueda_validar_censo[name];//Busca en el hashmap el nombre indicado
    $("#menu_select").val(name);//Modifica el valor del menu
    $("#btn_buscar_por").text(text);//Cambia el texto del botón
    $("#btn_buscar_por").append('<span class="caret"> </span>');//Agregar span al botón para mostrar icono flechita
    $("#buscador_docente").attr('data-original-title', 'Buscar por ' + text);//Cambia el texto del la caja de texto 
    $("#btn_buscar_b").attr('data-original-title', 'Buscar por ' + text);//Cambia el texto del botón
}

function runScript_busqueda_val(e) {
    if (e.keyCode == 13) {
        $("#btn_buscar_docentes_evaluacion").trigger("click");//Dispara el onclic del botón buscar validador en el sied
        return false;
    }
}

function funcion_ver_validacion_empleado(element) {
    var button_obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var empcve = button_obj.data('empcve');
    var matricula = button_obj.data('matricula');
    var estval = button_obj.data('estval');
    //var histvalcve = button_obj.data('histvalcve');
    var solicitud_cve = button_obj.data('solicitudcve');
    var usuario_cve = button_obj.data('usuariocve');
    var idrow = button_obj.data('usuariocve');
    //Remover contenido de un div 
    $('#select_perfil_validar').empty();
    var obj_post = { empcve: empcve, matricula: matricula, estval: estval, 
        usuario_cve: usuario_cve, solicitud_cve: solicitud_cve };
    data_ajax_post(site_url + '/evaluacion_docente/seccion_index', null, '#select_perfil_validar_evaluacion', obj_post);
}

function funcion_cerrar_validacion_empleado(element) {
    $('#select_perfil_validar').empty();
    data_ajax_post(site_url + '/evaluacion_docente/seccion_delete_datos_validado', null, null);
}

function ver_curso(elemento) {
    var value = $(elemento).attr('data-value');
    var seccion = $(elemento).attr('data-seccion');
    var tipo = $(elemento).attr('data-tipo');
    var is_post = $(elemento).attr('data-ispost');
//    alert(curso + " " + seccion);
    if (parseInt(is_post) == 1) {
        var objPost = {tipo: tipo, value: value}
        data_ajax_post(site_url + '/perfil_registro/' + seccion + '/', null, '#modal_content', objPost);
    } else {
        if (tipo.length > 0) {
            data_ajax(site_url + '/perfil_registro/' + seccion + '/' + value + '?t=' + tipo, null, '#modal_content');
        } else {
            data_ajax(site_url + '/perfil_registro/' + seccion + '/' + value, null, '#modal_content');
        }
    }
}