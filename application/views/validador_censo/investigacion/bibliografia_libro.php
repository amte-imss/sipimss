<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="col-md-12">
    <label for='lbl_bb_libro' class="control-label">
        <?php echo $string_values['lbl_bb_libro']; ?>
    </label>
    <div class="input-group">
        <label class="registro"><?php echo $bibliografia_libro; ?></label>
        <!-- <span class="input-group-addon">
            <span class="glyphicon glyphicon-education"> </span>
        </span> -->
        <?php
        /*echo $this->form_complete->create_element(array('id' => 'bibliografia_libro',
            'type' => 'textarea',
            'value' => (isset($bibliografia_libro)) ? $bibliografia_libro : '',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => $string_values['txt_bb_libro'],
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => $string_values['txt_bb_libro'])));*/
        ?>
    </div>
    <?php //echo form_error_format('bibliografia_libro'); ?>
</div>