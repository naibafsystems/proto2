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
								<th>Eco</th>
								<th>Encuesta</th>
								<th>Rol</th>
								<th>Ciudad</th>
								<th>No. Personas Requeridas</th>
								<th>No. Personas Inscritas</th>                                                          
								<th>No. Personas Matricular</th>
								<th>No. Personas Verde</th>
								<th>No. Personas Naranja</th>
								<th>No. Personas Rojo</th>
								<th>No. Personas Sin Validar</th>
								<th>Fecha Inicio Operacion</th>
								<!-- <th>Fecha Fin operacion</th> -->
							</tr>
						</thead>
						<tbody>
						<?php
						
						for ($i = 0; $i < count($reporte); $i++) {
							?>
							<tr>
							<td><?php echo utf8_decode($reporte[$i]->operativo)?></td>
							<td><?php echo utf8_decode($reporte[$i]->nombre_inv)?></td>
							<td><?php echo utf8_decode($reporte[$i]->nombre_rol_inv) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->nom_mpio) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->total_personas) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->total_inscritos) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->max_inscri) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->total_verdes) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->total_naranjas) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->total_rojos) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->total_sin_validar) ?></td>
							<td><?php echo utf8_decode($reporte[$i]->fecha_inicio) ?></td>
							<!-- <td><?php echo utf8_decode($reporte[$i]->fecha_fin) ?></td>  -->
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

