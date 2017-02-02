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
								<th>Correo</th>
								<th>Formacion</th>
								<th>Experiencia</th>
								<th>Hoja de Vida</th>
								<th>Modificar</th>
								<th>Eliminar</th>
								<th>Cambiar Invitaci&oacute;n</th>
							</tr>
						</thead>
						<tbody>
						<?php
						for ($i = 0; $i < count($usuarios); $i++) {
							
							$datosUsuario = $this->perfil_model->datos_usuario($usuarios[$i]->id_usuario);
							$formacionUsuario = $this->perfil_model->formacionUsuario($usuarios[$i]->id_usuario);
							$experienciaUsuario = $this->perfil_model->experienciaUsuario($usuarios[$i]->id_usuario);
							
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
										        				<img src="'.base_url('uploads/avatar/'.$datosUsuario[0]->nombA).'" width="200px">
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
							
							?>
							<tr>
							<td><?php echo utf8_decode($usuarios[$i]->id_usuario)?></td>
							<td><?php echo utf8_decode($usuarios[$i]->tipo_iden) . " - " . utf8_decode($usuarios[$i]->nume_iden) ?></td>
							<td><?php echo utf8_decode($usuarios[$i]->nombres) ?></td>
							<td><?php echo utf8_decode($usuarios[$i]->apellidos) ?></td>
							<td><?php echo utf8_decode($usuarios[$i]->usuario) ?></td>
							<?php 
							if(count($experienciaUsuario)>0){
								$experiencia = "SI";
							}else{
								$experiencia = "NO";
							}
								
							if(count($formacionUsuario)>0){
								$formacion = "SI";
							}else{
								$formacion = "NO";
							}
								
							echo "<td>" . $formacion . "</td>";
							echo "<td>" . $experiencia . "</td>"	
							?>
							<td><?php echo $informacionExponer[$i]['hojavida'] ?></td>
							<td>
	                        	<a class='btn btn-info' target='_blank' href='<?php echo base_url('administrador/adm_usuarios/editarUsuario/' . $usuarios[$i]->id_usuario) ?>'>
                                	 <span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span>  Modificar
                                </a>
							</td>
							<td>
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelFormacion-<?php echo $usuarios[$i]->id_usuario?>">
								  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar
								</button>
								<div class="modal fade bs-example-modal-lg" id="modalDelFormacion-<?php echo $usuarios[$i]->id_usuario?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Eliminar Usuario</h4>
									  </div>
									  <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formEliminarForm" action="<?php echo base_url('administrador/adm_usuarios/eliminarUsuario/'.$usuarios[$i]->id_usuario) ?>" name="formEliminarForm" method="post">
									  <div class="modal-body">
											Desea eliminar el usuario seleccionado. El id del usuario que selecciono es: <?php echo $usuarios[$i]->id_usuario?>
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
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDeCambioInvitacion-<?php echo $usuarios[$i]->id_usuario?>">
								  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Mover Invitaci&oacute;n
								</button>
								<div class="modal fade bs-example-modal-lg" id="modalDeCambioInvitacion-<?php echo $usuarios[$i]->id_usuario?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Mover Invitaci&oacute;n</h4>
									  </div>
									  <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formMoverInv" action="<?php echo base_url('administrador/adm_usuarios/moverinv/'.$usuarios[$i]->id_usuario. '/'. $usuarios[$i]->nume_iden) ?>" name="formMoverInv" method="post">
									  <div class="modal-body">
											Desea Mover la invitaci&oacute;n al usuario duplicado. Recuerde que para que el cambio se efectue debe existir solo dos usuarios asociados a la identificaci&oacute;n
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
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


