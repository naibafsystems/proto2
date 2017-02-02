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
                                Convocatorias Abiertas
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
					<table class="table table-striped" id="tablaUsuarios">
						<thead>
							<tr>
								<th>ID</th>
								<th>Investigaci&oacute;n</th>
								<th>Rol</th>
								<th>Tipo Convocatoria</th>
								<th>Operativo</th>
								<th>Clonar a invitaci&oacute;n</th>
							</tr>
						</thead>
						<tbody>
						<?php
						for ($i = 0; $i < count($convocatoriasAbiertas); $i++) {
							
							
							echo "<tr>";
							echo "<td>" . utf8_decode($convocatoriasAbiertas[$i]->id_convocatoria) . "</td>";
							echo "<td>" . utf8_decode($convocatoriasAbiertas[$i]->nombre_inv) . "</td>";
							echo "<td>" . utf8_decode($convocatoriasAbiertas[$i]->nombre_rol_inv) . "</td>";
							echo "<td>" . utf8_decode($convocatoriasAbiertas[$i]->tipo_conv) . "</td>";
							echo "<td>" . utf8_decode($convocatoriasAbiertas[$i]->operativo) . "</td>";
							?>
							<td>
								<a class='btn btn-danger' href='<?php echo base_url('administrador/convocatorias/clonarConvocatoria/' . $convocatoriasAbiertas[$i]->id_convocatoria ) ?>'>
									<span class="glyphicon glyphicon-user" aria-hidden="true"> </span>  Clonar 
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


