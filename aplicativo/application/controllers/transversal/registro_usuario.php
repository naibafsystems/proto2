<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro_usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('general_model');
        $this->load->model('usuarios_model');
        $this->load->model('grupos_model');
        $this->load->helper(array('url', 'form', 'html'));
        //$this->load->library('session');
    }

    public function index() {

        $datos["titulo"] = "Registro de Usuarios";
        $datos["contenido"] = "transversal/registro_usuario";
        $datos["id_grupo"] = $id_grupo;

        $this->load->view('plantilla', $datos);
    }

    public function formulario($id_grupo) {

        $datos["titulo"] = "Registro de Usuarios";
        $datos["contenido"] = "transversal/registro_usuario";
        $datos['paises'] = $this->usuarios_model->paises();
        $datos["id_grupo"] = $id_grupo;

        $this->load->view('plantilla', $datos);
    }

    public function guardarUsuario() {
    	
    	$this->load->library('My_PHPMailer');
    	$this->load->library('email');
    	
		
		$resultadoUserVali = $this->usuarios_model->validarUsuarioIdentificacion($_REQUEST['tipo_iden'], $_REQUEST['inputNumeIden']);
		if($_REQUEST['inputEmail']!=$_REQUEST['inputEmailConf']){
			echo "<script>alert('Los correos no coinciden')</script>";
			redirect(base_url(), 'refresh');
			exit;
		}
		if($_REQUEST['inputClave']!=$_REQUEST['inputClaveConf']){
			echo "<script>alert('Las claves no coinciden')</script>";
			redirect(base_url(), 'refresh');
			exit;
		}
		if($resultadoUserVali == '')
		{
			$resultadoEmailVali = $this->usuarios_model->validarUsuarioCorreo($_REQUEST['inputEmail']);
			
			if($resultadoEmailVali == '')
			{
			
				$datosU['tipo_iden'] = $_REQUEST['tipo_iden'];
				$datosU['nume_iden'] = $_REQUEST['inputNumeIden'];
				$datosU['nombres'] = utf8_encode($_REQUEST['inputNombres']);
				$datosU['apellidos'] = utf8_encode($_REQUEST['inputApellidos']);
				$datosU['fecha_naci'] = $_REQUEST['fechaNaci'];
				$datosU['sexo'] = $_REQUEST['sexo'];

				//Se registra la informacion del usuario, restorna el ID que asigna la BD
				$resultadoID = $this->usuarios_model->insertarUsuario($datosU);
				//$resultadoID = 4;
				if ($resultadoID) {
					$datosRol['id_usuario'] = $resultadoID;
					$datosRol['rol'] = 3;
					$datosRol['estado'] = 'AC';
					$resultadoRol = $this->usuarios_model->insertarRolUsuario($datosRol);
								
					$psswd = $_REQUEST['inputClave'];
					$datosLogin['usuario_id_usuario'] = $resultadoID;
					$datosLogin['usuario'] = $_REQUEST['inputEmail'];
					$datosLogin['clave'] = sha1(md5($psswd));
					$datosLogin['estado'] = 'IN';
					//$datosLogin['estado'] = 'AC';

					$resultadoLogin = $this->usuarios_model->insertarDatosLogin($datosLogin);
								
					$datosActi = $resultadoID;
					
					$datosLink = strrev(base64_encode($datosActi));
					$link = base_url('transversal/registro_usuario/activar/'.$datosLink);
					
					
					$this->load->library('My_PHPMailer');
    				$this->load->library('email');

    				$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => '0u67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
    				$this -> email -> initialize($configMail);
    				
					$this -> email -> from('aplicaciones@dane.gov.co', 'Banco Hojas de Vida');
			    	$this -> email -> to($datosLogin['usuario']);
			    	$this -> email -> subject('Correo de Activacion - Banco de Hojas de Vida DANE');
					
					$html = '			
					  <p>Bienvenido</p>
					  <p>'.$_REQUEST['inputNombres'].',</p>
					  <p>Gracias por registrarte! Para activar tu cuenta es necesario ingresar al siguiente vinculo:</p>
					  <p>'.$link.'</p>
					  <p>Los datos de ingreso son los siguientes:<br>
					  Usuario: ' . $_REQUEST['inputEmail'] . '<br>
					  </p>
					  <p>Recuerda que puedes cambiar tu contrase&ntilde;a despues de ingresar a la plataforma.</p>';

					
					$this -> email -> message($html);
			    	$this -> email -> send();
					
					$this->session->set_flashdata('retornoExito', 'Registro Exitoso. Para activar su cuenta es necesario que ingrese al link de activaci&oacute;n enviado a su correo electr&oacute;nico');
					redirect(base_url(), 'refresh');
				}else{
					$this->session->set_flashdata('retornoError', 'Ocurrio un error al intentar guardar el registro.');
					redirect(base_url(), 'refresh');
				}
			}else{
				$this->session->set_flashdata('retornoError', 'El correo electr&oacute;nico ya se encuentra registrado.');
				redirect(base_url(), 'refresh');
			}
        }else {
            $this->session->set_flashdata('retornoError', 'El usuario ya se encuentra registrado.');
            redirect(base_url(), 'refresh');
        }
    }
	
	public function activar($usuario)
	{
		$dato = strrev($usuario);
		$dato = base64_decode($dato);
		
		$resultadoLogin = $this->usuarios_model->activarCuenta($dato);
		$resultadoLogin = $this->usuarios_model->activarFecha($dato);
		
		$this->session->set_flashdata('retornoExito', 'Activaci&oacute;n Exitosa, Ingrese con su usuario y contrase&ntilde;a');
		redirect(base_url(), 'refresh');
	}

}
