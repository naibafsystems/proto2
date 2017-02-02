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
		$this->load->model('perfil_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');
		$this->load->model('convocatorias_model');
        
         if (!($this->session->userdata('language'))) {
            $this->session->set_userdata('language', 'spanish');
        }        
        $user_language = $this->session->userdata('language');        
        $this->lang->load('rtc_' . $user_language, $user_language);
    }

    public function index() {
        
		if($this->session->userdata('ciudad') != ''){
			$datos["ciudades"] = $this -> convocatorias_model -> ciudades_coordinador($this->session->userdata('email'));	
			$datos["conv_abiertas"] = $this -> convocatorias_model -> convocatorias_coor_abiertas($this->session->userdata('ciudad'));			
			$datos["conv_cerradas"] = $this -> convocatorias_model -> convocatorias_coor_cerradas($this->session->userdata('ciudad'));
			$datos["contenido"] = "coordinador/convocatorias";
			$this->load->view('plantilla', $datos);
		}else{
			$this -> session -> set_flashdata('retornoError', 'El usuario no tiene asociada completa la informaci&oacute;n');
			redirect(base_url(), 'refresh');
		}
    }
	
	public function verificarDoc($id_convocatoria, $id_conv_insc) {
        
		if($this->session->userdata('ciudad') != ''){
			
			$datos['info_conv'] = $this->convocatorias_model->infoConvMun($id_convocatoria, $id_conv_insc);
			$datos['info_usuarios'] = $this->convocatorias_model->personasInscritas($id_convocatoria, $id_conv_insc);
			$datos['info_requ'] = $this->convocatorias_model->requisitosInscritosMun($id_convocatoria, $id_conv_insc);
			$datos['info_requ2'] = $this->convocatorias_model->requisitosInscritos2($id_convocatoria);
			$datos['info_convocatoriaEsp'] = $this->convocatorias_model->info_convocatoriaEsp($id_convocatoria);
			$datos['id_convocatoria'] = $id_convocatoria;
			$datos['id_conv_insc'] = $id_conv_insc;
			
			$datos["contenido"] = "coordinador/inscritos";
			$this->load->view('plantilla', $datos);
		}else{
			$this -> session -> sess_destroy();
			$this -> session -> set_flashdata('retornoError', 'El usuario no tiene asociada completa la informaci&oacute;n');
			redirect(base_url(), 'refresh');
		}
    }
	
	public function actualizarDoc($id_convocatoria, $id_conv_insc, $id_usuario){
		
			
		$documentos = $_REQUEST['documentos'];
		$observaciones = utf8_encode($_REQUEST['observaciones']);

		$datosUsuario = $this->convocatorias_model->datosUsuario($id_usuario);
		$datosConvocatoria = $this->convocatorias_model->info_convocatoria($id_convocatoria);

		$usuarioDocumentos = $this->convocatorias_model->actualizarDocumentos($id_convocatoria, $id_conv_insc, $id_usuario, $documentos, $observaciones);
		
		if($usuarioDocumentos){
			
			if($documentos == 3){
				
				$usuarioLiberar = $this->convocatorias_model->liberarUsuarioConv($id_usuario, $id_convocatoria, $id_conv_insc);
				
				$this -> load -> library('My_PHPMailer');
	
				$this -> load -> library('email');
				$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => '0u67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
				//cargamos la configuración para enviar mail
				$this -> email -> initialize($configMail);
	
				$this -> email -> from('aplicaciones@dane.gov.co', 'Banco Hojas de Vida');
				$this -> email -> to($datosUsuario[0]->usuario);
				//$this -> email -> to('jonandres.c@gmail.com');
				//$this -> email -> bcc('esanchez1988@gmail.com');
				$this -> email -> subject('Información importante convocatoria DANE');
				
				$html = '
					  <p>Estimado Usuario</p>				
		              <p>
		                Revisados los documentos que usted anexo a la plataforma del DANE - Hojas de Vida frente al
						perfil requerido para la convocatoria a la que se postuló '.$datosConvocatoria[0]->nombre_inv.' - '.$datosConvocatoria[0]->nombre_rol_inv.', nos						
						permitimos informarle que no ha sido elegido para continuar en el proceso, toda vez que según lo						
						manifiesta la Sede y Subsede en la observación de la verificación de requisitos mínimos la cual fue						
						"'.$observaciones.'"
					  </p>						
					  <p>
						Lo invitamos a seguir revisando la plataforma para que aplique a las distintas convocatorias que el	DANE ofrece.
					  </p>';
			
				$this -> email -> message($html);
				if ($this -> email -> send()) {
					
				}
			}

			$this -> session -> set_flashdata('retornoExito', 'La actualizaci&oacute;n se realizo con exito');
			redirect(base_url('coordinador/principal/verificarDoc/'.$id_convocatoria.'/'.$id_conv_insc), 'refresh');
		}else{
			$this->session->set_flashdata('retornoError', 'Error al actualizar el registro, por favor contacte al administrador');
            redirect(base_url('coordinador/principal/verificarDoc/'.$id_convocatoria.'/'.$id_conv_insc), 'refresh');
		}
	}
	
	public function cambiaCiudad(){

		if($_REQUEST['ciudad'] != ''){
			$this->session->set_userdata('ciudad', $_REQUEST['ciudad']);			
		}
	}
	
	public function liberarUsuarios ($datos, $id_convocatoria, $id_conv_insc) {
		
		$usuarios = explode('-',$datos);
		
		for($u=0;$u<count($usuarios);$u++){
			if($usuarios[$u] != ''){
				$usuarioLibres = $this->convocatorias_model->liberarUsuario($usuarios[$u]);
			}
		}
		
		$this -> session -> set_flashdata('retornoExito', 'Se liberaron los usuarios que no cumplen con los requisitos');
		redirect(base_url('coordinador/principal/verificarDoc/'.$id_convocatoria.'/'.$id_conv_insc), 'refresh');
	}

}
