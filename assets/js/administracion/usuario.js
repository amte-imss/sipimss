$(function() {
    if($('#delegacion').length){
        $('#delegacion').blur(function() {
            validar_usuario_siap();
        });
    }
    if($('#matricula').length){
        $('#matricula').blur(function() {
            validar_usuario_siap();
        });
    }
    /*if($('.btn_editar_ce').length){
        $('.btn_editar_ce').on('click', function() {
            data_ajax(site_url+'/convocatoria_evaluacion/gestionar_convocatoria/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }

    if($('#btn_agregar_ce').length){
        $('#btn_agregar_ce').on('click', function() {
            data_ajax(site_url+'/convocatoria_evaluacion/gestionar_convocatoria/'+$(this).attr('data-value'), null, '#modal_content');
        });
    }

    $('.btn_eliminar_ce').on('click', function() {
        var data_value = $(this).attr('data-value');
        apprise(confirmar_eliminacion, {verify: true}, function(btnClick) {
            if (btnClick) {
                $.ajax({
                    url: site_url + '/convocatoria_evaluacion/eliminar_convocatoria/'+data_value,
                    method: 'POST',
                    dataType: "json",
                    beforeSend: function(xhr) {
                        $('#get_data_ajax_actividad').html(create_loader());
                    }
                })
                .done(function(response) {
                    $('#mensaje').html(imprimir_resultado(response));
                    if(response.result==true){
                        $('#tr_'+data_value).slideUp( "slow", function() { //Ocultar fila del registro
                            $('#tr_'+data_value).remove(); //Eliminar fila
                        });
                    }
                })
                .fail(function(jqXHR, response) {
                    $('#mensaje').html(imprimir_resultado(response));
                })
                .always(function() {
                    remove_loader();
                });
            } else {
                return false;
            }
        });
    });*/
});

function validar_usuario_siap(){
    var del = $('#delegacion').val();
    var mat = $('#matricula').val();
    if(del == "" || mat == ""){
        var resultado = { result:'danger', msg:txt_del_mat };
        $('#mensaje').html(imprimir_resultado(resultado));
    } else {
        $.ajax({
            url: site_url + '/usuario/validar_usuario_siap',
            method: 'POST',
            dataType: "json",
            data: { m: mat, d: del },
            beforeSend: function(xhr) {
                $('#mensaje').html(create_loader('1px'));
                $('#delegacion').attr('disabled', 'disabled');
                $('#matricula').attr('disabled', 'disabled');
                $("#btn_usuario_enviar").attr('disabled', 'disabled');
            }
        })
        .done(function(response) {
            $('#icon_mat_del').removeClass('glyphicon-remove');
            $('#icon_mat_del').removeClass('glyphicon-ok');
            $('#icon_mat_del').removeClass('glyphicon-question-sign');
            $('#icon_mat_del').attr('style', 'color:#555;');
            if(response.result==true){                
                $('#icon_mat_del').addClass('glyphicon-ok');
                $('#icon_mat_del').attr('style', 'color:green;');
                $("#nombre").val(response.data.nombre);
                $("#apaterno").val(response.data.paterno);
                $("#amaterno").val(response.data.materno);
                $("#lbl_adscripcion").html(response.data.descripcion+" ("+response.data.adscripcion+")");
                $("#lbl_categoria").html(response.data.pue_despue+" ("+response.data.emp_keypue+")");
                $("#lbl_presupuestal").html("");
                $("#lbl_curp").html(response.data.curp);
                $("#lbl_antiguedad").html(response.data.antiguedad);
                $("#lbl_genero").html(response.data.sexo);
            } else {
                if(response.msg!=""){
                    $('#mensaje').html(imprimir_resultado(response));
                }
                $('#icon_mat_del').addClass('glyphicon-remove');
                $('#icon_mat_del').attr('style', 'color:red;');
                $("#nombre").val("");
                $("#apaterno").val("");
                $("#amaterno").val("");
                $("#lbl_adscripcion").html("");
                $("#lbl_categoria").html("");
                $("#lbl_presupuestal").html("");
                $("#lbl_curp").html("");
                $("#lbl_antiguedad").html("");
                $("#lbl_genero").html("");
            }
        })
        .fail(function(jqXHR, response) {
            $('#mensaje').html(imprimir_resultado(response));
        })
        .always(function() {
            $('#delegacion').removeAttr('disabled');
            $('#matricula').removeAttr('disabled', 'disabled');
            $("#btn_usuario_enviar").removeAttr('disabled');
            remove_loader();
        });
    }
}