<link href="<?= base_url(); ?>assets/plugins/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/plugins/datatables/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/plugins/datatables/styleModified.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/css/dictamen/dictamen.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url(); ?>assets/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/dictamen/dictamen.js"></script>
<div class="container">
    <form id="frmBuscarDocentesDictamen" contelass="form-inline" >
        <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-6">
                    <div class="panel-body input-group ">
                        <span class="input-group-addon">Nombre del docente</span>
                             <input type="text" class="form-control" id="nombreDocente" name="nombreDocente"  >
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6">
                    <div class="panel-body input-group ">
                        <span class="input-group-addon">Matrícula del docente</span>
                             <input type="text" class="form-control" id="matriculaDocente" name="matriculaDocente" >
                    </div>
                </div>
        </div>  
        <div class="row">
            <button type="button" id="btnBuscarDocentes" class="btn btn-default" style="float:right">Buscar</button>
            <button type="button" id="btnLimpiar" class="btn btn-default" style="float:right">Limpiar</button>
        </div>
    </form>
    <div class="row"></div>
    <div id="container_tbl_dictamen" class="row">
    </div>
    <!--/row-->
</div>
<!-- /container-->
<div class="modal fade" id="docenteDatosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Datos generales docente</h4>
      </div>
      <div class="modal-body">
 
                <div class="row"> 
                    <div class="form-group col-xs-4 col-md-4">
                        <label for="perfil_apellido_paterno" class="control-label">
                             
                            Apellido paterno            </label>
                        <div class="">                            
                            <input type="text" readonly name="emp_ape_paterno" value="MORA" id="emp_ape_paterno" class="form-control form-control-personal nameFields " maxlength="30">
                        </div>
                                </div>
                    <div class="form-group col-xs-4 col-md-4">
                        <label for="perfil_apellido_materno" class="control-label">
                            Apellido materno            </label>
                        <div class="">
                            <input type="text" readonly name="emp_ape_materno" value="" id="emp_ape_materno" class="form-control form-control-personal nameFields " maxlength="30">
                        </div>
                                </div>
                    <div class="form-group col-xs-4 col-md-4">
                        <label for="perfil_nombre" class="control-label">
                             
                            Nombre            </label>
                        <div class="">
                            <input type="text" readonly name="emp_nombre" value="" id="emp_nombre" class="form-control form-control-personal nameFields "  maxlength="30">
                        </div>
                                </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-5 col-md-5">
                        <label for="perfil_edad" class="control-label">
                            Edad            </label>
                        <div class="">
                            <input type="text" readonly value="" id="emp_edad" class="form-control form-control-personal " readonly="readonly">
                        </div>

                    </div> 
                    <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                        <label for="perfil_genero" class="control-label">
                            Género            </label>
                        <div class="">
                            <input type="text" readonly value="" id="emp_genero" class="form-control form-control-personal "   maxlength="30" readonly="readonly">
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-5 col-md-5">
                        <label for="perfil_estado_civil" class="control-label">                             
                            Estado civil            
                        </label>
                        <div class="">
                            <input type="text" readonly name="CESTADO_CIVIL_CVE" value="" id="CESTADO_CIVIL_CVE" class="form-control form-control-personal "  maxlength="30">
                        </div>

                    </div>
                    <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                        <label for="perfil_correo_electronico" class="control-label">     
                            Correo electrónico            
                        </label>
                        <div class="">
                            <input type="text" readonly name="EMP_EMAIL" value="" id="EMP_EMAIL" class="form-control form-control-personal "  maxlength="30">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-5 col-md-5">
                        <label for="perfil_telefono_particular" class="control-label">                             
                            Teléfono particular
                        </label>
                        <div class="">
                             <input type="text" readonly name="EMP_TEL_PARTICULAR" value="" id="EMP_TEL_PARTICULAR" class="form-control form-control-personal " >
                        </div>
                                </div>
                    <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                        <label for="perfil_telefono_laboral" class="control-label">
                             
                            Teléfono laboral            </label>
                        <div class="">
                             <input type="text" readonly name="EMP_TEL_LABORAL" value="" id="EMP_TEL_LABORAL" class="form-control form-control-personal " maxlength="30">
                        </div>

                    </div>    
                </div>
                <div class="row">
                    <div class="form-group col-xs-5 col-md-5">
                        <label for="perfil_empleos_actuales" class="control-label">
                            Número de empleos actuales fuera del IMSS            </label>
                        <div class="">
                             <input type="text" readonly name="EMP_NUM_FUE_IMSS" value="" id="EMP_NUM_FUE_IMSS" class="form-control form-control-personal " >
                        </div>

                    </div>
                </div>
            <div class="row">
                <h4 class="modal-title" id="myModalLabel">Información IMSS</h4>
                <hr>
            </div>
            <div class="row">
                <div class="form-group col-xs-5 col-md-5">
                    <label for="perfil_matricula" class="control-label">
                        Matrícula            </label>
                    <div class="">                
                         <input type="text" readonly name="perfil_matricula" value="" id="perfil_matricula" class="form-control form-control-personal "   >
                    </div>

                </div> 
                <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                    <label for="perfil_delegacion" class="control-label">

                        Delegación            </label>
                    <div class="">
                         <input type="text" readonly name="perfil_delegacion" value="" id="perfil_delegacion" class="form-control form-control-personal "   maxlength="20" disabled="1">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-5 col-md-5">
                    <label for="perfil_nombre_categoria" class="control-label">

                        Nombre de la categoría/Puesto            </label>
                    <div class="">
                         <input type="text" readonly name="perfil_nombre_categoria" value="" id="perfil_nombre_categoria" class="form-control form-control-personal "   maxlength="25" disabled="1">
                    </div>

                </div> 
                <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                    <label for="perfil_clave_categoria" class="control-label">

                        Clave de la categoría/Puesto            </label>
                    <div class="">
                         <input type="text" readonly name="perfil_clave_categoria" value="" id="perfil_clave_categoria" class="form-control form-control-personal "   maxlength="11" disabled="1">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-5 col-md-5">
                    <label for="perfil_nombre_area_adscripcion" class="control-label">

                        Nombre del área de adscripción            </label>
                    <div class="">
                         <input type="text" readonly name="perfil_nombre_area_adscripcion" value="" id="perfil_nombre_area_adscripcion" class="form-control form-control-personal "   maxlength="20" disabled="1">
                    </div>

                </div> 
                <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                    <label for="perfil_nombre_unidad_adscripcion" class="control-label">

                        Nombre de la unidad de adscripción            </label>
                    <div class="">
                         <input type="text" readonly name="perfil_nombre_unidad_adscripcion" value="" id="perfil_nombre_unidad_adscripcion" class="form-control form-control-personal "   maxlength="20" disabled="1">
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-5 col-md-5">
                    <label for="perfil_nombre_clave_adscripcion" class="control-label">
                        Clave de adscripción            </label>
                    <div class="">
                         <input type="text" readonly name="perfil_nombre_clave_adscripcion" value="" id="perfil_nombre_clave_adscripcion" class="form-control form-control-personal "   maxlength="20" disabled="1">
                    </div>

                </div> 
                <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                    <label for="perfil_clave_antiguedad" class="control-label">                
                        Antigüedad            </label>
                    <div class="row">
                        <div class="form-group col-xs-4 col-md-4">
                            <div class="">
                                 <input type="text" readonly name="perfil_antiguedad_anios" value="" id="perfil_antiguedad_anios" class="form-control form-control-personal "   title="Años" maxlength="20" disabled="1">
                            </div>
                            <small>Años</small>
                        </div>
                        <div class="form-group col-xs-4  col-md-4">
                            <div class="">
                                 <input type="text" readonly name="perfil_antiguedad_quincena" value="" id="perfil_antiguedad_quincena" class="form-control form-control-personal "   title="Quincenas" maxlength="20" disabled="1">
                            </div>
                            <small>Quincenas</small>
                        </div>
                        <div class="form-group col-xs-4 col-md-4">
                            <div class="">
                                 <input type="text" readonly name="perfil_antiguedad_dias" value="" id="perfil_antiguedad_dias" class="form-control form-control-personal "   title="Días" maxlength="20" disabled="1">
                            </div>
                            <small>Días</small>
                        </div>
                    </div>

                </div>
            </div>
          
            <div class="row">
                <div class="form-group col-xs-5 col-md-5">
                    <label for="perfil_tipo_contratacion" class="control-label">                
                        Tipo de contratación            </label>
                    <div class="">
                     <input type="text" readonly name="perfil_tipo_contratacion" value="" id="perfil_tipo_contratacion" class="form-control form-control-personal "   maxlength="20" disabled="1">
                    </div>

                </div> 
                <div class="form-group col-xs-5 col-md-5 col-md-offset-1 col-md-offset-1">
                    <label for="perfil_estatus_empleado" class="control-label">                
                        Estatus del empleado            </label>
                    <div class="">
                     <input type="text" readonly name="perfil_estatus_empleado" value="" id="perfil_estatus_empleado" class="form-control form-control-personal "   maxlength="20" disabled="1">
                    </div>
                </div>
            </div>
      </div>
        <!--/modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--/modal-->

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