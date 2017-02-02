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
?>
<div id="tabsEvento">
    <ul>
        <li><a href="#tabsEvento-1"><?php echo $this->lang->line('Ofertas Publicados'); ?></a></li>
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
                    <th><?php echo $this->lang->line('Correo de contacto'); ?></th>
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
            <center>
                
                <?php 
                $pais_org = explode(";", $row->paises);

                for($m=0;$m<count($pais_org);$m++)
                {                    
                    if($pais_org[$m] != '')
                    {
                        $nombrePais = $this->eventos_model->infoPais($pais_org[$m]);
                        $pais = substr(strtolower($pais_org[$m]),0,2);
                        ?>
                        <img src="<?php echo base_url('assets/banderas/iso/'.$pais.'.png') ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $nombrePais[0]->desc_pais;?>" width="30px">
                        <?php
                    }
                    
                }
                
                ?>
                
            </center>
            </td>
            <td>
                <?php echo $row->contacto?>
            </td>
            <td>
                <center>
                    <a href="<?php echo base_url('uploads/' . $row->nombre) ?>" target="_blank">
                        <i class="fa fa-fw fa-file fa-lg"></i><br><?php echo $row->nombre ?>
                    </a>
                    <br>
                    <a href="<?php echo $row->link?>">
                        <?php echo $row->link?>
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
foreach ($eventos_nec_publicados as $row) {
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
            <center>
                <?php $pais = substr(strtolower($row->codi_pais),0,2);?>
                <img src="<?php echo base_url('assets/banderas/iso/'.$pais.'.png') ?>" width="30px">
                <br>
                <?php echo $row->contacto?>
            </center>
            </td>
            <td>
                <center>
                    <a href="<?php echo base_url('uploads/' . $row->nombre) ?>" target="_blank">
                        <i class="fa fa-fw fa-file fa-lg"></i><br><?php echo $row->nombre ?>
                    </a>
                    <br>
                    <a href="<?php echo $row->link?>">
                        <?php echo $row->link?>
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


<div id="borrarEveCoor-confirm" title="<?php echo $this->lang->line('Borrar Evento'); ?>">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $this->lang->line('Esta seguro que quiere borrar este evento'); ?></p>
</div>