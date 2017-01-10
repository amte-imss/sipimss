<div id="capa_html">
	<div id="capa_direccion_tesis" style="padding:20px;">
		<div class="row">
		    <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
		        <label class="control-label">
		            <?php echo $string_values['t_h_anio']; ?>:
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
                    <?php echo $string_values['t_h_tipo_curso']; ?>:
                </label>
            </div>
            <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
                <div class="form-group">
                    <div class="input-group">
                        <label class="registro"><?php echo $dir_tes['TIP_CUR_NOMBRE']; ?></label>                     
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($dir_tes['CUR_NOMBRE']) && !empty($dir_tes['CUR_NOMBRE'])){ ?>
            <div class="row">
                <div class='col-sm-12 col-md-12 col-lg-4 text-right'>
                    <label class="control-label">
                        <?php echo $string_values['t_h_curso']; ?>:
                    </label>
                </div>
                <div class='col-sm-12 col-md-12 col-lg-8 text-left'>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="registro"><?php echo $dir_tes['CUR_NOMBRE']; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
		<div class='row'>
            <div class="col-md-4 text-right">
                <label for='lbl_duracion' class="control-label">
                    <?php echo $string_values['lbl_duracion']; ?>
                </label>
            </div>
            <?php
            $radio_val = "";
            if(isset($dir_tes['EC_DURACION']) && !empty($dir_tes['EC_DURACION'])){
                $radio_val = '<script>$(function () { mostrar_horas_fechas("block"); });</script>';
            }
            if(isset($dir_tes['EC_FCH_INICIO']) && !empty($dir_tes['EC_FCH_INICIO']) && isset($dir_tes['EC_FCH_FIN']) && !empty($dir_tes['EC_FCH_FIN'])){
                $radio_val = '<script>$(function () { mostrar_horas_fechas("none"); });</script>';
            }
            ?>
            <div class='col-sm-12 col-lg-8 text-center' id="div_horas_dedicadas" style="<?php echo $mostrar_hora_fecha_duracion==='hora_dedicadas'?'display: block':'display: none';?>">
                <label for='lbl_duracion_horas' class="control-label">
                    <?php echo $string_values['radio_duracion_horas']; ?>
                </label>
                <div class="form-group">
                    <div class="input-group date" id="datetimepickerfi" >
                        <label class="registro"><?php echo $dir_tes['EC_DURACION']; ?></label>
                    </div>
                </div>
            </div>
            <div class='col-sm-4 col-lg-4 text-center' id="fecha_inicio" style="<?php echo $mostrar_hora_fecha_duracion==='fecha_dedicadas'?'display: block':'display: none';?>">
                <label for='lbl_duracion_fecha_inicio' class="control-label">
                    <?php echo $string_values['lbl_duracion_fecha_inicio']; ?>
                </label>

                <div class="form-group">
                    <div class="input-group date" id="datetimepickerfi" >
                        <label class="registro"><?php echo nice_date($dir_tes['EC_FCH_INICIO'], 'd-m-Y'); ?></label>
                    </div>
                </div>
            </div>

            <div class='col-sm-4 col-lg-4 text-center' id="fecha_fin" style="<?php echo $mostrar_hora_fecha_duracion==='fecha_dedicadas'?'display: block':'display: none';?>">
                <label for='radio_duracion_fecha' class="control-label">
                    <?php echo $string_values['lbl_duracion_fecha_final']; ?>
                </label>
                <div class="form-group">
                    <div class='input-group date' id='datetimepickerff'>
                        <label class="registro"><?php echo nice_date($dir_tes['EC_FCH_FIN'], 'd-m-Y'); ?></label>
                    </div>
                </div>
            </div>
        </div>

		<?php echo $formulario_carga_archivo; ?>
        <?php echo $formulario_validacion; ?>
	</div>
	<?php echo $radio_val; ?>
</div>
<script type="text/javascript">
/*$(function() {
    $('#modal_censo').on('hide.bs.modal', function (e) {
        cargar_datos_menu_perfil('seccion_comision_academica');
        recargar_fecha_ultima_actualizacion();
        $(this).off(e);
    });
});*/
</script>