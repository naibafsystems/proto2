<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cambio_pass extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('general_model');
        $this->load->helper(array('url', 'form', 'html'));
        $this->load->library('session');
    }

    public function index() {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "transversal/cambiar_pass";

        $this->load->view('plantilla', $datos);
    }

    public function actualizarPass() {
        
        $datos['clave'] = sha1(md5($_REQUEST['inputPass']));
        
        $this->general_model->actualizarPass($this->session->userdata('id_usuario'),$datos['clave']);
        $this->session->set_flashdata('passCambiado', 'Se realiz&oacute; el cambio de contrase&ntilde;a con exito');
        switch ($this->session->userdata('rol')) {
            case '':
                $datos['token'] = $this->token();
                $datos["contenido"] = "login/login";
                $this->load->view('plantilla', $datos);
                break;
            case "1":
                
                redirect(base_url() . 'administrador/principal');
                break;
            case "2":
                redirect(base_url() . 'coordinador/principal');
                break;
            case "3":
                redirect(base_url() . 'ciudadano/principal');
                break;
            case "4":
                redirect(base_url() . 'administrador/usuarios');
                break;
            default:
                $datos['token'] = $this->token();
                $datos["titulo"] = "RTC";
                $datos["contenido"] = "login/login";
                $this->load->view('plantilla', $datos);
                break;
        }
    }
}
