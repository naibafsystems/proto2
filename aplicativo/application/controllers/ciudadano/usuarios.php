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
        $datos["contenido"] = "administrador/usuarios";
        $datos['roles'] = $this->usuarios_model->roles();

        $datos['rol1'] = $this->usuarios_model->obtener_datosRol1();
        $datos['rol2'] = $this->usuarios_model->obtener_datosRol2();
        $datos['rol3'] = $this->usuarios_model->obtener_datosRol3();

        $this->load->view('plantilla', $datos);
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
        /*
          $this->load->library('email');

          $config['protocol'] = 'smtp';  // protocolo de envio de correo
          $config['smtp_host'] = 'smtp.gmail.com'; // direcci&oacute;n SMTP del servidor
          $config['smtp_user'] = 'pruebasrtccepal@gmail.com'; // remplazarlo por un cuenta real de Gmail - usuario SMTP
          $config['smtp_pass'] = 'rtc123456';
          $config['smtp_port'] = '587'; // o el '587' --  Puerto SMTP
          $config['charset'] = 'utf-8';
          $config['wordwrap'] = TRUE;
          $config['validate'] = true;

          $this->email->initialize($config);

          $this->email->from('esanchez1988@gmail.com', 'Edwin Sanchez');
          $this->email->to('esanchez1988@gmail.com', 'V&iacute;ctor Robles');
          $this->email->subject('Email Test');


          $html = '
          <p>Bienvenido</p>
          <p>Se ha creado una nueva cuenta para ingresar  la plataforma de la Red de Transmisi&oacute;n del Conocimiento RTC.</p>
          <p>Puede acceder a la plataforma a traves del siguiente <a href="' . base_url() . '" target="_blank">link</a></p>
          <p>Sus datos de ingreso son los siguientes:<br>
          Usuario: ' . $_REQUEST['inputEmail'] . '
          Clave: ' . $_REQUEST['inputEmail'] . '
          </p>
          <p>Recuerde que puede cambiar su contrase&ntilde;a despues de ingresar a la plataforma.</p>
          ';

          $this->email->message($html);
          $this->email->send();

          echo $this->email->print_debugger();
          exit; */
        /*
          $psswd = substr(microtime(), 1, 8);

          $this->email->from('esanchez1988@gmail.com', 'Edwin Sanchez');
          $this->email->to('esanchez1988@gmail.com');
          $this->email->subject('Datos de ingreso RTC');

          $html = '
          <p>Bienvenido</p>
          <p>Se ha creado una nueva cuenta para ingresar  la plataforma de la Red de Transmisi&oacute;n del Conocimiento RTC.</p>
          <p>Puede acceder a la plataforma a traves del siguiente <a href="' . base_url() . '" target="_blank">link</a></p>
          <p>Sus datos de ingreso son los siguientes:<br>
          Usuario: ' . $_REQUEST['inputEmail'] . '
          Clave: ' . $psswd . '
          </p>
          <p>Recuerde que puede cambiar su contrase&ntilde;a despues de ingresar a la plataforma.</p>
          ';

          $this->email->message($html);

          if ($this->email->send()) {

          $data['title'] = 'Mensaje Enviado';
          $data['msg'] = 'Mensaje enviado a su email';
          // echo $this->email->print_debugger(); exit;
          } else {
          $data['title'] = 'El mensaje no se pudo enviar';
          }
          var_dump($data);
          exit;
          //validar si ya existe un usuario con ese correo electronico o con ese tipo y numero de identificacion
          /*
          $correo = $this->usuarios_model->validarUsuarioCorreo($_REQUEST['inputEmail']);

          if (is_array($correo)) {
          $this->session->set_flashdata('correoRegistrado', 'El correo ya se encuentra registrado, si desea agregar el usuario con un nuevo rol, puede ingresar por la opci&oacute;n editar del usuario');
          redirect(base_url('administrador/usuarios/crearUsuario'), 'refresh');
          }

          //validar si ya existe un usuario con ese tipo y numero de identificacion
          $identificacion = $this->usuarios_model->validarUsuarioIdentificacion($_REQUEST['tipo_iden'], $_REQUEST['inputNumero']);
          if (is_array($identificacion)) {
          $this->session->set_flashdata('identificacionRegistrado', 'El usuario ya se encuentra registrado con ese tipo y n&uacute;mero de identificaci&oacute;n, si desea agregar el usuario con un nuevo rol, puede ingresar por la opci&oacute;n editar del usuario');
          redirect(base_url('administrador/usuarios/crearUsuario'), 'refresh');
          }
         */
        $datosU['tipo_iden'] = $_REQUEST['tipo_iden'];
        $datosU['nume_docu'] = $_REQUEST['inputNumero'];
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

            $this->session->set_flashdata('datosUsuario', 'Usuario:' . $_REQUEST['inputEmail'] . ' - Clave: ' . $psswd);
            redirect(base_url('administrador/usuarios'), 'refresh');
        } else {
            $this->session->set_flashdata('errorBD', $this->lang->line('Ocurrio un error al intentar guardar el registro'));
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

}
