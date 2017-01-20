$(function () {

    $('#btn_agregar_actividad_modal_nueva').on('click', function () {
        var isReadOnly = $('.nameFields').prop('readonly');
        $('.nameFields').prop('readonly', !isReadOnly);
        var a = hrutes['seccion_actividad_docente'];
        var cad_split = a.split(":");
        var actgralcve = $('#btn_agregar_actividad_modal_nueva').data('actgralcve');
        data_ajax_post(site_url + '/' + cad_split[0] + '/get_data_ajax_actividad_modal/0', null, '#modal_content', {act_gral_cve: actgralcve});
//        data_ajax(site_url + '/' + cad_split[0] + '/get_data_ajax_actividad_modal/0', null, '#modal_content');
        $(this).off();//Para el encadenamiento del post
    });

    $('#btn_guardar_actividad').on('click', function () {//Llama agetget_"data_ajax_actividad" para guardar información
//        data_ajax(site_url + '/perfil/get_data_ajax_actividad/', '#form_actividad_docente', '#get_data_ajax_actividad');
        apprise('Confirme que realmente desea actualizar los datos', {verify: true}, function (btnClick) {
            if (btnClick) {
                $.ajax({
                    url: site_url + '/perfil/seccion_actividad_docente',
                    data: $('#form_actividad_docente').serialize(),
                    method: 'POST',
                    beforeSend: function (xhr) {
                        $('#seccion_actividad_docente').html(create_loader());
                    }
                })
                        .done(function (response) {
//                            alert(response);
                            var html_result = response.split("@");
                            if (html_result.length > 1) {
                                $('#mensaje_error_index').html(html_result[1]);
                                $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-warning').removeClass('alert-info').removeClass('alert-success').addClass('alert-success');
                                $('#div_error_index').show();
                                setTimeout("$('#div_error_index').hide()", 6000);
                                response = html_result[0] + html_result[2];//Carga texto html a mostrar
                            }
                            $('#seccion_actividad_docente').html(response);
                        })
                        .fail(function (jqXHR, response) {
                            $('#seccion_actividad_docente').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                        })
                        .always(function () {
                            remove_loader();
                        });
            } else {
                return false;
            }
            $(this).off();//Para el encadenamiento del post
        });
    });
});

function ver_ad(elemento, tipo){
    data_ajax(site_url+'/perfil_registro/carga_datos_actividad/'+$(elemento).attr('data-value')+'?t='+tipo, null, '#modal_content');
}

function funcion_eliminar_actividad_docente(element) {
    var button_obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var a = hrutes['seccion_actividad_docente'];
    var cad_split = a.split(":");
    var index_tp_actividad = button_obj.data('cvead');
    var index_entidad = button_obj.data('tacve');
    var is_curso_principal = button_obj.data('cp');
    if (is_curso_principal === 1) {
        apprise('Es un curso principal, no es posible eliminar');
    } else {

        apprise('Confirme que realmente desea eliminar la actividad', {verify: true}, function (btnClick) {
            if (btnClick) {
                var button_obj = $(element);
                $.ajax({
                    url: site_url + '/' + cad_split[0] + '/get_data_ajax_eliminar_actividad_modal',
                    data: {
                        index_tp_actividad: index_tp_actividad,
                        index_entidad: index_entidad,
                        is_curso_principal: is_curso_principal,
                    },
                    method: 'POST',
                    beforeSend: function (xhr) {

                    }
                })
                        .done(function (response) {
                            var response = $.parseJSON(response);
                            $('#mensaje_error_index').html(response.error);
                            $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-warning').removeClass('alert-info').removeClass('alert-success').addClass('alert-success');
                            $('#div_error_index').show();

                            $('#id_row_' + button_obj.data('idrow')).remove();
                            setTimeout("$('#div_error_index').hide()", 6000);
                            recargar_fecha_ultima_actualizacion();//Recarga la fecha de la ultima actualización del modulo perfil
                        })
                        .fail(function (jqXHR, response) {
                            $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                            $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
                            $('#div_error').show();
                            setTimeout("$('#div_error').hide()", 6000);
                        })
                        .always(function () {
                            remove_loader();
                        });
            } else {
                return false;
            }
        });
    }


}

function cargar_curso(element) {
    var a = hrutes['seccion_actividad_docente'];
    var cad_split = a.split(":");
    var ctipo_curso_cve = document.getElementById("ctipo_curso").value;

    data_ajax_post(site_url + '/' + cad_split[0] + '/curso_actividad_docente', null, '#curso_div_gen', {ctipo_curso_cve: ctipo_curso_cve});
}

function funcion_asignar_curso_principal(element) {
    var radio_curso_principal = $(element);
    var a = hrutes['seccion_actividad_docente'];
    var cad_split = a.split(":");
    var entidad_tp_a_cve = radio_curso_principal.data('entidadtpacve');
    var act_general_cve = radio_curso_principal.data('actividadgeneralcve');
    var act_docente_cve = radio_curso_principal.data('actividaddocentecve');
    var cp = radio_curso_principal.data('cp');
    var key_row_select = radio_curso_principal.data('keyrowselect');
//    alert(act_general_cve + ' ' + entidad_tp_a_cve + ' ' + act_docente_cve + ' ' + cp);
    //Busca el row de la tabla que contiene el curso principal



    $.ajax({
        url: site_url + '/perfil/get_data_ajax_actualiza_curso_principal',
        data: {
            actividad_general_cve: act_general_cve,
            index_tp_actividad: entidad_tp_a_cve,
            actividad_docente_cve: act_docente_cve,
        },
        method: 'POST',
        beforeSend: function (xhr) {
//            $('#tabla_actividades_docente').html(create_loader());
        }
    })
            .done(function (response) {
                var response = $.parseJSON(response);//
                $('#mensaje_error_div').removeClass('alert-danger').removeClass('alert-success');
                if (response.result === 1) {
                    //Actializa vista de curso principal
                    $('#mensaje_error').html(response.error);
                    var cur_principal = curso_principal_actividad_docente();
                    $('#id_row_' + cur_principal).removeClass('success').addClass('');
                    $('#id_row_' + cur_principal).data("cp", 0);
                    $('#id_row_' + cur_principal).find('td').find('button[id=btn_eliminar_actividad_modal]').data("cp", 0);
                    $('#id_row_' + key_row_select).removeClass('').addClass('success');
                    $('#id_row_' + key_row_select).data("cp", 1);
                    $('#id_row_' + key_row_select).find('td').find('button[id=btn_eliminar_actividad_modal]').data("cp", 1);


                }
                $('#mensaje_error_div').addClass('alert-' + response.tipo_msg);
                $('#mensaje_error').html(response.error);
                $('#div_error').show();
                setTimeout("$('#div_error').hide()", 5000);
            })
            .fail(function (jqXHR, response) {
                $('#mensaje_error_div').removeClass('alert-danger').removeClass('alert-success');
                $('#mensaje_error_div').addClass('alert-danger');
                $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                $('#div_error').show();
                setTimeout("$('#div_error').hide()", 5000);
//                $('#div_error').show();
//                $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
//                $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
            })
            .always(function () {
                remove_loader();
            });

}



/**
 * 
 * @returns {}Obtiene el row de a la tabla de actividad docente que contiene 
 * el curso principal 
 */
function curso_principal_actividad_docente() {
    var row_cur_prin_actual = -1;
    var obj_row;
    for (var i = 0; i < document.getElementById('tabla_actividades').rows.length; i++) {
        obj_row = $(document.getElementById('tabla_actividades').rows[i]);
        if (obj_row.data('cp') === '1' || obj_row.data('cp') === 1) {
            row_cur_prin_actual = obj_row.data('keyrow');
            break;
        }
    }
    return row_cur_prin_actual;
}

function funcion_agregar_nueva_actividad() {
    //////////////
    var valor_radio_curso = '123';
    var titulo_tipo_actividad = 'titulo prueba';
    var anio = '2005';
    var duracion = '78';
    var fecha_inicio = '78';
    var fecha_fin = '546';
    var tacve = '100';
    var cvead = '30';
    var cp = '0';
    var idrow = funcion_obtener_max_id_row_table_actividad() + 1;//Obtiene el maximo index de el row de la tabla de actividades
    ////////////

    var htmlRowTemplate = $('#template_row_nueva_act').html();
    var htmlNewRow = htmlRowTemplate.replace(/\$\$valor_radio_curso\$\$/g, valor_radio_curso)
            .replace(/\$\$titulo_tipo_actividad\$\$/g, titulo_tipo_actividad)
            .replace(/\$\$anio\$\$/g, anio)
            .replace(/\$\$duracion\$\$/g, duracion)
            .replace(/\$\$fecha_inicio\$\$/g, fecha_inicio)
            .replace(/\$\$fecha_fin\$\$/g, fecha_fin)
            .replace(/\$\$tacve\$\$/g, tacve)
            .replace(/\$\$cvead\$\$/g, cvead)
            .replace(/\$\$cp\$\$/g, cp)
            .replace(/\$\$idrow\$\$/g, idrow)
            .replace(/\$\$key\$\$/g, idrow);//identificador unitario de el row
    $('#tabla_actividades').append($(htmlNewRow));
}

/**
 * 
 * @returns {Number} Recorre los row(s) de la tabla actividad docente, para 
 * obtener el index máximo del row
 */
function funcion_obtener_max_id_row_table_actividad() {
    var index_macx = -1;
    var obj_row;

    for (var i = 0; i < document.getElementById('tabla_actividades').rows.length; i++) {
        obj_row = $(document.getElementById('tabla_actividades').rows[i]);
        if (index_macx < obj_row.data('keyrow')) {
            index_macx = obj_row.data('keyrow');
        }
    }
    return index_macx;
}


//function funcion_guargar(index) {
//    data_ajax(site_url + '/perfil/get_data_ajax_actividad_cuerpo_modal/' + index + '/1/0', '#form_actividad_docente_especifico', '#info_actividad_docente');
//}
function funcion_guardar(element) {
    var a = hrutes['seccion_actividad_docente'];
    var cad_split = a.split(":");
    var act_doc_cve = 0;
    var cve_tipo_actividad = document.getElementById("ctipo_actividad_docente").value;
    var act_gral_cve = $(element).data("actgralcve");
    var formData = $('#form_actividad_docente_especifico').serialize();
    formData += '&act_doc_cve=' + act_doc_cve + '&cve_tipo_actividad=' + cve_tipo_actividad + '&act_gral_cve=' + act_gral_cve;//Agrega tipo de actividad
    if ($('#idc').length) { //Validar carga de archivo
        $.ajax({
            url: site_url + '/' + cad_split[0] + '/get_add_actividad_docente',
            data: formData,
            method: 'POST',
            beforeSend: function (xhr) {
                $('#info_actividad_docente').html(create_loader());
            }
        })
                .done(function (response) {
                    try {
                        if (response) {
                            var response_json = $.parseJSON(response);//
//                            var titulo_tipo_actividad = response_json.insertar[0].nombre_tp_actividad;
//                            var anio = response_json.insertar[0].anio;
//                            var duracion = response_json.insertar[0].duracion;
//                            var fecha_inicio = response_json.insertar[0].fecha_inicio;
//                            var fecha_fin = response_json.insertar[0].fecha_fin;
//                            var tacve = response_json.insertar[0].ta_cve;
//                            var cvead = response_json.insertar[0].cve_actividad_docente;
//                            var cve_actividad_general = response_json.insertar[0].actividad_general_cve;
//                            var cp = 0;
//                            var idrow = funcion_obtener_max_id_row_table_actividad() + 1;//Obtiene el maximo index de el row de la tabla de actividades
//                            ////////////
//                            duracion = (duracion === null) ? '' : duracion;
//                            fecha_inicio = (fecha_inicio === null) ? '' : fecha_inicio;
//                            fecha_fin = (fecha_fin === null) ? '' : fecha_fin;
//
//                            var htmlRowTemplate = $('#template_row_nueva_act').html();
//                            var htmlNewRow = htmlRowTemplate.replace(/\$\$titulo_tipo_actividad\$\$/g, titulo_tipo_actividad)
//                                    .replace(/\$\$anio\$\$/g, anio)
//                                    .replace(/\$\$duracion\$\$/g, duracion)
//                                    .replace(/\$\$fecha_inicio\$\$/g, fecha_inicio)
//                                    .replace(/\$\$fecha_fin\$\$/g, fecha_fin)
//                                    .replace(/\$\$tacve\$\$/g, tacve)
//                                    .replace(/\$\$cvead\$\$/g, cvead)
//                                    .replace(/\$\$cp\$\$/g, cp)
//                                    .replace(/\$\$idrow\$\$/g, idrow)
//                                    .replace(/\$\$key\$\$/g, idrow)//identificador unitario de el row
//                                    .replace(/\$\$actividadgeneralcve\$\$/g, cve_actividad_general);//identificador unitario de el row
//                            $('#tabla_actividades').append($(htmlNewRow));
                            recargar_opcion_menu_mostrar_mensaje('seccion_actividad_docente', true, response_json.error);

                        }
                    } catch (e) {
                        $('#info_actividad_docente').html(response);
                    }
                })
                .fail(function (jqXHR, response) {
                    $('#info_actividad_docente').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                })
                .always(function () {
                    remove_loader();
                });
    } else {
        $('#error_carga_archivo').html(html_message("Falta cargar archivos", 'danger'));
    }
}

/**
 * 
 * @param {type} element  (this)
 * @returns {undefined} 
 * Función del botón editar actividad docente. 
 */
function funcion_editar_reg_actividad(element) {
    var a = hrutes['seccion_actividad_docente'];
    var cad_split = a.split(":");
    var obj = $(element);
    var tp_actividad_cve = obj.data('tacve');
    var act_doc_cve = obj.data('cvead');
    data_ajax_post(site_url + '/' + cad_split[0] + '/get_data_ajax_actividad_modal/1', null, '#modal_content', {act_doc_cve: act_doc_cve, tp_actividad_cve: tp_actividad_cve});
}
/**
 * 
 * @param {type} element  (this)
 * @returns {undefined} 
 * Función del botón editar actividad docente. 
 */
function funcion_actualizar_actividad_docente(element) {
    var a = hrutes['seccion_actividad_docente'];
    var cad_split = a.split(":");
    var obj = $(element);
    var tp_actividad_cve = obj.data('tpactividadcve');
    var act_doc_cve = obj.data('invcve');
    var comprobantecve = obj.data('comprobantecve');
    var formData = $('#form_actividad_docente_especifico').serialize();
    formData += '&act_doc_cve=' + act_doc_cve + '&cve_tipo_actividad=' + tp_actividad_cve + '&comprobantecve=' + comprobantecve;//Agrega tipo de actividad
    if ($('#idc').length) {
        $.ajax({
            url: site_url + '/' + cad_split[0] + '/get_add_actividad_docente',
            data: formData,
            method: 'POST',
            beforeSend: function (xhr) {
                $('#info_actividad_docente').html(create_loader());
            }
        })
                .done(function (response) {
                    try {
                        var json = $.parseJSON(response);
                        recargar_opcion_menu_mostrar_mensaje('seccion_actividad_docente', json.satisfactorio, json.error);
                    } catch (e) {
                        $('#info_actividad_docente').html(response);
                    }
                })
                .fail(function (jqXHR, response) {
//                recargar_opcion_menu_mostrar_mensaje('', false, 'Guardado satisfactorio');
                    $('info_actividad_docente').html(response);
                })
                .always(function () {
                    remove_loader();
                });
    } else {
        $('#error_carga_archivo').html(html_message("Falta cargar archivos", 'danger'));
    }
}

/**
 * Carga formulario vista de formulario, según la opción del combo seleccionada
 * @returns {undefined}
 */
function function_carga_form_actividad_doc() {
    var tp_actividad_cve = document.getElementById("ctipo_actividad_docente").value;
    if (parseInt(tp_actividad_cve) < 1) {
        $('#id_pie_modal_actividad_docente').hide();
    } else {
        $('#id_pie_modal_actividad_docente').show();
    }
    var data_post = {tp_actividad_cve: tp_actividad_cve}//Datos a enviar 
    data_ajax_post(site_url + '/perfil/get_vista_form_act_docente', null, '#info_actividad_docente', data_post);

//    $('#info_actividad_docente').html(response.error);
//    $('#info_actividad_docente').removeClass('alert-danger').removeClass('alert-warning')
//            .removeClass('alert-info').removeClass('alert-success').addClass(response.tipo_msg);
}

function mostrar_horas_fechas(horas) {
    if (horas == 'none') {
        document.getElementById('div_horas_dedicadas').style.display = 'none';
        document.getElementById('fecha_inicio').style.display = 'block';
        document.getElementById('fecha_fin').style.display = 'block';
    } else {
        document.getElementById('div_horas_dedicadas').style.display = 'block';
        document.getElementById('fecha_inicio').style.display = 'none';
        document.getElementById('fecha_fin').style.display = 'none';
    }
}

function funcion_guargar(element) {
    var obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var tp_actividad_cve = obj.data('tpactividadcve');
    var data_post = {tp_actividad_cve: tp_actividad_cve}
    data_ajax_post(site_url + '/perfil/get_data_ajax_actividad_cuerpo_modal', '#form_actividad_docente_especifico', '#info_actividad_docente', data_post);
}



