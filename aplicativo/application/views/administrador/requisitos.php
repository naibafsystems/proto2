<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {

?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	<?php echo $retornoExito ?>
</div>
<?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
?>
<div class="alert alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<?php echo $retornoError ?>
</div>
<?php
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">

			<div class="panel panel-default">
				<div class="panel-heading text-right">
					<div class="nav">
						<div class="btn-group pull-left" data-toggle="buttons">
							<label> Requisitos Convocatoria: <?php echo utf8_decode($infoConv[0]->nombre_inv) . " - " . utf8_decode($infoConv[0]->nombre_rol_inv) ?> </label>
						</div>
					</div>
				</div>
				<form class="form-horizontal" enctype="multipart/form-data" role="form" id="formConvocatoria" action="<?php echo base_url('administrador/convocatorias/guardarRequisitos/' . $infoConv[0]->id_convocatoria) ?>" name="formConvocatoria" method="post">
					<div class="panel-body">
						
						<div class="row">							
							<div class="col-lg-6">
								<div class="form-group" id="div_eco">
									<div class="col-md-12">
										<label class="control-label" for="nivel">N&uacute;mero operativo</label>
										<input type="text" id="operativo" name="operativo" class="form-control validate[required]" value="<?php if(isset($infoRequ[0]->operativo)){echo $infoRequ[0]->operativo;}?>">
									</div>
								</div>
							</div> 
						</div>
						 
						<div class="row">							
							<div class="col-lg-6">
								<div class="form-group" id="div_eco">
									<div class="col-md-12">
										<label class="control-label" for="nivel">Archivo PDF</label>
										<?php 
										if($info_convocatoria[0]->nom_archivo != "")
										{
											$styleDI = "style='display:none'";
										}else{
											$styleDI = "style='display:block'";
										}
										if($info_convocatoria[0]->nom_archivo != "") 
										{
										?>
											<br>
											Usted ya cuenta con un documento guardado <a href='<?php echo base_url('uploads/'.$info_convocatoria[0]->nom_archivo)?>' target='_blank'>
											<span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Documento</a>
											<br>
											Desea cambiar el documento? 
											<input class="validate[required]" type="radio" name="cambDC" id="cambDC" value="S"> SI
											<input class="validate[required]" type="radio" name="cambDC" id="cambDC" value="N" checked> NO
											<?php
										}
										?>
										<div class="form-group" id="actSopConv" <?= $styleDI?>>
											<div class="col-md-12">
												<input type="hidden" name="idDocGuardado" value="<?= $info_convocatoria[0]->id_archivoConv?>">
												<input id="doc_convocatoria" name="doc_convocatoria" class="file " type="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-show-remove="false" data-allowed-file-extensions='["pdf"]' >
											</div>
										</div>
										
									</div>
								</div>
							</div> 
						</div>
						
						
						
						
						<div class="row">
							
							<div class="panel panel-default">
		                    <div class="panel-heading"><b><a href="#" data-toggle="tooltip" title="Niveles de formaci&oacute;n y experiencia">Niveles de formaci&oacute;n y experiencia</a> </b>
		                        
		                    </div>
		                    <?php if (count($requisitos)!=0){ ?>
		                    <div class="panel-body" id="divNuevoNivel">
		                    <?php for($z=0;$z<count($requisitos);$z++){?>
		                    	<div class="row" id="div_nivel_ext">    
		                        	<div class="col-sm-4">
		                        		<label class="control-label" for="nivel">Nivel</label>
										<select id="nivel-1" name="nivel[]" class="form-control validate[required]">
											<option value="">Seleccione...</option>
											<?php
											for ($m = 0; $m < count($niveles); $m++) {

												if ($niveles[$m] -> id_nivel == $infoRequ[$z] -> id_nivel) {
													echo "<option value='" . $niveles[$m] -> id_nivel . "' selected>" . utf8_decode($niveles[$m] -> descripcion) . "</option>";
												} else {
													echo "<option value='" . $niveles[$m] -> id_nivel . "'>" . utf8_decode($niveles[$m] -> descripcion) . "</option>";
												}
											}
											?>
										</select>		
		                            </div>
		                            <div class="col-sm-4">
		                                <label class="control-label" for="areas">Semestres o cursos aprobados</label>
										<select id="semestres-1" name="semestres[]" class="form-control validate[required]">
											<option value="">Seleccione...</option>
											<?php
											for ($a = 0; $a <= 11; $a++) {
												if ($a == $infoRequ[$z] -> semestres) {
													if ($a==0){
														echo "<option value='" . $a . "' selected>Graduado</option>";
													}else{
														echo "<option value='" . $a . "' selected>" . $a . "</option>";
													}
												} else {
													if ($a==0){
														echo "<option value='" . $a . "' selected>Graduado</option>";
													}else{
														echo "<option value='" . $a . "'>" . $a . "</option>";
													}
												}
											}
											?>
										</select>
		                            </div>
		                            <?php
									if (isset($infoRequ[0] -> tiempo)) {
										$tiempo = $infoRequ[$z] -> tiempo;
									} else {
										$tiempo = '';
									}
									?>
		                            <div class="col-sm-4">
		                                <label class="control-label" for="nivel">Tiempo de experiencia (Meses)</label>
										<input type="text" id="experiencia-1" name="experiencia[]" class="form-control validate[required]" value="<?php echo $tiempo?>">
		                            </div>	                            
		                        </div>
		                        <?php }?>	
		                    </div>
		                    <?php 
							}else{
								?>
								<div class="panel-body" id="divNuevoNivel">
		                    	<div class="row" id="div_nivel_ext">    
		                        	<div class="col-sm-4">
		                        		<label class="control-label" for="nivel">Nivel</label>
										<select id="nivel-1" name="nivel[]" class="form-control validate[required]">
											<option value="">Seleccione...</option>
											<?php
											for ($m = 0; $m < count($niveles); $m++) {

												if ($niveles[$m] -> id_nivel == $infoRequ[$z] -> id_nivel) {
													echo "<option value='" . $niveles[$m] -> id_nivel . "' selected>" . utf8_decode($niveles[$m] -> descripcion) . "</option>";
												} else {
													echo "<option value='" . $niveles[$m] -> id_nivel . "'>" . utf8_decode($niveles[$m] -> descripcion) . "</option>";
												}
											}
											?>
										</select>		
		                            </div>
		                            <div class="col-sm-4">
		                                <label class="control-label" for="areas">Semestres o cursos aprobados</label>
										<select id="semestres-1" name="semestres[]" class="form-control validate[required]">
											<option selected value="" selected>Seleccione...</option>
											<?php
											for ($a = 0; $a <= 11; $a++) {
												if ($a==0 ){
													echo "<option value='" . $a . "'>Graduado</option>";
												}else{
													echo "<option value='" . $a . "'>" . $a . "</option>";
												}
											}
											?>
										</select>
		                            </div>
		                            <?php
									if (isset($infoRequ[0] -> tiempo)) {
										$tiempo = $infoRequ[$z] -> tiempo;
									} else {
										$tiempo = '';
									}
									?>
		                            <div class="col-sm-4">
		                                <label class="control-label" for="nivel">Tiempo de experiencia (Meses)</label>
										<input type="text" id="experiencia-1" name="experiencia[]" class="form-control validate[required]" value="<?php echo $tiempo?>">
		                            </div>	                            
		                        </div>	
		                    	</div>	
							<?php
							}
		                    ?>
		                    <div class="panel-footer">
		                        <div class="row">
		                            <div class="col-sm-12">
		                            	<input type="hidden" name="tam" id="tam" value="<?php echo count($requisitos); ?>" >
		                                <div class="btn btn-info" id="btnAgregarNivel"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>  Agregar </div>
		                                <div class="btn btn-warning" id="btnBorrarNivel"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>  Quitar </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
							
							
							
						</div>						

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group" id="div_ciudad">
									<div class="col-md-12">
										<label class="control-label" for="nivel">&Aacute;rea de conocimiento</label>
										<select id="area" name="area[]" multiple="multiple" class="form-control">
											<?php
											$areasReg = '';

											if ($infoRequ[0] -> area) {
												$areasReg = explode(",", $infoRequ[0] -> area);
											}

											for ($c = 0; $c < count($areas); $c++) {

												if (array_search($areas[$c] -> id_programa, $areasReg)) {
													echo "<option value='" . $areas[$c] -> id_programa . "' data-section='" . utf8_decode($areas[$c] -> desc_areacono) . "' selected>" . $areas[$c] -> id_programa . " - " . utf8_decode($areas[$c] -> desc_programa) . "</option>";
												} else {
													echo "<option value='" . $areas[$c] -> id_programa . "' data-section='" . utf8_decode($areas[$c] -> desc_areacono) . "'>" . $areas[$c] -> id_programa . " - " . utf8_decode($areas[$c] -> desc_programa) . "</option>";
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<?php
						$info_ciudad = $this -> convocatorias_model -> info_por_ciudades($infoConv[0] -> id_convocatoria);
						?>
						<!-- ---------------- ------    Se muestra descripcion por ciudad y habilitar re apertura    -------------------     -->
						<div class="row">
							<div class="table-responsive col-md-10 col-md-offset-1">
								<table class="table table-striped">
									<tr>
										<th>Ciudad</th>
										<th>N&uacute;mero de personas a contratar</th>
										<th>M&aacute;ximo de inscritos </th>
										<th>ECO </th>
										<th>Fecha Cierre Convocatoria</th>
									</tr>
									<?php
									for ($i = 0; $i < count($info_ciudad); $i++) {
										echo "<tr>";
										echo "<td>" . utf8_decode($info_ciudad[$i] -> nom_mpio) . "</td>";
										echo "<td><input type='text' class='validate[required,custom[integer],min[1]]' name='contra-" . $info_ciudad[$i] -> id_conv_insc . "' value='" . $info_ciudad[$i] -> total_personas . "'></td>";
										echo "<td><input type='text' class='validate[required]' name='inscri-" . $info_ciudad[$i] -> id_conv_insc . "' value='" . $info_ciudad[$i] -> max_inscri . "'></td>";
										echo "<td><input type='text' class='validate[required]' name='eco-" . $info_ciudad[$i] -> id_conv_insc . "' value='" . $info_ciudad[$i] -> eco . "'></td>";
										/*echo "<td><input type='text' class='validate[required]' name='fechaFin-" . $info_ciudad[$i] -> id_conv_insc . "' value='" . $info_ciudad[$i] -> fecha_fin . "'></td>";*/
										echo "<td><input type='text' class='form-control validate[required] fechaConv' value='" . $info_ciudad[$i] -> fecha_fin . "' name='fechaFin-" . $info_ciudad[$i] -> id_conv_insc . "' readonly /></td>";
										echo "</tr>";
									}
									?>
								</table>
							</div>
						</div>
						
					</div><!--FIN DEL PANEL-->
					<div class="panel-footer">
						<button type="button" class="btn btn-danger" onclick="location.replace('<?php echo base_url('administrador/convocatorias/'); ?>')">
							Cancelar
						</button>
						<button type="submit" class="btn btn-success" >
							Guardar
						</button>
						</form>
					</div>
					<center>
						<button align="left" type="submit" class="btn btn-warning" data-toggle="modal" data-target="#archivarConvocatoria-<?php echo $infoConv[0]->id_convocatoria?>">Archivar Convocatoria</button>
	            	</center>
	            	
	            	<div class="modal fade bs-example-modal-lg" id="archivarConvocatoria-<?php echo $infoConv[0]->id_convocatoria?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Archivar Convocatoria</h4>
						  </div>
						  <form class="form-horizontal" enctype="multipart/form-data" role="form" action="<?php echo base_url('administrador/convocatorias/archivarConvocatoria/'.$infoConv[0] -> id_convocatoria) ?>" method="post">
						  <div class="modal-body">
								¡¡¡Desea archivar la convocatoria!!!. 
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-success" >Aceptar</button>
						  </div>
						  </form>
						</div>
					  </div>
					</div>
			</div>
		</div>
	</div>
</div>
