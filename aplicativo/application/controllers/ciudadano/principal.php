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
        $this->load->helper(array('url', 'form', 'html'));
        $this->load->library('session');
        
        $this->lang->load('rtc_spanish', 'spanish');
		
		if(!$this->session->userdata('rol')){
			$this->session->set_flashdata('retornoError', 'Su sesi&oacute;n finalizo');
            redirect(base_url(), 'refresh');
		}
		//ini_set('display_errors',1);
    }

    public function index() {
        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
		
		$datos['datosUsuario'] = $this->perfil_model->datos_usuario($this->session->userdata('id_usuario'));

		$datos['modalidades'] = $this->perfil_model->modalidades();
		$datos['niveles'] = $this->perfil_model->niveles();
		$datos['areas'] = $this->perfil_model->areas();
		$datos['paises'] = $this->perfil_model->paises();
		$datos['departamento'] = $this->perfil_model->departamentos('COL');
		
		$datos['formacionUsuario'] = $this->perfil_model->formacionUsuario($this->session->userdata('id_usuario'));
		$datos['experienciaUsuario'] = $this->perfil_model->experienciaUsuario($this->session->userdata('id_usuario'));
		
		$datos["contenido"] = "ciudadano/perfil";
		$this->load->view('plantilla', $datos);
		
    }

	public function cargaPrograma()
	{
		if($this->input->post('areas') && $this->input->post('nivel'))
		{
			$area = $this->input->post('areas');
			$nivel = $this->input->post('nivel');
			
			if($nivel == 8){
				$nivel = 1;
			}else if($nivel == 9){
				$nivel = 3;
			}else if($nivel == 10){
				$nivel = 1;
			}
			
			$programas = $this->perfil_model->programaAcademico($area, $nivel);
			foreach($programas as $fila)
			{
			?>
				<option value="<?=$fila -> id_programa ?>"><?= utf8_decode($fila -> desc_programa) ?></option>
			<?php
			}
		}
	}
	
	public function guardarFormacion()
	{
		
		if((isset($_REQUEST['graduado']) && $_REQUEST['graduado'] == 'S') && ($_REQUEST['nivel'] == 1 || $_REQUEST['nivel'] == 4 ||$_REQUEST['nivel'] == 5 || $_REQUEST['nivel'] == 6 || $_REQUEST['nivel'] == 7) )
		{	
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '1000';
			$config['file_name'] = "docT_".$this->session->userdata('id_usuario')."_".time();
			
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('doc_tarjeta')) {
				$error = array('error' => $this->upload->display_errors());
				
				$docTarjeta = '';
				$fechaTarj = $_REQUEST['fechaTarj']; 				
			} else {
				$rutaFinalTarjeta = array('rutaFinal' => $this->upload->data());
				
				$datosAr['ruta'] = $rutaFinalTarjeta['rutaFinal']['full_path'];
				$datosAr['nombre'] = $rutaFinalTarjeta['rutaFinal']['file_name'];
				$datosAr['fecha'] = date('Y-m-d');
				$datosAr['tags'] = '';
				$datosAr['es_publico'] = 0;
				$datosAr['estado'] = 'AC';

				$resultadoIDTarjeta = $this->perfil_model->insertarArchivo($datosAr);
			}

			
			$docTarjeta = $resultadoIDTarjeta;				
			$fechaTarj = $_REQUEST['fechaTarj'];
			
			
		}else 
		{
			$docTarjeta = '';
			$fechaTarj = '';
		}
		
				
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '1000';
			$config['file_name'] = "docF_".$this->session->userdata('id_usuario')."_".time();
			
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('doc_formacion')) {
				
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo de formaci&oacute;n acad&eacute;mica, recuerde que debe subir archivos PDF no mayor a 1Mb');
				redirect(base_url('ciudadano/principal'), 'refresh');				
				exit;
			} else {
				$rutaFinalForma = array('rutaFinal' => $this->upload->data());
				
				$datosAr['ruta'] = $rutaFinalForma['rutaFinal']['full_path'];
				$datosAr['nombre'] = $rutaFinalForma['rutaFinal']['file_name'];
				$datosAr['fecha'] = date('Y-m-d');
				$datosAr['tags'] = '';
				$datosAr['es_publico'] = 0;
				$datosAr['estado'] = 'AC';

				$resultadoIDForma = $this->perfil_model->insertarArchivo($datosAr);
				
				$docFormacion = $resultadoIDForma;
				
			}
			
		
		if($_REQUEST['fechaTerm'] != ''){
			$fechaTerm = $_REQUEST['fechaTerm'];
		}else{
			$fechaTerm = '';
		}
		
		
		$modalidad = $_REQUEST['modalidad'];	
		
		$semestres = $_REQUEST['semestres'];
		
		
			
		if(isset($_REQUEST['graduado'])){
			$graduado = $_REQUEST['graduado'];
		}else{
			$graduado = 'N';
		}
		$nivel = $_REQUEST['nivel'];	
		
		if(isset($_REQUEST['areas'])){
			$areas = $_REQUEST['areas'];
		}else{
			$areas = 0;
		}
		
		if(isset($_REQUEST['programa'])){
			$programa = $_REQUEST['programa'];
		}else{
			$programa = 0;
		}		
		
		$datosFormacion['id_usuario'] = $this->session->userdata('id_usuario');
		$datosFormacion['id_modalidad'] = $modalidad;
		$datosFormacion['semestres'] = $semestres;
		$datosFormacion['id_nivel'] = $nivel;
		$datosFormacion['id_areacono'] = $areas;
		$datosFormacion['id_programa'] = $programa;
		$datosFormacion['graduado'] = $graduado;
		$datosFormacion['fechaTermina'] = $fechaTerm;
		$datosFormacion['fechaTarje'] = $fechaTarj;
		$datosFormacion['id_docFormacion'] = $docFormacion;
		$datosFormacion['id_docTarjeta'] = $docTarjeta;
		$datosFormacion['estado'] = 'AC';
		
		$resultadoIDFormacion = $this->perfil_model->registraFormacion($datosFormacion);
		
		if($resultadoIDFormacion)
		{
			$this->session->set_flashdata('retornoExito', 'Se agrego una nueva informaci&oacute;n de formaci&oacute;n acad&eacute;mica');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}else
		{
			$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible agregar el registro');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}
		
		
		
	}
	
	public function cargaDepto()
	{
		if($this->input->post('pais'))
		{
			$pais = $this->input->post('pais');
			$deptos = $this->perfil_model->departamentos($pais);
			
			if(count($deptos) > 0){
				?>
				<option value="">Seleccione...</option>
				<?php
				foreach($deptos as $fila)
				{
				?>
					<option value="<?=$fila -> id_depto ?>"><?=$fila -> nom_depto ?></option>
				<?php
				}
			}else{
				?>
				<option value="">No existen departamentos asociados...</option>
				<?php
			}			
		}
	}
	
	public function cargaMuni()
	{
		if($this->input->post('departamento'))
		{
			$departamento = $this->input->post('departamento');
			$munis = $this->perfil_model->municipios($departamento);
			
			if(count($munis) > 0){
				?>
				<option value="">Seleccione...</option>
				<?php
				foreach($munis as $fila)
				{
				?>
					<option value="<?=$fila -> id_mpio ?>"><?=$fila -> nom_mpio ?></option>
				<?php
				}
			}else{
				?>
				<option value="">No existen municipios asociados...</option>
				<?php
			}
			
		}
	}
	
	public function guardarExperiencia()
	{
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf';
		$config['max_size'] = '1000';
		$config['file_name'] = "docExp_".$this->session->userdata('id_usuario')."_".time();
		
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload('doc_experiencia')) {
			
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo, recuerde que debe subir archivos PDF no mayor a 1Mb');
			redirect(base_url('ciudadano/principal'), 'refresh');				
			exit;
		} else {
			$rutaFinalForma = array('rutaFinal' => $this->upload->data());
			
			$datosAr['ruta'] = $rutaFinalForma['rutaFinal']['full_path'];
			$datosAr['nombre'] = $rutaFinalForma['rutaFinal']['file_name'];
			$datosAr['fecha'] = date('Y-m-d');
			$datosAr['tags'] = '';
			$datosAr['es_publico'] = 0;
			$datosAr['estado'] = 'AC';

			$resultadoIDExpe = $this->perfil_model->insertarArchivo($datosAr);
		}
		
		$empresa = utf8_encode($_REQUEST['empresa']);	
		$tipoem = $_REQUEST['tipoem'];	
		$dependencia = utf8_encode($_REQUEST['dependencia']);	
		$cargo = utf8_encode($_REQUEST['cargo']);	
		$pais = $_REQUEST['pais'];	
		$departamento = $_REQUEST['departamento'];
		$municipio = $_REQUEST['municipio'];
		$direccion = utf8_encode($_REQUEST['direccion']);
		$telefono = $_REQUEST['telefono'];
		$correo = $_REQUEST['correo'];
		$fechaIng = $_REQUEST['fechaIng'];
		
		
		if(isset($_REQUEST['fechaAct']) && $_REQUEST['fechaAct'] == 'on')
		{
			$fechaRet = '';
		}else
		{
			$fechaRet = $_REQUEST['fechaRet'];
		}
		$docExp = $resultadoIDExpe;
		
		$datosExperiencia['id_usuario'] = $this->session->userdata('id_usuario');
		$datosExperiencia['empresa'] = $empresa;
		$datosExperiencia['tipo_empresa'] = $tipoem;
		$datosExperiencia['dependencia'] = $dependencia;
		$datosExperiencia['cargo'] = $cargo;
		$datosExperiencia['codi_pais'] = $pais;
		$datosExperiencia['id_depto'] = $departamento;
		$datosExperiencia['id_mpio'] = $municipio;
		$datosExperiencia['direccion'] = $direccion;
		$datosExperiencia['telefono'] = $telefono;
		$datosExperiencia['correo'] = $correo;
		$datosExperiencia['fecha_ingreso'] = $fechaIng;
		$datosExperiencia['fecha_retiro'] = $fechaRet;
		$datosExperiencia['id_doc_soporte'] = $docExp;
		$datosExperiencia['estado'] = 'AC';
		
		$resultadoIDExperiencia = $this->perfil_model->registraExperiencia($datosExperiencia);
		
		if($resultadoIDExperiencia)
		{
			$this->session->set_flashdata('retornoExito', 'Se agrego una nueva informaci&oacute;n de experiencia laboral');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}else
		{
			$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible agregar el registro');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}
	}
	
	public function borrarExperiencia($id_experiencia)
	{
		$delete = $this->perfil_model->borrarExperiencia($id_experiencia);
		$this->session->set_flashdata('retornoExito', $this->lang->line('El registro se borro con exito'));
        redirect(base_url('ciudadano/principal'), 'refresh');
	}
	
	
	public function borrarFormacion($id_formacion)
	{
		$delete = $this->perfil_model->borrarFormacion($id_formacion);
		$this->session->set_flashdata('retornoExito', $this->lang->line('El registro se borro con exito'));
        redirect(base_url('ciudadano/principal'), 'refresh');
	}
	
	public function cargaAvatar()
	{
		
		$config['upload_path'] = './uploads/avatar/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = '1000';
		$config['file_name'] = "avatar_".$this->session->userdata('id_usuario')."_".time();
		
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload('doc_avatar')) {
			
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo, recuerde que debe subir archivos JPG y PNG no mayor a 1Mb');
			redirect(base_url('ciudadano/principal'), 'refresh');				
			exit;
		} else {
			$rutaFinalForma = array('rutaFinal' => $this->upload->data());
			
			$datosAr['ruta'] = $rutaFinalForma['rutaFinal']['full_path'];
			$datosAr['nombre'] = $rutaFinalForma['rutaFinal']['file_name'];
			$datosAr['fecha'] = date('Y-m-d');
			$datosAr['tags'] = '';
			$datosAr['es_publico'] = 0;
			$datosAr['estado'] = 'AC';

			$resultadoIDAvatar = $this->perfil_model->insertarArchivo($datosAr);
		}
		
		$datosAv['id_usuario'] = $this->session->userdata('id_usuario');
		$datosAv['id_avatar'] = $resultadoIDAvatar;
		
		$resultadoAvatar = $this->perfil_model->actualizarAvatar($datosAv['id_usuario'], $datosAv['id_avatar']);
		
		if($resultadoAvatar)
		{
			$this->session->set_flashdata('retornoExito', 'Se actualiz&oacute; la imagen de perfil ');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}else
		{
			$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible agregar el registro');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}
	}
	
	public function modificarBasica()
	{
		$datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
		
		$datos['paises'] = $this->perfil_model->paises();
		$datos['datosUsuario'] = $this->perfil_model->datos_usuario($this->session->userdata('id_usuario'));

        $datos["contenido"] = "ciudadano/actualizarDatos";
        $this->load->view('plantilla', $datos);
	}
	
	public function actualizarUsuario()
	{
		$datosUsuario = $this->perfil_model->datos_usuario($this->session->userdata('id_usuario'));
		
		if(isset($_FILES['doc_identidad']) && $_FILES['doc_identidad']['name'] != ''){
			
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '1000';
			$config['file_name'] = "docIden_".$this->session->userdata('id_usuario')."_".time();
			
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('doc_identidad')) {
				
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo, recuerde que debe subir archivos PDF no mayor a 1Mb');
				redirect(base_url('ciudadano/principal'), 'refresh');				
				exit;
			} else {
				$rutaFinalIden = array('rutaFinal' => $this->upload->data());
				
				$datosAr['ruta'] = $rutaFinalIden['rutaFinal']['full_path'];
				$datosAr['nombre'] = $rutaFinalIden['rutaFinal']['file_name'];
				$datosAr['fecha'] = date('Y-m-d');
				$datosAr['tags'] = '';
				$datosAr['es_publico'] = 0;
				$datosAr['estado'] = 'AC';
	
				$resultadoIDIden = $this->perfil_model->insertarArchivo($datosAr);
			}			
		}else{
			$resultadoIDIden = $datosUsuario[0]->id_docIden;
		}
				
		
		if(isset($_FILES['doc_libreta']) && $_FILES['doc_libreta']['name'] != ''){
			if($_REQUEST['sexo'] == 'M')
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = '1000';
				$config['file_name'] = "docLib_".$this->session->userdata('id_usuario')."_".time();
				
				$this->load->library('upload', $config);
				
				if (!$this->upload->do_upload('doc_libreta')) {
					
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo, recuerde que debe subir archivos PDF no mayor a 1Mb');
					redirect(base_url('ciudadano/principal'), 'refresh');				
					exit;
				} else {
					$rutaFinalLib = array('rutaFinal' => $this->upload->data());
					
					$datosAr['ruta'] = $rutaFinalLib['rutaFinal']['full_path'];
					$datosAr['nombre'] = $rutaFinalLib['rutaFinal']['file_name'];
					$datosAr['fecha'] = date('Y-m-d');
					$datosAr['tags'] = '';
					$datosAr['es_publico'] = 0;
					$datosAr['estado'] = 'AC';
	
					$resultadoIDLib = $this->perfil_model->insertarArchivo($datosAr);
				}
			}else
			{
				$resultadoIDLib = 0;
			}
		}else{
			$resultadoIDLib = $datosUsuario[0]->id_docLib;
		}
				
		$nombres = $_REQUEST['inputNombres'];	
		$apellidos = $_REQUEST['inputApellidos'];	
		$email2 = $_REQUEST['inputEmail2'];	
		$telefono = $_REQUEST['inputTelefono'];	
		$celular = $_REQUEST['inputCelular'];	
		$fechaNaci = $_REQUEST['fechaNaci'];
		$sexo = $_REQUEST['sexo'];
		$nacionalidad = $_REQUEST['nacionalidad'];
		$sigep = $_REQUEST['sigep'];
		
		$datosInfo['id_usuario'] = $this->session->userdata('id_usuario');
		$datosInfo['nombres'] = $nombres;
		$datosInfo['apellidos'] = $apellidos;
		$datosInfo['email2'] = $email2;
		$datosInfo['telefono'] = $telefono;
		$datosInfo['celular'] = $celular;
		$datosInfo['fecha_naci'] = $fechaNaci;
		$datosInfo['sexo'] = $sexo;
		$datosInfo['nacionalidad'] = $nacionalidad;
		$datosInfo['sigep'] = $sigep;
		$datosInfo['id_docIden'] = $resultadoIDIden;
		$datosInfo['id_docLib'] = $resultadoIDLib;		
		
		$resultadoIDActualiza = $this->perfil_model->actualizarDatos($datosInfo);
		
		if($resultadoIDActualiza)
		{
			$this->session->set_flashdata('retornoExito', 'Se actualiz&oacute; la informaci&oacute;n de perfil ');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}else
		{
			$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible actualizar');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}
	}
	
	public function modificarFormacion($idFormacion)
	{
		$idFormacion = strrev($idFormacion);
		$idFormacion = base64_decode($idFormacion);
		
		$datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
		
		$datos['modalidades'] = $this->perfil_model->modalidades();
		$datos['niveles'] = $this->perfil_model->niveles();
		$datos['areas'] = $this->perfil_model->areas();
		$datos['paises'] = $this->perfil_model->paises();
		$datos['datosUsuario'] = $this->perfil_model->datos_usuario($this->session->userdata('id_usuario'));
		$datos['formacionUsuario'] = $this->perfil_model->formacionMod($idFormacion);

        $datos["contenido"] = "ciudadano/actualizarForm";
        $this->load->view('plantilla', $datos);
	}
	
	public function modificarExperiencia($idExperiencia)
	{
		$idExperiencia = strrev($idExperiencia);
		$idExperiencia = base64_decode($idExperiencia);
		
		$datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
		
		$datos['modalidades'] = $this->perfil_model->modalidades();
		$datos['niveles'] = $this->perfil_model->niveles();
		$datos['areas'] = $this->perfil_model->areas();
		$datos['paises'] = $this->perfil_model->paises();
		$datos['datosUsuario'] = $this->perfil_model->datos_usuario($this->session->userdata('id_usuario'));
		$datos['experienciaUsuario'] = $this->perfil_model->experienciaMod($idExperiencia);
		
        $datos["contenido"] = "ciudadano/actualizarExpe";
        $this->load->view('plantilla', $datos);
	}
	
	public function actualizarFormacion()
	{
		
			if((isset($_REQUEST['graduado']) && $_REQUEST['graduado'] == 'S') && ($_REQUEST['nivel'] == 1 || $_REQUEST['nivel'] == 4 ||$_REQUEST['nivel'] == 5 || $_REQUEST['nivel'] == 6 || $_REQUEST['nivel'] == 7) )
			{	
				//var_dump($_FILES);exit;
				//if((isset($_REQUEST['cambDTP']) && $_REQUEST['cambDTP'] == 'S') || $_REQUEST['idTarjGuardado']==0){
				if((isset($_FILES['doc_tarjeta']) && $_FILES['doc_tarjeta']['name'] != '') || $_REQUEST['idTarjGuardado']==0){
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'pdf';
					$config['max_size'] = '1000';
					$config['file_name'] = "docT_".$this->session->userdata('id_usuario')."_".time();
					
					$this->load->library('upload', $config);
					
					if (!$this->upload->do_upload('doc_tarjeta')) {
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo, recuerde que debe subir archivos PDF no mayor a 2Mb');
						redirect(base_url('ciudadano/principal'), 'refresh');
						exit;
					} else {
						$rutaFinalTarjeta = array('rutaFinal' => $this->upload->data());
						
						$datosAr['ruta'] = $rutaFinalTarjeta['rutaFinal']['full_path'];
						$datosAr['nombre'] = $rutaFinalTarjeta['rutaFinal']['file_name'];
						$datosAr['fecha'] = date('Y-m-d');
						$datosAr['tags'] = '';
						$datosAr['es_publico'] = 0;
						$datosAr['estado'] = 'AC';
		
						$resultadoIDTarjeta = $this->perfil_model->insertarArchivo($datosAr);
					}
		
					
					$docTarjeta = $resultadoIDTarjeta;				 
					$fechaTarj = $_REQUEST['fechaTarj'];
				}else{
					$docTarjeta = $_REQUEST['idTarjGuardado'];
					$fechaTarj = $_REQUEST['fechaTarj'];
				}
			}else 
			{
				$docTarjeta = '';
				$fechaTarj = '';
			}
		
		if(isset($_FILES['doc_formacion']) && $_FILES['doc_formacion']['name'] != ''){			
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '1000';
			$config['file_name'] = "docF_".$this->session->userdata('id_usuario')."_".time();
			
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('doc_formacion')) {
				
				$error = array('error' => $this->upload->display_errors());					
				$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo de formaci&oacute;n acad&eacute;mica, recuerde que debe subir archivos PDF no mayor a 2Mb');
				redirect(base_url('ciudadano/principal'), 'refresh');				
				exit;
			} else {
				$rutaFinalForma = array('rutaFinal' => $this->upload->data());
				
				$datosAr['ruta'] = $rutaFinalForma['rutaFinal']['full_path'];
				$datosAr['nombre'] = $rutaFinalForma['rutaFinal']['file_name'];
				$datosAr['fecha'] = date('Y-m-d');
				$datosAr['tags'] = '';
				$datosAr['es_publico'] = 0;
				$datosAr['estado'] = 'AC';

				$resultadoIDForma = $this->perfil_model->insertarArchivo($datosAr);
				
				$docFormacion = $resultadoIDForma;
			}
			
		}else{
			$docFormacion = $_REQUEST['idDocGuardado'];
		}

		if($_REQUEST['fechaTerm'] != ''){
			$fechaTerm = $_REQUEST['fechaTerm'];
		}else{
			$fechaTerm = '';
		}
		
		$modalidad = $_REQUEST['modalidad'];	
		$semestres = $_REQUEST['semestres'];	
		if(isset($_REQUEST['graduado'])){
			$graduado = $_REQUEST['graduado'];
		}else{
			$graduado = 'N';
		}
		$nivel = $_REQUEST['nivel'];	
		
		if(isset($_REQUEST['areas'])){
			$areas = $_REQUEST['areas'];
		}else{
			$areas = 0;
		}
		
		if(isset($_REQUEST['programa'])){
			$programa = $_REQUEST['programa'];
		}else{
			$programa = 0;
		}				
		
		$datosFormacion['id_usuario'] = $this->session->userdata('id_usuario');
		$datosFormacion['id_formacion'] = $_REQUEST['id_formacion'];
		$datosFormacion['id_modalidad'] = $modalidad;
		$datosFormacion['semestres'] = $semestres;
		$datosFormacion['id_nivel'] = $nivel;
		$datosFormacion['id_areacono'] = $areas;
		$datosFormacion['id_programa'] = $programa;
		$datosFormacion['graduado'] = $graduado;
		$datosFormacion['fechaTermina'] = $fechaTerm;
		$datosFormacion['fechaTarje'] = $fechaTarj;
		$datosFormacion['id_docFormacion'] = $docFormacion;
		$datosFormacion['id_docTarjeta'] = $docTarjeta;
		$datosFormacion['estado'] = 'AC';
		
		$resultadoIDFormacion = $this->perfil_model->actualizaFormacion($datosFormacion);
		
		if($resultadoIDFormacion)
		{
			$this->session->set_flashdata('retornoExito', 'Se actualiz&oacute; la informaci&oacute;n de formaci&oacute;n acad&eacute;mica');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}else
		{
			$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible actualizar el registro');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}
	}
	
	public function actualizarExperiencia()
	{
		if((isset($_FILES['doc_experiencia']) && $_FILES['doc_experiencia']['name'] != '') || $_REQUEST['id_doc_soporte']==0){
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '1000';
			$config['file_name'] = "docExp_".$this->session->userdata('id_usuario')."_".time();
			
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('doc_experiencia')) {
				
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo, recuerde que debe subir archivos PDF no mayor a 2Mb');
				redirect(base_url('ciudadano/principal'), 'refresh');				
				exit;
			} else {
				$rutaFinalForma = array('rutaFinal' => $this->upload->data());
				
				$datosAr['ruta'] = $rutaFinalForma['rutaFinal']['full_path'];
				$datosAr['nombre'] = $rutaFinalForma['rutaFinal']['file_name'];
				$datosAr['fecha'] = date('Y-m-d');
				$datosAr['tags'] = '';
				$datosAr['es_publico'] = 0;
				$datosAr['estado'] = 'AC';
	
				$resultadoIDExpe = $this->perfil_model->insertarArchivo($datosAr);
			}
		}else{
			$resultadoIDExpe = 	$_REQUEST['id_doc_soporte'];
		}
		
		$empresa = $_REQUEST['empresa'];	
		$tipoem = $_REQUEST['tipoem'];	
		$dependencia = $_REQUEST['dependencia'];	
		$cargo = $_REQUEST['cargo'];	
		$pais = $_REQUEST['pais'];	
		$departamento = $_REQUEST['departamento'];
		$municipio = $_REQUEST['municipio'];
		$direccion = $_REQUEST['direccion'];
		$telefono = $_REQUEST['telefono'];
		$correo = $_REQUEST['correo'];
		$fechaIng = $_REQUEST['fechaIng'];
		
		
		if(isset($_REQUEST['fechaAct']) && $_REQUEST['fechaAct'] == 'on')
		{
			$fechaRet = '';
		}else
		{
			$fechaRet = $_REQUEST['fechaRet'];
		}
		$docExp = $resultadoIDExpe;
		
		$datosExperiencia['id_usuario'] = $this->session->userdata('id_usuario');
		$datosExperiencia['id_experiencia'] = $_REQUEST['id_experiencia'];
		$datosExperiencia['empresa'] = $empresa;
		$datosExperiencia['tipo_empresa'] = $tipoem;
		$datosExperiencia['dependencia'] = $dependencia;
		$datosExperiencia['cargo'] = $cargo;
		$datosExperiencia['codi_pais'] = $pais;
		$datosExperiencia['id_depto'] = $departamento;
		$datosExperiencia['id_mpio'] = $municipio;
		$datosExperiencia['direccion'] = $direccion;
		$datosExperiencia['telefono'] = $telefono;
		$datosExperiencia['correo'] = $correo;
		$datosExperiencia['fecha_ingreso'] = $fechaIng;
		$datosExperiencia['fecha_retiro'] = $fechaRet;
		$datosExperiencia['id_doc_soporte'] = $docExp;
		$datosExperiencia['estado'] = 'AC';
		
		$resultadoIDExperiencia = $this->perfil_model->actualizarExperiencia($datosExperiencia);
		
		if($resultadoIDExperiencia)
		{
			$this->session->set_flashdata('retornoExito', 'Se actualiz&oacute la informaci&oacute;n de experiencia laboral');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}else
		{
			$this->session->set_flashdata('retornoError', 'Por favor verifique la informaci&oacute;n, no fue posible agregar el registro');
			redirect(base_url('ciudadano/principal'), 'refresh');
			exit;
		}
	}
	
}
