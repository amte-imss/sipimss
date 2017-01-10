<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <label for="lbl_no_existe_usuario" class="alert alert-info">
        <?php if (isset($mensaje)) {
            echo $mensaje;
        } ?>
    </label>


<button id="btn_seleccionar_validador_0" type="button" class="btn btn-link btn-sm" 
        data-delcve="09" 
        data-idrow="0" 
        data-idvalidador="OTE" 
        data-depcve="09CF010000" 
        data-tipoevento="cargarseleccion" 
        data-toggle="modal" 
        data-target="#modal_censo" 
        onchange="funcion_carga_elemento(this)">
    Seleccionar validador
</button>

<button type="button" class="btn btn-link btn-sm" id="btn_seleccionar_validador_0" 
        data-toggle="modal" 
        data-target="#modal_censo" 
        data-idrow="0" 
        data-idvalidador="OTE" 
        data-delcve="09"
        data-depcve="09CF010000" 
        data-tipoevento="cargarseleccion" 
        onclick="funcion_carga_elemento(this)">
    Seleccionar validador
</button>

<button id="btn_buscar_validador_siep" class="btn btn-default browse" type="button" aria-expanded="false" title="Buscar unidad" 
        data-toggle="tooltip" 
        data-tipoevento="buscar" 
        data-idvalidador="OTE" 
        data-delcve="09" 
        data-depcve="09CF010000" 
        data-idrow="0"
        onclick="funcion_buscar_validador(this)">