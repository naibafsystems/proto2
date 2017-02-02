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

$eventoAprobado= $this->session->flashdata('eventoAprobado');
if ($eventoAprobado) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong><?php echo $eventoAprobado ?></strong> 
    </div>
    <?php
}

$eventoCreado= $this->session->flashdata('eventoCreado');
if ($eventoCreado) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong><?php echo $eventoCreado ?></strong> 
    </div>
    <?php
}


$eventoBorrada= $this->session->flashdata('eventoBorrada');
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
<div class="row">
    <div class="col-md-2 col-md-offset-5">
        <center>
            <a href="<?php echo base_url('administrador/eventos_necesidad/crearEvento') ?>">
                <img src="<?php echo base_url('assets/img/cronograma.png') ?>">
                <br>
                <?php echo $this->lang->line('Crear Necesidad de Capacitación'); ?>
            </a>
        </center>
    </div>
</div>
<div id="tabsEvento">
    <ul>
        <li><a href="#tabsEvento-1"><?php echo $this->lang->line('Necesidades Pendientes Aprobacion'); ?></a></li>
        <li><a href="#tabsEvento-2"><?php echo $this->lang->line('Necesidades Publicados'); ?></a></li>
    </ul>
    <div id="tabsEvento-1">
        <table id="evento1" class="table table-striped table-bordered display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('Descripcion'); ?></th>
                    <th><?php echo $this->lang->line('Fecha Inicio'); ?></th>
                    <th><?php echo $this->lang->line('Fecha Final'); ?></th>
                    <th><?php echo $this->lang->line('Tipo Actividad'); ?></th>
                    <th><?php echo $this->lang->line('Tipo Clasificacion'); ?></th>
                    <th><?php echo $this->lang->line('Pais Organizador'); ?></th>
                    <th><?php echo $this->lang->line('Mas Información'); ?></th>
                    <th><?php echo $this->lang->line('Aprobar'); ?></th>
                    <th><?php echo $this->lang->line('Editar'); ?></th>
                    <th><?php echo $this->lang->line('Borrar'); ?></th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($eventos_pendientes as $row) {
    ?>
        <tr>
            <td>
                <?php echo $row->descripcion ?>
            </td>
            <td>
                <?php echo $row->fecha_inicio ?>
            </td>
            <td>
                <?php echo $row->fecha_fin ?>
            </td>                        
            <td>
                <?php echo $this->lang->line($row->desc_acti_es); ?>
            </td>
            <td>
                <?php echo $this->lang->line("clasificacion".$row->tipo_clasificacion) ?>
            </td>
            <td>
                <?php $pais = substr(strtolower($row->codi_pais),0,2);?>
                <img src="<?php echo base_url('assets/banderas/iso/'.$pais.'.png') ?>" width="30px">
            </td>
            <td>
                <center>
                    <a href="<?php echo base_url('uploads/' . $row->nombre) ?>" target="_blank">
                        <i class="fa fa-fw fa-file fa-lg"></i><br><?php echo $row->nombre ?>
                    </a>
                </center>
            </td>
            <td>
                <center>
                    <a href="<?php echo base_url('administrador/eventos_necesidad/aprobarEvento/' . $row->id_evento) ?>">
                        <img src="<?php echo base_url('assets/img/si.png') ?>" width="30px">
                    </a>
                </center>
            </td>
			<td>
				<center>
                    <a href="<?php echo base_url('administrador/eventos_necesidad/modificarEvento/' . $row->id_evento) ?>">
                        <img src="<?php echo base_url('assets/img/editar.png') ?>" width="30px">
                    </a>
                </center>
			</td>
			<td>
				<center>
                    <a  onclick="borrarEventoAdmNecesidad(<?php echo $row->id_evento?>)" href="#">
                        <img src="<?php echo base_url('assets/img/no.png') ?>" width="30px">
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
    <div id="tabsEvento-2">
        <table id="evento2" class="table table-striped table-bordered display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('Descripcion'); ?></th>
                    <th><?php echo $this->lang->line('Fecha Inicio'); ?></th>
                    <th><?php echo $this->lang->line('Fecha Final'); ?></th>
                    <th><?php echo $this->lang->line('Tipo Actividad'); ?></th>
                    <th><?php echo $this->lang->line('Tipo Clasificacion'); ?></th>
                    <th><?php echo $this->lang->line('Pais Organizador'); ?></th>
                    <th><?php echo $this->lang->line('Mas Información'); ?></th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($eventos_publicados as $row) {
    ?>
        <tr>
            <td>
                <?php echo $row->descripcion ?>
            </td>
            <td>
                <?php echo $row->fecha_inicio ?>
            </td>
            <td>
                <?php echo $row->fecha_fin ?>
            </td>                        
            <td>
                <?php echo $this->lang->line($row->desc_acti_es); ?>
            </td>
            <td>
                <?php echo $this->lang->line("clasificacion".$row->tipo_clasificacion) ?>
            </td>
            <td>
                <?php $pais = substr(strtolower($row->codi_pais),0,2);?>
                <img src="<?php echo base_url('assets/banderas/iso/'.$pais.'.png') ?>" width="30px">
            </td>
            <td>
                <center>
                    <a href="<?php echo base_url('uploads/' . $row->nombre) ?>" target="_blank">
                        <i class="fa fa-fw fa-file fa-lg"></i><br><?php echo $row->nombre ?>
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


<div id="borrarEveNeceAdm-confirm" title="<?php echo $this->lang->line('Borrar Evento'); ?>">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $this->lang->line('Esta seguro que quiere borrar esta necesidad'); ?></p>
</div>