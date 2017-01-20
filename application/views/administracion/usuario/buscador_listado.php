<?php echo js('administracion/usuario.js'); ?>

<h1><?php echo $string_values['buscador']['titulo']; ?></h1><br>

<div id="mensaje"></div>

<?php echo form_open('usuario/index', array('id'=>'form_search')); ?>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            <label class="col-sm-4 control-label text-right"><span class="pull-right"><?php echo $string_values['buscador']['fil_mat_nom']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'srch_nombre', 'type'=>'text', 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['buscador']['fil_mat_nom'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['buscador']['fil_mat_nom']))); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            <label class="col-sm-4 control-label"><span class="pull-right"><?php echo $string_values['buscador']['fil_delegacion']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'srch_delegacion', 'type'=>'dropdown', 'options'=>$catalogos['cdelegacion'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('name'=>'srch_delegacion', 'class'=>'form-control', 'placeholder'=>$string_values['buscador']['fil_delegacion'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['buscador']['fil_delegacion']))); ?>                        
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            <label class="col-sm-4 control-label"><span class="pull-right"><?php echo $string_values['buscador']['fil_rol']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'srch_rol', 'type'=>'dropdown', 'options'=>$catalogos['crol'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('name'=>'srch_rol', 'class'=>'form-control', 'placeholder'=>$string_values['buscador']['fil_rol'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['buscador']['fil_rol']))); ?>                        
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            <label class="col-sm-4 control-label"><span class="pull-right"><?php echo $string_values['buscador']['fil_estado']; ?>:</span></label>
            <div class="col-sm-8">
                <?php echo $this->form_complete->create_element(array('id'=>'srch_est_usu', 'type'=>'dropdown', 'options'=>$catalogos['cestado_usuario'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('name'=>'srch_est_usu', 'class'=>'form-control', 'placeholder'=>$string_values['buscador']['fil_estado'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['buscador']['fil_estado']))); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px;">
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <button id="btn_submit" class="btn btn-default browse btn_buscar_usu">Buscar</button>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-4 col-sm-4">
                <div class="panel-body input-group input-group-sm">
                    <span class="input-group-addon">Número de registros a mostrar:</span>
                        <?php echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(10=>10, 20=>20, 50=>50, 100=>100), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"data_ajax(site_url+'/usuario/get_data_ajax', '#form_search', '#resultado_busqueda')"))); ?>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4">
                <div class="panel-body input-group input-group-sm">
                    <span class="input-group-addon">Ordenar por:</span>
                        <?php echo $this->form_complete->create_element(array('id'=>'order', 'type'=>'dropdown', 'options'=>$order_columns, 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/usuario/get_data_ajax', '#form_search', '#resultado_busqueda')"))); ?>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4">
                <div class="panel-body input-group input-group-sm">
                    <span class="input-group-addon">Tipo de orden:</span>
                        <?php echo $this->form_complete->create_element(array('id'=>'order_type', 'type'=>'dropdown', 'options'=>array('ASC'=>'Ascendente', 'DESC'=>'Descendente'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"data_ajax(site_url+'/usuario/get_data_ajax', '#form_search', '#resultado_busqueda')"))); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-right"><button type="button" class="btn btn-link btn-sm" id="btn_agregar_usu" data-toggle="modal" data-target="#modal_censo" data-value="">
                <?php echo $string_values['buscador']['titulo_agregar']; ?>
            </button></div>
        </div><br>
        <div id="resultado_busqueda" class="row">
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
    $( document ).ready(function() {
        data_ajax(site_url+"/usuario/get_data_ajax", "#form_search", "#resultado_busqueda");
        
        $("#btn_submit").click(function(event){
            data_ajax(site_url+"/usuario/get_data_ajax", "#form_search", "#resultado_busqueda");
            event.preventDefault();
        });
        /*$("#btn_agregar_usu").click(function(event){
            this.form.reset();
            data_ajax(site_url+"/usuario/get_data_ajax", "#form_search", "#resultado_busqueda");
            event.preventDefault();
        });*/
    });
</script>
