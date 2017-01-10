<?php
$usuario_logueado = $this->session->userdata('usuario_logeado');
$tipo_admin = $this->session->userdata('tipo_admin'); //Tipo de usuario almacenado en sesión
$tipo_admin_config = $this->config->item('rol_admin'); //Identificador de administrador
//pr($tipo_admin);

if (exist_and_not_null($usuario_logueado)) { ///Validar si usuario inicio sesión
    //if ($tipo_admin == $tipo_admin_config['TITULAR']['id']) { ///Administrador
    ?>
        <nav class="navbar navbar-default">   
            <div class="container-fluid">   
                <div class="navbar-header">
                    <button type="button" 
                        class="navbar-toggle collapsed" 
                        data-toggle="collapse" 
                        data-target="#bs-example-navbar-collapse-1" 
                        aria-expanded="false"
                    >
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span>
                    </button>
                    <?php if($this->uri->segment(1)!=='rol' AND !is_null($this->session->userdata("rol_seleccionado"))){
                        $rol_opciones = $this->session->userdata("rol_seleccionado");
//                        pr($rol_opciones);
                        foreach($rol_opciones as $key => $value){
                            if(empty(!$value['is_controlador'])AND intval($value['is_controlador']) ===1){
//                            pr($value['ruta']);
                    ?>
                             <a class="navbar-brand" href="<?php echo site_url($value['ruta']); ?>">
                                <span class="glyphicon glyphicon-eye-open"></span>
                    <?php  echo $value['nombre_modulo'];?>
                            </a>
                    <?php
                            }
                        }
                    }//fin if 
                    ?>
                   
                    
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <div class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                        </div>
                    </div> 
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="<?php echo site_url('/'); ?>">
                                <span class="glyphicon glyphicon-home"></span>Inicio
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('login/cerrar_session'); ?>"  >
                                <span class="glyphicon glyphicon-log-out"></span> Cerrar sesión
                            </a>
                        </li>
                    </ul>     
                </div>  
            </div>
        </nav>
        <div class="text-right">
            <?php echo "Bienvenido: ";?>  
            <a  href="<?php echo site_url()?>">
                <span class="glyphicon glyphicon-user"></span>
                <?php echo $this->session->userdata("nombre") . " "  
                        . $this->session->userdata("apaterno") . " "
                        . $this->session->userdata("amaterno") ?>
            </a> 
            <br>
        </div>  
<?php
} else { ///Usuario sin sesión
?>  <nav class="navbar navbar-default">   
        <div class="container-fluid">   
            <div class="navbar-header">
                <button type="button" 
                        class="navbar-toggle collapsed" 
                        data-toggle="collapse" 
                        data-target="#bs-example-navbar-collapse-1" 
                        aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="' . site_url() . '">
                    <span class="glyphicon glyphicon-user"></span>ghkj<?php echo $this->session->userdata("nombre") . " " .$this->session->userdata("apaterno") . " " .$this->session->userdata("amaterno") ?>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <div class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                    </div>
                </div> 
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo site_url('dashboard'); ?>"  >
                            <span class="glyphicon glyphicon-home"></span> Inicio
                        </a>
                    </li> 
                </ul>     
            </div>  
        </div>  
    </nav>
<?php
}



