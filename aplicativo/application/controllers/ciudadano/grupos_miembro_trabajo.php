<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grupos_miembro_trabajo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('grupos_miembro_model');
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
        $datos["contenido"] = "miembro/grupos";
        $datos['grupos'] = $this->grupos_miembro_model->gruposMiembro($this->session->userdata('id_usuario'));

        $this->load->view('plantilla', $datos);
    }

    public function actividades($id_grupo) {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "miembro/actividades";
        $datos['ac_pendientes'] = $this->grupos_miembro_model->actividadesPendientes($id_grupo);
        $datos['ac_resueltas'] = $this->grupos_miembro_model->actividadesResueltas($id_grupo);
        $datos['datosGrupo'] = $this->grupos_miembro_model->datosGrupo($id_grupo);

        $this->load->view('plantilla', $datos);
    }

    
    public function seguimientoActividad($id_actividad) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "miembro/seguimientoActividad";

        $datos['observaciones'] = $this->grupos_miembro_model->observaciones($id_actividad);
        $datos['productos'] = $this->grupos_miembro_model->productos($id_actividad);
        $datos['datosActividad'] = $this->grupos_miembro_model->datosActividad($id_actividad);

        $this->load->view('plantilla', $datos);
    }

    public function observacionActividad($id_actividad) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "miembro/observacionActividad";

        $datos['datosActividad'] = $this->grupos_miembro_model->datosActividad($id_actividad);

        $this->load->view('plantilla', $datos);
    }

    public function guardarObservacion($id_actividad) {

        $datosActividad = $this->grupos_miembro_model->datosActividad($id_actividad);

        $datosAc['id_actividad'] = $id_actividad;
        $datosAc['observaciones'] = $_REQUEST['observacion'];
        $datosAc['fecha'] = date('Y-m-d');

        $resultadoID = $this->grupos_miembro_model->insertarObservacion($datosAc);

        if ($resultadoID) {

            $this->session->set_flashdata('observacionCreada', $this->lang->line('Se creo la observacion para la actividad') . $datosActividad[0]->descripcion);
            redirect(base_url('miembro/grupos_miembro_trabajo/seguimientoActividad/' . $id_actividad), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('miembro/grupos_miembro_trabajo/seguimientoActividad/' . $id_actividad), 'refresh');
        }
    }

    public function foros($id_grupo) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "miembro/listaForos";

        $datos['datosGrupo'] = $this->grupos_miembro_model->datosGrupo($id_grupo);
        $datos['id_grupo'] = $id_grupo;
        $datos['forosGrupo'] = $this->grupos_miembro_model->forosGrupo($id_grupo);
        
        $this->load->view('plantilla', $datos);
    }

    public function foroDetalle($id_grupo, $id_foro) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "miembro/foroDetalle";

        $datos['datosGrupo'] = $this->grupos_miembro_model->datosGrupo($id_grupo);
        $datos['id_grupo'] = $id_grupo;
        $datos['detalleForo'] = $this->grupos_miembro_model->detalleForo($id_foro);
        $datos['respuestasForo'] = $this->grupos_miembro_model->respuestasForo($id_foro);

        $this->load->view('plantilla', $datos);
    }

    public function responderForo($id_grupo, $id_foro) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "miembro/responderForo";

        $datos['datosGrupo'] = $this->grupos_miembro_model->datosGrupo($id_grupo);
        $datos['id_grupo'] = $id_grupo;
        $datos['id_foro'] = $id_foro;
        $datos['detalleForo'] = $this->grupos_miembro_model->detalleForo($id_foro);
        $datos['respuestasForo'] = $this->grupos_miembro_model->respuestasForo($id_foro);

        $this->load->view('plantilla', $datos);
    }

    public function guardarRespuesta() {

        $id_foro = $_REQUEST['id_foro'];
        $id_grupo = $_REQUEST['id_grupo'];

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx';
        $config['max_size'] = '10000';

        if ($_FILES['documento']['size'] > 0) {
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('documento')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('errorArchivo', $this->lang->line('Ocurrio un error al intentar subir el archivo'));
                redirect(base_url('miembro/grupos_miembro_trabajo/foroDetalle/' . $id_grupo . "/" . $id_foro), 'refresh');
                exit;
            } else {
                $rutaFinal = array('rutaFinal' => $this->upload->data());

                $datosAr['ruta'] = $rutaFinal['rutaFinal']['full_path'];
                $datosAr['nombre'] = $rutaFinal['rutaFinal']['file_name'];
                $datosAr['fecha'] = date('Y-m-d');
                $datosAr['tags'] = "foro";
                $datosAr['es_publico'] = 0;
                $datosAr['estado'] = 'AC';

                $resultadoIDArchivo = $this->grupos_miembro_model->insertarArchivo($datosAr);
            }
        } else {
            $resultadoIDArchivo = 0;
        }

        $datosAc['id_foro'] = $id_foro;
        $datosAc['id_usuario'] = $this->session->userdata('id_usuario');
        $datosAc['respuesta_nombre'] = $this->session->userdata('nombre');
        $datosAc['respuesta_email'] = $this->session->userdata('email');
        $datosAc['respuesta'] = $_REQUEST['respuesta'];
        $datosAc['respuesta_fecha'] = date('Y-m-d H:m:i');
        $datosAc['id_archivo'] = $resultadoIDArchivo;
        $datosAc['respuesta_estado'] = "AC";

        $resultadoID = $this->grupos_miembro_model->insertarRespuestaForo($datosAc);

        if ($resultadoID) {

            $this->session->set_flashdata('respuestaCreada', $this->lang->line('Se registro la respuesta al foro'));
            redirect(base_url('miembro/grupos_miembro_trabajo/foroDetalle/' . $id_grupo . "/" . $id_foro), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('miembro/grupos_miembro_trabajo/foroDetalle/' . $id_grupo . "/" . $id_foro), 'refresh');
        }
    }

    public function crearForo($id_grupo) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/crearForo";

        $datos['datosGrupo'] = $this->grupos_miembro_model->datosGrupo($id_grupo);
        $datos['categoriasForo'] = $this->grupos_miembro_model->categoriasForo();
        $datos['id_grupo'] = $id_grupo;

        $this->load->view('plantilla', $datos);
    }

    public function guardarForo($id_grupo) {

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx';
        $config['max_size'] = '10000';

        if ($_FILES['documento']['size'] > 0) {
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('documento')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('errorArchivo', $this->lang->line('Ocurrio un error al intentar subir el archivo'));
                redirect(base_url('miembro/grupos_miembro_trabajo/foros/' . $id_grupo), 'refresh');
                exit;
            } else {
                $rutaFinal = array('rutaFinal' => $this->upload->data());

                $datosAr['ruta'] = $rutaFinal['rutaFinal']['full_path'];
                $datosAr['nombre'] = $rutaFinal['rutaFinal']['file_name'];
                $datosAr['fecha'] = date('Y-m-d');
                $datosAr['tags'] = "Documento inicial foro";
                $datosAr['es_publico'] = 0;
                $datosAr['estado'] = 'AC';

                $resultadoIDArchivo = $this->grupos_miembro_model->insertarArchivo($datosAr);
            }
        } else {
            $resultadoIDArchivo = 0;
        }

        $datosAc['id_grupo'] = $id_grupo;
        $datosAc['foro_tema'] = $_REQUEST['tema'];
        $datosAc['foro_descripcion'] = $_REQUEST['descripcion'];
        $datosAc['id_categoria'] = $_REQUEST['categoria'];
        $datosAc['id_autor'] = $this->session->userdata('id_usuario');
        $datosAc['foro_fecha'] = date('Y-m-d H:m:i');
        $datosAc['id_archivo'] = $resultadoIDArchivo;
        $datosAc['foro_estado'] = "AC";
        $datosAc['foro_tipo'] = $_REQUEST['tipo'];

        $resultadoID = $this->grupos_miembro_model->insertarForo($datosAc);

        if ($resultadoID) {

            $this->session->set_flashdata('foroCreado', $this->lang->line('Se creo el foro con exito'));
            redirect(base_url('miembro/grupos_miembro_trabajo/foros/' . $id_grupo), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('miembro/grupos_miembro_trabajo/foros/' . $id_grupo), 'refresh');
        }
    }

}
