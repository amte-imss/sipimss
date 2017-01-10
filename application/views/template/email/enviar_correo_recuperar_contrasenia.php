<div class="bg-success">


<p>
	Para continuar con la recuperación de su contraseña haga clic 
	<?php echo anchor(site_url('account/middle_password_reset/'.$token),'aquí'); ?>.
<br>
	O copie y pegue en su navegador la siguiente ruta: <?php echo site_url('account/middle_password_reset/'.$token) ?>
</p>

<p>
	Necesitará el siguiente código: <b><?php echo $REC_CON_CODIGO; ?></b>
</p>

</div>