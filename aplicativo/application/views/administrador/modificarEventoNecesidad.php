<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center"><?php echo $this->lang->line('Crear Necesidad'); ?></h3>
                <form class="form-horizontal" enctype="multipart/form-data" role="form" id="formCrearEvento" action="<?php echo base_url('administrador/eventos_necesidad/actualizarEvento/') ?>" name="formCrearEvento" method="post">
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="descripcion" class="control-label"><?php echo $this->lang->line('Descripci&oacute;n:'); ?></label>
                        </div>
                        <div class="col-sm-6">
                            <textarea class="validate[required, min[10]] form-control" id="descripcion" name="descripcion"><?php echo $infoEvento[0]->descripcion;?></textarea>
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="actividad" class="control-label"><?php echo $this->lang->line('Tipo Actividad:'); ?></label>
                        </div>
                        <div class="col-sm-6">
                            <select class="validate[required] form-control select2-select" id="actividad" name="actividad">
                                <option value=""><?php echo $this->lang->line('Seleccione...'); ?></option>
                                <?php
                                $grupo = 0;
                                
                                foreach ($tipo_actividad as $row) {
                                    
                                    if($row->grupo != $grupo)
                                        {
                                            if($row->grupo > 1)
                                                {
                                                    echo "</optgroup>";
                                                }
                                            switch($row->grupo)
                                            {
                                                case 1:
                                                    echo "<optgroup label='".$this->lang->line('Actividad Academica')."'>";
                                                    break;
                                                
                                                case 2:
                                                    echo "<optgroup label='".$this->lang->line('Actividad General')."'>";
                                                    break;
                                            }
                                            
                                            $grupo = $row->grupo;
                                        }
									if($infoEvento[0]->tipo_actividad == $row->id_tipo_actividad)
									{	
										echo "<option value='" . $row->id_tipo_actividad . "' selected>" . $this->lang->line($row->descripcion_es) . "</option>";
									}else
									{
										echo "<option value='" . $row->id_tipo_actividad . "'>" . $this->lang->line($row->descripcion_es) . "</option>";
									}
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="clasificacion" class="control-label"><?php echo $this->lang->line('Tipo Clasificación'); ?>:</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="validate[required] form-control select2-select" id="clasificacion" name="clasificacion">
                                <option value=""><?php echo $this->lang->line('Seleccione...'); ?></option>
                                <?php
                                foreach ($tipo_clasificacion as $row) {
									if($infoEvento[0]->tipo_clasificacion == $row->id_tipo_clasificacion)
									{
										echo "<option value='" . $row->id_tipo_clasificacion . "' selected>" . $this->lang->line("clasificacion".$row->id_tipo_clasificacion) . "</option>";
									}else
									{
										echo "<option value='" . $row->id_tipo_clasificacion . "'>" . $this->lang->line("clasificacion".$row->id_tipo_clasificacion) . "</option>";	
									}
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="inputFechini" class="control-label"><?php echo $this->lang->line('Fecha Inicio Actividad'); ?>:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $infoEvento[0]->fecha_inicio?>" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="validate[required] form-control" id="inputfechini" name="inputfechini" placeholder="<?php echo $this->lang->line('Fecha de Inicio de la Actividad'); ?>">
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div>                    
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="inputFechfin" class="control-label"><?php echo $this->lang->line('Fecha Final Actividad'); ?>:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $infoEvento[0]->fecha_fin?>" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="validate[required] form-control" id="inputfechfin" name="inputfechfin" placeholder="<?php echo $this->lang->line('Fecha de Finalizaci&oacute;n de la Actividad'); ?>">
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div> 
                    
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="contacto" class="control-label"><?php echo $this->lang->line('Correo de contacto').":"; ?></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $infoEvento[0]->contacto?>" class="validate[required, custom[email]] form-control" id="contacto" name="contacto"/>
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div> 
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="link" class="control-label"><?php echo $this->lang->line('link Informacion').":"; ?></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $infoEvento[0]->link?>" class="validate[min[10], custom[url]] form-control" id="link" name="link"/>
                            <span class="fa fa-check form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="col-sm-4 text-right">
                            <label for="userfile" class="control-label"><?php echo $this->lang->line('DocumentoActividad').":"; ?></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="file" class="" id="documento" name="documento">                            
                        </div>
                    </div>                     
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
							<input type="hidden" value="<?php echo $infoEvento[0]->id_evento?>" name="id_evento" id="id_evento">
							<input type="hidden" value="<?php echo $infoEvento[0]->id_archivo?>" name="id_archivo" id="id_archivo">
                            <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-check"></i><?php echo $this->lang->line('Guardar'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>