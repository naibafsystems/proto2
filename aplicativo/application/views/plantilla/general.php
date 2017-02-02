<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>">
        
        <script src="<?php echo base_url('assets/js/jquery-1.11.3.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('assets/js/scripts-rtc.js')?>"></script>
        
    </head>
    <body>
        <header>
            <?php
                $this->load->view('plantilla/top-bar.php');
            ?>
        </header>
        <nav>
            <?php
                $this->load->view('plantilla/nav-bar.php');
            ?>
        </nav>
        <footer>
            <?php
                $this->load->view('plantilla/bottom-bar')
            ?>
        </footer>
    </body>
</html>
