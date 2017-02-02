<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grupos_trabajo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('grupos_model');
        $this->load->model('general_model');
        $this->load->model('login_model');
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
        $datos["contenido"] = "administrador/grupos";
        $datos['grupos'] = $this->grupos_model->grupos();

        $this->load->view('plantilla', $datos);
    }

    public function crearGrupo() {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "administrador/crearGrupo";

        $datos['coordinadores'] = $this->grupos_model->coordinadores();
        
        $this->load->view('plantilla', $datos);
    }

    public function guardarGrupo() {
       
        $datosG['nombre_grupo'] = $_REQUEST['inputNombre'];
        $datosG['objetivo'] = $_REQUEST['inputObjetivo'];
        $datosG['id_coordinador'] = $_REQUEST['coordinador'];
        $datosG['estado'] = 'AC';
        
        $resultadoID = $this->grupos_model->insertarGrupo($datosG);

        if ($resultadoID) {
            $this->session->set_flashdata('grupoCreado', $this->lang->line('Se creo el grupo de trabajo') . $_REQUEST['inputNombre'] );
            redirect(base_url('administrador/grupos_trabajo'), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('errorBD'));
            redirect(base_url('administrador/grupos_trabajo'), 'refresh');
        }
    }
    
	public function modificarGrupo($id_grupo)
	{
		$datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
		$datos["infoGrupo"] = $this->grupos_model->datosGrupo($id_grupo);
        $datos["contenido"] = "administrador/modificarGrupo";

        $datos['coordinadores'] = $this->grupos_model->coordinadores();
        
        $this->load->view('plantilla', $datos);
	}
	
	public function actualizarGrupo()
	{
		$datosG['id_grupo'] = $_REQUEST['id_grupo'];
		$datosG['nombre_grupo'] = $_REQUEST['inputNombre'];
        $datosG['objetivo'] = $_REQUEST['inputObjetivo'];
        $datosG['id_coordinador'] = $_REQUEST['coordinador'];
				
        $resultadoID = $this->grupos_model->actualizarGrupo($datosG['id_grupo'], $datosG['nombre_grupo'], $datosG['objetivo'], $datosG['id_coordinador']);

        if ($resultadoID) {
            $this->session->set_flashdata('grupoCreado', $this->lang->line('Se actualizo el grupo de trabajo') . $_REQUEST['inputNombre'] );
            redirect(base_url('administrador/grupos_trabajo'), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('errorBD'));
            redirect(base_url('administrador/grupos_trabajo'), 'refresh');
        }
	}
	
	public function borrarGrupo($idGrupo) {

        $delete = $this->grupos_model->eliminar_grupo($idGrupo);
		$this->session->set_flashdata('grupoCreado', $this->lang->line('El registro se borro con exito'));
        redirect(base_url('administrador/grupos_trabajo'), 'refresh');
    }
	
    public function miembros() {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/grupos";
        $datos['grupos'] = $this->grupos_model->grupos();

        $this->load->view('plantilla', $datos);
    }
}
