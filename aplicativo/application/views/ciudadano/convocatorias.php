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

if($hv == 100){
	
	
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

            }

            $mesesExperiencia = $dias/30;
            
    }else
        {
            $mesesExperiencia = 0;
        }

?>

<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="memberModalLabel">Advertencia</h4>
      </div>
      <div class="modal-body">
      	<p>
        	Se&ntilde;or usuario recuerde leer con atenci&oacute;n los detalles de las convocatorias a las que desee aplicar, toda vez que si comete un error en su inscripci&oacute;n este ser&aacute; atendido durante los quince d&iacute;as h&aacute;biles que le corresponde a una PQR.
        </p>	
    	<p>Gracias</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="container">	
    <div class="row">
        <div class="col-md-12">
        	<div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
		        	<ul id="tabs" class="nav nav-tabs nav-justified" data-tabs="tabs">
				        <li><a href="#participando" data-toggle="tab">Convocatorias en las que estoy participando</a></li>
				        <li class="active"><a href="#abiertas" data-toggle="tab">Convocatorias Abiertas</a></li>
				        <?php
				        if (count($conv_cerradas) > 0) {
            			?>
				        <li><a href="#cerradas" data-toggle="tab">Convocatorias Cerradas</a></li>
				        <?php
				        }
						?>
				    </ul>
			    </div>
			    <div class="panel-body">
				    <div id="my-tab-content" class="tab-content">
				        <div class="tab-pane" id="participando">
				            <h3>Convocatorias en las que estoy participando</h3>
				            <div class="row">
		                        <div class="table-responsive">
		                            <table class="table table-striped" id="ciud_part">
		                            	
		                                <?php
		                                if (count($conv_participando)>0) {
		                                	?>
		                                	<thead>
		                                		<tr>
				                            		<th>Investigaci&oacute;n</th>
				                            		<th>Rol</th>
				                            		<th>Ciudad de convocatoria</th>
				                            <!--		<th>Fecha inicio convocatoria</th>
				                            		<th>Fecha fin convocatoria</th> -->
				                            		<th>Contrato</th>
				                            		<th>Detalle</th>
				                            		<th>Estado</th>
				                            	</tr>
		                                	</thead>
		                                	<tfoot>
		                                		<tr>
				                            		<th>Investigaci&oacute;n</th>
				                            		<th>Rol</th>
				                            		<th>Ciudad de convocatoria</th>
				                            	<!--	<th>Fecha inicio convocatoria</th>
				                            		<th>Fecha fin convocatoria</th>  -->
				                            		<th>Contrato</th>
				                            		<th>Detalle</th>
				                            		<th>Estado</th>
				                            	</tr>
		                                	</tfoot>
		                                	<tbody>
		                                	<?php
		                                    for ($p = 0; $p < count($conv_participando); $p++) {
		                                        ?>
		                                        <tr>
		                                        	<td width="30%"><?php echo utf8_decode($conv_participando[$p]->nombre_inv) ?></td>
			                                        <td width="20%"><?php echo utf8_decode($conv_participando[$p]->nombre_rol_inv) ?></td>
			                                        <td width="10%"><?php echo utf8_decode($conv_participando[$p]->nom_mpio)?></td>
			                                    <!--    <td width="10%"><?php /* echo $conv_participando[$p]->fecha_inicio?></td>
			                                        <td width="10%"><?php echo $conv_participando[$p]->fecha_fin */ ?></td>  -->
			                                        <td><?php echo utf8_decode($conv_participando[$p]->honorarios)?></td>
			                                        <td width="10%">
			                                        	<!-- Button trigger modal -->
														<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalle<?php echo $conv_participando[$p]->id_convocatoria?>">
														  <span class="glyphicon glyphicon-search" aria-hidden="true"> </span> Ver detalle
			                                        </td>
		                                            <td width="10%">
		                                                <span class="glyphicon glyphicon-repeat" aria-hidden="true" style="color: green"> </span>  En proceso<br>
		                                            </td>
		                                        </tr>
		                                        
		                                        <!-- Modal -->
												<div class="modal fade bs-example-modal-lg" id="detalle<?php echo $conv_participando[$p]->id_convocatoria?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog modal-lg" role="document">
												    <div class="modal-content">
												      <div class="modal-header">
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												        <h4 class="modal-title" id="myModalLabel"><?php echo utf8_decode($conv_participando[$p]->nombre_inv)?></h4>
												      </div>
												      <div class="modal-body">
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Investigaci&oacute;n</b></div>
			                            						<div class="col-md-9"><?php echo utf8_decode($conv_participando[$p]->nombre_inv)?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Rol</b></div>
			                            						<div class="col-md-9"><?php echo utf8_decode($conv_participando[$p]->nombre_rol_inv)?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Fecha de inicio</b></div>
			                            						<div class="col-md-9"><?php echo $conv_participando[$p]->fecha_inicio?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Fecha de finalizaci&oacute;n</b></div>
			                            						<div class="col-md-9"><?php echo $conv_participando[$p]->fecha_fin?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Honorarios o Salario</b></div>
			                            						<div class="col-md-9"><?php echo $conv_participando[$p]->honorarios?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="panel panel-primary">
																  <div class="panel-heading">Perfil</div>
																  <div class="panel-body">
																    <?php echo utf8_decode($conv_participando[$p]->perfil)?>
																  </div>
																</div>                            						
			                            					</div>
			                            					<div class="row">
			                            						<div class="panel panel-primary">
																  <div class="panel-heading">Objeto</div>
																  <div class="panel-body">
																    <?php echo utf8_decode($conv_participando[$p]->objeto)?>
																  </div>
																</div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="panel panel-primary">
																  <div class="panel-heading">Obligaciones</div>
																  <div class="panel-body">
																    <?php echo utf8_decode($conv_participando[$p]->obligaciones)?>
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
		                                        
		                                        <?php
		                                    }
		                                } else {
		                                    ?>
		                                    <tr>
		                                        <td>
		                                            <center><span class="glyphicon glyphicon-remove-sign" aria-hidden="true" style="color: red"> </span> No tiene participaci&oacute;n en ninguna convocatoria<br></center>
		                                        </td>
		                                    </tr>
		                                    <?php
		                                }
		                                ?>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
				        </div>
				        <div class="tab-pane active" id="abiertas">
				            <h3>Convocatorias Abiertas</h3>
				            <?php
							
							if (count($conv_participando)>0) {
								?>
								<center><h2>Ya se encuentra participando en una convocatoria</h2></center>
								<?php
							}else{
							?>
		                    <div class="row">
		                        <div class="table-responsive">
		                            <table class="table table-striped" id="ciud_abie">
		                            	<thead>
		                            		<tr>
			                            		<th>Investigaci&oacute;n</th>
			                            		<th>Rol</th>
			                            		<th>Ciudad de convocatoria</th>
			                           <!-- 		<th>Fecha inicio convocatoria</th>
			                            		<th>Fecha fin convocatoria</th>  -->
			                            		<th>Contrato</th>
			                            		<th>Detalle</th>
			                            		<th>Aplicar</th>
			                            	</tr>
		                            	</thead>
		                            	<tfoot>
								            <tr>
			                            		<th>Investigaci&oacute;n</th>
			                            		<th>Rol</th>
			                            		<th>Ciudad de convocatoria</th>
			                            	<!--	<th>Fecha inicio convocatoria</th>
			                            		<th>Fecha fin convocatoria</th>  -->
			                            		<th>Contrato</th>
			                            		<th>Detalle</th>
			                            		<th>Aplicar</th>
			                            	</tr>
								        </tfoot>
		                            	<tbody>
		                                <?php
		                                $operativo_ant="";
		                                
		                                for ($i = 0; $i < count($conv_abiertas); $i++) {
		                                	if(($operativo_ant != $conv_abiertas[$i]->operativo || $ciudad_ant != $conv_abiertas[$i]->id_ciudad) || $bandera==0){									
												$bandera = 0;
												$banderaF = 0;
												
												if(($conv_abiertas[$i]->fecha_inicio <= date('Y-m-d')) && ($conv_abiertas[$i]->fecha_fin >= date('Y-m-d'))){
													
													for($f=0;$f<count($formacionUsuario);$f++){
													/*	
													echo "<br>Bandera: ".$banderaF;
													echo "<br>Meses Expe: ".$mesesExperiencia;
													echo "<br>Conv Expe: ".$conv_abiertas[$i]->tiempo;
													*/
														//echo "//**".$formacionUsuario[$f]->id_nivel."<br>";
														//echo $conv_abiertas[$i]->id_nivel."--------<br>";
														switch($conv_abiertas[$i]->id_nivel){
															case 1:
																if($formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 8 || $formacionUsuario[$f]->id_nivel == 10 /* || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 10*/){
																	
																	if($formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 8 || $formacionUsuario[$f]->id_nivel == 10)
																	{
																		if($conv_abiertas[$i]->semestres != 0){
																			if($formacionUsuario[$f]->semestres >= $conv_abiertas[$i]->semestres || $bandera == 1 || $banderaF == 1)
																			{
																				$bandera = 1;
																				$banderaF = 1;
																			}else{
																				$bandera = 0;
																				$banderaF = 0;
																			}
																		}else{
																			if($formacionUsuario[$f]->graduado == "S" || $bandera == 1 || $banderaF == 1)
																			{
																				$bandera = 1;
																				$banderaF = 1;
																			}else{
																				$bandera = 0;
																				$banderaF = 0;
																			}
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																	
																}
															break;
															case 2:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || */$formacionUsuario[$f]->id_nivel == 2/* || $formacionUsuario[$f]->id_nivel == 3 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 8 || $formacionUsuario[$f]->id_nivel == 9 || $formacionUsuario[$f]->id_nivel == 10*/){
																	
																	if($formacionUsuario[$f]->id_nivel == 2 /*|| $formacionUsuario[$f]->id_nivel == 10*/)
																	{	
																		if($conv_abiertas[$i]->semestres != 0){														
																			if($formacionUsuario[$f]->semestres >= $conv_abiertas[$i]->semestres || $bandera == 1 || $banderaF == 1)
																			{					
																				$bandera = 1;
																				$banderaF = 1;
																			}else{																
																				$bandera = 0;
																				$banderaF = 0;
																			}
																		}else{
																			if($formacionUsuario[$f]->graduado == "S" || $bandera == 1 || $banderaF == 1)
																			{
																				$bandera = 1;
																				$banderaF = 1;
																			}else{
																				$bandera = 0;
																				$banderaF = 0;
																			}
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
															break;
															case 3:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || */$formacionUsuario[$f]->id_nivel == 3/* || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 8 || $formacionUsuario[$f]->id_nivel == 9 || $formacionUsuario[$f]->id_nivel == 10*/){
																	
																	if($formacionUsuario[$f]->id_nivel == 3 /*|| $formacionUsuario[$f]->id_nivel == 10*/)
																	{
																		if($conv_abiertas[$i]->semestres != 0){
															
																			if($formacionUsuario[$f]->semestres >= $conv_abiertas[$i]->semestres || $bandera == 1 || $banderaF == 1)
																			{					
																				$bandera = 1;
																				$banderaF = 1;
																			}else{																
																				$bandera = 0;
																				$banderaF = 0;
																			}
																		}else{
																			if($formacionUsuario[$f]->graduado == "S" || $bandera == 1 || $banderaF == 1)
																			{
																				$bandera = 1;
																				$banderaF = 1;
																			}else{
																				$bandera = 0;
																				$banderaF = 0;
																			}
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
															break;
															case 4:
																if($formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6){
																	if($conv_abiertas[$i]->semestres != 0){
																		$bandera = 1;
																		$banderaF = 1;
																	}else{
																		if($formacionUsuario[$f]->graduado == "S" || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}
																	}
																}
															break;
															case 5:
																if($formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6){
																	if($conv_abiertas[$i]->semestres != 0){
																		$bandera = 1;
																		$banderaF = 1;
																	}else{
																		if($formacionUsuario[$f]->graduado == "S" || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}
																	}
																}
															break;
															case 6:
																if($formacionUsuario[$f]->id_nivel == 6){
																	if($conv_abiertas[$i]->semestres != 0){
																		$bandera = 1;
																		$banderaF = 1;
																	}else{
																		if($formacionUsuario[$f]->graduado == "S" || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}
																	}
																}
															break;
															case 8:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || */$formacionUsuario[$f]->id_nivel == 8){
																	
																	if($formacionUsuario[$f]->id_nivel == 8)
																	{															
																		if($formacionUsuario[$f]->semestres >= $conv_abiertas[$i]->semestres || $bandera == 1 || $banderaF == 1)
																		{					
																			$bandera = 1;
																			$banderaF = 1;
																		}else{																
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
															break;
															case 9:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 3 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 8 || */$formacionUsuario[$f]->id_nivel == 9 /*|| $formacionUsuario[$f]->id_nivel == 10*/ ){
																	
																	if(/*$formacionUsuario[$f]->id_nivel == 3 || */$formacionUsuario[$f]->id_nivel == 9/* || $formacionUsuario[$f]->id_nivel == 10*/)
																	{															
																		if($formacionUsuario[$f]->semestres >= $conv_abiertas[$i]->semestres || $bandera == 1 || $banderaF == 1)
																		{					
																			$bandera = 1;
																			$banderaF = 1;
																		}else{																
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
															break;
															case 10:
																if($formacionUsuario[$f]->id_nivel == 1 || /*$formacionUsuario[$f]->id_nivel == 2 || $formacionUsuario[$f]->id_nivel == 3 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || */$formacionUsuario[$f]->id_nivel == 8 || /*$formacionUsuario[$f]->id_nivel == 9 ||*/ $formacionUsuario[$f]->id_nivel == 10){
																	
																	if($formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 8 || /*$formacionUsuario[$f]->id_nivel == 2 || $formacionUsuario[$f]->id_nivel == 3 ||*/ $formacionUsuario[$f]->id_nivel == 10)
																	{	
																		if($formacionUsuario[$f]->semestres >= $conv_abiertas[$i]->semestres || $bandera == 1 || $banderaF == 1)
																		{					
																			$bandera = 1;
																			$banderaF = 1;
																		}else{																
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
															break;
															case 11:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 2 || $formacionUsuario[$f]->id_nivel == 3 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 8 || $formacionUsuario[$f]->id_nivel == 9 || $formacionUsuario[$f]->id_nivel == 10 ||*/ $formacionUsuario[$f]->id_nivel == 11){
																	if($formacionUsuario[$f]->id_nivel == 11)
																	{																																
																		if($formacionUsuario[$f]->semestres >= $conv_abiertas[$i]->semestres || $bandera == 1 || $banderaF == 1)
																		{					
																			$bandera = 1;
																			$banderaF = 1;
																		}else{																
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
															break;
														}
													}
													//echo utf8_decode($conv_abiertas[$i]->nombre_inv) .' - '.$conv_abiertas[$i]->tiempo.'<br>'; 
													//echo $conv_abiertas[$i]->id_nivel."-----".$banderaF."Meses exp:  ".$mesesExperiencia."Meses Reque  ".$conv_abiertas[$i]->tiempo."<br>";
													if(($mesesExperiencia >= $conv_abiertas[$i]->tiempo) && ($banderaF == 1)){										
															$bandera = 1;											
														}else{
															$bandera = 0;
														}
														//echo "bandera final: ".$bandera."<br>";
												}else
													{
														$bandera = 0;
													}	
												
												
												if($bandera == 1){
												?>
			                                    <tr>
			                                        <td width="30%"><?php echo utf8_decode($conv_abiertas[$i]->nombre_inv) ?></td>
			                                        <td width="20%"><?php echo utf8_decode($conv_abiertas[$i]->nombre_rol_inv) ?></td>
			                                        <td width="10%"><?php echo utf8_decode($conv_abiertas[$i]->nom_mpio)?></td>
			                                   <!--     <td width="10%"><?php /* echo $conv_abiertas[$i]->fecha_inicio?></td>
			                                        <td width="10%"><?php echo $conv_abiertas[$i]->fecha_fin */ ?></td>  -->
			                                        <td><?php echo utf8_decode($conv_abiertas[$i]->honorarios)?></td>
			                                        <td width="10%">
			                                        	<!-- Button trigger modal -->
														<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalle<?php echo $conv_abiertas[$i]->id_convocatoria?>">
														  <span class="glyphicon glyphicon-search" aria-hidden="true"> </span> Ver detalle
			                                        </td>
			                                        <td width="10%">
			                                            <!--
														<a class='btn btn-primary' href='<?php echo base_url('ciudadano/convocatorias/aplicar/' . $conv_abiertas[$i]->id_convocatoria.'/'.$conv_abiertas[$i]->id_conv_insc) ?>'>
			                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"> </span>  Aplicar
			                                            </a>-->
														
														<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#aplicarAb<?php echo $conv_abiertas[$i]->id_conv_insc?>">
														  <span class="glyphicon glyphicon-ok" aria-hidden="true"> </span> Aplicar 
														</button>
			                                        </td>
			                                    </tr>
												
												<!-- Modal APLICAR -->
												<div class="modal fade bs-example-modal-lg" id="aplicarAb<?php echo $conv_abiertas[$i]->id_conv_insc?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
													  <div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">CONFIRMACI&Oacute;N</h4>
													  </div>
													  <form class="form-horizontal" role="form" id="formConvocatoriaAplicarAb" action="<?php echo base_url('ciudadano/convocatorias/aplicar/' . $conv_abiertas[$i]->id_convocatoria.'/'.$conv_abiertas[$i]->id_conv_insc) ?>" name="formConvocatoriaAplicarAb" method="post">
													  <div class="modal-body">												  
															<div class="row">
																<div class="col-md-10 col-md-offset-1">
																	<h5 style="text-align: center;"><strong>&iquest; Esta seguro que desea aplicar a la siguiente convocatoria de <?php echo utf8_decode($conv_abiertas[$i]->nom_mpio)?> ? </strong></h5>
																	<h5 style="text-align: center;"><strong>Recuerde que al aceptar, quedara inscrito en la convocatoria y esta no podr&aacute; ser modificada.</strong></h5>
																</div>
															</div>
															<div class="row">
																<div class="col-md-3"><b>Investigaci&oacute;n</b></div>
																<div class="col-md-9"><?php echo utf8_decode($conv_abiertas[$i]->nombre_inv)?></div>
															</div>
															<div class="row">
																<div class="col-md-3"><b>Rol</b></div>
																<div class="col-md-9"><?php echo utf8_decode($conv_abiertas[$i]->nombre_rol_inv)?></div>
															</div>
															<div class="row">
																<div class="col-md-3"><b>Municipio convocatoria </b></div>
																<div class="col-md-9"><?php echo utf8_decode($conv_abiertas[$i]->nom_mpio)?></div>
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
												<!--Fin modal aplicar-->
			                                    
			                                    <!-- Modal -->
												<div class="modal fade bs-example-modal-lg" id="detalle<?php echo $conv_abiertas[$i]->id_convocatoria?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog modal-lg" role="document">
												    <div class="modal-content">
												      <div class="modal-header">
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												        <h4 class="modal-title" id="myModalLabel"><?php echo utf8_decode($conv_abiertas[$i]->nombre_inv)?></h4>
												      </div>
												      <div class="modal-body">
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Investigaci&oacute;n</b></div>
			                            						<div class="col-md-9"><?php echo utf8_decode($conv_abiertas[$i]->nombre_inv)?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Rol</b></div>
			                            						<div class="col-md-9"><?php echo utf8_decode($conv_abiertas[$i]->nombre_rol_inv)?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Fecha de inicio convocatoria</b></div>
			                            						<div class="col-md-9"><?php echo $conv_abiertas[$i]->fecha_inicio?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Fecha de finalizaci&oacute;n convocatoria</b></div>
			                            						<div class="col-md-9"><?php echo $conv_abiertas[$i]->fecha_fin?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="col-md-3"><b>Honorarios o Salario</b></div>
			                            						<div class="col-md-9"><?php echo $conv_abiertas[$i]->honorarios?></div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="panel panel-primary">
																  <div class="panel-heading">Perfil</div>
																  <div class="panel-body">
																    <?php echo utf8_decode($conv_abiertas[$i]->perfil)?>
																  </div>
																</div>                            						
			                            					</div>
			                            					<div class="row">
			                            						<div class="panel panel-primary">
																  <div class="panel-heading">Objeto</div>
																  <div class="panel-body">
																    <?php echo utf8_decode($conv_abiertas[$i]->objeto)?>
																  </div>
																</div>
			                            					</div>
			                            					<div class="row">
			                            						<div class="panel panel-primary">
																  <div class="panel-heading">Obligaciones</div>
																  <div class="panel-body">
																    <?php echo utf8_decode($conv_abiertas[$i]->obligaciones)?>
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
			                                    <?php
												}  
												$operativo_ant= $conv_abiertas[$i]->operativo;    
												$ciudad_ant = $conv_abiertas[$i]->id_ciudad;
											}                            
		                                }
		                                ?>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div> 
		                    <?php
		                    }
		                    ?>
				        </div>
				        <?php
				        if (count($conv_cerradas) > 0) {
            			?>
				        <div class="tab-pane" id="cerradas">
				            <h3>Invitaciones</h3>
				            <?php
						
							if (count($conv_participando)>0) {
								?>
								<center><h2>Ya se encuentra participando en una convocatoria</h2></center>
								<?php
							}else{
								
								?>
	                        <div class="row">
	                            <div class="table-responsive">
	                                <table class="table table-striped" id="ciud_cerra">
	                                	<thead>
	                                		<tr>
			                            		<th>Investigaci&oacute;n</th>
			                            		<th>Rol</th>
			                            		<th>Ciudad de convocatoria</th>
			                            <!--		<th>Fecha inicio convocatoria</th>
			                            		<th>Fecha fin convocatoria</th>  -->
			                            		<th>Contrato</th>
			                            		<th>Detalle</th>
			                            		<th>Aplicar</th>
			                            	</tr>
	                                	</thead>
	                                	<tfoot>
	                                		<tr>
			                            		<th>Investigaci&oacute;n</th>
			                            		<th>Rol</th>
			                            		<th>Ciudad de convocatoria</th>
			                            <!--		<th>Fecha inicio convocatoria</th>
			                            		<th>Fecha fin convocatoria</th>  -->
			                            		<th>Contrato</th>
			                            		<th>Detalle</th>
			                            		<th>Aplicar</th>
			                            	</tr>
	                                	</tfoot>
	                                	<tbody>
	                                    <?php
	                                    //var_dump($conv_cerradas);
	                                    $operativo_ant="";
	                                    for ($c = 0; $c < count($conv_cerradas); $c++) {
											if(($operativo_ant != $conv_abiertas[$c]->operativo || $ciudad_ant != $conv_abiertas[$c]->id_ciudad) || $bandera==0){
												$bandera = 0;
												$banderaF = 0;
											
												if(($conv_cerradas[$c]->fecha_inicio <= date('Y-m-d')) && ($conv_cerradas[$c]->fecha_fin >= date('Y-m-d'))){
														
													for($f=0;$f<count($formacionUsuario);$f++){
														/*
														 echo "<br>Bandera: ".$banderaF;
														echo "<br>Meses Expe: ".$mesesExperiencia;
														echo "<br>Conv Expe: ".$conv_cerradas[$c]->tiempo;
														*/
														//echo "//**".$formacionUsuario[$f]->id_nivel."<br>";
														//echo $conv_cerradas[$c]->id_nivel."--------<br>";
														switch($conv_cerradas[$c]->id_nivel){
															case 1:
																if($formacionUsuario[$f]->id_nivel == 1/* || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 10*/){
																		
																	if($formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 10)
																	{
																		if($formacionUsuario[$f]->semestres >= $conv_cerradas[$c]->semestres || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}else{
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																		
																}
																break;
															case 2:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || */$formacionUsuario[$f]->id_nivel == 2/* || $formacionUsuario[$f]->id_nivel == 3 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 8 || $formacionUsuario[$f]->id_nivel == 9 || $formacionUsuario[$f]->id_nivel == 10*/){
																		
																	if($formacionUsuario[$f]->id_nivel == 2 /*|| $formacionUsuario[$f]->id_nivel == 10*/)
																	{
																		if($formacionUsuario[$f]->semestres >= $conv_cerradas[$c]->semestres || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}else{
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
																break;
															case 3:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || */$formacionUsuario[$f]->id_nivel == 3/* || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 8 || $formacionUsuario[$f]->id_nivel == 9 || $formacionUsuario[$f]->id_nivel == 10*/){
																		
																	if($formacionUsuario[$f]->id_nivel == 3 /*|| $formacionUsuario[$f]->id_nivel == 10*/)
																	{
																		if($formacionUsuario[$f]->semestres >= $conv_cerradas[$c]->semestres || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}else{
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
																break;
															case 4:
																if($formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6){
																	$bandera = 1;
																	$banderaF = 1;
																}
																break;
															case 5:
																if($formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6){
																	$bandera = 1;
																	$banderaF = 1;
																}
																break;
															case 6:
																if($formacionUsuario[$f]->id_nivel == 6){
																	$bandera = 1;
																	$banderaF = 1;
																}
																break;
															case 8:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || */$formacionUsuario[$f]->id_nivel == 8){
																		
																	if($formacionUsuario[$f]->id_nivel == 8)
																	{
																		if($formacionUsuario[$f]->semestres >= $conv_cerradas[$c]->semestres || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}else{
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
																break;
															case 9:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 3 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 8 || */$formacionUsuario[$f]->id_nivel == 9 /*|| $formacionUsuario[$f]->id_nivel == 10*/ ){
																		
																	if(/*$formacionUsuario[$f]->id_nivel == 3 || */$formacionUsuario[$f]->id_nivel == 9/* || $formacionUsuario[$f]->id_nivel == 10*/)
																	{
																		if($formacionUsuario[$f]->semestres >= $conv_cerradas[$c]->semestres || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}else{
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
																break;
															case 10:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 2 || $formacionUsuario[$f]->id_nivel == 3 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 8 || $formacionUsuario[$f]->id_nivel == 9 ||*/ $formacionUsuario[$f]->id_nivel == 10){
																		
																	if(/*$formacionUsuario[$f]->id_nivel == 2 || $formacionUsuario[$f]->id_nivel == 3 ||*/ $formacionUsuario[$f]->id_nivel == 10)
																	{
																		if($formacionUsuario[$f]->semestres >= $conv_cerradas[$c]->semestres || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}else{
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
																break;
															case 11:
																if(/*$formacionUsuario[$f]->id_nivel == 1 || $formacionUsuario[$f]->id_nivel == 2 || $formacionUsuario[$f]->id_nivel == 3 || $formacionUsuario[$f]->id_nivel == 4 || $formacionUsuario[$f]->id_nivel == 5 || $formacionUsuario[$f]->id_nivel == 6 || $formacionUsuario[$f]->id_nivel == 8 || $formacionUsuario[$f]->id_nivel == 9 || $formacionUsuario[$f]->id_nivel == 10 ||*/ $formacionUsuario[$f]->id_nivel == 11){
																	if($formacionUsuario[$f]->id_nivel == 11)
																	{
																		if($formacionUsuario[$f]->semestres >= $conv_cerradas[$c]->semestres || $bandera == 1 || $banderaF == 1)
																		{
																			$bandera = 1;
																			$banderaF = 1;
																		}else{
																			$bandera = 0;
																			$banderaF = 0;
																		}
																	}else{
																		$bandera = 1;
																		$banderaF = 1;
																	}
																}
																break;
														}
													}
													//echo utf8_decode($conv_cerradas[$c]->nombre_inv) .' - '.$conv_cerradas[$c]->tiempo.'<br>';
													//echo $conv_cerradas[$c]->id_nivel."-----".$banderaF."Meses exp:  ".$mesesExperiencia."Meses Reque  ".$conv_cerradas[$c]->tiempo."<br>";
													if(($mesesExperiencia >= $conv_cerradas[$c]->tiempo) && ($banderaF == 1)){
														$bandera = 1;
													}else{
														$bandera = 0;
													}
													//echo "bandera final: ".$bandera."<br>";
												}else
												{
													$bandera = 0;
												}
											
											
												if($bandera == 1){
													?>
														                                    <tr>
														                                        <td width="30%"><?php echo utf8_decode($conv_cerradas[$c]->nombre_inv) ?></td>
														                                        <td width="20%"><?php echo utf8_decode($conv_cerradas[$c]->nombre_rol_inv) ?></td>
														                                        <td width="10%"><?php echo utf8_decode($conv_cerradas[$c]->nom_mpio)?></td>
														                                   <!--     <td width="10%"><?php /* echo $conv_cerradas[$c]->fecha_inicio?></td>
														                                        <td width="10%"><?php echo $conv_cerradas[$c]->fecha_fin */ ?></td>  -->
														                                        <td><?php echo utf8_decode($conv_cerradas[$c]->honorarios)?></td>
														                                        <td width="10%">
														                                        	<!-- Button trigger modal -->
																									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalle<?php echo $conv_cerradas[$c]->id_convocatoria?>">
																									  <span class="glyphicon glyphicon-search" aria-hidden="true"> </span> Ver detalle
														                                        </td>
														                                        <td width="10%">
														                                            <!--
																									<a class='btn btn-primary' href='<?php echo base_url('ciudadano/convocatorias/aplicar/' . $conv_cerradas[$c]->id_convocatoria.'/'.$conv_cerradas[$c]->id_conv_insc) ?>'>
														                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"> </span>  Aplicar
														                                            </a>-->
																									
																									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#aplicarAb<?php echo $conv_cerradas[$c]->id_conv_insc?>">
																									  <span class="glyphicon glyphicon-ok" aria-hidden="true"> </span> Aplicar 
																									</button>
														                                        </td>
														                                    </tr>
																							
																							<!-- Modal APLICAR -->
																							<div class="modal fade bs-example-modal-lg" id="aplicarAb<?php echo $conv_cerradas[$c]->id_conv_insc?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
																							  <div class="modal-dialog modal-lg" role="document">
																								<div class="modal-content">
																								  <div class="modal-header">
																									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																									<h4 class="modal-title" id="myModalLabel">CONFIRMACI&Oacute;N</h4>
																								  </div>
																								  <form class="form-horizontal" role="form" id="formConvocatoriaAplicarAb" action="<?php echo base_url('ciudadano/convocatorias/aplicar/' . $conv_cerradas[$c]->id_convocatoria.'/'.$conv_cerradas[$c]->id_conv_insc) ?>" name="formConvocatoriaAplicarAb" method="post">
																								  <div class="modal-body">												  
																										<div class="row">
																											<div class="col-md-10 col-md-offset-1">
																												<h5 style="text-align: center;"><strong>&iquest; Esta seguro que desea aplicar a la siguiente convocatoria de <?php echo utf8_decode($conv_cerradas[$c]->nom_mpio)?> ? </strong></h5>
																												<h5 style="text-align: center;"><strong>Recuerde que al aceptar, quedara inscrito en la convocatoria y esta no podr&aacute; ser modificada.</strong></h5>
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
																											<div class="col-md-3"><b>Municipio convocatoria </b></div>
																											<div class="col-md-9"><?php echo utf8_decode($conv_cerradas[$c]->nom_mpio)?></div>
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
																							<!--Fin modal aplicar-->
														                                    
														                                    <!-- Modal -->
																							<div class="modal fade bs-example-modal-lg" id="detalle<?php echo $conv_cerradas[$c]->id_convocatoria?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
																							  <div class="modal-dialog modal-lg" role="document">
																							    <div class="modal-content">
																							      <div class="modal-header">
																							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																							        <h4 class="modal-title" id="myModalLabel"><?php echo utf8_decode($conv_cerradas[$c]->nombre_inv)?></h4>
																							      </div>
																							      <div class="modal-body">
														                            					<div class="row">
														                            						<div class="col-md-3"><b>Investigaci&oacute;n</b></div>
														                            						<div class="col-md-9"><?php echo utf8_decode($conv_cerradas[$c]->nombre_inv)?></div>
														                            					</div>
														                            					<div class="row">
														                            						<div class="col-md-3"><b>Rol</b></div>
														                            						<div class="col-md-9"><?php echo utf8_decode($conv_cerradas[$c]->nombre_rol_inv)?></div>
														                            					</div>
														                            					<div class="row">
														                            						<div class="col-md-3"><b>Fecha de inicio convocatoria</b></div>
														                            						<div class="col-md-9"><?php echo $conv_cerradas[$c]->fecha_inicio?></div>
														                            					</div>
														                            					<div class="row">
														                            						<div class="col-md-3"><b>Fecha de finalizaci&oacute;n convocatoria</b></div>
														                            						<div class="col-md-9"><?php echo $conv_cerradas[$c]->fecha_fin?></div>
														                            					</div>
														                            					<div class="row">
														                            						<div class="col-md-3"><b>Honorarios o Salario</b></div>
														                            						<div class="col-md-9"><?php echo $conv_cerradas[$c]->honorarios?></div>
														                            					</div>
														                            					<div class="row">
														                            						<div class="panel panel-primary">
																											  <div class="panel-heading">Perfil</div>
																											  <div class="panel-body">
																											    <?php echo utf8_decode($conv_cerradas[$c]->perfil)?>
																											  </div>
																											</div>                            						
														                            					</div>
														                            					<div class="row">
														                            						<div class="panel panel-primary">
																											  <div class="panel-heading">Objeto</div>
																											  <div class="panel-body">
																											    <?php echo utf8_decode($conv_cerradas[$c]->objeto)?>
																											  </div>
																											</div>
														                            					</div>
														                            					<div class="row">
														                            						<div class="panel panel-primary">
																											  <div class="panel-heading">Obligaciones</div>
																											  <div class="panel-body">
																											    <?php echo utf8_decode($conv_cerradas[$c]->obligaciones)?>
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
														                                    <?php
																							}  
																							$operativo_ant= $conv_cerradas[$c]->operativo;     
																							$ciudad_ant= $conv_cerradas[$c]->id_ciudad;
																						}                            
													                                }
	                                        ?>
                                        </tbody>
	                                </table>
	                            </div>
	                        </div> 
	                        <?php
	                        }
	                        ?>
					        </div>  
					        <?php
					        }
					        ?>     
				    </div>
			    </div>
            </div>
            
            </div>		
        </div>
    </div>
<?php
	
}else{
	?>
	<div class="container">
	    <div class="row">
	        <div class="col-md-8 col-md-offset-2">
	        	<center><h1>Debe completar la informaci&oacute;n de la hoja de vida para aplicar a convocatorias</h1></center>
        	</div>		
        </div>
    </div>
	<?php
}

?>
