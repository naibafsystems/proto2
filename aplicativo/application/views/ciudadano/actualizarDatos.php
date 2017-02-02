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
				<h3 class="text-center">ACTUALIZACI&Oacute;N DE DATOS</h3>
				</div>
				<div class="col-md-12">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formCrearUsuario" action="<?php echo base_url('ciudadano/principal/actualizarUsuario') ?>" name="formCrearUsuario" method="post">
                    <div class="form-group has-feedback">
                        <div class="col-sm-6 text-left">
                            <label for="inputNombres" class="control-label">Nombres:</label>
							<input type="text" value="<?php echo $datosUsuario[0]->nombres?>" class="validate[required, custom[onlyLetterSp]] form-control" id="inputNombres" name="inputNombres" placeholder="Nombres">
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                        <div class="col-sm-6 text-left">
                            <label for="inputApellidos" class="control-label">Apellidos:</label>
							<input type="text" value="<?php echo $datosUsuario[0]->apellidos?>" class="validate[required, custom[onlyLetterSp]] form-control" id="inputApellidos" name="inputApellidos" placeholder="Apellidos">
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="col-sm-6 text-left">
                            <label for="inputEmail" class="control-label">Correo Electr&oacute;nico Principal:</label>
							<input type="text" readonly value="<?php echo $datosUsuario[0]->usuario?>" class="validate[required, custom[email]] form-control" id="inputEmail" name="inputEmail" placeholder="Correo Electr&oacute;nico">
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                        <div class="col-sm-6 text-left">
                            <label for="inputEmail" class="control-label">Confirmar Correo Secundario:</label>
							<input type="text" value="<?php echo $datosUsuario[0]->email2?>" class="validate[custom[email]] form-control" id="inputEmail2" name="inputEmail2" placeholder="Correo Electr&oacute;nico Secundario">
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div>                    
                    <div class="form-group has-feedback">
                        <div class="col-sm-6 text-left">
                            <label for="inputClave" class="control-label">Tel&eacute;fono:</label>
							<input type="text" value="<?php echo $datosUsuario[0]->telefono?>" size="10" class="validate[required, maxSize[10]] form-control" id="inputTelefono" name="inputTelefono" placeholder="Tel&eacute;fono">
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                        <div class="col-sm-6 text-left">
                            <label for="inputClave" class="control-label">Celular:</label>
							<input type="text" value="<?php echo $datosUsuario[0]->celular?>" class="validate[required, maxSize[10]] form-control" id="inputCelular" name="inputCelular" placeholder="Celular">
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="col-sm-6 text-left">
                            <label class="control-label">Fecha de Nacimiento:</label>
							<div class="input-group input-append date" id="datePicker">
								<input type="text" readonly value="<?php echo $datosUsuario[0]->fecha_naci?>" class="form-control validate[required]" name="fechaNaci" id="fechaNaci" data-date-end-date="-18y"/>
								<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
                        </div>
						<div class="col-sm-6 text-left">
							<label class="control-label">Sexo:</label>
							<br>
							<input class="validate[required]" type="radio" name="sexo" id="sexo" value="F" <?php if($datosUsuario[0]->genero == "F"){ echo "checked";}?> >Mujer
							<input class="validate[required]" type="radio" name="sexo" id="sexo" value="M" <?php if($datosUsuario[0]->genero == "M"){ echo "checked";}?> >Hombre
                        </div>
                    </div>	
					<div class="form-group has-feedback">  
						<div class="col-sm-6 text-left">
                            <label class="control-label">Nacionalidad:</label>
								<select name="nacionalidad" id="nacionalidad" class="form-control validate[required]">
								<?php
								if($datosUsuario[0]->nacionalidad == ''){
									$datosUsuario[0]->nacionalidad = 'COL';
								}
								
								for($p=0;$p<count($paises);$p++)
								{
									if($paises[$p]->codi_pais == $datosUsuario[0]->nacionalidad)
									{
										echo "<option value='".$paises[$p]->codi_pais."' selected>".utf8_decode($paises[$p]->desc_pais)."</option>";
									}else{
										echo "<option value='".$paises[$p]->codi_pais."'>".utf8_decode($paises[$p]->desc_pais)."</option>";	
									}									
								}
								?>
								</select>
                        </div>
						<div class="col-sm-6 text-left">
							<label class="control-label">Hoja de vida actualizada en el SIGEP:</label>
							<br>
							<input class="validate[required]" type="radio" name="sigep" id="sigep" value="S" <?php if($datosUsuario[0]->sigep == "S"){ echo "checked";}?> >SI
							<input class="validate[required]" type="radio" name="sigep" id="sigep" value="N" <?php if($datosUsuario[0]->sigep == "N"){ echo "checked";}?> >NO
                        </div>                        
                    </div>
					<div class="form-group has-feedback">
						<?php
							if($datosUsuario[0]->nombDI != "")
							{
								$styleDI = "style='display:none'";
							}else{
								$styleDI = "style='display:block'";
							}
						?>
						<div class="col-md-6">
							<label class="control-label" for="textinput">Documento de Identificaci&oacute;n</label>	
							<span class='glyphicon glyphicon-info-sign' aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Documentos permitidos: PDF no mayor a 1Mb"></span>
							<?php
							if($datosUsuario[0]->nombDI != "")
							{
								?>
								<br>
								Usted ya cuenta con un documento guardado <a href='<?php echo base_url('uploads/'.$datosUsuario[0]->nombDI)?>' target='_blank'>
								<span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Documento</a>
								<br>
								Desea cambiar el documento? 
								<input class="validate[required]" type="radio" name="cambDI" id="cambDI" value="S"> SI
								<input class="validate[required]" type="radio" name="cambDI" id="cambDI" value="N" checked> NO
								<?php
							}
							?>							
							<div class="form-group" id="div_docIden" <?= $styleDI?>>
							  <div class="col-md-12">
								<input id="doc_identidad" name="doc_identidad" class="file  file-loading validate[required]" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-show-remove="false" data-allowed-file-extensions='["pdf"]' >
							  </div>
							</div>
						</div>
						<?php
							if($datosUsuario[0]->genero == "F")
							{
								$styleLib = "style='display:none'";
							}else{
								$styleLib = "style='display:block'";
							}
						?>
						<div class="col-md-6">
							<div id="div_libreta" <?= $styleLib?>>
								<label class="control-label" for="textinput">Libreta Militar</label>
								<span class='glyphicon glyphicon-info-sign' aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Documentos permitidos: PDF no mayor a 1Mb"></span>
								<?php
								if($datosUsuario[0]->nombLM != "")
								{
									?>
									<br>
									Usted ya cuenta con un documento guardado <a href='<?php echo base_url('uploads/'.$datosUsuario[0]->nombLM)?>' target='_blank'>
									<span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Documento</a>
									<br>
									Desea cambiar el documento? 
									<input class="validate[required]" type="radio" name="cambLM" id="cambLM" value="S"> SI
									<input class="validate[required]" type="radio" name="cambLM" id="cambLM" value="N" checked> NO
									<?php
									$styleLibCamb = "style='display:none'";
								}else{
									$styleLibCamb = "style='display:block'";
								}
								?>
								<div class="form-group" id="div_libretaCamb" <?= $styleLibCamb?> >
								  <div class="col-md-12">
									<input id="doc_libreta" name="doc_libreta" class="file  file-loading validate[required]" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-show-remove="false" data-allowed-file-extensions='["pdf"]' >
								  </div>
								</div>
							</div>							
						</div>
					</div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                            <a class="btn btn-danger" type="button" href="<?php echo base_url()?>"><i class="fa fa-fw fa-arrow-left"></i>Regresar</a>
							<button class="btn btn-success" type="submit"><i class="fa fa-fw fa-pencil-square-o"></i>Actualizar</button>
                        </div>
                    </div>
                </form>
				</div>
            </div>
        </div>
    </div>
</div>