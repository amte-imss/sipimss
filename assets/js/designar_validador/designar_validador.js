var menu_tipo_busqueda = new Object();
menu_tipo_busqueda['matricula'] = 'Matrícula';
menu_tipo_busqueda['nombre'] = 'Nombre empleado';
menu_tipo_busqueda['claveadscripcion'] = 'Clave de adscripción';
menu_tipo_busqueda['unidad'] = 'Unidad';


function funcion_buscar_elementos() {
    var path = site_url + '/designar_validador/get_data_buscar_unidades';
    var val_post = $('#form_busqueda_unidades').serialize();

    $.ajax({
        url: path,
        data: val_post,
        method: 'POST',
        beforeSend: function (xhr) {
            $('#div_result_unidades_medicas').html(create_loader());
        }
    })
            .done(function (response) {
                $('#div_result_unidades_medicas').html(response);
            })
            .fail(function (jqXHR, textStatus) {
                $('#div_result_unidades_medicas').html("Ocurrió un error durante el proceso, inténtelo más tarde.");
            })
            .always(function () {
                remove_loader();
            });
}

/**
 * 
 * @param {type} name Menu de opciónes de filtro
 * @returns {undefined}
 */
function funcion_menu_tipo_busqueda(name) {
//function funcion_menu_tipo_busqueda_validar_censo(name) {
    var text = menu_tipo_busqueda[name];//Busca en el hashmap el nombre indicado
    $("#menu_select").val(name);//Modifica el valor del menu
    $("#btn_buscar_por").text(text);//Cambia el texto del botón
    $("#btn_buscar_por").append('<span class="caret"> </span>');//Agregar span al botón para mostrar icono flechita
    $("#buscar_unidad_medica").attr('data-original-title', 'Buscar por ' + text);//Cambia el texto del la caja de texto 
    $("#btn_buscar_b").attr('data-original-title', 'Buscar por ' + text);//Cambia el texto del botón
}

function runScript(e) {
    if (e.keyCode == 13) {
//        var tb = document.getElementById("scriptBox");
//        eval(tb.value);
        funcion_buscar_elementos();
        return false;
    }
}
function runScriptBuscador_sied(e) {
    if (e.keyCode == 13) {
        $("#btn_buscar_validador_siep").trigger("click");//Dispara el onclic del botón buscar validador en el sied
        return false;
    }
}

//****************************Seleccion de validador****************************
/**
 * LEAS
 * 
 * @param {type} element this del botón de la tabla de unidades
 * Carga los validadores prospecto o candidatos a ser validadores de unidad de adscripción
 * @returns {undefined}
 */
function funcion_carga_elemento(element) {
//    alert('sdjhsjdj');
    var obj = $(element);
//    var id_validaor = obj.data('idvalidador');
    var tipo_evento = obj.data('tipoevento');
    var delegacion_cve = obj.data('delcve');
    var departamento_desc = obj.data('depcve');
    var idrow = obj.data('idrow');
    $.ajax({
        url: site_url + '/designar_validador/get_data_cargar_elemento',
        data: {tipo_evento: tipo_evento,
//        data: {id_validaor: id_validaor, tipo_evento: tipo_evento,
            delegacion_cve: delegacion_cve, departamento_desc: departamento_desc,
            idrow: idrow
        },
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
//                $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
//                $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
            })
            .always(function () {
                remove_loader();
            });
}
/**
 * 
 * @param {type} element combobox o select con los validadores prospectos
 * @returns {undefined}
 */
function funcion_carga_validador(element) {
    var obj = $(element);
    var id_validaor = obj.data('idvalidador');
    var tipo_evento = obj.data('tipoevento');
    var delegacion_cve = obj.data('delcve');
    var departamento_desc = obj.data('depcve');
    var idrow = obj.data('idrow');
    var datos_form_serializados = $('#form_carga_validadores').serialize();
    datos_form_serializados += '&idrow=' + idrow + '&tipo_evento=' + tipo_evento + '&id_validaor=' + id_validaor + '&delegacion_cve=' + delegacion_cve + '&departamento_desc=' + departamento_desc;
    //Si es cero, se carga el buscador, de lo contrario se cargan los datos del validador seleccionado, y esto en diferentes divs
    var e = document.getElementById("candidato_a_validador");
    var candidato_a_validador = parseInt(e.options[e.selectedIndex].value);
    var div_resultado = 'div_buscador_sied'; //div resultados
//    document.getElementById("div_resultados_validadores").innerHTML = "";
    document.getElementById("div_buscador_sied").innerHTML = "";
//    if (candidato_a_validador > 0) {
//        div_resultado = 'div_resultados_validadores';
//    }
    $.ajax({
        url: site_url + '/designar_validador/get_data_cargar_datos_opcion_validador',
//        data: {cve_inv: cve_inv, carga_datos: 1, idrow: idrow, comprobantecve: comprobantecve},
        data: datos_form_serializados,
        method: 'POST',
        beforeSend: function (xhr) {
            $('#' + div_resultado).html(create_loader());
        }
    })
            .done(function (response) {
                $('#' + div_resultado).html(response);
            })
            .fail(function (jqXHR, response) {
//                $('#div_error').show();
//                $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
//                $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
            })
            .always(function () {
                remove_loader();
            });
}

function funcion_buscar_validador(element) {
    var obj = $(element);
    var id_validaor = obj.data('idvalidador');
    var tipo_evento = obj.data('tipoevento');
    var delegacion_cve = obj.data('delcve');
    var departamento_desc = obj.data('depcve');
    var idrow = obj.data('idrow');
    var datos_form_serializados = $('#form_buscador_validador').serialize();
    datos_form_serializados += '&idrow=' + idrow + '&tipo_evento=' + tipo_evento + '&id_validaor=' + id_validaor + '&delegacion_cve=' + delegacion_cve + '&departamento_desc=' + departamento_desc;
    $.ajax({
        url: site_url + '/designar_validador/get_data_buscar_sied_validador',
//        data: {cve_inv: cve_inv, carga_datos: 1, idrow: idrow, comprobantecve: comprobantecve},
        data: datos_form_serializados,
        method: 'POST',
        beforeSend: function (xhr) {
            $('#div_resultados_validadores').html(create_loader());
        }
    })
            .done(function (response) {
                $('#div_resultados_validadores').html(response);
            })
            .fail(function (jqXHR, response) {
//                $('#div_error').show();
//                $('#mensaje_error').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
//                $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
            })
            .always(function () {
                remove_loader();
            });
}

function funcion_designar_validador(element) {
    var obj = $(element);
    var id_validador = obj.data('idvalidador');
    var delegacion_cve = obj.data('delcve');
    var departamento_desc = obj.data('depcve');
    var idrow = parseInt(obj.data('idrow'));

    var confirmacion = apprise('Confirme que realmente quitar la designación de validador a la unidad', {verify: true}, function (btnClick) {
        if (btnClick) {
            $.ajax({
                url: site_url + '/designar_validador/get_data_eliminar_vinculo_validador',
                data: {
                    id_validador: id_validador
                },
                method: 'POST',
                beforeSend: function (xhr) {

                }
            })
                    .done(function (response) {
                        try {
                            var response_json = $.parseJSON(response);//
                            var success = response_json.success;
                            if (parseInt(success) === 1) {//Se elimino correctamente el vinculo unidad validador
                                var row = document.getElementById("id_row_" + idrow);
//                                var row = document.getElementById("tabla_designar_validador").rows[idrow + 1];
                                $('#check_designado_' + idrow).remove();//Remover checkbox para asignar validador
//                                var boton = add_boton_link(idrow, id_validador, departamento_desc, delegacion_cve);//Genera checkbox
                                var boton = add_boton_link(idrow, departamento_desc, delegacion_cve);//Genera checkbox

                                row.cells[6].appendChild(boton);//Agrega el botón a la celda seleccionada
                                row.cells[3].innerHTML = '';//Limpia el texto de la celda matricula
                                row.cells[4].innerHTML = '';//Limpia el texto de la celda nombre
                                row.cells[5].innerHTML = '';//Limpia el texto de la celda categoría

//                                document.getElementById('btn_seleccionar_validador_' + idrow).data('toggle', 'modal');
//                                document.getElementById('btn_seleccionar_validador_' + idrow).data('target', '#modal_censo');

                            } else {
                                document.getElementById("check_designado_" + idrow).checked = true;//"Cheked" del checkbox, ya que cancelo
                            }
                            $('#mensaje_error_index').html(response_json.error);
                            $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-success').addClass('alert-' + response_json.tipo_msg);
                            $('#div_error_index').show();
                            setTimeout("$('#div_error_index').hide()", 6000);
                        } catch (e) {

                        }

                    })
                    .fail(function (jqXHR, response) {
                        document.getElementById("check_designado_" + idrow).checked = true;//"Cheked" del checkbox, ya que cancelo
                        $('#mensaje_error_index').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
                        $('#mensaje_error_div_index').removeClass('alert-danger').removeClass('alert-success').addClass('alert-danger');
                        $('#div_error_index').show();
                        setTimeout("$('#div_error_index').hide()", 10000);

                    })
                    .always(function () {
                        remove_loader();
                    });
        } else {
            document.getElementById("check_designado_" + idrow).checked = true;//"Cheked" del checkbox, ya que cancelo
            return false;
        }
    });
}

function add_boton_link(id_row, depcve, delcve) {
////function add_boton_link(id_row, id_validador, depcve, delcve) {
    var btn = document.createElement("button");
    btn.id = "btn_seleccionar_validador_" + id_row;
    btn.type = "button";
//    btn.class = "btn btn-link btn-sm";
    btn.textContent = "Seleccionar validador";
    //Agrega los atrubutos
    btn.setAttribute('class', 'btn btn-link btn-sm');
    btn.setAttribute('data-toggle', "modal");
    btn.setAttribute('data-target', "#modal_censo");
//    btn.data('toggle', 'modal');
//    btn.data('target', '#modal_censo');

    btn.setAttribute('data-delcve', delcve);
    btn.setAttribute('data-idrow', id_row);
//    btn.setAttribute('data-idvalidador', id_validador);
    btn.setAttribute('data-depcve', depcve);
    btn.setAttribute('data-tipoevento', 'cargarseleccion');
    btn.setAttribute('onclick', 'funcion_carga_elemento(this)');
//    btn.setAttribute('onclick', function(){funcion_carga_elemento(this);});
//    btn.onChange = function(){funcion_carga_elemento(this);};
    //    
//    checkbox.addEventListener('onchange', funcion_designar_validador(this), true);
//    var data_ = document.createElement("input");

//      var btn = $('#btn_seleccionar_validador_' + id_row).
//        append($('<button>').
//            attr("class", "btn btn-link btn-sm").
//            attr("type", "button").
//            attr('onchange', 'funcion_carga_elemento(this)').
//            text('Seleccionar validador')
//        );

    return btn;

}

function funcion_seleccionar_validador(element) {
    var obj = $(element);
    var tipo_evento = obj.data('tipoevento');
    var delegacion_cve = obj.data('delcve');
    var departamento_desc = obj.data('depcve');
    var matricula = obj.data('matricula');
    var idrow = parseInt(obj.data('idrow'));
//    var candidato_a_validador = document.getElementById('#candidato_a_validador').val;
    var e = document.getElementById("candidato_a_validador");
    var candidato_a_validador = e.options[e.selectedIndex].value;

    var datos_form_serializados = $('#form_seleccionar_validador').serialize();
//    datos_form_serializados += '&idrow=' + idrow + '&candidato_a_validador=' + candidato_a_validador + '&tipo_evento=' + tipo_evento + '&id_validaor=' + id_validador + '&delegacion_cve=' + delegacion_cve + '&departamento_desc=' + departamento_desc;
    datos_form_serializados += '&idrow=' + idrow + '&candidato_a_validador=' + candidato_a_validador + '&tipo_evento=' + tipo_evento + '&matricula=' + matricula + '&delegacion_cve=' + delegacion_cve + '&departamento_desc=' + departamento_desc;

    document.getElementById("div_resultados_validadores").innerHTML = "";//Limpia del div resultado de validadores
    document.getElementById("div_buscador_sied").innerHTML = ""; //Limpia resultado busqueda de sied
    if (candidato_a_validador > 0) {//
        div_resultado = 'div_resultados_validadores';
    }

    $.ajax({
        url: site_url + '/designar_validador/get_data_seleccionar_validador',
//        data: {cve_inv: cve_inv, carga_datos: 1, idrow: idrow, comprobantecve: comprobantecve},
        data: datos_form_serializados,
        method: 'POST',
        beforeSend: function (xhr) {
            $('#div_resultados_validadores').html(create_loader());
        }
    })
            .done(function (response) {
                try {
                    var response_json = $.parseJSON(response);//
                    var validador_cve = response_json.result_datos.id_validador;
                    var matricula = response_json.result_datos.matricula;
                    var nombre = response_json.result_datos.nombre;
                    var categoria_nombre = response_json.result_datos.categoria_nombre;
//                    var id_reg = idrow + 1;
//                    alert(id_reg);
//                    var row = document.getElementById("tabla_designar_validador").rows[id_reg];
                    var row = document.getElementById("id_row_" + idrow);
                    $('#btn_seleccionar_validador_' + idrow).remove();//Remover boton para asignar validador
                    var checkbox = add_check_box(idrow, validador_cve, departamento_desc, delegacion_cve);//Genera checkbox
                    row.cells[1].appendChild(checkbox);//Agrega el check box a la celda seleccionada
                    row.cells[3].innerHTML = matricula;//Agrega el check box a la celda seleccionada
                    row.cells[4].innerHTML = nombre;//Agrega el check box a la celda seleccionada
                    row.cells[5].innerHTML = categoria_nombre;//Agrega el check box a la celda seleccionada
                    $('#mensaje_error_index').html(response_json.error);
                    $('#mensaje_error_div_index').removeClass('alert-danger').addClass('alert-success');
                    $('#div_error_index').show();
                    $('#modal_censo').modal('toggle');
                    setTimeout("$('#div_error_index').hide()", 5000);
                } catch (e) {
                    $('#div_resultados_validadores').html(response);
                }
            })
            .fail(function (jqXHR, response) {
//                $('#div_error').show();
                $('#div_resultados_validadores').html('Ocurrió un error durante el proceso, inténtelo más tarde.');
//                $('#mensaje_error_div').removeClass('alert-success').addClass('alert-danger');
            })
            .always(function () {
                remove_loader();
            });
}

function add_check_box(id_row, id_validador, depcve, delcve) {
    var checkbox = document.createElement("input");
    checkbox.id = "check_designado_" + id_row;
    checkbox.type = "checkbox";
    checkbox.class = "text-center";
    checkbox.checked = "checked";
    //Agrega los atrubutos del checkbox
    checkbox.setAttribute('data-idvalidador', id_validador)
    checkbox.setAttribute('data-idrow', id_row)
    checkbox.setAttribute('data-delcve', delcve)
    checkbox.setAttribute('data-depcve', depcve)
//    checkbox.setAttribute('onchange', 'funcion_designar_validador(this)')
    checkbox.setAttribute('onclick', 'funcion_designar_validador(this)')
//    checkbox.addEventListener('onchange', funcion_designar_validador(this), true);//dispara el evento
//    var data_ = document.createElement("input");
    return checkbox;
//  
}

function  add_html_cell(name_tabla, id_row, id_cell, textoHtml) {
    var table = document.getElementById(name_tabla);
    var row;
    var col;
    for (var i = 0, row; row = table.rows[i]; i++) {
        //iterate through rows
        if (id_row === i) {
            //rows would be accessed using the "row" variable assigned in the for loop
            for (var j = 0, col; col = row.cells[j]; j++) {
                //iterate through columns
                //columns would be accessed using the "col" variable assigned in the for loop
                if (j === id_cell) {
                    col.innerHTML(textoHtml);
                    break;
                }
            }
            break;
        }
    }

}
