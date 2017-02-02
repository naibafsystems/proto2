<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class adm_usuarios extends CI_Controller {

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
        $this -> lang -> load('rtc_' . $user_language, $user_language);
        
        if(!$this->session->userdata('rol')){
        	$this->session->set_flashdata('retornoError', 'Su sesi&oacute;n finalizo');
        	redirect(base_url(), 'refresh');
        }
        if($this->session->userdata('rol')!=1 && $this->session->userdata('rol')!=5 && $this->session->userdata('rol')!=6){
        	redirect(base_url(), 'refresh');
        }
    }

    public function index() {

        $datos["contenido"] = "administrador/adm_usuarios";
        $this->load->view('plantilla', $datos);
    }
	
	
	public function cargaDatosUsuario() {
		
		$documento = trim($this->input->post('documento'));
		$nombres = trim($this->input->post('nombres'));
		$apellidos = trim($this->input->post('apellidos'));
		$correo = trim($this->input->post('correo'));
		
		if($documento != '' || $nombres != '' || $apellidos != '' || $correo != ''){
			
			$datos["usuarios"] = $this->usuarios_model->consulta_usuario($documento, $nombres, $apellidos, $correo);
			
			if(count($datos["usuarios"]) > 0){
        		$this->load->view('administrador/adm_usuariosDatos', $datos);
				//echo $data;
			}else{
				echo "<center><h2>Sin informaci&oacute;n</h2></center>";
			}			
			
		}else{
			echo "<center><h2>Sin informaci&oacute;n</h2></center>";
		}
        
    }

    public function editarUsuario($idUsuario) {

        $datos["contenido"] = "administrador/editarUsuario";
        $datos['datosUsuario'] = $this->perfil_model->datos_usuario($idUsuario);

        $this->load->view('plantilla', $datos);
    }

    public function actualizarUsuario() {
        $id_usuario = $_REQUEST['id_usuario'];
        $nombres = $_REQUEST['nombres'];
        $apellidos = $_REQUEST['apellidos'];
        $identificacion = $_REQUEST['identificacion'];
        $correo = $_REQUEST['correo'];
        
        //echo $id_usuario."---".$nombres."///".$apellidos."+++".$identificacion."***".$correo;exit;

        $act_usuario = $this->perfil_model->actualizarUsuario($id_usuario, $nombres, $apellidos, $identificacion);
        $act_correo = $this->perfil_model->actualizarCorreo($id_usuario, $correo);
		
    	if($act_usuario && $act_correo){
			$this->session->set_flashdata('retornoExito', 'Se actualizo el registro correctamente');
            redirect(base_url('administrador/adm_usuarios'), 'refresh');
		}else{
			$this->session->set_flashdata('retornoError', 'Error al actualizar el registro');
            redirect(base_url('administrador/adm_usuarios'), 'refresh');
		}
    }

    public function eliminarUsuario($idUsuario) {
    	$delete = $this->perfil_model->eliminar_usuario($idUsuario);
    	
    	if($delete){
        	$this->session->set_flashdata('retornoExito', 'Se elimino el registro correctamente');
            redirect(base_url('administrador/adm_usuarios'), 'refresh');
    	}else{
    		$this->session->set_flashdata('retornoError', 'No se puede eliminar el registro, debido a que esta aplicando a una convocatoria.');
    		redirect(base_url('administrador/adm_usuarios'), 'refresh');
    	}
        
    }
    public function moverInv($idusuario,$cedula) {
    	$cedulas = $this->usuarios_model->consultaridentificacion($cedula);
    	
    	if(count($cedulas)==2){
    		$array_idusuario_ok = $this->usuarios_model->consultarid($idusuario, $cedula);
    		
    		$id_usuario_ok = $array_idusuario_ok[0]->id_usuario;
    		$mover = $this->convocatorias_model->mover_invitacion($idusuario, $id_usuario_ok);
    		$this->session->set_flashdata('retornoExito', 'Se movio la invitaci&oacute;n correctamente');
    		redirect(base_url('administrador/adm_usuarios'), 'refresh');
    	}else{
    		$this->session->set_flashdata('retornoError', 'No se puede mover la invitaci&oacute;n, debido a que la identificacion no tiene dos registros.');
    		redirect(base_url('administrador/adm_usuarios'), 'refresh');
    	}
    
    }

}
