<div id="capa_html">
	<div id="capa_formacion_salud" style="padding:20px;">
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['lbl_fecha_inicio']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker">
		            	<label class="registro"><?php echo nice_date($dir_tes['EFPCS_FCH_INICIO'], 'd-m-Y'); ?></label>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['lbl_fecha_final']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker" id="datetimepicker2">
		            	<label class="registro"><?php echo nice_date($dir_tes['EFPCS_FCH_FIN'], 'd-m-Y'); ?></label>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['lbl_tipo_formacion']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group">
		            	<label class="registro"><?php echo $dir_tes['TIP_FORM_SALUD_NOMBRE']; ?></label>		            	
		            </div>
		        </div>
		    </div>
		</div>
		<?php
		if(isset($dir_tes['SUBTIP_NOMBRE']) && !empty($dir_tes['SUBTIP_NOMBRE'])) {
			?>
			<div class='col-sm-12 col-md-12 col-lg-4 text-right'>
			    <label class="control-label">
			        <?php echo $string_values['lbl_subtipo_formacion']; ?>:
			    </label>
			</div>
			<div class='col-sm-12 col-md-12 col-lg-8 text-left'>
				<div class="form-group">
				    <div class="input-group">
				    	<label class="registro"><?php echo $dir_tes['SUBTIP_NOMBRE']; ?></label>
				    </div>
				</div>
			</div>
			<?php
		}
		?>
		<?php echo $formulario_carga_archivo; ?>
		<?php echo $formulario_validacion; ?>
	</div>
</div>
<script type="text/javascript">
$(function() {
    $('#modal_censo').on('hide.bs.modal', function (e) {
		cargar_datos_menu_perfil('seccion_formacion');
		recargar_fecha_ultima_actualizacion();
		$(this).off(e);
	});
});
</script>