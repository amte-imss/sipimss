<?php
if(count($catalogos['csubtipo_formacion_profesional'])>0){
	?>
	<div class='col-sm-12 col-md-12 col-lg-4 text-right'>
	    <label class="control-label">
	        * <?php echo $string_values['lbl_subtipo_formacion_docente']; ?>:
	    </label>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		<div class="form-group">
		    <div class="input-group">
		        <?php
		        echo $this->form_complete->create_element(array('id'=>'subtipo', 'type'=>'dropdown', 'value'=>$dir_tes['SUB_FOR_PRO_CVE'], 'options'=>$catalogos['csubtipo_formacion_profesional'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_subtipo_formacion_docente'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_subtipo_formacion_docente'])));
		        ?>
		    </div>
		</div>
		<?php echo form_error_format('subtipo'); ?>	
	</div>
	<?php
}
//////////////////////////Curso
if(isset($catalogos['campos_catalogos']) && count($catalogos['campos_catalogos'])>0){
	?>
	<div class="row">
        <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
            <label class="control-label">
                * <?php echo $string_values['t_h_tipo_curso']; ?>:
            </label>
        </div>
        <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
            <div class="form-group">
                <div class="input-group">
                    <?php
                    echo $this->form_complete->create_element(array('id'=>'tipo_curso', 'type'=>'dropdown', 'value'=>$dir_tes['CURSO_CVE'], 'options'=>$catalogos['campos_catalogos'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['t_h_tipo_curso'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['t_h_tipo_curso'])));
                    ?>                      
                </div>
            </div>
            <?php echo form_error_format('tipo_curso'); ?>
        </div>
    </div>
	<?php
}
////////////////////////Cuando seleccione 'Otro', se mostrará un campo para escribir el nombre del curso
?>
<div id="div_curso_otro" class="row" style="display:none;">
    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
        <label class="control-label">
            * <?php echo $string_values['otro_curso']; ?>:
        </label>
    </div>
    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
        <div class="form-group">
            <div class="input-group">
                <?php
                echo $this->form_complete->create_element(array('id'=>'nombre_curso', 'type'=>'text', 'value'=>$dir_tes['EFP_NOMBRE_CURSO'], 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['otro_curso'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['otro_curso'])));
                ?>                      
            </div>
        </div>
        <?php echo form_error_format('nombre_curso'); ?>
    </div>
</div>
<script type="text/javascript">
$(function() {
	if($('#tipo_curso').length){
        $( "#tipo_curso" ).change(function() {
        	mostrar_otro();
        });
        mostrar_otro();
    }
    if($('#subtipo').length){
        $( "#subtipo" ).change(function() {
            if($(this).val()!=""){
                data_ajax(site_url+'/perfil/subtipo_formacion_docente/'+$('#tipo_formacion').val()+"/"+$('#subtipo').val()+"?curso=&nombre_curso=", null, '#capa_subtipo');
            }
        });
        <?php
        if(isset($dir_tes['TIP_FOR_PROF_CVE']) && !empty($dir_tes['TIP_FOR_PROF_CVE'])){ ?>
            data_ajax(site_url+"/perfil/subtipo_formacion_docente/"+$('#tipo_formacion').val()+"/<?php echo ((isset($dir_tes['SUB_FOR_PRO_CVE']) && !empty($dir_tes['SUB_FOR_PRO_CVE'])) ? $dir_tes['SUB_FOR_PRO_CVE'].'?' : '?').((isset($dir_tes['CURSO_CVE']) && !empty($dir_tes['CURSO_CVE'])) ? 'curso='.$dir_tes['CURSO_CVE'] : '').((isset($dir_tes['EFP_NOMBRE_CURSO']) && !empty($dir_tes['EFP_NOMBRE_CURSO'])) ? '&nombre_curso='.$dir_tes['EFP_NOMBRE_CURSO'] : ''); ?>", null, '#capa_subtipo');
        <?php } ?>
    } 
});
function mostrar_otro(){
	if($( "#tipo_curso" ).val()=="<?php echo $this->config->item('ccurso')['OTRO']['id']; ?>"){
		$("#div_curso_otro").show("slow");
	} else {
		$("#div_curso_otro").hide("slow");
		$("#nombre_curso").val("");
	}
}
</script>