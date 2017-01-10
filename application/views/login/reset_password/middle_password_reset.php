<div id="middle_password_reset">


<?php   echo form_open('account/middle_password_reset/'.$token_activate_middle.'/', array('id'=>'middle_pass_reset')); 
    
    $is_error_mail = $is_error_mat = FALSE; // TRUE
    $has_error_mat = $has_error_mail = ""; //"has-error"

?>
    <div class="row">
        <div class="col col-xs-12 col-md-6 col-md-push-3">
            <div class="panel imss-border-gray">
                <div class="panel-body">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">            
                        <h2>Recuperar tu contraseña en SIPIMSS</h2><hr>                
                        <div class="form-group  <?php echo $has_error_mail; ?>">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <p class="help-block">C&oacute;digo de recuperaci&oacute;n de contraseña en SIPIMSS</p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <?php
                                        echo $this->form_complete->create_element(
                                                    array(
                                                            'id'=>'codigo_recuperacion', 
                                                            'type'=>'text', 
                                                            'attributes'=>array(
                                                                    'class'=>'form-control',
                                                                    'maxlength'=>'200', 
                                                                    'autocomplete'=>'off', 
                                                                    'placeholder'=>'C&oacute;digo de recuperaci&oacute;n de contraseña', 
                                                                    'data-toggle'=>'tooltip', 
                                                                    'data-placement'=>'top', 
                                                                    'title'=>'C&oacute;digo de recuperaci&oacute;n de contraseña')
                                                            )
                                                    );
                                ?>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-danger">
                                <?php   echo form_error_format('codigo_recuperacion'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group <?php echo $has_error_mat; ?>">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <p class="help-block">Ingresa tu matr&iacute;cula</p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <?php
                                    echo $this->form_complete->create_element(
                                                    array(
                                                            'id'=>'matricula', 
                                                            'type'=>'text', 
                                                            'attributes'=>array(
                                                                        'class'=>'form-control',
                                                                        'maxlength'=>'20', 
                                                                        'autocomplete'=>'off', 
                                                                        'placeholder'=>'Mat&iacute;cula', 
                                                                        'data-toggle'=>'tooltip', 
                                                                        'data-placement'=>'top', 
                                                                        'title'=>'Mat&iacute;cula')
                                                                )
                                                    );
                                ?>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-danger">
                                <?php   echo form_error_format('matricula'); ?>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <p class="help-block">Escribe el código de seguridad que aparece en la imágen</p>

                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                    <div id="captcha_first" class="img-captcha">
                                        <!-- aqui va a ir la imagen captcha y el reload -->
                                    </div>
                                    <script type="text/javascript">
                                        // inicia codigo javascript necesario para un captcha
                                        $( document ).ready(function() { //alert("nn")
                                            data_ajax(site_url+"/captcha/get_new_captcha_ajax", "#null", "#captcha_first"); // cargamos por primera vez el captcha
                                        }); // termina codigo javascript necesario para un captcha
                                    </script>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="userCaptcha" 
                                    id="userCaptcha" 
                                    placeholder="Escribe el texto de la imágen"
                                    autocomplete="off"
                                    data-toggle='tooltip'
                                    data-placement='top'
                                    value="<?php if(!empty($userCaptcha))echo $userCaptcha; ?>" 
                                    />
                                <input 
                                    type="hidden"
                                    id="t_a_m"
                                    value="<?php echo $token_activate_middle; ?>" 
                                    />
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <?php   echo form_error_format('userCaptcha'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <button id="btn_envia_cod_rec" type="button" class="btn btn-info btn-block" onclick="enviaCodigoRecContrasenia();">Enviar código de recuperación de contraseña</button>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>
        </div>
    </div>
            
<?php   echo form_close(); ?>

</div>

<script type="text/javascript">

function enviaCodigoRecContrasenia() {
    data_ajax(site_url+"/account/ajax_middle_pass/<?php echo $token_activate_middle; ?>", "#middle_pass_reset", "#middle_password_reset"); // cargamos por primera vez el captcha
}
function guardaNuevaContrasenia() {
    data_ajax(site_url+"/account/endup_password_reset/<?php echo $token_activate_middle; ?>", "#endup_password_reset", "#middle_password_reset"); // cargamos por primera vez el captcha
}
</script>