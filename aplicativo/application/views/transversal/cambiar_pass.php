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
                        <h1 class="text-center">Cambio de Contrase&ntilde;a</h1>
                        <form class="form-horizontal" role="form" id="formActualizarPass" action="<?php echo base_url('transversal/cambio_pass/actualizarPass')?>" name="formActualizarPass" method="post">
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputPass" class="control-label">Nueva Contrase&ntilde;a:</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="validate[required, minSize[6]] form-control" id="inputPass" name="inputPass" placeholder="Nueva Contrase&ntilde;a">
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-sm-4 text-right">
                                    <label for="inputRepPass" class="control-label">Vuelva a escribir la nueva contrase&ntilde;a:</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="validate[required, equals[inputPass]] form-control" id="inputRepPass" name="inputRepPass" placeholder="Vuelva a escribir la nueva contrase&ntilde;a">
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-2 text-center">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-check"></i>Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>