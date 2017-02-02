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
			<h2>REPORTE HISTORICO POR CONVOCATORIA</h2>
		</center>		
	</div>
</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
    	<div class="row">
    		<div class="col-md-3">
    			<fieldset><b>Operativo</b></fieldset>
    			<input type="text" name="operativo" id="operativo" placeholder="Numero Operativo">
    		</div>
    		<div class="col-md-3">
    			<fieldset><b>Experiencia</b></fieldset>
    			<input type="text" name="experiencia" id="experiencia" placeholder="experiencia en meses">
    		</div> 
    		<div class="col-md-3">
    			<fieldset><b>Encuesta</b></fieldset>
    			<select id="encuesta" name="encuesta" class="select2" multiple="multiple" style="width: 250px;">
                    <option value=""></option>
					<?php
					for ($i = 0; $i< count($investigaciones); $i++) {
					    echo "<option value='" . $investigaciones[$i]->id_investigacion . "'>" . utf8_decode($investigaciones[$i]->nombre_inv) . "</option>";
					}
					?>
            	</select>  
    		</div> 
    		<div class="col-md-3">
    			<fieldset><b>Rol</b></fieldset>
    			<select id="rol" name="rol" class="select2" multiple="multiple" style="width: 250px;">
                    <option value=""></option>
					<?php
					for ($i = 0; $i < count($roles); $i++) {
					    echo "<option value='" . $roles[$i]->id_rol_inv . "'>" . utf8_decode($roles[$i]->nombre_rol_inv) . "</option>";
					}
					?>
				</select>
    		</div> 
    		<div class="col-md-3">
    			<fieldset><b>Cedula</b></fieldset>
    			<input type="text" name="cedula" id="cedula" placeholder="Numero de identificacion">
    		</div>
    		<div class="col-md-3"> 
    			<fieldset><b>Nombre Completo</b></fieldset>
    			<input type="text" name="nombreC" id="nombreC" placeholder="nombre Completo">
    		</div>
    		<div class="col-md-3">
    			<fieldset><b>Ciudad</b></fieldset>
    			<select id="city" name="city" class="select2" multiple="multiple" style="width: 250px;">
                    <option value=""></option>
					<?php
					for ($i = 0; $i < count($ciudades); $i++) {
					    echo "<option value='" . $ciudades[$i]->id_mpio . "'>" . utf8_decode($ciudades[$i]->nom_mpio) . "</option>";
					}
					?>
				</select>
    		</div><br>
    		<!-- 
    		<div class="col-md-3">
    			<fieldset><b>Tipo Convocatoria</b></fieldset>
    			<input type="radio" name="convocatoria" id="convocatoria" value="A" checked >Abierta
    			<input type="radio" name="convocatoria" id="convocatoria" value="C">Invitaci&oacute;n
    		</div> -->
    	</div>       
    </div>
</div><br>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<center>
			<button class="btn btn-primary" id="btn-reporteHistoricoAdmin">Buscar</button>	
		</center>		
	</div>
</div>
<div class="row">
	<div class="col-md-12" id="informacion">
		
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