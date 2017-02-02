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
								<th>Operativo</th>
								<th>Identificaci&oacute;n</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Investigaci&oacute;n</th>
								<th>Rol</th>                                                          
								<th>Municipio</th>
								<th>Borrar</th>
							</tr>
						</thead>
						<tbody>
						<?php
						
						for ($i = 0; $i < count($personas); $i++) {
							
							
							echo "<tr>";
							echo "<td>";
							if($personas[$i]->operativo == ''){
								echo "Falta codigo";
							}else{
								echo utf8_decode($personas[$i]->operativo);
							}
							echo "</td>";
							echo "<td>" . utf8_decode($personas[$i]->tipo_iden) . " - " . utf8_decode($personas[$i]->nume_iden) . "</td>";
							echo "<td>" . utf8_decode($personas[$i]->nombres) . "</td>";
							echo "<td>" . utf8_decode($personas[$i]->apellidos) . "</td>";
							echo "<td>" . utf8_decode($personas[$i]->nombre_inv) . "</td>";
							echo "<td>" . utf8_decode($personas[$i]->nombre_rol_inv) . "</td>";
							echo "<td>" . utf8_decode($personas[$i]->nom_mpio) . "</td>";
							?>
							<td>
								<a class='btn btn-danger' href='<?php echo base_url('administrador/convocatorias/borrarInscripcion/' . $personas[$i]->id_usuario . '/'. $personas[$i]->id_convocatoria .'/'. $personas[$i]->id_conv_insc ) ?>'>
									<span class="glyphicon glyphicon-user" aria-hidden="true"> </span>  Eliminar 
								</a>
							</td>							
							<?php
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


