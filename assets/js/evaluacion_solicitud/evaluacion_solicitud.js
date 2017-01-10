$(document).ready(function () {
    $("#btn_solicitud").on('click', function () {
        //alert($("#form_informacion_general").attr("action"));
        var action = $("#solicitar_evc").attr("action");
        var form_data = $("#solicitar_evc").serialize();
        $.ajax({
            url: action,
            data: form_data,
            method: 'POST',
            beforeSend: function (xhr) {
                $('#seccion_info_general').html(create_loader());
            }
        })
                .done(function (response) {
                    //alert(response)
                    try{
                        var resp = $.parseJSON(response);
                        $('#msg_general').show();        
                        $('#msg_general').text(resp.message);
                        //alert($('#msg_general').attr("class"));
                        if(resp.result=="true"){
                            $('#msg_general').addClass('alert-success');
                        }else{
                            $('#msg_general').addClass('alert-danger');
                        }
                        //setTimeout("$('#msg_general').hide()", 5000);
                        //recargar_fecha_ultima_actualizacion();//Recarga la fecha de la ultima actualización del modulo perfil
                        //$("#seccion_info_general").html(resp.content);
                    }catch(e){
                        $("#msg_general").html(response);
                    }
                    
                })
                .fail(function (jqXHR, response) {
                    $('#msg_general').removeClass('alert-success').addClass('alert-danger');
                    $('#msg_general').html('Ocurrió un error durante el proceso, inténtelo más tarde.'+response);
                })
                .always(function () {
                    remove_loader();
                });
    });
});