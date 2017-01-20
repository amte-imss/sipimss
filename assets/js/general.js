$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip(); //Llamada a tooltip
    $('.help-popover').popover();
});

/**
 *	Método que muestra una imagen (gif animado) que indica que algo esta cargando
 *	@return	string	Contenedor e imagen del cargador.
 */
function create_loader(padding) {
var optionalPadding = padding || '200px';
optionalPadding = (typeof optionalPadding === 'undefined') ? '200px' : optionalPadding;
        return '<div id="ajax_loader" align="center" style="padding-top:' + optionalPadding + '; padding-bottom:' + optionalPadding + ';"><img src="' + img_url_loader + '" alt="Cargando..." title="Cargando..." /></div>';
}

/**
 *	Método que remueve el contenedor e imagen de cargando
 */
function remove_loader() {
    $("#ajax_loader").remove();
}

/**	Método que muestra un mensaje con formato de alertas de boostrap
 * @param	string	message 	Mensaje que será mostrado
 * @param 	string 	tipo 		Posibles valores('success','info','warning','danger')
 */
function html_message(message, tipo) {
    tipo = (typeof (tipo) === "undefined") ? 'danger' : tipo;
    return "<div class='alert alert-" + tipo + "' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + message + "</div>";
}

function imprimir_resultado(resultado) {
    var tipo_mensaje = (resultado.result == true) ? 'success' : 'danger';
    setTimeout("$('#div_mensaje').hide()", 6000);
    return "<div id='div_mensaje' class='row'><div class='col-lg-12 alert alert-" + tipo_mensaje + "'>" + resultado.msg + "</div></div>";
}

/*
 * @author  ???
 * @modified_by DPérez
 * @param url para conexión ajax
 * @param id html del formulario donde se obtienen los datos a enviar en ajax
 * @param id html del elemento que contendrá los datos del resultado
 * @param función que se ejecutará cuando el ajax es correcto y se tienen datos
 * @returns none
 */
function data_ajax(path, form_recurso, elemento_resultado, callback) {
    var dataSend = $(form_recurso).serialize();
    $.ajax({
        url: path,
        data: dataSend,
        method: 'POST',
        beforeSend: function (xhr) {
            $(elemento_resultado).html(create_loader());
        }
    })
    .done(function (response) {
        if( typeof callback !== 'undefined' && typeof callback === 'function' ){
            $(elemento_resultado).html(response).promise().done(callback());
        }else{
            $(elemento_resultado).html(response);
        }
    })
    .fail(function (jqXHR, textStatus) {
        $(elemento_resultado).html("Ocurrió un error durante el proceso, inténtelo más tarde.");
    })
    .always(function () {
        remove_loader();
    });

}
/*
 *       Función que inicializa dataTables después de una petición ajax
 * Se mandan a la función data_ajax en 4° parametro para ejecutar la función de inicio de dataTables.
 * 
 * @param   id html de la tabla que aplicará DataTables
 * @returns function callback
 */
function callbackIniDataTables(idTabla){
    return function(){
        $(idTabla).DataTable(
            {
                "info": false
                , "searching": false
                , "lengthChange": false
                , "scrollX": true
//                , "order": [[ 1, "asc" ]]
            }
        );
    }
    
}

/*
 *       Función que inicializa dataTables después de una petición ajax
 * Se mandan a la función data_ajax en 4° parametro para ejecutar la función de inicio de dataTables.
 * No usa parametros inicializa los elementos con la clase help-popover
 */
function callbackIniPopover(){
    return function(){
        $('.help-popover').popover();
    }
}

/*
 *  @param: elementsArray   {array}     elementos a los que se les tratará de apicar todas las funciones de callback 
 *  @param: callbackArray   {array}     funcinoes callback que aplicararan a los elementos del primer array 
 */
function someCallback(elementsArray, callbackArray){
    for(var x in callbackArray){
        for(var y in elementsArray){
            callbackArray[x](elementsArray[y]);
        }
    }
}

/**
 * 
 * @param {type} path 
 * @param {type} form_recurso
 * @param {type} elemento_resultado
 * Param extra {type_ objet} elementos_post - Argumentos indefinidos, 
 * Despúes del elemento resuiltado, se enviarán todos los elementos 
 * por post que se requieran enviar ejem. {key : value, key_2 : value_2,...,key_n : value_n}
 * @returns {JSON} Si el return del response del servidor es un, regresa JSON, si no, regresa vacio 
 */
function data_ajax_type_post(path, form_recurso, elemento_resultado) {
    var json_return = '';
    var formData = new FormData();
    if (form_recurso !== null) {//Prepara los datos del formulario
        var formData = new FormData($(form_recurso)[0]);
    }
    if (arguments.length === 4) {//Prepara los datos extra que se enviarán por post
        var obj_data_extra = arguments[3]
        for (var key_extras in arguments[3]) {
            formData.append(key_extras, obj_data_extra[key_extras]);
        }
    }
    $.ajax({
        url: path,
        data: formData,
        type: 'POST',
        contentType: false, //Limpía el formulario
        processData: false,
//        mimeType: "multipart/form-data",
        beforeSend: function (xhr) {
            $(elemento_resultado).html(create_loader());
        }
    })
            .done(function (response) {
                try {
                    json_return = $.parseJSON(response);
                } catch (e) {
                    $(elemento_resultado).html(response);
                }
            })
            .fail(function (jqXHR, textStatus) {
                $(elemento_resultado).html("Ocurrió un error durante el proceso, inténtelo más tarde.");
            })
            .always(function () {
                remove_loader();
            });
    return json_return;//Return de json, puede ser null

}

/**
 * 
 * @param {type} path
 * @param {type} form_recurso - Formulario que se va a enviar
 * @param {type} elemento_resultado Div o elemento donde se mostrará el resultado
 * param {type objete} Despúes del elemento resuiltado, se enviarán todos los elementos 
 * por post simple que se requieran enviar ejem. {key : value, key_2 : value_2,...,key_n : value_n}
 * 
 * @returns {JSON} Si el return del response del servidor es un, regresa JSON, si no, regresa vacio 
 */
function data_ajax_post(path, form_recurso, elemento_resultado) {
//    var result = 0;
    var formData = '';
    if (form_recurso !== null) {//Prepara los datos del formulario
        formData = $(form_recurso).serialize();
    }
    if (arguments.length === 4) {//Prepara los datos extra que se enviarán por post
        var obj_data_extra = arguments[3];
        for (var key_extras in arguments[3]) {
            formData += '&' + key_extras + '=' + obj_data_extra[key_extras];
        }
    }

    $.ajax({
        url: path,
        data: formData,
        method: 'POST',
        beforeSend: function (xhr) {
            $(elemento_resultado).html(create_loader());
        }
    })
            .done(function (response) {
//                     result = 1;
                try {
                    var json = $.parseJSON(response);
                } catch (e) {
                    $(elemento_resultado).html(response);
                }
            })
            .fail(function (jqXHR, textStatus) {
                $(elemento_resultado).html("Ocurrió un error durante el proceso, inténtelo más tarde.");
            })
            .always(function () {
                remove_loader();
            });
}

/**
 *	Método que válida con javascript la extensión del archivo que se desea subir
 *	@param 	string	fileName 	Nombre del archivo
 *	@param	array	extension 	Arreglo de extensiones permitidas
 *	@return	boolean				true en caso de que la extensión del archivo se encuentre dentro de las permitidas
 */
function validate_extension(fileName, extension) {
    var file_extension = fileName.split('.').pop(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.

    for (var i = 0; i <= extension.length; i++) {
        if (extension[i] == file_extension) {
            return true; // valid file extension
        }
    }

    return false;
}

/**
 *	Método que crea un modal que muestra un mensaje
 *	@attribute 	title 			Título que se le colocará al modal
 *	@attribute 	mensaje			Mensaje que mostrará
 *	@return	false
 */
function mensaje_modal(mensaje, title) {
    if ($('#dataMessageModal').length > 0) {
        $('#dataMessageModal').remove();
    }
    var html = "<div class='modal fade' id='dataMessageModal' role='dialog' aria-labelledby='dataConfirmLabel'>" +
            "<div class='modal-dialog'>" +
            "<div class='modal-content'>" +
            "<div class='modal-header'>" +
            "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>" +
            "<h4 class='modal-title'>" + title + "</h4>" +
            "</div>" +
            "<div class='modal-body'>" +
            "<p>" + mensaje + "</p>" +
            "</div>" +
            "<div class='modal-footer'>" +
            "<button type='button' class='btn btn-default' aria-hidden='true' data-dismiss='modal'>Aceptar</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
    $('body').append(html);
    $('#dataMessageModal').modal({show: true});

    return false;
}

function dropdown(id, tag, act) {
    var val = $(id).val();
    // alert(val);
    $.ajax({
        url: site_url + act,
        data: {'campo': val},
        method: 'POST',
        dataType: 'JSON',
        beforeSend: function (xhr) {
            $(tag).html(create_loader());
        }

    })
            .done(function (response) {
                // alert(response.resultado);
                if (response.resultado == true) {
                    $(tag).html(response.data);
                    $('[data-toggle="tooltip"]').tooltip();
                } else {
                    $(tag).html(html_message(response.error, 'danger'));
                }
            })
            .fail(function (jqXHR, textStatus) {
                // alert(textStatus)
                $(tag).html(html_message("Ocurri&oacute; un error durante el proceso, inténtelo m&aacute;s tarde.", 'danger'));//+textStatus
            })
            .always(function () {
                remove_loader();
            });
}

function modal_static(is_static_modal) {
    var modal = $(document).getElementById('modal_censo');
    if (is_static_modal) {

    } else {

    }

}

function cargar_archivo(req, form) {
    var archivo = $('#userfile').val();
    var carga = '#capa_carga_archivo';
    var error = "#error_carga_archivo";
    var tipo_comprobante = "";
    var ed = $('#extension').val();
    var extension_documentacion = ed.split(',');
    if ($("#tipo_comprobante").length) {
        tipo_comprobante = $("#tipo_comprobante").val();
    }
    if (archivo != "") { //Validar que contenga archivo
        if (validate_extension(archivo, extension_documentacion)) { //Validar la extensión, definida en archivo de configuración
            if (tipo_comprobante != "") {
                var formData = new FormData($(form)[0]);
                formData.append('identificador', req);
                formData.append('tipo_comprobante', tipo_comprobante);
                $.ajax({
                    url: site_url + '/administracion/cargar_archivo',
                    type: 'POST',
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function (xhr) {
                        $(carga).hide();
                        $(error).html(create_loader());
                    }
                })
                        .done(function (response) {
                            var tipo = "";
                            $(carga).show();
                            if (response.result == true) {
                                tipo = 'success';
                                $('#capa_archivo_cargado').html("<a href='" + site_url + "/administracion/ver_archivo/" + response.idb + "' target='_blank'><span class='glyphicon glyphicon-search'></span>  Ver archivo</a><br><a href='" + site_url + "/administracion/descarga_archivo/" + response.idb + "' target='_blank'><span class='glyphicon glyphicon-download'></span>  Descargar archivo</a><input id='idc' name='idc' type='hidden' value='" + response.idb + "' >");
                                $('#userfile').val("");
                                $('#text_comprobante').val("");
                                $("#btn_subir_archivo").attr('data-key', response.id);
                            } else {
                                tipo = 'danger';
                            }
                            $("#error_carga_archivo").html(html_message(response.msg, tipo));
                        })
                        .fail(function (jqXHR, textStatus) {
                            $(error).html(html_message("Ocurrió un error durante el proceso, inténtelo más tarde.", 'danger'));
                        })
                        .always(function () {
                            remove_loader();
                            $(carga).show();
                            $('#evidencia_archivo').val('');
                            $('[data-toggle="tooltip"]').tooltip();
                        });
            } else {
                $(error).html(html_message("Debe seleccionar el tipo de comprobante para poder cargar el archivo.", 'danger'));
            }
        } else {
            $(error).html(html_message("El archivo seleccionado no esta permitido. Por favor elija un archivo con alguna de las siguientes extensiones: " + extension_documentacion, 'danger'));
        }
    } else {
        $(error).html(create_loader());
        $(error).html(html_message("Debe seleccionar un archivo. Por favor elija uno.", 'danger'));
    }
}

/**
 * @author LEAS
 * @fecha 10/09/2016
 *  * @param {type} tabla
 * @param {type} check_box_control
 * @returns {undefined}
 */
function seleccionar_todos_checkbox_tabla(tabla, check_box_control) {
//    alert(tabla + check_box_control);
    var isSeleccion = $(check_box_control).is(':checked');
    var obj_row;
    for (var i = 1; i < document.getElementById(tabla).rows.length; i++) {
        obj_row = $(document.getElementById(tabla).rows[i]);

        $('td input:checkbox', obj_row).each(function () {
            this.checked = isSeleccion;
//			if($("input[name=checktodos]:checked").length == 1){
//			} else {
//				this.checked = false;
//			}
        });
        ;
    }

}
