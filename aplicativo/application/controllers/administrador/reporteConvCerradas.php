<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ReporteConvCerradas extends CI_Controller { 

    public function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('general_model');
        $this->load->model('login_model');
        $this->load->model('usuarios_model');
        $this->load->model('convocatorias_model');
        $this->load->model('perfil_model');
        $this->load->helper(array('url', 'form', 'html'));
        $this->load->library('session');
		
    	if (!($this -> session -> userdata('language'))) {
        	$this -> session -> set_userdata('language', 'spanish');
        }
        
        $user_language = $this -> session -> userdata('language');
        /*$this -> lang -> load('rtc_' . $user_language, $user_language);
        
        if(!$this->session->userdata('rol')){
        	$this->session->set_flashdata('retornoError', 'Su sesi&oacute;n finalizo');
        	redirect(base_url(), 'refresh');
        } */
        if($this->session->userdata('rol')!=1 && $this->session->userdata('rol')!=5 && $this->session->userdata('rol')!=6){
        	redirect(base_url(), 'refresh');
        }              
    }

    public function index() {
    	

        $datos["contenido"] = "administrador/reporteConvCerradas";
        $datos['investigaciones'] = $this->convocatorias_model->investigaciones();
        $datos['roles'] = $this->convocatorias_model->roles();
        $datos['ciudades'] = $this->convocatorias_model->ciudades();
        $this->load->view('plantilla', $datos);
    }
	
    
	public function cargaReporte() {		 
		 
		$operativo = trim($this->input->post('operativo'));
		$encuesta_array = $this->input->post('encuesta');
		$rol_array = $this->input->post('rol');
		$cedula = trim($this->input->post('cedula'));
		$nombreC = trim($this->input->post('nombreC'));
		$ciudad_array = $this->input->post('ciudad');
		
		$encuesta="";
		if(is_array($encuesta_array)){
			for ($i=0;$i<count($encuesta_array);$i++){
				$encuesta.=$encuesta_array[$i].",";
			}
			$encuesta = substr($encuesta, 0, -1);
		}		
		$rol="";
		if(is_array($rol_array)){
			for ($i=0;$i<count($rol_array);$i++){
				$rol.=$rol_array[$i].",";
			}
			$rol = substr($rol, 0, -1);
		}
		$ciudad="";
		if(is_array($ciudad_array)){
			for ($i=0;$i<count($ciudad_array);$i++){
				$ciudad.=$ciudad_array[$i].",";
			}
			$ciudad = substr($ciudad, 0, -1);
		}		
		
		if($operativo != '' || $encuesta != '' || $rol != '' || $cedula != '' || $nombreC != '' || $ciudad != ''){				
			
			$datos["reporte"] = $this->convocatorias_model->reporteConvCerradasAdmin($operativo, $encuesta, $rol, $cedula, $nombreC, $ciudad);
			
			if(count($datos["reporte"]) > 0){
        		$this->load->view('administrador/reporteConvCerradasDatos', $datos);
			}else{
				echo "<center><h2>Sin informaci&oacute;n</h2></center>";
			}			
			
		}else{
			echo "<center><h2>Sin informaci&oacute;n</h2></center>";
		}        
    }
}
