<?php
$correoRegistrado = $this->session->flashdata('correoRegistrado');
if ($correoRegistrado) {
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong>Error!</strong> <?php echo $correoRegistrado ?>
    </div>
    <?php
}

$identificacionRegistrado = $this->session->flashdata('identificacionRegistrado');
if ($identificacionRegistrado) {
    ?>
    <div class="alert alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong>Error!</strong> <?php echo $identificacionRegistrado ?>
    </div>
    <?php
}
?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center"><?php echo $this->lang->line('Administraci&oacute;n de Grupos de Trabajo'); ?></h1>
                <form class="form-horizontal" role="form" id="formCrearGrupo" action="<?php echo base_url('administrador/grupos_trabajo/actualizarGrupo') ?>" name="formCrearGrupo" method="post">
                    
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="inputNombre" class="control-label"><?php echo $this->lang->line('Nombre del Grupo:'); ?></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $infoGrupo[0]->nombre_grupo;?>" class="validate[required] form-control" id="inputNombre" name="inputNombre" placeholder="<?php echo $this->lang->line('Nombre del grupo de trabajo'); ?>">
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="inputObjetivo" class="control-label"><?php echo $this->lang->line('Objetivo del Grupo:'); ?></label>
                        </div>
                        <div class="col-sm-6">
                            <textarea type="text" class="validate[required] form-control" id="inputObjetivo" name="inputObjetivo" placeholder="<?php echo $this->lang->line('Objetivo del grupo de trabajo'); ?>"><?php echo $infoGrupo[0]->objetivo;?></textarea>
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <div class="col-sm-4 text-right">
                            <label class="control-label"><?php echo $this->lang->line('Coordinador:'); ?></label>
                        </div>
                        <div class="col-sm-6">
                            <select class="validate[required] form-control select2-select" id="coordinador" name="coordinador">
                                <option value=''>Seleccione...</option>
                                    <?php
                                    foreach ($coordinadores as $pa) {
										if($infoGrupo[0]->id_coordinador == $pa->id_usuario)
										{
											echo "<option value='" . $pa->id_usuario . "' selected>" . $pa->nombres ." ". $pa->apellidos ."</option>";
										}else
										{
											echo "<option value='" . $pa->id_usuario . "'>" . $pa->nombres ." ". $pa->apellidos ."</option>";
										}
                                        
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
							<input type="hidden" name="id_grupo" id="id_grupo" value="<?php echo $infoGrupo[0]->id_grupo; ?>">
                            <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-check"></i><?php echo $this->lang->line('Guardar'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>