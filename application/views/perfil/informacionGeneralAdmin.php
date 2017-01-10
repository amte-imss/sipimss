<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    $this->lang->load('interface','spanish');
    $string_values = $this->lang->line('interface');
?>
    
    
    <!-- Inicio informacion personal -->
    <div class='row'>
        <h3 class='pinfo'><?php echo $string_values['perfil']['lbl_informacion_general_informacion_personal']; ?> <small><span class="rojo">*</span> <?php echo $string_values['registro']['lbl_campos_obligatorios']; ?></small></h3>
    </div>
    <?php echo form_open('', array('id'=>'form_informacion_general')); ?>
    <div class='row'> 
        <div class="form-group col-xs-3 col-md-3">
            <label for='perfil_apellido_paterno' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['perfil']['lbl_informacion_general_apellido_paterno']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-pencil"> </span>
                </span>
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_apellido_paterno',
                        'type'=>'text',
                        'value' => !empty($apellidoPaterno) ? $apellidoPaterno : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal nameFields',
                            'placeholder'=>$string_values['perfil']['plh_informacion_general_apellido_paterno'],
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['perfil']['plh_informacion_general_apellido_paterno'],
                            'maxlength'=>15,
                            'readonly' => 'readonly',
                              
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_apellido_paterno'); ?>
        </div>
        <div class="form-group col-xs-3 col-md-3">
            <label for='perfil_apellido_materno' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['perfil']['lbl_informacion_general_apellido_materno']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_apellido_materno',
                        'type'=>'text',
                        'value' => !empty($apellidoMaterno) ? $apellidoMaterno : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal nameFields',
                            'placeholder'=>$string_values['perfil']['plh_informacion_general_apellido_materno'],
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['perfil']['plh_informacion_general_apellido_materno'],
                            'maxlength'=>15,
                            'readonly' => 'readonly'
                            )
                        )
                    );
            ?>
            </div>
            <?php   echo form_error_format('perfil_apellido_materno'); ?>
        </div>
        <div class="form-group col-xs-3 col-md-3">
            <label for='perfil_nombre' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['perfil']['lbl_informacion_general_nombre']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_nombre',
                        'type'=>'text',
                        'value' => !empty($nombre) ? $nombre : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal nameFields',
                            'placeholder'=>$string_values['perfil']['plh_informacion_general_nombre'],
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['perfil']['plh_informacion_general_nombre'],
                            'maxlength'=>15,
                            'readonly' => 'readonly'
                            )
                        )
                    );
            ?>
            </div>
            <?php   echo form_error_format('perfil_nombre'); ?>
        </div>
        <div class="form-group col-xs-3 col-md-3 button-padding">
            <button type="button" class="btn btn-primary btn-xs" id="btnEditarNombre">
               <?php echo $string_values['perfil']['btn_informacion_general_editar_nombre']; ?> 
            </button>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_edad' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['perfil']['lbl_informacion_general_edad']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-pencil"> </span>
                </span>
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_edad',
                        'type'=>'text',
                        'value' => !empty($edad) ? $edad : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'placeholder'=>$string_values['perfil']['plh_informacion_general_edad'],
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>30,
                            'readonly' => 'readonly'
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_edad'); ?>    
        </div> 
        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
            <label for='perfil_genero' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['perfil']['lbl_informacion_general_genero']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-pencil"> </span>
                </span>
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_genero',
                        'type'=>'dropdown',
                        'options'=>$generos,
                        'first' => array('' => $string_values['perfil']['plh_informacion_general_genero'] ),
                        'value' => $generoSelected,
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['perfil']['plh_informacion_general_genero'],
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_genero'); ?> 
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_estado_civil' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['perfil']['lbl_informacion_general_estado_civil']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-pencil"> </span>
                </span>
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_estado_civil',
                        'type'=>'dropdown',
                        'options'=>$estadosCiviles,
                        'first' => array('' => $string_values['perfil']['plh_informacion_general_estado_civil'] ),
                        'value' => $estadoCivilSelected,
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['perfil']['plh_informacion_general_estado_civil'],
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_estado_civil'); ?>    
        </div>
        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
            <label for='perfil_correo_electronico' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['perfil']['lbl_informacion_general_correo_electronico']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon"><strong>@</strong> </span>
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_correo_electronico',
                        'type'=>'text',
                        'value' => !empty($correoElectronico) ? $correoElectronico : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'placeholder'=>$string_values['perfil']['plh_informacion_general_correo_electronico'],
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['perfil']['plh_informacion_general_correo_electronico'],
                            'maxlength'=>30
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_correo_electronico'); ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_telefono_particular' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['perfil']['lbl_informacion_general_telefono_particular']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-phone-alt"> </span>
                </span>
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_telefono_particular',
                        'type'=>'text',
                        'value' => !empty($telParticular) ? $telParticular : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'placeholder'=>$string_values['perfil']['plh_informacion_general_telefono_particular'],
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['perfil']['plh_informacion_general_telefono_particular'],
                            'maxlength'=>30
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_telefono_particular'); ?>
        </div>
        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
            <label for='perfil_telefono_laboral' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['perfil']['lbl_informacion_general_telefono_laboral']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-phone-alt"> </span>
                </span>
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_telefono_laboral',
                        'type'=>'text',
                        'value' => !empty($telLaboral) ? $telLaboral : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'placeholder'=>$string_values['perfil']['plh_informacion_general_telefono_laboral'],
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['perfil']['plh_informacion_general_telefono_laboral'],
                            'maxlength'=>30
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_telefono_laboral'); ?>    
        </div>    
    </div>
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_empleos_actuales' class="control-label">
                <?php echo $string_values['perfil']['lbl_informacion_general_empleos_actuales']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-pencil"> </span>
                </span>
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_empleos_actuales',
                        'type'=>'text',
                        'value' => !empty($empleosFueraImss) ? $empleosFueraImss : 0,
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'placeholder'=>$string_values['perfil']['plh_informacion_general_empleos_actuales'],
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>$string_values['perfil']['plh_informacion_general_empleos_actuales'],
                            'maxlength'=>30
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_empleos_actuales'); ?> 
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-4 col-md-4 col-md-offset-4 text-center">
            <button type="button" class="btn btn-success" id="btn_informacion_general_personal">
               <?php echo $string_values['perfil']['btn_informacion_general_guardar_informacion_personal']; ?> 
            </button>
        </div>    
    </div>
    <?php echo form_close(); ?>
    <!-- Fin informacion personal-->
    <!--Inicio informacion IMSS-->
    <div class='row'>
        <h3 class='pinfo'><?php echo $string_values['perfil']['lbl_informacion_general_informacion_imss']; ?></h3>
    </div>
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_matricula' class="control-label">
                <?php echo $string_values['perfil']['lbl_informacion_general_matricula']; ?>
            </label>
            <div class="input-group">                
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_matricula',
                        'type'=>'text',
                        'value' => !empty($matricula) ? $matricula : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>10,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_matricula'); ?>    
        </div> 
        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
            <label for='perfil_delegacion' class="control-label">
                
                <?php echo $string_values['perfil']['lbl_informacion_general_delegacion']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_delegacion',
                        'type'=>'text',
                        'value' => !empty($delegacion) ? $delegacion : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>20,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_delegacion'); ?> 
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_nombre_categoria' class="control-label">
                
                <?php echo $string_values['perfil']['lbl_informacion_general_nombre_categoria']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_nombre_categoria',
                        'type'=>'text',
                        'value' => !empty($nombreCategoria) ? $nombreCategoria : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>25,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_nombre_categoria'); ?>    
        </div> 
        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
            <label for='perfil_clave_categoria' class="control-label">
                
                <?php echo $string_values['perfil']['lbl_informacion_general_clave_categoria']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_clave_categoria',
                        'type'=>'text',
                        'value' => !empty($claveCategoria) ? $claveCategoria : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>11,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_clave_categoria'); ?> 
        </div>
    </div>    
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_nombre_area_adscripcion' class="control-label">
                
                <?php echo $string_values['perfil']['lbl_informacion_general_nombre_area_adscripcion']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_nombre_area_adscripcion',
                        'type'=>'text',
                        'value' => !empty($nombreAreaAdscripcion) ? $nombreAreaAdscripcion : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>20,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_nombre_area_adscripcion'); ?>    
        </div> 
        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
            <label for='perfil_nombre_unidad_adscripcion' class="control-label">
                
                <?php echo $string_values['perfil']['lbl_informacion_general_nombre_unidad_adscripcion']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_nombre_unidad_adscripcion',
                        'type'=>'text',
                        'value' => !empty($nombreUnidadAdscripcion) ? $nombreUnidadAdscripcion : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>20,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_nombre_unidad_adscripcion'); ?> 
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_nombre_clave_adscripcion' class="control-label">
                
                <?php echo $string_values['perfil']['lbl_informacion_general_nombre_clave_adscripcion']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_nombre_clave_adscripcion',
                        'type'=>'text',
                        'value' => !empty($claveAdscripcion) ? $claveAdscripcion : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>20,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_nombre_clave_adscripcion'); ?>    
        </div> 
        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
            <label for='perfil_clave_antiguedad' class="control-label">                
                <?php echo $string_values['perfil']['lbl_informacion_general_antiguedad']; ?>
            </label>
            <div class="row">
                <div class="form-group col-xs-4 col-md-4">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(
                                array(
                                    'id'=>'perfil_antiguedad_anios',
                                    'type'=>'text',
                                    'value' => !empty($antiguedadAnios) ? $antiguedadAnios : '',
                                    'attributes'=>array(
                                        'class'=>'form-control-personal',
                                        'autocomplete'=>'off',
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'bottom',
                                        'title'=>$string_values['perfil']['lbl_informacion_general_antiguedad_anios'],
                                        'maxlength'=>20,
                                        'disabled' => true,
                                        )
                                    )
                                );
                        ?>
                    </div>
                    <small><?php echo $string_values['perfil']['lbl_informacion_general_antiguedad_anios']; ?></small>
                </div>
                <div class="form-group col-xs-4  col-md-4">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(
                                array(
                                    'id'=>'perfil_antiguedad_quincenas',
                                    'type'=>'text',
                                    'value' => !empty($antiguedadQuincenas) ? $antiguedadQuincenas : '',
                                    'attributes'=>array(
                                        'class'=>'form-control-personal',
                                        'autocomplete'=>'off',
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'bottom',
                                        'title'=>$string_values['perfil']['lbl_informacion_general_antiguedad_quincenas'],
                                        'maxlength'=>20,
                                        'disabled' => true,
                                        )
                                    )
                                );
                        ?>
                    </div>
                    <small><?php echo $string_values['perfil']['lbl_informacion_general_antiguedad_quincenas']; ?></small>
                </div>
                <div class="form-group col-xs-4 col-md-4">
                    <div class="input-group">
                        <?php
                        echo $this->form_complete->create_element(
                                array(
                                    'id'=>'perfil_antiguedad_dias',
                                    'type'=>'text',
                                    'value' => !empty($antiguedadDias) ? $antiguedadDias : '',
                                    'attributes'=>array(
                                        'class'=>'form-control-personal',
                                        'autocomplete'=>'off',
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'bottom',
                                        'title'=>$string_values['perfil']['lbl_informacion_general_antiguedad_dias'],
                                        'maxlength'=>20,
                                        'disabled' => true,
                                        )
                                    )
                                );
                        ?>
                    </div>
                    <small><?php echo $string_values['perfil']['lbl_informacion_general_antiguedad_dias']; ?></small>
                </div>
            </div>
            <?php echo form_error_format('perfil_antiguedad'); ?> 
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_tipo_contratacion' class="control-label">                
                <?php echo $string_values['perfil']['lbl_informacion_general_tipo_contratacion']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_tipo_contratacion',
                        'type'=>'text',
                        'value' => !empty($tipoContratacion) ? $tipoContratacion : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>20,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_tipo_contratacion'); ?>    
        </div> 
        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
            <label for='perfil_estatus_empleado' class="control-label">                
                <?php echo $string_values['perfil']['lbl_informacion_general_estatus_empleado']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_estatus_empleado',
                        'type'=>'text',
                        'value' => !empty($estatusEmpleado) ? $estatusEmpleado : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>20,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_estatus_empleado'); ?> 
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-5 col-md-5">
            <label for='perfil_clave_presupuestal' class="control-label">                
                <?php echo $string_values['perfil']['lbl_informacion_general_clave_presupuestal']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_clave_presupuestal',
                        'type'=>'text',
                        'value' => !empty($clavePresupuestal) ? $clavePresupuestal : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>20,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_clave_presupuestal'); ?>    
        </div> 
        <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
            <label for='perfil_curp' class="control-label">
                
                <?php echo $string_values['perfil']['lbl_informacion_general_curp']; ?>
            </label>
            <div class="input-group">
            <?php
            echo $this->form_complete->create_element(
                    array(
                        'id'=>'perfil_curp',
                        'type'=>'text',
                        'value' => !empty($curp) ? $curp : '',
                        'attributes'=>array(
                            'class'=>'form-control-personal',
                            'autocomplete'=>'off',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'maxlength'=>20,
                            'disabled' => true,
                            )
                        )
                    );
            ?>
            </div>
            <?php echo form_error_format('perfil_curp'); ?> 
        </div>
    </div>
    <!--Fin informacion IMSS-->
<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/perfil/informacionGeneral.js"></script>
