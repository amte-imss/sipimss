<?php
    $tipo_color = array("text-red", "text-yellow", "text-orange","text-blue", "text-maroon", 
        "text-gray", "text-fuchsia", "text-aqua", "text-green");
    
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
      <?php echo (!is_null($title)) ? "{$title}&nbsp;|" : "" ?> SIPIMSS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo asset_url();?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo asset_url();?>sipimss/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo asset_url();?>sipimss/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo asset_url();?>sipimss/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo asset_url();?>sipimss/css/skins/_all-skins.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="<?php echo asset_url();?>plugins/pace/pace.css">
  <!--estilos IMSS sobre la platilla-->
  <link href="<?php echo asset_url();?>css/styles-imss.css" rel="stylesheet" type="text/css"/>
  
  <!-- APPRISE -->
  <?php echo css("apprise.css"); ?>

  <!-- jQuery 2.2.3 -->
  <script src="<?php echo asset_url();?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo asset_url();?>bootstrap/js/bootstrap.min.js"></script>
  <!-- APPRISE -->
  <?php echo js("apprise.js"); ?>
  <!-- PACE -->
  <script src="<?php echo asset_url();?>plugins/pace/pace.min.js"></script>
  <!-- SlimScroll -->
  <script src="<?php echo asset_url();?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo asset_url();?>plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo asset_url();?>sipimss/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo asset_url();?>sipimss/js/demo.js"></script>
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <script type="text/javascript">
			var img_url_loader = "<?php echo img_url_loader(); ?>";
			var site_url = "<?php echo site_url(); ?>";
			<?php echo $css_script; ?>
		</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="row" style="background-color:#d1d3d4; height:80px">
        <div class="col-lg-2"></div>
        <div class="col-lg-8 col-xs-12">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-xs-2 col-sm-2">
                    <a href="#">
                        <img src="<?php echo asset_url();?>sipimss/img/sipimss_logo_2.png" 
                             height="80px"
                             class="" 
                             alt="SIPIMSS"
                             title="SIPIMSS"
                             target="_blank"/>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="http://edumed.imss.gob.mx">
                        <img src="<?php echo asset_url();?>sipimss/img/ces.png" 
                             class="img-header" 
                             alt="Coordinación de Educación en Salud" 
                             title="Coordinación de Educación en Salud"
                             target="_blank"/>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="http://innovacioneducativa.imss.gob.mx">
                        <img src="<?php echo asset_url();?>sipimss/img/die.png" 
                             class="img-header"
                             alt="División de Innovación Educativa"
                             title="División de Innovación Educativa"
                             target="_blank"/>
                    </a>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <a href="http://www.imss.gob.mx">
                        <img src="<?php echo asset_url();?>sipimss/img/imss.png" 
                             class="img-header" 
                             alt="Instituto Mexicano del Seguro Social"
                             title="Instituto Mexicano del Seguro Social"
                             target="_blank"/>
                    </a>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
        <div class="col-lg-2"></div>
</div>
<!-- Site wrapper -->
<div class="wrapper">
    <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SIP</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SIPIMSS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <?php if($this->session->userdata('usuario_logeado')){ ?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo asset_url();?>sipimss/img/iconTeach.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata("nombre") . " "  
                        . $this->session->userdata("apaterno") . " "
                        . $this->session->userdata("amaterno") ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo asset_url();?>sipimss/img/iconTeach.png" class="img-circle" alt="User Image">

                <p>
                 <?php echo $this->session->userdata("nombre") . " "  
                        . $this->session->userdata("apaterno") . " "
                        . $this->session->userdata("amaterno") ?>
                  <small><?php echo $this->session->userdata("matricula")?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <!--a href="#">Followers</a-->
                  </div>
                  <div class="col-xs-4 text-center">
                    <!--a href="#">Sales</a-->
                  </div>
                  <div class="col-xs-4 text-center">
                    <!--a href="#">Friends</a-->
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--<a href="#" class="btn btn-default btn-flat"><? php echo  $string_tpl["lbl_link_profile"]?></a>-->
                    
                </div>
                <div class="pull-right">
                  <!--<a href="<? php echo site_url('login/cerrar_session'); ?>" class="btn btn-default btn-flat"><? php echo $string_tpl["lbl_link_logout"]?></a>-->
                    <a href="<?= base_url(); ?>/index.php/login/cerrar_session" class="btn btn-default btn-flat">Cerrar sesión</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <?php }?>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      
      
      <!--Posiblidad de quitar por duplicidad de datos-->
<!--      <div class="user-panel">
        <div class="pull-left image">
          <img src="<? php echo asset_url();?>sipimss/img/iconTeach.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><? php echo $this->session->userdata("nombre") . "<br /> "  
                        . $this->session->userdata("apaterno") . "<br /> "
                        . $this->session->userdata("amaterno") ;
            ?>
          </p>
        </div>
      </div>-->
        <div class="user-body">
            <p  class="bg-red">
                <?php
                    if( $this->session->userdata("nombre_rol") != "" ){
                        echo "Rol: " .$this->session->userdata("nombre_rol"); 
                    }else{
                        echo "Seleccione un rol";
                    }    
                ?>
            </p>
        </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
          <?php
          
            // En esta parte se imprime la selección de rol del menú
            $roles = $this->session->userdata('lista_roles');
            if($roles){
          ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-exchange"> </i>
                    <span>
                        <?php
                            if( $this->session->userdata("nombre_rol") != "" ){
                                echo "Cambio de rol "; 
                            }else{
                                echo "Roles disponibles ";
                            }    
                        ?>
                    </span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu" >
                   <?php
                        $printRolesLi = "";
                        $cont = 0;
                        foreach($roles as $num => $rol){
                            $printRolesLi.= '<li class=""><a href="#"><i class="fa fa-circle-o"></i> '.$rol.' </a>
                                                    <ul class="treeview-menu">
                                                        <li><a href="'. base_url().'index.php/rol?seleciion_role='.$num.'&seccion=resumen"><i class="fa fa-circle-o"></i> Resumen </a></li>   
                                                        <li><a href="'. base_url().'index.php/rol?seleciion_role='.$num.'&seccion=entrar"><i class="fa fa-circle-o"></i> Entrar </a></li>
                                                    </ul>
                                              </li>';
                        }
                        echo $printRolesLi;
                   ?> 
                </ul>
            </li>
        <!--Crear menu-->
        <?php 
            }
            if($this->uri->segment(1)!=='rol' AND !is_null($this->session->userdata("rol_seleccionado"))){
            echo '<li class="header">ACTIVIDADES</li>';
                        $rol_opciones = $this->session->userdata("rol_seleccionado");
                        $tam_array_color = sizeof($tipo_color) - 1;
                        $color = '';     
//                        pr($rol_opciones);
                        foreach($rol_opciones as $key => $value){
                            if(empty(!$value['is_controlador'])AND intval($value['is_controlador']) ===1){
                            $color = $tipo_color[rand(0, $tam_array_color)];//Asignar un color
        ?>  
        <li><a href="<?php echo site_url($value['ruta']); ?>"><i class="fa fa-circle-o <?php echo $color; ?>"></i> <span><?php  echo $value['nombre_modulo'];?></span></a></li>
        <?php
                }
            }
        }//fin if 
        ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php
            if(!is_null($main_title)){ 
                echo $main_title;
            }   
        ?>
      </h1>
      <!--ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Pace page</li>
      </ol-->
    </section>

    <!-- Main content -->
    <section class="content">
    <?php if($this->session->flashdata('success')){?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            Success alert preview. This alert is dismissable.
        </div>
    <?php }elseif($this->session->flashdata('info')){ ?>
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-info"></i> Alert!</h4>
            Info alert preview. This alert is dismissable.
        </div>
    <?php }elseif($this->session->flashdata('error')){ ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my entire
            soul, like these sweet mornings of spring which I enjoy with my whole heart.
        </div>
    <?php }elseif($this->session->flashdata('warning')){?>
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            Warning alert preview. This alert is dismissable.
        </div>
    <?php } ?>
    <div id="msg_general"></div>
    <?php
    if(!is_null($main_content) ){
        echo $main_content;
    }
    ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    
        <!-- Se declara una ventana modal llamada modal_censo -->
		<div class="modal fade" id="modal_censo" tabindex="-1" 
             role="dialog" aria-labelledby="modal_censo_label" data-backdrop="static">
		    <div class="modal-dialog modal-lg" role="document">
		        <div class="modal-content" id="modal_content">
							<!-- Cuerpo de la ventana modal -->
                             <?php echo (! is_null($cuerpo_modal)) ? "{$cuerpo_modal}" : ""; ?>
		        </div>
		    </div>
		</div>
		<!-- Termina la ventana modal llamada modal_censo -->
    
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>SIPIMSS Versi&oacute;n</b> 0.4.0
    </div>
    <strong>Copyright © IMSS 2016. Este sitio se visualiza mejor a partir de resoluciones 1024 px con Microsof edge 25.10 / Firefox 33.0 / Chrome 38.0
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- page script -->
<script type="text/javascript">
	// To make Pace works on Ajax calls
	$(document).ajaxStart(function() { Pace.restart(); });
    $('.ajax').click(function(){
        $.ajax({url: '#', success: function(result){
            $('.ajax-content').html('<hr>Ajax Request Completed !');
        }});
    });
</script>
<?php echo js("general.js"); ?>
</body>
</html>
