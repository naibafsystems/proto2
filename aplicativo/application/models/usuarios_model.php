<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	
	function consulta_usuario($documento, $nombres, $apellidos, $correo) {
        $this->load->database();
 
        $cadena_sql = "SELECT DISTINCT us.id_usuario, nombres, apellidos, tipo_iden, nume_iden, fecha_naci, sexo, celular, telefono, usuario, id_avatar, id_docIden ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "JOIN login lo ON us.id_usuario = lo.usuario_id_usuario  ";
        $cadena_sql.= "WHERE 1=1 ";
		
		if($documento != ''){
			$cadena_sql.= "AND nume_iden = '".$documento."' ";
		}
		if($nombres != ''){
			$cadena_sql.= "AND nombres like '%".$nombres."%' ";
		}
		if($apellidos != ''){
			$cadena_sql.= "AND apellidos like '%".$apellidos."%' ";
		}
		if($correo != ''){
			$cadena_sql.= "AND lo.usuario like '%".$correo."%' ";
		}
		
		

        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    function consulta_invitaciones($id_usuario) {
    	$this->load->database();
    
    	$cadena_sql = "SELECT DISTINCT inv.id_convocatoria, tipo_conv, nombre_inv, nombre_rol_inv, nom_mpio, aplico, fecha_aplico, envio_email, fecha_correo, req.operativo ";
    	$cadena_sql.= "FROM invitaciones inv ";
    	$cadena_sql.= "JOIN convocatorias con ON con.id_convocatoria = inv.id_convocatoria  ";
    	$cadena_sql.= "JOIN param_investigacion pinv ON pinv.id_investigacion = con.id_investigacion ";
    	$cadena_sql.= "JOIN param_rol_inv prol ON prol.id_rol_inv = con.id_rol ";
    	$cadena_sql.= "JOIN param_mpios mpio ON mpio.id_mpio = inv.id_ciudad ";
    	$cadena_sql.= "JOIN requisitos req ON con.id_convocatoria = req.id_convocatoria ";
    	$cadena_sql.= "WHERE inv.estado = 'AC' ";
    	$cadena_sql.= "AND inv.id_usuario = ".$id_usuario." ";
    
    	$query = $this->db->query($cadena_sql);
    
    	return $query->result();
    }
    
    function consulta_aplicacion($id_usuario) {
    	$this->load->database();
    
    	$cadena_sql = "SELECT DISTINCT usc.id_convocatoria, tipo_conv, nombre_inv, nombre_rol_inv, nom_mpio, doc_estado, observaciones, usc.estado, req.operativo ";
    	$cadena_sql.= "FROM usuario_convocatoria usc ";
    	$cadena_sql.= "JOIN convocatorias con ON con.id_convocatoria = usc.id_convocatoria ";
    	$cadena_sql.= "JOIN convocatorias_inscritos conins ON conins.id_conv_insc = usc.id_conv_insc ";
    	$cadena_sql.= "JOIN param_investigacion pinv ON pinv.id_investigacion = con.id_investigacion ";
    	$cadena_sql.= "JOIN param_rol_inv prol ON prol.id_rol_inv = con.id_rol ";
    	$cadena_sql.= "JOIN param_mpios mpio ON mpio.id_mpio = conins.id_ciudad ";
    	$cadena_sql.= "JOIN requisitos req ON con.id_convocatoria = req.id_convocatoria ";
    	$cadena_sql.= "WHERE usc.id_usuario = ".$id_usuario." ";
    	$cadena_sql.= "AND usc.estado = 'AC' ";
    
    	$query = $this->db->query($cadena_sql);
    
    	return $query->result();
    }

    public function roles() {
        $query = $this->db->query("SELECT * FROM roles WHERE estado = '1'");
        $result = $query->result();
        return $result;
    }

    function obtener_datosRol1() {
        $this->load->database();

        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, email, pa.desc_pais ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "JOIN param_paises pa ON pa.codi_pais = us.codi_pais  ";
        $cadena_sql.= "WHERE rol='1' ";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }

    function obtener_datosRol2() {
        $this->load->database();

        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, email, pa.desc_pais ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "JOIN param_paises pa ON pa.codi_pais = us.codi_pais  ";
        $cadena_sql.= "WHERE rol='2' ";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }

    function obtener_datosRol3() {
        $this->load->database();

        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, email, pa.desc_pais ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "JOIN param_paises pa ON pa.codi_pais = us.codi_pais  ";
        $cadena_sql.= "WHERE rol='3' ";

        $query = $this->db->query($cadena_sql);

        return $query->result();
    }

    function tipos_identificacion() {
        $this->load->database();

        $cadena_sql = "SELECT referencia, descripcion  ";
        $cadena_sql.= "FROM param_tipo_iden ";
        $cadena_sql.= "WHERE estado='AC' ";

        $query = $this->db->query($cadena_sql);

        return $query->result();
    }

    function paises() {
        $this->load->database();

        $cadena_sql = "SELECT codi_pais, desc_pais ";
        $cadena_sql.= "FROM param_paises ";

        $query = $this->db->query($cadena_sql);

        return $query->result();
    }

    public function obtenerCargo($inputCargo) {

        $this->load->database();

        $cadena_sql = "SELECT id_cargo, desc_cargo ";
        $cadena_sql.= "FROM param_cargo ";
        $cadena_sql.= "WHERE desc_cargo like '%" . $inputCargo . "%' ";

        $query = $this->db->query($cadena_sql);

        $registro = $query->result();

        return $registro;
    }

    public function obtenerEspeci($inputEspec) {

        $this->load->database();

        $cadena_sql = "SELECT id_espec, desc_espec ";
        $cadena_sql.= "FROM param_especialidad	 ";
        $cadena_sql.= "WHERE desc_espec like '%" . $inputEspec . "%' ";

        $query = $this->db->query($cadena_sql);

        $registro = $query->result();

        return $registro;
    }

    public function validarUsuarioCorreo($inputEmail) {

        $this->load->database();

        $cadena_sql = "SELECT usuario_id_usuario, usuario ";
        $cadena_sql.= "FROM login ";
        $cadena_sql.= "WHERE usuario = '" . $inputEmail . "' ";

        $query = $this->db->query($cadena_sql);

        if ($query->num_rows() > 0) {
            $registro = $query->result();
        } else {
            $registro = '';
        }
        return $registro;
    }

    public function validarUsuarioIdentificacion($tipo_iden, $inputNumero) {

        $this->load->database();

        $cadena_sql = "SELECT tipo_iden, nume_iden ";
        $cadena_sql.= "FROM usuario ";
        $cadena_sql.= "WHERE tipo_iden = '" . $tipo_iden . "' ";
        $cadena_sql.= "AND nume_iden = " . $inputNumero . " ";

        $query = $this->db->query($cadena_sql);

        if ($query->num_rows() > 0) {
            $registro = $query->result();
        } else {
            $registro = '';
        }

        return $registro;
    }

    public function insertarUsuario($param) {
        $this->db->trans_start();
        $this->db->insert('usuario', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function insertarRolUsuario($param) {
        $this->db->trans_start();
        $this->db->insert('usuario_rol', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function insertarDatosUsuario($param) {
        $this->db->trans_start();
        $this->db->insert('usuario_datos', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    public function insertarDatosLogin($param) {
        $this->db->trans_start();
        $this->db->insert('login', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    function datosUsuario($idUsuario) {
        $this->load->database();
 
        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, email, codi_pais, cargo, especialidad, rol ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "JOIN usuario_datos ud ON us.id_usuario = ud.id_usuario  ";
        $cadena_sql.= "JOIN usuario_rol ur ON us.id_usuario = ur.id_usuario ";
        $cadena_sql.= "WHERE us.id_usuario = ".$idUsuario;

        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    function actualizarUsuario($id_usuario, $nombres, $apellidos, $email, $codi_pais)
    {
        $data = array(
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'email' => $email,
            'codi_pais' => $codi_pais
        );
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->update('usuario', $data);
    }
	
    function activarCuenta($id_usuario)
    {
        $data = array(
            'estado' => 'AC'
        );
        $this->db->where('usuario_id_usuario', $id_usuario);
        return $this->db->update('login', $data);
    }
	
    function activarFecha($id_usuario)
    {
        $data = array(
            'fecha_acti' => date('Y-m-d H:i:s')
        );
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->update('usuario', $data);
    }
    
    function actualizarUsuarioDatos($id_usuario, $cargo, $especialidad)
    {
        $data = array(
            'cargo' => $cargo,
            'especialidad' => $especialidad
        );
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->update('usuario_datos', $data);
    }
    
    function actualizarUsuarioRol($id_usuario, $rol)
    {
        $data = array(
            'rol' => $rol
        );
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->update('usuario_rol', $data);
    }
    
    function eliminar_usuario($id_usuario)
    {
        $data = array(
            'rol' => $rol
        );
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->update('usuario_rol', $data);
    }
    
    function consultaridentificacion($cedula) {
    	$this->load->database();
    
    	$cadena_sql = "SELECT us.nume_iden ";
    	$cadena_sql.= "FROM usuario us ";
    	$cadena_sql.= "WHERE us.nume_iden = ".$cedula;
    
    	$query = $this->db->query($cadena_sql);
    
    	return $query->result();
    }
    
    function consultarid($idusuario, $cedula) {
    	$this->load->database();
    
    	$cadena_sql = "SELECT us.id_usuario ";
    	$cadena_sql.= "FROM usuario us ";
    	$cadena_sql.= "WHERE us.nume_iden = ".$cedula. " AND id_usuario!=".$idusuario;
    
    	$query = $this->db->query($cadena_sql);
    
    	return $query->result();
    }
}
