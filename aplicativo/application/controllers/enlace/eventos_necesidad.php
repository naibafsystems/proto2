<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eventos_necesidad extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('grupos_model');
        $this->load->model('general_model');
        $this->load->model('login_model');
        $this->load->model('eventos_model');
        $this->load->helper(array('url', 'form', 'html'));
        $this->load->library('session');

        if (!($this->session->userdata('language'))) {
            $this->session->set_userdata('language', 'spanish');
        }

        $user_language = $this->session->userdata('language');
        $this->lang->load('rtc_' . $user_language, $user_language);
    }

    public function index() {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "enlace/eventos_necesidad";
        $datos['eventos_usuario'] = $this->eventos_model->eventosMiembroNecesidad($this->session->userdata('id_usuario'));

        $this->load->view('plantilla', $datos);
    }

    public function crearEvento() {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "enlace/crearEventoNecesidad";
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
            $this->session->set_flashdata('errorArchivo', $this->lang->line('Ocurrio un error al intentar subir el archivo') . $this->upload->display_errors());
            redirect(base_url('enlace/eventos_necesidad/'), 'refresh');
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
            $datosAc['estado'] = 1;

            $resultadoID = $this->eventos_model->insertarEventos_necesidad($datosAc);
        }


        if ($resultadoID) {

            $eventosComun = $this->eventos_model->eventosComun($datosAc['tipo_actividad'], $datosAc['tipo_clasificacion']);

            if ($eventosComun) {
                $htmlEventos = '<div class="panel panel-primary">
                                <div class="panel-heading">
                                <h3 class="panel-title">'.$this->lang->line('Eventos similares').'</h3>
                                </div>    
                                <div class="panel-body">';
                
                $htmlEventos .= '<table class="table">';
                $htmlEventos .= '<tr><th>'.$this->lang->line('Descripcion').'</th>
                                     <th>'.$this->lang->line('Tipo Actividad').'</th>
                                     <th>'.$this->lang->line('Tipo Clasificacion').'</th>
                                     <th>'.$this->lang->line('Pais Organizador').'</th></tr>';
                foreach ($eventosComun as $row) {
                    
                    $pais = substr(strtolower($row->codi_pais),0,2);
                    $htmlEventos .= '<tr>
                                        <td>'.$row->descripcion.'</td>
                                        <td>'.$this->lang->line($row->desc_acti_es).'</td>
                                        <td>'.$this->lang->line("clasificacion".$row->tipo_clasificacion).'</td>
                                        <td><center>
                                                <img src="'.base_url('assets/banderas/iso/'.$pais.'.png') .'" width="30px">
                                                <br>
                                                '.$row->contacto.' 
                                            </center>
                                        </td>                                            
                                    </tr>';
                }
                
                                      
                $htmlEventos .= '</table>
                                </div>
                                </div>';
            }else
                {
                    $htmlEventos='';
                }

            $this->session->set_flashdata('eventoCreado', $this->lang->line('Se creo el evento necesidad') . $_REQUEST['descripcion']. $htmlEventos);
            redirect(base_url('enlace/eventos_necesidad/'), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('enlace/eventos_necesidad/'), 'refresh');
        }
    }

    public function borrarEvento($idEvento) {

        $delete = $this->eventos_model->eliminar_evento_necesidad($idEvento);

        $this->session->set_flashdata('eventoBorrada', $this->lang->line('Se borro el evento necesidad'));
        redirect(base_url('enlace/eventos_necesidad/'), 'refresh');
    }

}
