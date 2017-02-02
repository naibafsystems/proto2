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

$grupoCreado = $this->session->flashdata('grupoCreado');
if ($grupoCreado) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong><?php echo $grupoCreado ?></strong> 
    </div>
    <?php
}
?>

<div class="row">
    <div class="col-md-2 col-md-offset-5">
        <center>
            <a href="<?php echo base_url('administrador/grupos_trabajo/crearGrupo') ?>">
                <img src="<?php echo base_url('assets/img/grupos.png') ?>">
                <br>
                <?php echo $this->lang->line('Crear Grupo de Trabajo'); ?>
            </a>
        </center>
    </div>
</div>
<div id="tabsGrupo">
    <ul>
        <li><a href="#tabsGrupo-1"><?php echo $this->lang->line('Grupo de Trabajo RTC'); ?></a></li>
    </ul>
    <div id="tabsGrupo-1">
        <table id="grupos1" class="table table-striped table-bordered display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><?php echo $this->lang->line('Nombre Grupo'); ?></th>
                    <th><?php echo $this->lang->line('Objetivo'); ?></th>
                    <th><?php echo $this->lang->line('Coordinador'); ?></th>
                    <th><?php echo $this->lang->line('Editar'); ?></th>
                    <th><?php echo $this->lang->line('Borrar'); ?></th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($grupos as $row) {
    ?>
        <tr>
            <td>
                <?php echo $row->id_grupo ?>
            </td>
            <td>
                <?php echo $row->nombre_grupo ?>
            </td>
            <td>
                <?php echo $row->objetivo ?>
            </td>                        
            <td>
                <?php echo $row->email ?>
            </td>
			<td>
				<center>
                    <a href="<?php echo base_url('administrador/grupos_trabajo/modificarGrupo/' . $row->id_grupo) ?>">
                        <img src="<?php echo base_url('assets/img/editar.png') ?>" width="30px">
                    </a>
                </center>
			</td>
			<td>
				<center>
                    <a  onclick="borrarGrupo(<?php echo $row->id_grupo?>)" href="#">
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
</div>


<div id="borrarGrupo-confirm" title="Borrar Grupo">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $this->lang->line('Seguro que quiere borrar este registro'); ?></p>
</div>
