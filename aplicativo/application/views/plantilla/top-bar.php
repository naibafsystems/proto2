<div class="top-bar">
  <div class="container">
    <div class="row">
    	<div class="col-md-3" style="text-align: center;">
			<a class="text-right" href="#">
			  <img src="<?php echo base_url('assets/imgs/logos_dane_pais2.png')?>" alt="Dane" width="85%"/>
			</a>
    	</div>
    	<div class="col-md-9" style="text-align: right;">
    		<?php 
                if($this->session->userdata('en_sistema') == FALSE)
                    {
					?>
					<form class="navbar-form" role="search" action="<?php echo base_url('login/validar_user') ?>" id="login" name="login" method="post">
						<input type="hidden" name="token" value="<?php echo $token ?>">
						<div class="form-group has-feedback" style="text-align: left;">
							<label class="control-label"><b>Correo electr&oacute;nico</b></label><br>
							<input id="usuario" name="usuario" class="validate[required]  form-control" type="text" placeholder="Usuario"><br>
							&nbsp;
						</div>
						<div class="form-group has-feedback" style="text-align: left;">
							<label class="control-label"><b>Contrase&ntilde;a</b></label><br>
							<input type="password" id="pass" name="pass" class="validate[required] form-control" placeholder="Contrase&ntilde;a"><br>
							<a href="<?php echo base_url('login/recordar_clave');?>">Has olvidado tu contrase&ntilde;a?</a>
						</div>
						
						<button class="btn btn-default btn-lg" style="background-color: #AD124B; color: #FFFFFF" type="submit"><?php echo $this -> lang -> line('ingresar'); ?></button>
					</form>
					<?php
					}else if ($this->session->userdata('en_sistema') == TRUE) {
						?>
							<p class="navbar-text">
								<h1><?php echo $this->session->userdata('nombre') ?></h1>
							</p>
						<?php
						}
				?>
    	</div>      		
    </div>
  </div>
</div>
<div id="colorbar" class="row">

					<div id="color_container" class="hidden-xs">

						<div id="areaa">

							<div class="color4" id="area1"></div>

							<div class="color2" id="area2"></div>

						</div>

						<div class="color5" id="area3"></div>

						<div class="color2" id="area4"></div>

						<div id="areab">

							<div class="color3" id="area5"></div>

							<div class="color4" id="area6"></div>

							<div class="color2" id="area7"></div>

						</div>

						<div id="areac">

							<div class="color4" id="area8"></div>

							<div class="color1" id="area9"></div>

						</div>

						<div class="color2" id="area10"></div>

						<div class="color5" id="area11"></div>

						<div id="aread">

							<div class="color3" id="area12"></div>

							<div class="color6" id="area13"></div>

						</div>

						<div class="color4" id="area14"></div>

						<div id="areae">

							<div class="color1" id="area15"></div>

							<div class="color3" id="area16"></div>

						</div>

						<div id="areaf">

							<div class="color3" id="area17"></div>

							<div class="color2" id="area18"></div>

							<div class="color5" id="area19"></div>

						</div>

						<div id="areag">

							<div class="color6" id="area20"></div>

							<div class="color3" id="area21"></div>

						</div>

						<div class="color1" id="area22"></div>

					</div>

				</div>
			</div>

