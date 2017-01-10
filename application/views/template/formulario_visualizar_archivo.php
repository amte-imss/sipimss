<div class="row">
    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
        <label class="control-label">
            <?php echo $string_values['lbl_tipo_comprobante']; ?>:
        </label>
    </div>
    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
        <div class="form-group">
            <div class="input-group date datepicker">
                <label class="registro"><?php
                $dir_tes['COMPROBANTE_CVE'] = (isset($dir_tes['comprobante_cve']) && !empty($dir_tes['comprobante_cve'])) ? $dir_tes['comprobante_cve'] : $dir_tes['COMPROBANTE_CVE'];
                if(!empty($dir_tes['COMPROBANTE_CVE']) || !empty($idc)){ //En caso de tener asociado archivo, se muestra link
                    $idcomprobante = (!empty($dir_tes['COMPROBANTE_CVE'])) ? $this->seguridad->encrypt_base64($dir_tes['COMPROBANTE_CVE']) : ((!empty($idc)) ? $idc : '');
                    echo '<a href="'.site_url('administracion/ver_archivo/'.$idcomprobante).'" target="_blank"><span class="glyphicon glyphicon-search"></span> '.$string_values['ver_archivo'].'</a><br>';
                    echo '<a href="'.site_url('administracion/descarga_archivo/'.$idcomprobante).'" target="_blank"><span class="glyphicon glyphicon-download"></span> '.$string_values['descargar_archivo'].'</a>';
                    echo $this->form_complete->create_element(array('id'=>'idc', 'type'=>'hidden', 'value'=>$idcomprobante));
                }
                ?>
                </label>
            </div>
        </div>
    </div>
</div>