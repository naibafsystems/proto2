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
			$diasExperiencia = $aniosE." A�os - ".$mesesE." Meses - ".$diasE." Dias ";
				
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
				
			$experienciaT = intval($anio)." A�os  -  ".intval($mesExperiencia)." Meses";
			//$informacionExponer[$i]['experiencia'] = print_r($dias);
			$tiempo_experiencia = $mesesExperiencia;
						
		}else{
		$mesExperiencia = 0;
		$mesesExperiencia = 0;
		$experienciaT = "Sin experiencia";
		//$informacionExponer[$i]['experiencia'] = print_r($dias);
		$tiempo_experiencia = $mesesExperiencia;
		}
			
		
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
									  				
									  			$años = $diferencia->y;
									  			$meses = $diferencia->m;
									  			$dias = $diferencia->d;
									  			$diasExperiencia = $años." A&ntilde;os - ".$meses." Meses - ".$dias." Dias ";
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
									  		$informacionExponer[$i]['hojavida'] .= '<center><b>Sin Experiencia</b></center>';
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
				if(count($experienciaUsuario)>0){
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
					$informacionExponer[$i]['experiencia'] = "Sin experiencia";
					//$informacionExponer[$i]['experiencia'] = print_r($dias);
					$informacionExponer[$i]['tiempo_experiencia'] = 0;
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
				$verifComple = 0;
				$informacionExponer[$i]['doc_estado'] = "";
				
			}else if($datosDocu[0]->doc_estado == 1){
				$banderaMatricula = 1;
				$verifComple = 1;
				$informacionExponer[$i]['doc_estado'] = "<img src='".base_url('assets/img/verde.jpg')."' width='45px'>";
												
			}else if($datosDocu[0]->doc_estado == 2){
				$banderaMatricula = 1;
				$verifComple = 1;
				$informacionExponer[$i]['doc_estado'] = "<img src='".base_url('assets/img/naranja.jpg')."' width='45px'>";
				
			}else if($datosDocu[0]->doc_estado == 3){
				$banderaMatricula = 0;
				$verifComple = 1;
				$informacionExponer[$i]['doc_estado'] = "<img src='".base_url('assets/img/rojo.jpg')."' width='45px'>";
				
			}									
			
			if($datosDocu[0]->observaciones != ''){
				$informacionExponer[$i]['observaciones'] =	utf8_decode($datosDocu[0]->observaciones);							
			}else{
				$informacionExponer[$i]['observaciones'] =	'';
			}	
			
			$informacionExponer[$i]['bandera'] = $banderaMatricula;
			$informacionExponer[$i]['verifDoc'] = $verifComple;
			// BOTON MATRICULAR
			if($banderaMatricula == 0){
					$informacionExponer[$i]['btn_matricula'] = "No cumple requisitos";
				}else{
					$informacionExponer[$i]['btn_matricula'] = "Cumple requisitos";
					
				}
			
			
			//INFROMACION MATRICULA EXCEL
			$informacionExponer[$i]['id_usuario'] = $info_usuarios[$i]->id_usuario;
			$informacionExponer[$i]['nombres'] = strtoupper(utf8_decode($info_usuarios[$i]->nombres));
			$informacionExponer[$i]['apellidos'] = strtoupper(utf8_decode($info_usuarios[$i]->apellidos));
			
								
	}
	//array_multisort($informacionExponer['puntajeForm'], SORT_DESC, $informacionExponer['tiempo_experiencia'], SORT_DESC, $informacionExponer);
	
	foreach ($informacionExponer as $key => $row)
	{
	    $puntaje[$key]  = $row['puntajeForm'];
		$tiempo_exp[$key]  = $row['tiempo_experiencia'];
		$bandera[$key]  = $row['bandera'];
	}    
	
	// Sort the data with wek ascending order, add $mar as the last parameter, to sort by the common key
	
	array_multisort($puntaje, SORT_DESC, $tiempo_exp, SORT_DESC, $bandera, SORT_DESC, $informacionExponer);
	
	$inscribir = 1;
	$maxInscritos = $info_requ[0]->max_inscri;
	$permite = '';
	$nopermite = '';
	
	for($m=0;$m<count($informacionExponer);$m++){
		
		if($informacionExponer[$m]['bandera'] == 1){
		
			if($inscribir <= $maxInscritos){
				$inscribir++;
								
				$permite .= $informacionExponer[$m]['id_usuario']."-";			
			}else{
				$nopermite .= $informacionExponer[$m]['id_usuario']."-";
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
        <div class="col-md-12">
        	<div class="row">
        		<div class="col-md-5">
            		<ul>
		            	<li><b>Investigaci&oacute;n:</b> <?php echo utf8_decode($info_conv[0]->nombre_inv)?></li>
		            	<li><b>Rol:</b> <?php echo utf8_decode($info_conv[0]->nombre_rol_inv)?></li>
		            	<li><b>Ciudad:</b> <?php echo utf8_decode($info_conv[0]->nom_mpio)?></li>
		            </ul>
            	</div>
            	<div class="col-md-5">
            		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalleConv">
						<span class="glyphicon glyphicon-search" aria-hidden="true"> </span> Ver detalle convocatoria
				  	</button>
            	</div>
            	<!-- Modal -->
				<div class="modal fade bs-example-modal-lg" id="detalleConv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel"><?php echo utf8_decode($info_conv[0]->nombre_inv)?></h4>
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
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				      </div>
				    </div>
				  </div>
				</div>
        	</div>
            
            <div class="row">
            	<div class="col-md-10">
            		<div class="col-md-3">
	            		<b>Personas Inscritas:</b> <?php echo count($info_usuarios)?>
	            	</div>
	            	<div class="col-md-3">
	            		<b>Personas a Matricular:</b> <?php echo $info_requ[0]->max_inscri?>
	            	</div>
	            	<div class="col-md-3">
	            		<b>Personas a contratar:</b> <?php echo $info_requ[0]->total_personas?>
	            	</div>
	            	<div class="col-md-3">
	            		<!--<a class='btn btn-danger' data-toggle="modal" data-target="#inscritosLiberar" >
							<span class="glyphicon glyphicon-user" aria-hidden="true"> </span>  Liberar usuarios
						</a>-->
						
						<!-- Modal -->
						<!--<div class="modal fade bs-example-modal-lg" id="inscritosLiberar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						    	<form class="form-horizontal" role="form" id="formInscritosLiberar" action="<?php echo base_url('coordinador/principal/liberarUsuarios/' . $nopermite . '/'. $id_convocatoria . '/' .$id_conv_insc) ?>" name="formInscritosLiberar" method="post">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel">Liberar usuarios convocatorias</h4>
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
					 </div>-->
	            	</div>
            	</div>           	
            	
            </div><br><br>
            
            <?php
            
            if(count($info_usuarios) > 0){
            	?>
            	
            	<table id="tb_inscritoss" class="table table-striped table-bordered" width="100%" cellspacing="0">
            		<thead>
            			<tr>
	            			<th>Persona</th>
	            			<th>Hoja de Vida</th>
	            			<th>Estudios</th>
	            			<!--<th>Experiencia</th>-->	            			
							<th>Estado</th>
							<th>Observaci&oacute;n</th>
							<th>Requisitos</th>
	            			<th>Validar Documentos</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php
            		
            		for($j=0;$j < count($informacionExponer);$j++){
            			
						
            			?>
            			<tr>
							<td>
								<?php echo $informacionExponer[$j]['datos'];?>
							</td>
							<td>
								<?php echo $informacionExponer[$j]['hojavida'];?>
							</td>
							<td>
								<?php echo $informacionExponer[$j]['formacion'];?>							
							</td>
							<!--<td>
								<?php echo $informacionExponer[$j]['experiencia'];?>
							</td>-->
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
								<center>
									<?php echo $informacionExponer[$j]['btn_matricula'];?>	
								</center>
							</td>
							<td>
								<?php
								//echo $informacionExponer[$j]['bandera'];
								if($informacionExponer[$j]['verifDoc'] == 0){
									?>
									
									<center>
								
									<a href="#" class="btn btn-info" data-toggle="modal" data-target="#validarDoc<?php echo $informacionExponer[$j]['id_usuario']?>">
										Verificar
									</a>
									<?php
									
									$url = 'coordinador/principal/actualizarDoc/'.$id_convocatoria.'/'.$id_conv_insc.'/'.$informacionExponer[$j]["id_usuario"];
									
									?>								
									</center>
								
									<div class="modal fade bs-example-modal-lg" id="validarDoc<?php echo $informacionExponer[$j]['id_usuario']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									  <div class="modal-dialog modal-lg" role="document">
									    <div class="modal-content">
										<form class="form-horizontal" role="form" id="formInscritosCoor" action="<?php echo base_url($url);?>" name="formInscritosCoor" method="post">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Validaci&oacute;n Documentos <?php echo $informacionExponer[$j]['nombres']." ".$informacionExponer[$j]['apellidos'];?></h4>
										  </div>
										  <div class="modal-body">
										  		<div class="row">
										  			<div class="col-md-10 col-md-offset-1 text-center">
										  				<b>Documentos completos?</b>								  				
										  			</div>								  			
										  		</div>
												<div class="row">
													<div class="col-md-10 col-md-offset-1">
														<div class="col-md-4 text-center">
															<input type="radio" id="documentos" class="validate[required]" name="documentos" value="1" <?php if($informacionExponer[$j]['doc_estado'] == '1'){echo "checked";}?>>
															<b>SI </b>
														</div>
														<div class="col-md-4 text-center">
															<input type="radio" id="documentos" class="validate[required]"  name="documentos" value="3" <?php if($informacionExponer[$j]['doc_estado'] == '3'){echo "checked";}?>>
															<b>NO</b>
														</div>															
													</div>		
												</div>
												<div class="row">
													<div class="col-md-3">
														<b>Observaciones: </b>
													</div>	
													<div class="col-md-5">
														<textarea id="observaciones" name="observaciones" rows="5" cols="55" class="form-control validate[required,minSize[20]]" ></textarea>
													</div>
												</div>										
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
											<button type="submit" class="btn btn-success">Actualizar</button>
										  </div>	
										</form>	
									    </div>
									  </div>
									</div>
									
									<?php
								}else{
									?>
									<center>
										Documentos ya validados
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
            	
            	<?php
            }else{
            	echo "<center>NO HAY USUARIOS INSCRITOS</center>";
            }
            
            ?>
            
            
            
            
        </div>		
    </div>
</div>


