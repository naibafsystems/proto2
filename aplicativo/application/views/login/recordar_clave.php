<div class="col-md-10 col-md-offset-1">
	<?php
		$retornoError = $this->session->flashdata('retornoError');
		if ($retornoError) {
			?>
			<div class="row">
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Error!</strong> <?php echo $retornoError ?>
				</div>
			</div>    
			<?php
		}


		$retornoExito = $this->session->flashdata('retornoExito');
		if ($retornoExito) {
			?>
			<div class="row">
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<strong><?php echo $retornoExito ?></strong> 
				</div>
			</div>  
			<?php
		}
	?>
	    <form class="form-signin" action="<?php echo base_url('login/enviar_link') ?>" id="login" name="login" method="post">
	        <h3 class="form-signin-heading"><p class="text-center">Recuperaci&oacute;n de contrase&ntilde;a</p></h3>
	        <label for="usuario" class="sr-only">Correo electr&oacute;nico</label>
	        <div class="input-group">
	            <span class="input-group-addon" id="basic-addon1">@</span>
	            <input type="email" id="usuario" name="usuario" class="validate[required,custom[email]]  form-control" placeholder="Email" required="" autofocus="">
	        </div>
	        
	        
	        <p class="text-info text-center">El sistema enviar&aacute; una nueva contrase&ntilde;a para ingresar al banco de hojas de vida</p>
	        <button class="btn btn-lg btn-primary btn-block" type="submit">Enviar</button>
	    </form>
</div>