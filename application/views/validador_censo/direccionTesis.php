<script type="text/javascript">
var confirmar_eliminacion = "<?php echo $string_values['confirmar_eliminacion']; ?>";
</script>
<?php echo js('validacion_censo_profesores/direccion_tesis.js'); 
$this->seguridad->set_tiempo_convocatoria_null();//Reinicia validacion de convocatoria
$this->seguridad->set_tiempo_convocatoria(null, null, $is_interseccion);//Valida paso de convocatoria y, si la validación actual es una intersección
?>
<div class="list-group">
    <div id = 'tab_content_actividad_docente' class='tab-content col-md-12'>
        <div id = 'actividad_docente_tab' class='tab-pane fade in active'>
			<div class="panel-body">
                <div>
                   <br>
                       <h4><?php echo $string_values['title']; ?></h4>
                   <br>
                </div>
                <div id="mensaje"></div>
                <?php if(isset($lista_direccion)){?>
                    <div class="row" >
                            <div id="div_direccion_tesis" class="table-responsive">
                                <table class="table table-striped table-hover table-bordered" id="tabla_direccion_tesis">
                                    <thead>
                                        <tr class='btn-default'>
                                        	<th><?php echo $string_values['validado']; ?></th>
                                            <th><?php echo $string_values['t_h_anio']; ?></th>
                                            <th><?php echo $string_values['t_h_nivel_academico']; ?></th>
                                            <th><?php echo $string_values['t_h_area']; ?></th>
                                            <th><?php echo $string_values['t_h_comprobante']; ?></th>
                                            <th><?php echo $string_values['opciones']; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php //Generará la tabla que muestrá las actividades del docente
                                    		foreach ($lista_direccion as $key_ld => $direccion) {
//                                                        pr($lista_direccion);
                                    			$id = $this->seguridad->encrypt_base64($direccion['EMP_COMISION_CVE']);
                                    			$btn_comprobante = (!is_null($direccion['COMPROBANTE_CVE'])) ? '<a href="'.site_url('administracion/ver_archivo/'.$this->seguridad->encrypt_base64($direccion['COMPROBANTE_CVE'])).'" target="_blank">'.$string_values['lbl_ver_comprobante'].'</a>' : '';
                                    			//$btn_validar = ($this->seguridad->verificar_liga_validar($direccion['IS_VALIDO_PROFESIONALIZACION'])) ?                                                '<button type="button" class="btn btn-link btn-sm btn_validar_dt" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="'.$id.'" onclick="validar_dt(this);" data-valid="'.$this->seguridad->encrypt_base64($this->config->item('ACCION_GENERAL')['VALIDAR']['valor']).'">'.$string_values['validar'].'</button>' : '';
                                                ///////////Inicio ver liga de validación
                                                $valido_eliminar_editar = $this->seguridad->verificar_liga_validar($direccion['IS_VALIDO_PROFESIONALIZACION'], $direccion['IS_CARGA_SISTEMA']);
                                                $btn_validar = ($valido_eliminar_editar) ? '<button type="button" class="btn btn-link btn-sm btn_validar_dt" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="'.$id.'" onclick="validar_dt(this);" data-valid="'.$this->seguridad->encrypt_base64($this->config->item('ACCION_GENERAL')['VALIDAR']['valor']).'">'.$string_values['validar'].'</button>' : '';
                                                ///////////Fin ver liga de validación
												echo '<tr id="tr_'.$id.'">
													<td class="text-center">'.$this->seguridad->html_verificar_evaluado_issistema_valido($direccion['IS_VALIDO_PROFESIONALIZACION'], $direccion['IS_CARGA_SISTEMA'], $direccion['validation_estado']).'</td>
													<td>'.$direccion['EC_ANIO'].'</td>
													<td>'.$direccion['NIV_ACA_NOMBRE'].'</td>
													<td>'.$direccion['COM_ARE_NOMBRE'].'</td>
													<td>'.$btn_comprobante.'</td>
													<td><button type="button" class="btn btn-link btn-sm btn_ver_dt" aria-expanded="false" data-toggle="modal" data-target="#modal_censo" data-value="'.$id.'" onclick="ver_dt(this);">'.
					                                       $string_values['ver'].
					                                    '</button>
					                                    '.$btn_validar.'
					                                </td>
												</tr>';
										}
	                                	?>
	                                </tbody>
	                            </tbody>
	                        </table>
	                    </div>
	                </div>
                <?php } ?>
            </div>
	    </div><!--Termina primer tab-->                
    </div>
</div>
