<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Productos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('productos_model');
        $this->load->helper(array('url', 'form', 'html'));
        $this->load->library('session');
        
        if(!($this->session->userdata('language')))
            {
                $this->session->set_userdata('language', 'spanish');
            }
            
        $user_language = $this->session->userdata('language');
        $this->lang->load('rtc_'.$user_language , $user_language);
    }

    public function index() {

        $datos["titulo"] = $this->lang->line('Productos Grupos de Trabajo');
        $datos['grupos'] = $this->productos_model->grupos();

        $datos["contenido"] = "transversal/grupos_productos";

        $this->load->view('plantilla', $datos);
    }

    public function detallesGrupo($id_grupo) {
        
        $datos["titulo"] = $this->lang->line('Productos Grupos de Trabajo');
        $datos['coordinadores'] = $this->productos_model->coordinadorGrupo($id_grupo);
        $datos['participantes'] = $this->productos_model->participantesGrupo($id_grupo);
        $datos['productos'] = $this->productos_model->productosGrupos($id_grupo);

        $datos["contenido"] = "transversal/detalles_productos";

        $this->load->view('plantilla', $datos);
    }
}
