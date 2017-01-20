<?php ?>
<div class='col-sm-12 col-md-12 col-lg-4 text-right'>
    <label class="control-label">
        * <?php echo $string_values['lbl_licenciatura']; ?>:
        <!--</label>-->
</div>
<div class='col-sm-12 col-md-12 col-lg-8 text-left'>
    <div class="form-group">
        <div class="input-group">
            <?php
            echo $this->form_complete->create_element(array('id' => 'LICENCIATURA_CVE',
                'type' => 'dropdown',
                'value' => (isset($dir_tes['LICENCIATURA_CVE'])) ? $dir_tes['LICENCIATURA_CVE'] : '',
                'options' => $catalogos['licenciatura'],
                'first' => array('' => 'Selecciona...'),
                'attributes' => array('class' => 'form-control',
                    'placeholder' => $string_values['lbl_licenciatura'],
                    'data-toggle' => 'tooltip', 'data-placement' => 'top',
                    'title' => $string_values['lbl_licenciatura'])));
            ?>
        </div>
    </div>
    <?php echo form_error_format('LICENCIATURA_CVE');  ?>	
</div>
<script type="text/javascript">
    <?php if (isset($dir_tes['TIP_LICENCIATURA_CVE']) && !empty($dir_tes['TIP_LICENCIATURA_CVE'])) { ?>
        <?php $tmp_lic = (isset($dir_tes['LICENCIATURA_CVE']) && !empty($dir_tes['LICENCIATURA_CVE']))?$dir_tes['LICENCIATURA_CVE']:'';?>
        data_ajax(site_url+"/perfil/licenciaturas_formacion/"+$('#ctipo_licenciatura').val()+"/<?php echo $tmp_lic; ?>", null, '#capa_licenciaturas');
    <?php } ?>
</script>
