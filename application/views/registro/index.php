<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inicio de sesi&oacute;n::SIPIMSS</title>

        <!-- CSS -->
        
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo asset_url();?>/login/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo asset_url();?>/login/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo asset_url();?>/login/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo asset_url();?>/login/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo asset_url();?>/login/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo asset_url();?>/login/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo asset_url();?>/login/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo asset_url();?>/login/ico/apple-touch-icon-57-precomposed.png">
        
         <!-- Javascript -->
        <script type="text/javascript">
			var img_url_loader = "<?php echo img_url_loader(); ?>";
			var site_url = "<?php echo site_url(); ?>";
            var asset_url = "<?php echo asset_url();?>";
		</script>
        <script src="<?php echo asset_url();?>/login/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo asset_url();?>/login/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo asset_url();?>/login/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo asset_url();?>/login/js/scripts.js"></script>
        <?php echo js("general.js");?>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->
        
    </head>

    <body>
        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                                    <h3><strong>SIPIMSS</strong>&nbsp;&nbsp;&nbsp;Registrar cuenta</h3>
                                    <p class="p-subtitle">¡Juntos hacemos lo extraordinario!</p>
                        		</div>
                        		<div class="form-top-right p-subtitle">
                        			<i class="fa fa-user-plus"></i>
                        		</div>
                            </div>
                            <div class="form-bottom form-username">
                                <div class="form_group text-right">
                                    <b class="rojo">*</b>
                                    <label for="form-username">
                                        <?php echo $string_values['registro']['lbl_campos_obligatorios']; ?>
                                    </label>
                                </div>                            
			                    <?php echo form_open('', array('id'=>'form_registro', 'class'=>'form-horizontal'));?>
                                    <div class="form-group">
                                        <b class="rojo">*</b> <label class="" for="form-username">Matr&iacute;cula</label>
                                        <?php
                                        echo $this->form_complete->create_element(
                                            array('id'=>'reg_matricula', 
                                                  'type'=>'text', 
                                                  'attributes'=>array(
                                                      'class'=>'form-username form-control', 
                                                      'maxlength'=>'20', 
                                                      'autocomplete'=>'off',        
                                                      'placeholder'=>$string_values['registro']['plh_matricula'], 
                                                      'data-toggle'=>'tooltip', 
                                                      'data-placement'=>'top', 
                                                      'title'=>'Matrícula'
                                                  )
                                            )
                                        );
                                        ?>
                                        <span class="text-danger"> 
                                            <?php echo form_error('reg_matricula','','');?> 
                                        </span>
			                        </div>
                                    
                                    <div class="form-group">
			                        	<b class="rojo">*</b>
                                        <label class="" for="form-delegacion">Delegaci&oacute;n:</label>
			                        	<?php
                                        echo $this->form_complete->create_element(
                                            array('id'=>'reg_delegacion', 
                                                  'type'=>'dropdown',
                                                  'options'=>$delegaciones,
                                                  'first'=>array(''=>'SELECCIONES LA DELEGACI&Oacute;N'),
                                                  'attributes'=>array(
                                                      'class'=>'form-control', 
                                                      'autocomplete'=>'off', 
                                                      'placeholder'=>'Delegaci&oacute;n', 
                                                      'data-toggle'=>'tooltip', 
                                                      'data-placement'=>'top',
                                                      'title'=>'Delegaci&oacute;n'
                                                  )
                                            )
                                        );
                                        ?>
                                        <span class="text-danger"> 
                                            <?php echo form_error('reg_delegacion','','');?> 
                                        </span>
			                        </div>
                                    
                                
                                    <div class="form-group">
                                        <div id="captcha_first" class="img-captcha">
                                            <!-- aqui va a ir la imagen captcha y el reload -->
                                        </div>
                                        <script type="text/javascript">
                                            // inicia codigo javascript necesario para un captcha
                                            $( document ).ready(function() {
                                                //alert("adfsad")
                                                data_ajax(site_url+"/captcha/get_new_captcha_ajax", "#null", "#captcha_first"); // cargamos por primera vez el captcha
                                            });
                                            // termina codigo javascript necesario para un captcha
                                        </script>
                                        <input 
                                               type="text" 
                                               class="form-control" 
                                               name="userCaptcha" 
                                               id="userCaptcha" 
                                               placeholder="Escribe el texto de la imágen" 
                                               autocomplete="off"
                                               data-toggle='tooltip'
                                               data-placement='top'
                                               value="<?php if(!empty($userCaptcha))echo $userCaptcha; ?>" />
                                         <span class="text-danger"> 
                                             <?php echo form_error('userCaptcha','','');?>
                                         </span>
                                    </div>
			                        <button type="submit" class="btn">Entrar</button>
			                        <input type="hidden" 
                                           id="token" 
                                           name="token" 
                                           value="<?php echo (exist_and_not_null($this->session->userdata('token')) ? $this->session->userdata('token') : ''); ?>"
                                    />
                                <?php
                                echo form_close(); 
                                ?>
                                <script type="text/javascript">
                                    $( "#img-captcha" ).find( "img" ).addClass( "img-rounded");
                                </script>
                                <div class="form-group text-right">
                                <?php 
                                    echo anchor('login', 
                                                'Iniciar sesión>>',
                                                array('title'=>'Iniciar sesión')
                                    ); 
                                ?>
                                </div>
		                    </div>
                        </div>
                    </div>
                    <div class="row">
                        
                    </div>
                </div>
            </div>
            
        </div>
    </body>

</html>