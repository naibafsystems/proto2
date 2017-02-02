<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct');

class Inicio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
		$this->load->model('perfil_model');
        $this->load->helper(array('url', 'form'));        
       
        if($this->uri->segment(1) == 'en')
            {
                $this->session->set_userdata('language', 'english');                
            }else if($this->uri->segment(1) == 'es')
                {
                    $this->session->set_userdata('language', 'spanish');
                }else
                    {
                        $this->session->set_userdata('language', 'spanish');
                    }
            
        if(!($this->session->userdata('language')))
            {
                $this->session->set_userdata('language', 'spanish');
            }
            
        $user_language = $this->session->userdata('language');
        $this->lang->load('rtc_'.$user_language , $user_language);
    
    }

    public function index() {
        
		

        switch ($this->session->userdata('rol')) {
            case '':
                $datos['token'] = $this->token();
                $datos["titulo"] = $this->lang->line('rtc');
                $datos["contenido"] = "transversal/registro_usuario";
                $this->load->view('plantilla', $datos);
                break;
            case "1":
                redirect(base_url() . 'administrador/principal');
                break;
            case "2":
                redirect(base_url() . 'coordinador/principal');
                break;
            case "3":
				
				$datos['datosUsuario'] = $this->perfil_model->datos_usuario($this->session->userdata('id_usuario'));

				$datos['formacionUsuario'] = $this->perfil_model->formacionUsuario($this->session->userdata('id_usuario'));
				$datos['experienciaUsuario'] = $this->perfil_model->experienciaUsuario($this->session->userdata('id_usuario'));
				
				$hv = 20;
				if($datos['datosUsuario'][0]->id_avatar != 0 && $datos['datosUsuario'][0]->rutaDI!= '')
				{
					$hv = $hv + 20;
				}
				
				if(count($datos['formacionUsuario'])>0)
				{
					$hv = $hv + 30;
				}
				
				if(count($datos['experienciaUsuario'])>0)
				{
					$hv = $hv + 30;
				}
				
				if($hv >= 80 && $hv <= 100)
				{
					redirect(base_url('ciudadano/convocatorias'), 'refresh');
				}else{
					redirect(base_url() . 'ciudadano/principal');
				}			
                
                break;
            case "4":
                redirect(base_url() . 'administrador/usuarios');
                break; 
            case "5":
              	redirect(base_url() . 'administrador/principal');
               	break;
            case "6":
                redirect(base_url() . 'administrador/principal'); 
               	break;
            case "7":
            	redirect(base_url() . 'administrador/reporteHistorico');
               	break;
            default:
                $datos['token'] = $this->token();
                $datos["titulo"] = $this->lang->line('rtc');
                $datos["contenido"] = "transversal/registro_usuario";
                $this->load->view('plantilla', $datos);
                break;
        }
    }

    public function token() {
        $token = md5(uniqid(rand(), true));

        $usuario_data = array(
            'token' => $token,
            'fecha' => date('Y-m-d H:i:s'),
            'logueado' => FALSE
        );
        $this->session->set_userdata($usuario_data);

        return $token;
    }

    public function logout_ci() {
        $this->session->sess_destroy();
        $this->index();
    }

    public function create_list($arr) {
        $html = "\n<ul>\n";
        foreach ($arr as $key => $v) {
            $html .= '<li><a href="'.$v['href'].'">' . $v['descripcion'] . "</a></li>\n";
            if (array_key_exists('children', $v)) {
                $html .= "<li>";
                $html .= $this->create_list($v['children']);
                $html .= "</li>\n";
            } else {
                
            }
        }
        $html .= "</ul>\n";
        return $html;
    }

}
