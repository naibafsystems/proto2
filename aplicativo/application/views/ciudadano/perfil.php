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

ini_set("display_errors","0");

$hv = 20;
$class = 'progress-bar-danger';
if($datosUsuario[0]->rutaDI!= '')
{
	$hv = $hv + 20;
	$classhv = 'progress-bar-danger';
}

if(count($formacionUsuario)>0)
{
	$hv = $hv + 60;
	$classhv = 'progress-bar-warning';
}
/*
if(count($experienciaUsuario)>0)
{
	$hv = $hv + 30;
	$classhv = 'progress-bar-success';
}
*/
if($hv >= 0 && $hv <= 40)
{
	$classhv = 'progress-bar-danger';
}else if($hv >= 40 && $hv <= 80)
{
	$classhv = 'progress-bar-warning';
}else if($hv >= 80 && $hv <= 100)
{
	$classhv = 'progress-bar-success';
}

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
            $tiempoExperiencia = intval($anio)." A&ntilde;os  -  ".intval($mesExperiencia)." Meses";
    }else
        {
            $tiempoExperiencia = "0 A&ntilde;os  -  0 Meses";
        }
 
	
?>
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">

            <!-- Heading 
            ================================================== -->
		<div id="header" class="row">
            <div class="col-sm-3">
				<div class="col-sm-12">
				<?php
					if($datosUsuario[0]->id_avatar == 0)
					{
						?>
						<img class="propic" id="imgSalida" src="<?php echo base_url('assets/img/avatar.png')?>" width="200" alt="">
						<?php
					}else
					{						
						?>
						<img class="propic" id="imgSalida" src="<?php echo base_url('uploads/avatar/'.$datosUsuario[0]->nombA)?>" width="200" alt="">
						<?php
					}
				?>
                <div class="col-sm-10 col-md-offset-1" >	
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#cambiarAvatar">
				  <span class="glyphicon glyphicon-camera" aria-hidden="true"></span> Cambiar Imagen
				</button>
				</div>
				<div class="col-sm-12">
					<!--<a href="<?php echo base_url('ciudadano/principal/descargarHV/') ?>" target='_blank'>
					  <span class='glyphicon glyphicon-file' aria-hidden='true'></span> Descargar Hoja de Vida</a>
					</a>-->
				</div> 
				<div class="modal fade bs-example-modal-lg" id="cambiarAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Cambiar Imagen de Perfil</h4>
					  </div>
					  <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formCargaAvatar" action="<?php echo base_url('ciudadano/principal/cargaAvatar') ?>" name="formCargaAvatar" method="post">
					  <div class="modal-body">
							<div class="col-md-10 col-md-offset-1">
								<label class="control-label" for="textinput">Seleccione una imagen en formato JPG o PNG no mayor a 1Mb</label>
								<div class="form-group">
								  <div class="col-md-12">
									<input id="doc_avatar" name="doc_avatar" class="file file-loading validate[required]" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="true" data-show-remove="false" data-allowed-file-extensions='["jpg","png"]' >
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
				</div>
            </div>
			
            <!-- photo end-->
            <div class="col-sm-6">
                <div class="cv-title">
                    <div class="row">
                        <div class="col-sm-7">
                            <h3><?php echo utf8_decode($datosUsuario[0]->nombres)." ".utf8_decode($datosUsuario[0]->apellidos);?></h3>
                        </div>                        
                    </div>
                    <h6><b>N&uacute;mero de identificaci&oacute;n: </b><?php echo $datosUsuario[0]->nume_iden?></h6>
                    <h6><b>Nacionalidad: </b><?php echo $datosUsuario[0]->desc_pais?></h6>
                    <h6><b>Fecha de nacimiento: </b><?php echo date($datosUsuario[0]->fecha_naci)?></h6>
                    <h6><b>T&eacute;lefono: </b><?php echo $datosUsuario[0]->telefono?></h6>
                    <h6><b>Celular: </b><?php echo $datosUsuario[0]->celular?></h6>
                    <h6><b>Sexo: </b><?php echo $datosUsuario[0]->desc_gene?></h6>
                    <h6><b>Correo electr&oacute;nico principal: </b><?php echo $datosUsuario[0]->usuario?></h6>
                    <h6><b>Correo electr&oacute;nico secundario: </b><?php echo $datosUsuario[0]->email2?></h6>
                    <h6><b>Hoja de vida actualizada en el SIGEP: </b><?php if($datosUsuario[0]->sigep == "S"){echo "SI";}else{echo "NO";}?></h6>
                    <h6><b>Tiempo de experiencia: <a data-toggle="modal" data-target="#myModal"></b><?php echo $tiempoExperiencia?></h6></a>
                </div>                
            </div>
            
            <!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Experiencia</h4>
			      </div>
			      <div class="modal-body">
			        <?php
			        
			        if(isset($expEnCuenta) && count($expEnCuenta) > 0){
			        	?>
			        	
			        	<table class="table">
			        		<tr>
			        			<th>Empresa</th>
				        		<th>Fecha ingreso</th>
				        		<th>Fecha retiro</th>
				        		<th>Experiencia</th>	
			        		</tr>			        		
			        		<?php
			        		
			        		for($ex=0;$ex<count($expEnCuenta);$ex++)
			        		{
			        			echo "<tr>";
									echo "<td>".utf8_decode($expEnCuenta[$ex]['empresa'])."</td>";
									echo "<td>".$expEnCuenta[$ex]['fechaIngreso']."</td>";
									echo "<td>".$expEnCuenta[$ex]['fechaRetiro']."</td>";
									echo "<td>".$expEnCuenta[$ex]['experiencia']."</td>";
								echo "</tr>";
			        		}
			        		
			        		?>
			        	</table>
			        	<?php
			        }
			        
			        ?>
			      </div>
			    </div>
			  </div>
			</div>
            
			<div class="col-sm-3">
				<div class="row">
                    <div class="col-sm-12">
						<b>Hoja de Vida</b>
                        <div class="progress">
						  <div class="progress-bar <?= $classhv?>  progress-bar-striped" role="progressbar"
						  aria-valuenow="<?php echo $hv?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $hv?>%">
							<?php echo $hv?>%
						  </div>
						</div>
                    </div>                  
                </div>
				<div class="row">
                    <div class="col-sm-10 col-md-offset-1">
						<a href="<?php echo base_url('ciudadano/principal/modificarBasica/') ?>" class="btn btn-info">
						  <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Actualizar Datos
						</a>
                    </div>                  
                </div>
				<div class="row">
                    <div class="col-lg-12">
						<?php
							if($datosUsuario[0]->rutaDI != '')
							{
                                echo "<br><a href='".base_url('uploads/'.$datosUsuario[0]->nombDI)."' target='_blank'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Documento Identificaci&oacute;n</a>";
                            }else{
                                echo "<br><span class='glyphicon glyphicon-file' aria-hidden='true'></span><font color='red'> Falta Documento Identificaci&oacute;n</font>";
                            }
						?>
                    </div>                  
                </div>
				<div class="row">
                    <div class="col-lg-12">
						<?php
						/*if($datosUsuario[0]->genero == 'M' || $datosUsuario[0]->genero == 'F')
						{
							if($datosUsuario[0]->rutaLM != '')
							{
                                echo "<br><a href='".base_url('uploads/'.$datosUsuario[0]->nombLM)."' target='_blank'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Libreta Militar</a>";
                            }else{
                                echo "<br><span class='glyphicon glyphicon-file' aria-hidden='true'></span><font color='red'> Falta Libreta Militar</font>";
                            }
						}	*/						
						?>
                    </div>                  
                </div>
			</div>
        </div><!-- header end-->		

        <div class="panel panel-default">
			<div class="panel-heading text-right">
				<div class="nav">				
					<div class="btn-group pull-left" data-toggle="buttons">
					  <label>
						Formaci&oacute;n acad&eacute;mica
					  </label>
					</div>

					<div class="btn-group pull-right" data-toggle="buttons">					  
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalFormacion">
						  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>A&ntilde;adir
						</button>
					</div>
				</div>
			</div>
		  <div class="panel-body">
			 <div class="table-responsive">
			  <table class="table table-hover">
				<?php
				if(count($formacionUsuario)>0)
				{
					/*echo "<pre>";
					print_r($formacionUsuario);
					echo "</pre>";*/
					for($i=0;$i<count($formacionUsuario);$i++)
					{
						?>
						<tr>
							<td width="80%">
							<?php
								if($formacionUsuario[$i]->id_programa > 0)
								{
									echo "<b>".utf8_decode($formacionUsuario[$i]->desc_programa)."</b><br>";
								}
								
								echo "<b>Nivel:".utf8_decode($formacionUsuario[$i]->descripcion)."</b>";
								
								echo "<br>".$formacionUsuario[$i]->semestres." Semestres o cursos aprobados";	
																
								if($formacionUsuario[$i]->id_nivel < 8 && $formacionUsuario[$i]->graduado == 'S' )
								{
									echo "<br>Fecha de grado: ".$formacionUsuario[$i]->fechaTermina;
								}
								
								if($formacionUsuario[$i]->fechaTermina != '0000-00-00')
								{
									echo "<br>Fecha de terminaci&oacute;n: ".$formacionUsuario[$i]->fechaTermina;
								}
																
								if($formacionUsuario[$i]->rutaF != '')
								{
									echo "<br><a href='".base_url('uploads/'.$formacionUsuario[$i]->nombF)."' target='_blank'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Soporte</a>";
								}
								if($formacionUsuario[$i]->rutaT != '')
								{
									echo "<br><a href='".base_url('uploads/'.$formacionUsuario[$i]->nombT)."' target='_blank'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver tarjeta profesional</a>";
								}
								$idActualizar = strrev(base64_encode($formacionUsuario[$i]->id_formacion));
							?>
							</td>							
							<td class="text-right">
								<a type="button" class="btn btn-info" href="<?php echo base_url('ciudadano/principal/modificarFormacion/'.$idActualizar) ?>">
								  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modificar
								</a>
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelFormacion-<?php echo $formacionUsuario[$i]->id_formacion?>">
								  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar
								</button>
								<div class="modal fade bs-example-modal-lg" id="modalDelFormacion-<?php echo $formacionUsuario[$i]->id_formacion?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Borrar Formaci&oacute;n Acad&eacute;mica</h4>
									  </div>
									  <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formEliminarForm" action="<?php echo base_url('ciudadano/principal/borrarFormacion/'.$formacionUsuario[$i]->id_formacion) ?>" name="formEliminarForm" method="post">
									  <div class="modal-body">
											Seguro quiere eliminar este registro de formaci&oacute;n acad&eacute;mica
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
										<button type="submit" class="btn btn-success" >Aceptar</button>
									  </div>
									  </form>
									</div>
								  </div>
								</div>
							</td>
						</tr>
						<?php
					}
				}else
				{
					echo "No se encontraron registros";
				}
				?>
			  </table>
			</div> 
		  </div>
		</div>   
		
		
		<div class="panel panel-default">
			<div class="panel-heading text-right">
				<div class="nav">				
					<div class="btn-group pull-left" data-toggle="buttons">
					  <label>
						Experiencia laboral
					  </label>
					</div>

					<div class="btn-group pull-right" data-toggle="buttons">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalExperiencia">
						  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>A&ntilde;adir
						</button>
					</div>
				</div>
			</div>
		  <div class="panel-body">
			<div class="table-responsive">
			  <table class="table table-hover">
				<?php
				if(count($experienciaUsuario)>0)
				{
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
						?>
						<tr>
							<td width="80%">
							<?php
								echo "<b>".utf8_decode($experienciaUsuario[$j]->empresa)."</b><br>";
								echo utf8_decode($experienciaUsuario[$j]->cargo)." - ".utf8_decode($experienciaUsuario[$j]->dependencia)."<br>";
								echo $experienciaUsuario[$j]->direccion."<br>";
								echo $experienciaUsuario[$j]->telefono."<br>";
								echo "Fecha de Ingreso: ".$experienciaUsuario[$j]->fecha_ingreso."    Fecha de Retiro: ".$fechaRetiro."<br>";
								
								$fechainicial = new DateTime($experienciaUsuario[$j]->fecha_ingreso);
								$fechafinal = new DateTime($fechaCalcular);
								
								$diferencia = $fechainicial->diff($fechafinal);
								
								$años = $diferencia->y;
								$meses = $diferencia->m;
								$dias = $diferencia->d;								
								$diasExperiencia = $años." A&ntilde;os - ".$meses." Meses - ".$dias." Dias ";							
								
								echo "<b>Experiencia: ".$diasExperiencia."</b><br>";
								
								if($experienciaUsuario[$j]->rutaE != '')
								{
									echo "<a href='".base_url('uploads/'.$experienciaUsuario[$j]->nombE)."' target='_blank'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Ver Soporte</a> <br>";
								}
								
								$idActualizarExp = strrev(base64_encode($experienciaUsuario[$j]->id_experiencia));
							?>
							</td>
							<td class="text-right">
								<a type="button" class="btn btn-info" href="<?php echo base_url('ciudadano/principal/modificarExperiencia/'.$idActualizarExp) ?>">
								  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modificar
								</a>
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelExperiencia-<?php echo $experienciaUsuario[$j]->id_experiencia?>">
								  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar
								</button>
								<div class="modal fade bs-example-modal-lg" id="modalDelExperiencia-<?php echo $experienciaUsuario[$j]->id_experiencia?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Borrar Experiencia Laboral</h4>
									  </div>
									  <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formEliminarExp" action="<?php echo base_url('ciudadano/principal/borrarExperiencia/'.$experienciaUsuario[$j]->id_experiencia) ?>" name="formEliminarExp" method="post">
									  <div class="modal-body">
											Seguro quiere eliminar este registro de experiencia laboral	
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
										<button type="submit" class="btn btn-success" >Aceptar</button>
									  </div>
									  </form>
									</div>
								  </div>
								</div>
							</td>
						</tr>
						<?php
					}
				}else
				{
					echo "No se encontraron registros";
				}
				?>
			  </table>
			</div> 
		  </div>
		</div> 		 
	</div>		
</div>
</div>

<!-- Modal de Formacion Academica -->
		<div class="modal fade bs-example-modal-lg" id="modalFormacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Formaci&oacute;n Acad&eacute;mica</h4>
			  </div>
			  <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formFormacion" action="<?php echo base_url('ciudadano/principal/guardarFormacion') ?>" name="formFormacion" method="post">
			  <div class="modal-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									  <div class="col-md-12">
										<label class="control-label" for="nivel">Nivel de estudios</label>
										<select id="nivel" name="nivel" class="form-control validate[required]">
										  <option value="">Seleccione...</option>
										  <?php
											for($n=0;$n<count($niveles);$n++)
											{
												echo "<option value='".$niveles[$n]->id_nivel."'>".utf8_decode($niveles[$n]->descripcion)."</option>";
											}
										  ?>
										</select>
									  </div>
								</div>																
							</div>
							<div class="col-md-4">								
								<div class="form-group" id="div_semestres">
									  <div class="col-md-12">
										<label class="control-label" for="nivel">Semestres o cursos aprobados</label>
										<select id="semestres" name="semestres" class="form-control validate[required]">
										  <option value="">Seleccione...</option>
										  <?php
											for($ns=1;$ns <= 11;$ns++)
											{
												echo "<option value='".$ns."'>".$ns."</option>";
											}
										  ?>
										</select>
									  </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group" id="div_graduado">								  
								  <label class="control-label" for="graduado">Graduado</label>
								  <div class="radio">
									<label for="graduado-0">
									  <input class="validate[required]" type="radio" name="graduado" id="graduado" value="S">
										Si
									</label>									
									<label for="graduado-1">
									  <input class="validate[required]" type="radio" name="graduado" id="graduado" value="N">
									  No
									</label>
									</div>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group" id="div_modalidad">
									  <div class="col-md-12">
										<label class="control-label" for="nivel">Modalidad</label>
										<select id="modalidad" name="modalidad" class="form-control validate[required]">
										  <option value="">Seleccione...</option>
										  <?php
											for($m=0;$m<count($modalidades);$m++)
											{
												echo "<option value='".$modalidades[$m]->id_modalidad."'>".utf8_decode($modalidades[$m]->desc_modalidad)."</option>";
											}
										  ?>
										</select>
									  </div>
								</div>								
							</div>							
							<div class="col-md-3">
								<div class="form-group"  id="div_areacono">
									  <div class="col-md-12">
										<label class="control-label" for="areas">Nucleo de conocimiento</label>
										<select id="areas" name="areas" class="form-control validate[required]">
										  <option value="">Seleccione...</option>
										  <?php
											for($a=0;$a<count($areas);$a++)
											{
												echo "<option value='".$areas[$a]->id_areacono."'>".utf8_decode($areas[$a]->desc_areacono)."</option>";
											}
										  ?>
										</select>
									  </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group" id="div_programa">
									  <div class="col-md-12">
										<label class="control-label" for="programa">Programa acad&eacute;mico</label>
										<select id="programa" name="programa" class="form-control validate[required]" style="width: 100%">
										  <option value="">Seleccione area de conocimiento y nivel...</option>
										</select>
									  </div>
								</div>
							</div>
						</div>
						<br>
						<div id="div_valGraduado">
                            <div class="row">							
                                <div class="col-md-6" id="div_fechatermi">
                                        <label class="control-label" for="textinput">Fecha de terminaci&oacute;n</label>
                                        <div class="form-group">
                                          <div class="col-md-10 col-md-offset-1 input-group input-append date" id="datePicker">
                                                <input type="text" class="form-control validate[required,past[#fechaTarj]]" name="fechaTerm" id="fechaTerm" readonly />
                                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                          </div>
                                        </div>
                                </div>
                                <div class="col-md-6" id="div_fechatarje">
                                        <label class="control-label" for="textinput">Fecha de expedici&oacute;n tarjeta profesional</label>
                                        <div class="form-group">
                                          <div class="col-md-10 col-md-offset-1 input-group input-append date" id="datePicker">
                                                <input type="text" class="form-control validate[required,future[#fechaTerm]]" name="fechaTarj" id="fechaTarj" readonly />
                                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                          </div>
                                        </div>
                                </div>		
						</div>
						</div>
						<div class="row">
							<div class="col-md-6" id="div_sopforma">
								<label class="control-label" for="textinput">Soporte formaci&oacuten acad&eacute;mica</label>
								<span class='glyphicon glyphicon-info-sign' aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Documentos permitidos: PDF no mayor a 1Mb"></span>
								<div class="form-group">
								  <div class="col-md-12">
									<input id="doc_formacion" name="doc_formacion" class="file  file-loading validate[required]" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-show-remove="false" data-allowed-file-extensions='["pdf"]' >
								  </div>
								</div>
							</div>
							<div class="col-md-6" id="div_soptarje">
								<label class="control-label" for="textinput">Soporte tarjeta profesional</label>
								<span class='glyphicon glyphicon-info-sign' aria-hidden='true' data-toggle="tooltip" data-placement="left" title="Documentos permitidos: PDF no mayor a 1Mb"></span>
								<div class="form-group">
								  <div class="col-md-12">
									<input id="doc_tarjeta" name="doc_tarjeta" class="file  file-loading" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-show-remove="false" data-allowed-file-extensions='["pdf"]' >
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
		
		
		<!-- Modal de Experiencia -->
		<div class="modal fade bs-example-modal-lg" id="modalExperiencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabelExp">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabelExp">Experiencia laboral</h4>
				<h6><font color="red">Los datos de experiencia se deben suministrar por cada uno de los contratos realizados. Por favor adjunte certificados laborales</font></h6>
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
									<label class="control-label" for="nivel">Tipo empresa</label>
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
											for($m=0;$m<count($paises);$m++)
											{
												if($paises[$m]->codi_pais == 'COL'){
													$seleccionado = 'selected';
												}else{
													$seleccionado = '';
												}
												echo "<option value='".$paises[$m]->codi_pais."' ".$seleccionado.">".utf8_decode($paises[$m]->desc_pais)."</option>";
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
											for($n=0;$n<count($departamento);$n++)
											{
												echo "<option value='".$departamento[$n]->id_depto."'>".utf8_decode($departamento[$n]->nom_depto)."</option>";
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
											for($a=0;$a<count($municipio);$a++)
											{
												echo "<option value='".$municipio[$a]->id_areacono."'>".utf8_decode($municipio[$a]->desc_areacono)."</option>";
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
										<label class="control-label" for="nivel">Correo electr&oacute;nico entidad</label>
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
										<label class="control-label" for="textinput">Fecha de ingreso</label>
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
								<label class="control-label" for="textinput">Adjuntar soporte</label>
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
		
		
		