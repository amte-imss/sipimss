<?php 
/*foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach;*/ ?>

<!-- <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="row" style="margin:5px;">
            <div class="panel">
				<?php echo $output; ?>
    		</div>
    	</div>
    </div>
</div> -->

<h1><?php echo $string_values['rol_modulo']['titulo']; ?></h1><br>

<?php if(isset($msg) && !is_null($msg)){ echo $msg; } //Imprimir mensaje ?>
<div id="mensaje"></div>

<?php echo form_open('usuario/rol_modulo', array('id'=>'form_rol_modulo')); ?>

<div class="row">
	<div class='col-sm-12 col-md-12 col-lg-12'><br>
        <div class="form-group col-sm-12 text-right">
            <button type="button" id="btn_admin_rol" aria-expanded="false" class="btn btn-default browse">
                <?php echo $string_values['formulario']['btn_administrar_rol']; ?>
            </button>
            <button type="button" id="btn_admin_modulo" aria-expanded="false" class="btn btn-default browse">
                <?php echo $string_values['formulario']['btn_administrar_modulo']; ?>
            </button>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 table-responsive">
        <table class="table table-striped table-hover">
        	<thead>
        		<tr>
        			<th></th>
        			<?php foreach ($catalogos['crol'] as $rol) {
        				echo '<th>'.$rol.'</th>';
        			} ?>
        		</tr>
        	</thead>
        	<tbody>
    			<?php foreach ($catalogos['modulo'] as $key_modulo => $modulo) {
    				echo '<tr><td>'.$modulo.'</td>';
    				foreach ($catalogos['crol'] as $key_rol => $rol) {
    					$checked = array();
    					foreach ($rol_modulo as $key_rm => $rol_mod) {
    						//echo ($key_modulo==$rol_mod['MODULO_CVE'] && $key_rol==$rol_mod['ROL_CVE']) ? '<td>-'.$rol.'</td>' : '<td>km:'.$key_modulo.' rmm'.$rol_mod['MODULO_CVE'].'</td>';
    						if($key_modulo==$rol_mod['MODULO_CVE'] && $key_rol==$rol_mod['ROL_CVE']){
    							$checked = array('checked'=>'checked');
    						}
    					}
    					echo '<td>'.$this->form_complete->create_element(array('id'=>'rm_'.$key_rol.'[]', 'type'=>'checkbox', 'value'=>$key_modulo, 'attributes'=>array_merge(array('class'=>'form-control', 'placeholder'=>$rol.' - '.$modulo, 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$rol.' - '.$modulo), $checked) )).'</td>';
    				}
    				echo '</tr>';
    			} ?>
        	</tbody>
        </table>
    </div>
    <div class='col-sm-12 col-md-12 col-lg-12'><br>
        <div class="form-group col-sm-12 text-right">
            <button type="button" id="btn_rol_modulo_enviar" aria-expanded="false" class="btn btn-default browse">
                <?php echo $string_values['enviar']; ?>
            </button>
        </div>
    </div>
</div>

<?php echo form_close(); ?>

<script type="text/javascript">
$(function() {
    if($('#btn_rol_modulo_enviar').length){
        $('#btn_rol_modulo_enviar').on('click', function() {
        	apprise("<?php echo $string_values['rol_modulo']['texto'] ?>", {verify: true}, function(btnClick) {
				if (btnClick) {
					$("#form_rol_modulo").submit();
				} else {
	                return false;
	            }
        	});
        });
    }
});
</script>