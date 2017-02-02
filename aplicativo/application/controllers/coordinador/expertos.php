<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expertos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('grupos_model');
        $this->load->model('general_model');
        $this->load->model('login_model');
        $this->load->model('expertos_model');
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

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/expertos";
        $datos['expertos'] = $this->expertos_model->expertosRegistrados($this->session->userdata('id_usuario'));

        $this->load->view('plantilla', $datos);
    }

    public function crearExperto() {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/crearExperto";
        $datos['fases'] = $this->expertos_model->fases();
        $datos['categoria'] = $this->expertos_model->categoria();
        $datos['nivel_formacion'] = $this->expertos_model->nivel_formacion();
        $datos['temas'] = $this->expertos_model->temas();
        $datos['paises'] = $this->expertos_model->paises();

        $this->load->view('plantilla', $datos);
    }

    public function guardarExperto() {
	
		$datosExp['id_usuario'] = $this->session->userdata('id_usuario');;
		$datosExp['codi_pais'] = $_REQUEST['pais'];
		$datosExp['institucion'] = $_REQUEST['institucion'];
		$datosExp['nombre'] = $_REQUEST['nombres'];
		$datosExp['apellidos'] = $_REQUEST['apellidos'];
		$datosExp['link'] = $_REQUEST['link'];
		$datosExp['experiencia'] = $_REQUEST['experiencia'];
		$datosExp['correo'] = $_REQUEST['contacto'];
		
		$resultadoIDExperto = $this->expertos_model->insertarExperto($datosExp);
		
        if ($resultadoIDExperto) {
			
			for($i=0;$i<count($_REQUEST['nivel']);$i++)
			{
				$datosEstudio['id_experto'] = $resultadoIDExperto;
				$datosEstudio['id_nivel_formacion'] = $_REQUEST['nivel'][$i];
				$datosEstudio['campo_estudio'] = $_REQUEST['campo'][$i]; 
				$datosEstudio['universidad'] = $_REQUEST['universidad'][$i];
				
				$resultadoID = $this->expertos_model->insertarFormacion($datosEstudio);
			}
			
			
			for($j=0;$j<count($_REQUEST['categoria']);$j++)
			{
				$datosTema['id_experto'] = $resultadoIDExperto;
				$datosTema['id_categoria'] = $_REQUEST['categoria'][$j];
				$datosTema['id_fase'] = $_REQUEST['fase'][$j]; 
				
				$resultadoID = $this->expertos_model->insertarTema($datosTema);
			}
        
        if ($resultadoID) {
            
            $this->session->set_flashdata('expertoCreado', $this->lang->line('Se creo la informacion del experto'));
            redirect(base_url('coordinador/expertos/'), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/expertos/'), 'refresh');
        }
    }else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/expertos/'), 'refresh');
        }
    
    
	}
	
	public function borrarExperto($idExperto) {

        $delete = $this->expertos_model->eliminar_experto($idExperto);

        $this->session->set_flashdata('expertoBorrado', $this->lang->line('Se borro el experto'));
        redirect(base_url('coordinador/expertos/'), 'refresh');
    }
}