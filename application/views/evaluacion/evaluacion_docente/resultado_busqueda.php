<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><?php echo $string_values['matricula_docente'] ?></th>
                    <th class="text-center"><?php echo $string_values['nombre_docente'] ?></th>
                    <th class="text-center"><?php echo $string_values['delegacion'] ?></th>
                    <th class="text-center"><?php echo $string_values['categoria'] ?></th>
                    <!-- <th class="text-center"></th> -->
                    <th class="text-center"><?php echo $string_values['estado'] ?></th>
                    <th class="text-center"><?php echo $string_values['opciones'] ?></th>
                </tr>
            </thead>
            <tbody>
                <?php //Generará la tabla que muestrá las actividades del docente
                $html = "";
                foreach ($data as $evaluacion) {
                    //pr($evaluacion); ///Obtener estado de la evaluación
                    $solicitud_cve = $this->seguridad->encrypt_base64(intval($evaluacion['VALIDACION_CVE']));
                    $empleado_cve = $this->seguridad->encrypt_base64(intval($evaluacion['EMPLEADO_CVE']));
                    $matricula = $this->seguridad->encrypt_base64($evaluacion['emp_matricula']);
                    //$hist_val_cve = $this->seguridad->encrypt_base64(intval($val['historia_validacion_cve']));
                    $estado_val = $this->seguridad->encrypt_base64(intval($evaluacion['CESE_CVE']));
                    $usuario_cve = $this->seguridad->encrypt_base64(intval($evaluacion['USUARIO_CVE']));
                    $link_ver_curso = 'class="text-center" onclick="funcion_ver_validacion_empleado(this)" '
                        . 'data-empcve="' . $empleado_cve . '"'
                        . 'data-matricula="' . $matricula . '"'
                        . 'data-estval="' . $estado_val . '"'
                        //. 'data-histvalcve="' . $hist_val_cve . '"'
                        . 'data-solicitudcve="' . $solicitud_cve . '"'
                        . 'data-usuariocve="' . $usuario_cve . '"';
                    $estado = ($evaluacion['CESE_CVE']==Enum_es::Envio_evaluacion) ? ((empty($evaluacion['estado']) && $evaluacion['estado']==0) ? $this->config->item('cestado_evaluacion')[Enum_ee::Por_evaluar]['value'] : $this->config->item('cestado_evaluacion')[$evaluacion['estado']]['value']) : $evaluacion['CESE_NOMBRE'];
                    $evaluar = ($evaluacion['CESE_CVE']==Enum_es::Envio_evaluacion || $evaluacion['CESE_CVE']==Enum_es::Evaluacion) ? '<span '.$link_ver_curso.'><a data-toggle="tab" href="#select_perfil_validar_evaluacion">'.$string_values['evaluar'].'</a></span>' : '';
                    $html .= '<tr id="tr_'.$this->seguridad->encrypt_base64($evaluacion['VALIDACION_CVE']).'">
                            <td>'.$evaluacion['emp_matricula'].'</td>
                            <td>'.$evaluacion['EMP_NOMBRE'].' '.$evaluacion['EMP_APE_PATERNO'].' '.$evaluacion['EMP_APE_MATERNO'].'</td>
                            <td>'.$evaluacion['DEL_NOMBRE'].'</td>
                            <td>'.$evaluacion['nom_categoria'].'</td>
                            <!-- <td></td> -->
                            <td>'.$estado.'</td>
                            <td>
                                '.$evaluar.'
                                <!-- <button type="button" class="btn btn-link btn-sm btn_evaluar" data-value="'.$this->seguridad->encrypt_base64($evaluacion['VALIDACION_CVE']).'">'.
                                   $string_values['evaluar'].
                                '</button> -->
                            </td>
                        </tr>';
                }
                echo $html;
                ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	/*$(".btn_editar_usu").click(function(event){
        //data_ajax(site_url+"/usuario/get_data_ajax", "#form_search", "#resultado_busqueda");
        document.location.href=site_url+"/usuario/gestionar_usuario/"+$(this).attr('data-value');
    });*/
});
</script>