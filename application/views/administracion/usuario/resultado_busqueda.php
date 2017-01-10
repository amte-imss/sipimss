<?php defined('BASEPATH') OR exit('No direct script access allowed');
//$tipo_admin = $this->config->item('tipo_admin');
//$tipo_usuario = $this->session->userdata('tipo_admin');
?>
<script type="text/javascript">
    var confirmar_eliminacion = "<?php echo $string_values['confirmar_eliminacion']; ?>"; //Texto de confirmación
    //var error_eliminacion = "<?php //echo $string_values['error']; ?>"; //Texto de confirmación
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><?php echo $string_values['buscador']['tab_head_matricula'] ?></th>
                    <th class="text-center"><?php echo $string_values['buscador']['tab_head_nombre'] ?></th>
                    <th class="text-center"><?php echo $string_values['buscador']['tab_head_delegacion'] ?></th>
                    <th class="text-center"><?php echo $string_values['buscador']['tab_head_adscripcion'] ?></th>
                    <th class="text-center"><?php echo $string_values['buscador']['tab_head_rol'] ?></th>
                    <th class="text-center"><?php echo $string_values['buscador']['tab_head_estado'] ?></th>
                    <th class="text-center"><?php echo $string_values['acciones'] ?></th>
                </tr>
            </thead>
            <tbody>
                    <?php //Generará la tabla que muestrá las actividades del docente
                    $html = "";
                    foreach ($data as $usu) {
                        $html_rol = "";
                        foreach ($usu['rol'] as $rol) {
                            $html_rol .= '- '.$rol['ROL_NOMBRE'].'<br>';
                        }
                        $html .= '<tr id="tr_'.$this->seguridad->encrypt_base64($usu['USUARIO_CVE']).'">
                                <td>'.$usu['USU_MATRICULA'].'</td>
                                <td>'.$usu['nombre'].'</td>
                                <td>'.$usu['nom_delegacion'].'</td>
                                <td>'.$usu['dep_nombre'].'</td>
                                <td>'.$html_rol.'</td>
                                <td>'.$usu['EDO_USUARIO_DESC'].'</td>
                                <td><button type="button" class="btn btn-link btn-sm btn_editar_usu" data-value="'.$this->seguridad->encrypt_base64($usu['USUARIO_CVE']).'">'.
                                       $string_values['editar'].
                                    '</button>
                                    <button type="button" class="btn btn-link btn-sm btn_eliminar_usu" data-value="'.$this->seguridad->encrypt_base64($usu['USUARIO_CVE']).'">'.
                                           $string_values['eliminar'].
                                        '</button>
                                </td>
                            </tr>';
                    }
                    echo $html;
                    ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('.btn_eliminar_usu').on('click', function() {
        var data_value = $(this).attr('data-value');
        apprise(confirmar_eliminacion, {verify: true}, function(btnClick) {
            if (btnClick) {
                $.ajax({
                    url: site_url + '/usuario/desactivar_usuario/'+data_value,
                    method: 'POST',
                    dataType: "json",
                    beforeSend: function(xhr) {
                        $('#mensaje').html(create_loader());
                    }
                })
                .done(function(response) {
                    $('#mensaje').html(imprimir_resultado(response));
                    if(response.result==true){
                        /*$('#tr_'+data_value).slideUp( "slow", function() { //Ocultar fila del registro
                            $('#tr_'+data_value).remove(); //Eliminar fila
                        });*/
                		data_ajax(site_url+"/usuario/get_data_ajax/"+$('#cr').val(), "#form_search", "#resultado_busqueda");
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
    });
	$(".btn_editar_usu").click(function(event){
        //data_ajax(site_url+"/usuario/get_data_ajax", "#form_search", "#resultado_busqueda");
        document.location.href=site_url+"/usuario/gestionar_usuario/"+$(this).attr('data-value');
    });
});
</script>