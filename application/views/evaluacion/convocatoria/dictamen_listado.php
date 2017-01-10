<div class="row">
    <div class="col-lg-9 col-md-9">
    	<h4><?php echo $string_values['titulo_dictamen']; ?></h4>
    </div>
    <div class="col-lg-3 col-md-3 text-right">
    	<button type="button" class="btn btn-link btn-sm" id="btn_agregar_de" data-value="">
            <?php echo $string_values['agregar_dictamen']; ?>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><?php echo $string_values['tab_head_fecha_inicia_evaluacion'] ?></th>
                    <th class="text-center"><?php echo $string_values['tab_head_fecha_fin_evaluacion'] ?></th>
                    <th class="text-center"><?php echo $string_values['tab_head_fecha_fin_inconformidad'] ?></th>
                    <th class="text-center"><?php echo $string_values['acciones'] ?></th>
                </tr>
            </thead>
            <tbody>
                    <?php //Generará la tabla que muestrá los dictamenes
                    $html = "";
                    if(!empty($dictamen_evaluacion)){
	                    foreach ($dictamen_evaluacion as $de) {
	                        $html .= '<tr id="trd_'.$this->seguridad->encrypt_base64($de['ADMIN_DICTAMEN_EVA_CVE']).'">
	                                <td>'.nice_date($de['FCH_INICIO_EVALUACION'], 'd-m-Y').'</td>
	                                <td>'.nice_date($de['FCH_FIN_EVALUACION'], 'd-m-Y').'</td>
	                                <td>'.nice_date($de['FCH_FIN_INCONFORMIDAD'], 'd-m-Y').'</td>
	                                <td><button type="button" class="btn btn-link btn-sm btn_editar_de" data-value="'.$this->seguridad->encrypt_base64($de['ADMIN_DICTAMEN_EVA_CVE']).'">'.
	                                       $string_values['editar'].
	                                    '</button>
	                                    <button type="button" class="btn btn-link btn-sm btn_eliminar_de" data-value="'.$this->seguridad->encrypt_base64($de['ADMIN_DICTAMEN_EVA_CVE']).'">'.
	                                       $string_values['eliminar'].
	                                    '</button>
	                                    </td>
	                            </tr>';
	                    }
	                } else {
	                	$html = '<tr><td colspan="4">'.$string_values['no_existe_datos'].'</td></tr>';
	                }
                    echo $html;
                    ?>
            </tbody>
        </table>
    </div>
</div><br>
<script type="text/javascript">
$(function() {
	if($('.btn_editar_de').length){
        $('.btn_editar_de').on('click', function() {
            data_ajax(site_url+'/convocatoria_evaluacion/gestionar_dictamen/'+$("#btn_convocatoria_enviar").attr('data-value')+'/'+$(this).attr('data-value'), null, '#capa_dictamen_formulario');
        });
    }

    if($('#btn_agregar_de').length){
        $('#btn_agregar_de').on('click', function() {
            data_ajax(site_url+'/convocatoria_evaluacion/gestionar_dictamen/'+$("#btn_convocatoria_enviar").attr('data-value')+'/'+$(this).attr('data-value'), null, '#capa_dictamen_formulario');
        });
    }

    $('.btn_eliminar_de').on('click', function() {
        var data_value = $(this).attr('data-value');
        apprise(confirmar_eliminacion, {verify: true}, function(btnClick) {
            if (btnClick) {
                $.ajax({
                    url: site_url + '/convocatoria_evaluacion/eliminar_dictamen/'+data_value,
                    method: 'POST',
                    dataType: "json",
                    beforeSend: function(xhr) {
                        //$('#get_data_ajax_actividad').html(create_loader());
                    }
                })
                .done(function(response) {
                	if($("#js_msg").length){
                		$("#js_msg").html(imprimir_resultado(response));
                	} else {
                    	$('#mensaje_dictamen').html(imprimir_resultado(response));
                    }
                    if(response.result==true){
                        data_ajax(site_url+'/convocatoria_evaluacion/listar_dictamen/'+$("#btn_convocatoria_enviar").attr('data-value'), null, '#capa_dictamen');
                        if($('#btn_convocatoria_cancelar').length){ ///Agregar actualización
					    	$('#btn_convocatoria_cancelar').on('click', function() {
							    $('#modal_censo').on('hidden.bs.modal', function (e) {
									document.location.href=document.location.href;
								})
							});
						}
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
});
</script>