<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eventos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('grupos_model');
        $this->load->model('general_model');
        $this->load->model('login_model');
        $this->load->model('eventos_model');
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
        $datos["contenido"] = "enlace/eventos";
        $datos['eventos_usuario'] = $this->eventos_model->eventosMiembro($this->session->userdata('id_usuario'));

        $this->load->view('plantilla', $datos);
    }

    public function crearEvento() {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "enlace/crearEvento";
        $datos['paises'] = $this->eventos_model->paises();
        $datos['tipo_clasificacion'] = $this->eventos_model->tipo_clasificacion();
        $datos['tipo_actividad'] = $this->eventos_model->tipo_actividad();

        $this->load->view('plantilla', $datos);
    }

    public function guardarEvento() {

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|png|pdf';
        $config['max_size'] = '10000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('documento')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('errorArchivo', $this->lang->line('Ocurrio un error al intentar subir el archivo'). $this->upload->display_errors());
            redirect(base_url('enlace/eventos/'), 'refresh');
            exit;
        } else {
            $rutaFinal = array('rutaFinal' => $this->upload->data());
        }

        $datosAr['ruta'] = $rutaFinal['rutaFinal']['full_path'];
        $datosAr['nombre'] = $rutaFinal['rutaFinal']['file_name'];
        $datosAr['fecha'] = date('Y-m-d');
        $datosAr['tags'] = "";
        $datosAr['es_publico'] = 1;
        $datosAr['estado'] = 'AC';

        $resultadoID = $this->grupos_model->insertarArchivo($datosAr);
        
        if ($resultadoID) {
            $paises = NULL;
            for ($i=0;$i<count($_REQUEST['pais_organiza']);$i++)    
            {     
                $paises .= $_REQUEST['pais_organiza'][$i].";";        
            }
            
            $dateIni = date_create($_REQUEST['inputfechini']);
            $fechaIni = date_format($dateIni, 'Y-m-d');

            $dateFin = date_create($_REQUEST['inputfechfin']);
            $fechaFin = date_format($dateFin, 'Y-m-d');

            $datosAc['descripcion'] = $_REQUEST['descripcion'];
            $datosAc['tipo_actividad'] = $_REQUEST['actividad'];
            $datosAc['fecha_inicio'] = $fechaIni;
            $datosAc['fecha_fin'] = $fechaFin;
            $datosAc['tipo_clasificacion'] = $_REQUEST['clasificacion'];
            $datosAc['contacto'] = $_REQUEST['contacto'];
            $datosAc['link'] = $_REQUEST['link'];
            $datosAc['id_archivo'] = $resultadoID;
            $datosAc['id_usuario'] = $this->session->userdata('id_usuario');
            $datosAc['paises'] = $paises;
            $datosAc['estado'] = 1;

            $resultadoID = $this->eventos_model->insertarEventos($datosAc);
    
        }
        
        
        if ($resultadoID) {
            
            $this->session->set_flashdata('eventoCreado', $this->lang->line('Se creo el evento') . $_REQUEST['descripcion']);
            redirect(base_url('enlace/eventos/'), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('enlace/eventos/'), 'refresh');
        }
    }
    
    
    public function borrarEvento($idEvento) {

        $delete = $this->eventos_model->eliminar_evento($idEvento);

        $this->session->set_flashdata('eventoBorrada', $this->lang->line('Se borro el evento'));
        redirect(base_url('enlace/eventos/'), 'refresh');
    }
}
