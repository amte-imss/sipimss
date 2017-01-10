<?php
if(count($catalogos['ccurso'])>0){
	?>
	<div class='col-sm-12 col-md-12 col-lg-4 text-right'>
	    <label class="control-label">
	        * <?php echo $string_values['t_h_curso']; ?>:
	    </label>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		<div class="form-group">
		    <div class="input-group">
		        <?php
		        echo $this->form_complete->create_element(array('id'=>'curso', 'type'=>'dropdown', 'value'=>$dir_tes['CURSO_CVE'], 'options'=>$catalogos['ccurso'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['t_h_curso'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['t_h_curso'])));
		        ?>
		    </div>
		</div>
		<?php echo form_error_format('curso'); ?>	
	</div>
	<?php 
}
?>

