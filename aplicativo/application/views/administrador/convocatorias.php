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
    <div class="row">
        <div class="col-md-12">
        <?php if($_SESSION["rol"]!=6){?>
        	<div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalConvocatoria">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Crear Convocatoria
                    </button>
                </div>
            </div>
        <?php 
		}
        ?>
            <br>
        	<div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
            		<ul id="tabs" class="nav nav-tabs nav-justified" data-tabs="tabs">
            			<li class="active"><a href="#tabs-1" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"> </span> Convocatorias Abiertas</a></li>
            			<li><a href="#tabs-2" data-toggle="tab"><span class="glyphicon glyphicon-list" aria-hidden="true"> </span> Convocatorias cerradas</a></li>
					</ul>
				</div>
			    <div class="panel-body">
					<div id="my-tab-content" class="tab-content">
				        <div class="tab-pane active" id="tabs-1">				        	
				        	<div class="panel panel-default">
				                <div class="panel-heading text-right">
				                    <div class="nav">				
				                        <div class="btn-group pull-left" data-toggle="buttons">
				                            <label>
				                                Convocatorias Abiertas
				                            </label>
				                        </div>
				                    </div>
				                </div>
				                <div class="panel-body">
									<table class="table table-striped" id="admin_abier">
										<thead>
											<tr>
												<th class="text-center">Operativo</th>
												<th class="text-center">Investigaci&oacute;n</th>
												<th class="text-center">Rol</th>	
										<!--		<th class="text-center">Fecha inicio convocatoria</th>
												<th class="text-center">Fecha fin convocatoria</th> -->
												<th class="text-center">Contrato</th>
										<?php if($_SESSION["rol"]!=6){ ?><th class="text-center">Requisitos</th><?php } ?>
												<th class="text-center">Detalle</th>
												<th class="text-center">Ciudades</th>
											</tr>											
										</thead>
										<tfoot>
											<tr>
												<th>Operativo</th>
												<th>Investigaci&oacute;n</th>
												<th>Rol</th>	
											<!-- <th>Fecha inicio convocatoria</th>
												<th>Fecha fin convocatoria</th> -->
												<th>Contrato</th>
											<?php if($_SESSION["rol"]!=6){ ?>	<th>Requisitos</th><?php } ?>
												<th>Detalle</th>
												<th>Ciudades</th>
											</tr>											
										</tfoot>
										<tbody>											
											<?php
						                    for ($a = 0; $a < count($conv_abiertas); $a++) {
						                        $info_conv = $this->convocatorias_model->info_convocatoria($conv_abiertas[$a]->id_convocatoria);						                        
						                        ?>
						                        <tr>						                        	
						                        	<td>
						                        		<?php
							                        	if($conv_abiertas[$a]->operativo == ''){
						                        			echo "Falta codigo";
							                        	}else{
							                        		echo utf8_decode($conv_abiertas[$a]->operativo);
							                        	}
							                        	?>
													</td>
						                        	<td><?php echo utf8_decode($conv_abiertas[$a]->nombre_inv)?></td>
						                        	<td><?php echo utf8_decode($conv_abiertas[$a]->nombre_rol_inv)?></td>						                        	
						                          <!--  <td><?php /* echo utf8_decode($info_conv[0]->fecha_inicio)?></td>
						                        	<td><?php echo utf8_decode($info_conv[0]->fecha_fin) */ ?></td> -->
						                        	<td><?php echo utf8_decode($conv_abiertas[$a]->honorarios)?></td>
						                        	<?php if($_SESSION["rol"]!=6){ ?>
						                        	<td class="text-center">
						                        		<a class='btn btn-danger' target='_blank' href='<?php echo base_url('administrador/convocatorias/requisitos/' . $conv_abiertas[$a]->id_convocatoria) ?>'>
		                                                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span>  Requisitos
		                                                </a>
	                                                </td>
	                                                <?php 
							                        }
							                        ?>
	                                                <td class="text-center">
		                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalle<?php echo $conv_abiertas[$a]->id_convocatoria?>">
													  		<span class="glyphicon glyphicon-search" aria-hidden="true"> </span> Ver detalle      
													  	</button>
													</td>
	                                                <td class="text-center">  	
													  	<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#minscritos<?php echo $conv_abiertas[$a]->id_convocatoria?>">
													  		<span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span> Ciudades      
													  	</button>
													  	<!-- MODAL CIUDADES -->
														<div class="modal fade modal-wide" id="minscritos<?php echo $conv_abiertas[$a]->id_convocatoria?>" tabindex="-1" role="dialog" aria-labelledby="myModalCiudades">
														  <div class="modal-dialog modal-lg" role="document">
														    <div class="modal-content">
														      <div class="modal-header">
														        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														        <h4 class="modal-title" id="myModalCiudades"><?php echo utf8_decode($conv_abiertas[$a]->nombre_inv)?></h4>
														      </div>
														      <div class="modal-body">
														      	<div class="table-responsive">
																  	<table class="table table-responsive">
					                                                	<thead>
					                                                		<tr>
						                                                        <th>Nombre</th>
						                                                        <th>Ciudad</th>
						                                                        <th>N&uacute;mero de personas a contratar</th>
						                                                        <th>Fecha inicio</th>
						                                                        <th>Fecha finalizaci&oacute;n</th>                                                          
						                                                        <th>ECO</th>
						                                                        <th>Inscritos</th>
																				<th>Borrar Ciudad</th>
						                                                    </tr>
					                                                	</thead>
					                                                    <tbody>
					                                                    <?php
					                                                    for ($i = 0; $i < count($info_conv); $i++) {
					                                                    	
																			$inscritos = $this->convocatorias_model->totalInscritos($conv_abiertas[$a]->id_convocatoria, $info_conv[$i]->id_conv_insc);
																			
					                                                        echo "<tr>";
					                                                        echo "<td>" . utf8_decode($info_conv[$i]->nombre_inv) . " - " . utf8_decode($info_conv[$i]->nombre_rol_inv) . "</td>";
					                                                        echo "<td>" . utf8_decode($info_conv[$i]->nom_mpio) . "</td>";
					                                                        echo "<td>" . $info_conv[$i]->total_personas . "</td>";
																			echo "<td>" . $info_conv[$i]->fecha_inicio . "</td>";
																			echo "<td>" . $info_conv[$i]->fecha_fin . "</td>";
																			echo "<td>" . $info_conv[$i]->eco . "</td>";
																			?>
																			<td>
																				<a class='btn btn-primary' target='_blank' href='<?php echo base_url('administrador/convocatorias/inscritos/' . $conv_abiertas[$a]->id_convocatoria . '/'. $info_conv[$i]->id_conv_insc) ?>'>
								                                                    <span class="glyphicon glyphicon-user" aria-hidden="true"> </span>  Inscritos <span class="badge"><?php if(isset($inscritos[0]->total)){echo $inscritos[0]->total;}else{echo "0";}?></span>
								                                                </a>
							                                                </td>
																			<td>
																				<?php 
																				if(isset($inscritos[0]->total) && $inscritos[0]->total > 0){
																					echo "<center><b>No se puede eliminar</b></center>";
																				}else{
																					?>
																					<center>
																						<a class='btn btn-danger' href='<?php echo base_url('administrador/convocatorias/eliminarCiudad/' . $conv_abiertas[$a]->id_convocatoria . '/'. $info_conv[$i]->id_conv_insc) ?>'>
																							<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Eliminar
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
														      <div class="modal-footer">
														        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
														      </div>
														    </div>
														  </div>
														</div>
														<!-- FIN MODAL CIUDADES -->
						                        	</td>
						                        </tr>
						                        
						                        
						                        					                        
						                        <!-- MODAL DETALLES -->
						                        <?php $readonly="";
						                        if($_SESSION["rol"]==6)$readonly="readonly='readonly' ";
						                        ?>
												<div class="modal fade bs-example-modal-lg" id="detalle<?php echo $conv_abiertas[$a]->id_convocatoria?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog modal-lg" role="document">
												    <div class="modal-content">
												      <div class="modal-header">
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												        <h4 class="modal-title" id="myModalLabel"><?php echo utf8_decode($conv_abiertas[$a]->nombre_inv)?></h4>
												      </div>
												      <form class="form-horizontal" role="form" id="formConvocatoriaActA" action="<?php echo base_url('administrador/convocatorias/actualizaConv/'.$conv_abiertas[$a]->id_convocatoria) ?>" name="formConvocatoriaActA" method="post">
												      <div class="modal-body">	
												      		<div class="row">                        
										                        <div class="col-md-3"><b>Tipo de convocatoria:</b></div>
										                        <div class="col-md-9">
										                            <div class="radio">
										                                <label for="tipo_conv-0">
										                                    <input class="validate[required]" type="radio" name="tipo_conv" id="tipo_conv" value="A" <?php if($conv_abiertas[$a]->tipo_conv == 'A'){echo "checked";}?>>
										                                    Abierta
										                                </label>									
										                                <label for="tipo_conv-1">
										                                    <input class="validate[required]" type="radio" name="tipo_conv" id="tipo_conv" value="C" <?php if($conv_abiertas[$a]->tipo_conv == 'C'){echo "checked";}?>>
										                                    Invitaci&oacute;n
										                                </label>
										                            </div>
										                        </div>							
										                    </div>					      	
						                					<div class="row">
						                						<div class="col-md-3"><b>Investigaci&oacute;n</b></div>
						                						<div class="col-md-9"><?php echo utf8_decode($conv_abiertas[$a]->nombre_inv)?></div>
						                					</div>
						                					<div class="row">
						                						<div class="col-md-3"><b>Rol</b></div>
						                						<div class="col-md-9"><?php echo utf8_decode($conv_abiertas[$a]->nombre_rol_inv)?></div>
						                					</div>                					
						                					<div class="row">
						                						<div class="col-md-3"><b>Honorarios o Salario</b></div>
						                						<div class="col-md-9"><input type="text" size="50%" class="form-control validate[required]" name="honorariosAct" id="honorariosAct" value="<?php echo utf8_decode($conv_abiertas[$a]->honorarios)?>"<?php echo $readonly;?>></div>
						                					</div>
															<div class="row">	
																<div class="col-md-10 col-md-offset-1">
																	<div class="col-md-6">
																		<div class="form-group">				
																			<label class="control-label" for="textinput">Fecha de inicio convocatoria</label>
																			<div class="input-group input-append date" id="datePicker">
																				<input type="text" class="form-control validate[required] fechaConv" value="<?php echo $info_conv[0]->fecha_inicio?>" name="fechaInicio" id="fechaInicio" <?php echo $readonly;?>/>
																				<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
																			</div>
																		</div>
																	</div>	
																	<div class="col-md-6">
																		<div class="form-group">								  
																			<label class="control-label" for="textinput">Fecha de finalizaci&oacute;n convocatoria</label>  
																			<div class="input-group input-append date" id="datePicker">
																				<input type="text" class="form-control validate[required] fechaConv" value="<?php echo $info_conv[0]->fecha_fin?>" name="fechaFin" id="fechaFin" <?php echo $readonly;?>/>
																				<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
																			</div>									
																		</div>
																	</div>
																</div>
															</div>
						                					<div class="row">
						                						<div class="panel panel-primary">
																  <div class="panel-heading">Perfil</div>
																  <div class="panel-body">
																  	<div class="col-md-12">
																  		<textarea class="form-control validate[required]" name="perfilAct" id="perfilAct" rows="2"<?php echo $readonly;?>><?php echo utf8_decode($conv_abiertas[$a]->perfil)?></textarea>	
																  	</div>										  											    
																  </div>
																</div>                            						
						                					</div>
						                					<div class="row">
						                						<div class="panel panel-primary">
																  <div class="panel-heading">Objeto</div>
																  <div class="panel-body">
																  	<div class="col-md-12">
																  		<textarea class="form-control validate[required]" name="objetoAct" id="objetoAct" rows="2" <?php echo $readonly;?>><?php echo utf8_decode($conv_abiertas[$a]->objeto)?></textarea>	
																  	</div>
																  </div>
																</div>
						                					</div>
						                					<div class="row">
						                						<div class="panel panel-primary">
																  <div class="panel-heading">Obligaciones</div>
																  <div class="panel-body">
																  	<div class="col-md-12">
																  		<textarea class="form-control validate[required]" name="obligacionesAct" id="obligacionesAct" rows="2" <?php echo $readonly;?>><?php echo utf8_decode($conv_abiertas[$a]->obligaciones)?></textarea>	
																  	</div>
																  </div>
																</div>
						                					</div> 
						                					<div class="row">
																<label class="control-label" for="textinput">Documento de Convocatoria</label>	
																<span class='glyphicon glyphicon-info-sign' aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Documentos permitidos: PDF no mayor a 1Mb"></span>
																<br>
																<a href='<?php echo base_url('uploads/'.$info_conv[0]->nom_archivo)?>' target='_blank'>
																<span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Documento</a>
															</div>                           					
												      </div>
												      <div class="modal-footer">
												        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
												        <?php if($_SESSION["rol"]!=6){ ?><button type="submit" class="btn btn-success">Actualizar</button><?php }?>
												      </div>
												      </form>
												    </div>
												  </div>
												</div>
												<!-- FIN MODAL-->
					                            <?php
						                        }
						                        ?>
													
										</tbody>
									</table>
				                    
				                </div>
				            </div>   
				        	
				        </div>
				        <div class="tab-pane" id="tabs-2">				        	
				        	<div class="panel panel-default">
				                <div class="panel-heading text-right">
				                    <div class="nav">				
				                        <div class="btn-group pull-left" data-toggle="buttons">
				                            <label>
				                                Convocatorias Cerradas
				                            </label>
				                        </div>
				                    </div>
				                </div>
				                <div class="panel-body">
			                		<table class="table table-striped" id="admin_cerra">
										<thead>
											<tr>
												<th class="text-center">Operativo</th>
												<th class="text-center">Investigaci&oacute;n</th>
												<th class="text-center">Rol</th>	
										<!--		<th class="text-center">Fecha inicio convocatoria</th>
												<th class="text-center">Fecha fin convocatoria</th> -->
												<th class="text-center">Contrato</th>
										<?php if($_SESSION["rol"]!=6 && $_SESSION["rol"]!=5){ ?><th class="text-center">Invitaciones</th><?php }?>
										<?php if($_SESSION["rol"]!=6){ ?><th class="text-center">Requisitos</th><?php }?>
												<th class="text-center">Detalles</th>
												<th class="text-center">Ciudades</th>
											</tr>											
										</thead>
										<tfoot>
											<tr>
												<th>Operativo</th>
												<th>Investigaci&oacute;n</th>
												<th>Rol</th>	
											<!--	<th>Fecha inicio convocatoria</th>
												<th>Fecha fin convocatoria</th>-->
												<th>Contrato</th>
											<?php if($_SESSION["rol"]!=6 && $_SESSION["rol"]!=5){ ?>	<th>Invitaciones</th> <?php }?>
											<?php if($_SESSION["rol"]!=6){ ?><th>Requisitos</th> <?php }?>
												<th>Detalles</th>
												<th>Ciudades</th>
											</tr>											
										</tfoot>
										<tbody>
				                        <?php
				                        for ($c = 0; $c < count($conv_cerradas); $c++) {
				                            $info_convC = $this->convocatorias_model->info_convocatoria($conv_cerradas[$c]->id_convocatoria);
											
				                            ?>
				                            <tr>
				                            	<td>
					                        		<?php
						                        	if($conv_cerradas[$c]->operativo == ''){
					                        			echo "Falta codigo";
						                        	}else{
						                        		echo utf8_decode($conv_cerradas[$c]->operativo);
						                        	}
						                        	?>
												</td>
				                            	<td><?php echo utf8_decode($conv_cerradas[$c]->nombre_inv)?></td>
					                        	<td><?php echo utf8_decode($conv_cerradas[$c]->nombre_rol_inv)?></td>						                        	
					                        <!--	<td><?php /* echo utf8_decode($info_convC[0]->fecha_inicio)?></td>
					                        	<td><?php echo utf8_decode($info_convC[0]->fecha_fin) */ ?></td> -->
					                        	<td><?php echo utf8_decode($conv_cerradas[$c]->honorarios)?></td>
					                        	<?php if($_SESSION["rol"]!=6 && $_SESSION["rol"]!=5){ ?>
					                        	<td class="text-center">
					                        		<a class='btn btn-info' target='_blank' href='<?php echo base_url('administrador/convocatorias/invitar/' . $conv_cerradas[$c]->id_convocatoria) ?>'>
	                                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"> </span>  Invitaciones
	                                                </a>
	                                            </td>
	                                            <?php }?>
	                                            <?php if($_SESSION["rol"]!=6){ ?>
	                                            <td class="text-center">    
					                        		<a class='btn btn-danger' target='_blank' href='<?php echo base_url('administrador/convocatorias/requisitos/' . $conv_cerradas[$c]->id_convocatoria) ?>'>
	                                                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span>  Requisitos
	                                                </a>	
                                                </td>
                                                <?php 
						                        }
                                                ?>
	                                            <td class="text-center">                                                  
	                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalle<?php echo $conv_cerradas[$c]->id_convocatoria?>">
												  		<span class="glyphicon glyphicon-search" aria-hidden="true"> </span> Ver detalle      
												  	</button>
											  	</td>
	                                            <td class="text-center"> 
												  	<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#minscritos<?php echo $conv_cerradas[$c]->id_convocatoria?>">
												  		<span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span> Ciudades      
												  	</button>
												  	<!-- MODAL CIUDADES -->
													<div class="modal fade modal-wide" id="minscritos<?php echo $conv_cerradas[$c]->id_convocatoria?>" tabindex="-1" role="dialog" aria-labelledby="myModalCiudades">
													  	<div class="modal-dialog modal-lg" role="document">
													    	<div class="modal-content">
														      <div class="modal-header">
														        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														        <h4 class="modal-title" id="myModalCiudades"><?php echo utf8_decode($conv_cerradas[$c]->nombre_inv)?></h4>
														      </div>
														      <div class="modal-body">
														      	<div class="table-responsive">
																  	<table class="table table-responsive">
					                                                	<thead>
					                                                		<tr>
						                                                        <th>Nombre</th>
						                                                        <th>Ciudad</th>
						                                                        <th>N&uacute;mero de personas a contratar</th>
						                                                        <th>Fecha inicio</th>
						                                                        <th>Fecha finalizaci&oacute;n</th>                                                          
						                                                        <th>ECO</th>
						                                                        <th>Inscritos</th>
																				<th>Borrar Ciudad</th>
						                                                    </tr>
					                                                	</thead>
					                                                    <tbody>
					                                                    <?php
						                                                for ($i = 0; $i < count($info_convC); $i++) {
						                                                	
																			$inscritos = $this->convocatorias_model->totalInscritos($conv_cerradas[$c]->id_convocatoria, $info_convC[$i]->id_conv_insc);
																			
						                                                    echo "<tr>";
						                                                    echo "<td>" . utf8_decode($info_convC[$i]->nombre_inv) . " - " . utf8_decode($info_convC[$i]->nombre_rol_inv) . "</td>";
						                                                    echo "<td>" . utf8_decode($info_convC[$i]->nom_mpio) . "</td>";
						                                                    echo "<td>" . $info_convC[$i]->total_personas . "</td>";
																			echo "<td>" . $info_convC[$i]->fecha_inicio . "</td>";
																			echo "<td>" . $info_convC[$i]->fecha_fin . "</td>";
																			echo "<td>" . $info_convC[$i]->eco . "</td>";
																			?>
																			<td>
																				<a class='btn btn-primary' target='_blank' href='<?php echo base_url('administrador/convocatorias/inscritos/' . $conv_cerradas[$c]->id_convocatoria . '/'. $info_convC[$i]->id_conv_insc) ?>'>
								                                                    <span class="glyphicon glyphicon-user" aria-hidden="true"> </span>  Inscritos <span class="badge"><?php if(isset($inscritos[0]->total)){echo $inscritos[0]->total;}else{echo "0";}?></span>
								                                                </a>
							                                                </td>
																			<td>
																					<?php 
																					if(isset($inscritos[0]->total) && $inscritos[0]->total > 0){
																						echo "<center><b>No se puede eliminar</b></center>";
																					}else{
																						?>
																						<a class='btn btn-danger' href='<?php echo base_url('administrador/convocatorias/eliminarCiudad/' . $conv_cerradas[$c]->id_convocatoria . '/'. $info_convC[$i]->id_conv_insc) ?>'>
																							<span class="glyphicon glyphicon-remove	" aria-hidden="true"> </span>  Eliminar
																						</a>
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
														      <div class="modal-footer">
														        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
														      </div>
														    </div>
														  </div>
														</div>
														<!-- FIN MODAL CIUDADES -->
					                        	</td>
				                        	</tr>
				                        
				                        
				                        <!-- Modal -->
				                        <?php $readonly="";
				                        	if($_SESSION["rol"]==6)$readonly="readonly='readonly' ";
				                        ?>
										<div class="modal fade bs-example-modal-lg" id="detalle<?php echo $conv_cerradas[$c]->id_convocatoria?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										  <div class="modal-dialog modal-lg" role="document">
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h4 class="modal-title" id="myModalLabel"><?php echo utf8_decode($conv_cerradas[$c]->nombre_inv)?></h4>
										      </div>
										      <form class="form-horizontal" role="form" id="formConvocatoriaActC" action="<?php echo base_url('administrador/convocatorias/actualizaConv/'.$conv_cerradas[$c]->id_convocatoria) ?>" name="formConvocatoriaActC" method="post">
										      <div class="modal-body">
										      		<div class="row">                        
								                        <div class="col-md-3"><b>Tipo de convocatoria:</b></div>
								                        <div class="col-md-9">
								                            <div class="radio">
								                                <label for="tipo_conv-0">
								                                    <input class="validate[required]" type="radio" name="tipo_conv" id="tipo_conv" value="A" <?php if($conv_cerradas[$c]->tipo_conv == 'A'){echo "checked";}?>>
								                                    Abierta
								                                </label>									
								                                <label for="tipo_conv-1">
								                                    <input class="validate[required]" type="radio" name="tipo_conv" id="tipo_conv" value="C" <?php if($conv_cerradas[$c]->tipo_conv == 'C'){echo "checked";}?>>
								                                    Invitaci&oacute;n
								                                </label>
								                            </div>
								                        </div>							
								                    </div>							      	
				                					<div class="row">
				                						<div class="col-md-3"><b>Investigaci&oacute;n</b></div>
				                						<div class="col-md-9"><?php echo utf8_decode($conv_cerradas[$c]->nombre_inv)?></div>
				                					</div>
				                					<div class="row">
				                						<div class="col-md-3"><b>Rol</b></div>
				                						<div class="col-md-9"><?php echo utf8_decode($conv_cerradas[$c]->nombre_rol_inv)?></div>
				                					</div>                					
				                					<div class="row">
				                						<div class="col-md-3"><b>Honorarios o Salario</b></div>
				                						<div class="col-md-9"><input type="text" size="50%" class="form-control validate[required]" name="honorariosAct" id="honorariosAct" value="<?php echo utf8_decode($conv_cerradas[$c]->honorarios)?>"<?php echo $readonly;?>></div>
				                					</div>
													<div class="row">	
														<div class="col-md-10 col-md-offset-1">
															<div class="col-md-6">
																<div class="form-group">				
																	<label class="control-label" for="textinput">Fecha de inicio convocatoria</label>
																	<div class="input-group input-append date" id="datePicker">
																		<input type="text" class="form-control validate[required] fechaConv"  value="<?php echo $info_convC[0]->fecha_inicio?>" name="fechaInicio" id="fechaInicio" readonly />
																		<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
																	</div>
																</div>
															</div>	
															<div class="col-md-6">
																<div class="form-group">								  
																	<label class="control-label" for="textinput">Fecha de finalizaci&oacute;n convocatoria</label>  
																	<div class="input-group input-append date" id="datePicker">
																		<input type="text" class="form-control validate[required] fechaConv"  value="<?php echo $info_convC[0]->fecha_fin?>"  name="fechaFin" id="fechaFin" readonly />
																		<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
																	</div>									
																</div>
															</div>
														</div>
													</div>
				                					<div class="row">
				                						<div class="panel panel-primary">
														  <div class="panel-heading">Perfil</div>
														  <div class="panel-body">
														  	<div class="col-md-12">
														  		<textarea class="form-control validate[required]" name="perfilAct" id="perfilAct" rows="2" <?php echo $readonly;?>><?php echo utf8_decode($conv_cerradas[$c]->perfil)?></textarea>	
														  	</div>										  											    
														  </div>
														</div>                            						
				                					</div>
				                					<div class="row">
				                						<div class="panel panel-primary">
														  <div class="panel-heading">Objeto</div>
														  <div class="panel-body">
														  	<div class="col-md-12">
														  		<textarea class="form-control validate[required]" name="objetoAct" id="objetoAct" rows="2" <?php echo $readonly;?>><?php echo utf8_decode($conv_cerradas[$c]->objeto)?></textarea>	
														  	</div>
														  </div>
														</div>
				                					</div>
				                					<div class="row">
				                						<div class="panel panel-primary">
														  <div class="panel-heading">Obligaciones</div>
														  <div class="panel-body">
														  	<div class="col-md-12">
														  		<textarea class="form-control validate[required]" name="obligacionesAct" id="objetoAct" rows="2" <?php echo $readonly;?>><?php echo utf8_decode($conv_cerradas[$c]->obligaciones)?></textarea>	
														  	</div>
														  </div>
														</div>
				                					</div>
				                					<div class="row">
														<label class="control-label" for="textinput">Documento de Convocatoria</label>	
														<span class='glyphicon glyphicon-info-sign' aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Documentos permitidos: PDF no mayor a 1Mb"></span>
														<br>
														<a href='<?php echo base_url('uploads/'.$info_convC[0]->nom_archivo)?>' target='_blank'>
														<span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Documento</a>
													</div>                             					
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
										        <?php if($_SESSION["rol"]!=6){ ?><button type="submit" class="btn btn-success">Actualizar</button><?php }?>
										      </div>
										      </form>						      
										    </div>
										  </div>
										</div>
										<!-- FIN MODAL-->
				                        
				                        <?php
				                    }
				                    ?> 
				                    </tbody>
				                    </table>
				                </div>
				            </div>
				        	
				        </div>
			       </div>
		      	</div>
	      	</div>
        </div>		
    </div>
</div>

<!-- Modal de Convocatorias -->
<div class="modal fade bs-example-modal-lg" id="modalConvocatoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Convocatorias</h4>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formConvocatoria" action="<?php echo base_url('administrador/convocatorias/guardarConvocatoria') ?>" name="formConvocatoria" method="post">
                <div class="modal-body">
                    <div class="row">                        
                        <div class="col-md-6">
                            <label class="control-label" for="graduado">Tipo de convocatoria</label>
                            <div class="radio">
                                <label for="tipo_conv-0">
                                    <input class="validate[required]" type="radio" name="tipo_conv" id="tipo_conv" value="A">
                                    Abierta
                                </label>									
                                <label for="tipo_conv-1">
                                    <input class="validate[required]" type="radio" name="tipo_conv" id="tipo_conv" value="C">
                                    Cerrada
                                </label>
                            </div>
                        </div>							
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group" id="div_modalidad">
                                <div class="col-md-12">
                                    <label class="control-label" for="nivel">Investigaci&oacute;n</label>
                                    <select id="investigacion" name="investigacion" class="form-control validate[required]">
                                        <option value="">Seleccione...</option>
										<?php
										for ($m = 0; $m < count($investigaciones); $m++) {
										    echo "<option value='" . $investigaciones[$m]->id_investigacion . "'>" . utf8_decode($investigaciones[$m]->nombre_inv) . "</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>								
                        </div>							
                        <div class="col-md-6">
                            <div class="form-group"  id="div_areacono">
                                <div class="col-md-12">
                                    <label class="control-label" for="areas">Rol</label>
                                    <select id="rol" name="rol" class="form-control validate[required]">
                                        <option value="">Seleccione...</option>
										<?php
										for ($a = 0; $a < count($roles); $a++) {
										    echo "<option value='" . $roles[$a]->id_rol_inv . "'>" . utf8_decode($roles[$a]->nombre_rol_inv) . "</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="div_perfil">
                                <div class="col-md-12">
                                    <label class="control-label" for="nivel">Perfil</label>
                                    <textarea class="form-control validate[required]" name="perfil" id="perfil" rows="2"></textarea>
                                </div>
                            </div>								
                        </div>	
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="div_objeto">
                                <div class="col-md-12">
                                    <label class="control-label" for="nivel">Objeto</label>
                                    <textarea class="form-control validate[required]" name="objeto" id="objeto" rows="2"></textarea>
                                </div>
                            </div>								
                        </div>	
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="div_obligacion">
                                <div class="col-md-12">
                                    <label class="control-label" for="nivel">Obligaciones</label>
                                    <textarea class="form-control validate[required]" name="obligaciones" id="obligaciones" rows="2"></textarea>
                                </div>
                            </div>								
                        </div>	
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="div_obligacion">
                                <div class="col-md-12">
                                    <label class="control-label" for="nivel">Honorarios o Salario</label>
                                    <input class="form-control validate[required]" name="honorarios" id="honorarios"></input>
                                </div>
                            </div>								
                        </div>	
                    </div>
                    <div class="row">	
                        <div class="col-md-10 col-md-offset-1">
                            <div class="col-md-6">
                                <div class="form-group">				
                                    <label class="control-label" for="textinput">Fecha de inicio convocatoria</label>
                                    <div class="input-group input-append date" id="datePicker">
                                        <input type="text" class="form-control validate[required] fechaConv" name="fechaInicio" id="fechaInicio" readonly />
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>	
                            <div class="col-md-6">
                                <div class="form-group">								  
                                    <label class="control-label" for="textinput">Fecha de finalizaci&oacute;n convocatoria</label>  
                                    <div class="input-group input-append date" id="datePicker">
                                        <input type="text" class="form-control validate[required] fechaConv" name="fechaFin" id="fechaFin" readonly />
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>									
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="div_ciudad">
                                <div class="col-md-12">
                                    <label class="control-label" for="nivel">Ciudad o ciudades donde se va a realizar</label>
                                    <select id="ciudades" name="ciudades[]" multiple="multiple" class="form-control validate[funcCall[ifSelectNotEmpty]]">
										<?php
										for ($c = 0; $c < count($ciudades); $c++) {
										    echo "<option value='" . $ciudades[$c]->id_mpio . "' data-section='" . utf8_decode($ciudades[$c]->nomb_terri) . "'>" . utf8_decode($ciudades[$c]->nom_mpio) . "</option>";
										}
										?>
                                    </select>
                                </div>
                            </div>								
                        </div>	
                    </div>
                    <div class="row">
						<label class="control-label" for="textinput">Convocatoria en PDF</label>	
						<span class='glyphicon glyphicon-info-sign' aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Documentos permitidos: PDF no mayor a 1Mb"></span>
						<div class="form-group" id="div_docIden">
						  <div class="col-md-12">
							<input id="doc_identidad" name="doc_identidad" class="file  file-loading validate[required]" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-show-remove="false" data-allowed-file-extensions='["pdf"]' >
						  </div>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" >Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal de Experiencia -->
<div class="modal fade bs-example-modal-lg" id="modalExperiencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabelExp">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelExp">Experiencia Laboral</h4>
                <h6><font color="red">Los datos de experiencia se deben suministrar por cada uno de los contratos realizados</font></h6>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formExperiencia" action="<?php echo base_url('ciudadano/principal/guardarExperiencia') ?>" name="formFormacion" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label" for="nivel">Empresa</label>
                                    <div class="input-group input-append" id="datePicker">
                                        <input type="text" class="form-control validate[required]" name="empresa" id="empresa" />
                                    </div>
                                </div>
                            </div>								
                        </div>							
                        <div class="col-lg-3">
                            <div class="form-group">	
                                <label class="control-label" for="nivel">Tipo Empresa</label>
                                <div class="radio">
                                    <label for="tipoem-0">
                                        <input class="validate[required]" type="radio" name="tipoem" id="tipoem" value="PU">
                                        P&uacute;blica
                                    </label>									
                                    <label for="tipoem-1">
                                        <input class="validate[required]" type="radio" name="tipoem" id="tipoem" value="PR">
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
                                        <input type="text" class="form-control validate[required]" name="dependencia" id="dependencia" />
                                    </div>
                                </div>
                            </div>								
                        </div>	
                        <div class="col-lg-3">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label" for="nivel">Cargo</label>
                                    <div class="input-group input-append" id="datePicker">
                                        <input type="text" class="form-control validate[required]" name="cargo" id="cargo" />
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
for ($m = 0; $m < count($paises); $m++) {
    echo "<option value='" . $paises[$m]->codi_pais . "'>" . $paises[$m]->desc_pais . "</option>";
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
for ($n = 0; $n < count($departamento); $n++) {
    echo "<option value='" . $departamento[$n]->id_nivel . "'>" . $departamento[$n]->descripcion . "</option>";
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
for ($a = 0; $a < count($municipio); $a++) {
    echo "<option value='" . $municipio[$a]->id_areacono . "'>" . $municipio[$a]->desc_areacono . "</option>";
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
                                                <input type="text" class="form-control validate[required]" name="direccion" id="direccion" />
                                            </div>
                                        </div>
                                    </div>
                                </div>	
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label" for="nivel">Tel&eacute;fono</label>
                                            <div class="input-group input-append" id="datePicker">
                                                <input type="text" class="form-control validate[required]" name="telefono" id="telefono" />
                                            </div>
                                        </div>
                                    </div>
                                </div>	
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label" for="nivel">Correo Electr&oacute;nico Entidad</label>
                                            <div class="input-group input-append" id="datePicker">
                                                <input type="text" class="form-control validate[custom[email]]" name="correo" id="correo" />
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
                                            <input type="text" class="form-control validate[required]" name="fechaIng" id="fechaIng" readonly />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>	
                                <div class="col-md-4">
                                    <div class="form-group">								  
                                        <label class="control-label" for="textinput">Fecha de retiro</label>  
                                        <div class="input-group input-append date" id="datePicker">
                                            <input type="text" class="form-control validate[required]" name="fechaRet" id="fechaRet" readonly />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>									
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">								  
                                        <label class="control-label" for="textinput">Trabajo aqui actualmente</label>  
                                        <input type="checkbox" class="form-control" name="fechaAct" id="fechaAct"/>								
                                    </div>
                                </div>
                            </div>
                        </div>							
                    </div>						
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <label class="control-label" for="textinput">Adjuntar Soporte</label>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input id="doc_experiencia" name="doc_experiencia" class="file file-loading validate[required]" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-show-remove="false" data-allowed-file-extensions='["pdf"]' >
                                </div>
                            </div>
                        </div>							
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" >Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>


