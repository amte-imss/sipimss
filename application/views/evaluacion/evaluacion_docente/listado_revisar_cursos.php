<?php echo css("style-sipimss.css"); ?>

<!--<script type='text/javascript' src="<?php // echo base_url(); ?>assets/js/evaluacion_curricular/index_eva_curricular.js"></script>-->
<script>
    $('.botonF1').hover(function () {
        $('.btn').addClass('animacionVer');
    })
    $('.contenedor').mouseleave(function () {
        $('.btn').removeClass('animacionVer');
    })
</script>

<div class="panel-group" id="accordion">
    <div class="row">
        <div class="col-sm-6">
            <strong><?php echo $string_value_seccion["lbl_info_nombre"]?></strong>
                    <?php echo $empleado["nombre"]." "
                          .$empleado["apellidoPaterno"]." "
                          .$empleado["apellidoMaterno"]?><br />
            <strong><?php echo $string_value_seccion["lbl_info_matricula"]?></strong>
                    <?php echo $empleado["matricula"]?><br />
            <strong><?php //echo $string_value["lbl_info_categoria"]?></strong>
                    <?php //echo $empleado["categoria_PD"]?>
        </div>
        <!-- /.col -->
        <div class="col-sm-6 ">
            <strong><?php echo $string_value_seccion["lbl_info_del"]?></strong>
                    <?php echo $empleado["delegacion"]?><br />
            <strong><?php echo $string_value_seccion["lbl_info_adscripcion"]?></strong>
                    <?php echo $empleado["nombreUnidadAdscripcion"]?><br />
            <strong><?php //echo $string_value["lbl_info_vigencia"]?></strong>
                    <?php // $empleado["vigencia"]?>
        </div>
        <!-- /.col -->
      </div>
    <br>
    <?php
    echo form_open('solicitar_evaluacion/secd');
    foreach ($array_menu as $key_bloque => $value_secc) {
        ?>
        <script >
            /*Guarda los datos de configuración para el uso de ajax en javascript*/
//            hrutes['<?php // echo $value_tab['ruta']; ?>'] = '<?php // echo $value_tab['ruta_padre']; ?>';
        </script>
        <div class="panel box box-success">
            <div class="box-header with-border">
                <h4 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo 'seccion_'.$key_bloque ?>" class="collapsed" aria-expanded="false">
                        <?php echo $string_values[$labels_bloque[$key_bloque]];?>
                    </a>
                </h4>
            </div>
            <div id="msg_<?php echo $key_bloque; ?>"></div>
            <div id="<?php echo 'seccion_'.$key_bloque ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div id="cuerpo_<?php echo $key_bloque ?>" class="box-body">
                    
                    <?php foreach ($value_secc as $key_seccion => $value_mod) {
                        $data['datos_modulo'] = $value_mod;
                        $data['metadatos'] = $info_actividad;
                        $data['pk'] = $info_actividad[$key_bloque][$key_seccion]['pk'];
                        $data['curso'] = $info_actividad[$key_bloque][$key_seccion]['fields']["lbl_" . $key_seccion . "_nombre"];
                        $data['tipo_curso'] = $info_actividad[$key_bloque][$key_seccion]['fields']["lbl_" . $key_seccion . "_tipo"];
                        $data['tp_cve'] = $info_actividad[$key_bloque][$key_seccion]['fields']["tp_cve"];
                        $data['seccion'] = $key_seccion;
                        $data['bloque'] = $key_bloque;
                        $data['view'] = $info_actividad[$key_bloque][$key_seccion]["functions"]["view"];
                        $data['is_post'] = $info_actividad[$key_bloque][$key_seccion]["functions"]["is_post"];
                        //$data['string_values'] = $string_values;
                        
                        //echo $this->load->view('evaluacion_currucular_doc/tablas_seccion_docente/tab_gen_cursos', $data, true);
                        $seleccionar = $this->form_complete->create_element(array('id' => 'checkall_' . $data['bloque'] . '_' . $data['seccion'],
                            'value' => '', 'type' => 'checkbox',
                            'attributes' => array('class' => 'form-control',
                                'placeholder' => $string_values['chek_selct_profesionalizacion'],
                                'onclick' => "seleccionar_deseleccionar_tablas(this)",
                                'data-tabla' => "trve_" . $data['seccion'],
                                'data-check' => "checkall_" . $data['seccion'],
                                'title' => $string_values['chek_selct_profesionalizacion'])));
                        ?>
                        <table class="table table-striped table-hover table-bordered" id="trve_<?php echo $data['seccion']; ?>">
                            <thead>
                                <tr class='bg-info'>
                                    <!-- <th style="width: 12%">¿<?php //echo $string_values['valido']; ?>?</th>-->
                                    <th style="width: 20%"><?php echo $string_values['title_curso'] ?></th>
                                    <th style="width: 20%"><?php echo $string_values['title_tipo_curso'] ?></th>
                                    <th style="width: 50%"><?php //echo $string_values['seccion']; ?></th>
                                    <th style="width: 5%"> <?php //echo $string_values['puntos']; ?></th>
                                    <!-- <th style="width: 3%"></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //Generará la tabla que muestrá las actividades del docente
                                foreach ($data['datos_modulo'] as $key_ai => $value) {
                                    //pr($data);
                                    $reg = $value[$data['metadatos'][$data['bloque']][$data['seccion']]['pk']];
                                    $identificador = $data['bloque']."_".$data['seccion']."_".$reg;
                                    //pr($identificador);
                                    $key = $this->seguridad->encrypt_base64($value[$data['pk']]); //
                                    /*$seccion_metodo = $data['view'];
                                    $checkbox_profesionalizacio = $this->form_complete->create_element(array(
                                        'id' => 'check_' . $key_ai,
                                        'value' => '', 'type' => 'checkbox',
                                        'attributes' => array('class' => 'form-control')
                                            )
                                    );*/
                                    $tipo = (isset($value[$data['tp_cve']]) ? $value[$data['tp_cve']] : '');
                                    $ver = '<button type="button" class="btn btn-link btn-sm btn_ver_me" '
                                            . 'aria-expanded="false" data-toggle="modal" '
                                            . 'data-target="#modal_censo" '
                                            . 'data-value="' . $key . '" '
                                            . 'data-seccion="' . $data['view'] . '"'
                                            . 'data-tipo="' . $tipo . '" '
                                            . 'data-ispost="' . $data['is_post'] . '" '
                                            . 'onclick="ver_curso(this);">' .
                                            $string_values['accion_ver'] .
                                            '</button>';
                                    echo "<tr id='id_row_" . $key_ai . "' data-keyrow=" . $key_ai . ">";
                        //            echo "<td>" . $checkbox_profesionalizacio . "</td>";
                                    //pr($info_cursos_evaluados);
                                    /*pr($key_bloque);
                                    pr($key_seccion);*/
                                    $ice = (isset($info_cursos_evaluados['evaluaciones'][$key_bloque]) && isset($info_cursos_evaluados['evaluaciones'][$key_bloque][$key_seccion])) ? $info_cursos_evaluados['evaluaciones'][$key_bloque][$key_seccion] : null;
                                    

                                    echo "<td>" . $value[$data['curso']] . "</td>";
                                    echo "<td>" . $value[$data['tipo_curso']] . "</td>";
                                    echo '<td><table class="table table-striped table-hover table-bordered">';
                                    $evaluacion_session = $this->session->userdata('evaluacion')['hist_evaluacion'];
                                    foreach ($evaluacion_session as $key_es => $eva_ses) {
                                        echo '<tr><td class="text-center">
                                            <div class="form-group">
                                              <div>
                                                '.$this->form_complete->create_element(
                                                    array('id'=>'valido_'.$identificador, 'type'=>'dropdown',
                                                        'value' => (isset($ice[$reg])) ? $ice[$reg]['EVA_CUR_VALIDO'] : null,
                                                        'options' => $catalogos['EVA_CUR_VALIDO'],
                                                        'first'=>array(''=>'Selecciona...'), 
                                                        'attributes'=>array(
                                                          'class'=>'form-control valido',
                                                          'data-toggle'=>'tooltip',
                                                          //'data-bloque'=>$id,
                                                          //'data-seccion'=>$key_seccion,
                                                          'data-registro'=>$identificador,
                                                          'title'=>'¿'.$string_values['valido'].'?'
                                                        )
                                                      )
                                                  ).'
                                            </div>
                                          </div>
                                        </td>';
                                        echo '<td>'.$eva_ses['ROL_NOMBRE'].'</td>';
                                        echo '<td>'.$this->form_complete->create_element(
                                            array('id' => "seccion_".$identificador, 'type' => 'dropdown', 
                                              'value' => (isset($ice[$reg])) ? $ice[$reg]['SECCION_CVE'] : null,
                                              'options' => $catalogos['cseccion'], 'first'=>array(''=>'Selecciona...'), 
                                              'attributes' => array('class' => 'form-control seccion_drop', 
                                                'disabled'=>'disabled', 'readonly'=>'readonly',
                                                'placeholder' => $string_values['seccion'], 'data-toggle' => 'tooltip', 
                                                'data-placement' => 'top', 'title' => $string_values['seccion']))).'</td>';
                                        echo '<td>'.$this->form_complete->create_element(
                                          array('id'=>"puntos_".$identificador,'type'=>'text',
                                                'value' => (isset($ice[$reg])) ? $ice[$reg]['EVA_CUR_PUNTOS_CURSO'] : null,
                                                'attributes'=>array(
                                                  'class'=>"form-control puntos ".$data['bloque'],
                                                  'data-toggle'=>'tooltip',
                                                  'disabled'=>'disabled',
                                                  'data-bloque'=>$data['bloque'],
                                                  'data-seccion'=>$data['seccion'],
                                                  'readonly'=>'readonly',
                                                  'title'=>$string_values['puntos']
                                                )
                                            )
                                        ).'</td>';
                                        $btn_guardar = '';
                                        //if($this->session->userdata('evaluacion')['EST_EVALUACION_CVE']!=Enum_eei::Completa){
                                          $btn_guardar = '<button type="button" class="btn btn-guardar" id="guardar_'.$identificador.'" data-bloque="'.$data['bloque'].'" 
                                              data-seccion="'.$data['seccion'].'" data-registro="'.$value[$data['metadatos'][$data['bloque']][$data['seccion']]['pk']].'"
                                              data-eva-curso="'.((isset($ice[$reg]['EVA_CURSO_CVE'])) ? $ice[$reg]['EVA_CURSO_CVE'] : null).'"><i class="fa fa-save fa-2x"></i></button>';
                                        //}
                                        echo '<td>
                                          '.$btn_guardar.'
                                        </td></tr>';
                                    }
                                    echo "</table></td>";
                                    echo "<td>" . $ver . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                              <tr>
                                <td colspan="3" class="text-right">Total <?php echo $string_values[$labels_bloque[$key_bloque]]; ?>:</td>
                                <td>
                                  <?php echo $this->form_complete->create_element(
                                    array('id'=>"puntos_seccion_{$data['bloque']}",'type'=>'text',
                                      'value' => "",
                                          'attributes'=>array(
                                            'class'=>'form-control seccion',
                                            'data-value'=>$data['bloque'],
                                            'data-toggle'=>'tooltip',
                                            'disabled'=>'disabled',
                                            'readonly'=>'readonly',
                                            'title'=>$string_values['puntos']
                                          )
                                      )
                                  ); ?>
                                </td>
                              </tr>
                            </tbody>
                        </table>
                        <br>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
      echo form_close();
    }
    ?>
    <br>
</div>
<div class="row">
  <div class="col-lg-12" id="msg_general"></div>
  <div class="col-lg-9 text-right" style="padding-right:20px;">
    <?php 
    //if($this->session->userdata('evaluacion')['EST_EVALUACION_CVE']!=Enum_eei::Completa){
      echo '<button type="button" class="btn" id="btn-correccion"> '.$string_values['enviar_correccion'].'</button>';
      echo '<button type="button" class="btn btn-success" id="btn-finalizar"> '.$string_values['enviar_corroborar'].'</button>';
    //} ?>
  </div>
  
  <div class="col-lg-3 text-right" style="padding-right:20px;">
    <h2><div id="total"></div></h2>
  </div>
</div> 











<!--  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> <?php /*echo $string_value["lbl_info_prof"]?>
          </h2>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
            <strong><?php echo $string_value["lbl_info_nombre"]?></strong>
                    <?php echo $empleado["nombre"]." "
                          .$empleado["apellidoPaterno"]." "
                          .$empleado["apellidoMaterno"]?><br />
            <strong><?php echo $string_value["lbl_info_matricula"]?></strong>
                    <?php echo $empleado["matricula"]?><br />
            <strong><?php //echo $string_value["lbl_info_categoria"]?></strong>
                    <?php //echo $empleado["categoria_PD"]?>
        </div>
        <div class="col-sm-6 ">
            <strong><?php echo $string_value["lbl_info_del"]?></strong>
                    <?php echo $empleado["delegacion"]?><br />
            <strong><?php echo $string_value["lbl_info_adscripcion"]?></strong>
                    <?php echo $empleado["nombreUnidadAdscripcion"]?><br />
            <strong><?php //echo $string_value["lbl_info_vigencia"]?></strong>
                    <?php // $empleado["vigencia"]?>
        </div>
      </div><br />
      <?php 
      echo form_open('solicitar_evaluacion/secd'); 
          //pr($empleado);
      ?>
      <div class="box-group" id="accordion">    
      <?php
      if(isset($cfg_actividad)){
        foreach($cfg_actividad as $id=>$actividad): 
          foreach ($bloques['bloque_'.$id] as $key_seccion => $seccion) {
            $seccion_id = str_replace("seccion_", "", $key_seccion); ?>
            <div class="panel box box-success">
              <div class="box-header with-border">
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $id?>" class="collapsed" aria-expanded="false">
                    <?php echo $string_value[$bloques['labels'][$actividad[$seccion_id]['acronimo']]]; ?>
                  </a>
                </h4>
                <div id="msg_<?php echo $id; ?>"></div>
              </div>
              <div id="collapseThree<?php echo $id?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="box-body  table-responsive no-padding">
                  <table class="table table-hover">
                    <tbody>
                    <tr>
                      <th style="width: 7%">¿<?php echo $string_value['valido']; ?>?</th>
                      <th style="width: 35%"><?php echo $string_value['curso']; ?></th>
                      <th style="width: 30%"><?php echo $string_value['tipo_curso']; ?></th>
                      <th style="width: 20%"><?php echo $string_value['seccion']; ?></th>
                      <th style="width: 5%"><?php echo $string_value['puntos']; ?></th>
                      <th style="width: 3%"></th>
                    </tr>
                    <?php foreach ($seccion as $key_registro => $registro) { //pr($registro);
                        $identificador = $id."_".$seccion_id."_".$registro[$cfg_actividad[$id][$seccion_id]['pk']];
                        $reg = $registro[$cfg_actividad[$id][$seccion_id]['pk']]; ?>
                        <tr>
                          <td class="text-center">
                            <div class="form-group">
                              <div class="checkbox">
                                <label>
                                  <?php echo $this->form_complete->create_element(
                                    array('id'=>'valido_'.$identificador, 'type'=>'dropdown',
                                        'value' => $catalogos['EVA_CUR_VALIDO'],
                                        'attributes'=>array(
                                          'class'=>'form-control valido',
                                          'data-toggle'=>'tooltip',
                                          //'data-bloque'=>$id,
                                          //'data-seccion'=>$key_seccion,
                                          'data-registro'=>$identificador,
                                          'title'=>'¿'.$string_value['valido'].'?',
                                          'style'=>'width:20px; height: 20px;'
                                        )
                                      )
                                  ); ?>
                                </label>
                              </div>
                            </div>
                          </td>
                          <td>
                          <?php
                            echo $registro[$cfg_actividad[$id][$seccion_id]['fields']['lbl_'.$seccion_id.'_nombre']];
                          ?>
                          </td>
                          <td>
                            <?php
                            echo $registro[$cfg_actividad[$id][$seccion_id]['fields']['lbl_'.$seccion_id.'_tipo']];
                            ?>
                          </td>
                          <td>
                            <?php echo $this->form_complete->create_element(
                              array('id' => "seccion_".$identificador, 'type' => 'dropdown', 
                                'options' => $catalogos['cseccion'], 'first'=>array(''=>'Selecciona...'), 
                                'attributes' => array('class' => 'form-control', 
                                  'disabled'=>'disabled', 'readonly'=>'readonly',
                                  'placeholder' => $string_value['seccion'], 'data-toggle' => 'tooltip', 
                                  'data-placement' => 'top', 'title' => $string_value['seccion']))); ?>
                          </td>
                          <td>
                            <?php echo $this->form_complete->create_element(
                              array('id'=>"puntos_".$identificador,'type'=>'text',
                                'value' => '',
                                    'attributes'=>array(
                                      'class'=>"form-control puntos $id",
                                      'data-toggle'=>'tooltip',
                                      'disabled'=>'disabled',
                                      'data-bloque'=>$id,
                                      'data-seccion'=>$key_seccion,
                                      'readonly'=>'readonly',
                                      'title'=>$string_value['puntos']
                                    )
                                )
                            ); ?>
                          </td>
                          <td>
                            <button type="button" class="btn btn-guardar" id="guardar_<?php echo $identificador; ?>" data-bloque="<?php echo $id; ?>" 
                              data-seccion="<?php echo $seccion_id;?>" data-registro="<?php echo $reg;?>"><i class="fa fa-save fa-2x"></i></button>
                          </td>
                        </tr>
                        <?php 
                        }
                        ?>
                        <tr>
                          <td colspan="4" class="text-right">Total <?php echo $string_value[$bloques['labels'][$actividad[$seccion_id]['acronimo']]]; ?>:</td>
                          <td>
                            <?php echo $this->form_complete->create_element(
                              array('id'=>"puntos_seccion_{$id}",'type'=>'text',
                                'value' => "",
                                    'attributes'=>array(
                                      'class'=>'form-control seccion',
                                      'data-value'=>"$id",
                                      'data-toggle'=>'tooltip',
                                      'disabled'=>'disabled',
                                      'readonly'=>'readonly',
                                      'title'=>$string_value['puntos']
                                    )
                                )
                            ); ?>
                          </td>
                        </tr>
                    <?php } ?>
                  </tbody>
                 </table>
                </div>
              </div>
            </div>
          <?php
        endforeach;
      }
      ?>
    </div>
    <div class="row">
      <div class="col-lg-12 text-right" style="padding-right:20px;">
        <h2><div id="total"></div></h2>
      </div>
    </div>
    <?php echo form_close();*/ ?>
  </div>
</div> -->
<script type="text/javascript">
$(document).ready(function(){
  $('.valido').on("click", function() {
    habilitar_puntos(this);
  });
  $('.puntos').on("keyup", function() {
    var clase = $(this).attr('data-bloque');
    calcular_puntos_seccion(clase);
  });
  $('.btn-guardar').on("click", function() {
    guardar_puntos(this);
  });
  $('#btn-finalizar').on("click", function() {
    finalizar();
  });
  jQuery.each( $('.valido'), function( i, val ) {
    habilitar_puntos(val);
  });
  $.each( $('.puntos'), function( i, val ) {
    if($(this).val()!=""){
      var clase = $(this).attr('data-bloque');
      calcular_puntos_seccion(clase);
    }
  });
});
function finalizar(){
  var validacion = 0;
  $.each($('.valido'), function(index, val) {
    if($(this).val()===""){
      validacion++;
    }
  });
  if(validacion===0){
    //data_ajax(site_url+'/evaluacion_docente/finalizar_evaluacion', null, '#msg_general');
    $.ajax({
        url: site_url + '/evaluacion_docente/finalizar_evaluacion',
        method: 'POST',
        dataType: "json",
        beforeSend: function(xhr) {
            $('#msg_general').html(create_loader());
        }
    })
    .done(function(response) {
        $('#msg_general').html(imprimir_resultado(response));
        if(response.result==true){
          $('.btn-guardar').hide();
          $('#btn-finalizar').hide();
          /*$('.puntos').attr('disabled', 'disabled');
          $('.puntos').attr('readonly', 'readonly');
          $('.seccion_drop').attr('disabled', 'disabled');
          $('.seccion_drop').attr('readonly', 'readonly');
          $('.valido').attr('disabled', 'disabled');
          $('.valido').attr('readonly', 'readonly');*/
        }
    })
    .fail(function(jqXHR, response) {
        $('#msg_general').html(imprimir_resultado(response));
    })
    .always(function() {
        remove_loader();
    });
  } else {
    apprise('<?php echo $string_values["faltante_validar"]; ?>');
  }
}
function habilitar_puntos(elemento){
  var id = $(elemento).attr('data-registro');
  var clase = $(elemento).attr('data-clase');
  if($(elemento).val()=="<?php echo $this->config->item('EVA_CUR_VALIDO')['VALIDO']['id']; ?>"){ //Habilitar elementos para puntuación
    $("#puntos_"+id).removeAttr('disabled');
    $("#puntos_"+id).removeAttr('readonly');
    $("#seccion_"+id).removeAttr('disabled');
    $("#seccion_"+id).removeAttr('readonly');
    //$("#guardar_"+id).removeAttr('disabled');
    //$("#guardar_"+id).removeAttr('readonly');
    //$("#guardar_"+id).addClass('btn-success');
    /*$("#guardar_"+id).bind( "click" , function( event ) {
      alert( "The quick brown fox jumps over the lazy dog." );
      timesClicked++;
      if ( timesClicked >= 3 ) {
        $( this ).unbind( event );
      }
    });*/
  } else { //Deshabilitar y borrar datos
    $("#puntos_"+id).attr('disabled', 'disabled');
    $("#puntos_"+id).attr('readonly', 'readonly');
    $("#puntos_"+id).val('');
    $("#seccion_"+id).attr('disabled', 'disabled');
    $("#seccion_"+id).attr('readonly', 'readonly');
    $("#seccion_"+id).val('');
    //$("#guardar_"+id).attr('disabled', 'disabled');
    //$("#guardar_"+id).attr('readonly', 'readonly');
    //$("#guardar_"+id).removeClass('btn-success');
    //$("#guardar_"+id).unbind( "click" );
  }
  calcular_puntos_seccion(clase);
}
function guardar_puntos(elemento){
  //var id = $(elemento).attr('data-registro');
  var seccion = $(elemento).attr('data-seccion');
  var bloque = $(elemento).attr('data-bloque');
  var registro = $(elemento).attr('data-registro');
  var valido = $("#valido_"+bloque+"_"+seccion+"_"+registro).val();
  if( valido == "" ){
    apprise('<?php echo $string_values["error_guardar_puntos_valido"]; ?>');
  } else if(valido=="<?php echo $this->config->item('EVA_CUR_VALIDO')['VALIDO']['id']; ?>" && ($("#seccion_"+bloque+"_"+seccion+"_"+registro).val()=="" || $("#puntos_"+bloque+"_"+seccion+"_"+registro).val()=="")) {
    apprise('<?php echo $string_values["error_guardar_puntos"]; ?>');
  } else {
    if(valido=="<?php echo $this->config->item('EVA_CUR_VALIDO')['NO_VALIDO']['id']; ?>") { //Limpiar datos que puedan interferir
      $("#seccion_"+bloque+"_"+seccion+"_"+registro).val('');
      $("#puntos_"+bloque+"_"+seccion+"_"+registro).val('');
    }
    var puntos = $("#puntos_"+bloque+"_"+seccion+"_"+registro).val();
    var seccion_dictamen = $("#seccion_"+bloque+"_"+seccion+"_"+registro).val();
    var data_eva_curso = $(elemento).attr('data-eva-curso');
    $.ajax({
        url: site_url + '/evaluacion_docente/guardar_puntos_registro/',
        method: 'POST',
        dataType: "json",
        data: {'bloque': bloque, 'seccion': seccion, 'registro': registro, 'valido': valido, 'puntos': puntos, 'seccion_dictamen': seccion_dictamen, 'data_eva_curso': data_eva_curso},
        beforeSend: function(xhr) {
            $('#msg_'+bloque).html(create_loader());
        }
    })
    .done(function(response) {
        $('#msg_'+bloque).html(imprimir_resultado(response));
        if(response.result==true){
          if(response.accion=='I'){
            $(elemento).attr('data-eva-curso', response.data.identificador);
          }
        }
    })
    .fail(function(jqXHR, response) {
        $('#msg_'+bloque).html(imprimir_resultado(response));
    })
    .always(function() {
        remove_loader();
    });
  }
}
function calcular_puntos_seccion(clase){
  var total = 0;
  //console.log(clase);
  $("."+clase).each(function( index ) {
    total += Number($(this).val()); 
  });
  //console.log(total);
  $("#puntos_seccion_"+clase).val(total);
  calcular_puntos_total();
}
function calcular_puntos_total(){
  var total = 0;
  $(".seccion").each(function( index ) {
    total += Number($(this).val()); 
  });
  $("#total").html("Total de puntos:  "+total);
}
</script>