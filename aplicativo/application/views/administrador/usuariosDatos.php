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
        <div class="col-md-10 col-md-offset-1">            
            <br>
            <div class="panel panel-default">
                <div class="panel-heading text-right">
                    <div class="nav">				
                        <div class="btn-group pull-left" data-toggle="buttons">
                            <label>
                                Usuarios Registrados
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
					<table class="table table-striped" id="tablaUsuarios">
						<thead>
							<tr>
								<th>ID</th>
								<th>Identificaci&oacute;n</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<!--<th>Foto Perfil</th>
								<th>Documento</th>-->                                                          
								<th>Formacion</th>
								<th>Experiencia</th>
								<th>Hoja de Vida</th>
								<th>Invitaciones</th>
								<th>Aplicaciones</th>
							</tr>
						</thead>
						<tbody>
						<?php
						for ($i = 0; $i < count($usuarios); $i++) {
							
							$datosUsuario = $this->perfil_model->datos_usuario($usuarios[$i]->id_usuario);
							$formacionUsuario = $this->perfil_model->formacionUsuario($usuarios[$i]->id_usuario);
							$experienciaUsuario = $this->perfil_model->experienciaUsuario($usuarios[$i]->id_usuario);
							$invitaciones = $this->usuarios_model->consulta_invitaciones($usuarios[$i]->id_usuario);							
							$aplicaciones = $this->usuarios_model->consulta_aplicacion($usuarios[$i]->id_usuario);
							
							//EXPERIENCIA LABORAL
							if(count($experienciaUsuario)>0)
							{
								$dias = 0;
								$exp = 0;
								for($j=0;$j<count($experienciaUsuario);$j++)
								{
								if($experienciaUsuario[$j]->fecha_retiro == '0000-00-00')
								{
								$fechaRetiro = 'Actualmente';
								$fechaCalcular = date('Y-m-d');
								}else
									{
										$fechaRetiro = $experienciaUsuario[$j]->fecha_retiro;
										$fechaCalcular = $experienciaUsuario[$j]->fecha_retiro;
								}
									
								$fechainicial = new DateTime($experienciaUsuario[$j]->fecha_ingreso);
								$fechafinal = new DateTime($fechaCalcular);
									
								$diferencia = $fechainicial->diff($fechafinal);
									
								$dias = $dias + $diferencia->days;
							
								$aniosE = $diferencia->y;
								$mesesE = $diferencia->m;
								$diasE = $diferencia->d;
								$diasExperiencia = $aniosE." AÒos - ".$mesesE." Meses - ".$diasE." Dias ";
							
								$expEnCuenta[$exp]['empresa'] = $experienciaUsuario[$j]->empresa;
								$expEnCuenta[$exp]['fechaIngreso'] = $experienciaUsuario[$j]->fecha_ingreso;
								$expEnCuenta[$exp]['fechaRetiro'] = $fechaCalcular;
								$expEnCuenta[$exp]['experiencia'] = $diasExperiencia;
								$exp++;
									
								}
									
								$mesesExperiencia = $dias/30;
								$aniosExperiencia = $mesesExperiencia/12;
							
								$tiempo = explode(".",$aniosExperiencia);
								$anio = $tiempo[0];
								$mes = "0.".$tiempo[1];
								$mesExperiencia = $mes*12;
							
								$experienciaT = intval($anio)." AÒos  -  ".intval($mesExperiencia)." Meses";
								//$informacionExponer[$i]['experiencia'] = print_r($dias);
								$tiempo_experiencia = $mesesExperiencia;
							
								}else{
								$mesExperiencia = 0;
								$mesesExperiencia = 0;
								$experienciaT = "Sin experiencia";
								//$informacionExponer[$i]['experiencia'] = print_r($dias);
								$tiempo_experiencia = $mesesExperiencia;
							}
							
							if(count($invitaciones)>0){
										
								$informacionExponer[$i]['invitaciones'] ='<center>
										<a href="#" data-toggle="modal" data-target="#invitaciones'.$usuarios[$i]->id_usuario.'">Ver Informaci&oacute;n</a>
									</center>
									<!-- Modal -->
									<div class="modal fade modal-wide" id="invitaciones'.$usuarios[$i]->id_usuario.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									  <div class="modal-dialog modal-lg" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title" id="myModalLabel">Invitaciones '.utf8_decode($usuarios[$i]->nombres)." ".utf8_decode($usuarios[$i]->apellidos).'</h4>
									      </div>
									      <div class="modal-body">
							        		<div class="row">
								        		<table class="table table-hover">
								        			<tr>
														<th>Operativo</th>
								        				<th>Investigaci&oacute;n</th>
								        				<th>Rol</th>
								        				<th>Ciudad</th>
								        				<th>Aplico</th>
								        				<th>Fecha Aplico</th>
								        				<th>Env&iacute;o Correo</th>
								        				<th>Fecha Correo</th>
								        			</tr>';
													
								        			for($inv = 0;$inv<count($invitaciones);$inv++){
									
														$informacionExponer[$i]['invitaciones'] .='<tr>
																<td>'.utf8_decode($invitaciones[$inv]->operativo).'</td>
																<td>'.utf8_decode($invitaciones[$inv]->nombre_inv).'</td>
																<td>'.utf8_decode($invitaciones[$inv]->nombre_rol_inv).'</td>
																<td>'.utf8_decode($invitaciones[$inv]->nom_mpio).'</td>
																<td>'.$invitaciones[$inv]->aplico.'</td>
																<td>'.$invitaciones[$inv]->fecha_aplico.'</td>
																<td>'.$invitaciones[$inv]->envio_email.'</td>
																<td>'.$invitaciones[$inv]->fecha_correo.'</td>
															</tr>';
														}
							$informacionExponer[$i]['invitaciones'] .='</table>		
							        		</div>
									      </div>							      
									    </div>
									  </div>
									</div>';
							}else{
								$informacionExponer[$i]['invitaciones'] ='<center>Sin Invitaciones</center>';
							}
							
							if(count($aplicaciones)>0){
										
								$informacionExponer[$i]['aplicaciones'] ='<center>
										<a href="#" data-toggle="modal" data-target="#aplicaciones'.$usuarios[$i]->id_usuario.'">Ver Informaci&oacute;n</a>
									</center>
									<!-- Modal -->
									<div class="modal fade modal-wide" id="aplicaciones'.$usuarios[$i]->id_usuario.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									  <div class="modal-dialog modal-lg" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title" id="myModalLabel">Aplicaciones '.utf8_decode($usuarios[$i]->nombres)." ".utf8_decode($usuarios[$i]->apellidos).'</h4>
									      </div>
									      <div class="modal-body">
							        		<div class="row">
								        		<table class="table table-hover">
								        			<tr>
								        				<th>Operativo</th>
								        				<th>Investigaci&oacute;n</th>
								        				<th>Rol</th>
								        				<th>Ciudad</th>
								        				<th>Aplico</th>
								        				<th>Observaciones</th>
								        			</tr>';
													
								        			for($apl = 0;$apl<count($aplicaciones);$apl++){
															
								        				$doc_estado = "Sin estado";
														
														if($aplicaciones[$apl]->doc_estado == 1){
															$doc_estado = "<img src='".base_url('assets/img/verde.jpg')."' width='45px'>";																							
														}else if($aplicaciones[$apl]->doc_estado == 2){
															$doc_estado = "<img src='".base_url('assets/img/naranja.jpg')."' width='45px'>";															
														}else if($aplicaciones[$apl]->doc_estado == 3){
															$doc_estado = "<img src='".base_url('assets/img/rojo.jpg')."' width='45px'>";															
														}else if($aplicaciones[$apl]->doc_estado == 0){
															$doc_estado = "Sin estado";
														}
														
														$obs_apli = "Sin observaciones";
														
														if($aplicaciones[$apl]->observaciones != ''){
															$obs_apli = utf8_decode($aplicaciones[$apl]->observaciones);																							
														}else{
															$obs_apli = "Sin observaciones";
														}
									
														$informacionExponer[$i]['aplicaciones'] .='<tr>
									    						<td>'.utf8_decode($aplicaciones[$apl]->operativo).'</td>
																<td>'.utf8_decode($aplicaciones[$apl]->nombre_inv).'</td>
																<td>'.utf8_decode($aplicaciones[$apl]->nombre_rol_inv).'</td>
																<td>'.utf8_decode($aplicaciones[$apl]->nom_mpio).'</td>
																<td>'.$doc_estado.'</td>
																<td>'.$obs_apli.'</td>
															</tr>';
														}
							$informacionExponer[$i]['aplicaciones'] .='</table>		
							        		</div>
									      </div>							      
									    </div>
									  </div>
									</div>';
							}else{
								$informacionExponer[$i]['aplicaciones'] ='<center>No tiene aplicaciones</center>';
							}
							
							if(trim($datosUsuario[0]->nombA) != ''){
								$imagenAvatar = base_url('uploads/avatar/'.$datosUsuario[0]->nombA);
							}else{
								$imagenAvatar = base_url('assets/img/avatar.png');
							}
							
							$informacionExponer[$i]['hojavida'] ='<center>
										<a href="#" data-toggle="modal" data-target="#hoja_vida'.$usuarios[$i]->id_usuario.'"><img src="'.base_url('assets/img/acroread.png').'"></a>
									</center>
									<!-- Modal -->
									<div class="modal fade bs-example-modal-lg" id="hoja_vida'.$usuarios[$i]->id_usuario.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									  <div class="modal-dialog modal-lg" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title" id="myModalLabel">Hoja de vida '.utf8_decode($usuarios[$i]->nombres)." ".utf8_decode($usuarios[$i]->apellidos).'</h4>
									      </div>
									      <div class="modal-body">
								        		<div class="row">
									        		<div class="col-md-10 col-md-offset-1">
									        			<div class="row">
										        			<div class="col-md-4">
										        				<img src="'.$imagenAvatar.'" width="200px">
										        			</div>
										        			<div class="col-md-8">
										        				<h3>'.strtoupper(utf8_decode($usuarios[$i]->nombres)).' '.strtoupper(utf8_decode($usuarios[$i]->apellidos)).'</h3><br>
										        				<b>Identificaci&oacute;n: </b>'.$usuarios[$i]->tipo_iden." - ".$usuarios[$i]->nume_iden.'<br>
										        				<b>Correo eletr&oacute;nico: </b>'.$usuarios[$i]->usuario.'<br>
										        				<b>Celular: </b>'.$usuarios[$i]->celular.'<br>
										        				<b>Tel&eacute;fono: </b>'.$datosUsuario[0]->telefono.'<br>
										        				<b>Fecha nacimiento: </b>'.$datosUsuario[0]->fecha_naci.'<br>
										        				<b>G&eacute;nero: </b>'.$datosUsuario[0]->desc_gene.'<br>
										        				<b>Documento identidad:</b> <a href="'.base_url('uploads/'.$datosUsuario[0]->nombDI).'" target="_blank">Documento</a><br>
										        				';
																
																if($datosUsuario[0]->genero == "M" && $datosUsuario[0]->nombLM != ''){
										        					$libretaMilitar = '<b>Libreta militar:</b> <a href="'.base_url('uploads/'.$datosUsuario[0]->nombLM).'" target="_blank">Documento</a><br>';
										        				}else{
										        					$libretaMilitar = '';
										        				}
																
																$informacionExponer[$i]['hojavida'] .= $libretaMilitar;		        				
																	        				
																$informacionExponer[$i]['hojavida'] .= '
									        					<b>Tiempo de experiencia: </b>'.$experienciaT.'<br> 
										        			</div>
									        			</div>
									        		</div>
								        			
								        		</div>
								        		<div class="row">
								        			<div class="col-md-10 col-md-offset-1">
									        			<div class="panel panel-primary">
														  <div class="panel-heading">Formaci&oacute;n acad&eacute;mica</div>
														  <div class="panel-body"> ';
														  
														  	if(count($formacionUsuario)>0){
														  		for($f=0;$f<count($formacionUsuario);$f++){
														  			if(($f%2) == 0){
														  				$clase = "#D9EDF7";	
														  			}else{
														  				$clase = "#F5F5F5";	
														  			}
														  			
							$informacionExponer[$i]['hojavida'] .= '<div class="row" style="background-color: '.$clase.'">
														  				<div class="col-md-10 col-md-offset-1">
														  					<b>Nivel: </b>'.utf8_decode($formacionUsuario[$f]->descripcion).'<br>
														  					';
																			
														  					if($formacionUsuario[$f]->id_areacono != 0){												  						
																				$informacionExponer[$i]['hojavida'] .= '<b>Area Conocimiento: </b>'.utf8_decode($formacionUsuario[$f]->desc_areacono).'<br>';
														  					}
																			
														  					if($formacionUsuario[$f]->id_programa != 0){
														  						$informacionExponer[$i]['hojavida'] .= '<b>Programa: </b>'.utf8_decode($formacionUsuario[$f]->desc_programa).'<br>';												  						
														  					}
														  					
																			$informacionExponer[$i]['hojavida'] .= '<b>Fecha terminaci&oacute;n: </b>'.$formacionUsuario[$f]->fechaTermina.' - <a href="'.base_url('uploads/'.$formacionUsuario[$f]->nombF).'" target="_blank">Documento</a><br>';
					
														  					if($formacionUsuario[$f]->nombT != NULL){
														  						$informacionExponer[$i]['hojavida'] .= '
														  						<b>Tarjeta Profesional: </b>'.$formacionUsuario[$f]->fechaTarje.' - <a href="'.base_url('uploads/'.$formacionUsuario[$f]->nombT).'" target="_blank">Documento</a><br>	
														  						';
														  					}
														  					$informacionExponer[$i]['hojavida'] .= '<b>Semestres cursados: </b>'.$formacionUsuario[$f]->semestres.'<br>';
														  					
							$informacionExponer[$i]['hojavida'] .= '  </div>
														  			</div>
														  			<hr>';
														  		}
														  	}else{
														  		$informacionExponer[$i]['hojavida'] .= '<center>Sin formaci&oacute;n acad&eacute;mica</center>';
														  	}
															
							$informacionExponer[$i]['hojavida'] .= ' </div>
														</div>
								        			</div>
								        			
								        		</div>
								        		<div class="row">
								        			<div class="col-md-10 col-md-offset-1">
									        			<div class="panel panel-primary">
														  <div class="panel-heading">Experiencia laboral</div>
														  <div class="panel-body">
														  ';
														  	
														  	if(count($experienciaUsuario)>0){
														  		for($e=0;$e<count($experienciaUsuario);$e++){
														  		/*-------------- CALCULAR LA EXPERIENCA POR TRABAJO ---------------------*/
														  			if($experienciaUsuario[$e]->fecha_retiro == '0000-00-00')
														  			{
														  				$fechaRetiro = 'Actualmente';
														  				$fechaCalcular = date('Y-m-d');
														  			}else
														  			{
														  				$fechaRetiro = $experienciaUsuario[$e]->fecha_retiro;
														  				$fechaCalcular = $experienciaUsuario[$e]->fecha_retiro;
														  			}
														  			$fechainicial = new DateTime($experienciaUsuario[$e]->fecha_ingreso);
														  			$fechafinal = new DateTime($fechaCalcular);
														  			
														  			$diferencia = $fechainicial->diff($fechafinal);
														  			
														  			$a√±os = $diferencia->y;
														  			$meses = $diferencia->m;
														  			$dias = $diferencia->d;
														  			$diasExperiencia = $a√±os." A&ntilde;os - ".$meses." Meses - ".$dias." Dias ";
														  		/*---------------------------------------------------------------------*/
														  			
														  			if(($e%2) == 0){
														  				$clase = "#D9EDF7";	
														  			}else{
														  				$clase = "#F5F5F5";	
														  			}
														  			
							$informacionExponer[$i]['hojavida'] .= '<div class="row" style="background-color: '.$clase.'">
														  				<div class="col-md-10 col-md-offset-1">
														  					<b>Empresa: </b>'.utf8_decode($experienciaUsuario[$e]->empresa).'<br>
														  					<b>Cargo: </b>'.utf8_decode($experienciaUsuario[$e]->cargo).'<br>
														  					<b>Dependencia: </b>'.utf8_decode($experienciaUsuario[$e]->dependencia).'<br>
														  					<b>Direcci&oacute;n: </b>'.$experienciaUsuario[$e]->direccion.'<br>
														  					<b>Tel&eacute;fono: </b>'.$experienciaUsuario[$e]->telefono.'<br>
														  					<b>Fecha de ingreso: </b>'.$experienciaUsuario[$e]->fecha_ingreso.'<br>
														  					<b>Fecha de retiro: </b>';
																			
														  					
																			if($experienciaUsuario[$e]->fecha_retiro == "0000-00-00"){
																				$informacionExponer[$i]['hojavida'] .= 'Actualmente';
																			}else{
																				$informacionExponer[$i]['hojavida'] .= $experienciaUsuario[$e]->fecha_retiro;
																				}
																	$informacionExponer[$i]['hojavida'] .= '<br><b>Experiencia: </b>'.$diasExperiencia;
														  					
							$informacionExponer[$i]['hojavida'] .= '	<br>
														  					<b>Certificaci&oacute;n: </b><a href="'.base_url('uploads/'.$experienciaUsuario[$e]->nombE).'" target="_blank">Documento</a><br>
														  				</div>
														  			</div>
														  			<hr>
														  			';
														  		}
														  	}else{
														  		$informacionExponer[$i]['hojavida'] .= '<center>Sin experiencia laboral</center>';
														  	}
							$informacionExponer[$i]['hojavida'] .= '								
														  </div>
														</div>
								        			</div>
								        			
								        		</div>
									      </div>							      
									    </div>
									  </div>
									</div>';
							
							?>
							
							<tr>
							<td><?php echo utf8_decode($usuarios[$i]->id_usuario)?></td>
							<td><?php echo utf8_decode($usuarios[$i]->tipo_iden) . " - " . utf8_decode($usuarios[$i]->nume_iden) ?></td>
							<td><?php echo utf8_decode($usuarios[$i]->nombres) ?></td>
							<td><?php echo utf8_decode($usuarios[$i]->apellidos) ?></td>
							<?php
							
							if($usuarios[$i]->id_avatar > 0){ $avatar = "SI";}else{ $avatar = "NO";}
							
							//echo "<td>" . $avatar . "</td>";
							
							if($usuarios[$i]->id_docIden > 0){ $documento = "SI";}else{ $documento = "NO";}
							
							//echo "<td>" . $documento . "</td>";
							
							if(count($formacionUsuario)>0){
								$formacion = "SI";
							}else{
								$formacion = "NO";
							}
							
							if(count($experienciaUsuario)>0){
								$experiencia = "SI";
							}else{
								$experiencia = "NO";
							}
							
							echo "<td>" . $formacion . "</td>";
							echo "<td>" . $experiencia . "</td>";
							echo "<td>" . $informacionExponer[$i]['hojavida'] . "</td>";
							echo "<td>" . $informacionExponer[$i]['invitaciones'] . "</td>";
							echo "<td>" . $informacionExponer[$i]['aplicaciones'] . "</td>";
							echo "</tr>";
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


