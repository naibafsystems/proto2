<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Convocatorias extends CI_Controller {

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
		
        //$this->lang->load('rtc_spanish', 'spanish');
        
        if (!($this -> session -> userdata('language'))) {
        	$this -> session -> set_userdata('language', 'spanish');
        }
        
        $user_language = $this -> session -> userdata('language');
        $this -> lang -> load('rtc_' . $user_language, $user_language);
        
        if(!$this->session->userdata('rol')){
        	$this->session->set_flashdata('retornoError', 'Su sesi&oacute;n finalizo');
        	redirect(base_url(), 'refresh');
        }
        //echo $this->session->userdata('rol');exit();
        if($this->session->userdata('rol')!=1 && $this->session->userdata('rol')!=5 && $this->session->userdata('rol')!=6){
        	redirect(base_url(), 'refresh');
        }
		
	}

    public function index() {

        $datos["contenido"] = "administrador/convocatorias";
        $datos['investigaciones'] = $this->convocatorias_model->investigaciones();
        $datos['roles'] = $this->convocatorias_model->roles();
        $datos['ciudades'] = $this->convocatorias_model->sedes();

        $datos['conv_abiertas'] = $this->convocatorias_model->conv_abiertas_info();
        $datos['conv_cerradas'] = $this->convocatorias_model->conv_cerradas_info();

        $this->load->view('plantilla', $datos);
    }
	
	public function reporte() {

        $datos["contenido"] = "administrador/reporte";
        $datos['investigaciones'] = $this->convocatorias_model->investigaciones();
        $datos['roles'] = $this->convocatorias_model->roles();
        $datos['ciudades'] = $this->convocatorias_model->sedes();

        $datos['conv_abiertas'] = $this->convocatorias_model->conv_abiertas_info();
        $datos['conv_cerradas'] = $this->convocatorias_model->conv_cerradas_info();

        $this->load->view('plantilla', $datos);
    }
	
	public function matriculas() {

        $datos["contenido"] = "administrador/matriculas";
        $datos['investigaciones'] = $this->convocatorias_model->investigaciones();
        $datos['roles'] = $this->convocatorias_model->roles();
        $datos['ciudades'] = $this->convocatorias_model->sedes();

        $datos['conv_abiertas'] = $this->convocatorias_model->conv_abiertas_info();
        $datos['conv_cerradas'] = $this->convocatorias_model->conv_cerradas_info();

        $this->load->view('plantilla', $datos);
    }
	
	public function inscritos($id_convocatoria, $id_conv_insc) {

        $datos["contenido"] = "administrador/inscritos";
        
        $datos['info_conv'] = $this->convocatorias_model->infoConvMun($id_convocatoria, $id_conv_insc);
		$datos['info_usuarios'] = $this->convocatorias_model->personasInscritas($id_convocatoria, $id_conv_insc);
		$datos['info_requ2'] = $this->convocatorias_model->requisitosInscritos2($id_convocatoria);
		$datos['info_requ'] = $this->convocatorias_model->requisitosInscritosMun($id_convocatoria, $id_conv_insc);
		$datos['id_convocatoria'] = $id_convocatoria;
		$datos['id_conv_insc'] = $id_conv_insc;
		
        $this->load->view('plantilla', $datos);
    }

    public function invitar($id) {

        $datos["contenido"] = "administrador/invitar";
        $datos["idConv"] = $id;
        $datos["usuariosInvitados"] = $this->convocatorias_model->usuariosInvitados($id);
		$datos["convocatoria"] = $this->convocatorias_model->infoConv($id);

        $this->load->view('plantilla', $datos);
    }
	
	public function inactConvConfirm($id) {

        $datos["idConv"] = $id;
        $usuariosInscritos = $this->convocatorias_model->totalPersonasInscritas($id);
		
		if($usuariosInscritos[0]->total <= 0){
			$datos["contenido"] = "administrador/inactivarConvocatoria";
			$this->load->view('plantilla', $datos);
		}else{
			$this->session->set_flashdata('retornoError', 'No se puede inactivar la convocatoria ya que tiene usuarios inscritos');
            redirect(base_url('administrador/convocatorias'), 'refresh');
		}
		
		
    }
	
	public function eliminarCiudad($id_convocatoria, $id_conv_insc) {

        $usuariosInscritos = $this->convocatorias_model->totalInscritos($id_convocatoria, $id_conv_insc);

		if($usuariosInscritos[0]->total == 0){
			$resultadoBorrar = $this->convocatorias_model->borrarCiudadConvocatoria($id_convocatoria, $id_conv_insc);
			if($resultadoBorrar){
				$this->session->set_flashdata('retornoExito', 'La solicitud fue procesada con exito');
				redirect(base_url('administrador/convocatorias'), 'refresh');
			}else{
				$this->session->set_flashdata('retornoError', 'Error al procesar la solicitud');
				redirect(base_url('administrador/convocatorias'), 'refresh');
			}
		}else{
			$this->session->set_flashdata('retornoError', 'No se puede eliminar la convocatoria de la ciudad ya que tiene usuarios inscritos');
            redirect(base_url('administrador/convocatorias'), 'refresh');
		}
    }
	
	

    public function guardarConvocatoria() {

    	$datosC['tipo_conv'] = $_REQUEST['tipo_conv'];
        $datosC['id_investigacion'] = $_REQUEST['investigacion'];
        $datosC['id_rol'] = $_REQUEST['rol'];
        $datosC['perfil'] = utf8_encode($_REQUEST['perfil']);
        $datosC['objeto'] = utf8_encode($_REQUEST['objeto']);
        $datosC['obligaciones'] = utf8_encode($_REQUEST['obligaciones']);
		$datosC['honorarios'] = utf8_encode($_REQUEST['honorarios']);
		//$datosC['id_archivoConv'] = $this->convocatorias_model->consultarArchivos($datosAr['nombre']);

        $resultadoConvocatoria = $this->convocatorias_model->insertarDatosConvocatoria($datosC);

        if ($resultadoConvocatoria) {
            for ($ciu = 0; $ciu < count($_REQUEST['ciudades']); $ciu++) {
                $datosI['id_convocatoria'] = $resultadoConvocatoria;
                $datosI['id_ciudad'] = $_REQUEST['ciudades'][$ciu];
                $datosI['fecha_inicio'] = $_REQUEST['fechaInicio'];
                $datosI['fecha_fin'] = $_REQUEST['fechaFin'];


                $resultadoConvocatoriaIns = $this->convocatorias_model->insertarConvocatoriaInsc($datosI);
            }
            
            /*-------------------- GUARDAR EL PDF DE LA CONVOCATORIA ----------------------------------------- */
            if(isset($_FILES['doc_identidad']) && $_FILES['doc_identidad']['name'] != ''){
            	 
            	$config['upload_path'] = './uploads/';
            	$config['allowed_types'] = 'pdf';
            	$config['max_size'] = '1000';
            	$config['file_name'] = "docConv_".$resultadoConvocatoria."_".time();
            	 
            	$this->load->library('upload', $config);
            	 
            	if (!$this->upload->do_upload('doc_identidad')) {
            		 
            		$error = array('error' => $this->upload->display_errors());
            		$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo, recuerde que debe subir archivos PDF no mayor a 1Mb');
            		redirect(base_url('administrador/convocatorias'), 'refresh');
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
            		
            		if ($resultadoIDIden) {
            			$this->convocatorias_model->ActualizarArchivoConvocatoria($resultadoConvocatoria,$resultadoIDIden);
            		}
            	}
            }

            $this->session->set_flashdata('retornoExito', 'Se registro la convocatoria correctamente');
            redirect(base_url('administrador/convocatorias'), 'refresh');
        } else {
            $this->session->set_flashdata('retornoError', 'Error al registrar la convocatoria');
            redirect(base_url('administrador/convocatorias'), 'refresh');
        }
    }

	public function actualizaConv($idConv)
	{			
		$datosC['id_convocatoria'] = $idConv;
		$datosC['perfil'] = utf8_encode($_REQUEST['perfilAct']);
        $datosC['objeto'] = utf8_encode($_REQUEST['objetoAct']);
        $datosC['obligaciones'] = utf8_encode($_REQUEST['obligacionesAct']);
		$datosC['honorarios'] = utf8_encode($_REQUEST['honorariosAct']);
		$datosC['tipo_conv'] = $_REQUEST['tipo_conv'];
		
		$resultadoConvocatoria = $this->convocatorias_model->actualizarDatosConvocatoria($datosC);
		
		$datosI['id_convocatoria'] = $idConv;
		$datosI['fecha_inicio'] = $_REQUEST['fechaInicio'];
		$datosI['fecha_fin'] = $_REQUEST['fechaFin'];
		
		$resultadoFechaConvocatoria = $this->convocatorias_model->actualizarFechaConvocatoria($datosI);
		
		if($resultadoConvocatoria){
			$this->session->set_flashdata('retornoExito', 'Se actualizo la convocatoria correctamente');
            redirect(base_url('administrador/convocatorias'), 'refresh');
		}else{
			$this->session->set_flashdata('retornoError', 'Error al actualizar la convocatoria');
            redirect(base_url('administrador/convocatorias'), 'refresh');
		}
	}

    public function requisitos($id) {
		
        $datos["contenido"] = "administrador/requisitos";
        $datos['investigaciones'] = $this->convocatorias_model->investigaciones();
        $datos['roles'] = $this->convocatorias_model->roles();
        $datos['ciudades'] = $this->convocatorias_model->sedes();
        $datos['requisitos'] = $this->convocatorias_model->requisitosInscritos2($id);
        $datos['niveles'] = $this->perfil_model->niveles();
        $datos['areas'] = $this->convocatorias_model->listaAreas();

        $datos['infoConv'] = $this->convocatorias_model->infoConv($id);
        $datos['info_convocatoria'] = $this->convocatorias_model->info_convocatoria($id);
        $datos['infoRequ'] = $this->convocatorias_model->verificaRequisitos($id);

        $this->load->view('plantilla', $datos);
    }

    public function cargaPrograma() {
        if ($this->input->post('nivel')) {
            $nivel = $this->input->post('nivel');
            $programas = $this->convocatorias_model->listaProgramas($nivel);
            foreach ($programas as $fila) {
                ?>
                <option value="<?= $fila->id_programa ?>" data-section=" <?= utf8_decode($fila->desc_areacono) ?> "><?= utf8_decode($fila->desc_programa) ?></option>
                <?php
            }
        }
    }
    
    
    public function cargaInfoPerfil() {
        if ($this->input->post('investigacion') && $this->input->post('rol')) {
            
            $investigacion = $this->input->post('investigacion');
            $rol = $this->input->post('rol');
            
            $descripcion = $this->convocatorias_model->informacionPerfil($investigacion, $rol);
            
            if($descripcion)
                {
                    echo utf8_decode($descripcion[0]->perfil);
                }else{
                    echo "";
                }
        }
    }
	
    
    public function cargaInfoObjeto() {
        if ($this->input->post('investigacion') && $this->input->post('rol')) {
            
            $investigacion = $this->input->post('investigacion');
            $rol = $this->input->post('rol');
            
            $descripcion = $this->convocatorias_model->informacionPerfil($investigacion, $rol);
            
            if($descripcion)
                {
                    echo utf8_decode($descripcion[0]->objeto);
                }else{
                    echo "";
                }
        }
    }

    public function guardarRequisitos($id_conv) {
        
    	error_reporting(0);
        $datosReq['id_convocatoria'] = $id_conv;
        $datosReq['id_nivel'] = $_REQUEST['nivel'];
        $datosReq['semestres']= $_REQUEST['semestres'];
        $datosReq['tiempo']= $_REQUEST['experiencia'];
		$datosReq['operativo']= $_REQUEST['operativo'];
		
        $areas = '';
        if($_REQUEST['area'] != '' || isset($_REQUEST['area']))
            {
                
                for($i=0;$i<count($_REQUEST['area']);$i++)
                {
                    $areas.=$_REQUEST['area'][$i].",";
                }
            }
        
        $datosReq['area']=$areas;
        
        $datosRequisitos = $this->convocatorias_model->verificaRequisitos($id_conv);
        $total_registros=count($datosRequisitos);
        
        if($datosRequisitos)
            {            	
            	if (count($datosReq['semestres']) == count($datosRequisitos)){
            		
            		//$id_requisito.= $datosRequisitos->id_requisito;
            		            		
	                $datosReq['id_requisito'] = $datosRequisitos;
	                
	                $datosUsuario = $this->convocatorias_model->actualizarRequisitos($datosReq,$total_registros);
            	}else{
            		
            		for($a=0;$a<count($datosReq['semestres']);$a++){
            			if(count($datosRequisitos)>$a){
            				//$id_requisito = $datosRequisitos[0]->id_requisito;
            				$datosReq['id_requisito'] = $datosRequisitos;
            				//var_dump($datosReq);exit;
            				$datosUsuario = $this->convocatorias_model->actualizarRequisitos($datosReq,$total_registros);
            			}else{
            				$datosUsuario = $this->convocatorias_model->guardarRequisitos($datosReq,$a);
            			}		
            		}
            	}                
            }else{
            	for($a=0;$a<count($datosReq['semestres']);$a++){
                	$datosUsuario = $this->convocatorias_model->guardarRequisitos($datosReq,$a);
            	}
            }
        /* ------------------------- BUSCA INSCRITOS PARA ACTUALIZAR Y DAR RE APERTURA ------------------------------------ */
        $datosInscritos = $this->convocatorias_model->buscarInscritos($id_conv);
        
        if($datosInscritos)
        {
            for($j=0;$j<count($datosInscritos);$j++)
            {
                $datosActIns['id_conv_insc'] = $datosInscritos[$j]->id_conv_insc;
                $datosActIns['total_personas'] = $_REQUEST['contra-'.$datosInscritos[$j]->id_conv_insc];
                $datosActIns['max_inscri'] = $_REQUEST['inscri-'.$datosInscritos[$j]->id_conv_insc];
				$datosActIns['eco'] = $_REQUEST['eco-'.$datosInscritos[$j]->id_conv_insc];
				$datosActIns['fecha_fin'] = $_REQUEST['fechaFin-'.$datosInscritos[$j]->id_conv_insc];
                
                $datosUsuario = $this->convocatorias_model->actualizarInscritos($datosActIns);
            }
        }
        
        //************/////////////**------- MODIFICACION ARCHIVO PDF  ------------*/*************************/////
        if(isset($_FILES['doc_convocatoria']) && $_FILES['doc_convocatoria']['name'] != ''){
        
        	$config['upload_path'] = './uploads/';
        	$config['allowed_types'] = 'pdf';
        	$config['max_size'] = '1000';
        	$config['file_name'] = "docConv_".$id_conv."_".time();
        
        	$this->load->library('upload', $config);
        
        	if (!$this->upload->do_upload('doc_convocatoria')) {
        			
        		$error = array('error' => $this->upload->display_errors());
        		$this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo, recuerde que debe subir archivos PDF no mayor a 1Mb');
        		redirect(base_url('administrador/convocatorias'), 'refresh');
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
        
        		if ($resultadoIDIden) {
        			$this->convocatorias_model->ActualizarArchivoConvocatoria($id_conv,$resultadoIDIden); 
        		}
        	}
        }
        
        
        $this->session->set_flashdata('retornoExito', 'Se actualiz&oacute; los requisitos de la convocatoria');
        redirect(base_url('administrador/convocatorias'), 'refresh');
        
    }

    public function cargarInvitaciones($id_conv) {
        $this->load->library('PHPExcel.php');
		$nombre_archivoCarga = "invitacion_" . $this->session->userdata('id_usuario') . "_" . $id_conv. "_" . time();

        $config['upload_path'] = './uploads/invitaciones/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '10000';
        $config['file_name'] = $nombre_archivoCarga;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('doc_excel')) {

            $error = array('error' => $this->upload->display_errors());
            //var_dump($error);
            $this->session->set_flashdata('retornoError', 'Ocurrio un problema al intentar subir el archivo, recuerde que debe subir archivos Excel');
            redirect(base_url('administrador/convocatorias'), 'refresh');
            exit;
        } else {
            //var_dump($this->PHPExcel_IOFactory);
            $nombre_archivo = $nombre_archivoCarga. ".xls";
            $rutaArchivo = './uploads/invitaciones/' . $nombre_archivo;

            $objPHPExcel = PHPExcel_IOFactory::load($rutaArchivo);
            //var_dump($archivo);

			
            $archivo = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $msj = ""; 
			$userPr = 0;
						
            for ($i = 2; $i <= count($archivo); $i++) {
                $infoUsuario = $this->convocatorias_model->verifica_usuario($archivo[$i]['E'], $archivo[$i]['F']);

                if (count($infoUsuario) > 0) {
                    $msj.= "El usuario " . $archivo[$i]['A'] . " " . $archivo[$i]['B'] . " ya se encuentra registrado como usuario <br>";
					$ret[$userPr]['usuario'] = "El usuario " . $archivo[$i]['A'] . " " . $archivo[$i]['B'] . " ya se encuentra registrado como usuario <br>";
                    $idUsuario = $infoUsuario[0]->id_usuario;
                } else {
                    $datoUsu['nombres'] = $archivo[$i]['A'];
                    $datoUsu['apellidos'] = $archivo[$i]['B'];
                    $datoUsu['tipo_iden'] = $archivo[$i]['E'];
                    $datoUsu['nume_iden'] = $archivo[$i]['F'];
                    $datoUsu['sexo'] = $archivo[$i]['C'];
                    $datoUsu['telefono'] = $archivo[$i]['H'];
                    $datoUsu['celular'] = $archivo[$i]['G'];

                    $idUsuario = $this->usuarios_model->insertarUsuario($datoUsu);

                    if ($idUsuario) {
                        $datosUsuRol['id_usuario'] = $idUsuario;
                        $datosUsuRol['rol'] = 3;
                        $datosUsuRol['estado'] = 'AC';

                        $idUsuarioRol = $this->usuarios_model->insertarRolUsuario($datosUsuRol);

                        $datosUsuLogin['usuario_id_usuario'] = $idUsuario;
                        $datosUsuLogin['usuario'] = $archivo[$i]['I'];
                        $datosUsuLogin['clave'] = sha1(md5($archivo[$i]['F']));
                        $datosUsuLogin['estado'] = 'AC';

                        $idUsuarioLogin = $this->usuarios_model->insertarDatosLogin($datosUsuLogin);
                    }

                    $msj.= "El usuario " . $archivo[$i]['A'] . " " . $archivo[$i]['B'] . " se agreg&oacute; como usuario nuevo<br>";
					$ret[$userPr]['usuario'] = "El usuario " . $archivo[$i]['A'] . " " . $archivo[$i]['B'] . " se agreg&oacute; como usuario nuevo<br>";
                }
                //Verificar si el usuario ya se encuentra registrado en esa convocatoria
                $usuario_conv = $this->convocatorias_model->verificaInvitacionUsuario($idUsuario, $id_conv);

                if (count($usuario_conv) > 0) {
                    $msj.= "El usuario " . $archivo[$i]['A'] . " " . $archivo[$i]['B'] . " ya se encuentra asociado a esta convocatoria<br>";
					$ret[$userPr]['conv'] = "El usuario " . utf8_decode($archivo[$i]['A']) . " " . utf8_decode($archivo[$i]['B']) . " ya se encuentra asociado a esta convocatoria<br>";
                } else {
                    //Asociar el usuario a la convocatoria
                    
                    
                    $ciudadAplica = $this->convocatorias_model->buscarCiudad($archivo[$i]['J']);
					//echo "<br>Ciudad Archivo: ";var_dump($ciudadAplica);					
					//if(isset($ciudadAplica[0]->id_mpio) && ($ciudadAplica[0]->id_mpio > 0)){
							
					if(isset($ciudadAplica[0]->id_mpio) && ($ciudadAplica[0]->id_mpio > 0)){
						//$ciudadAplicaConv = $this->convocatorias_model->buscarCiudadConvocatoria($id_conv, $ciudadAplica[0]->id_mpio);
						$munAplica = $ciudadAplica[0]->id_mpio;
					}else{
						$munAplica = '11001';
					}
						
						$datosInvReg['id_convocatoria'] = $id_conv;
	                    $datosInvReg['id_usuario'] = $idUsuario;
	                    $datosInvReg['aplico'] = 'NO';
	                    $datosInvReg['cumple_req'] = 'NO';
	                    $datosInvReg['estado'] = 'AC';
						$datosInvReg['id_ciudad'] = $munAplica;
	                    $registraConv = $this->convocatorias_model->insertarUsuarioInvitacion($datosInvReg);
	
	                    $msj.= "El usuario " . utf8_decode($archivo[$i]['A']) . " " . utf8_decode($archivo[$i]['B']) . " se asoci&oacute; correctamente a la convocatoria<br>";
						$ret[$userPr]['conv'] = "El usuario " . utf8_decode($archivo[$i]['A']) . " " . utf8_decode($archivo[$i]['B']) . " se asoci&oacute; correctamente a la convocatoria<br>";
						
						
						//echo "<br>Ciudad Aplica: ";var_dump($ciudadAplica);
						//exit;	
						/*if(count($ciudadAplicaConv)>0){ 
							$datosInvReg['id_convocatoria'] = $id_conv;
		                    $datosInvReg['id_usuario'] = $idUsuario;
		                    $datosInvReg['aplico'] = 'NO';
		                    $datosInvReg['cumple_req'] = 'NO';
		                    $datosInvReg['estado'] = 'AC';
							$datosInvReg['id_ciudad'] = $munAplica;
		                    $registraConv = $this->convocatorias_model->insertarUsuarioInvitacion($datosInvReg);
		
		                    $msj.= "El usuario " . utf8_decode($archivo[$i]['A']) . " " . utf8_decode($archivo[$i]['B']) . " se asoci&oacute; correctamente a la convocatoria<br>";
							$ret[$userPr]['conv'] = "El usuario " . utf8_decode($archivo[$i]['A']) . " " . utf8_decode($archivo[$i]['B']) . " se asoci&oacute; correctamente a la convocatoria<br>";	
						}else{
							$ret[$userPr]['conv'] = "La ciudad asociada no tiene convocatoria vigente<br>";
						}
						*/
					/*		
					}else{
						$ret[$userPr]['conv'] = "La ciudad asociada no se encuentra registrada<br>";
					}
                    */
                    
                }
				$userPr++;
            }
			//exit;
            $this->session->set_flashdata('retornoTabla', $ret);
            redirect(base_url('administrador/convocatorias/invitar/' . $id_conv), 'refresh');
            exit;
        }
    }

    public function enviarCorreo($id_conv, $id_usuario) {

        $this->load->library('My_PHPMailer');
        $this->load->library('email');

        $datosUsuario = $this->convocatorias_model->datosUsuario($id_usuario);
        $datosConv = $this->convocatorias_model->infoConv($id_conv);
		
		$this -> load -> library('My_PHPMailer'); 
	
			$this -> load -> library('email');
			$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => '0u67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
			//cargamos la configuraciÃÆÃÂ³n para enviar mail
			$this -> email -> initialize($configMail);

			$this -> email -> from('aplicaciones@dane.gov.co', 'Banco Hojas de Vida');
			$this -> email -> to($datosUsuario[0]->usuario);
			//$this -> email -> bcc('esanchez1988@gmail.com');
			$this -> email -> subject('Invitacion convocatoria DANE');
			
			$html = '			
		              <p>Bienvenido</p>
		              <p>' . $datosUsuario[0]->nombres . " " . $datosUsuario[0]->apellidos . ',</p>
		                <p>Usted ha sido registrado para participar en la convocatoria '.$datosConv[0]->nombre_inv.'</p>
		              <p>Puede acceder a la plataforma a trav&eacute;s del siguiente <a href="' . base_url() . '" target="_blank">link</a> y continuar con su proceso para aplicar a la convocatoria</p>
		              <p>Sus datos de ingreso son los siguientes:<br>
		              Usuario: ' . $datosUsuario[0]->usuario . '<br>
		              Contrase&ntilde;a: En caso de que no hubiese realizado el proceso de registro previamente, puede ingresar con su numero de identificaci&oacute;n, en caso contrario ingresar con su contrase&ntilde;a registrada<br>
		              </p>
		              <p>Recuerde que puede cambiar su contrase&ntilde;a despues de ingresar a la plataforma.</p>';
			
			$this -> email -> message($html);
			if ($this -> email -> send()) {
				
			}
        
        
        $actuConv = $this->convocatorias_model->actualizarEnvio($id_usuario,$id_conv);
        
        $this->session->set_flashdata('retornoExito', 'Env&iacute;o de correo exitoso a '.$datosUsuario[0]->usuario);
        redirect(base_url('administrador/convocatorias/invitar/' . $id_conv), 'refresh');
    }

	public function usuariosConv() {

        $datos["contenido"] = "administrador/usuariosConv";  
		$datos["personas"] = $this->convocatorias_model->personasInscritos();      
        $this->load->view('plantilla', $datos);
    }

	public function usuariosDatos($identificacion) {

        $datos["contenido"] = "administrador/usuariosDatos";  
		$datos["personas"] = $this->convocatorias_model->personasDatos($identificacion);      
        $this->load->view('plantilla', $datos);
    }

	public function borrarInscripcion($id_usuario, $id_convocatoria, $id_conv_insc){

		$resultadoBorrar = $this->convocatorias_model->liberarUsuario($id_usuario);
		if($resultadoBorrar){
			$this->session->set_flashdata('retornoExito', 'La solicitud fue procesada con exito');
			redirect(base_url('administrador/convocatorias/usuariosConv'), 'refresh');
		}else{
			$this->session->set_flashdata('retornoError', 'Error al procesar la solicitud');
			redirect(base_url('administrador/convocatorias/usuariosConv'), 'refresh');
		}
	}
	
	public function registrosConv() {

        $datos["contenido"] = "administrador/registrosConv";  
		$datos["convocatoriasAbiertas"] = $this->convocatorias_model->conv_abiertas_clon();      
        $this->load->view('plantilla', $datos);
    }
    
    public function clonarConvocatoria($id_convocatoria){

		$resultadoConvocatoria = $this->convocatorias_model->info_convocatoriaEsp($id_convocatoria);
		
		
		$datosC['id_investigacion'] = $resultadoConvocatoria[0]->id_investigacion;
		$datosC['tipo_conv'] = 'C';
		$datosC['id_rol'] = $resultadoConvocatoria[0]->id_rol;
		$datosC['perfil'] = $resultadoConvocatoria[0]->perfil;
		$datosC['objeto'] = $resultadoConvocatoria[0]->objeto;
		$datosC['obligaciones'] = $resultadoConvocatoria[0]->obligaciones;
		$datosC['honorarios'] = $resultadoConvocatoria[0]->honorarios;
		
		$resultadoConvocatoria = $this->convocatorias_model->insertarDatosConvocatoria($datosC);
				
		if($resultadoConvocatoria){
			
			$resultadoRequisitos = $this->convocatorias_model->info_requisitosEsp($id_convocatoria);
			
			$datosReq['id_convocatoria'] = $resultadoConvocatoria;
			$datosReq['id_nivel'] = $resultadoRequisitos[0]->id_nivel;
			$datosReq['semestres'] = $resultadoRequisitos[0]->semestres;
			$datosReq['tiempo'] = $resultadoRequisitos[0]->tiempo;
			$datosReq['area'] = $resultadoRequisitos[0]->area;
			$datosReq['operativo'] = $resultadoRequisitos[0]->operativo;
			
			$resultadoReqMunIns = $this->convocatorias_model->insertarRequisitosEsp($datosReq);
			
			
			$resultadoConvocatoriaMun = $this->convocatorias_model->info_convocatoriaEspMun($id_convocatoria);			
			
			for($i=0;$i<count($resultadoConvocatoriaMun);$i++){
					
				$datosCM['id_convocatoria'] = $resultadoConvocatoria;
				$datosCM['id_ciudad'] = $resultadoConvocatoriaMun[$i]->id_ciudad;
				$datosCM['total_personas'] = $resultadoConvocatoriaMun[$i]->total_personas;
				$datosCM['total_insc'] = $resultadoConvocatoriaMun[$i]->total_insc;
				$datosCM['max_inscri'] = $resultadoConvocatoriaMun[$i]->max_inscri;
				$datosCM['fecha_inicio'] = $resultadoConvocatoriaMun[$i]->fecha_inicio;
				$datosCM['fecha_fin'] = $resultadoConvocatoriaMun[$i]->fecha_fin;
				$datosCM['eco'] = 0;
				
				
				$resultadoConvocatoriaMunIns = $this->convocatorias_model->insertarConvocatoriaInsc($datosCM);
				
			}	
			
			$this->session->set_flashdata('retornoExito', 'La solicitud fue procesada con exito, id convocatoria '.$resultadoConvocatoria);
			redirect(base_url('administrador/convocatorias/registrosConv'), 'refresh');
		}else{
			$this->session->set_flashdata('retornoError', 'Error al procesar la solicitud');
			redirect(base_url('administrador/convocatorias/registrosConv'), 'refresh');
		}
	}

	public function liberarUsuarios ($datos, $id_convocatoria, $id_conv_insc) {
		
		$usuarios = explode('-',$datos);
		for($u=0;$u<count($usuarios);$u++){
			
		}
	}

	public function crearArchivoMatricula ($datos, $id_convocatoria, $id_conv_insc) {
		//echo $id_convocatoria."----".$id_conv_insc;exit;
		$this->load->library('PHPExcel.php');
		
	    // configuramos las propiedades del documento
	    $this->phpexcel->getProperties()->setCreator("Departamento Administrativo Nacional de Estadistica")
	                                 ->setLastModifiedBy("Departamento Administrativo Nacional de Estadistica")
	                                 ->setTitle("Matricula plataforma de aprendizaje")
	                                 ->setSubject("Matricula plataforma de aprendizaje")
	                                 ->setDescription("Matricula plataforma de aprendizaje")
	                                 ->setKeywords("Matricula plataforma de aprendizaje")
	                                 ->setCategory("Matricula plataforma de aprendizaje");
	     
	     
	    // agregamos informaciÃÆÃÂ³n a las celdas
	    $this->phpexcel->setActiveSheetIndex(0)
	                ->setCellValue('A1', 'username')
	                ->setCellValue('B1', 'password')
	                ->setCellValue('C1', 'firstname')
	                ->setCellValue('D1', 'lastname')
					->setCellValue('E1', 'email')
					->setCellValue('F1', 'department')
					->setCellValue('G1', 'city')
					->setCellValue('H1', 'group1')
					->setCellValue('I1', 'course1')
					->setCellValue('J1', 'telefono')
					->setCellValue('K1', 'celular');

		$row = 2;
		$inscrito = 1;
		$usuarios = explode('-',$datos);
		
		for($u=0;$u<count($usuarios);$u++){
			
			if($usuarios[$u] != ''){

				$usuarioMatriculado = $this->convocatorias_model->usuarioMatriculado($usuarios[$u],$id_convocatoria,$id_conv_insc);				
				$total_usuarioMatriculado = count($usuarioMatriculado);
				
				if($total_usuarioMatriculado != 0){
					$datosUsuario = $this->perfil_model->datos_usuario($usuarios[$u]);
					$guardarMatricula = $this->convocatorias_model->guardar_matricula($usuarios[$u],$id_convocatoria,$id_conv_insc);
					$info_conv = $this->convocatorias_model->infoConvMun($id_convocatoria, $id_conv_insc);
					
					$unwanted_array = array('Ãâ¦ÃÂ '=>'S', 'Ãâ¦ÃÂ¡'=>'s', 'Ãâ¦ÃÂ½'=>'Z', 'Ãâ¦ÃÂ¾'=>'z', 'ÃÆÃ¢âÂ¬'=>'A', 'ÃÆÃ¯Â¿Â½'=>'A', 'ÃÆÃ¢â¬Å¡'=>'A', 'ÃÆÃâ'=>'A', 'ÃÆÃ¢â¬Å¾'=>'A', 'ÃÆÃ¢â¬Â¦'=>'A', 'ÃÆÃ¢â¬Â '=>'A', 'ÃÆÃ¢â¬Â¡'=>'C', 'ÃÆÃâ '=>'E', 'ÃÆÃ¢â¬Â°'=>'E',
	                            'ÃÆÃÂ '=>'E', 'ÃÆÃ¢â¬Â¹'=>'E', 'ÃÆÃâ'=>'I', 'ÃÆÃ¯Â¿Â½'=>'I', 'ÃÆÃÂ½'=>'I', 'ÃÆÃ¯Â¿Â½'=>'I', 'ÃÆÃ¢â¬Ë'=>'N', 'ÃÆÃ¢â¬â¢'=>'O', 'ÃÆÃ¢â¬Å'=>'O', 'ÃÆÃ¢â¬ï¿½'=>'O', 'ÃÆÃ¢â¬Â¢'=>'O', 'ÃÆÃ¢â¬â'=>'O', 'ÃÆÃÅ'=>'O', 'ÃÆÃ¢âÂ¢'=>'U',
	                            'ÃÆÃÂ¡'=>'U', 'ÃÆÃ¢â¬Âº'=>'U', 'ÃÆÃâ'=>'U', 'ÃÆÃ¯Â¿Â½'=>'Y', 'ÃÆÃÂ¾'=>'B', 'ÃÆÃÂ¸'=>'Ss', 'ÃÆÃÂ '=>'a', 'ÃÆÃÂ¡'=>'a', 'ÃÆÃÂ¢'=>'a', 'ÃÆÃÂ£'=>'a', 'ÃÆÃÂ¤'=>'a', 'ÃÆÃÂ¥'=>'a', 'ÃÆÃÂ¦'=>'a', 'ÃÆÃÂ§'=>'c',
	                            'ÃÆÃÂ¨'=>'e', 'ÃÆÃÂ©'=>'e', 'ÃÆÃÂª'=>'e', 'ÃÆÃÂ«'=>'e', 'ÃÆÃÂ¬'=>'i', 'ÃÆÃÂ­'=>'i', 'ÃÆÃÂ®'=>'i', 'ÃÆÃÂ¯'=>'i', 'ÃÆÃÂ°'=>'o', 'ÃÆÃÂ±'=>'n', 'ÃÆÃÂ²'=>'o', 'ÃÆÃÂ³'=>'o', 'ÃÆÃÂ´'=>'o', 'ÃÆÃÂµ'=>'o',
	                            'ÃÆÃÂ¶'=>'o', 'ÃÆÃÂ¸'=>'o', 'ÃÆÃÂ¹'=>'u', 'ÃÆÃÂº'=>'u', 'ÃÆÃÂ»'=>'u', 'ÃÆÃÂ½'=>'y', 'ÃÆÃÂ¾'=>'b', 'ÃÆÃÂ¿'=>'y', '.'=>'', ','=>'', 'ÃÆÃÂ¡'=>'a', '\u00e1;'=>'a');
				
				
					$nombresAr = strtr( utf8_decode($datosUsuario[0]->nombres), $unwanted_array );
					$nombres = ucwords(strtolower($nombresAr));
					
					$apellidosAr = strtr( utf8_decode($datosUsuario[0]->apellidos), $unwanted_array );
					$apellidos = ucwords(strtolower($apellidosAr));
					
					$departamentoAr = strtr( utf8_decode($info_conv[0]->nom_mpio), $unwanted_array );
					$departamento = ucwords(strtolower($departamentoAr));
					
					$convNombre = strtr( $info_conv[0]->nombre_inv." - ". $info_conv[0]->nombre_rol_inv , $unwanted_array );
					
					$this->phpexcel->setActiveSheetIndex(0)
		                ->setCellValue('A'.$row, $datosUsuario[0]->nume_iden)
		                ->setCellValue('B'.$row, "Dane".substr($datosUsuario[0]->nume_iden,-4)."+")
		                ->setCellValue('C'.$row, $nombres)
		                ->setCellValue('D'.$row, $apellidos)
						->setCellValue('E'.$row, strtolower($datosUsuario[0]->usuario))
						->setCellValue('F'.$row, $departamento)
						->setCellValue('G'.$row, $departamento."_".$id_conv_insc)
						->setCellValue('H'.$row, $departamento."_".$id_conv_insc)
						->setCellValue('I'.$row, $convNombre)
						->setCellValue('J'.$row, $datosUsuario[0]->telefono)
						->setCellValue('K'.$row, $datosUsuario[0]->celular);	
						
						$row++;
						$inscrito++;				
				}
			}		
		}
		
		foreach(range('A','K') as $columnID) {
		    $this->phpexcel->getActiveSheet()->getColumnDimension($columnID)
		        ->setAutoSize(true);
		}
		 	     
	    // Renombramos la hoja de trabajo
	    $this->phpexcel->getActiveSheet()->setTitle('moodle');
	     
	     
	    // configuramos el documento para que la hoja
	    // de trabajo nÃÆÃÂºmero 0 sera la primera en mostrarse
	    // al abrir el documento
	    $this->phpexcel->setActiveSheetIndex(0);
	     
	     
	    // redireccionamos la salida al navegador del cliente (Excel2007)
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment;filename="matricula_'.$id_conv_insc.'.xlsx"');
	    header('Cache-Control: max-age=0');
	     
	    $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
	    $objWriter->save('php://output');
	     
	    //------------------------------ LIBERACION DE USUARIOS NO MATRICULADOS -------------------------------------
	    
	    $this->liberaNoMatriculados($id_convocatoria, $id_conv_insc);
	    
	}
	
	
	public function liberaNoMatriculados($id_convocatoria, $id_conv_insc){

		$noMatriculados = $this->convocatorias_model->noMatriculados($id_convocatoria, $id_conv_insc);
		$datosConvocatoria = $this->convocatorias_model->info_convocatoria($id_convocatoria);		
		$liberacion = $this->convocatorias_model->liberarNoMatriculados($id_convocatoria, $id_conv_insc);
	
		if($liberacion){
					
			$this -> load -> library('My_PHPMailer');

			$this -> load -> library('email');
			$configMail = array('protocol' => 'smtp', 'smtp_host' => 'mail.dane.gov.co', 'smtp_port' => 25, 'smtp_user' => 'aplicaciones@dane.gov.co', 'smtp_pass' => '0u67UtapW3v', 'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
			
			for($a=0;$a<count($noMatriculados);$a++){

				$id_usuario = $noMatriculados[$a]->id_usuario;

				$datosUsuario = $this->convocatorias_model->datosUsuario($id_usuario);
				
				//cargamos la configuraciÃÂ³n para enviar mail
				$this -> email -> initialize($configMail);
	
				$this -> email -> from('aplicaciones@dane.gov.co', 'Banco Hojas de Vida');
				$this -> email -> to($datosUsuario[0]->usuario);
	//			$this -> email -> to('jonandres.c@gmail.com');
	//			$this -> email -> bcc('jonandres.c@gmail.com');
				$this -> email -> subject('Informacion importante convocatoria DANE');
	
				$html = '
					  <p>Estimado Usuario</p>
		              <p>
						Para la convocatoria a la que se postulo '.$datosConvocatoria[0]->nombre_inv.' - '.$datosConvocatoria[0]->nombre_rol_inv.', nos
						permitimos informarle que no ha sido elegido para continuar en el proceso. El motivo es que se presentaron personas con mayor experiencia y/o formacion academica.
					  </p>
					  <p>
						Lo invitamos a seguir revisando la plataforma para que aplique a las distintas convocatorias que el	DANE ofrece.
					  </p>'; 
					
				$this -> email -> message($html);
				if ($this -> email -> send()) {
						
				}
			}
	
			$this -> session -> set_flashdata('retornoExito', 'La actualizaci&oacute;n se realizo con exito');
			redirect(base_url('administrador/convocatorias/inscritos/'.$id_convocatoria.'/'.$id_conv_insc), 'refresh');
		}else{
			$this->session->set_flashdata('retornoError', 'Error al actualizar el registro, por favor contacte al administrador');
			redirect(base_url('administrador/convocatorias/inscritos/'.$id_convocatoria.'/'.$id_conv_insc), 'refresh');
		}
	}
	
	public function	actualizarMaxMatricular($id_convocatoria, $id_conv_insc){
		$maximo_matricular = $_REQUEST['maximoMatricular'];
		$cambiarMaximoMatricular = $this->convocatorias_model->cambiarMaximoMatricular($id_convocatoria, $id_conv_insc, $maximo_matricular);
		
		if($cambiarMaximoMatricular){
			$this -> session -> set_flashdata('retornoExito', 'La actualizaci&oacute;n de personas a matricular se realizo con exito');
			redirect(base_url('administrador/convocatorias/inscritos/'.$id_convocatoria.'/'.$id_conv_insc), 'refresh');
		}else{
			$this->session->set_flashdata('retornoError', 'Error al actualizar el registro, por favor contacte al administrador');
			redirect(base_url('administrador/convocatorias/inscritos/'.$id_convocatoria.'/'.$id_conv_insc), 'refresh');	
		}
	}
	
	public function	archivarConvocatoria($id_convocatoria){
		$archivar = $this->convocatorias_model->archivarConvocatoria($id_convocatoria);
	
		if($archivar){
			$liberar = $this->convocatorias_model->liberarUsuarios_convArchivada($id_convocatoria);
			if($liberar){
				$this -> session -> set_flashdata('retornoExito', 'Se archivo la convocatoria con exito');
				redirect(base_url('administrador/convocatorias'), 'refresh');
			}else{
				$this->session->set_flashdata('retornoError', 'Error al archivar convocatoria, por favor contacte al administrador');
				redirect(base_url('administrador/convocatorias'), 'refresh');
			}
		}else{
			$this->session->set_flashdata('retornoError', 'Error al archivar convocatoria, por favor contacte al administrador');
			redirect(base_url('administrador/convocatorias'), 'refresh');
		}
	}

}
