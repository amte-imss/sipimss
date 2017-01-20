var array_menu_perfil_validar_eva = new Array(10);
var seccion_seleccionada;
var hrutes = new Object();

//Botones menu principal
$(function () {
    $(".panel-collapse").on("show.bs.collapse", function (e) {
        var id = $(this).attr('id');

        if (id === 'seccion_validar_evaluacion') {
            if (seccion_seleccionada !== id) {//Si es diferente, recarga la sección validar
                cargar_datos_menu_perfil(id);
            }
        } else {
            if (id.indexOf('seccion') > -1 && array_menu_perfil_validar_eva.indexOf(id) < 0) {
                //alert();
                array_menu_perfil_validar_eva.push(id);
                //Separar en 4, 0controlador; 1nombre del método ajax; 2nombre del formulario; 3nombre del div
//                cargar_datos_menu_perfil(id);
            }
        }
        seccion_seleccionada = id;
//        $(document).scrollTop(scrollposition);
    });
});

/**
 * 
 * @param {type} el identificador se compone de tres elementos o argumentos, que 
 * se encuentran separados por el caracter ":" 1er_arg=metódo, 2do_arg=formulario
 * y 3er_arg=div, ejemplo a continuación:
 * "get_data_ajax_actividad:#form_actividad_docente:#get_data_ajax_actividad"
 * @returns {undefined}
 */
function cargar_datos_menu_perfil(id) {
//    alert(id);
    try {
        var padre = hrutes[id];
        data_ajax(site_url + '/' + padre + '/' + id, null, '#' + id);
    } catch (e) {//Carga los datos de la recarga de la páginas
        var URLactual = window.location;
        URLactual = String(URLactual);
        var pag = URLactual.split("#");
        if (pag.length === 2) {
            var menu = pag[1];
            data_ajax(site_url + '/evaluacion_curricular_validar/' + menu, '', '#' + menu);
        }

    }
}
