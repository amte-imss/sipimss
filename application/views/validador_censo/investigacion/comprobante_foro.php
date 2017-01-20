<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script type="text/javascript">
//    $('.btn_subir_comprobante').click(function () {
    $('.btn_subir_comprobante').click(function () {
        cargar_archivo($(this).attr('data-key'), "#form_investigacion_docente");
    });
</script>

<?php
//Miuestrá el cargador de archivos, la bibliografía del libro o revista
if (isset($vista_comprobante)) {
    echo $vista_comprobante;
}
?>  