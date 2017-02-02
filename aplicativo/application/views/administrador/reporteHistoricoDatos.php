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
                                Reporte Totalizado Por Matricula
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
					<table class="table table-striped display nowrap" id="tablaReportes">
						<thead>
							<tr>
								<th>Identificacion</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<!-- <th>Hoja de vida</th>   -->
								<th>Encuesta</th>
								<th>Rol</th>
								<th>Ciudad</th>
								<th>Numero operativo</th>
								<th>Estado</th>                                                          
								<th>Observaciones</th>
								<th>Actividad</th>
								<th>Fecha Aplicacion</th>
								<th>Fecha Semaforo</th>
								<th>Tipo Convocatoria</th>
								<?php if($_SESSION["rol"]==1){ ?><th>Reiniciar Semaforo</th> <?php }?>
							</tr>
						</thead>
						<tbody>
						<?php
						
						for ($i = 0; $i < count($reporte); $i++) {  
							?>
							<tr>
							<td><?php echo utf8_decode($reporte[$i]->nume_iden)?></td>
							<td><?php echo utf8_decode($reporte[$i]->nombres)?></td>
							<td><?php echo utf8_decode($reporte[$i]->apellidos) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->nombre_inv) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->nombre_rol_inv) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->nom_mpio) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->operativo) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->doc_estado) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->observaciones) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->estado) ?></td>
							<td><?php if($reporte[$i]->doc_estado!='Sin Estado')
								{
									if($reporte[$i]->tipo_convocatoria=='Abierta'){
										echo utf8_decode($reporte[$i]->fecha_aplicaA);
									}elseif($reporte[$i]->tipo_convocatoria=='Cerrada'){
										echo utf8_decode($reporte[$i]->fecha_aplicaC);
									}
								}
								?></td>
							<td><?php echo utf8_decode($reporte[$i]->fecha_doc_estado) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->tipo_convocatoria) ?></td>
							<td>
							<?php if($_SESSION["rol"]==1){ ?>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modificarSemaforo-<?php echo $reporte[$i]->id_usu_conv?>">
						  		<span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span> Reiniciar Semaforo      
						  	</button>
						  	
						  	 
						  	<div class="modal fade bs-example-modal-lg" id="modificarSemaforo-<?php echo $reporte[$i]->id_usu_conv?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Restablecer Semaforo</h4>
									  </div>
									  <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formRestablecer" action="<?php echo base_url('administrador/reporteHistorico/restablecerSemaforo/'.$reporte[$i]->id_usu_conv.'/'.$reporte[$i]->id_usuario.'/'.$reporte[$i]->estado) ?>" name="formEliminarForm" method="post">
									  <div class="modal-body">
									  <?php 
									  if ($reporte[$i]->estado=="Inactivo"){
										echo "El usuario se encuentra inactivo en la convocatoria. ¡DESEA ACTIVARLO DE NUEVO!<br>";
									  }
									  ?>
											Desea restablecer el semaforo.
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
										<button type="submit" class="btn btn-success" >Aceptar</button>
									  </div>
									  </form>
									</div>
								  </div>
								</div>
							<?php }?>								
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
	</div>
</div>
 
 <!--ADICION PARA GENERAR TABLAS DINAMICAS-->

<!--  
<link href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
-->

 
 
 <link href="<?= base_url('assets/css/general/buttons.dataTables.min.css')?>" media="all" rel="stylesheet" type="text/css" /> 
  
 <script type="text/javascript" src="<?= base_url('assets/js/general/dataTables.buttons.min.js') ?>"></script>
 <script type="text/javascript" src="<?= base_url('assets/js/general/buttons.flash.min.js') ?>"></script>
 <script type="text/javascript" src="<?= base_url('assets/js/general/jszip.min.js') ?>"></script>
 <script type="text/javascript" src="<?= base_url('assets/js/general/pdfmake.min.js') ?>"></script> 
 <script type="text/javascript" src="<?= base_url('assets/js/general/vfs_fonts.js') ?>"></script>
 <script type="text/javascript" src="<?= base_url('assets/js/general/buttons.html5.min.js') ?>"></script>
 <script type="text/javascript" src="<?= base_url('assets/js/general/buttons.print.min.js') ?>"></script>
 

<script type="text/javascript" src="<?= base_url('assets/js/general/sistema/reportes.js') ?>"></script>

