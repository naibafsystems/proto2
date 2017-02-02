<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios extends CI_Controller {

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
		
    	if (!($this -> session -> userdata('language'))) {
        	$this -> session -> set_userdata('language', 'spanish');
        }
        
        $user_language = $this -> session -> userdata('language');
        $this -> lang -> load('rtc_' . $user_language, $user_language);
        
        if(!$this->session->userdata('rol')){
        	$this->session->set_flashdata('retornoError', 'Su sesi&oacute;n finalizo');
        	redirect(base_url(), 'refresh');
        }    
        if($this->session->userdata('rol')!=1 && $this->session->userdata('rol')!=5 && $this->session->userdata('rol')!=6){
        	redirect(base_url(), 'refresh');
        }           
    }

    public function index() {

        $datos["contenido"] = "administrador/usuarios";
        $this->load->view('plantilla', $datos);
    }
	
	
	public function cargaDatosUsuario() {
		
		$documento = trim($this->input->post('documento'));
		$nombres = trim($this->input->post('nombres'));
		$apellidos = trim($this->input->post('apellidos'));
		$correo = trim($this->input->post('correo'));
		
		if($documento != '' || $nombres != '' || $apellidos != '' || $correo != ''){
			
			$datos["usuarios"] = $this->usuarios_model->consulta_usuario($documento, $nombres, $apellidos, $correo);
			
			if(count($datos["usuarios"]) > 0){
        		$this->load->view('administrador/usuariosDatos', $datos);
				//echo $data;
			}else{
				echo "<center><h2>Sin informaci&oacute;n</h2></center>";
			}			
			
		}else{
			echo "<center><h2>Sin informaci&oacute;n</h2></center>";
		}
        
    }

    public function crearUsuario() {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "administrador/crearUsuario";

        $datos['tipo_identificacion'] = $this->usuarios_model->tipos_identificacion();
        $datos['paises'] = $this->usuarios_model->paises();
        $datos['roles'] = $this->usuarios_model->roles();

        $this->load->view('plantilla', $datos);
    }

    public function guardarUsuario() {

        //$this->load->library('email');
        $this->load->library('My_PHPMailer');

        $datosU['nombres'] = $_REQUEST['inputNombres'];
        $datosU['apellidos'] = $_REQUEST['inputApellidos'];
        $datosU['email'] = $_REQUEST['inputEmail'];
        $datosU['codi_pais'] = $_REQUEST['pais'];

        //Se registra la informacion del usuario, restorna el ID que asigna la BD
        $resultadoID = $this->usuarios_model->insertarUsuario($datosU);

        if ($resultadoID) {
            $datosRol['id_usuario'] = $resultadoID;
            $datosRol['rol'] = $_REQUEST['rol_usuario'];
            $datosRol['estado'] = 'AC';
            $resultadoRol = $this->usuarios_model->insertarRolUsuario($datosRol);

            //Asignamos el ID que retorna a la variable id_usuario
            $datosCom['id_usuario'] = $resultadoID;
            $datosCom['cargo'] = $_REQUEST['inputCargo'];
            $datosCom['especialidad'] = $_REQUEST['inputEspeci'];

            $resultadoDatos = $this->usuarios_model->insertarDatosUsuario($datosCom);

            $psswd = $this->generaPass();
            $datosLogin['usuario_id_usuario'] = $resultadoID;
            $datosLogin['usuario'] = $_REQUEST['inputEmail'];
            $datosLogin['clave'] = sha1(md5($psswd));
            $datosLogin['estado'] = 'AC';

            $resultadoLogin = $this->usuarios_model->insertarDatosLogin($datosLogin);

            $this->load->library('email');

            $mail = new PHPMailer();
            $mail->IsSMTP(); // establecemos que utilizaremos SMTP
            $mail->IsHTML(true);
            $mail->SetFrom('rtc-candane@dane.gov.co', $this->lang->line('rtc'));  //Quien env&iacute;a el correo
            $mail->AddReplyTo("esanchez1988@gmail.com", "Edwin Sanchez");  //A quien debe ir dirigida la respuesta
            $mail->Subject = $this->lang->line('Registro de Usuarios RTC');  //Asunto del mensaje
            $mail->AddEmbeddedImage("assets/imgs/logo-rtc.jpg", 'imagen.jpg', "logo-rtc.jpg", 'base64', 'image/jpeg');

            $html = '
              <p><img src="cid:imagen.jpg"></p>
              <p>'.$this->lang->line('bienvenido').'</p>
              <p>'.$this->lang->line('parrafo1EmailRegistro').'.</p>
              <p>'.$this->lang->line('parrafo2EmailRegistro').' <a href="' . base_url() . '" target="_blank">link</a></p>
              <p>'.$this->lang->line('parrafo3EmailRegistro').':<br>
              '.$this->lang->line('user').': ' . $_REQUEST['inputEmail'] . '<br>
              '.$this->lang->line('password').': ' . $psswd . '
              </p>
              <p>.</p>
              ';

            $mail->Body = $html;
            $mail->AddAddress($_REQUEST['inputEmail'], $_REQUEST['inputNombres'] . " " . $_REQUEST['inputApellidos']);
            $mail->addBCC("esanchez1988@gmail.com", "Edwin Sanchez");

            if (!$mail->Send()) {
                $data["message"] = $this->lang->line('errorEnvio') . $mail->ErrorInfo;
                $this->session->set_flashdata('errorBD', $data["message"]);
                redirect(base_url('administrador/usuarios'), 'refresh');
            } else {
                //$data["message"] = "Ãƒâ€šÃ‚Â¡Mensaje enviado correctamente!";
                $this->session->set_flashdata('registroExitoso', $this->lang->line('registroExitoUsuario'));
                redirect(base_url('administrador/usuarios'), 'refresh');
            }
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('errorBD'));
            redirect(base_url('administrador/usuarios'), 'refresh');
        }
    }

    public function generaPass() {
        //Se define una cadena de caractares. Te recomiendo que uses esta.
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        //Obtenemos la longitud de la cadena de caracteres
        $longitudCadena = strlen($cadena);

        //Se define la variable que va a contener la contrase&ntilde;a
        $pass = "";
        //Se define la longitud de la contrase&ntilde;a, en mi caso 10, pero puedes poner la longitud que quieras
        $longitudPass = 10;

        //Creamos la contrase&ntilde;a
        for ($i = 1; $i <= $longitudPass; $i++) {
            //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos = rand(0, $longitudCadena - 1);

            //Vamos formando la contrase&ntilde;a en cada iteraccion del bucle, a&ntilde;adiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
            $pass .= substr($cadena, $pos, 1);
        }
        return $pass;
    }

    public function obtenerCargo() {
        $icargo = $_REQUEST['cargo'];
        $registro = $this->usuarios_model->obtenerCargo($icargo);

        if (is_array($registro)) {
            foreach ($registro as $fila) {
                $respuesta[] = array("label" => $fila->desc_cargo, "value" => $fila->id_cargo);
            }
        } else {
            $respuesta[] = array("label" => " ", "value" => "-1");
        }
        $data = json_encode($respuesta);
        echo $data;
        exit;
    }

    public function obtenerEspecialidad() {
        $iespec = $_REQUEST['espec'];
        $registro = $this->usuarios_model->obtenerEspeci($iespec);

        if (is_array($registro)) {
            foreach ($registro as $fila) {
                $respuesta[] = array("label" => $fila->desc_espec, "value" => $fila->id_espec);
            }
        } else {
            $respuesta[] = array("label" => " ", "value" => "-1");
        }
        $data = json_encode($respuesta);
        echo $data;
        exit;
    }

    public function editarUsuario($idUsuario) {

        $datos["titulo"] = $this->general_model->rol_usuario($this->session->userdata('rol'))->descripcion;
        $datos["contenido"] = "administrador/editarUsuario";

        $datos['datosUsuario'] = $this->usuarios_model->datosUsuario($idUsuario);
        $datos['paises'] = $this->usuarios_model->paises();
        $datos['roles'] = $this->usuarios_model->roles();

        $this->load->view('plantilla', $datos);
    }

    public function actualizarUsuario() {
        $id_usuario = $_REQUEST['id_usuario'];
        $nombres = $_REQUEST['inputNombres'];
        $apellidos = $_REQUEST['inputApellidos'];
        $cargo = $_REQUEST['inputCargo'];
        $especialidad = $_REQUEST['inputEspeci'];
        $email = $_REQUEST['inputEmail'];
        $codi_pais = $_REQUEST['pais'];
        $rol = $_REQUEST['rol_usuario'];

        $act_usuario = $this->usuarios_model->actualizarUsuario($id_usuario, $nombres, $apellidos, $email, $codi_pais);

        if ($act_usuario) {
            $act_usuario_datos = $this->usuarios_model->actualizarUsuarioDatos($id_usuario, $cargo, $especialidad);

            if ($act_usuario_datos) {
                $act_usuario_rol = $this->usuarios_model->actualizarUsuarioRol($id_usuario, $rol);
                if ($act_usuario_rol) {
                    $this->session->set_flashdata('datosUsuario', $this->lang->line('Datos actualizados correctamente'));
                    redirect(base_url('administrador/usuarios'), 'refresh');
                } else {
                    $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar actualizar el registro del rol'));
                    redirect(base_url('administrador/usuarios'), 'refresh');
                }
            } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar actualizar el registro del cargo y/o especialidad.'));
                redirect(base_url('administrador/usuarios'), 'refresh');
            }
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar actualizar el registro de datos.'));
            redirect(base_url('administrador/usuarios'), 'refresh');
        }
    }

    public function borrarUsuario($idUsuario) {

        $delete = $this->usuarios_model->eliminar_usuario($idUsuario);
        redirect(base_url('administrador/usuarios'), 'refresh');
        echo $idUsuario;
    }

	public function usuariosInnovacion()
	{
		$datos["contenido"] = "administrador/usuariosInnovacion";  
		$this->load->view('plantilla', $datos);
	}

	public function crearArchivoUsuarios () {
		
		if(trim($_REQUEST['usuarios']) == ''){
			$this->session->set_flashdata('errorBD', $this->lang->line('Error al procesar los datos, favor verifique los datos que ha diligenciado.'));
            redirect(base_url('administrador/usuariosInnovacion'), 'refresh');
		}else{
				
		$usuariosBuscar = $_REQUEST['usuarios'];						
		$usuariosMatricula = $this->convocatorias_model->personasBuscar($usuariosBuscar);
						
		$this->load->library('PHPExcel.php');
		
	    // configuramos las propiedades del documento
	    $this->phpexcel->getProperties()->setCreator("Departamento Administrativo Nacional de Estadistica")
	                                 ->setLastModifiedBy("Departamento Administrativo Nacional de Estadistica")
	                                 ->setTitle("Usuarios")
	                                 ->setSubject("Usuarios")
	                                 ->setDescription("Usuarios")
	                                 ->setKeywords("Usuarios")
	                                 ->setCategory("Usuarios");
	     
	     
	    // agregamos informaciÃƒÂ³n a las celdas
	    $this->phpexcel->setActiveSheetIndex(0)
	                ->setCellValue('A1', 'username')
	                ->setCellValue('B1', 'firstname')
	                ->setCellValue('C1', 'lastname')
	                ->setCellValue('D1', 'email')
					->setCellValue('E1', 'sexo')
					->setCellValue('F1', 'edad')
					->setCellValue('G1', 'formacion academica')
					->setCellValue('H1', 'experiencia laboral');

		$row = 2;
		$inscrito = 1;
		//$usuarios = explode('-',$datos);
		
		for($u=0;$u<count($usuariosMatricula);$u++){
			
			if($usuariosMatricula[$u] != ''){
				$datosUsuario = $this->perfil_model->datos_usuario($usuariosMatricula[$u]->id_usuario);
				$formacionUsuario = $this->perfil_model->formacionUsuario($usuariosMatricula[$u]->id_usuario);
				$experienciaUsuario = $this->perfil_model->experienciaUsuario($usuariosMatricula[$u]->id_usuario);
								
				if($datosUsuario[0]->fecha_naci != '0000-00-00'){
					$edad = $datosUsuario[0]->fecha_naci;
				
					list($Y,$m,$d) = explode("-",$edad);
	    			$edadP = ( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
				}else{
					$edadP = 'No registra';
				}
				
				
				$genero = $datosUsuario[0]->genero;				
								
				//FORMACION ACADEMICA
				$formacion = '';
				for($f=0;$f<count($formacionUsuario);$f++){
					
					switch($formacionUsuario[$f]->id_nivel){
						case 1:
							$formacion .= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
						case 2:
							$formacion.= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
						case 3:
							$formacion .= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
						case 4:
							$formacion .= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
						case 5:
							$formacion .= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
						case 6:
							$formacion .= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
						case 8:
							$formacion .= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
						case 9:
							$formacion .= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
						case 10:
							$formacion .= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
						case 11:
							$formacion .= " - ".($formacionUsuario[$f]->descripcion)."  ";
						break;
					}							
				}
				
				
				//EXPERIENCIA LABORAL
				if(count($experienciaUsuario)>0)
				{	
					$dias = 0;
					$exp = 0;
			        for($j=0;$j<count($experienciaUsuario);$j++)
			            {
			                    if($experienciaUsuario[$j]->fecha_retiro == '0000-00-00')
			                    {
			                            $fechaRetiro = 'Actualmente';
			                            $fechaCalcular = date('Y-m-d');
			                    }else
			                    {
			                            $fechaRetiro = $experienciaUsuario[$j]->fecha_retiro;
			                            $fechaCalcular = $experienciaUsuario[$j]->fecha_retiro;
			                    }
			
			                    $fechainicial = new DateTime($experienciaUsuario[$j]->fecha_ingreso);
			                    $fechafinal = new DateTime($fechaCalcular);
			
			                    $diferencia = $fechainicial->diff($fechafinal);
			
			                    $dias = $dias + $diferencia->days;
								
								$aniosE = $diferencia->y;
								$mesesE = $diferencia->m;
								$diasE = $diferencia->d;								
								$diasExperiencia = $aniosE." Años - ".$mesesE." Meses - ".$diasE." Dias ";
								
								$expEnCuenta[$exp]['empresa'] = $experienciaUsuario[$j]->empresa;
								$expEnCuenta[$exp]['fechaIngreso'] = $experienciaUsuario[$j]->fecha_ingreso;
								$expEnCuenta[$exp]['fechaRetiro'] = $fechaCalcular;
								$expEnCuenta[$exp]['experiencia'] = $diasExperiencia;
								$exp++;
			
			            }
			
			            $mesesExperiencia = $dias/30; 
			            $aniosExperiencia = $mesesExperiencia/12; 
												
			            $tiempo = explode(".",$aniosExperiencia);
			            $anio = $tiempo[0];
			            $mes = "0.".$tiempo[1];
			            $mesExperiencia = $mes*12;
						
			            $experiencia = intval($anio)." Años  -  ".intval($mesExperiencia)." Meses";
						//$informacionExponer[$i]['experiencia'] = print_r($dias);
						$tiempo_experiencia = $mesesExperiencia;
		
				}else{
					$mesExperiencia = 0;
					$mesesExperiencia = 0;
					$experiencia = "Sin experiencia";
					//$informacionExponer[$i]['experiencia'] = print_r($dias);
					$tiempo_experiencia = $mesesExperiencia;
				}
												
				$unwanted_array = array('Ã…Â '=>'S', 'Ã…Â¡'=>'s', 'Ã…Â½'=>'Z', 'Ã…Â¾'=>'z', 'Ãƒâ‚¬'=>'A', 'Ãƒï¿½'=>'A', 'Ãƒâ€š'=>'A', 'ÃƒÆ’'=>'A', 'Ãƒâ€ž'=>'A', 'Ãƒâ€¦'=>'A', 'Ãƒâ€ '=>'A', 'Ãƒâ€¡'=>'C', 'ÃƒË†'=>'E', 'Ãƒâ€°'=>'E',
                            'ÃƒÅ '=>'E', 'Ãƒâ€¹'=>'E', 'ÃƒÅ’'=>'I', 'Ãƒï¿½'=>'I', 'ÃƒÅ½'=>'I', 'Ãƒï¿½'=>'I', 'Ãƒâ€˜'=>'N', 'Ãƒâ€™'=>'O', 'Ãƒâ€œ'=>'O', 'Ãƒâ€�'=>'O', 'Ãƒâ€¢'=>'O', 'Ãƒâ€“'=>'O', 'ÃƒËœ'=>'O', 'Ãƒâ„¢'=>'U',
                            'ÃƒÅ¡'=>'U', 'Ãƒâ€º'=>'U', 'ÃƒÅ“'=>'U', 'Ãƒï¿½'=>'Y', 'ÃƒÅ¾'=>'B', 'ÃƒÅ¸'=>'Ss', 'ÃƒÂ '=>'a', 'ÃƒÂ¡'=>'a', 'ÃƒÂ¢'=>'a', 'ÃƒÂ£'=>'a', 'ÃƒÂ¤'=>'a', 'ÃƒÂ¥'=>'a', 'ÃƒÂ¦'=>'a', 'ÃƒÂ§'=>'c',
                            'ÃƒÂ¨'=>'e', 'ÃƒÂ©'=>'e', 'ÃƒÂª'=>'e', 'ÃƒÂ«'=>'e', 'ÃƒÂ¬'=>'i', 'ÃƒÂ­'=>'i', 'ÃƒÂ®'=>'i', 'ÃƒÂ¯'=>'i', 'ÃƒÂ°'=>'o', 'ÃƒÂ±'=>'n', 'ÃƒÂ²'=>'o', 'ÃƒÂ³'=>'o', 'ÃƒÂ´'=>'o', 'ÃƒÂµ'=>'o',
                            'ÃƒÂ¶'=>'o', 'ÃƒÂ¸'=>'o', 'ÃƒÂ¹'=>'u', 'ÃƒÂº'=>'u', 'ÃƒÂ»'=>'u', 'ÃƒÂ½'=>'y', 'ÃƒÂ¾'=>'b', 'ÃƒÂ¿'=>'y', '.'=>'', ','=>'', 'ÃƒÂ¡'=>'a', '\u00e1;'=>'a');
			
			
				$nombresAr = strtr( utf8_decode($datosUsuario[0]->nombres), $unwanted_array );
				$nombres = ucwords(strtolower($nombresAr));
				
				$apellidosAr = strtr( utf8_decode($datosUsuario[0]->apellidos), $unwanted_array );
				$apellidos = ucwords(strtolower($apellidosAr));
												
				$this->phpexcel->setActiveSheetIndex(0)
	                ->setCellValue('A'.$row, $datosUsuario[0]->nume_iden)
	                ->setCellValue('B'.$row, $nombres)
	                ->setCellValue('C'.$row, $apellidos)
	                ->setCellValue('D'.$row, strtolower($datosUsuario[0]->usuario))
					->setCellValue('E'.$row, $genero)
					->setCellValue('F'.$row, $edadP)
					->setCellValue('G'.$row, $formacion)
					->setCellValue('H'.$row, $experiencia);	
					
					$row++;
					$inscrito++;				
			}		
		}
		
		foreach(range('A','H') as $columnID) {
		    $this->phpexcel->getActiveSheet()->getColumnDimension($columnID)
		        ->setAutoSize(true);
		}
		 	     
	    // Renombramos la hoja de trabajo
	    $this->phpexcel->getActiveSheet()->setTitle('moodle');
	     
	     
	    // configuramos el documento para que la hoja
	    // de trabajo nÃƒÂºmero 0 sera la primera en mostrarse
	    // al abrir el documento
	    $this->phpexcel->setActiveSheetIndex(0);
	     
	     
	    // redireccionamos la salida al navegador del cliente (Excel2007)
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment;filename="usuarios_consulta.xlsx"');
	    header('Cache-Control: max-age=0');
	     
	    $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
	    $objWriter->save('php://output');
	     
		}
	}

}
