<?php
$usuario_incorrecto = $this->session->flashdata('usuario_incorrecto');
if ($usuario_incorrecto) {
    ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong> <?php echo $usuario_incorrecto ?>
    </div>
    <?php
}


$registroExitoso = $this->session->flashdata('registroExitoso');
if ($registroExitoso) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <strong><?php echo $registroExitoso ?></strong> 
    </div>
    <?php
}
?>

<div  class="container">
    <form class="form-signin" action="<?php echo base_url('login/validar_user') ?>" id="login" name="login" method="post">
        <h2 class="form-signin-heading"><?php echo $this->lang->line('titulo_inicio'); ?></h2>
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <label for="usuario" class="sr-only">Correo electr&oacute;nico</label>		
        <input type="email" id="usuario" name="usuario" class="validate[required,custom[email]]  form-control" placeholder="Correo electr&oacute;nico" required="" autofocus="">

        <label for="pass" class="sr-only"><?php echo $this->lang->line('contrasena'); ?></label>
        <input type="password" id="pass" name="pass" class="validate[required] form-control" placeholder="<?php echo $this->lang->line('contrasena'); ?>" required="">
        <p class="text-center">
            <a href="<?php echo base_url('login/recordar_clave') ?>"><?php echo $this->lang->line('recordar_pass'); ?></a>
        </p>
        <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $this->lang->line('ingresar'); ?></button>
    </form>
</div>