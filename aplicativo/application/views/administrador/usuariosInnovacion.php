<?php
$errorBD = $this->session->flashdata('errorBD');
if ($errorBD) {
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong>Error!</strong> <?php echo $errorBD ?>
    </div>
    <?php
}

$registroExitoso = $this->session->flashdata('registroExitoso');
if ($registroExitoso) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong>OK!</strong> <?php echo $registroExitoso ?>
    </div>
    <?php
}
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<center>
			<h2>CONSULTA DE USUARIOS</h2>
		</center>		
	</div>
</div>
<form class="form-horizontal" role="form" id="formUsuarioInno" action="<?php echo base_url('administrador/usuarios/crearArchivoUsuarios')?>" name="formUsuarioInno" method="post">
<div class="row">
    <div class="col-md-10 col-md-offset-1">
    	<div class="row">    		
    		<div class="col-md-12 text-center">
    			<fieldset><b>Identificaci&oacute;n separado por ,</b></fieldset>
    			<input type="text" name="usuarios" id="usuarios" size="100" placeholder="Documento identificaci&oacute;n separado por coma">
    		</div>    		
    	</div>        
    </div>
</div><br>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<center>
			<input type="submit" class="btn btn-primary" value="Buscar" />	
		</center>		
	</div>
</div>
</form>
<br>

