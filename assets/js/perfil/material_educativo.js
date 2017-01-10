$(function () {

    $('#btn_gregar_material_educativo').on('click', function () {
        var isReadOnly = $('.nameFields').prop('readonly');
        $('.nameFields').prop('readonly', !isReadOnly);
        var a = hrutes['seccion_material_educativo'];
        var cad_split = a.split(":");
        data_ajax(site_url + '/' + cad_split[0] + '/get_form_general_material_educativo', null, '#modal_content');
    });

    $('#btn_guardar_direccion_tesis').on('click', function () {
        if ($('#idc').length) { //Validar carga de archivo
            data_ajax(site_url + '/perfil/direccion_tesis_formulario/<?php echo $identificador; ?>', '#formularioDireccionTesis', '#modal_content');
        } else {
            $('#error_carga_archivo').html(html_message("<?php echo $string_values['falta_carga_archivo']; ?>", 'danger'));
        }
    });

});

function ver_me(elemento){
    data_ajax(site_url+'/perfil_registro/carga_datos_editar_material_educativo/'+$(elemento).attr('data-value'), null, '#modal_content');
}

function funcion_cargar_campos_tipo_material_educativo() {
    var a = hrutes['seccion_material_educativo'];
    var cad_split = a.split(":");
    data_ajax(site_url + '/' + cad_split[0] + '/get_cargar_tipo_material', '#form_material_educativo', '#cuerpo_modal');
}


function funcion_guardar_material_educativo() {
    var a = hrutes['seccion_material_educativo'];
    var cad_split = a.split(":");
    var formData = new FormData($('#form_material_educativo')[0]);
//    alert($('#idc').val())
    if ($('#idc').length) { //Validar carga de archivo
        $.ajax({
            url: site_url + '/' + cad_split[0] + '/add_tipo_material_educativo',
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
                        recargar_opcion_menu_mostrar_mensaje('seccion_material_educativo', json.satisfactorio, json.error);
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

function funcion_eliminar_reg_material_educativo(element) {
    var a = hrutes['seccion_material_educativo'];
    var cad_split = a.split(":");
    var button_obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var index_ctp_mat_edu = button_obj.data('tpmateducve');
    var index_mat_edu = button_obj.data('mateducve');
    var comprobante_cve = button_obj.data('comprobantecve');
    var idrow = button_obj.data('idrow');

    apprise('Confirme que realmente desea eliminar el registro de material educativo', {verify: true}, function (btnClick) {
        if (btnClick) {
            $.ajax({
                url: site_url + '/' + cad_split[0] + '/eliminar_material_educativo',
                data: {
                    comprobante: comprobante_cve,
                    tipo_material_cve: index_ctp_mat_edu,
                    emp_material_educativo_cve: index_mat_edu
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

function funcion_editar_material_educativo(element) {
    var a = hrutes['seccion_material_educativo'];
    var cad_split = a.split(":");
    var obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var material_edu_cve = obj.data('mateducve');
    var comprobantecve = obj.data('comprobantecve');
    var ti_material_cve = obj.data('tpmateducve');
    var idrow = obj.data('idrow');
//    datos_form_serializados += '&cve_inv='+cve_inv+'&carga_datos=0'+'&idrow='+idrow+'&comprovantecve='+comprovantecve;

    $.ajax({
        url: site_url + '/' + cad_split[0] + '/carga_datos_editar_material_educativo',
        data: {material_edu_cve: material_edu_cve, comprobantecve: comprobantecve, ti_material_cve: ti_material_cve},
        method: 'POST',
        beforeSend: function (xhr) {
            $('#modal_content').html(create_loader());
        }
    })
            .done(function (response) {
                $('#modal_content').html(response);
            })
            .fail(function (jqXHR, response) {
//                $('#div_error').show();
                $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
//                $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
            })
            .always(function () {
                remove_loader();
            });
}

function funcion_actualizar_material_educativo(element) {
    var a = hrutes['seccion_material_educativo'];
    var cad_split = a.split(":");
    var obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var material_edu_cve = obj.data('mateducve');
    var ti_material_cve = obj.data('tpmateducve');
    var comprobantecve = obj.data('comprobantecve');
    var formData = new FormData($('#form_material_educativo')[0]);
    formData.append("material_edu_cve", material_edu_cve);
    formData.append("ti_material_cve", ti_material_cve);
//    formData.append("comprobantecve", comprobantecve);
    $.ajax({
        url: site_url + '/' + cad_split[0] + '/actualizar_datos_editar_material_educativo',
//        data: formData,
        data: formData,
        type: 'POST',
        contentType: false, //Limpía el formulario
        processData: false,
//        mimeType: "multipart/form-data", //Para subir archivos 
//        cache: false,
//  
        beforeSend: function (xhr) {
            $('#cuerpo_modal').html(create_loader());
        }
    })
            .done(function (response) {
                try {
                    var json = $.parseJSON(response);
                    recargar_opcion_menu_mostrar_mensaje('seccion_material_educativo', json.satisfactorio, json.error);
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
}