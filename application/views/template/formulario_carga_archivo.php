<?php ///////////////////Inicio carga de archivo
$userfile = ((!empty($dir_tes['COMPROBANTE_CVE'])) ? $this->seguridad->encrypt_sha512($dir_tes['COMPROBANTE_CVE']) : null); ?>
<div class="row">
    <div class="col-md-6">
            <label for='' class="control-label">
                * <?php echo $string_values['lbl_tipo_comprobante']; ?>
            </label>
             <?php 
                echo $this->form_complete->create_element(array('id' => 'tipo_comprobante', 
                    'type' => 'dropdown', 
                    'options' => $catalogos['ctipo_comprobante'], 
                    'first' => array('' => $string_values['drop_tipo_comprobante']), 
                    'value' => (isset($dir_tes['TIPO_COMPROBANTE_CVE'])) ? $dir_tes['TIPO_COMPROBANTE_CVE'] : '',
                    'class'=>'form-control',
                    'attributes' => array('class' => 'form-control', 'aria-describedby'=>"help-tipo-comprobante",
                    'placeholder' => $string_values['title_tipo_comprobante'], 'data-toggle' => 'tooltip', 'data-placement' => 'top', 
                    'title' => $string_values['title_tipo_comprobante'] ))); 
            ?>
            <div class="col-lg-12 col-md-12"></div>
            <?php echo form_error_format('tipo_comprobante'); ?>
    </div>            
    <div class="col-md-6" id="capa_carga_archivo">
            <?php 
            echo $this->form_complete->create_element(array('id'=>'userfile', 'type'=>'upload', 'attributes'=>array(
                    'class'=>'file',
                    'accept'=>'application/pdf',
                    'autocomplete'=>'off'
                )));
            echo $this->form_complete->create_element(array('id'=>'extension', 'type'=>'hidden', 'value'=>$this->config->item('upload_config')['comprobantes']['allowed_types'])); ?>
            <label for='lbl_comprobante' class="control-label">
                * <?php echo $string_values['lbl_comprobante']; ?>
            </label>
            <div class="input-group">                                           
                <?php
                    echo $this->form_complete->create_element(
                    array('id'=>'text_comprobante','type'=>'text',
                            'value' => isset($dir_tes['COM_NOMBRE']) ? $dir_tes['COM_NOMBRE'] : '',
                            'attributes'=>array(
                            'class'=>'form-control',
                            'placeholder'=>$string_values['title_cargar_comprobante'],
                            'min'=> '0',
                            'max'=> '100',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['title_cargar_comprobante'],
                            'readonly'=>'readonly',
                            )
                        )
                    );
                ?>                       
              <div class="input-group-btn">
                <button type="button" aria-expanded="false" class="btn btn-default browse">
                    <span aria-hidden="true" class="glyphicon glyphicon-file"> </span>
                </button>
              </div>
            </div>
            <div class="col-lg-8 col-md-12" id="capa_archivo_cargado">
            	<?php
            	if(!empty($dir_tes['COMPROBANTE_CVE']) || !empty($idc)){ //En caso de tener asociado archivo, se muestra link
                    $idcomprobante = (!empty($dir_tes['COMPROBANTE_CVE'])) ? $this->seguridad->encrypt_base64($dir_tes['COMPROBANTE_CVE']) : ((!empty($idc)) ? $idc : '');
            		echo '<a href="'.site_url('administracion/ver_archivo/'.$idcomprobante).'" target="_blank"><span class="glyphicon glyphicon-search"></span> '.$string_values['ver_archivo'].'</a><br>';
                    echo '<a href="'.site_url('administracion/descarga_archivo/'.$idcomprobante).'" target="_blank"><span class="glyphicon glyphicon-download"></span> '.$string_values['descargar_archivo'].'</a>';
            		echo $this->form_complete->create_element(array('id'=>'idc', 'type'=>'hidden', 'value'=>$idcomprobante));
            	}
            	?>
            </div>
            <?php if(!isset($no_mostrar_comprobante)){//No muestra el comprobante si esté existe ?>
            <div class="col-lg-4 col-md-12">
            	<?php echo $this->form_complete->create_element(array(
                            'id'=>'btn_subir_archivo',
                            'type'=>'button',
                            'value'=>$string_values['subir_archivo'],
                            'attributes'=>array(
                                'class'=>'btn-success btn_subir_comprobante pull-right',
                                'data-key'=> $userfile
                            ))); ?>
            </div>
            <?php echo form_error_format('text_comprobante'); }?>
    </div>
    <div id="error_carga_archivo"></div>
</div>
<?php ///////////////////////Fin carga de archivo ?>