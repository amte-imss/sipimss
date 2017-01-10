$(document).ready(function(){
    var path = site_url + '/dictamen/buscarDictamenes';
    data_ajax(path, '', '#container_tbl_dictamen', callbackIniDataTables('#dictamenTbl'));
    
    // Borra la tabla
    $('#btnLimpiar').click(function(){
        $('#container_tbl_dictamen').html(' ');
    });
    
    // Busqueda por parametros
    $('#btnBuscarDocentes').click(function(){
        var url = site_url + '/dictamen/buscarDictamenes';
        data_ajax(url, '#frmBuscarDocentesDictamen', '#container_tbl_dictamen', callbackIniDataTables('#dictamenTbl'));
    });
    
});

// Función que pide los datos generales de un docente vía ajax
function showDocenteModalData(id){
    var path = site_url + '/dictamen/datosGenerales';
    $.ajax({
        method: 'POST'
        , url: path
        , dataType: 'json'
        , data: {id: id}
        , success: function(response){
            console.log(response);
            llenadoDatosModal(response);
            $('#docenteDatosModal').modal();
        }
        , error: function(){
            console.warn("no se ha efectuado el ajax");
        }
        , beforeSend: function(){
            // mostrar spiner loading
            console.log('inicia loading');
        }
        , complete: function(){
            // quitar spiner loading
            console.log('termina loading');
        }
    })
    
}

function buscarDocenteTabla(){
    var path = site_url + '/dictamen/buscarDictamenes';
    data_ajax(path, '', '#container_tbl_dictamen', callbackIniDataTables('#dictamenTbl'));
}

// Para ir al dictamen
function goToDictamen( emp, solic){
//    var dataUrl = $('#frmDatosDocenteTablaSolic'+ solic +'Emp'+emp).serialize();
//    var path = site_url + '/dictamen/dictamenFormato?'+dataUrl;
//    window.location.replace(path);
    $('#frmDatosDocenteTablaSolic'+ solic +'Emp'+emp).submit();
}

// Coloca los datos recuperados del docente en el modal y luego lo muestra
function llenadoDatosModal(data){
    $('#emp_ape_paterno').val(data.apellidoPaterno)
    $('#emp_ape_materno').val(data.apellidoMaterno)
    $('#emp_nombre').val(data.nombre)

    var annios = calculaEdadConCurp(data.curp);
    $('#emp_edad').val(annios);
    
    var generoString
    switch(data.generoSelected){
        case "M":
        case "m":
            generoString = "Masculino";
        break;
        case 'F':
        case 'f':
            generoString = "Femenino";
        break;
        default:
            generoString = "";
        break;        
    }
    $('#emp_genero').val(generoString)
    
    if( typeof data.estadoCivilSelected !== 'undefined' && data.estadoCivilSelected !== null ){
        var estadoCivilString = "";
        switch(data.estadoCivilSelected){
            case '1':
                estadoCivilString = "Soltero";
            break;
            case '2':
                estadoCivilString = "Casado";
            break;
            case '3':
                estadoCivilString = "Divorciado";
            break;
            case '4':
                estadoCivilString = "Viudo";
            break;
            default:
                estadoCivilString = "Indefinido";
        }
        $('#CESTADO_CIVIL_CVE').val(estadoCivilString);
    }
    
    $('#EMP_EMAIL').val(data.correoElectronico)
    $('#EMP_TEL_PARTICULAR').val(data.telParticular)
    $('#EMP_TEL_LABORAL').val(data.telLaboral)
    
    var num_empls_fue_imss = '0';
    if(data.empleosFueraImss) num_empls_fue_imss = data.empleosFueraImss;
    $('#EMP_NUM_FUE_IMSS').val(num_empls_fue_imss)
    
    $('#perfil_matricula').val(data.matricula)
    $('#perfil_delegacion').val(data.delegacion)
    $('#perfil_nombre_categoria').val(data.nombreCategoria)
    $('#perfil_clave_categoria').val(data.claveCategoria)
    $('#perfil_nombre_area_adscripcion').val(data.nombreAreaAdscripcion)
    $('#perfil_nombre_unidad_adscripcion').val(data.nombreUnidadAdscripcion)
    $('#perfil_nombre_clave_adscripcion').val(data.claveAdscripcion)
    $('#perfil_tipo_contratacion').val(data.tipoContratacion)
    $('#perfil_estatus_empleado').val(data.estatusEmpleado)
    var arregloFecha = data.antiguedad.split("_");
    
    $('#perfil_antiguedad_anios').val(arregloFecha[0]) 
    $('#perfil_antiguedad_quincena').val(arregloFecha[1])
    $('#perfil_antiguedad_dias').val(arregloFecha[2])
    
}

// Calcula la edad de una persona con datos de la CURP
// Se da por hecho que la curp viene formada correctamente.
function calculaEdadConCurp(curp){
    /*
     * 1.-Se obtiene la fecha actual.
     * 2.-Se cortan los datos la fecha de la curp.
     * 3.-Se se genera la fecha de nacimiento con los datos curp.
     * 4.-Se toma la diferencia de fechas en tiempo unix.
     * 5.-Se obtienen los años en base a la diferencia unix.
     */
    var fechaHoy = new Date();
    var annioEdad = curp.slice(4,6);
    var mesEdad = curp.slice(6,8);
    var diaEdad = curp.slice(8,10);
    var fechaNacimiento = new Date();
    fechaNacimiento.setYear(annioEdad);
    fechaNacimiento.setMonth(parseInt(mesEdad) - 1);
    fechaNacimiento.setDate(diaEdad);
    var diffTime = Math.abs(fechaHoy.getTime() - fechaNacimiento.getTime()) ;
    var annios = Math.floor(diffTime / ( 365 * 24 * 60 * 60 * 1000 ) );
    return annios;
}
