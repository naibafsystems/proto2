<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DANE - Banco de Hojas de Vida</title>

        <link href="<?= base_url('assets/css/general/estiloGeneral.css') ?>" rel="stylesheet" media="screen">
        <link href="<?= base_url('assets/css/general/login.css') ?>" rel="stylesheet" media="screen">
        <link href="<?= base_url('assets/css/general/carousel.css') ?>" rel="stylesheet" media="screen">
        <link href="<?= base_url('assets/css/bootstrap/bootstrap.css') ?>" rel="stylesheet" media="screen">
        <link href="<?= base_url('assets/css/bootstrap/bootstrap-theme.css') ?>" rel="stylesheet" media="screen">
        <link href="<?= base_url('assets/css/general/validationEngine.jquery.css') ?>" rel="stylesheet" type="text/css">
        <!--<link href="<?= base_url('assets/css/general/jquery-ui.css') ?>" rel="stylesheet" type="text/css">-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="<?= base_url('assets/css/general/ui.jqgrid.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/general/ui.jqgrid-bootstrap.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/bootstrap/datatable-bootstrap.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/general/datatable-tools.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/bootstrap/bootstrap_pingedo.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/general/select2.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/general/select2-bootstrap.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/style.css')?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/general/multi-select.css')?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/general/fileinput/fileinput.css')?>" media="all" rel="stylesheet" type="text/css" />        
        <link href="<?= base_url('assets/css/general/tree/jquery.tree-multiselect.css')?>" media="all" rel="stylesheet" type="text/css" />        
        <link href="<?= base_url('assets/css/general/datepicker3.min.css')?>" media="all" rel="stylesheet" type="text/css" />        
        <link href="<?= base_url('assets/css/sistema.css')?>" media="all" rel="stylesheet" type="text/css" />     
        <link href="<?= base_url('assets/css/general/buttons.dataTables.min.css')?>" media="all" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/css/general/tabs_bootstrap.css')?>" media="all" rel="stylesheet" type="text/css" />        
        <link href="<?= base_url('assets/css/general/bootstrap_table.css')?>" media="all" rel="stylesheet" type="text/css" />
		
        <script type="text/javascript">
            var baseurl = "<?php print base_url(); ?>";
            var lenguaje = "<?php print $this->session->userdata('language'); ?>";
        </script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script type="text/javascript" src="<?= base_url('assets/js/general/principales/jquery-1.11.js') ?>"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script type="text/javascript" src="<?= base_url('assets/js/bootstrap/bootstrap.js') ?>"></script>       
        
        <?php 
        
        if($this->session->userdata('language') == 'english')
            {
            ?>
                <script type="text/javascript" src="<?= base_url('assets/js/general/principales/jquery.validationEngine-en.js') ?>"  charset="utf-8"></script>
            <?php
            }else
                {
                ?>
                    <script type="text/javascript" src="<?= base_url('assets/js/general/principales/jquery.validationEngine-es.js') ?>"  charset="utf-8"></script>
                <?php
                }
        
        ?>
        
        <script type="text/javascript" src="<?= base_url('assets/js/general/principales/jquery.validationEngine.js') ?>"  charset="utf-8"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/jqgrid/i18n/grid.locale-es.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/select2.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/bootstrap-typeahead.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/bootstrap_table.js') ?>"></script>
        <!--<script type="text/javascript" src="<?php echo base_url('assets/js/scripts-rtc.js')?>"></script>-->
        <script>
		  $.fn.bootstrapBtn = $.fn.button.noConflict();
		</script>
        <script type="text/javascript">
            $.jgrid.no_legacy_api = true;
            $.jgrid.useJSON = true;
        </script> 
        <script type="text/javascript" src="<?= base_url('assets/js/general/jqgrid/jquery.jqGrid.min.js') ?>"></script>        
        <!--<script type="text/javascript" src="<?= base_url('assets/js/general/principales/jquery-ui.js') ?>"  charset="utf-8"></script>-->

        <script type="text/javascript" src="<?= base_url('assets/js/general/datatable.js') ?>"></script>        
        <script type="text/javascript" src="<?= base_url('assets/js/bootstrap/datatable-bootstrap.js') ?>"  charset="utf-8"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/datatable-tools.js') ?>"  charset="utf-8"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/jquery.multi-select.js') ?>"  charset="utf-8"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/tinymce/tinymce.min.js') ?>"  charset="utf-8"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/jquery.multi-open-accordion-1.0.1.js') ?>"  charset="utf-8"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/general/fileinput/fileinput.js') ?>" ></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/fileinput/fileinput_locale_es.js')?>" ></script>

        <script type="text/javascript" src="<?= base_url('assets/js/general/retroceso.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/sistema/login.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/sistema/perfil.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/sistema/convocatorias.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/general/sistema/convocatorias_coord.js') ?>"></script>		
        <!--<script type="text/javascript" src="<?= base_url('assets/js/general/sistema/usuarios.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/sistema/grupos.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/sistema/eventos.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/sistema/expertos.js') ?>"></script>-->
        <script type="text/javascript" src="<?= base_url('assets/js/general/bootstrap_datepicker.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/bootstrap_datepicker_es.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/tree/jquery.tree-multiselect.js') ?>"></script>
        
        
        <script type="text/javascript" src="<?= base_url('assets/js/general/dataTables.buttons.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/pdfmake.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/vfs_fonts.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/general/buttons.html5.min.js') ?>"></script>
        
        <script type="text/javascript">
            $(document).ready(function () {


                function formatState (state) {
                    if (!state.id) { return state.text; }
                    var $state = $(
                      '<span> ' + state.text + '</span>'
                    );
                    return $state;
                  };

                $('#cambioIdioma').select2({
                    templateResult: formatState
                  });

                $('#cambioIdioma').change(function() {      
                    
                    var url = baseurl + $(this).val();
                    window.location = url;
                 });
                 
                 
            });
        </script>


    </head>
    <body>
        <header>
            <?php
                $this->load->view('plantilla/top-bar');
            ?>
        </header>
        <?php
        	if($this->session->userdata('rol')){
        	?>
        	<nav>
            <?php            
                $this->load->view('plantilla/nav-bar');
            ?>
        	</nav>
        	<?php
        }
        ?>
        
        <section class="container">
            <?php $this->load->view($contenido) ?>
        </section>
        <footer class="footer">
            <?php
                $this->load->view('plantilla/footer')
            ?>
        </footer>
    </body>
</html>