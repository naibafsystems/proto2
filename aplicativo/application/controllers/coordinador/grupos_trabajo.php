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
        $datos["contenido"] = "coordinador/grupos";
        $datos['grupos'] = $this->grupos_model->gruposCoordinador($this->session->userdata('id_usuario'));

        $this->load->view('plantilla', $datos);
    }

    public function miembros($id_grupo) {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/miembros";
        $datos['miembros'] = $this->grupos_model->miembrosGrupo($id_grupo);
        $datos['nomiembros'] = $this->grupos_model->miembrosNoGrupo($id_grupo);
        $datos['datosGrupo'] = $this->grupos_model->datosGrupo($id_grupo);

        $this->load->view('plantilla', $datos);
    }

    public function asociarMiembro($id_usuario, $id_grupo) {

        $datosM['id_usuario'] = $id_usuario;
        $datosM['id_grupo'] = $id_grupo;
        $datosM['fecha_ingreso'] = date('Y-m-d');
        $datosM['fecha_fin'] = '';
        $datosM['estado'] = 'AC';

        $resultadoID = $this->grupos_model->insertarMiembro($datosM);
        $datosGrupo = $this->grupos_model->datosGrupo($id_grupo);
        $datosCorreo = $this->general_model->datosUsuario($id_usuario);

        if ($resultadoID) {

            $this->load->library('My_PHPMailer');
            $this->load->library('email');

            $mail = new PHPMailer();
            $mail->IsSMTP(); // establecemos que utilizaremos SMTP
            $mail->IsHTML(true);
            $mail->SetFrom('rtc-candane@dane.gov.co', 'Red de Transmision del Conocimiento');  //Quien env&iacute;a el correo
            $mail->AddReplyTo("esanchez1988@gmail.com", "Edwin Sanchez");  //A quien debe ir dirigida la respuesta
            $mail->Subject = "Miembros del grupo " . $datosGrupo[0]->nombre_grupo;  //Asunto del mensaje
            $mail->AddEmbeddedImage("assets/imgs/logo-rtc.jpg", 'imagen.jpg', "logo-rtc.jpg", 'base64', 'image/jpeg');

            $html = '
              <p><img src="cid:imagen.jpg"></p>
              <p>Ahora hace parte del grupo de trabajo ' . $datosGrupo[0]->nombre_grupo . '.</p>
              <p>Para verificar puede acceder a la plataforma a trav&eacute;s del siguiente <a href="' . base_url() . '" target="_blank">link</a></p>
              <p>Cordial Saludo</p>';

            $mail->Body = $html;
            $mail->AddAddress($datosCorreo[0]->email, $datosCorreo[0]->email);
            $mail->addBCC("esanchez1988@gmail.com", "Edwin Sanchez");
            $mail->Send();

            $this->session->set_flashdata('miembroAsociado', $this->lang->line('Se asocio el miembro al grupo de trabajo'));
            redirect(base_url('coordinador/grupos_trabajo/miembros/' . $id_grupo), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/grupos_trabajo/miembros/' . $id_grupo), 'refresh');
        }
    }

    public function desasociarMiembro($id_usuario, $id_grupo) {

        $resultadoID = $this->grupos_model->desasociarMiembro($id_usuario, $id_grupo);
        $datosGrupo = $this->grupos_model->datosGrupo($id_grupo);
        $datosCorreo = $this->general_model->datosUsuario($id_usuario);

        if ($resultadoID) {

            $this->load->library('My_PHPMailer');
            $this->load->library('email');

            $mail = new PHPMailer();
            $mail->IsSMTP(); // establecemos que utilizaremos SMTP
            $mail->IsHTML(true);
            $mail->SetFrom('rtc-candane@dane.gov.co', 'Red de Transmision del Conocimiento');  //Quien env&iacute;a el correo
            $mail->AddReplyTo("esanchez1988@gmail.com", "Edwin Sanchez");  //A quien debe ir dirigida la respuesta
            $mail->Subject = "Miembros del grupo " . $datosGrupo[0]->nombre_grupo;  //Asunto del mensaje
            $mail->AddEmbeddedImage("assets/imgs/logo-rtc.jpg", 'imagen.jpg', "logo-rtc.jpg", 'base64', 'image/jpeg');

            $html = '
              <p><img src="cid:imagen.jpg"></p>
              <p>Ya no hace parte del grupo de trabajo ' . $datosGrupo[0]->nombre_grupo . '.</p>
              <p>Para verificar puede acceder a la plataforma a trav&eacute;s del siguiente <a href="' . base_url() . '" target="_blank">link</a></p>
              <p>Cordial Saludo</p>';

            $mail->Body = $html;
            $mail->AddAddress($datosCorreo[0]->email, $datosCorreo[0]->email);
            $mail->addBCC("esanchez1988@gmail.com", "Edwin Sanchez");
            $mail->Send();

            $this->session->set_flashdata('miembroAsociado', $this->lang->line('Se desasocio el miembro del grupo de trabajo'));
            redirect(base_url('coordinador/grupos_trabajo/miembros/' . $id_grupo), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/grupos_trabajo/miembros/' . $id_grupo), 'refresh');
        }
    }

    public function actividades($id_grupo) {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/actividades";
        $datos['ac_pendientes'] = $this->grupos_model->actividadesPendientes($id_grupo);
        $datos['ac_resueltas'] = $this->grupos_model->actividadesResueltas($id_grupo);
        $datos['datosGrupo'] = $this->grupos_model->datosGrupo($id_grupo);

        $this->load->view('plantilla', $datos);
    }

    public function crearActividad($id_grupo) {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/crearActividad";

        $datos['miembros'] = $this->grupos_model->miembrosGrupo($id_grupo);
        $datos['datosGrupo'] = $this->grupos_model->datosGrupo($id_grupo);

        $this->load->view('plantilla', $datos);
    }

    public function guardarActividad($id_grupo) {

        $dateIni = date_create($_REQUEST['inputfechini']);
        $fechaIni = date_format($dateIni, 'Y-m-d');

        $dateFin = date_create($_REQUEST['inputfechfin']);
        $fechaFin = date_format($dateFin, 'Y-m-d');

        $datosAc['id_grupo'] = $id_grupo;
        $datosAc['descripcion'] = $_REQUEST['inputDescripcion'];
        $datosAc['fecha_inicial'] = $fechaIni;
        $datosAc['fecha_final'] = $fechaFin;
        $datosAc['requerimiento'] = $_REQUEST['inputRequerimiento'];
        $datosAc['solucion'] = "";
        $datosAc['estado'] = 'PE';

        $resultadoID = $this->grupos_model->insertarActividad($datosAc);

        if ($resultadoID) {
            for ($i = 0; $i < count($_REQUEST['miembros']); $i++) {
                $datosAs['id_actividad'] = $resultadoID;
                $datosAs['id_usuario'] = $_REQUEST['miembros'][$i];
                $datosAs['estado'] = 'PE';

                $resultadoIDAs = $this->grupos_model->insertarUsuarioActividad($datosAs);

                $datosGrupo = $this->grupos_model->datosGrupo($id_grupo);
                $datosCorreo = $this->general_model->datosUsuario($_REQUEST['miembros'][$i]);

                $this->load->library('My_PHPMailer');
                $this->load->library('email');

                $mail = new PHPMailer();
                $mail->IsSMTP(); // establecemos que utilizaremos SMTP
                $mail->IsHTML(true);
                $mail->SetFrom('rtc-candane@dane.gov.co', 'Red de Transmision del Conocimiento');  //Quien env&iacute;a el correo
                $mail->AddReplyTo("esanchez1988@gmail.com", "Edwin Sanchez");  //A quien debe ir dirigida la respuesta
                $mail->Subject = "Nueva Actividad del grupo " . $datosGrupo[0]->nombre_grupo;  //Asunto del mensaje
                $mail->AddEmbeddedImage("assets/imgs/logo-rtc.jpg", 'imagen.jpg', "logo-rtc.jpg", 'base64', 'image/jpeg');

                $html = '
              <p><img src="cid:imagen.jpg"></p>
              <p>Se ha creado una nueva actividad del grupo de trabajo ' . $datosGrupo[0]->nombre_grupo . ' y fue seleccionado como responsable.</p>
              <p><b>Descripci&oacute;n</b>:'.$datosAc['descripcion'].'</p>
              <p><b>Fecha Inicial</b>:'.$datosAc['fecha_inicial'].'</p>
              <p><b>Fecha Final</b>:'.$datosAc['fecha_final'].'</p>
              <p><b>Requerimiento</b>:'.$datosAc['requerimiento'].'</p>
              <p>Para verificar puede acceder a la plataforma a trav&eacute;s del siguiente <a href="' . base_url() . '" target="_blank">link</a></p>
              <p>Cordial Saludo</p>';

                $mail->Body = $html;
                $mail->AddAddress($datosCorreo[0]->email, $datosCorreo[0]->email);
                $mail->addBCC("esanchez1988@gmail.com", "Edwin Sanchez");
                $mail->Send();
            }

            $this->session->set_flashdata('actividadCreada', $this->lang->line('Se creo la actividad') . $_REQUEST['inputDescripcion']);
            redirect(base_url('coordinador/grupos_trabajo/actividades/' . $id_grupo), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/grupos_trabajo/actividades/' . $id_grupo), 'refresh');
        }
    }

    public function seguimientoActividad($id_actividad) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/seguimientoActividad";

        $datos['observaciones'] = $this->grupos_model->observaciones($id_actividad);
        $datos['productos'] = $this->grupos_model->productos($id_actividad);
        $datos['datosActividad'] = $this->grupos_model->datosActividad($id_actividad);

        $this->load->view('plantilla', $datos);
    }

    public function observacionActividad($id_actividad) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/observacionActividad";

        $datos['datosActividad'] = $this->grupos_model->datosActividad($id_actividad);

        $this->load->view('plantilla', $datos);
    }

    public function guardarObservacion($id_actividad) {

        $datosActividad = $this->grupos_model->datosActividad($id_actividad);

        $datosAc['id_actividad'] = $id_actividad;
        $datosAc['observaciones'] = $_REQUEST['observacion'];
        $datosAc['fecha'] = date('Y-m-d');

        $resultadoID = $this->grupos_model->insertarObservacion($datosAc);

        if ($resultadoID) {

            $this->session->set_flashdata('observacionCreada', $this->lang->line('Se creo la observacion para la actividad') . $datosActividad[0]->descripcion);
            redirect(base_url('coordinador/grupos_trabajo/seguimientoActividad/' . $id_actividad), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/grupos_trabajo/seguimientoActividad/' . $id_actividad), 'refresh');
        }
    }

    public function agregarProducto($id_actividad) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/agregarProducto";

        $datos['datosActividad'] = $this->grupos_model->datosActividad($id_actividad);

        $this->load->view('plantilla', $datos);
    }

    public function guardarProducto($id_actividad) {


        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|pdf';
        $config['max_size'] = '10000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('documento')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('errorProducto', $this->lang->line('Ocurrio un error al intentar subir el archivo'));
            redirect(base_url('coordinador/grupos_trabajo/seguimientoActividad/' . $id_actividad), 'refresh');
            exit;
        } else {
            $rutaFinal = array('rutaFinal' => $this->upload->data());
        }

        $datosActividad = $this->grupos_model->datosActividad($id_actividad);

        if ($_REQUEST['publico'] == 'SI') {
            $publico = 1;
        } else {
            $publico = 0;
        }

        $datosAc['id_actividad'] = $id_actividad;
        $datosAc['observacion'] = $_REQUEST['observacion'];
        $datosAr['ruta'] = $rutaFinal['rutaFinal']['full_path'];
        $datosAr['nombre'] = $rutaFinal['rutaFinal']['file_name'];
        $datosAr['fecha'] = date('Y-m-d');
        $datosAr['tags'] = $_REQUEST['tags'];
        $datosAr['es_publico'] = $publico;
        $datosAr['estado'] = 'AC';

        $resultadoID = $this->grupos_model->insertarArchivo($datosAr);

        if ($resultadoID) {

            $datosAc['id_actividad'] = $id_actividad;
            $datosAc['id_archivo'] = $resultadoID;
            $datosAc['observacion'] = $_REQUEST['observacion'];
            $datosAc['fecha'] = date('Y-m-d');

            $resultadoID = $this->grupos_model->insertarProductos($datosAc);

            $this->session->set_flashdata('productoOk', $this->lang->line('Se agrego un nuevo producto para la actividad') . $datosActividad[0]->descripcion);
            redirect(base_url('coordinador/grupos_trabajo/seguimientoActividad/' . $id_actividad), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/grupos_trabajo/seguimientoActividad/' . $id_actividad), 'refresh');
        }
    }

    public function invitarMiembro($id_grupo) {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/invitarMiembro";

        $datos['datosGrupo'] = $this->grupos_model->datosGrupo($id_grupo);

        $this->load->view('plantilla', $datos);
    }

    public function enviarInvitacion($id_grupo) {


        $this->load->library('My_PHPMailer');
        $this->load->library('email');

        $mail = new PHPMailer();
        $mail->IsSMTP(); // establecemos que utilizaremos SMTP
        $mail->IsHTML(true);
        $mail->SetFrom('rtc-candane@dane.gov.co', 'Red de Transmision del Conocimiento');  //Quien env&iacute;a el correo
        $mail->AddReplyTo("esanchez1988@gmail.com", "Edwin Sanchez");  //A quien debe ir dirigida la respuesta
        $mail->Subject = "Invitacion a ser miembro de la RTC";  //Asunto del mensaje
        $mail->AddEmbeddedImage("assets/imgs/logo-rtc.jpg", 'imagen.jpg', "logo-rtc.jpg", 'base64', 'image/jpeg');

        $html = '
          <p><img src="cid:imagen.jpg"></p>
          <p>Bienvenido</p>
          <p>Este es un correo de invitaci&oacute;n para registrarse en la plataforma de la Red de Transmisi&oacute;n del Conocimiento RTC.</p>
          <p>Puede acceder al formulario de registro a traves del siguiente <a href="' . base_url('transversal/registro_usuario/formulario/' . $id_grupo) . '" target="_blank">link</a></p>
          <p>' . $_REQUEST['mensaje'] . '</p>';

        $mail->Body = $html;
        $mail->AddAddress($_REQUEST['correoMiembro'], $_REQUEST['correoMiembro']);
        $mail->addBCC("esanchez1988@gmail.com", "Edwin Sanchez");

        if (!$mail->Send()) {
            $data["message"] = "Error en el env&iacute;o: " . $mail->ErrorInfo;
            $this->session->set_flashdata('errorBD', $data["message"]);
            redirect(base_url('coordinador/grupos_trabajo/miembros/' . $id_grupo), 'refresh');
        } else {
            $this->session->set_flashdata('correoEnviado', $this->lang->line('Invitaci&oacute;n enviada con exito'));
            redirect(base_url('coordinador/grupos_trabajo/miembros/' . $id_grupo), 'refresh');
        }
    }

    public function borrarActividad($idActividad, $idGrupo) {

        $datosActividad = $this->grupos_model->datosActividad($idActividad);

        $delete = $this->grupos_model->eliminar_actividad($idActividad);

        $this->session->set_flashdata('actividadBorrada', $this->lang->line('Se borro la actividad') . $datosActividad[0]->descripcion);
        redirect(base_url('coordinador/grupos_trabajo/actividades/' . $idGrupo), 'refresh');
    }

    public function editarActividad($id_actividad) {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/editarActividad";

        $datos['datosActividad'] = $this->grupos_model->datosActividad($id_actividad);
        $datos['miembrosActividad'] = $this->grupos_model->miembrosActividad($id_actividad);
        $datos['miembros'] = $this->grupos_model->miembrosGrupo($datos['datosActividad'][0]->id_grupo);
        $datos['datosGrupo'] = $this->grupos_model->datosGrupo($datos['datosActividad'][0]->id_grupo);

        $this->load->view('plantilla', $datos);
    }

    public function actualizarActividad($id_grupo) {

        $dateIni = date_create($_REQUEST['inputfechini']);
        $fechaIni = date_format($dateIni, 'Y-m-d');

        $dateFin = date_create($_REQUEST['inputfechfin']);
        $fechaFin = date_format($dateFin, 'Y-m-d');

        $act_actividad = $this->grupos_model->actualizarActividad($id_grupo, $_REQUEST['id_actividad'], $_REQUEST['inputDescripcion'], $fechaIni, $fechaFin, $_REQUEST['inputRequerimiento']);

        if ($act_actividad) {
            $this->grupos_model->limpiarResponsables($_REQUEST['id_actividad']);

            for ($i = 0; $i < count($_REQUEST['miembros']); $i++) {
                $datosAs['id_actividad'] = $_REQUEST['id_actividad'];
                $datosAs['id_usuario'] = $_REQUEST['miembros'][$i];
                $datosAs['estado'] = 'PE';

                $resultadoIDAs = $this->grupos_model->insertarUsuarioActividad($datosAs);
            }
            $this->session->set_flashdata('actividadCreada', $this->lang->line('Se actualizo la actividad') . $_REQUEST['inputDescripcion']);
            redirect(base_url('coordinador/grupos_trabajo/actividades/' . $id_grupo), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/grupos_trabajo/actividades/' . $id_grupo), 'refresh');
        }
    }

    public function agregarActa($id_actividad) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/agregarActa";

        if (isset($_REQUEST['preliminar'])) {
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit;
        }


        $datos['datosActividad'] = $this->grupos_model->datosActividad($id_actividad);

        $this->load->view('plantilla', $datos);
    }

    public function generarActa($id_actividad) {

        $this->load->library('html2pdf');

        $contenidoPagina = "<page backtop='30mm' backbottom='50mm' backleft='20mm' backright='20mm'>";
        $contenidoPagina .= "<page_header>
        <table align='center' style='width: 100%;'>
            <tr>
                <td align='center' >
                    <img src='./assets/imgs/logo-rtc.jpg' width='150px'>
                </td>
                <td align='center' >
                    <font size='14px'><b>RED DE TRANSMISI&Oacute;N DEL CONOCIMIENTO</b></font>
                    <br>
                    <font size='14px'><b>ACTA DE GRUPO DE TRABAJO</b></font>
                </td>
            </tr>
        </table>
    </page_header>";
//$contenidoPagina = "<page>";
        $contenidoPagina .= $_POST['acta'];
        $contenidoPagina .= "<page_footer>
        <table align='center' width = '100%'>            
            <tr>
                <td align='center'>
                    RED DE TRANSMISI&Oacute;N DEL CONOCIMIENTO 
                    <br>
                    Todos los derechos reservados.
                    <br>
                    Carrera 59 No. 26-70 Interior I - CAN 
                    <br>
                    Email: rtc_candane@dane.gov.co                 
                </td>
            </tr>
        </table>
    </page_footer>";
        $contenidoPagina .= "</page>";

        $this->html2pdf->html($contenidoPagina);

        if ($_REQUEST['preli'] == 1) {
            $this->html2pdf->folder('./uploads/test/');
            $this->html2pdf->filename('acta_preliminar.pdf');
            $this->html2pdf->paper('Letter', 'portrait');

            $this->html2pdf->create('download');
        } else {
            $this->html2pdf->folder('uploads/');
            $nombre_archivo = "acta_" . $id_actividad . "_" . date('Y-m-d-H_m_i') . ".pdf";
            $this->html2pdf->filename($nombre_archivo);

            $this->html2pdf->paper('Letter', 'portrait');

            $rutaActa = $this->html2pdf->create('save');

            $directorio = (__FILE__);
            $directorio = str_replace("\\", "/", $directorio);
            $rut = explode("application", $directorio);
            $rutaProyecto = $rut[0];

            $rutaFinal = $rutaProyecto . $rutaActa;

            $datosActividad = $this->grupos_model->datosActividad($id_actividad);

            if ($_REQUEST['publico'] == 'SI') {
                $publico = 1;
            } else {
                $publico = 0;
            }

            $datosAc['id_actividad'] = $id_actividad;
            $datosAc['observacion'] = "Acta del grupo de trabajo - " . date('Y-m-d H:m:i');
            $datosAr['ruta'] = $rutaFinal;
            $datosAr['nombre'] = $nombre_archivo;
            $datosAr['fecha'] = date('Y-m-d');
            $datosAr['tags'] = $_REQUEST['tags'];
            $datosAr['es_publico'] = $publico;
            $datosAr['estado'] = 'AC';

            $resultadoID = $this->grupos_model->insertarArchivo($datosAr);

            if ($resultadoID) {

                $datosAc['id_actividad'] = $id_actividad;
                $datosAc['id_archivo'] = $resultadoID;
                $datosAc['observacion'] = $datosAc['observacion'];
                $datosAc['fecha'] = date('Y-m-d');

                $resultadoID = $this->grupos_model->insertarProductos($datosAc);

                $this->session->set_flashdata('productoOk', $this->lang->line('Se agrego un nuevo producto para la actividad') . $datosActividad[0]->descripcion);
                redirect(base_url('coordinador/grupos_trabajo/seguimientoActividad/' . $id_actividad), 'refresh');
            } else {
                $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
                redirect(base_url('coordinador/grupos_trabajo/seguimientoActividad/' . $id_actividad), 'refresh');
            }
        }
    }

    public function foros($id_grupo) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/listaForos";

        $datos['datosGrupo'] = $this->grupos_model->datosGrupo($id_grupo);
        $datos['id_grupo'] = $id_grupo;
        $datos['forosGrupo'] = $this->grupos_model->forosGrupo($id_grupo);
        /* echo "<pre>";
          print_r($datos['forosGrupo']);
          echo "</pre>";
          exit; */
        $this->load->view('plantilla', $datos);
    }

    public function foroDetalle($id_grupo, $id_foro) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/foroDetalle";

        $datos['datosGrupo'] = $this->grupos_model->datosGrupo($id_grupo);
        $datos['id_grupo'] = $id_grupo;
        $datos['detalleForo'] = $this->grupos_model->detalleForo($id_foro);
        $datos['respuestasForo'] = $this->grupos_model->respuestasForo($id_foro);

        $this->load->view('plantilla', $datos);
    }

    public function responderForo($id_grupo, $id_foro) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/responderForo";

        $datos['datosGrupo'] = $this->grupos_model->datosGrupo($id_grupo);
        $datos['id_grupo'] = $id_grupo;
        $datos['id_foro'] = $id_foro;
        $datos['detalleForo'] = $this->grupos_model->detalleForo($id_foro);
        $datos['respuestasForo'] = $this->grupos_model->respuestasForo($id_foro);

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
                redirect(base_url('coordinador/grupos_trabajo/foroDetalle/' . $id_grupo . "/" . $id_foro), 'refresh');
                exit;
            } else {
                $rutaFinal = array('rutaFinal' => $this->upload->data());

                $datosAr['ruta'] = $rutaFinal['rutaFinal']['full_path'];
                $datosAr['nombre'] = $rutaFinal['rutaFinal']['file_name'];
                $datosAr['fecha'] = date('Y-m-d');
                $datosAr['tags'] = "foro";
                $datosAr['es_publico'] = 0;
                $datosAr['estado'] = 'AC';

                $resultadoIDArchivo = $this->grupos_model->insertarArchivo($datosAr);
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

        $resultadoID = $this->grupos_model->insertarRespuestaForo($datosAc);

        if ($resultadoID) {

            $this->session->set_flashdata('respuestaCreada', $this->lang->line('Se registro la respuesta al foro'));
            redirect(base_url('coordinador/grupos_trabajo/foroDetalle/' . $id_grupo . "/" . $id_foro), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/grupos_trabajo/foroDetalle/' . $id_grupo . "/" . $id_foro), 'refresh');
        }
    }

    public function crearForo($id_grupo) {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "coordinador/crearForo";

        $datos['datosGrupo'] = $this->grupos_model->datosGrupo($id_grupo);
        $datos['categoriasForo'] = $this->grupos_model->categoriasForo();
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
                redirect(base_url('coordinador/grupos_trabajo/foros/' . $id_grupo), 'refresh');
                exit;
            } else {
                $rutaFinal = array('rutaFinal' => $this->upload->data());

                $datosAr['ruta'] = $rutaFinal['rutaFinal']['full_path'];
                $datosAr['nombre'] = $rutaFinal['rutaFinal']['file_name'];
                $datosAr['fecha'] = date('Y-m-d');
                $datosAr['tags'] = "Documento inicial foro";
                $datosAr['es_publico'] = 0;
                $datosAr['estado'] = 'AC';

                $resultadoIDArchivo = $this->grupos_model->insertarArchivo($datosAr);
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

        $resultadoID = $this->grupos_model->insertarForo($datosAc);

        if ($resultadoID) {

            $this->session->set_flashdata('foroCreado', $this->lang->line('Se creo el foro con exito'));
            redirect(base_url('coordinador/grupos_trabajo/foros/' . $id_grupo), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
            redirect(base_url('coordinador/grupos_trabajo/foros/' . $id_grupo), 'refresh');
        }
    }

}
