<?php
$errorBD = $this->session->flashdata('errorBD');
if ($errorBD) {
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong>Error!</strong> <?php echo $errorBD ?>
    </div>
    <?php
}


$eventoCreado= $this->session->flashdata('expertoCreado');
if ($eventoCreado) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong><?php echo $eventoCreado ?></strong> 
    </div>
    <?php
}

$eventoBorrada= $this->session->flashdata('expertoBorrado');
if ($eventoBorrada) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong><?php echo $eventoBorrada ?></strong> 
    </div>
    <?php
}
?>
<div id="tabsExperto">
    <ul>
        <li><a href="#tabsGrupo-1"><?php echo $this->lang->line('Expertos Registrados'); ?></a></li>
    </ul>
    <div id="tabsEvento-1">
        <table id="experto1" class="table table-striped table-bordered display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('Pais que registra'); ?></th>
                    <th><?php echo $this->lang->line('Nombre'); ?></th>
                    <th><?php echo $this->lang->line('Apellidos'); ?></th>
                    <th><?php echo $this->lang->line('Pais'); ?></th>
                    <th><?php echo $this->lang->line('Institucion'); ?></th>
                    <th><?php echo $this->lang->line('Experiencia'); ?></th>
                    <th><?php echo $this->lang->line('mas Informacion'); ?></th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($expertos as $row) {
    ?>
        <tr>
            <td>
				<center>
                <?php 
					$pais = substr(strtolower($row->paisUsuario),0,2);
					?>
					<img src="<?php echo base_url('assets/banderas/iso/'.$pais.'.png') ?>" width="30px">
					<br>
					<?php echo $row->emailUsuario ?>
				</center>
            </td>
			<td>
                <?php echo $row->nombre ?>
            </td>
            <td>
                <?php echo $row->apellidos ?>
            </td>
            <td>
                <?php echo $row->desc_pais ?>
            </td>                        
            <td>
                <?php echo $row->institucion ?>
            </td>
            <td>
                <?php echo $row->experiencia ?>
            </td>
            <td>
				<div class="modal fade" id="infoExp<?php echo $row->id_experto?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"><?php echo $row->nombre." ".$row->apellidos ?></h4>
					  </div>
					  <div class="modal-body">
						<table class="table table-bordered">
							<tr>
								<th><?php echo $this->lang->line('Pais'); ?></th>
								<th><?php echo $this->lang->line('Institucion'); ?></th>
								<th><?php echo $this->lang->line('Correo Electr&oacute;nico'); ?></th>
							</tr>
							<tr>
								<td><?php echo $row->desc_pais?></td>
								<td><?php echo $row->institucion?></td>
								<td><?php echo $row->correo?></td>
							</tr>
						</table>
						<div class="panel panel-primary">
							<div class="panel-heading"><?php echo $this->lang->line('Experiencia'); ?></div>
							<div class="panel-body">
								<?php echo $row->experiencia?>
							</div>
						</div>
						<?php
							$formacion_expertos = $this->expertos_model->formacionExperto($row->id_experto);
						?>
						<div class="panel panel-primary">
							<div class="panel-heading"><?php echo $this->lang->line('Formacion'); ?></div>
							<div class="panel-body">
								<table class="table table-bordered">
									<tr>
										<th><?php echo $this->lang->line('Nivel'); ?></th>
										<th><?php echo $this->lang->line('Campo'); ?></th>
										<th><?php echo $this->lang->line('Universidad'); ?></th>
									</tr>
									<?php
									foreach($formacion_expertos as $forma)
									{
										?>
										<tr>
											<td>
												<?php echo $forma->descripcion?>											
											</td>
											<td>
												<?php echo $forma->campo_estudio?>
											</td>
											<td>
												<?php echo $forma->universidad?>
											</td>
										</tr>
										<?php
									}
									
								?>
								</table>
							</div>
						</div>
						<?php
							$temas_expertos = $this->expertos_model->temasExperto($row->id_experto);
						?>

						<div class="panel panel-primary">
							<div class="panel-heading"><?php echo $this->lang->line('Temas Experticia'); ?></div>
							<div class="panel-body">							
								<table class="table table-bordered">
									<tr>
										<th><?php echo $this->lang->line('Categoria'); ?></th>
										<th><?php echo $this->lang->line('Fase'); ?></th>
									</tr>
								<?php
									foreach($temas_expertos as $temaEx)
									{
										?>
										<tr>
											<td>
												<?php echo $this->lang->line('clasificacion'.$temaEx->id_categoria)?>											
											</td>
											<td>
												<?php echo $temaEx->descripcion?>
											</td>											
										</tr>
										<?php
									}
									
								?>									
								</table>
							</div>
						</div>
					</div>
				  </div>
				</div>
				</div>
                <center>
                    <a href="#" data-toggle="modal" data-target="#infoExp<?php echo $row->id_experto?>">
                        <img src="<?php echo base_url('assets/img/info.png') ?>" width="30px">
                    </a>
                </center>
            </td>			
        </tr>
    <?php
}
?>
            <tbody>
        </table>
    </div>
</div>