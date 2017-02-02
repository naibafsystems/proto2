<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {

		parent::__construct();

		$this -> load -> model('login_model');
		$this -> load -> model('general_model');

		$this -> load -> helper(array('url', 'form'));

		$this -> load -> library('session');

		if (!($this -> session -> userdata('language'))) {
			if ($this -> uri -> segment(1) == 'en') {
				$this -> session -> set_userdata('language', 'english');
			} else if ($this -> uri -> segment(1) == 'es') {
				$this -> session -> set_userdata('language', 'spanish');
			} else {
				$this -> session -> set_userdata('language', 'spanish');
			}
		}

		$user_language = $this -> session -> userdata('language');
		$this -> lang -> load('rtc_' . $user_language, $user_language);
	}

	public function validar_user() {

		$username = $this -> input -> post('usuario');
		$password = sha1(md5($this -> input -> post('pass')));
		$passwd = str_replace(array("<", ">", "[", "]", "*", "^", "-", "'", "="), "",$this -> input -> post('pass'));
		$check_user = $this -> login_model -> login_user($username, $password);
		
		if (count($check_user)>0) {

			foreach ($check_user as $t) {

				$data = array('en_sistema' => TRUE, 
				'id_usuario' => $t -> id_usuario, 
				'nombre' => $t -> nombres . " " . $t -> apellidos, 
				'usuario' => $t -> usuario, 
				'email' => $t -> email, 
				'rol' => $t -> rol, 
				'estado' => $t -> estado);
			}

			if ($data['estado'] == 'AC') {
				$this -> session -> set_userdata($data);
				redirect(base_url());
			} else {
				$this -> session -> set_flashdata('retornoError', 'El usuario se encuentra inactivo. Revise el correo electr&oacute;nico para activar la cuenta.'); 
				redirect(base_url(), 'refresh');
			}

		} else {
			/*
			$this -> session -> set_flashdata('retornoError', 'El usuario o contrase&ntilde;a son incorrectos');
			redirect(base_url(), 'refresh');
			*/
			$login = $username;
			
			//LDAP PRODUCCION
			$host = "192.168.1.47";
			$port = "389";
			$basedn = "CN=Aplicaciones,OU=DA,OU=DANE,DC=DANE,DC=GOV,DC=CO";
			$tree = "dc=dane,dc=gov,dc=co";

			$ldap = ldap_connect($host);
			
			//or die ("ERROR: No se ha podido establecer conexión con el servidor LDAP.");
			if ($ldap) {
				ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
				ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
				$bind = ldap_bind($ldap, $basedn, 'app2015') or die("ERROR: No se ha podido establecer enlace con el servidor LDAP.");
				if ($bind) {
					$data["view"] = "login";
					//$result = ldap_search($ldap, $tree, "(|(CN=$login))") or die("Error en la Búsqueda");
					
					$filter = "(|(userprincipalname=".$login."@dane.gov.co))";
					$result = ldap_search($ldap, $tree, $filter) or die("Error en la Búsqueda");
					
					$number_returned = ldap_count_entries($ldap, $result);
					//var_dump($number_returned);exit;
					if ($number_returned > 0) {
						//$info = ldap_get_entries($ldap, $result);
						$info = ldap_get_entries($ldap, $result);
						if ($info[0]) {
							//$user_bind=ldap_bind($ldap,$info[0]["displayname"][0],$passwd) or die("Could not bind to LDAP");
							
							//var_dump($info[0]);
							//$user_bind = ldap_bind($ldap, "(|(CN=$login))", $this -> input -> post('pass'));
							//$user_bind = ldap_bind($ldap, $info[0]["dn"], $this -> input -> post('pass'));
							
							
						//	var_dump($info);exit;						
							error_reporting(0);
							//echo $info[0]["mail"][0]."----".$password;exit;
							$user_bind = ldap_bind($ldap, $info[0]["displayname"][0], $this -> input -> post('pass'));
			//echo $info[0]["samaccountname"][0]."@dane.gov.co"."----".$passwd;exit;			
							if ($user_bind = ldap_bind($ldap, $info[0]["samaccountname"][0]."@dane.gov.co", /*$this -> input -> post('pass')*/$passwd)) {
//echo $info[0]["samaccountname"][0];exit;
								$admin = $this -> login_model -> coordinadores(strtolower($info[0]["samaccountname"][0])."@dane.gov.co");

								if(count($admin) > 0){
									$usuario_data = array('nombre' => $info[0]["displayname"][0],
												'office' => $info[0]["physicaldeliveryofficename"][0],
												'email' => strtolower($info[0]["samaccountname"][0])."@dane.gov.co",
												'rol'=>'2',
												'ciudad'=>$admin[0]->id_ciudad,
												'en_sistema'=>TRUE);
									//$usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["userprincipalname"][0]), 'logueado' => TRUE, 'admin' => TRUE);
									$this -> session -> set_userdata($usuario_data);
									redirect(base_url());
								}else{
									$this -> session -> set_flashdata('retornoError', 'El usuario no tiene permisos para acceder a la plataforma');
									redirect(base_url(), 'refresh');
								}															
								
							
							}else {
									
								$this -> session -> set_flashdata('retornoError', 'El usuario o contrase&ntilde;a son incorrectos');
								redirect(base_url(), 'refresh');
									
								
							}
						} else {
							$this -> session -> set_flashdata('retornoError', 'Datos del usuario incorrectos');
							redirect(base_url(), 'refresh');
						}
					} else {
						
						$result = ldap_search($ldap, $tree, "(|(CN=$login))") or die("Error en la Búsqueda");
						
						$number_returned = ldap_count_entries($ldap, $result);
							
						if ($number_returned > 0) {
							$info = ldap_get_entries($ldap, $result);
								
							if ($info[0]) {
								//$user_bind=ldap_bind($ldap,$info[0]["displayname"][0],$passwd) or die("Could not bind to LDAP");
								error_reporting(0);
						
						
								if ($user_bind = ldap_bind($ldap, $info[0]["displayname"][0], $passwd)) {
									
									$admin = $this -> login_model -> coordinadores(strtolower($info[0]["samaccountname"][0])."@dane.gov.co");
									
										
									$usuario_data = array('name' => $info[0]["displayname"][0],'office' => $info[0]["physicaldeliveryofficename"][0],'mail' => strtolower($info[0]["mail"][0]),'logueado' => TRUE,'admin'=>$admin,'user_ext'=>FALSE, 'id_usuario'=>$datosadmin[0]->id);
									$usuario_data = array('nombre' => $info[0]["displayname"][0],
												'office' => $info[0]["physicaldeliveryofficename"][0],
												'email' => strtolower($info[0]["samaccountname"][0])."@dane.gov.co",
												'rol'=>'2',
												'ciudad'=>$admin[0]->id_ciudad,
												'en_sistema'=>TRUE);
									//$usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["userprincipalname"][0]), 'logueado' => TRUE, 'admin' => TRUE);
									$this -> session -> set_userdata($usuario_data);
									redirect(base_url());
						
								} else {
									$this -> session -> set_flashdata('retornoError', 'Contrase&ntilde;a errada');
									redirect(base_url(), 'refresh');
								}
							} else {
								$this -> session -> set_flashdata('retornoError', 'Error en el usuario o contrase&ntilde;a ingresados.');
								redirect(base_url(), 'refresh');
							}
						}else{
							$this -> session -> set_flashdata('retornoError', 'Error en el usuario o contrase&ntilde;a ingresados');
							redirect(base_url(), 'refresh');
						}
						
						/*
						if($login == 'jnalzater'){
										
								$usuario_data = array('nombre' => 'JOSE NELSON ALZATE RIOS',
											'office' => 'Medellin',
											'email' => "jnalzater@dane.gov.co",
											'rol'=>'2',
											'ciudad'=>'5001',
											'en_sistema'=>TRUE);
								//$usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["userprincipalname"][0]), 'logueado' => TRUE, 'admin' => TRUE);
								$this -> session -> set_userdata($usuario_data);
								redirect(base_url());
								
						}else if($login == 'jmmonroym'){
							$usuario_data = array('nombre' => 'JOSE MARIO MONROY MATOMA',
											'office' => 'Ibague',
											'email' => "jmmonroym@dane.gov.co",
											'rol'=>'2',
											'ciudad'=>'73001',
											'en_sistema'=>TRUE);
							//$usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["userprincipalname"][0]), 'logueado' => TRUE, 'admin' => TRUE);
							$this -> session -> set_userdata($usuario_data);
							redirect(base_url());
							
						}else if($login == 'lpramosv'){
							$usuario_data = array('nombre' => 'LILIANA PATRICIA RAMOS VARGAS',
											'office' => 'Monteria',
											'email' => "lpramosv@dane.gov.co",
											'rol'=>'2',
											'ciudad'=>'23001',
											'en_sistema'=>TRUE);
							//$usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["userprincipalname"][0]), 'logueado' => TRUE, 'admin' => TRUE);
							$this -> session -> set_userdata($usuario_data);
							redirect(base_url());
						}else if($login == 'dnsanchezc'){
							$usuario_data = array('nombre' => 'Dilsa Noalbi Sanchez Cagua',
											'office' => 'San Jose del Gauviare',
											'email' => "dnsanchezc@dane.gov.co",
											'rol'=>'2',
											'ciudad'=>'95001',
											'en_sistema'=>TRUE);
							//$usuario_data = array('name' => $info[0]["displayname"][0], 'office' => $info[0]["physicaldeliveryofficename"][0], 'mail' => strtolower($info[0]["userprincipalname"][0]), 'logueado' => TRUE, 'admin' => TRUE);
							$this -> session -> set_userdata($usuario_data);
							redirect(base_url());
						}else{
							$this -> session -> set_flashdata('retornoError', 'El usuario o contrase&ntilde;a son incorrectos');
							redirect(base_url(), 'refresh');
						}

						$this -> session -> set_flashdata('retornoError', 'Usuario no se encuentra en el servidor');
						redirect(base_url(), 'refresh');*/
					}

					

				} else {

					$this -> session -> set_flashdata('retornoError', 'No se ha podido establecer enlace con el servidor');
					redirect(base_url(), 'refresh');
				}
			}else {
					$this -> session -> set_flashdata('retornoError', 'Error de conexion 101');
					redirect(base_url(), 'refresh');
				}
			ldap_close($ldap);
		}
	
	
				
	}

	public function recordar_clave() {

		$datos["token"] = $this -> token();
		$datos["contenido"] = "login/recordar_clave";
		$this -> load -> view('plantilla', $datos);
	}

	public function enviar_link() {

		$result_user = $this -> login_model -> login_recupera($_REQUEST['usuario']);

		if ($result_user) {
			$clave = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz0123456789', 8)), 0, 8);

			$datosLogin['usuario'] = $_REQUEST['usuario'];
			$datosLogin['clave'] = sha1(md5($clave));

			$cambio = $this -> login_model -> actualizar_pass($datosLogin['usuario'], $datosLogin['clave']);
			
			$this -> load -> library('My_PHPMailer');
	
			$this -> load -> library('email');
			$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => '0u67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
			//cargamos la configuración para enviar mail
			$this -> email -> initialize($configMail);

			$this -> email -> from('aplicaciones@dane.gov.co', 'Banco Hojas de Vida');
			$this -> email -> to($_REQUEST['usuario']);
			//$this -> email -> bcc('esanchez1988@gmail.com');
			$this -> email -> subject('Recuperación clave banco hojas de vida');
			
			$html = ' <p><b>Recuperaci&oacute;n de contrase&ntilde;a</b></p>
		              <p>' . $result_user[0] -> nombres . " " . $result_user[0] -> apellidos . ',</p>
		              <p>Se ha realizado una solicitud para recuperar la contrase&ntilde;a de la cuenta .</p>					
					  <p>Sus datos de ingreso a la plataforma son:</p>					
					  <p><b>Usuario: ' . $_REQUEST['usuario'] . '</b></p>
					  <p><b>Contrase&ntilde;a: ' . $clave . '</b></p>
					  <p>Puede ingresar a la plataforma ingresando al siguiente <a href="' . base_url() . '">link</a></p>
		              <p>Recuerde que puede cambiar su contrase&ntilde;a despues de ingresar a la plataforma.</p>
					  <p><b>DEPARTAMENTO ADMINISTRATIVO NACIONAL DE ESTADITICA (DANE)</b></p>
					  ';
			
			$this -> email -> message($html);
			if ($this -> email -> send()) {
				
			}
			
			$this -> session -> set_flashdata('retornoExito', 'Por favor, revise su correo electr&oacute;nico donde encontrara la informaci&oacute;n necesaria para ingresar a la plataforma');
			redirect(base_url('login/recordar_clave'), 'refresh');
		} else {
			$this -> session -> set_flashdata('retornoError', 'El usuario digitado no se encuentra registrado');
			redirect(base_url('login/recordar_clave'), 'refresh');
		}

	}

	public function token() {

		$token = md5(uniqid(rand(), true));

		$usuario_data = array('token' => $token, 'fecha' => date('Y-m-d H:i:s'), 'logueado' => FALSE);

		$this -> session -> set_userdata($usuario_data);

		return $token;
	}

	public function logout_ci() {

		$this -> session -> sess_destroy();

		redirect(base_url());
	}

}
