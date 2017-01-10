<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$boque = $this->seguridad->encrypt_base64($bloque);
//$solicitud = $this->seguridad->encrypt_base64($solicitud);

if (!empty($estado_validacion_bloque)) {
    ?>
    <div id="div_pie" class="text-right">
        <button id="btn_comentarios" type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_censo" 
                onclick="ver_comentarios_bloque(this)" 
                data-bloque="<?php echo $bloque; ?>">
                    <?php echo $string_values['text_btn_comentarios']; ?>
        </button>
        <button id="btn_validar_bloque" type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_censo" 
                onclick="ver_cambio_estado_bloque(this)" 
                data-bloque="<?php echo $bloque; ?>">
                    <?php echo $string_values['text_btn_validar']; ?>
        </button>
    </div>
    <?php
}
?>