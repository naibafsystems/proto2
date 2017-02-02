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
<div class="container">
	<?php
	if(count($ciudades) > 0){
		
	?>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<b>Ciudad a verificar:</b> 
			<select id="ciudad" name="ciudad">
			<?php
				for($c=0;$c<count($ciudades);$c++){
					if($ciudades[$c]->id_ciudad == $this->session->userdata('ciudad')){
						echo "<option value='".$ciudades[$c]->id_ciudad."' selected>".$ciudades[$c]->nom_mpio."</option>";
					}else{
						echo "<option value='".$ciudades[$c]->id_ciudad."'>".$ciudades[$c]->nom_mpio."</option>";
					}
					
				}				
			?>
			</select>
		</div>
	</div>
	<?php
	}
	?>
	<div class="row">
        <div class="col-md-10 col-md-offset-1">
        	<div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
            		<ul id="tabs" class="nav nav-tabs nav-justified" data-tabs="tabs">
            			<li class="active"><a href="#tabs-1" data-toggle="tab">Convocatorias Abiertas</a></li>
            			<li><a href="#tabs-2" data-toggle="tab">Invitaciones</a></li>
					</ul>
				</div>
			    <div class="panel-body">
					<div id="my-tab-content" class="tab-content">
				        <div class="tab-pane active" id="tabs-1">
				        	<?php
							
							if(count($conv_abiertas) > 0)
							{
								?>							
								<div class="row">
									<div class="table-responsive">
										<table class="table table-striped" id="tb-conv_abiertas">
											<thead>
												<tr>
													<th>Operativo</th>
													<th>Nombre</th>
													<th>Ciudad</th>
													<th>N&uacute;mero de personas a contratar</th>
												 <th>Fecha inicio</th>
													<th>Fecha finalizaci&oacute;n</th>                                                         
													<th>Inscritos</th>
													<th>Detalles</th>
													<th>Verificar</th>
												</tr>
											</thead>
											<tbody>
											<?php
											
												for ($a = 0; $a < count($conv_abiertas); $a++) {
													$info_conv = $this->convocatorias_model->infoConvMun($conv_abiertas[$a]->id_convocatoria, $conv_abiertas[$a]->id_conv_insc);
													$info_requ = $this->convocatorias_model->requisitosInscritosMun($conv_abiertas[$a]->id_convocatoria, $conv_abiertas[$a]->id_conv_insc);
													$info_convocatoriaEsp = $this->convocatorias_model->info_convocatoriaEsp($conv_abiertas[$a]->id_convocatoria);
													$info_convocatoria = $this->convocatorias_model->info_convocatoria($conv_abiertas[$a]->id_convocatoria);
													$inscritos = $this->convocatorias_model->totalInscritos($conv_abiertas[$a]->id_convocatoria, $conv_abiertas[$a]->id_conv_insc);
													
													echo "<tr>";
													echo "<td>";
													if($conv_abiertas[$a]->operativo == ''){
														echo "Falta codigo";
													}else{
														echo utf8_decode($conv_abiertas[$a]->operativo);
													}
													echo "</td>";
													echo "<td>" . utf8_decode($conv_abiertas[$a]->nombre_inv) . " - " . utf8_decode($conv_abiertas[$a]->nombre_rol_inv) . "</td>";
													echo "<td>" . utf8_decode($conv_abiertas[$a]->nom_mpio) . "</td>";
													echo "<td>" . $conv_abiertas[$a]->total_personas . "</td>";
													echo "<td>" . $conv_abiertas[$a]->fecha_inicio . "</td>";
													echo "<td>" . $conv_abiertas[$a]->fecha_fin . "</td>"; 
													?>
													<td>
														<?php 
															if(isset($inscritos[0]->total))
															{
																echo $inscritos[0]->total;
															}
															else{
																echo "0";
																}
														?>
														
													</td>
													<td class="text-center">
													  	
													  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalleConv<?php echo $conv_abiertas[$a]->id_convocatoria?>">
													  		<span class="glyphicon glyphicon-search" aria-hidden="true"> </span> Ver detalle      
													  	</button>
											  		</td>
											  		<!-- Modal detalle conv-->
														<div class="modal fade bs-example-modal-lg" id="detalleConv<?php echo $conv_abiertas[$a]->id_convocatoria?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
														  <div class="modal-dialog modal-lg" role="document">
														    <div class="modal-content">
														      <div class="modal-header">
														        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														        <h4 class="modal-title" id="myModalLabel"><?php echo utf8_decode($conv_abiertas[$a]->nombre_inv)?></h4>
														      </div>
														      <div class="modal-body">
									        					<div class="row">
									        						<div class="col-md-3"><b>Investigaci&oacute;n</b></div>
									        						<div class="col-md-9"><?php echo utf8_decode($info_conv[0]->nombre_inv)?></div>
									        					</div>
									        					<div class="row">
									        						<div class="col-md-3"><b>Rol</b></div>
									        						<div class="col-md-9"><?php echo utf8_decode($info_conv[0]->nombre_rol_inv)?></div>
									        					</div>
									        					<div class="row">
									        						<div class="col-md-3"><b>Ciudad</b></div>
									        						<div class="col-md-9"><?php echo utf8_decode($info_conv[0]->nom_mpio)?></div>
									        					</div>
									        					<div class="row">
									        						<div class="col-md-3"><b>Fecha de inicio de convocatoria</b></div>
									        						<div class="col-md-9"><?php echo $info_requ[0]->fecha_inicio?></div>
									        					</div>
									        					<div class="row">
									        						<div class="col-md-3"><b>Fecha de finalizaci&oacute;n de convocatoria</b></div>
									        						<div class="col-md-9"><?php echo $info_requ[0]->fecha_fin?></div>
									        					</div>
									        					<div class="row">
									        						<div class="col-md-3"><b>Honorarios</b></div>
									        						<div class="col-md-9"><?php echo utf8_decode($info_convocatoriaEsp[0]->honorarios)?></div>
									        					</div>
									        					<div class="row">
									        						<div class="panel panel-primary">
																	  <div class="panel-heading">Perfil</div>
																	  <div class="panel-body">
																	    <?php echo utf8_decode($info_convocatoriaEsp[0]->perfil)?>
																	  </div>
																	</div>                            						
									        					</div>
									        					<div class="row">
									        						<div class="panel panel-primary">
																	  <div class="panel-heading">Objeto</div>
																	  <div class="panel-body">
																	    <?php echo utf8_decode($info_convocatoriaEsp[0]->objeto)?>
																	  </div>
																	</div>
									        					</div>
									        					<div class="row">
									        						<div class="panel panel-primary">
																	  <div class="panel-heading">Obligaciones</div>
																	  <div class="panel-body">
																	    <?php echo utf8_decode($info_convocatoriaEsp[0]->obligaciones)?>
																	  </div>
																	</div>
									        					</div>  
									        					<div class="row">
																	<label class="control-label" for="textinput">Documento de Convocatoria</label>	
																	<span class='glyphicon glyphicon-info-sign' aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Documentos permitidos: PDF no mayor a 1Mb"></span>
																	<br>
																	<a href='<?php echo base_url('uploads/'.$info_convocatoria[0]->nom_archivo)?>' target='_blank'>
																	<span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Documento</a>
																</div>                           					
													      </div>
														      <div class="modal-footer">
														        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
														      </div>
														    </div>
														  </div>
														</div>
													<!-- CIERRO MODAL -->											  		
													<td>
														<?php 
														if(isset($inscritos[0]->total) && $inscritos[0]->total <= 0){
															echo "<center><b>No hay inscritos</b></center>";
														}else{
															?>
															<center>
																<a class='btn btn-primary' style="color: white" href='<?php echo base_url('coordinador/principal/verificarDoc/' . $conv_abiertas[$a]->id_convocatoria . '/'. $conv_abiertas[$a]->id_conv_insc) ?>'>
																	<span class="glyphicon glyphicon-file" aria-hidden="true"> </span>  Verificar
																</a>
															</center>
															<?php
														}
														?>
													</td>
												</tr>
													<?php
												}
												?>
												</tbody>
											</table>
										</div>
									</div>                                        
		                             
		                            <?php
		                        
							}else{
								echo "<center>No existen convocatorias abiertas asociadas a su ciudad</center>";
							}
							?>
			        </div>
						        
					    
				    <div class="tab-pane" id="tabs-2">
					    <?php
							if(count($conv_cerradas) > 0){							
								?>
									<div class="row">
										<div class="table-responsive">
											<table class="table table-striped" id="tb-conv_cerradas">
												<thead>
													<tr>
														<th>Operativo</th>
														<th>Nombre</th>
														<th>Ciudad</th>
														<th>N&uacute;mero de personas a contratar</th>
														<th>Fecha inicio</th>
														<th>Fecha finalizaci&oacute;n</th>  
														<th>Inscritos</th>
														<th>Verificar</th>													
													</tr>
												</thead>
												<tbody>
												<?php
													for ($c = 0; $c < count($conv_cerradas); $c++) {
																								
													$inscritos = $this->convocatorias_model->totalInscritos($conv_cerradas[$c]->id_convocatoria, $conv_cerradas[$c]->id_conv_insc);
													
													echo "<tr>";
													echo "<td>";
													if($conv_cerradas[$c]->operativo == ''){
														echo "Falta codigo";
													}else{
														echo utf8_decode($conv_cerradas[$c]->operativo);
													}
													echo "</td>";
													echo "<td>" . utf8_decode($conv_cerradas[$c]->nombre_inv) . " - " . utf8_decode($conv_cerradas[$c]->nombre_rol_inv) . "</td>";
													echo "<td>" . utf8_decode($conv_cerradas[$c]->nom_mpio) . "</td>";
													echo "<td>" . $conv_cerradas[$c]->total_personas . "</td>";
													echo "<td>" . $conv_cerradas[$c]->fecha_inicio . "</td>";
													echo "<td>" . $conv_cerradas[$c]->fecha_fin . "</td>";  
													?>
													<td>
														<?php if(isset($inscritos[0]->total)){echo $inscritos[0]->total;}else{echo "0";}?>
													</td>
													<td>
															<?php 
															if(isset($inscritos[0]->total) && $inscritos[0]->total <= 0){
																echo "<center><b>No hay inscritos</b></center>";
															}else{
																?>
																<center>
																	<a class='btn btn-primary' style="color: white" href='<?php echo base_url('coordinador/principal/verificarDoc/' . $conv_cerradas[$c]->id_convocatoria . '/'. $conv_cerradas[$c]->id_conv_insc) ?>'>
																		<span class="glyphicon glyphicon-file" aria-hidden="true"> </span>  Verificar
																	</a>	
																</center>																
																<?php
															}
															?>
														</td>
													</tr>
													<?php													
												}
												?>
												</tbody>
											</table>
										</div>
									</div>
							   
							<?php
								
							}else{
								echo "<center>No existen invitaciones asociadas a su ciudad</center>";
							}
		                    ?> 
					  </div>
					</div>      	
			  	</div>			  			  
			</div>	        	 
        </div>		
    </div>
</div>