<div class="row">
    <div class="col-xs-12 col-md-3" >
        <a href="javascript:window.history.back();" style="float:right;" ><i class="fa fa-mail-reply"></i>  Regresar</a>
    </div>
        <div class="col-xl-12 col-md-6">
        <?php   echo form_open('account/begin_password_reset', array('id'=>'begin_password_reset')); 
            $is_error_mail = $is_error_mat = FALSE; // TRUE
            $has_error_mat = $has_error_mail = ""; //"has-error"
        ?>
        <div class="panel imss-border-gray">
                <div class="breadcrumbs6 panel-heading imss-border-bottom" style="padding-left:20px;">
                        <h2 id="titulo_registro">
                            <small>
                                <span class="glyphicon glyphicon-info-sign">
                                </span>
                            </small>
                            <span class="">Recuperar tu contraseña en SIPIMSS</span>
                        </h2>
                    </div>
                <div class="panel-body">
                    <!--<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">-->
                        <?php
                            if (isset($error_model) && !empty($error_model)) {                        
                                echo html_message($error_model, 'danger');
                            }
                        ?>            

                        <div class="form-group  <?php echo $has_error_mail; ?>">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <p class="help-block">Ingresa tu correo electr&oacute;nico registrado en SIPIMSS</p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <?php
                                        echo $this->form_complete->create_element(
                                                    array(
                                                            'id'=>'correo_electronico', 
                                                            'type'=>'text', 
                                                            'attributes'=>array(
                                                                    'class'=>'form-control',
                                                                    'maxlength'=>'200', 
                                                                    'autocomplete'=>'off', 
                                                                    'placeholder'=>'Correo elect&oacute;nico', 
                                                                    'data-toggle'=>'tooltip', 
                                                                    'data-placement'=>'top', 
                                                                    'title'=>'Correo electr&oacute;nico')
                                                            )
                                                    );
                                ?>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-danger">
                                <?php   echo form_error_format('correo_electronico'); ?>
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
                                <p class="help-block">Escribe el c&oacute;digo de seguridad que aparece en la im&aacute;gen</p>

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
                                    placeholder="Escribe el texto de la im&aacute;gen"
                                    autocomplete="off"
                                    data-toggle='tooltip'
                                    data-placement='top'
                                    value="<?php if(!empty($userCaptcha))echo $userCaptcha; ?>" 
                                    />
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <?php   echo form_error_format('userCaptcha'); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <button class="btn btn-success btn-block">Enviar</button>
                            </div>
                        </div>                
                    <!--</div>-->
                </div>
            </div>
        <?php   echo form_close(); ?>
    </div>

</div>
