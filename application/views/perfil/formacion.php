<?php defined('BASEPATH') OR exit('No direct script access allowed');

$this->lang->load('interface','spanish');
$string_values = $this->lang->line('interface');

?>

    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/perfil/formacion.js"></script>

    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#formacionPersonalSalud">
                <strong>
                    <?php echo $string_values['perfil']['lbl_formacion_personal_salud']; ?>
                </strong>
            </a>
        </li>
        <li>
            <a data-toggle="tab" href="#formacionDocente">
                <strong>
                    <?php echo $string_values['perfil']['lbl_formacion_docente']; ?>
                </strong>
            </a>
        </li>
    </ul>
    <div id = 'tabContentFormacion' class='tab-content col-md-12'>
        <div id = 'formacionPersonalSalud' class = 'tab-pane fade in active'>
            <div class="panel">
                 <div class="breadcrumbs6 panel-heading" style="padding-left:20px;">
                    <h3 id="titulo_registro">
                        <?php echo $string_values['perfil']['lbl_formacion_personal_salud']; ?>
                    </h3>
                </div>
                <div class="panel-body">                    
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-12">
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>
                                            <?php echo $string_values['perfil']['lbl_formacion_salud_formacion_profesional']; ?>
                                        </th>
                                        <th>
                                            <?php echo $string_values['perfil']['lbl_formacion_salud_subtipo_formacion_profesional']; ?>
                                        </th>
                                        <th>
                                            <?php echo $string_values['perfil']['lbl_formacion_salud_comprobante']; ?>
                                        </th>
                                        <th>
                                            <?php echo $string_values['perfil']['lbl_formacion_salud_editar']; ?>
                                        </th>
                                        <th>
                                            <?php echo $string_values['perfil']['lbl_formacion_salud_borrar']; ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div clas='row'>
                        <div class="form-group col-xs-4 col-md-4 col-md-offset-8">
                            <button class="btn-link btn-sm" 
                                    id="btnAgregarFormacionProfesional" 
                                    data-toggle="modal" 
                                    data-target="#modalFormacionSalud"
                                    data-idformacion="0"
                                    data-opcion="0">
                                <?php echo $string_values['perfil']['btn_formacion_salud_agregar_formacion_profesional']; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id = 'formacionDocente' class = 'tab-pane fade'>
            formacion docente
        </div>
    </div>
    
    
    <div class="modal fade" id="modalFormacionSalud" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo $string_values['perfil']['lbl_formacion_salud_formacion_profesional']; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-12">
                            <label for='formacion_profesional' class="control-label">
                                <b class="rojo">*</b>
                                <?php echo $string_values['perfil']['lbl_formacion_salud_formacion_profesional']; ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil"> </span>
                                </span>
                                <?php
                                echo $this->form_complete->create_element(
                                        array(
                                            'id' => 'formacion_profesional',
                                            'type' => 'dropdown',
                                            'options' => $formacionProfesionalOptions,
                                            'first' => array('' => $string_values['perfil']['plh_formacion_salud_formacion_profesional']),
                                            'attributes' => array(
                                                'autocomplete' => 'off',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'bottom',
                                                'title' => $string_values['perfil']['plh_formacion_salud_formacion_profesional'],
                                            )
                                        )
                                );
                                ?>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <label for='formacion_profesional' class="control-label">
                                <b class="rojo">*</b>
                                <?php echo $string_values['perfil']['lbl_formacion_salud_subtipo_formacion_profesional']; ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil"> </span>
                                </span>
                                <?php
                                echo $this->form_complete->create_element(
                                        array(
                                            'id' => 'formacion_profesional',
                                            'type' => 'dropdown',
                                            'options' => $formacionProfesionalOptions,
                                            'first' => array('' => $string_values['perfil']['plh_formacion_salud_subtipo_formacion_profesional']),
                                            'attributes' => array(
                                                'autocomplete' => 'off',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'bottom',
                                                'title' => $string_values['perfil']['plh_formacion_salud_subtipo_formacion_profesional'],
                                            )
                                        )
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                    
                       Duracion
                       <hr>
                       Formacion inicial
                       <hr>
                    <div class="row">
                        <div class="form-group col-xs-5 col-md-5">
                            <label for='formacion_salud_tipo_comprobante' class="control-label">
                                <b class="rojo">*</b>
                                <?php echo $string_values['perfil']['lbl_formacion_salud_tipo_comprobante']; ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil"> </span>
                                </span>
                                <?php
                                echo $this->form_complete->create_element(
                                        array(
                                            'id' => 'formacion_salud_tipo_comprobante',
                                            'type' => 'dropdown',
                                            'options' => $tipoComprobanteOptions,
                                            'first' => array('' => $string_values['perfil']['plh_formacion_salud_tipo_comprobante']),
                                            'attributes' => array(
                                                'autocomplete' => 'off',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'bottom',

                                            )
                                        )
                                );
                                ?>
                            </div>
                        </div> 
                        <div class="form-group col-xs-6 col-md-6 col-md-offset-1">
                            <label for='formacion_salud_comprobante' class="control-label">
                                <b class="rojo">*</b>
                                <?php echo $string_values['perfil']['lbl_formacion_salud_comprobante']; ?>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-pencil"> </span>
                                </span>
                                <span class="btn btn-default btn-file">
                                    Seleccionar archivo
                                    <?php
                                    echo $this->form_complete->create_element(
                                            array(
                                                'id' => 'formacion_salud_tipo_comprobante',
                                                'type' => 'upload',
                                                'attributes' => array(
                                                    'autocomplete' => 'off',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'bottom',

                                                )
                                            )
                                    );
                                    ?>
                                </span>
                            </div>
                        </div>   
                    </div>
                </div>
                        <div class="modal-footer">            
                            <button type="button" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                </div>
            </div>
        </div>
            