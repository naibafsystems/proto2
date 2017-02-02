<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');
    }

    public function index() {
        $datos["titulo"] = "Reservaton.co";
        $datos["contenido"] = "reservaton/usuarios";
        $datos['roles'] = $this->usuarios_model->roles();
        
        $datos['listado'] = $this->usuarios_model->obtener_datosRol1();

        $this->load->view('plantilla', $datos);
    }

}
