
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
		<button type="button" class="navbar-toggle" data-toggle="collapse" 
				data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" rel="home" href="#" title="DEPARTAMENTO ADMINISTRATIVO NACIONAL DE ESTADISTICA">
			<img style="max-width:100px; margin-top: -14px;"
				 src="<?php echo base_url('assets/img/logos_dane_pais2.png') ?>">
		</a>
			
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <ul class="nav navbar-nav">
                    <?php
                    //EN ESTA PARTE SE MANEJA EL MENU DINAMICO PARA LOS DIFERENTES PERFILES
                    $menu_padre = $this->login_model->menu_padre_user($this->session->userdata('rol'));

                    foreach ($menu_padre as $mp) {
                        unset($menu_hijos);
                        $menu_hijos = $this->login_model->menu_hijos_user($mp->id_menu);
                        
                        if (is_array($menu_hijos) && count($menu_hijos) > 0) {
                            ?>
                            <li class="dropdown">
                                <a href="<?php echo $mp->href ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $mp->descripcion ?><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php
                                    foreach ($menu_hijos as $mh) {
                                        ?>
                                        <li><a href="<?php echo base_url($mh->href) ?>"><?php echo $mh->descripcion ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>    
                            <?php
                        } else {
                            ?>
                            <li><a href="<?php echo base_url($mp->href) ?>"><?php echo $mp->descripcion ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <ul class="nav navbar-nav">

                    <?php
                    if ($this->session->userdata('en_sistema') == TRUE) {
                        ?>
                        <li>
                            <p class="navbar-text">
							Bienvenido <?php echo $this->session->userdata('nombre') ?>
							</p>
                        </li>
						<li>
							<button type="button" class="btn btn-danger btn-sm" onclick="location.replace('<?php echo base_url() ?>login/logout_ci')">
								<i class="fa fa-sign-out fa-2x"></i> Cerrar Sesi&oacute;n
                            </button>							
						</li>
                        <?php
                    } 
                    ?>

                </ul>

            </ul>
        </div>        
    </div>
</nav>