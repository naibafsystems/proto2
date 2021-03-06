<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ReporteHistorico extends CI_Controller { 

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
    }

    public function index() {
    	

        $datos["contenido"] = "coordinador/reporteHistorico";
        $datos['investigaciones'] = $this->convocatorias_model->investigaciones();
        $datos['roles'] = $this->convocatorias_model->roles();
        $this->load->view('plantilla', $datos);
    }
	
    
	public function cargaReporte() {		 
		 
		$ciudad = $this -> convocatorias_model -> ciudades_coordinador($this->session->userdata('email'));
		$ciudades="";
		for($i=0;$i<count($ciudad);$i++){
			$ciudades.=$ciudad[$i]->id_ciudad.",";
		}
		$ciudades = substr($ciudades, 0, -1);		
		
		$operativo = trim($this->input->post('operativo'));
		$encuesta_array = $this->input->post('encuesta');
		$rol_array = $this->input->post('rol');
		$experiencia = trim($this->input->post('experiencia'));
		$cedula = trim($this->input->post('cedula'));
		$nombreC = trim($this->input->post('nombreC'));
		
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
		
		if($operativo != '' || $encuesta != '' || $rol != '' || $experiencia != '' || $cedula != '' || $nombreC != ''){				
			
			$datos["reporte"] = $this->convocatorias_model->reporteHistorico($operativo, $encuesta, $rol, $experiencia, $ciudades, $cedula, $nombreC);
			
			if(count($datos["reporte"]) > 0){
        		$this->load->view('coordinador/reporteHistoricoDatos', $datos);
			}else{
				echo "<center><h2>Sin informaci&oacute;n</h2></center>";
			}			
			
		}else{
			echo "<center><h2>Sin informaci&oacute;n</h2></center>";
		}        
    }
}
