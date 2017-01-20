
$(function () {

    $('#btn_agregar_investigacion_modal').on('click', function () {
        var isReadOnly = $('.nameFields').prop('readonly');
        $('.nameFields').prop('readonly', !isReadOnly);
        var a = hrutes['seccion_investigacion'];
        var cad_split = a.split(":");
        data_ajax(site_url + '/' + cad_split[0] + '/cargar_formulario_investigacion', null, '#modal_content');
    });

    $('#btn_guardar_actividad').on('click', function () {//Llama agetget_"data_ajax_actividad" para guardar información
//        data_ajax(site_url + '/perfil/get_data_ajax_actividad/', '#form_actividad_docente', '#get_data_ajax_actividad');
        apprise('Confirme que realmente desea actualizar los datos', {verify: true}, function (btnClick) {
            if (btnClick) {
                $.ajax({
                    url: site_url + '/perfil/get_data_ajax_actividad',
//                    data: $('#form_actividad_docente').serialize(),
                    method: 'POST',
                    mimeType: "multipart/form-data",
                    contentType: false,
                    beforeSend: function (xhr) {
                        $('#get_data_ajax_actividad').html(create_loader());
                    }
                })
                        .done(function (response) {
//                            alert(response);
                            $('#get_data_ajax_actividad').html(response);
                            $('#mensaje_error').html('Los datos se almacenaron correctamente');
                            $('#mensaje_error_div').removeClass('alert-danger').addClass('alert-success');
                            $('#div_error').show();
                            setTimeout("$('#div_error').hide()", 5000);//desaparece div
                        })
                        .fail(function (jqXHR, response) {
                            $('#get_data_ajax_actividad').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                        })
                        .always(function () {
                            remove_loader();
                        });
            } else {
                return false;
            }
        });
    });

});

function ver_in(elemento){
    data_ajax(site_url+'/perfil_registro/carga_datos_investigacion/'+$(elemento).attr('data-value'), null, '#modal_content');
}

function funcion_eliminar_reg_investigacion(element) {
    var a = hrutes['seccion_investigacion'];
    var cad_split = a.split(":");
    var button_obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var index_inv = button_obj.data('invcve');
    var comprobante_cve = button_obj.data('comprobantecve');
    var idrow = button_obj.data('idrow');
    apprise('Confirme que realmente desea eliminar el registro de investigación', {verify: true}, function (btnClick) {
        if (btnClick) {
            $.ajax({
                url: site_url + '/' + cad_split[0] + '/get_data_ajax_eliminar_investigacion',
                data: {
                    index_inv: index_inv,
                    comprobante_cve: comprobante_cve,
                },
                method: 'POST',
                beforeSend: function (xhr) {
                }
            })
                    .done(function (response) {
                        var response = $.parseJSON(response);
                        $('#mensaje_error_index').html(response.error);
                        $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-success').addClass('alert-' + response.tipo_msg);
                        $('#id_row_' + idrow).remove();
                        $('#div_error_index').show();
                        setTimeout("$('#div_error_index').hide()", 5000);
                        recargar_fecha_ultima_actualizacion();
                    })
                    .fail(function (jqXHR, response) {
                        $('#mensaje_error_index').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                        $('#mensaje_error_div_index').removeClass('alert-success').addClass('alert-danger');
                        $('#div_error_index').show();
                        setTimeout("$('#div_error_index').hide()", 6000);
                    })
                    .always(function () {
                        remove_loader();
                    });
        } else {
            return false;
        }
    });
}


function funcion_guardar_investigacion(element) {
//    data_ajax(site_url + '/perfil/get_data_ajax_actividad_cuerpo_modal/' + index + '/1/0', '#form_actividad_docente_especifico', '#info_actividad_docente');
    var a = hrutes['seccion_investigacion'];
    var cad_split = a.split(":");
    var obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var comprobantecve = obj.data('comprobantecve');
    var formData = new FormData($('#form_investigacion_docente')[0]);
    formData.append("comprobantecve", comprobantecve);
    var cve_divulgacion = parseInt($("#cmedio_divulgacion").val());
    var validacion_comprobante = (cve_divulgacion === 1 || cve_divulgacion === 2);//Valida que las opciones carguen un comprobante
    var validacion_cargado_comprobante = (validacion_comprobante) ? $('#idc').length : true;
    if (validacion_cargado_comprobante) { //Validar carga de archivo
        $.ajax({
            url: site_url + '/' + cad_split[0] + '/ajax_add_investigacion',
            data: formData,
            type: 'POST',
            mimeType: "multipart/form-data", //Para subir archivos 
            contentType: false, //Limpía el formulario
            cache: false,
            processData: false,
            beforeSend: function (xhr) {
                $('#cuerpo_modal').html(create_loader());
            }
        })
                .done(function (response) {
                    try {
                        var json = $.parseJSON(response);
                        recargar_opcion_menu_mostrar_mensaje('seccion_investigacion', json.satisfactorio, json.error);
                    } catch (e) {
                        $('#cuerpo_modal').html(response);
                    }
                })
                .fail(function (jqXHR, response) {
//                recargar_opcion_menu_mostrar_mensaje('', false, 'Guardado satisfactorio');
                    $('cuerpo_modal').html(response);
                })
                .always(function () {
                    remove_loader();
                });
    } else {
        $('#error_carga_archivo').html(html_message("Falta cargar archivos", 'danger'));
    }

}

function funcion_obtener_max_id_row_table_tabla_investigacion_docente() {
    var index_macx = -1;
    var obj_row;

    for (var i = 0; i < document.getElementById('tabla_investigacion_docente').rows.length; i++) {
        obj_row = $(document.getElementById('tabla_investigacion_docente').rows[i]);
        if (index_macx < obj_row.data('keyrow')) {
            index_macx = obj_row.data('keyrow');
        }
    }
    return index_macx;
}

/**
 * @author LEAS
 * @fecha creación : 20/07/2016
 * @param {type} elementos
 * @returns {undefined}
 */
function funcion_mostrar_tipo_publicacion() {
    var a = hrutes['seccion_material_educativo'];
    var cad_split = a.split(":");
    var cve_divulgacion = $("#cmedio_divulgacion").val();
    $.ajax({
        url: site_url + '/' + cad_split[0] + '/cargar_opcion_divulgacion',
        data: {cve_divulgacion: cve_divulgacion},
        method: 'POST',
        beforeSend: function (xhr) {
            $('#div_mostrar_comprobante_libro_revista').html(create_loader());
        }
    })
            .done(function (response) {
                $('#div_mostrar_comprobante_libro_revista').html(response);
            })
            .fail(function (jqXHR, response) {
            })
            .always(function () {
                remove_loader();
            });
}

/**
 * @author LEAS
 * @fecha creación : 20/07/2016
 * @param {type} elementos
 * @returns {undefined}
 */
function funcion_agregar_elemento(element) {
    nextinput++;
    var obj = $(element);
//    alert(obj.data('keyname'));
    var key = obj.data('keyname');
    //Control de cantidad de elementos
    if (!control_generados.hasOwnProperty(key)) {
        control_generados[key] = '0';
    }
    var propiedades = htipos_bibliografia[key];
    var array_prop = propiedades.split('|');
    var cdadPermitida = parseInt(array_prop[0]);
    var ctr_cdad_permitida = parseInt(control_generados[key]);
//    alert(cdadPermitida + ' ' + ctr_cdad_permitida);

    var is_valido = (cdadPermitida === -1) ? true : false;//Verifica si se debe agregar infinitamente elementos
    is_valido = (is_valido) ? true : (ctr_cdad_permitida > -1 && ctr_cdad_permitida < cdadPermitida); //Si n o se agregan infinitamente, verifica que la cantidad permitida sea menor o igual que los componentes agregados

    if (is_valido) {//Valida que se tenga permitido agreagar más elementos 
        var name_data_btn_control = array_prop[1];
        var id_div = array_prop[2];
        var id_btn_agregar = array_prop[3];

        var array_name_inputs = array_prop[4].split('$');
        var array_place_holder = array_prop[5].split('$');
        var titulo = array_prop[6];
//    console.log('cont -> ' + name_data_btn_control);
//    campo = '<ul id="' + name_data_btn_control + nextinput + '"><li name="autores' + nextinput + '" ><p>Autor(' + nextinput + '):</p>\n\
//                <input type="text"  size="50" id="autor_nom' + nextinput + '" name="autor_nom' + nextinput + '" placeholder = "Nombre(s)" />\n\
//                <input type="text"  size="50" id="autor_ap' + nextinput + '" name="autor_ap' + nextinput + '"  placeholder = "Apellido paterno"/>\n\
//                <input type="text"  size="50" id="autor_am' + nextinput + '" name="autor_am' + nextinput + '" placeholder = "Apellido materno" />\n\
//                <button type="button" class="btn btn-link btn-sm" name = "els" id="btn_eliminar_actividad_modal" data-keyname ="' + name_data_btn_control + '" data-rowli="' + name_data_btn_control + nextinput + '" onclick="funcion_eliminar_li(this)" >Eliminar</button>\n\n\
//             </li></ul>';
        //Genera los inputs
        var inputs = '';
        for (var i = 0; i < array_name_inputs.length - 1; i++) {
            inputs += '<input type="text"  class="form-control" size="500" id="' + array_name_inputs[i] + nextinput + '" name="' + array_name_inputs[i] + nextinput + '" placeholder = "' + array_place_holder[i] + '" />\n'
        }

        campo = '<ul id="' + name_data_btn_control + nextinput + '"><li name="autores' + nextinput + '" ><p>' + titulo + '(' + nextinput + '):</p>\n\
                ' + inputs + '\
                <button type="button" class="btn btn-link btn-sm" name = "els" id="btn_eliminar_actividad_modal" data-keyname ="' + name_data_btn_control + '" data-rowli="' + name_data_btn_control + nextinput + '" onclick="funcion_eliminar_li(this)" >Eliminar</button>\n\n\
             </li></ul>';
        add_autor = '<button type="button" class="btn btn-link btn-sm" id="' + id_btn_agregar + '"; data-keyname="' + name_data_btn_control + '"; onclick="funcion_agregar_elemento(this);" >' + titulo + '</button>';
        //Genera el boton agregar
        $("#" + id_div).append(campo);
        $("#" + id_btn_agregar).remove();
        valores_label(id_div);
        control_generados[key] = ctr_cdad_permitida + 1;
        if (cdadPermitida === -1 || (cdadPermitida > (ctr_cdad_permitida + 1))) {//Si ya rebasa el máximo de elementos, no se agrega
            $("#" + id_div).append(add_autor);
        }

    }
}

function funcion_eliminar_li(element) {
    var obj = $(element);
    var key = obj.data('keyname');
    var propiedades = htipos_bibliografia[key];
    var array_prop = propiedades.split('|');
    var cdadPermitida = parseInt(array_prop[0]);
    var elementos_existentes = parseInt(control_generados[key]);//Cantidad de elementos existentes
    var id_uili = obj.data('rowli'); //Nombre del <li> a eliminar 
    var id_div = array_prop[2];//Nombre del div

    $('#' + id_uili).remove();
    valores_label(id_div);

    control_generados[key] = elementos_existentes - 1;

    if (!(elementos_existentes > -1 && elementos_existentes < cdadPermitida)) {//Si ya rebasa el máximo de elementos, no se agrega
        var name_data_btn_control = array_prop[1];
        var id_btn_agregar = array_prop[3];
        var titulo = array_prop[6];
        add_autor = '<button type="button" class="btn btn-link btn-sm" id="' + id_btn_agregar + '"; data-keyname="' + name_data_btn_control + '"; onclick="funcion_agregar_elemento(this);" >' + titulo + '</button>';
        $("#" + id_div).append(add_autor);
    }

}

/**
 * 
 * @returns {}Obtiene el row de a la tabla de actividad docente que contiene 
 * el curso principal 
 */
function valores_label(id_div) {
    var inc = 1;
    $("#" + id_div + " p").each(function (i)
    {
        var pos_1 = $(this).text().indexOf('(');
        var pos_2 = $(this).text().indexOf(')');
        var text = $(this).text().substr(0, pos_1);
        var text = text + '(' + inc + $(this).text().substr(pos_2);
        $(this).text(text);
        inc++;
//        console.log('cont -> ' + text);
//        console.log($(this).text());
    });
}




function funcion_editar_reg_investigacion(element) {
    var a = hrutes['seccion_investigacion'];
    var cad_split = a.split(":");
    var obj = $(element);
    var cve_inv = obj.data('invcve');
    var comprobantecve = obj.data('comprobantecve');
//    datos_form_serializados += '&cve_inv='+cve_inv+'&carga_datos=0'+'&idrow='+idrow+'&comprovantecve='+comprovantecve;

    $.ajax({
        url: site_url + '/' + cad_split[0] + '/ajax_carga_datos_investigacion',
        data: {cve_inv: cve_inv, comprobantecve: comprobantecve},
        method: 'POST',
        beforeSend: function (xhr) {
            $('#modal_content').html(create_loader());
        }
    })
            .done(function (response) {
//                var is_html = response.indexOf('<div class=\"list-group\">');//si existe la cadena, entonces es un html
//                if (is_html > -1) {
//                }
                $('#modal_content').html(response);
            })
            .fail(function (jqXHR, response) {
                $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
            })
            .always(function () {
                remove_loader();
            });
}

function funcion_actualizar_investigacion(element) {
    var a = hrutes['seccion_investigacion'];
    var cad_split = a.split(":");
    var obj = $(element);
    var cve_inv = obj.data('invcve');
    var idrow = obj.data('idrow');
    var comprobantecve = obj.data('comprobantecve');
    var formData = new FormData($('#form_investigacion_docente')[0]);
    formData.append("comprobantecve", comprobantecve);
    formData.append("cve_inv", cve_inv);
//    cve_inv : cve_inv, carga_datos : 0
//    alert('sasasdasd asda,sdmlamk da sdkjaskdm ,aksmd lksa dmk F');
    var cve_divulgacion = parseInt($("#cmedio_divulgacion").val());
    var validacion_comprobante = (cve_divulgacion === 1 || cve_divulgacion === 2);//Valida que las opciones carguen un comprobante
    var validacion_cargado_comprobante = (validacion_comprobante) ? $('#idc').length : true;
    if (validacion_cargado_comprobante) { //Validar carga de archivo
        $.ajax({
            url: site_url + '/' + cad_split[0] + '/ajax_update_investigacion',
            data: formData,
            type: 'POST',
            contentType: false, //Limpía el formulario
            processData: false,
//  
            beforeSend: function (xhr) {
                $('#cuerpo_modal').html(create_loader());
            }
        })
                .done(function (response) {
                    try {
                        var json = $.parseJSON(response);
                        recargar_opcion_menu_mostrar_mensaje('seccion_investigacion', json.satisfactorio, json.error);
                    } catch (e) {
                        $('#cuerpo_modal').html(response);
                    }
                })
                .fail(function (jqXHR, response) {
                    $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                })
                .always(function () {
                    remove_loader();
                });
    } else {
        $('#error_carga_archivo').html(html_message("Falta cargar archivos", 'danger'));
    }

}

function funcion_mostrar_medio_divulgacion(tipo_medio) {
   data_ajax(site_url+'/perfil/medio_divulgacion_por_tipo/'+tipo_medio, null, '#medio_divulgacion_div');
   $('#div_mostrar_comprobante_libro_revista').html('<div class="clearfix"></div>');
}

//function funcion_cambio_texto(element) {
//    $('#id_row_' + 14). $("#" + id_div + " p").each(function (i)
//    {
//}



