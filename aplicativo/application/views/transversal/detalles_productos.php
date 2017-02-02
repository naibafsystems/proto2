<html>    
  <head> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/general/gmap/gmap3.js') ?>"></script>
    <style>
      body{
        text-align:center;
      }
      .gmap3{
        margin: 20px auto;
        border: 1px dashed #C0C0C0;
        width: 800px;
        height: 500px;
      }
    </style>
    
    <script type="text/javascript">
        
      $(function(){
      
        $('#test1').gmap3({
          map:{
            options:{
              center:[-5.7034484,-65.522461],
              zoom: 3
            }
          },
          marker:{
            values:[ 
                <?php 
                
                foreach ($participantes as $row) {
                    
                    ?>
                    {address:"<?php echo strtolower($row->desc_pais)?>", data:"<img src='<?= base_url('assets/banderas/iso/'.substr(strtolower($row->codi_pais),0,2).'.png') ?>'><br><b><?php echo $this->lang->line('Nombre')." : ".$row->nombres." ". $row->apellidos?><br> <?php echo $this->lang->line('Email')." : ".$row->email?><br> <?php echo $this->lang->line('rolMiembro')?></b>", options:{icon: "http://maps.google.com/mapfiles/marker_green.png"}},    
                    <?php
                    
                }
                
                foreach ($coordinadores as $row) {
                    
                    ?>
                    {address:"<?php echo strtolower($row->desc_pais)?>", data:"<img src='<?= base_url('assets/banderas/iso/'.substr(strtolower($row->codi_pais),0,2).'.png') ?>'><br><b><?php echo $this->lang->line('Nombre')." : ".$row->nombres." ". $row->apellidos?><br> <?php echo $this->lang->line('Email')." : ".$row->email?><br> <?php echo $this->lang->line('rolCoordinador')?></b>"},    
                    <?php
                    
                }
                ?>
            ],
            options:{
              draggable: false
            },
            events:{
              mouseover: function(marker, event, context){
                var map = $(this).gmap3("get"),
                  infowindow = $(this).gmap3({get:{name:"infowindow"}});
                if (infowindow){
                  infowindow.open(map, marker);
                  infowindow.setContent(context.data);
                } else {
                  $(this).gmap3({
                    infowindow:{
                      anchor:marker, 
                      options:{content: context.data}
                    }
                  });
                }
              },
              mouseout: function(){
                var infowindow = $(this).gmap3({get:{name:"infowindow"}});
                if (infowindow){
                  infowindow.close();
                }
              }
            }
          }
        });
      });
    </script>
  <body>
        
    <div id="tabsGrupo">
    <ul>
        <li><a href="#tabsGrupo-1"><?php echo $this->lang->line('Participantes'); ?></a></li>
        <li><a href="#tabsGrupo-2"><?php echo $this->lang->line('Productos Grupos de Trabajo'); ?></a></li>
    </ul>
    <div id="tabsGrupo-1">
        <div id="test1" class="gmap3"></div>
    </div>
        
    <div id="tabsGrupo-2">
        <table id="grupos1" class="table table-striped table-bordered display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('Observaci&oacute;n'); ?></th>
                    <th><?php echo $this->lang->line('Fecha'); ?></th>
                    <th><?php echo $this->lang->line('Archivo'); ?></th>
                    <th><?php echo $this->lang->line('Tags'); ?></th>                    
                    <th><?php echo $this->lang->line('P&uacute;blico'); ?></th>                    
                </tr>
            </thead>
            <tbody>
<?php
foreach ($productos as $row) {
    ?>
        <tr>
            <td>
                <?php echo $row->observacion ?>
            </td>
            <td>
                <?php echo $row->fecha ?>
            </td>                          
            <td>
                <a href="<?php echo base_url('uploads/' . $row->nombre) ?>" target="_blank"><?php echo $row->nombre ?></a>
            </td>
            <td>
                <?php echo $row->tags ?>
            </td>                          
            <td>
                <?php
                if ($row->es_publico == 1) {
                    echo "SI";
                } else {
                    echo "NO";
                }
                ?>
            </td>
        </tr>
    <?php
}
?>
            <tbody>
        </table>
    </div>
</div>

    
  </body>
</html>