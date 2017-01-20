<script type="text/javascript">
$(function() {
    $('#modal_censo').on('hide.bs.modal', function (e) {
		cargar_datos_menu_perfil('seccion_direccion_tesis');
		recargar_fecha_ultima_actualizacion();
		$(this).off(e);
	});
});
</script>
<div id="capa_html">
	<div id="capa_direccion_tesis" style="padding:20px;">
		<?php //if(isset($msg) && !is_null($msg)){ echo $msg; } //Imprimir mensaje ?>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            * <?php echo $string_values['t_h_anio']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group date datepicker">
		                <label class="registro"><?php echo $dir_tes['EC_ANIO']; ?></label>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['t_h_nivel_academico']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group">
		            	<label class="registro"><?php echo $dir_tes['NIV_ACA_NOMBRE']; ?></label>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['t_h_area']; ?>:
		        </label>
		    </div>
		    <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		        <div class="form-group">
		            <div class="input-group">
		                <label class="registro"><?php echo $dir_tes['COM_ARE_NOMBRE']; ?></label>
		            </div>
		        </div>
		    </div>
		</div>
		<?php echo $formulario_carga_archivo; ?>
		<?php echo $formulario_validacion; ?>
	</div>
</div>