<?php 
    $correoRegistrado = $this->session->flashdata('correoRegistrado');
    if ($correoRegistrado) 
    {
    ?>
       <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong>Error!</strong> <?php echo $correoRegistrado ?>
      </div>
    <?php
    }
    
    $identificacionRegistrado = $this->session->flashdata('identificacionRegistrado');
    if ($identificacionRegistrado) 
    {
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
                        <h1 class="text-center"><?php echo $this->lang->line('administracionDeUsuarios'); ?></h1>
                        <form class="form-horizontal" role="form" id="formCrearUsuario" action="<?php echo base_url('administrador/usuarios/guardarUsuario')?>" name="formCrearUsuario" method="post">
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputNombres" class="control-label"><?php echo $this->lang->line('Nombres:'); ?></label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" id="inputNombres" name="inputNombres" >
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputApellidos" class="control-label"><?php echo $this->lang->line('Apellidos:'); ?></label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" id="inputApellidos" name="inputApellidos" >
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputCargo" class="control-label"><?php echo $this->lang->line('Cargo:'); ?></label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" id="inputCargo" name="inputCargo" >
									<input type="hidden" name="hidCargo" id="hidCargo">
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputEspeci" class="control-label"><?php echo $this->lang->line('Especialidad:'); ?></label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" id="inputEspeci" name="inputEspeci" >
									<input type="hidden" name="hidEspeci" id="hidEspeci">
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputEmail" class="control-label"><?php echo $this->lang->line('Correo Electronico:'); ?></label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="validate[required, custom[email]] form-control" id="inputEmail" name="inputEmail" >
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 text-right">
                                    <label class="control-label"><?php echo $this->lang->line('Pais - INE:'); ?></label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="validate[required] form-control select2-select" id="pais" name="pais">
                                        <option value=''><?php echo $this->lang->line('Seleccione...'); ?></option>
                                        <?php									
                                        foreach($paises as $pa)
                                        {
                                            echo "<option value='".$pa->codi_pais."'>".$pa->desc_pais."</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
							<div class="form-group">
                                <div class="col-sm-4 text-right">
                                    <label class="control-label"><?php echo $this->lang->line('Tipo de Usuario:'); ?></label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="validate[required] form-control" id="rol_usuario" name="rol_usuario">
                                        <option value=''><?php echo $this->lang->line('Seleccione...'); ?></option>
                                        <?php									
                                        foreach($roles as $ro)
                                        {
                                            echo "<option value='".$ro->id_rol."'>".$this->lang->line($ro->descripcion)."</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-2 text-center">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-check"></i><?php echo $this->lang->line('Guardar'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>