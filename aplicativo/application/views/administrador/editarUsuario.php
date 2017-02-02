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

                        <h1 class="text-center"><?php echo $this->lang->line('Administraci&oacute;n de Usuarios'); ?></h1>
                        <form class="form-horizontal" role="form" id="formEditarUsuario" action="<?php echo base_url('administrador/adm_usuarios/actualizarUsuario')?>" name="formEditarUsuario" method="post">
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputNombres" class="control-label">Nombres:</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $datosUsuario[0]->id_usuario?>">
                                    <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" name="nombres" id="nombres" value="<?php echo utf8_decode($datosUsuario[0]->nombres)?>">                                    
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputApellidos" class="control-label">Apellidos:</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" id="apellidos" name="apellidos" value="<?php echo utf8_decode($datosUsuario[0]->apellidos)?>">                                    
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputIdentificacion" class="control-label">Identificaci&oacute;n:</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" id="identificacion" name="identificacion" value="<?php echo $datosUsuario[0]->nume_iden?>">                               
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputCorreo" class="control-label">correo:</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" id="correo" name="correo" value="<?php echo utf8_decode($datosUsuario[0]->usuario)?>">                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-2 text-center">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-check"></i>Actualizar</button>
                                </div>
                            </div>
                        </form>