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
<div class="section">
    <div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="row">
				<div class="col-md-12 text-left">
				<h3 class="text-center">ACTUALIZACI&Oacute;N EXPERIENCIA LABORAL</h3>
				</div>
				<div class="col-md-12">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formExperiencia" action="<?php echo base_url('ciudadano/principal/actualizarExperiencia') ?>" name="formExperiencia" method="post">
					<div class="row">
						<div class="col-lg-3">
							<div class="form-group">
								  <div class="col-md-12">
									<label class="control-label" for="nivel">Empresa</label>
									<div class="input-group input-append" id="datePicker">
										<input type="text" class="form-control validate[required]" name="empresa" id="empresa" value="<?php echo $experienciaUsuario[0]->empresa?>"/>
									</div>
								  </div>
							</div>								
						</div>							
						<div class="col-lg-3">
							<div class="form-group">	
								<label class="control-label" for="nivel">Tipo Empresa</label>
							  <div class="radio">
								<label for="tipoem-0">
								  <input class="validate[required]" type="radio" name="tipoem" id="tipoem" value="PU" <?php if($experienciaUsuario[0]->tipo_empresa == 'PU'){echo "checked";}?>>
									P&uacute;blica
								</label>									
								<label for="tipoem-1">
								  <input class="validate[required]" type="radio" name="tipoem" id="tipoem" value="PR" <?php if($experienciaUsuario[0]->tipo_empresa == 'PR'){echo "checked";}?>>
									Privada
								</label>
								</div>
							</div>
						</div>	
						<div class="col-lg-3">
							<div class="form-group">
								  <div class="col-md-12">
									<label class="control-label" for="nivel">Dependencia</label>
									<div class="input-group input-append" id="datePicker">
										<input type="text" class="form-control validate[required]" name="dependencia" id="dependencia"  value="<?php echo $experienciaUsuario[0]->dependencia?>"/>
									</div>
								  </div>
							</div>								
						</div>	
						<div class="col-lg-3">
							<div class="form-group">
								  <div class="col-md-12">
									<label class="control-label" for="nivel">Cargo</label>
									<div class="input-group input-append" id="datePicker">
										<input type="text" class="form-control validate[required]" name="cargo" id="cargo"  value="<?php echo $experienciaUsuario[0]->cargo?>"/>
									</div>
								  </div>
							</div>
						</div>	
					</div>
					<div class="row">
						<div class="col-md-4">								
							<div class="form-group">
								  <div class="col-md-12">
									<label class="control-label" for="pais">Pa&iacute;s</label>
									<select id="pais" name="pais" class="form-control validate[required]">
									  <option value="">Seleccione...</option>
									  <?php
										for($m=0;$m<count($paises);$m++)
										{
											if($experienciaUsuario[0]->codi_pais == $paises[$m]->codi_pais)
											{
												echo "<option value='".$paises[$m]->codi_pais."' selected>".$paises[$m]->desc_pais."</option>";
											}else{
												echo "<option value='".$paises[$m]->codi_pais."'>".$paises[$m]->desc_pais."</option>";	
											}											
										}
									  ?>
									</select>
								  </div>
							</div>
						</div>	
						<div class="col-md-4">
							<div class="form-group">
								  <div class="col-md-12">
									<label class="control-label" for="departamento">Departamento</label>
									<select id="departamento" name="departamento" class="form-control validate[required]">
									  <option value="">Seleccione...</option>
									  <?php
										$departamento = $this->perfil_model->departamentos($experienciaUsuario[0]->codi_pais);
										for($n=0;$n<count($departamento);$n++)
										{
											if($experienciaUsuario[0]->id_depto == $departamento[$n]->id_depto)
											{
												echo "<option value='".$departamento[$n]->id_depto."' selected>".$departamento[$n]->nom_depto."</option>";
											}else{
												echo "<option value='".$departamento[$n]->id_depto."'>".$departamento[$n]->nom_depto."</option>";
											}
										}
									  ?>
									</select>
								  </div>
							</div>								
						</div>							
						<div class="col-md-4">
							<div class="form-group">
								  <div class="col-md-12">
									<label class="control-label" for="municipio">Municipio</label>
									<select id="municipio" name="municipio" class="form-control validate[required]">
									  <option value="">Seleccione...</option>
									  <?php
										$municipio = $this->perfil_model->municipios($experienciaUsuario[0]->id_depto);
										for($a=0;$a<count($municipio);$a++)
										{
											if($experienciaUsuario[0]->id_mpio == $municipio[$a]->id_mpio)
											{
												echo "<option value='".$municipio[$a]->id_mpio."' selected>".$municipio[$a]->nom_mpio."</option>";
											}else{
												echo "<option value='".$municipio[$a]->id_mpio."'>".$municipio[$a]->nom_mpio."</option>";
											}
										}
									  ?>
									</select>
								  </div>
							</div>
						</div>							
					</div>
					<div class="row">	
						<div class="col-md-10 col-md-offset-1">
						<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								  <div class="col-md-12">
									<label class="control-label" for="nivel">Direcci&oacute;n</label>
									<div class="input-group input-append" id="datePicker">
										<input type="text" class="form-control validate[required]" name="direccion" id="direccion"  value="<?php echo $experienciaUsuario[0]->direccion?>"/>
									</div>
								  </div>
							</div>
						</div>	
						<div class="col-md-4">
							<div class="form-group">
								  <div class="col-md-12">
									<label class="control-label" for="nivel">Tel&eacute;fono</label>
									<div class="input-group input-append" id="datePicker">
										<input type="text" class="form-control validate[required]" name="telefono" id="telefono"  value="<?php echo $experienciaUsuario[0]->telefono?>"/>
									</div>
								  </div>
							</div>
						</div>	
						<div class="col-md-4">
							<div class="form-group">
								  <div class="col-md-12">
									<label class="control-label" for="nivel">Correo Electr&oacute;nico Entidad</label>
									<div class="input-group input-append" id="datePicker">
										<input type="text" class="form-control validate[custom[email]]" name="correo" id="correo"  value="<?php echo $experienciaUsuario[0]->correo?>"/>
									</div>
								  </div>
							</div>
						</div>	
						</div>
						</div>							
					</div>
					<br>
					<div class="row">	
						<div class="col-md-8 col-md-offset-2">
							<div class="row">	
								<div class="col-md-4">
								<div class="form-group">				
									<label class="control-label" for="textinput">Fecha de Ingreso</label>
									<div class="input-group input-append date" id="datePicker">
										<input type="text" class="form-control validate[required]" name="fechaIng" id="fechaIng" readonly  value="<?php echo $experienciaUsuario[0]->fecha_ingreso?>"/>
										<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
								</div>	
								<div class="col-md-4">
									<div class="form-group">								  
										<label class="control-label" for="textinput">Fecha de retiro</label>  
										<div class="input-group input-append date" id="datePicker">
											<input type="text" class="form-control validate[required]" name="fechaRet" id="fechaRet" readonly value="<?php if($experienciaUsuario[0]->fecha_retiro != '0000-00-00'){echo $experienciaUsuario[0]->fecha_retiro;}?>"/>
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>									
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">							  
										<label class="control-label" for="textinput">Trabajo aqui actualmente</label>  
										<input type="checkbox" class="form-control" name="fechaAct" id="fechaAct" <?php if($experienciaUsuario[0]->fecha_retiro == '0000-00-00'){echo "checked";}?>/>								
									</div>
								</div>
							</div>
						</div>							
					</div>						
					<br>
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<label class="control-label" for="textinput">Adjuntar Soporte</label>
							<?php
							if($experienciaUsuario[0]->nombE != "")
							{
								$styleDI = "style='display:none'";
							}else{
								$styleDI = "style='display:block'";
							}
							
							if($experienciaUsuario[0]->nombE != "")
							{
								?> 
								<br>
								Usted ya cuenta con un documento guardado <a href='<?php echo base_url('uploads/'.$experienciaUsuario[0]->nombE)?>' target='_blank'>
								<span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Documento</a>
								<br>
								Desea cambiar el documento? 
								<input class="validate[required]" type="radio" name="cambDE" id="cambDE" value="S"> SI
								<input class="validate[required]" type="radio" name="cambDE" id="cambDE" value="N" checked> NO
								<?php
							}
							?>
							<div class="form-group" id="actSopExp" <?= $styleDI?>>
							  <div class="col-md-12">
								<input id="doc_experiencia" name="doc_experiencia" class="file file-loading validate[required]" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-show-remove="false" data-allowed-file-extensions='["pdf"]' >
							  </div>
							</div>
						</div>							
					</div>
					<div class="col-sm-8 col-sm-offset-2 text-center">
						<input type="hidden" id="id_experiencia" name="id_experiencia" value="<?php echo $experienciaUsuario[0]->id_experiencia?>">
						<input type="hidden" id="id_doc_soporte" name="id_doc_soporte" value="<?php echo $experienciaUsuario[0]->id_doc_soporte?>">
						<a class="btn btn-danger" type="button" href="<?php echo base_url()?>"><i class="fa fa-fw fa-arrow-left"></i>Regresar</a>
						<button class="btn btn-success" type="submit"><i class="fa fa-fw fa-pencil-square-o"></i>Actualizar</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>