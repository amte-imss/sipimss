<?php if(isset($catalogos)){
    extract($catalogos, EXTR_OVERWRITE);
}?>
<label for='drop_lbl_curso' class="control-label">
    <b class="rojo">*</b>
    <?php echo $string_values['drop_lbl_curso']; ?>
</label>
<div class="input-group">
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-book"> </span>
    </span>
    <?php
    echo $this->form_complete->create_element(array('id' => 'ccurso', 'type' => 'dropdown',
        'options' => $ccurso,
        'first' => array('' => $string_values['drop_curso']),
        'value' => isset($ccurso_cve) ? $ccurso_cve : '',
        'attributes' => array('class' => 'form-control',
            'placeholder' => '', 'data-toggle' => 'tooltip', 'data-placement' => 'top',
            'data-toggle' => 'tooltip', 'data-placement' => 'top',
            'title' => $string_values['drop_lbl_curso'])));
    ?>
</div>
<?php echo form_error_format('ccurso'); ?>
