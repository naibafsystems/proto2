<?php

$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <?php echo $retornoExito ?>
    </div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
    <div class="alert alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <?php echo $retornoError ?>
    </div>
    <?php
}

?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<center>
			<h2>ADMINISTRACI&Oacute;N DE USUARIOS</h2>
		</center>		
	</div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
    	<div class="row">
    		<div class="col-md-3">
    			<fieldset><b>Identificaci&oacute;n</b></fieldset>
    			<input type="text" name="documento" id="documento" placeholder="Documento identificaci&oacute;n">
    		</div>
    		<div class="col-md-3">
    			<fieldset><b>Nombres</b></fieldset>
    			<input type="text" name="nombres" id="nombres" placeholder="Nombres">
    		</div>
    		<div class="col-md-3">
    			<fieldset><b>Apellidos</b></fieldset>
    			<input type="text" name="apellidos" id="apellidos" placeholder="Apellidos">
    		</div>
    		<div class="col-md-3">
    			<fieldset><b>Correo Electr&oacute;nico</b></fieldset>
    			<input type="text" name="correo" id="correo" placeholder="Correo Electr&oacute;nico">
    		</div>
    	</div>        
    </div>
</div><br>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<center>
			<button class="btn btn-primary" id="btn-administrar">Buscar</button>	
		</center>		
	</div>
</div>
<br>
<div class="row">
	<div class="panel panel-primary">
		<div class="panel-heading">Resultados consulta</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12" id="informacion">
				
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalCargando">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
		<center>
			<img src="<?php echo base_url('assets/img/cargando.gif')?>">
		</center>    	
    </div>
  </div>
</div>
