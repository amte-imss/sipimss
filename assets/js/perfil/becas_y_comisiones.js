$(function () {

    $('#btn_gregar_comision_modal').on('click', function () {
        var isReadOnly = $('.nameFields').prop('readonly');
        $('.nameFields').prop('readonly', !isReadOnly);
        var a = hrutes['seccion_becas_comisiones'];
        var cad_split = a.split(":");
        data_ajax(site_url + '/' + cad_split[0] + '/get_form_comisiones', null, '#modal_content');
    });
    $('#btn_gregar_beca_modal').on('click', function () {
        var isReadOnly = $('.nameFields').prop('readonly');
        $('.nameFields').prop('readonly', !isReadOnly);
        var a = hrutes['seccion_becas_comisiones'];
        var cad_split = a.split(":");
        data_ajax(site_url + '/' + cad_split[0] + '/get_form_becas', null, '#modal_content');
    });
});

function ver_be(elemento){
    data_ajax(site_url+'/perfil_registro/carga_datos_editar_beca/'+$(elemento).attr('data-value'), null, '#modal_content');
}

function ver_co(elemento){
    data_ajax(site_url+'/perfil_registro/carga_datos_editar_comision/'+$(elemento).attr('data-value'), null, '#modal_content');
}

function funcion_eliminar_reg_beca(element) {
    var a = hrutes['seccion_becas_comisiones'];
    var cad_split = a.split(":");
    var button_obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var beca_cve = button_obj.data('becacve');
    var comprobante_cve = button_obj.data('comprobantecve');
    var idrow = button_obj.data('idrow');

    apprise('Confirme que realmente desea eliminar el registro de beca', {verify: true}, function (btnClick) {
        if (btnClick) {
            $.ajax({
                url: site_url + '/' + cad_split[0] + '/eliminar_beca',
                data: {
                    comprobante: comprobante_cve,
                    beca_cve: beca_cve,
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

function funcion_eliminar_reg_comision(element) {
    var a = hrutes['seccion_becas_comisiones'];
    var cad_split = a.split(":");
    var button_obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var comision_cve = button_obj.data('comisioncve');
    var comprobante_cve = button_obj.data('comprobantecve');
    var idrow = button_obj.data('idrow');

    apprise('Confirme que realmente desea eliminar el registro de comisión laboral', {verify: true}, function (btnClick) {
        if (btnClick) {
            $.ajax({
                url: site_url + '/' + cad_split[0] + '/eliminar_comision',
                data: {
                    comprobante: comprobante_cve,
                    comision_cve: comision_cve,
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

function funcion_guardar_beca() {
    var a = hrutes['seccion_becas_comisiones'];
    var cad_split = a.split(":");
    var formData = new FormData($('#form_becas_laborales')[0]);
    if ($('#idc').length) { //Validar carga de archivo
        $.ajax({
            url: site_url + '/' + cad_split[0] + '/get_add_beca',
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
                        recargar_opcion_menu_mostrar_mensaje('seccion_becas_comisiones', json.satisfactorio, json.error);
                    } catch (e) {
                        $('#cuerpo_modal').html(response);
                    }
                })
                .fail(function (jqXHR, response) {
                    $('cuerpo_modal').html(response);
                })
                .always(function () {
                    remove_loader();
                });
    } else {
        $('#error_carga_archivo').html(html_message("Falta cargar archivos", 'danger'));
    }
}

function funcion_guardar_comision() {
    var a = hrutes['seccion_becas_comisiones'];
    var cad_split = a.split(":");
    var formData = new FormData($('#form_comisiones_laborales')[0]);
    if ($('#idc').length) { //Validar carga de archivo
        $.ajax({
            url: site_url + '/' + cad_split[0] + '/get_add_comision',
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
                        recargar_opcion_menu_mostrar_mensaje('seccion_becas_comisiones', json.satisfactorio, json.error);
                    } catch (e) {
                        $('#cuerpo_modal').html(response);
                    }
                })
                .fail(function (jqXHR, response) {
                    $('cuerpo_modal').html(response);
                })
                .always(function () {
                    remove_loader();
                });
    } else {
        $('#error_carga_archivo').html(html_message("Falta cargar archivos", 'danger'));
    }
}


function funcion_editar_reg_beca(element) {
    var a = hrutes['seccion_material_educativo'];
    var cad_split = a.split(":");
    var obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var cve_beca = obj.data('becacve');
    var comprobantecve = obj.data('comprobantecve');
    var idrow = obj.data('idrow');
//    datos_form_serializados += '&cve_inv='+cve_inv+'&carga_datos=0'+'&idrow='+idrow+'&comprovantecve='+comprovantecve;

    $.ajax({
        url: site_url + '/' + cad_split[0] + '/carga_datos_editar_beca',
        data: {comprobantecve: comprobantecve, cve_beca: cve_beca},
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

function funcion_actualizar_beca(element) {
    var a = hrutes['seccion_becas_comisiones'];
    var cad_split = a.split(":");
    var obj = $(element);
    var cve_beca = obj.data('becacve');
//    var idrow = obj.data('idrow');
    var comprobantecve = obj.data('comprobantecve');
    var formData = new FormData($('#form_becas_laborales')[0]);
    formData.append("comprobantecve", comprobantecve);
    formData.append("cve_beca", cve_beca);
    $.ajax({
        url: site_url + '/' + cad_split[0] + '/actualizar_datos_editar_becas',
        data: formData,
        type: 'POST',
        mimeType: "multipart/form-data", //Para subir archivos 
        contentType: false, //Limpía el formulario
        cache: false,
        processData: false,
//  
        beforeSend: function (xhr) {
            $('#cuerpo_modal').html(create_loader());
        }
    })
            .done(function (response) {
                try {
                    var json = $.parseJSON(response);
                    recargar_opcion_menu_mostrar_mensaje('seccion_becas_comisiones', json.satisfactorio, json.error);
                } catch (e) {
                    $('#cuerpo_modal').html(response);
                }
            })
            .fail(function (jqXHR, response) {
                $('cuerpo_modal').html(response);
            })
            .always(function () {
                remove_loader();
            });
}
///*****************************Comisiones *******************************************************************************
function funcion_editar_reg_comision(element) {
    var a = hrutes['seccion_material_educativo'];
    var cad_split = a.split(":");
    var obj = $(element); //Convierte a objeto todos los elementos del this que llegan del componente html (button en esté caso)
    var cve_comision = obj.data('comisioncve');
    var comprobantecve = obj.data('comprobantecve');
    $.ajax({
        url: site_url + '/' + cad_split[0] + '/carga_datos_editar_comision',
        data: {comprobantecve: comprobantecve, cve_comision: cve_comision},
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

function funcion_actualizar_comision(element) {//actualizar_datos_editar_comision
    var a = hrutes['seccion_becas_comisiones'];
    var cad_split = a.split(":");
    var obj = $(element);
    var cve_comision = obj.data('comisioncve');
//    var idrow = obj.data('idrow');
    var comprobantecve = obj.data('comprobantecve');
    var formData = new FormData($('#form_comisiones_laborales')[0]);
    formData.append("comprobantecve", comprobantecve);
    formData.append("cve_comision", cve_comision);
    $.ajax({
        url: site_url + '/' + cad_split[0] + '/actualizar_datos_editar_comision',
        data: formData,
        type: 'POST',
        mimeType: "multipart/form-data", //Para subir archivos 
        contentType: false, //Limpía el formulario
        cache: false,
        processData: false,
//  
        beforeSend: function (xhr) {
            $('#cuerpo_modal').html(create_loader());
        }
    })
            .done(function (response) {
                try {
                    var json = $.parseJSON(response);
//                    $('.nav-tabs > li a[href="#comisiones_tab"]').tab('show');
//                    $('.nav-tabs a:last').tab('show');
                    $( "#comisiones_tab" ).trigger( "click" );//Onclic a comisiones 
                    recargar_opcion_menu_mostrar_mensaje('seccion_becas_comisiones', json.satisfactorio, json.error);
                } catch (e) {
                    $('#cuerpo_modal').html(response);
                }
            })
            .fail(function (jqXHR, response) {
                $('cuerpo_modal').html(response);
            })
            .always(function () {
                remove_loader();
            });
   
}
