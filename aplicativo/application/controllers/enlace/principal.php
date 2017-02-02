<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Principal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('general_model');
        $this->load->model('login_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');
        
         if (!($this->session->userdata('language'))) {
            $this->session->set_userdata('language', 'spanish');
        }        
        $user_language = $this->session->userdata('language');        
        $this->lang->load('rtc_' . $user_language, $user_language);
    }

    public function index() {
        
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/principal";
        $this->load->view('plantilla', $datos);
		
    }

}
