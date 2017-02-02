<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center"><?php echo $this->lang->line('Crear Experto'); ?></h3>
                <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formCrearExperto" action="<?php echo base_url('administrador/expertos/guardarExperto/') ?>" name="formCrearExperto" method="post">

                    <div class="panel panel-default">
                        <div class="panel-heading"><?php echo $this->lang->line('Informacion Basica'); ?></div>
                        <div class="panel-body">
                            <div class="form-group has-feedback">                       
                                <div class="col-sm-6">
                                    <label for="nombres" class="control-label"><?php echo $this->lang->line('Nombres') . ":"; ?></label>
                                    <input type="text" class="validate[required, min[3]] form-control" id="nombres" name="nombres"/>
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                                <div class="col-sm-6">
                                    <label for="apellidos" class="control-label"><?php echo $this->lang->line('Apellidos') . ":"; ?></label>
                                    <input type="text" class="validate[required, min[3]] form-control" id="apellidos" name="apellidos"/>
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div> 

                            <div class="form-group has-feedback">                     
                                <div class="col-sm-6">
                                    <label for="pais" class="control-label"><?php echo $this->lang->line('Pais'); ?>:</label>
                                    <select class="validate[required] form-control select2-select" id="pais" name="pais">
                                        <option value=""><?php echo $this->lang->line('Seleccione...'); ?></option>
                                        <?php
                                        foreach ($paises as $row) {
                                            echo "<option value='" . $row->codi_pais . "'>" . $row->desc_pais . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 ">
                                    <label for="institucion" class="control-label"><?php echo $this->lang->line('Institucion') . ":"; ?></label>
                                    <input type="text" class="validate[required, min[3]] form-control" id="institucion" name="institucion"/>
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div>

                            <div class="form-group has-feedback">
                                <div class="col-sm-6">
                                    <label for="contacto" class="control-label"><?php echo $this->lang->line('Correo de contacto') . ":"; ?></label>
                                    <input type="text" class="validate[required, custom[email]] form-control" id="contacto" name="contacto"/>
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                                <div class="col-sm-6">
                                    <label for="link" class="control-label"><?php echo $this->lang->line('link Informacion') . ":"; ?></label>
                                    <input type="text" class="validate[min[10], custom[url]] form-control" id="link" name="link"/>
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div> 

                            <div class="form-group has-feedback">
                                <div class="col-sm-12">
                                    <label for="experiencia" class="control-label"><?php echo $this->lang->line('Experiencia'); ?>:</label>
                                    <textarea class="validate[required, min[10], max[1500]] form-control" id="experiencia" name="experiencia"></textarea>
                                    <span class="fa fa-check form-control-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php echo $this->lang->line('Formacion'); ?></div>
                        <div class="panel-body" id="divNuevoFormacion">							
							<div class="row" id="div_formacion">
								<div class="col-sm-4">
									<label for="nivel" class="control-label"><?php echo $this->lang->line('Nivel'); ?>:</label>
									<select class="validate[required] form-control select2-select" id="nivel" name="nivel[]">
										<option value=""><?php echo $this->lang->line('Seleccione...'); ?></option>
										<?php
										foreach ($nivel_formacion as $row) {
											echo "<option value='" . $row->id_nivel . "'>" . $row->descripcion . "</option>";
										}
										?>
									</select>
								</div>
								<div class="col-sm-4">
									<label for="campo" class="control-label"><?php echo $this->lang->line('Campo') . ":"; ?></label>
									<input type="text" class="validate[required, min[3]] form-control" id="campo" name="campo[]"/>
								</div>
								<div class="col-sm-4">
									<label for="universidad" class="control-label"><?php echo $this->lang->line('Universidad') . ":"; ?></label>
									<input type="text" class="validate[required, min[3]] form-control" id="universidad" name="universidad[]"/>
								</div>
							</div>
                        </div>
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-12">
									<div class="btn btn-info" id="btnAgregarFormacion"><i class="fa fa-fw fa-plus"></i><?php echo $this->lang->line('Agregar Formacion'); ?></div>
									<div class="btn btn-warning" id="btnBorrarFormacion"><i class="fa fa-fw fa-minus"></i><?php echo $this->lang->line('Borrar Formacion'); ?></div>
								</div>
							</div>
						</div>
                    </div>
      
					<div class="panel panel-default">
                        <div class="panel-heading"><?php echo $this->lang->line('Temas Experticia'); ?></div>
                        <div class="panel-body" id="divNuevoTema">
							<div class="row" id="div_tema">	
								<div class="col-sm-6">
									<label for="categoria" class="control-label"><?php echo $this->lang->line('Categoria'); ?>:</label>
									<select class="validate[required] form-control select2-select" id="categoria" name="categoria[]">
										<option value=""><?php echo $this->lang->line('Seleccione...'); ?></option>
										<?php
										foreach ($categoria as $row) {
											echo "<option value='" . $row->id_tipo_clasificacion . "'>" . $this->lang->line('clasificacion'.$row->id_tipo_clasificacion) . "</option>";
										}
										?>
									</select>
								</div>
								<div class="col-sm-6">
									<label for="fase" class="control-label"><?php echo $this->lang->line('Fase'); ?>:</label>
									<select class="validate[required] form-control select2-select" id="fase" name="fase[]">
										<option value=""><?php echo $this->lang->line('Seleccione...'); ?></option>
										<?php
										foreach ($fases as $row) {
											echo "<option value='" . $row->id_fase . "'>" . $row->descripcion . "</option>";
										}
										?>
									</select>
								</div>                            
							</div>
                        </div>
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-12">
									<div class="btn btn-info" id="btnAgregarTema"><i class="fa fa-fw fa-plus"></i><?php echo $this->lang->line('Agregar Tema'); ?></div>
									<div class="btn btn-warning" id="btnBorrarTema"><i class="fa fa-fw fa-minus"></i><?php echo $this->lang->line('Borrar Tema'); ?></div>
								</div>
							</div>
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