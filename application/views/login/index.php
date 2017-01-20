<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>SIPIMSS</title>
		
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>log_reg/css/normalize.css"/>
		<link rel="stylesheet" href="<?php echo asset_url();?>log_reg/css/style.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url();?>log_reg/css/bootstrap.css"/>
        
        <!-- Javascript -->
        <script type="text/javascript">
			var img_url_loader = "<?php echo img_url_loader(); ?>";
			var site_url = "<?php echo site_url(); ?>";
            var asset_url = "<?php echo asset_url();?>";
		</script>
        <?php echo js("jquery-2.1.4.min.js");?>
        <?php echo js("bootstrap.js");?>
        <?php echo js("general.js");?>
		<script src="<?php echo asset_url();?>log_reg/js/main.js"></script>
		<script src="<?php echo asset_url();?>log_reg/js/modernizr.js"></script>
       
	</head>
	<body>
	
	<header role="banner">
		<div id="cd-logo">
            <a href="#0">
                <img src="<?php echo asset_url();?>log_reg/img/imss.png" alt="IMSS">
            </a>
        </div>
        <div id="cd-logo">
            <a href="#0">
                <img src="<?php echo asset_url();?>img/ces.png" alt="CES">
            </a>
        </div>
        <div id="cd-logo">
            <a href="#0">
                <img src="<?php echo asset_url();?>img/arrobas.png" alt="Logo">
            </a>
        </div>

		<nav class="main-nav">
			<ul>
				<!-- inser more links here -->
				<li><a class="cd-signin" href="#0">Inicio de sesión</a></li>
				<li><a class="cd-signup" href="#0">Si desea registrarse</a></li>
			</ul>
		</nav>
	</header>
<div class="background"></div>
	<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<ul class="cd-switcher">
				<li><a href="#0">Inicio de sesión</a></li>
				<li><a href="#0">Registro</a></li>
			</ul>

			<div id="cd-login"> <!-- log in form -->
				<?php   
                echo form_open('login/index', array('id'=>'login', "class"=>"cd-form")); 
                ?>
					<p class="fieldset">
						<label class="image-replace cd-username" 
                               for="signup-username">
                            Matr&iacute;cula:
                        </label>
                        <?php
                        echo $this->form_complete->create_element(
                            array('id'=>'matricula', 
                                  'type'=>'text', 
                                  'attributes'=>array(
                                      'class'=>'full-width has-padding has-border', 
                                      'maxlength'=>'20', 
                                      'autocomplete'=>'off',        
                                      'placeholder'=>'Matr&iacute;cula', 
                                      'data-toggle'=>'tooltip', 
                                      'data-placement'=>'top', 
                                      'title'=>'Matricula'
                                  )
                            )
                        );
                        ?>
                        <span class="text-danger"> 
                            <?php echo form_error('matricula','','');?> 
                        </span>
						<!--input class="full-width has-padding has-border" id="signin-email" type="email" placeholder="Usuario"-->
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signin-password">Contraseña</label>
						<?php
                        echo $this->form_complete->create_element(
                            array('id'=>'passwd', 
                                  'type'=>'password', 
                                  'attributes'=>array(
                                      'class'=>'full-width has-padding has-border', 
                                      'autocomplete'=>'off', 
                            'placeholder'=>'Contrase&ntilde;a', 
                                      'data-toggle'=>'tooltip', 
                                      'data-placement'=>'top',
                                      'title'=>'Contrase&ntilde;a'
                                  )
                            )
                        );
                        ?>
                        <span class="text-danger"> 
                        <?php echo form_error('passwd','','');?> 
                        </span>
					</p>
                    <p class="fieldset">
                        <div id="captcha_first" class="img-captcha">
                        <!-- aqui va a ir la imagen captcha y el reload -->
                        </div>
                        <script type="text/javascript">
                        // inicia codigo javascript necesario para un captcha
                        $( document ).ready(function() {
                            data_ajax(site_url+"/captcha/get_new_captcha_ajax", "#null", "#captcha_first"); 
                            // cargamos por primera vez el captcha
                        });
                        // termina codigo javascript necesario para un captcha
                        </script>
                        <input 
                           type="text" 
                           class="full-width has-padding has-border" 
                           name="userCaptcha" 
                           id="userCaptcha" 
                           placeholder="Escriba el texto de la imágen" 
                           autocomplete="off" 
                           value="<?php if(!empty($userCaptcha))echo $userCaptcha; ?>" />
                         <span class="text-danger"> 
                             <?php echo form_error('userCaptcha','','');?>
                         </span>
                    </p>
					<p class="fieldset">
                        <button type="submit" class="full-width">Entrar</button>
			             <input type="hidden" 
                           id="token" 
                           name="token" 
                           value="<?php echo (exist_and_not_null($this->session->userdata('token')) ? $this->session->userdata('token') : ''); ?>"
                        />
						<!--input class="full-width" type="submit" value="Enviar"-->
					</p>
				 <?php
                 echo form_close(); 
                 ?>
				
				<!--p class="cd-form-bottom-message"><a href="#0">Olvidó su contraseña?</a></p-->
			</div> <!-- cd-login -->

			<div id="cd-signup"> <!-- sign up form -->
				<form class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-username">Usuario</label>
						<input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="Usuario">
						<span class="cd-error-message">Error!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-email" for="signup-email">E-mail</label>
						<input class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">Contraseña</label>
						<input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="Contraseña">
						<a href="#0" class="hide-password">Esconder</a>
						<span class="cd-error-message">Error!</span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="accept-terms">
						<label for="accept-terms">Estoy de acuerdo con los  <a href="#0">Términos</a></label>
					</p>
					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Crear cuenta">
					</p>
				</form>

				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-signup -->

			<div id="cd-reset-password"> <!-- reset password form -->
				<p class="cd-form-message">Recuperar contraseña.</p>

				<form class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-email" for="reset-email">E-mail</label>
						<input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error!</span>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Enviar">
					</p>
				</form>

				<p class="cd-form-bottom-message"><a href="#0">Regresar a Inicio de sesión</a></p>
			</div> <!-- cd-reset-password -->
			<a href="#0" class="cd-close-form">Cerrar</a>
		</div> <!-- cd-user-modal-container -->
	</div> <!-- cd-user-modal -->
    <script type="text/javascript">
        $(document).ready(function(){
            $( "#img-captcha" ).find( "img" ).addClass( "img-rounded");
        });
    </script>
	</body>
</html>