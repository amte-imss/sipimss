<?php 	defined('BASEPATH') OR exit('No direct script access allowed');	?> 
    <script src="<?= base_url() ?>assets/js/dictamen/dictamen_formato.js" type="text/javascript"></script>
    <style type="text/css">
            *,*:before,*:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            }
            .texto-titulo{
                font-size: 1.2em;
            }
            .texto-negrita{
                font-weight: 900;
            }
            .texto-chico{
                font-size: 0.8em;
            }
            .td-texto-centrado{
                text-align: center;
            }
            .td-table-container{
                padding: 0px 5px;
            }
            .img-firma-dr{
                width: 100px;
                margin-left: auto;
                margin-right: auto;
                display: block;
            }
            #tabla_padre{
                background-color: white;
            }
            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
                border-top:  0.5px solid #c0c0c0;
            }
            hr {
              page-break-after: always;
              border: 1;
              margin: 0;
              padding: 0;
            }
            
            .border-bottom{
                border-bottom: 0.5px solid #c0c0c0;
            }
            .border-top{
                border-top: 0.5px solid #c0c0c0;
            }
            .table_fath {
                border-collapse: collapse;
                border: 0.5px solid #c0c0c0;
                }

            .table {
                border-collapse: collapse;
                border: 0.5px solid #c0c0c0;
                margin-bottom: 1px !important;
                }
            .table th, .table td {
                border: 0.5px solid #c0c0c0;
            }
            
            .header,
            .footer {
                width: 100%;
                position: fixed;
            }
            .header {
                top: 0px;
            }
            .footer {
                bottom: 0px;
            }
            .pagenum:before {
                content: counter(page);
            }

        </style>
        <div class="row">
            <div class="col-md-2">
                <a class="btn btn-default" href="<?= base_url() ?>index.php/dictamen/" role="button">
                    <i class="glyphicon glyphicon-share-alt" style="-moz-transform: scale(-1, 1);
                                                                    -webkit-transform: scale(-1, 1);
                                                                    -o-transform: scale(-1, 1);
                                                                    -ms-transform: scale(-1, 1);
                                                                    transform: scale(-1, 1);"></i>
                    Regresar
                </a>
            </div>
        </div>
        <br>
        <!--Tabla de formato de Dictamen-->
        <!--cabecera estilo aprobado-->
        <div style="width: 100%; background-color: white; border:  0.5px solid #c0c0c0; margin-bottom: 8px;">
            <?php echo img("logo_imssprintv1.png");?>
        </div>
        <!--segunda parte cabecera-->
        <div style="width: 100%; background-color: white; border:  0.5px solid #c0c0c0; text-align: center; margin-bottom: 8px;">
            <p class="texto-negrita">
                INSTITUTO MEXICANO DEL SEGURO SOCIAL <br>
                DIRECCIÓN DE PRESTACIONES MÉDICAS<br>   
                UNIDAD DE EDUCACIÓN, INVESTIGACIÓN Y POLÍTICAS DE SALUD<br>
                COORDINACIÓN DE EDUCACIÓN EN SALUD
            </p>
            <hr style=" border-top: 1px solid #ccc;">
            <p class="texto-negrita">Dictamen de evaluación curricular docente</p>
        </div>
        
        <table width="100%" id="tabla_padre" class="table_fath">
            <tr id="fila_encabezado">
              <td>
              </td>
            </tr>
            <tr id="fila_cuerpo">
              <td>
                <table width="100%" id="tabla_dictamen">
                  <tr id="datos_personales">
                    <td class="td-table-container">
                      <table width="100%" id="tabla_datos_personal">
                        <tr>
                            <td>Nombre: <span id="spanNombreDocente"><?= $empleado['nombre']. ' '.$empleado['apellidoPaterno']. ' '.$empleado['apellidoMaterno']   ?></span></td>
                            <td>No. de Expediente: <span id="spanNumExpediente">ECD-17546-97</span></td>
                        </tr>
                        <tr>
                            <td>Fecha de evaluación: <span id="spanFechaEvaluacion"> 07/10/2016 </span></td>
                            <td>Delegación:  <span id="spanDelgacion"><?= $empleado['delegacion'] ?></span></td>
                        </tr>
                        <tr>
                            <td>Adscripción: <span id="spanAdscripcion" ><?= $empleado['nombreAreaAdscripcion'] ?></span></td>
                          <td></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr id="datos_formacion td-table-container">
                      <td class="border-bottom td-table-container ">
                          <br>
                          <span class="texto-titulo">1. FORMACIÓN DOCENTE.</span> 
                          <span id="spanFormacionDocente">Medico Cirujano </span> <!-- aqui va la formación que ha tenido el docente-->
                        <br><br>
                    </td>
                    
                  </tr>
                  <tr id="actividad_docente">
                      <td class="td-table-container "><span class="texto-titulo">2. ACTIVIDADES DOCENTES.</span>
                          <br><span>Número de años de actividad ininterrumpida dentro del IMSS: </span><span id="spanAnniosActidadImss">5</span>
                        <table width="100%" class="table" id="tabla_actividad">
                            <tr style="text-align:center">
                              <td rowspan="2">Modalidad</td>
                              <td colspan="2">Número de cursos</td>
                              <td rowspan="2">Puntos</td>
                            </tr>
                            <tr style="text-align:center">
                              <td>Hasta un semestre</td>
                              <td>Hasta un año</td>
                            </tr>
                            <tr>
                              <td>Formación</td>
                              <td class="td-texto-centrado">
                                  <span id="spanFormacion1semestre">3</span> <!-- aqui se colocan los cursos de formación hasta un semestre-->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanFormacion1annio">1</span> <!-- aqui se colocan los cursos de formación de hasta un año -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanFormacionPuntos">20</span> <!-- aqui se coloca el total de puntos por los cursos de formación -->
                              </td>
                            </tr>
                            <tr>
                              <td>Educación continua</td>
                              <td class="td-texto-centrado">
                                  <span id="spanEducacionContinua1semestre">0</span> <!-- aqui se colocan los cursos de educación continua de hasta un semestre  -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanEducacionContinua1annio">0</span> <!-- aqui se colocan los cursos de educación continua de hasta un año -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanEducacionContinuaPuntos">0</span> <!-- aqui se colocan los cursos de educacuón continua -->
                              </td>
                            </tr>
                        </table>
                        <div style="text-align:right; float: right; display: table; width: 15%" id="subtotal">
                            <div style="display: table-row">
                                <div style="display: table-cell; width: 40%">SUBTOTAL:</div>
                                <div style="display: table-cell; width: 55%; border-bottom: 1px solid  #c0c0c0" class="td-texto-centrado">
                                    <span id="spanTotalActividades">20</span> <!--  En esta parte se coloca la suma de los puntos de educación continua y formacion -->
                                </div>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr id="direccion_tesis">
                      <td class="td-table-container"><span class="texto-titulo">3. DIRECCIÓN DE TESIS.</span>
                        <table width="100%" class="table" id="tabla_actividad">                        
                            <tr>
                              <td>Nivel</td>
                              <td>Técnico</td>
                              <td>Licenciatura</td>
                              <td>Especialidad</td>
                              <td>Maestría</td>
                              <td>Doctorado</td>
                            </tr>
                            <tr>
                              <td>Número</td>
                              <td class="td-texto-centrado">
                                  <span id="spanDireccionTesisTecnico">2</span> <!-- en esta parte se coloca la candidad de direccion de tesis tecnico -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanDireccionTesisLicenciatura">3</span> <!-- en esta parte se coloca la candidad de direccion de tesis licenciatura -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanDireccionTesisEspecialidad">1</span> <!-- en esta parte se coloca la candidad de direccion de tesis especialidad -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanDireccionTesisMaestria">1</span> <!-- en esta parte se coloca la candidad de direccion de tesis maestría -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanDireccionTesisDoctorado">0</span> <!-- en esta parte se coloca la candidad de direccion de tesis doctorado -->
                              </td>
                            </tr>
                        </table>
                        <div style="text-align:right; float: right; display: table; width: 15%" id="subtotal">
                            <div style="display: table-row">
                                <div style="display: table-cell; width: 40%">SUBTOTAL:</div>
                                <div style="display: table-cell; width: 55%; border-bottom: 1px solid  #c0c0c0" class="td-texto-centrado">
                                    <span id="spanDireccionTesisPuntos">16</span> <!-- En esta parte se colocan los puntos obtenidos por dirección de tesis -->
                                </div>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr id="actividad_investigacion_educa">
                      <td class="td-table-container"><span class="texto-titulo">4. ACTIVIDADES DE INVESTIGACIÓN EDUCATIVA.</span>
                        <table width="100%" class="table" id="tabla_actividad">
                            <tr style="text-align:center">
                              <td rowspan="2">Tipo</td>
                              <td rowspan="2">Instrumentos de evaluación</td>
                              <td rowspan="2">Presentaciones en foros</td>
                              <td colspan="2" width="40%">Artículos</td>
                              <td rowspan="2">Capítulos de libros</td>
                              <td rowspan="2">Libros completos</td>
                            </tr>
                            <tr style="text-align:center">
                              <td>Hasta un semestre</td>
                              <td>Hasta un año</td>
                            </tr>
                            <tr>
                              <td>Número</td>
                              <td class="td-texto-centrado">
                                  <span id="spanInstrumentosEvaluacion">2</span> <!-- en esta parte se coloca la cantidad de instrumentos de evaluacion creados por el docente  -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanPresentacionesForos">1</span> <!-- en esta parte se coloca la cantidad de presentaciones en foros en las que participó el docente  -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanRevistasReconocidas">1</span> <!-- en esta parte se coloca la cantidad de publicaciones en revistas reconocidas en las que publicó  -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanOtrasRevistas">2</span> <!-- en esta parte se coloca la cantidad de publicaciones en revistas "no reconocidas" en las que publicó -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanCapitulosLibros">0</span> <!-- en esta parte se coloca la cantidad de capitulos de libros que ecribió  -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanLibrosCompletos">0</span> <!-- en esta parte se coloca la cantidad de libros conpletos que escribió el docente -->
                              </td>
                            </tr>
                        </table>
                        <div style="text-align:right; float: right; display: table; width: 15%" id="subtotal">
                            <div style="display: table-row">
                                <div style="display: table-cell; width: 40%">SUBTOTAL:</div>
                                <div style="display: table-cell; width: 55%; border-bottom: 1px solid  #c0c0c0" class="td-texto-centrado"> 
                                    <pan id="spanActividadesEducacionPuntos">20</pan> <!-- En esta parte se colocan los puntos de las actividades de investigación educativa -->
                                </div>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr id="elab_material_educa">
                      <td class="td-table-container"><span class="texto-titulo"> 5. ELABORACIÓN DE MATERIAL EDUCATIVO.</span>
                        <table width="100%" class="table" id="tabla_actividad">                        
                            <tr>
                              <td>Tipo</td>
                              <td>Antologías o manuales educativos</td>
                              <td>Digitales</td>
                              <td>Puntos</td>
                            </tr>
                            <tr>
                              <td>Número</td>
                              <td class="td-texto-centrado">
                                  <span id="spanAntologiasManuales">2</span> <!-- En esta parte se colocan las antologías o manuales educativos creados por el docente -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanDigitales">6</span> <!-- En esta parte se coloca la cantidad de materiales digitales de diversis tipos creados por el docente -->
                              </td>
                              <td class="td-texto-centrado">
                                  <span id="spanMaterialEducativoPuntos">11</span> <!-- En esta parte se colocan los puntos obtenidos por la creación de materiales educativos -->
                              </td>
                            </tr>
                        </table>
                        <div style="text-align:right; float: right; display: table; width: 15%" id="subtotal">
                            <div style="display: table-row">
                                <div style="display: table-cell; width: 40%">SUBTOTAL:</div>
                                <div style="display: table-cell; width: 55%; border-bottom: 1px solid  #c0c0c0" class="td-texto-centrado">
                                    <span id="spanMaterialEducativoPuntosSubtotal">11</span> <!-- Este campo es como el anterior o revisar el dato -->
                                </div>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr id="comisiones">
                    <td class="td-table-container">
                        <div><span class="texto-titulo">6. COMISIONES.</span></div>
                            <div style="text-align:left; float: left; display: table; width: 30%" id="subtotal">
                                <div style="display: table-row">
                                    <div style="display: table-cell; width: 60%">Número (por periodos anuales):</div>
                                    <div style="display: table-cell; width: 40%; border-bottom: 1px solid  #c0c0c0" class="td-texto-centrado">
                                        <span id="spanComisionesAnuales">2</span> <!-- En esta parte se coloca en número de comissiones por año -->
                                    </div>
                                </div>
                            </div>
                            <div style="text-align:right; float: right; display: table; width: 15%" id="subtotal">
                                <div style="display: table-row">
                                    <div style="display: table-cell; width: 40%">SUBTOTAL:</div>
                                    <div style="display: table-cell; width: 55%; border-bottom: 1px solid  #c0c0c0" class="td-texto-centrado">
                                        <span id="spanComisionesAnualesSubTotal">2</span> <!-- En esta parte se coloca el total de puntos por las comisiones anuales -->
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!--<div style="text-align:right" id="subtotal"> <strong>PUNTOS TOTALES:</strong> <small>__________________</small></div>-->
                            <!--<div style="text-align:right; float: right; display: table; width: 15%" id="subtotal">-->
                                              
                    </td>
                    <tr>
                        <td class="td-table-container">
                            <br>
                            <div style="display: table; width: 33%; float: right;">
                                <div style="display: table-row; ">
                                    <div style="display: table-cell; width: 44%; text-align: right; font-weight: 900;">PUNTOS TOTALES:</div>
                                    <div style="display: table-cell; width: 55%; border-bottom: 1px solid  #c0c0c0" class="td-texto-centrado">
                                        <span id="spanPuntosTotalesDictamen" class="texto-negrita">69</span> <!-- En esta parte se colocan los puntos totales obtenidos en las secciones anteriores -->
                                    </div>
                                </div>
                            </div> 
                        </td>
                    
                        
                  </tr>
                  <tr id="dictamen">
                  
                        <td  style="padding-bottom: 9px;">
                            <h4 style="margin-left: 12px;"><span style="font-weight: 900;">DICTAMEN: &nbsp;&nbsp;</span>
                                <!-- Aquí va el dictamen  -->
                                  <select id="slcCatDictamen" form="formDictamen" name="slcCatDictamen">
                                      <?php
                                          foreach ($catalogo as $dictamen){
                                              echo '<option value="'.$dictamen['CATEGORIA_CVE'].'" >'.$dictamen['CAT_NOMBRE'].'</option>';
                                          }
                                      ?>
                                  </select>
                            </h4>
                          <br>
                           <div style="text-align:left; float: left; display: table; width: 90%; margin-left: 12px;" id="subtotal">
                              <div style="display: table-row">
                                  <div style="display: table-cell; width: 10%; ">Observaciones: </div>
                                  <!--<div style="display: table-cell; width: 90%; border-bottom: 1px solid  #c0c0c0"></div>-->
                                  <input id="txtObservaciones" form="formDictamen" type="text" name="txtObservaciones" style="width:100%" maxlength="130">
                              </div>
                          </div>
                        </td>
                    
                  </tr>
                  <tr id="titulo_academico">
                    <td class="border-top" style="text-align:center">
                        <strong>GRUPO ACADÉMICO PARA LA EVALUACIÓN CURRICULAR DOCENTE</strong>
                    </td>
                  </tr>
                  <tr id="firma_vocales_1">
                    <td>
                      <table width="100%" id="firma_vocal_1">
                        <tr>
                          <td class="border-bottom" style="width: 48%">
                              <br>
                              <img src="<?= base_url() ?>assets/img/firmas/firma5.png" class="img-firma-dr" >
                          </td>
                          <td style="width: 4%">
                              <br>
                              &nbsp;
                          </td>
                          <td class="border-bottom" style="width: 48%">
                              <br>
                              <img src="<?= base_url() ?>assets/img/firmas/firma4.png" class="img-firma-dr" >
                          </td>
                        </tr>
                        <tr >
                          <td style="width: 48%" class="td-texto-centrado texto-chico">
                              Vocal Dr.
                              <br>
                              <span id="spanNombreVocal3">Marco Antonio Chavez Arriaga </span> <!-- En esta parte se coloca el nobre del vocal3 -->
                          </td>
                          <td style="width: 4%">
                          </td>
                          <td style="width: 48%" class="td-texto-centrado texto-chico">
                              Vocal Dr.
                              <br>
                              <span id="spanNombreVocal2">Araceli Martinez Najera </span> <!-- En esta parte se coloca el nobre del vocal2 -->
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr id="firma_vocales_2">
                    <td> 
                      <table width="100%" id="firma_vocal_2">
                        <tr>
                          <td class="border-bottom" style="width: 48%">
                              <br>
                              <img src="<?= base_url() ?>assets/img/firmas/firma3.png" class="img-firma-dr" >
                          </td>
                          <td style="width:20px" style="width: 4%">
                              <br>
                              &nbsp;
                          </td>
                          <td class="border-bottom" style="width: 48%">
                              <br>
                              <img src="<?= base_url() ?>assets/img/firmas/firma2.png" class="img-firma-dr" >
                          </td>
                        </tr>
                        <tr class="td-texto-centrado texto-chico">
                          <td style="width: 48%">
                              Vocal Dr.
                              <br>
                              <span id="spaNombreVocal1">Eduardo Javier Rios Cortéz</span>
                          </td>
                          <td style="width: 4%"></td>
                          <td style="width: 48%">
                              Secretario(a) Dr.
                              <br>
                              <span id="spaNombreSecretario">Fernanada Gonzáles Gonzáles</span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr id="firma_presidente" style="text-align:center">
                    <td>
                        
                      <table width="100%" style="text-align:center" id="firma_presi">
                        <tr>
                            <td class="border-bottom">
                                
                                <img src="<?= base_url() ?>assets/img/firmas/firma1.png" class="img-firma-dr" >
                            </td>
                        </tr>
                        <tr>
                          <td class="td-texto-centrado texto-chico">
                              Presidente(a) Dr.
                              <br>
                              <span id="spanNombrePresidente"> Kattya Villanueva L. </span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
                  <br>
              </td>
            </tr>
        </table>
        <br>
        <div class="row">
            <div class="col col-md-2">
                <form id="formDictamen" action="<?= base_url() ?>index.php/dictamen/dictamina" method="post" >
                    <input type="hidden" name="hddSolicCve" id="hddSolicCve" value="<?= $solicEvalCve ?>">
                    <input type="hidden" name="hddempleadoCve" id="hddempleadoCve" value="<?= $empleadoCve ?>">
                    <input type="submit" name="action" id="btnDictaminar" class="btn btn-success" disabled="disabled" value="Dictaminar">
                </form>    
            </div>
            <div class="col col-md-2">
                <button data-toggle="modal" data-target="#modalCorreccion"  id="btnCorreccion" class="btn btn-warning" >Enviar a Corrección</button>
            </div>
        </div>
        <div class="row" style="margin-top:8px;">
            <div class="col-md-2">
                <a class="btn btn-default" href="<?= base_url() ?>index.php/dictamen/" role="button">
                    <i class="glyphicon glyphicon-share-alt" style="-moz-transform: scale(-1, 1);
                                                                    -webkit-transform: scale(-1, 1);
                                                                    -o-transform: scale(-1, 1);
                                                                    -ms-transform: scale(-1, 1);
                                                                    transform: scale(-1, 1);"></i>
                    Regresar
                </a>
            </div>
        </div>
<!-- Modal para correción de datos de dictamen -->
<div class="modal fade" id="modalCorreccion" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-alert"></i>  Correción  </h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="txtMotivosCorrecion">Motivos para la correción</label>
            <input type="text" form="formCorrecion" class="form-control" id="txtMotivosCorrecion" name="txtMotivosCorrecion" maxlength="120">
        </div>  
      </div>
      <div class="modal-footer">
          <div class="row">
              <div class="col col-md-6">
                <form id="formCorrecion" method="post" action="<?= base_url() ?>index.php/dictamen/correcion">
                    <input type="hidden" name="hddSolicCveCorrecion" id="hddSolicCveCorrecion" value="<?= $solicEvalCve ?>">
                    <input type="hidden" name="hddempleadoCveCorrecion" id="hddempleadoCveCorrecion" value="<?= $empleadoCve ?>">
                    <input type="submit" class="btn btn-primary" value="Enviar">
                </form>  
              </div>
              <div class="col col-md-6">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
          </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
