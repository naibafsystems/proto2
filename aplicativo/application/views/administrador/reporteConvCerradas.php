<?php

?>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<center>
			<h2>REPORTE CONVOCATORIAS CERRADAS</h2>
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
    			<fieldset><b>Ciudad</b></fieldset>
    			<select id="city" name="city" class="select2" multiple="multiple" style="width: 250px;">
                    <option value=""></option>
					<?php
					for ($i = 0; $i < count($ciudades); $i++) {
					    echo "<option value='" . $ciudades[$i]->id_mpio . "'>" . utf8_decode($ciudades[$i]->nom_mpio) . "</option>";
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
    		<br>
    	</div>       
    </div>
</div><br>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<center>
			<button class="btn btn-primary" id="btn-reporteConvCerradaAdmin">Buscar</button>	
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