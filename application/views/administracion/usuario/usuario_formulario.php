<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
    var txt_del_mat = "<?php echo $string_values['buscador']['txt_del_mat']; ?>";
    $(function() {
    <?php if(is_null($identificador) || $accion == "insert"){
            echo "validar_usuario_siap();";
        } ?>
    });
</script>
<?php echo js('administracion/usuario.js'); ?>
<h1><?php echo $string_values['buscador']['titulo']; ?></h1><br>

<?php if(isset($msg) && !is_null($msg)){ echo $msg; } //Imprimir mensaje ?>
<div id="mensaje"></div>

<?php echo form_open('usuario/gestionar_usuario/'.$identificador, array('id'=>'form_usuario')); ?>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label"><span class="pull-right">* <?php echo $string_values['buscador']['fil_delegacion']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'delegacion', 'type'=>'dropdown', 'value'=>$dato_usuario['DELEGACION_CVE'], 'options'=>$catalogos['cdelegacion'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('name'=>'srch_delegacion', 'class'=>'form-control', 'placeholder'=>$string_values['buscador']['fil_delegacion'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['buscador']['fil_delegacion'])));
                echo form_error_format('delegacion'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right">* <?php echo $string_values['lbl_informacion_general_matricula']; ?>:</span></label>
            <div class="col-sm-8">
                <?php 
                if(is_null($identificador) || empty($identificador)){
                    echo '<div class="input-group">'.
                            $this->form_complete->create_element(array('id'=>'matricula', 'type'=>'text', 'value'=>$dato_usuario['USU_MATRICULA'], 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_matricula'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_matricula']))).
                            '<span class="input-group-addon" id="lbl_por_validar" data-toggle="tooltip" data-placement="top" title="'.$string_values['buscador']['lbl_por_validar'].'">
                                <span id="icon_mat_del" class="glyphicon glyphicon-question-sign" ></span>
                            </span>
                        </div>';
                    echo form_error_format('matricula');
                } else {
                    echo $this->form_complete->create_element(array('id'=>'matricula', 'type'=>'hidden', 'value'=>$dato_usuario['USU_MATRICULA']));
                    echo $dato_usuario['USU_MATRICULA'];
                } ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right">* <?php echo $string_values['lbl_informacion_general_nombre']; ?>:</span></label>
            <div class="col-sm-8">
                <?php //echo $dato_usuario['USU_NOMBRE']; 
                echo $this->form_complete->create_element(array('id'=>'nombre', 'type'=>'text', 'value'=>$dato_usuario['USU_NOMBRE'], 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_nombre'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_nombre'])));
                echo form_error_format('nombre'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right">* <?php echo $string_values['lbl_informacion_general_apellido_paterno']; ?>:</span></label>
            <div class="col-sm-8">
                <?php //echo $dato_usuario['USU_PATERNO']; 
                echo $this->form_complete->create_element(array('id'=>'apaterno', 'type'=>'text', 'value'=>$dato_usuario['USU_PATERNO'], 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_apellido_paterno'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_apellido_paterno'])));
                echo form_error_format('apaterno'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right">* <?php echo $string_values['lbl_informacion_general_apellido_materno']; ?>:</span></label>
            <div class="col-sm-8">
                <?php //echo $dato_usuario['USU_MATERNO']; 
                echo $this->form_complete->create_element(array('id'=>'amaterno', 'type'=>'text', 'value'=>$dato_usuario['USU_MATERNO'], 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_apellido_materno'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_apellido_materno'])));
                echo form_error_format('amaterno'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_nombre_area_adscripcion']; ?>:</span></label>
            <div id="lbl_adscripcion" class="col-sm-8">
                <?php echo (isset($dato_usuario['ADSCRIPCION_CVE']) && isset($dato_usuario['dep_nombre'])) ? $dato_usuario['dep_nombre'].' ('.$dato_usuario['ADSCRIPCION_CVE'].')' : ''; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_nombre_categoria']; ?>:</span></label>
            <div id="lbl_categoria" class="col-sm-8">
                <?php echo (isset($dato_usuario['nom_categoria']) && isset($dato_usuario['CATEGORIA_CVE'])) ? $dato_usuario['nom_categoria'].' ('.$dato_usuario['CATEGORIA_CVE'].')' : ''; ?>
            </div>
        </div>
    </div>
    <?php if(!empty($dato_usuario['pre_nombre'])){ ?>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_clave_presupuestal']; ?>:</span></label>
                <div id="lbl_presupuestal" class="col-sm-8">
                    <?php echo (isset($dato_usuario['pre_nombre']) && isset($dato_usuario['presupuestal_cve'])) ? $dato_usuario['pre_nombre'].' ('.$dato_usuario['presupuestal_cve'].')' : ''; ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_curp']; ?>:</span></label>
            <div id="lbl_curp" class="col-sm-8">
                <?php echo (isset($dato_usuario['USU_CURP'])) ? $dato_usuario['USU_CURP'] : ''; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_antiguedad']; ?>:</span></label>
            <div id="lbl_antiguedad" class="col-sm-8">
                <?php echo (isset($dato_usuario['USU_ANTIGUEDAD'])) ? antiguedad_format($dato_usuario['USU_ANTIGUEDAD']): ''; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_genero']; ?>:</span></label>
            <div id="lbl_genero" class="col-sm-8">
                <?php echo (isset($dato_usuario['USU_GENERO'])) ? $this->config->item('USU_GENERO')[$dato_usuario['USU_GENERO']] : ''; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['buscador']['fil_rol']; ?>:</span></label>
            <div class="col-sm-8">
                <?php 
                echo $this->form_complete->create_element(array('id'=>'roles', 'type'=>'multiselect', 'value'=>$dato_usuario['rol'], 'options'=>$catalogos['crol'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('name'=>'estado_civil', 'class'=>'form-control', 'placeholder'=>$string_values['buscador']['fil_rol'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['buscador']['fil_rol'])));
                /*foreach ($dato_usuario['rol'] as $key_rol => $rol) {
                    echo "* ".$rol['ROL_NOMBRE']."<br>";
                }*/
                echo form_error_format('roles[]'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_estado_civil']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'estado_civil', 'type'=>'dropdown', 'value'=>$dato_usuario['CESTADO_CIVIL_CVE'], 'options'=>$catalogos['cestado_civil'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('name'=>'estado_civil', 'class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_estado_civil'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_estado_civil'])));
                echo form_error_format('estado_civil'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_telefono_laboral']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'tel_laboral', 'type'=>'text', 'value'=>$dato_usuario['USU_TEL_LABORAL'], 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_telefono_laboral'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_telefono_laboral'])));
                echo form_error_format('tel_laboral'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_telefono_particular']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'tel_particular', 'type'=>'text', 'value'=>$dato_usuario['USU_TEL_PARTICULAR'], 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_telefono_particular'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_telefono_particular'])));
                echo form_error_format('tel_particular'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right">* <?php echo $string_values['lbl_informacion_general_correo_electronico']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'correo', 'type'=>'text', 'value'=>$dato_usuario['USU_CORREO'], 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_correo_electronico'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_correo_electronico'])));
                echo form_error_format('correo'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_informacion_general_correo_electronico_alt']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'correo_alt', 'type'=>'text', 'value'=>$dato_usuario['USU_CORREO_ALTERNATIVO'], 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_correo_electronico_alt'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_correo_electronico_alt'])));
                echo form_error_format('correo_alt'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_contrasenia']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'contrasenia', 'type'=>'password', 'value'=>'', 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_contrasenia'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_contrasenia'])));
                echo form_error_format('contrasenia'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['lbl_confirma_contrasenia']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'confirma_contrasenia', 'type'=>'password', 'value'=>'', 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_confirma_contrasenia'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_confirma_contrasenia'])));
                echo form_error_format('confirma_contrasenia'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            <label class="col-sm-4 control-label"><span class="pull-right">* <?php echo $string_values['lbl_informacion_general_estado_usuario']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'estado_usuario', 'type'=>'dropdown', 'value'=>$dato_usuario['ESTADO_USUARIO_CVE'], 'options'=>$catalogos['cestado_usuario'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('name'=>'estado_civil', 'class'=>'form-control', 'placeholder'=>$string_values['lbl_informacion_general_estado_usuario'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_informacion_general_estado_usuario'])));
                echo form_error_format('estado_usuario'); ?>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-md-12 col-lg-12'><br>
        <label class="col-sm-8 control-label"><span class="pull-left">* Campos obligatorios</span></label>
        <div class="form-group col-sm-4 text-right">
            <button type="submit" id="btn_usuario_enviar" aria-expanded="false" class="btn btn-default browse" style="margin-right:10px;">
                <?php echo $string_values['enviar']; ?>
            </button>
            <button type="button" id="btn_usuario_cancelar" aria-expanded="false" class="btn btn-default browse">
                <?php echo $string_values['cancelar']; ?>
            </button>
        </div>
    </div>
</div>

<?php echo form_close(); ?>

<!-- TIP_CONTRATACION_CVE -->

