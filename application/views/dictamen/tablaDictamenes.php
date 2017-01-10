<?php
    if(count($tableResultset) > 0){
?>
<table id="dictamenTbl" class="display compact " cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Nombre</th>
            <th>Delegación</th>
            <th>Adscripción</th>
            <th>Evaluado</th>
            <th>Puntos</th>
            <th>Dictamen</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $string = "";
            $dictamen;
            foreach ($tableResultset as $tupla){
                $dictamen =  isset($tupla['CATEGORIA_CVE']) && isset($tupla['CAT_NOMBRE'])  ;
                $string .= '<tr>';
                $string .= '<td>'.$tupla['emp_matricula'].'</td>';
                $string .= '<td>'.$tupla['EMP_NOMBRE']. ' '. $tupla['EMP_APE_PATERNO'] .'</td>';
                $string .= '<td>'.$tupla['DEL_NOMBRE'].'</td>';
                $string .= '<td>'.$tupla['ADS_NOM_AREA'].'</td>';
                $string .= '<td>'
                        . '<div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-unchecked"></i> vocal1 </div><div class="div-evaluador-calif" >45</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-check "></i> vocal2 </div> <div class="div-evaluador-calif" >64</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-unchecked "></i> vocal3 </div> <div class="div-evaluador-calif" >55</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-check "></i> secretario</div> <div class="div-evaluador-calif" >34</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-check "></i> presidente</div> <div class="div-evaluador-calif" >77</div>
                <br>' //  <- datos doomy
                        . '</td>';
//                $string .= '<td align="center">'.$tupla['TOTAL_PUNTOS'].' <input type="hidden" value="'.$dictamen.'" name="test" > </td>';
                $string .= '<td align="center"> 184  <input type="hidden" value="'.$dictamen.'" name="test" > </td>';
                $string .= '<td align="center">'. ( ($dictamen && $tupla['CATEGORIA_CVE'] != 1 )? '<i class="glyphicon glyphicon-check"></i>' : '<i class="glyphicon glyphicon-unchecked"></i>' ) .'</td>';
                $string .= '<td>'.( ($dictamen && $tupla['CATEGORIA_CVE'] != 1 ) ? $tupla['CAT_NOMBRE'] : ' '
                       
                            . '<select id="slcCatDictamen" form="formDictamen" name="slcCatDictamen" disabled>
                                      <option value="1">Sin Categoría</option>
                                      <option value="2">Asociado A_2</option>
                                      <option value="3">Asociado B</option>
                                      <option value="4">Asociado C</option>
                               </select>
                               <input type="hidden" name="hddSolicCve" id="hddSolicCve" value="" >
                               <input type="hidden" name="hddempleadoCve" id="hddempleadoCve" value="" >
                               <input type="submit" name="btnDictaminar" id="btnDictaminar" value="Dictaminar" class="btn btn-default btn-xs" disabled>'
                        . ''  ).' </td>';
                $string .= '<td>'
                                .'<div class="div-icons-flex">'
                                    .'<form action="'. base_url() .'index.php/dictamen/dictamenFormato" id="frmDatosDocenteTablaSolic'.$tupla['SOLICITUD_VAL_CVE'].'Emp'.$tupla['EMPLEADO_CVE'].'" method="post" >'
                                        . '<input type="hidden" name="hddempleadoCve" value="'.$tupla['EMPLEADO_CVE'].'" >'
                                        . '<input type="hidden" name="hddSolicCve" value="'.$tupla['SOLICITUD_VAL_CVE'].'" >'
                                    .'</form>'    
                                    .'<i onclick="showDocenteModalData('.$tupla['emp_matricula'].')" class="glyphicon glyphicon-info-sign datosDocente" data-toggle="tooltip" data-placement="bottom" title="Ver Docente"></i>'
                                    . ( ($dictamen && $tupla['CATEGORIA_CVE'] != 1 ) ? ' ' : '<i onclick="goToDictamen('.$tupla['EMPLEADO_CVE'].', '.$tupla['SOLICITUD_VAL_CVE'].');" class="glyphicon glyphicon-file" data-toggle="tooltip" data-placement="bottom" title="Dictamen"></i>'  ) . ' '
//                                    .' '.( ($dictamen && $tupla['CATEGORIA_CVE'] != 1 ) ? ' ' : '<i class="glyphicon glyphicon-exclamation-sign" data-toggle="tooltip" data-placement="bottom" title="Enviar a corrección"></i>' ) .' '                                  
                                .'</div>'
                            .'</td>';
                $string .= '</tr>';
            }
            echo $string;
        ?>
<!--        <tr>
            <td>999999999</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-unchecked"></i> vocal1 </div><div class="div-evaluador-calif" >45</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-check "></i> vocal2 </div> <div class="div-evaluador-calif" >664</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-unchecked "></i> vocal3 </div> <div class="div-evaluador-calif" >664</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-check "></i> secretario</div> <div class="div-evaluador-calif" >664</div>
<br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-check "></i> presidente</div> <div class="div-evaluador-calif" >664</div>
                <br>
            </td>
            <td align="center">800</td>
            <td align="center"><i class="glyphicon glyphicon-check"></i></td>
            <td></td>  
            <td> 
                <div class="div-icons-flex">
                    <i onclick="showDocenteModalData()" class="glyphicon glyphicon-info-sign datosDocente" data-toggle="tooltip" data-placement="bottom" title="Ver Docente"></i>
                    <i onclick="goToDictamen();" class="glyphicon glyphicon-file" data-toggle="tooltip" data-placement="bottom" title="Dictamen"></i>
                    <i class="glyphicon glyphicon-exclamation-sign" data-toggle="tooltip" data-placement="bottom" title="Enviar a corrección"></i>
                </div> 
            </td>
        </tr>-->
<!--        <tr>
            <td>6767676767</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-unchecked"></i> vocal1 </div><div class="div-evaluador-calif" >45</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-check "></i> vocal2 </div> <div class="div-evaluador-calif" >664</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-unchecked "></i> vocal3 </div> <div class="div-evaluador-calif" >664</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-check "></i> secretario</div> <div class="div-evaluador-calif" >664</div>
                <br>
                <div class="div-evaluador-icon-check"><i class="glyphicon glyphicon-check "></i> presidente</div> <div class="div-evaluador-calif" >664</div>
                <br>
            </td>
            <td align="center">800</td>
            <td align="center"><i class="glyphicon glyphicon-check"></i></td>
            <td> Asociado A</td>  
            <td>
                <div class="div-icons-flex">
                    <i onclick="showDocenteModalData()" class="glyphicon glyphicon-info-sign datosDocente" data-toggle="tooltip" data-placement="bottom" title="Ver Docente"></i>
                    <i onclick="goToDictamen();" class="glyphicon glyphicon-file" data-toggle="tooltip" data-placement="bottom" title="Dictamen"></i>
                </div> 
            </td>
        </tr>-->
        
    </tbody>
</table>
<?php
    }else{
        
?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        La Busqueda no ha producido resultados.
    </div>
<?php 
    }
?>
