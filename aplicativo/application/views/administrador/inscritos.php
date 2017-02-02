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

if(count($info_usuarios) > 0){ 
	
	for($i=0;$i < count($info_usuarios);$i++){
		
		$datosUsuario = $this->perfil_model->datos_usuario($info_usuarios[$i]->id_usuario);
		$formacionUsuario = $this->perfil_model->formacionUsuario($info_usuarios[$i]->id_usuario);
		$experienciaUsuario = $this->perfil_model->experienciaUsuario($info_usuarios[$i]->id_usuario);
		$datosDocu = $this->convocatorias_model->documentosCompletos($info_usuarios[$i]->id_usuario, $id_convocatoria);
			
		$informacionExponer[$i]['matriculado'] = $info_usuarios[$i]->matriculado; 
		$informacionExponer[$i]['fecha_matriculado'] = $info_usuarios[$i]->fecha_matriculado;
		$informacionExponer[$i]['fecha_aplica'] = $info_usuarios[$i]->fecha_aplica;
		
		$informacionExponer[$i]['datos'] = strtoupper(utf8_decode($info_usuarios[$i]->nombres))." ".strtoupper(utf8_decode($info_usuarios[$i]->apellidos))."<br>";
		$informacionExponer[$i]['datos'] .= $info_usuarios[$i]->tipo_iden." - ".$info_usuarios[$i]->nume_iden."<br>";
		$informacionExponer[$i]['datos'] .= $info_usuarios[$i]->usuario." - ".$info_usuarios[$i]->celular."<br>";
		
		if(trim($datosUsuario[0]->nombA) != ''){
			$imagenAvatar = base_url('uploads/avatar/'.$datosUsuario[0]->nombA);
		}else{
			$imagenAvatar = base_url('assets/img/avatar.png');
		}
		
		$informacionExponer[$i]['hojavida'] ='<center>
					<a href="#" data-toggle="modal" data-target="#hoja_vida'.$info_usuarios[$i]->id_usuario.'"><img src="'.base_url('assets/img/acroread.png').'"></a>
				</center>
				<!-- Modal -->
				<div class="modal fade bs-example-modal-lg" id="hoja_vida'.$info_usuarios[$i]->id_usuario.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Hoja de vida '.utf8_decode($info_usuarios[$i]->nombres)." ".utf8_decode($info_usuarios[$i]->apellidos).'</h4>
				      </div>
				      <div class="modal-body">
			        		<div class="row">
				        		<div class="col-md-10 col-md-offset-1">
				        			<div class="row">
					        			<div class="col-md-4">
					        				<img src="'.$imagenAvatar.'" width="200px">
					        			</div>
					        			<div class="col-md-8">
					        				<h3>'.strtoupper(utf8_decode($info_usuarios[$i]->nombres)).' '.strtoupper(utf8_decode($info_usuarios[$i]->apellidos)).'</h3><br>
					        				<b>Identificaci&oacute;n: </b>'.$info_usuarios[$i]->tipo_iden." - ".$info_usuarios[$i]->nume_iden.'<br>
					        				<b>Correo eletr&oacute;nico: </b>'.$info_usuarios[$i]->usuario.'<br>
					        				<b>Celular: </b>'.$info_usuarios[$i]->celular.'<br>
					        				<b>Tel&eacute;fono: </b>'.$datosUsuario[0]->telefono.'<br>
					        				<b>Fecha nacimiento: </b>'.$datosUsuario[0]->fecha_naci.'<br>
					        				<b>G&eacute;nero: </b>'.$datosUsuario[0]->desc_gene.'<br>
					        				<b>Documento identidad:</b> <a href="'.base_url('uploads/'.$datosUsuario[0]->nombDI).'" target="_blank">Documento</a><br>
					        				';
											
											if($datosUsuario[0]->genero == "M"){
					        					$libretaMilitar = '<b>Libreta militar:</b> <a href="'.base_url('uploads/'.$datosUsuario[0]->nombLM).'" target="_blank">Documento</a><br>';
					        				}else{
					        					$libretaMilitar = '';
					        				}
											
											$informacionExponer[$i]['hojavida'] .= $libretaMilitar;		        				
												        				
											$informacionExponer[$i]['hojavida'] .= '
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
									  					
		$informacionExponer[$i]['hojavida'] .= '  </div>
									  			</div>
									  			<hr>';
									  		}
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
									  					
		$informacionExponer[$i]['hojavida'] .= '	<br>
									  					<b>Certificaci&oacute;n: </b><a href="'.base_url('uploads/'.$experienciaUsuario[$e]->nombE).'" target="_blank">Documento</a><br>
									  				</div>
									  			</div>
									  			<hr>
									  			';
									  		}
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
				
				
				//FORMACION ACADEMICA
				$puntajeForm = 0;
				$informacionExponer[$i]['formacion'] = '';
				$numForm = 1;
				for($f=0;$f<count($formacionUsuario);$f++){
					
					switch($formacionUsuario[$f]->id_nivel){
						case 1:
							$puntajeForm = $puntajeForm + 7;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
						case 2:
							$puntajeForm = $puntajeForm + 3;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
						case 3:
							$puntajeForm = $puntajeForm + 5;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
						case 4:
							$puntajeForm = $puntajeForm + 8;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
						case 5:
							$puntajeForm = $puntajeForm + 9;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
						case 6:
							$puntajeForm = $puntajeForm + 10;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
						case 8:
							$puntajeForm = $puntajeForm + 6;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
						case 9:
							$puntajeForm = $puntajeForm + 4;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
						case 10:
							$puntajeForm = $puntajeForm + 2;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
						case 11:
							$puntajeForm = $puntajeForm + 1;
							$informacionExponer[$i]['formacion'] .= " - ".utf8_decode($formacionUsuario[$f]->descripcion)."<br>";
						break;
					}							
				}
				
				$informacionExponer[$i]['puntajeForm'] = $puntajeForm;
				
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
								
								$añosE = $diferencia->y;
								$mesesE = $diferencia->m;
								$diasE = $diferencia->d;								
								$diasExperiencia = $añosE." Años - ".$mesesE." Meses - ".$diasE." Dias ";
								
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
						
			            $informacionExponer[$i]['experiencia'] = intval($anio)." A&ntilde;os  -  ".intval($mesExperiencia)." Meses";
						//$informacionExponer[$i]['experiencia'] = print_r($dias);
						$informacionExponer[$i]['tiempo_experiencia'] = $mesesExperiencia;
		
			}else{
				$mesExperiencia = 0;
				$mesesExperiencia = 0;
				$informacionExponer[$i]['experiencia'] = "Sin experiencia";
				//$informacionExponer[$i]['experiencia'] = print_r($dias);
				$informacionExponer[$i]['tiempo_experiencia'] = $mesesExperiencia;
			}
		
			//CUMPLE REQUISITOS
			$banderaMatricula = 0;
			if($mesesExperiencia >= $info_requ2[0]->tiempo){
				$banderaMatricula = 1;									
				$informacionExponer[$i]['cumple_req'] = "<img src='".base_url('assets/img/si.png')."'>";
				
			}else{
				$banderaMatricula = 0;
				$informacionExponer[$i]['cumple_req'] = "<img src='".base_url('assets/img/no.png')."'>";
			}			
			
			//DOCUMENTOS COMPLETOS
			if($datosDocu[0]->doc_estado == 0){
				$banderaMatricula = 0;
				$informacionExponer[$i]['doc_estado'] = "";
				
			}else if($datosDocu[0]->doc_estado == 1){
				$banderaMatricula = 1;
				$informacionExponer[$i]['doc_estado'] = "<img src='".base_url('assets/img/verde.jpg')."' width='45px'>";
												
			}else if($datosDocu[0]->doc_estado == 2){
				$banderaMatricula = 1;
				$informacionExponer[$i]['doc_estado'] = "<img src='".base_url('assets/img/naranja.jpg')."' width='45px'>";
				
			}else if($datosDocu[0]->doc_estado == 3){
				$banderaMatricula = 0;
				$informacionExponer[$i]['doc_estado'] = "<img src='".base_url('assets/img/rojo.jpg')."' width='45px'>";
				
			}									
			
			if($datosDocu[0]->observaciones != ''){
				$informacionExponer[$i]['observaciones'] =	utf8_decode($datosDocu[0]->observaciones);							
			}else{
				$informacionExponer[$i]['observaciones'] =	'';
			}	
			
			$informacionExponer[$i]['bandera'] = $banderaMatricula;
			// BOTON MATRICULAR
			if($banderaMatricula == 0){
					$informacionExponer[$i]['btn_matricula'] = "No cumple requisitos";
				}else{
					$informacionExponer[$i]['btn_matricula'] = "<button type='button' class='btn btn-info'>Matricular</button>";
					
				}
			
			
			//INFROMACION MATRICULA EXCEL
			$informacionExponer[$i]['id_usuario'] = $info_usuarios[$i]->id_usuario;
			
								
	}
	//array_multisort($informacionExponer['puntajeForm'], SORT_DESC, $informacionExponer['tiempo_experiencia'], SORT_DESC, $informacionExponer);
	
	foreach ($informacionExponer as $key => $row)
	{
	    $puntaje[$key]  = $row['puntajeForm'];
		$tiempo_exp[$key]  = $row['tiempo_experiencia'];
	}    
	
	// Sort the data with wek ascending order, add $mar as the last parameter, to sort by the common key
	
	array_multisort($puntaje, SORT_DESC, $tiempo_exp, SORT_DESC, $informacionExponer);
	
	$inscribir = 1;
	$maxInscritos = $info_requ[0]->max_inscri;
	$permite = '';
	$nopermite = '';
	$permiteArray = array();
	$nopermiteArray = array();
	for($m=0;$m<count($informacionExponer);$m++){
		
		if($informacionExponer[$m]['bandera'] == 1){
		
			if($inscribir <= $maxInscritos){
				
				$datosDocu = $this->convocatorias_model->actualizarMatricula($informacionExponer[$m]['id_usuario'], 'SI', $inscribir, $id_convocatoria, $id_conv_insc);	
				
				$inscribir++;
								
				$permite .= $informacionExponer[$m]['id_usuario']."-";
				$permiteArray[] = $informacionExponer[$m]['id_usuario'];	
				
				
			}else{
				
				$datosDocu = $this->convocatorias_model->actualizarMatricula($informacionExponer[$m]['id_usuario'], 'NO', 0, $id_convocatoria, $id_conv_insc);
				
				$nopermite .= $informacionExponer[$m]['id_usuario']."-";
				$nopermiteArray[] = $informacionExponer[$m]['id_usuario'];
			}
			
		}else{
			$nopermite .= $informacionExponer[$m]['id_usuario']."-";	
		}
		
	}	
	
}else{
	$inscribir = 0;
}

	?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <ul>
            	<li><b>Investigaci&oacute;n:</b> <?php echo utf8_decode($info_conv[0]->nombre_inv)?></li>
            	<li><b>Rol:</b> <?php echo utf8_decode($info_conv[0]->nombre_rol_inv)?></li>
            	<li><b>Ciudad:</b> <?php echo utf8_decode($info_conv[0]->nom_mpio)?></li>
            </ul>
            <div class="row">
            	<div class="col-md-8">
            		<div class="col-md-4">
	            		<b>Personas Inscritas:</b> <?php echo count($info_usuarios)?>
	            	</div>
	            	<div class="col-md-4">
	            		<?php if($_SESSION["rol"]!="6"){ ?>
	            		<b>Personas a Matricular:</b> <?php echo $info_requ[0]->max_inscri?>
	            		<?php }else{ ?>
	            		<form class="form-horizontal" enctype="multipart/form-data" role="form" action="<?php echo base_url('administrador/convocatorias/actualizarMaxMatricular/'.$id_convocatoria."/". $id_conv_insc) ?>" method="post">
	            			<b>Personas a Matricular:</b> <input type="text" size="4" maxlength="4" name="maximoMatricular" id="maximoMatricular" value="<?php echo $info_requ[0]->max_inscri?>">
	            			<button type="submit" class="btn btn-success">Actualizar Personas a matricular</button>
	            		</form>
	            		<?php }?>
	            	</div>
	            	<div class="col-md-4">
	            		<b>Personas a contratar:</b> <?php echo $info_requ[0]->total_personas?>
	            	</div>
            	</div>
            	<div class="col-md-4 text-right">
            		<?php
            		
            		if($inscribir > 0 && $maxInscritos >0){
            			?>
						<!--  <a class='btn btn-info' target="_blank" href='<?php echo base_url('administrador/convocatorias/crearArchivoMatricula/'. $id_convocatoria . '/' .$id_conv_insc) ?>'>
							<span class="glyphicon glyphicon-file" aria-hidden="true"> </span>  Matr&iacute;cula masiva
						</a> -->
						<?php 
						if($_SESSION["rol"]!="5"){
						?>
						<a class='btn btn-info' target="_blank" href='<?php echo base_url('administrador/convocatorias/crearArchivoMatricula/' . $permite . '/'. $id_convocatoria . '/' .$id_conv_insc) ?>'>
							<span class="glyphicon glyphicon-file" aria-hidden="true"> </span>  Matr&iacute;cula masiva
						</a>
						<?php 
						}
						?>
						<!--<a class='btn btn-danger' data-toggle="modal" data-target="#inscritosLiberar" href='<?php echo base_url('administrador/convocatorias/liberarUsuarios/' . $permite . '/'. $id_convocatoria . '/' .$id_conv_insc) ?>'>
							<span class="glyphicon glyphicon-user" aria-hidden="true"> </span>  Liberar usuarios
						</a>-->
						
						<!-- Modal -->
						<div class="modal fade bs-example-modal-lg" id="inscritosLiberar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						    	<form class="form-horizontal" role="form" id="formInscritosLiberar" action="<?php echo base_url('administrador/convocatorias/liberarUsuarios/' . $nopermite . '/'. $id_convocatoria . '/' .$id_conv_insc) ?>" name="formInscritosLiberar" method="post">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel">Hoja de vida '.utf8_decode($info_usuarios[$i]->nombres)." ".utf8_decode($info_usuarios[$i]->apellidos).'</h4>
							      </div>
							      <div class="modal-body">
							      	<div class="row">
										<div class="col-md-10 col-md-offset-1">
											<h5 style="text-align: center;"><strong>&iquest; Esta seguro que desea liberar los usuarios que no cumplen con requisitos para que pueda aplicar a otras convocatorias? </strong></h5>											
										</div>
									</div>
					      		  </div>
					      		  <div class="modal-footer">											        
									<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
									<button type="submit" class="btn btn-success">Aceptar</button> 
								  </div>
				      		  </form>
					        </div>
					      </div>
					    </div>
						
						
						<?
					}else{
						echo "Verifique los valores de personas a matricular";
					}            		
            		?>
            		
            	</div>
            	
            </div><br><br>            
            	<?php            	
            	if(count($info_usuarios) > 0){
            	?>	
            	<table id="tb_inscritos_admin" class="table table-bordered" width="100%" cellspacing="0">
            		<th>Usuario</th>
	            			<th>Hoja de Vida</th>
	            			<th>Estudios</th>
	            			<th>Experiencia</th>
	            			<!-- <th>Desempate</th> -->
	            			<th>Fecha Aplica</th>
	            			<th>Pre seleccionado</th>
	            			<th>Doc. Completo</th>
	            			<th>Observaciones</th>
	            			<th>Matriculado</th>
            		<?php
            		//var_dump($informacionE) 
            		for($j=0;$j < count($informacionExponer);$j++){
							
						if($informacionExponer[$j]['matriculado'] == 'SI'){							
							echo '<tr bgcolor= "#D8D8D8">';
						}else{
							echo "<tr>";
						}
            			?>
            			
							<td>
								<?php echo $informacionExponer[$j]['datos'];?>
							</td>
							<td>
								<?php echo $informacionExponer[$j]['hojavida'];?>
							</td>
							<td>
								<?php echo $informacionExponer[$j]['formacion'];?>							
							</td>
							<td>
								<?php echo $informacionExponer[$j]['experiencia'];?>
							</td>
							<td>
								<?php echo $informacionExponer[$j]['fecha_aplica'];?>
							</td>
							<td>
								<center>
									<?php echo $informacionExponer[$j]['cumple_req'];?>									
								</center>							
							</td>						
							<td>							
								<center>
									<?php echo $informacionExponer[$j]['doc_estado'];?>	
								</center>
							</td>
							<td>							
								<center>
									<?php echo $informacionExponer[$j]['observaciones'];?>	
								</center>
							</td>
							<td>
								<?php 
								if($informacionExponer[$j]['fecha_matriculado']!="0000-00-00 00:00:00"){
									echo $informacionExponer[$j]['fecha_matriculado'];
								}
								?>
							<!-- 
								<center>
								<?php /* echo $informacionExponer[$j]['btn_matricula']; */ ?>	
								</center>
								-->
							</td>
						</tr>
						<?php
            		}
            		
            		?>
            	</table>
            	
            	<?php
            }else{
            	echo "<center>NO HAY USUARIOS INSCRITOS</center>";
            }
            
            ?>
        </div>		
    </div>
</div>