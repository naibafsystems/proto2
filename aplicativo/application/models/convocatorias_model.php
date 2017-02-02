<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class Convocatorias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function investigaciones() {
        $cadena_sql = "SELECT id_investigacion, nombre_inv  ";
        $cadena_sql.= " FROM param_investigacion ";
        $cadena_sql.= " WHERE estado = 'AC' ";
		$cadena_sql.= " ORDER BY nombre_inv ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function roles() {
        $cadena_sql = "SELECT id_rol_inv, nombre_rol_inv  ";
        $cadena_sql.= " FROM param_rol_inv ";
        $cadena_sql.= " WHERE estado = 'AC' ";
		$cadena_sql.= " ORDER BY nombre_rol_inv ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function sedes() {
        $cadena_sql = "SELECT id_mpio, nom_mpio, nomb_terri  ";
        $cadena_sql.= " FROM param_territorial ter";
        $cadena_sql.= " JOIN param_subsede sed ON ter.id_territorial = sed.id_territorial ";
        $cadena_sql.= " JOIN param_mpios mpi ON sed.id_ciudad = mpi.id_mpio ";
        $cadena_sql.= " ORDER BY 3,2 ";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function insertarDatosConvocatoria($param) {
        $this->db->trans_start();
        $this->db->insert('convocatorias', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    public function ActualizarArchivoConvocatoria($id_convocatoria,$id_archivo) {
    	$data = array(
            'id_archivoConv' => $id_archivo
        );
        $this->db->where('id_convocatoria', $id_convocatoria);
        return $this->db->update('convocatorias', $data);
    }
    
    function actualizarDatosConvocatoria($datos)
    {
        $data = array(
            'perfil' => $datos['perfil'],
            'objeto' => $datos['objeto'],
            'obligaciones' => $datos['obligaciones'],
            'honorarios' => $datos['honorarios'],
			'tipo_conv' => $datos['tipo_conv']
        );
        $this->db->where('id_convocatoria', $datos['id_convocatoria']);
        return $this->db->update('convocatorias', $data);
    }
	
	function actualizarFechaConvocatoria($datos)
    {
        $data = array(
            'fecha_inicio' => $datos['fecha_inicio'],
            'fecha_fin' => $datos['fecha_fin']
        );
        $this->db->where('id_convocatoria', $datos['id_convocatoria']);
        return $this->db->update('convocatorias_inscritos', $data);
    }
	
	
    
    public function insertarConvocatoriaInsc($param) {
        $this->db->trans_start();
        $this->db->insert('convocatorias_inscritos', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
	
	public function insertarRequisitosEsp($param) {
        $this->db->trans_start();
        $this->db->insert('requisitos', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    public function conv_abiertas_info() {
        $cadena_sql = "SELECT DISTINCT con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, perfil, objeto, obligaciones, honorarios, tipo_conv, operativo  ";
        $cadena_sql.= " FROM convocatorias con ";
		$cadena_sql.= " LEFT JOIN requisitos req ON req.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " WHERE tipo_conv = 'A' AND archivado='0' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function conv_abiertas_clon() {
        $cadena_sql = "SELECT con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, perfil, objeto, obligaciones, honorarios, tipo_conv, operativo  ";
        $cadena_sql.= " FROM convocatorias con ";
		$cadena_sql.= " LEFT JOIN requisitos req ON req.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " WHERE tipo_conv = 'A' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function conv_cerradas_info() {
        $cadena_sql = "SELECT DISTINCT con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, perfil, objeto, obligaciones, honorarios, tipo_conv, operativo ";
        $cadena_sql.= " FROM convocatorias con ";
		$cadena_sql.= " JOIN requisitos req ON req.id_convocatoria = con.id_convocatoria "; 
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " WHERE tipo_conv = 'C' AND archivado='0' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function info_convocatoria($id_convocatoria) {
        $cadena_sql = "SELECT distinct con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, conins.id_conv_insc, mun.nom_mpio, total_personas, total_insc, eco, fecha_inicio, fecha_fin, id_archivoConv, ar.nombre AS nom_archivo  ";
        $cadena_sql.= " FROM convocatorias con ";
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " JOIN convocatorias_inscritos conins ON conins.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = conins.id_ciudad ";
        $cadena_sql.= " LEFT JOIN archivos ar ON ar.id_archivo=con.id_archivoConv ";
        $cadena_sql.= " WHERE con.id_convocatoria = ".$id_convocatoria." ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function consultarArchivos($nombre) {
    	$cadena_sql = "SELECT id_archivo ";
    	$cadena_sql.= " FROM archivos ";
    	$cadena_sql.= " WHERE nombre = '".$nombre."' ";
    
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
	
	public function info_convocatoriaEsp($id_convocatoria) {
        $cadena_sql = "SELECT distinct con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, perfil, objeto, obligaciones, honorarios  ";
        $cadena_sql.= " FROM convocatorias con ";
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " WHERE con.id_convocatoria = ".$id_convocatoria." ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function info_convocatoriaEspMun($id_convocatoria) {
        $cadena_sql = "SELECT id_ciudad, total_personas, total_insc, max_inscri, fecha_inicio, fecha_fin, eco  ";
        $cadena_sql.= " FROM convocatorias_inscritos con ";
        $cadena_sql.= " WHERE con.id_convocatoria = ".$id_convocatoria." ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function info_requisitosEsp($id_convocatoria) {
        $cadena_sql = "SELECT distinct id_nivel, semestres, tiempo, area, operativo  ";
        $cadena_sql.= " FROM requisitos ";
        $cadena_sql.= " WHERE id_convocatoria = ".$id_convocatoria." ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
       
    
    public function conv_cerradas($id_convocatoria) {
        $cadena_sql = "SELECT distinct con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, total_personas, total_insc  ";
        $cadena_sql.= " FROM convocatorias con ";
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " JOIN convocatorias_inscritos conins ON conins.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " WHERE con.id_convocatoria = ".$id_convocatoria." ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function infoConv($id) {
        $cadena_sql = "SELECT distinct con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, id_ciudad, mun.nom_mpio, total_personas, total_insc, max_inscri  ";
        $cadena_sql.= " FROM convocatorias con ";
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " JOIN convocatorias_inscritos conins ON conins.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = conins.id_ciudad ";
        $cadena_sql.= " WHERE con.id_convocatoria = '".$id."' ";
		
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function infoConvMun($id_convocatoria, $id_conv_ins) {
        $cadena_sql = "SELECT distinct con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, id_ciudad, mun.nom_mpio, total_personas, total_insc, max_inscri  ";
        $cadena_sql.= " FROM convocatorias con ";
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " JOIN convocatorias_inscritos conins ON conins.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = conins.id_ciudad ";
        $cadena_sql.= " WHERE conins.id_convocatoria = '".$id_convocatoria."' ";
        $cadena_sql.= " AND conins.id_conv_insc = '".$id_conv_ins."' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function listaAreas() {
        $cadena_sql = "SELECT prog.id_programa, prog.desc_programa, desc_areacono ";
        $cadena_sql.= "FROM param_programa prog ";
        $cadena_sql.= "JOIN param_areacono are ON are.id_areacono = prog.id_areacono ";
        $cadena_sql.= " WHERE are.estado = 'AC'";
        $cadena_sql.= " AND prog.estado = 'AC'";
        $cadena_sql.= " ORDER BY 3,2 ";
        
        $query = $this->db->query($cadena_sql);

        $result = $query->result();

        return $result;
    }
    
    public function listaProgramas($idNivel) {
        $cadena_sql = "SELECT prog.id_programa, prog.desc_programa, desc_areacono ";
        $cadena_sql.= "FROM param_programa prog ";
        $cadena_sql.= "JOIN param_areacono are ON are.id_areacono = prog.id_areacono ";
        $cadena_sql.= " WHERE are.estado = 'AC'";
        $cadena_sql.= " AND prog.estado = 'AC'";
        $cadena_sql.= " AND prog.id_nivel = '".$idNivel."'";
        $cadena_sql.= " ORDER BY 3,2 ";
        
        $query = $this->db->query($cadena_sql);

        $result = $query->result();

        return $result;
    }
    
    public function info_por_ciudades($id_convocatoria) {
        $cadena_sql = "SELECT distinct con.id_convocatoria, id_conv_insc , id_ciudad, mun.nom_mpio, total_personas, total_insc, max_inscri, eco, fecha_inicio, fecha_fin  ";
        $cadena_sql.= " FROM convocatorias con ";
        $cadena_sql.= " JOIN convocatorias_inscritos conins ON conins.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = conins.id_ciudad ";
        $cadena_sql.= " WHERE con.id_convocatoria = ".$id_convocatoria." ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    
    public function verifica_usuario($tipo_iden, $nume_iden) {
        $cadena_sql = "SELECT id_usuario, tipo_iden, nume_iden, nombres, apellidos ";
        $cadena_sql.= " FROM usuario ";
        $cadena_sql.= " WHERE tipo_iden = '".$tipo_iden."' ";
        $cadena_sql.= " AND nume_iden = '".$nume_iden."' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function verificaInvitacionUsuario($id_usuario, $id_conv) {
        $cadena_sql = "SELECT id_invitacion, id_convocatoria, id_usuario ";
        $cadena_sql.= " FROM invitaciones ";
        $cadena_sql.= " WHERE id_usuario = '".$id_usuario."' ";
        $cadena_sql.= " AND id_convocatoria = '".$id_conv."' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function usuariosInvitados($id_conv) {
        $cadena_sql = "SELECT id_invitacion, id_convocatoria, inv.id_usuario, aplico, cumple_req, envio_email, fecha_aplico, fecha_correo, nombres, apellidos, tipo_iden, nume_iden, usuario, nom_mpio ";
        $cadena_sql.= " FROM invitaciones inv ";
        $cadena_sql.= " JOIN usuario usu ON usu.id_usuario = inv.id_usuario ";
        $cadena_sql.= " JOIN login log ON log.usuario_id_usuario = inv.id_usuario ";
		$cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = inv.id_ciudad ";
        $cadena_sql.= " WHERE id_convocatoria = '".$id_conv."' ";
        $cadena_sql.= " AND inv.estado = 'AC' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function requisitosInscritos($id_conv) {
        $cadena_sql = "SELECT id_ciudad, mun.nom_mpio, total_personas, max_inscri, fecha_inicio, fecha_fin ";
        $cadena_sql.= " FROM convocatorias_inscritos cinv ";
        $cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = cinv.id_ciudad ";
        $cadena_sql.= " WHERE id_convocatoria = '".$id_conv."' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function requisitosInscritos2($id_conv) {
        $cadena_sql = "SELECT id_nivel, semestres, tiempo, area, operativo ";
        $cadena_sql.= " FROM requisitos req ";
        $cadena_sql.= " WHERE id_convocatoria = '".$id_conv."' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function requisitosInscritosMun($id_conv, $id_conv_insc) {
        $cadena_sql = "SELECT id_ciudad, mun.nom_mpio, total_personas, max_inscri, fecha_inicio, fecha_fin ";
        $cadena_sql.= " FROM convocatorias_inscritos cinv ";
        $cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = cinv.id_ciudad ";
        $cadena_sql.= " WHERE id_convocatoria = '".$id_conv."' ";
        $cadena_sql.= " AND cinv.id_conv_insc = '".$id_conv_insc."' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function requisitosInscritos2Mun($id_conv) {
        $cadena_sql = "SELECT id_nivel, semestres, tiempo, area, operativo ";
        $cadena_sql.= " FROM requisitos req ";
        $cadena_sql.= " WHERE id_convocatoria = '".$id_conv."' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function documentosCompletos($id_usuario, $id_conv) {
        $cadena_sql = "SELECT doc_estado, observaciones ";
        $cadena_sql.= " FROM usuario_convocatoria  ";
        $cadena_sql.= " WHERE id_convocatoria = '".$id_conv."' ";
        $cadena_sql.= " AND id_usuario = '".$id_usuario."' ";
        $cadena_sql.= " AND estado = 'AC' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function insertarUsuarioInvitacion($param) {
        $this->db->trans_start();
        $this->db->insert('invitaciones', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    
    public function guardarRequisitos($param, $total_registros) {
    	if ($total_registros!=0){
    		
    		$data = array(
    			'id_convocatoria' => $param['id_convocatoria'],
    			'id_nivel' => $param['id_nivel'][$total_registros],
    			'semestres' => $param['semestres'][$total_registros],
    			'tiempo' => $param['tiempo'][$total_registros],
    			'operativo' => $param['operativo'],
    			'area' => $param['area']    			
    		);
    		$this->db->insert('requisitos', $data);
    	}else{
    		$data = array(
    				'id_convocatoria' => $param['id_convocatoria'],
    				'id_nivel' => $param['id_nivel'][$total_registros],
    				'semestres' => $param['semestres'][$total_registros],
    				'tiempo' => $param['tiempo'][$total_registros],
    				'operativo' => $param['operativo'],
    				'area' => $param['area']
    		);
    		$this->db->insert('requisitos', $data);
    		/*
    		$this->db->trans_start();
    		$this->db->insert('requisitos', $param);
    		$insert_id = $this->db->insert_id();
    		$this->db->trans_complete();
    		return  $insert_id;
    		
    		*/
    	}
    }
    
    public function verificaRequisitos($id_conv) {
        $cadena_sql = "SELECT id_requisito, id_convocatoria, id_nivel, semestres, tiempo, area, operativo  ";
        $cadena_sql.= "FROM requisitos ";
        $cadena_sql.= "WHERE id_convocatoria = '" . $id_conv . "'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }   
	
	public function infoRequisitos($id_conv) {
        $cadena_sql = "SELECT id_requisito, id_convocatoria, rq.id_nivel, nf.descripcion, semestres, tiempo, area, operativo  ";
        $cadena_sql.= "FROM requisitos rq ";
		$cadena_sql.= "JOIN param_nivel_formacion nf ON rq.id_nivel = nf.id_nivel ";
        $cadena_sql.= "WHERE id_convocatoria = '" . $id_conv . "'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }   
    
    function actualizarRequisitos($parametros,$total_registros)
    {
    	for($i=0;$i<$total_registros;$i++){
	    		
		    	$data = array(
		            'id_nivel' => $parametros['id_nivel'][$i],
		            'semestres' => $parametros['semestres'][$i],
		            'tiempo' => $parametros['tiempo'][$i],
		            'area' => $parametros['area'],
		            'operativo' => $parametros['operativo']
		        );
		        
		        $array = array('id_requisito' => $parametros['id_requisito'][$i]->id_requisito);
		        $this->db->where($array);
		        if($i!=($total_registros-1)){
		        	$this->db->update('requisitos', $data);
		        }else{
		        	return $this->db->update('requisitos', $data);
		        }
    	}
    }
    
    public function datosUsuario($id_usuario) {
        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, usuario, rol FROM login lo ";
        $cadena_sql.= "JOIN usuario us ON usuario_id_usuario = us.id_usuario ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "WHERE us.id_usuario = '" . $id_usuario . "'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    function actualizarEnvio($id_usuario, $id_conv)
    {
        $data = array(
            'fecha_correo' => date('Y-m-d H:i:s'),
            'envio_email' => 'SI'
        );
        
        $array = array('id_usuario' => $id_usuario, 'id_convocatoria' => $id_conv);
        $this->db->where($array);
        return $this->db->update('invitaciones', $data);
        
    }
    
    public function buscarInscritos($id_conv) {
        $cadena_sql = "SELECT id_conv_insc, id_convocatoria, id_ciudad, total_personas, total_insc, max_inscri, fecha_inicio, fecha_fin ";
        $cadena_sql.= "FROM convocatorias_inscritos ";
        $cadena_sql.= "WHERE id_convocatoria = '" . $id_conv . "'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function informacionPerfil($investigacion, $rol) {
        $cadena_sql = "SELECT perfil, objeto ";
        $cadena_sql.= "FROM param_perfil_inves ";
        $cadena_sql.= " WHERE id_investigacion = '" . $investigacion . "'";
        $cadena_sql.= " AND id_rol_inv = '" . $rol . "'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    function actualizarInscritos($parametros)
    {
    	
        $data = array(
            'total_personas' => $parametros['total_personas'],
            'max_inscri' => $parametros['max_inscri'],
        	'total_insc' => $parametros['total_insc'],
            'eco' => $parametros['eco'],
        	'fecha_fin' => $parametros['fecha_fin']
        );
        
        $array = array('id_conv_insc' => $parametros['id_conv_insc']);
        $this->db->where($array);
        return $this->db->update('convocatorias_inscritos', $data);
        
    }
    
    //CIUDADANO
    
    
    public function ciudadano_conv_participa($id_usuario) {
        $cadena_sql = "SELECT usco.id_usu_conv, usco.id_usuario, usco.id_convocatoria, usco.estado, inve.nombre_inv, nombre_rol_inv, perfil, objeto, obligaciones, honorarios, cins.id_conv_insc, cins.id_ciudad, mpio.nom_mpio, fecha_inicio, fecha_fin, total_personas, max_inscri ";
        $cadena_sql.= "FROM usuario_convocatoria usco ";
        $cadena_sql.= "JOIN convocatorias conv ON usco.id_convocatoria = conv.id_convocatoria ";
        $cadena_sql.= "JOIN convocatorias_inscritos cins ON cins.id_convocatoria = conv.id_convocatoria AND usco.id_conv_insc = cins.id_conv_insc ";
        $cadena_sql.= "JOIN param_investigacion inve ON inve.id_investigacion = conv.id_investigacion ";
        $cadena_sql.= "JOIN param_rol_inv rol ON rol.id_rol_inv = conv.id_rol ";
		$cadena_sql.= "JOIN param_mpios mpio ON mpio.id_mpio = cins.id_ciudad ";
        $cadena_sql.= "WHERE usco.id_usuario = '" . $id_usuario . "'";
		$cadena_sql.= " AND usco.estado = 'AC'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    
    
    public function ciudadano_conv_abiertas() {
        $cadena_sql = "SELECT conv.id_convocatoria, inve.nombre_inv, nombre_rol_inv, req.id_nivel, req.semestres, req.tiempo, perfil, objeto, obligaciones, honorarios, cins.id_conv_insc, cins.id_ciudad, mpio.nom_mpio, fecha_inicio, fecha_fin, total_personas, max_inscri, total_insc, operativo ";
        $cadena_sql.= "FROM convocatorias conv ";
		$cadena_sql.= "JOIN requisitos req ON req.id_convocatoria = conv.id_convocatoria ";
		$cadena_sql.= "JOIN convocatorias_inscritos cins ON cins.id_convocatoria = conv.id_convocatoria ";
        $cadena_sql.= "JOIN param_investigacion inve ON inve.id_investigacion = conv.id_investigacion ";
        $cadena_sql.= "JOIN param_rol_inv rol ON rol.id_rol_inv = conv.id_rol ";
		$cadena_sql.= "JOIN param_mpios mpio ON mpio.id_mpio = cins.id_ciudad ";
        $cadena_sql.= "WHERE conv.tipo_conv = 'A'";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function ciudadano_conv_cerradas($id_usuario) {
        $cadena_sql = "SELECT conv.id_convocatoria, inve.nombre_inv, nombre_rol_inv, req.id_nivel, req.semestres, req.tiempo, perfil, objeto, obligaciones, honorarios, cins.id_conv_insc, cins.id_ciudad, mpio.nom_mpio, fecha_inicio, fecha_fin, total_personas, max_inscri, operativo ";
        $cadena_sql.= "FROM invitaciones inv ";
        $cadena_sql.= "JOIN convocatorias conv ON inv.id_convocatoria = conv.id_convocatoria ";
		$cadena_sql.= "JOIN requisitos req ON req.id_convocatoria = conv.id_convocatoria ";
		$cadena_sql.= "JOIN convocatorias_inscritos cins ON cins.id_convocatoria = conv.id_convocatoria AND inv.id_ciudad = cins.id_ciudad  ";
        $cadena_sql.= "JOIN param_investigacion inve ON inve.id_investigacion = conv.id_investigacion ";
        $cadena_sql.= "JOIN param_rol_inv rol ON rol.id_rol_inv = conv.id_rol ";
        $cadena_sql.= "JOIN param_mpios mpio ON mpio.id_mpio = cins.id_ciudad ";
        $cadena_sql.= " WHERE conv.tipo_conv = 'C'";
        $cadena_sql.= " AND inv.id_usuario = '".$id_usuario."'";
		        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function verificaCruceConvocatoria($id_usuario) {
        $cadena_sql = "SELECT id_usu_conv, id_usuario, id_convocatoria, estado ";
        $cadena_sql.= "FROM usuario_convocatoria ";
        $cadena_sql.= " WHERE id_usuario = '".$id_usuario."'";
        $cadena_sql.= " AND estado = 'AC'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function verificaDisponibilidad($idConvocatoria, $id_conv_ins) {
        $cadena_sql = "SELECT id_ciudad, total_personas, total_insc, max_inscri, fecha_inicio, fecha_fin ";
        $cadena_sql.= "FROM convocatorias_inscritos ";
        $cadena_sql.= " WHERE id_conv_insc = '".$id_conv_ins."'";
        $cadena_sql.= " AND id_convocatoria = '".$idConvocatoria."'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }  
    
    
    public function totalPersonasInscritas($idConvocatoria) {
        $cadena_sql = "SELECT count(id_convocatoria) total ";
        $cadena_sql.= "FROM usuario_convocatoria ";
        $cadena_sql.= " WHERE id_convocatoria = '".$idConvocatoria."'";
        $cadena_sql.= " AND estado = 'AC'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
		
    public function totalInscritos($idConvocatoria, $id_conv_ins) {
        $cadena_sql = "SELECT count(id_convocatoria) total ";
        $cadena_sql.= "FROM usuario_convocatoria ";
        $cadena_sql.= " WHERE id_convocatoria = '".$idConvocatoria."'";
        $cadena_sql.= " AND id_conv_insc = '".$id_conv_ins."'";
        $cadena_sql.= " AND estado = 'AC'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function borrarCiudadConvocatoria($id_convocatoria, $id_conv_insc){
		$this->db->where('id_convocatoria',$id_convocatoria);
        $this->db->where('id_conv_insc',$id_conv_insc);
        return $this->db->delete('convocatorias_inscritos');
	}
	
	public function personasInscritas($idConvocatoria, $id_conv_insc) {
        $cadena_sql = "SELECT uc.id_usuario, us.nombres, us.apellidos, tipo_iden, nume_iden, telefono, celular, lo.usuario, matriculado, fecha_matriculado, fecha_aplica  "; 
        $cadena_sql.= "FROM usuario_convocatoria uc ";
		$cadena_sql.= "JOIN usuario us ON us.id_usuario = uc.id_usuario ";
		$cadena_sql.= "JOIN login lo ON lo.usuario_id_usuario = us.id_usuario  ";
        $cadena_sql.= " WHERE id_convocatoria = '".$idConvocatoria."'";
		$cadena_sql.= " AND id_conv_insc = '".$id_conv_insc."'";
        $cadena_sql.= " AND uc.estado = 'AC'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function personasDatos($identificacion) {
        $cadena_sql = "SELECT us.id_usuario, us.nombres, us.apellidos, us.tipo_iden, us.nume_iden, id_avatar, id_docIden ";
		$cadena_sql .= " FROM usuario us  ";		
		$cadena_sql .= " WHERE nume_iden = ".$identificacion;
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	
    
    
    public function insertarConvocatoriaUsuario($param) {
        $this->db->trans_start();
        $this->db->insert('usuario_convocatoria', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

	public function personasInscritos() {
        $cadena_sql = "SELECT DISTINCT uc.id_usuario, uc.id_convocatoria, uc.id_conv_insc, us.nombres, us.apellidos, us.tipo_iden, us.nume_iden, nom_mpio, inv.nombre_inv, rol.nombre_rol_inv, req.operativo ";
		$cadena_sql .= " FROM usuario_convocatoria uc  ";
		$cadena_sql .= " JOIN usuario us ON us.id_usuario = uc.id_usuario  ";
		$cadena_sql .= " JOIN convocatorias con ON con.id_convocatoria = uc.id_convocatoria  ";
		$cadena_sql .= " LEFT JOIN requisitos req ON req.id_convocatoria = con.id_convocatoria ";
		$cadena_sql .= " JOIN convocatorias_inscritos cins ON cins.id_convocatoria = uc.id_convocatoria  ";
		$cadena_sql .= " AND cins.id_conv_insc = uc.id_conv_insc  ";
		$cadena_sql .= " JOIN param_mpios mpio ON mpio.id_mpio = cins.id_ciudad  ";
		$cadena_sql .= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion  ";
		$cadena_sql .= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol WHERE uc.estado!='IN' ";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }

	public function borrarCiudadUsuario($id_usuario, $id_convocatoria, $id_conv_insc){
		$this->db->where('id_usuario',$id_usuario);
        $this->db->where('id_convocatoria',$id_convocatoria);
		$this->db->where('id_conv_insc',$id_conv_insc);
        return $this->db->delete('usuario_convocatoria');
	}
	
	
    public function info_invitacion($id_convocatoria, $id_usuario) {
        $cadena_sql = "SELECT id_ciudad, aplico, fecha_aplico  ";
        $cadena_sql.= " FROM invitaciones ";
        $cadena_sql.= " WHERE id_convocatoria = ".$id_convocatoria." ";
		$cadena_sql.= " AND id_usuario = ".$id_usuario." ";
		

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	function actualizarInvitacionAplica($parametros)
    {
        $data = array(
            'fecha_aplico' => $parametros['fecha_aplico'],
            'aplico' => $parametros['aplico']
        );
        
        $array = array('id_convocatoria' => $parametros['id_convocatoria'], 'id_usuario' => $parametros['id_usuario']);
        $this->db->where($array);
        return $this->db->update('invitaciones', $data);
        
    }
	
	//COORDINADOR
	
	public function convocatorias_coor_abiertas($ciudad) {
        $cadena_sql = "SELECT distinct con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, conins.id_conv_insc, mun.nom_mpio, total_personas, total_insc, eco, fecha_inicio, fecha_fin, operativo  ";
        $cadena_sql.= " FROM convocatorias con ";
        $cadena_sql.= " LEFT JOIN requisitos req ON req.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " JOIN convocatorias_inscritos conins ON conins.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = conins.id_ciudad ";
        $cadena_sql.= " WHERE conins.id_ciudad = ".$ciudad." ";
		$cadena_sql.= " AND con.tipo_conv = 'A' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function convocatorias_coor_cerradas($ciudad) {
        $cadena_sql = "SELECT distinct con.id_convocatoria, con.id_investigacion, nombre_inv, con.id_rol, nombre_rol_inv, conins.id_conv_insc, mun.nom_mpio, total_personas, total_insc, eco, fecha_inicio, fecha_fin, operativo  ";
        $cadena_sql.= " FROM convocatorias con ";
        $cadena_sql.= " LEFT JOIN requisitos req ON req.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
        $cadena_sql.= " JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
        $cadena_sql.= " JOIN convocatorias_inscritos conins ON conins.id_convocatoria = con.id_convocatoria ";
        $cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = conins.id_ciudad ";
        $cadena_sql.= " WHERE conins.id_ciudad = ".$ciudad." ";
		$cadena_sql.= " AND con.tipo_conv = 'C' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	function actualizarDocumentos($id_convocatoria, $id_conv_insc, $id_usuario, $documentos, $observaciones)
    {
    	//echo $id_convocatoria."---".$id_conv_insc."+++".$id_usuario."///".$documentos."...".$observaciones;exit; 
        $data = array(
            'doc_estado' => $documentos,
            'observaciones' => $observaciones,
        	'fecha_doc_estado' => date('Y-m-d H:i:s')
        );
        
        $array = array('id_usuario' => $id_usuario, 'id_convocatoria' => $id_convocatoria, 'id_conv_insc' => $id_conv_insc);
        $this->db->where($array);
        return $this->db->update('usuario_convocatoria', $data);
        
    }
	
	public function buscarCiudad($ciudad) {
        $cadena_sql = "SELECT id_mpio, nom_mpio  ";
        $cadena_sql.= " FROM param_mpios ";
        $cadena_sql.= " WHERE nom_mpio = '".$ciudad."'  ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
        
	public function ciudades_coordinador($username) {
        $cadena_sql = "SELECT nombres, apellidos, email, estado, id_ciudad, mun.nom_mpio ";
        $cadena_sql.= "FROM coordinadores coor ";
		$cadena_sql.= " JOIN param_mpios mun ON mun.id_mpio = coor.id_ciudad ";
        $cadena_sql.= "WHERE email = '" . $username . "' ";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    
    public function buscarCiudadConvocatoria($id_convocatoria, $ciudad) {
        $cadena_sql = "SELECT *  ";
        $cadena_sql.= " FROM convocatorias_inscritos ";
        $cadena_sql.= " WHERE id_convocatoria = ".$id_convocatoria." ";
		$cadena_sql.= " AND id_ciudad =  ".$ciudad." ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	function liberarUsuario($id_usuario)
    {
        $data = array(
            'estado' => 'IN'
        );
        $this->db->where('id_usuario', $id_usuario);
        return $this->db->update('usuario_convocatoria', $data);
    }
    
    function liberarUsuarioConv($id_usuario, $id_convocatoria, $id_conv_insc)
    {
        $data = array(
            'estado' => 'IN',
            'fecha_cambio' => date('Y-m-d H:i:s')
        );
        $array = array('id_usuario' => $id_usuario, 'id_convocatoria' => $id_convocatoria, 'id_conv_insc' => $id_conv_insc, 'estado' => 'AC');
        $this->db->where($array);
        return $this->db->update('usuario_convocatoria', $data);
    }
	
    function actualizarMatricula($id_usuario, $estado, $inscribir, $id_convocatoria, $id_conv_insc)
    {
        $data = array(
            'para_matricula' => $estado,
            'ord_matricula' => $inscribir
        );
		$array = array('id_usuario' => $id_usuario, 'id_convocatoria' => $id_convocatoria, 'id_conv_insc' => $id_conv_insc, 'estado' => 'AC');
        $this->db->where($array);
        return $this->db->update('usuario_convocatoria', $data);
    }
    
    public function personasMatricular($id_convocatoria, $id_conv_insc) {
        $cadena_sql = "SELECT id_usuario, para_matricula, ord_matricula  ";
        $cadena_sql.= " FROM usuario_convocatoria ";
        $cadena_sql.= " WHERE id_convocatoria = ".$id_convocatoria." ";
		$cadena_sql.= " AND id_conv_insc =  ".$id_conv_insc." ";
		$cadena_sql.= " AND para_matricula = 'SI' ";
		$cadena_sql.= " ORDER BY  ord_matricula ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function reporteTotalizadoAbierta($operativo, $encuesta, $rol, $ciudad, $convocatoria) {
    	$cadena_sql = "SELECT DISTINCT operativo, nombre_inv, nombre_rol_inv, nom_mpio, total_personas, "; 
    	$cadena_sql.= "(SELECT COUNT( * ) FROM usuario_convocatoria	WHERE ci.id_conv_insc = id_conv_insc AND estado =  'AC') AS total_inscritos, ";
    	$cadena_sql.= "(SELECT COUNT( * ) FROM usuario_convocatoria    WHERE ci.id_conv_insc = id_conv_insc AND estado =  'AC' AND doc_estado='1') AS total_verdes, ";
    	$cadena_sql.= "(SELECT COUNT( * ) FROM usuario_convocatoria    WHERE ci.id_conv_insc = id_conv_insc AND estado =  'AC' AND doc_estado='2') AS total_naranjas, ";
    	$cadena_sql.= "(SELECT COUNT( * ) FROM usuario_convocatoria    WHERE ci.id_conv_insc = id_conv_insc AND estado =  'AC' AND doc_estado='3') AS total_rojos, ";
    	$cadena_sql.= "(SELECT COUNT( * ) FROM usuario_convocatoria    WHERE ci.id_conv_insc = id_conv_insc AND estado =  'AC' AND doc_estado='0') AS total_sin_validar, ";  
    	$cadena_sql.= "max_inscri, fecha_inicio, fecha_fin ";
		$cadena_sql.= "FROM convocatorias con ";
		$cadena_sql.= "LEFT JOIN requisitos req ON req.id_convocatoria = con.id_convocatoria ";
		$cadena_sql.= "JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
		$cadena_sql.= "JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
		$cadena_sql.= "JOIN convocatorias_inscritos ci ON con.id_convocatoria = ci.id_convocatoria ";
		$cadena_sql.= "JOIN param_mpios mun ON ci.id_ciudad = mun.id_mpio ";
		$cadena_sql.= "WHERE ";
		
		if($convocatoria == "A"){
			$cadena_sql.= "tipo_conv =  'A' ";
		}
		
		if($convocatoria == "C"){
			$cadena_sql.= "tipo_conv =  'C' ";
		}
		
		if ($operativo!=""){
			$cadena_sql.= "AND operativo =  '".$operativo."' ";
		}
		if ($encuesta!=""){
			$cadena_sql.= "AND con.id_investigacion IN ( ".$encuesta." ) ";
		}
		if ($rol!=""){
			$cadena_sql.= "AND con.id_rol IN ( ".$rol." ) ";
		}
		if ($ciudad!=""){
			$cadena_sql.= "AND mun.id_mpio IN ( ".$ciudad." ) ";
		}
		    	
    
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
	
    public function ciudades() {
    	$cadena_sql = "SELECT id_mpio, nom_mpio ";
    	$cadena_sql.= "FROM param_mpios ";
    	$cadena_sql.= "ORDER BY nom_mpio ";
    
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
    
    function liberarNoMatriculados($id_convocatoria, $id_conv_insc)
    {
    	$data = array(
    			'estado' => 'IN',
    			'fecha_cambio' => date('Y-m-d H:i:s')
    	);
    	$array = array('id_convocatoria' => $id_convocatoria, 'id_conv_insc' => $id_conv_insc, 'para_matricula' => 'NO', 'estado' => 'AC');
    	
    	$this->db->where($array);
    	return $this->db->update('usuario_convocatoria', $data);
    }
    
    public function noMatriculados($id_convocatoria, $id_conv_insc) {
    	$cadena_sql = "SELECT id_usuario, para_matricula, ord_matricula  ";
    	$cadena_sql.= " FROM usuario_convocatoria ";
    	$cadena_sql.= " WHERE id_convocatoria = ".$id_convocatoria." ";
    	$cadena_sql.= " AND id_conv_insc =  ".$id_conv_insc." ";
    	$cadena_sql.= " AND para_matricula = 'NO' AND estado='AC' ";
    	$cadena_sql.= " ORDER BY  id_usuario ";
    
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
	
	public function personasBuscar($usuarios) {  
        $cadena_sql = "SELECT id_usuario ";
        $cadena_sql.= " FROM usuario ";
        $cadena_sql.= " WHERE nume_iden IN(".$usuarios.")  ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    function guardar_matricula($usuario, $id_convocatoria, $id_conv_insc)
    {
    	$data = array(
    			'matriculado' => 'SI',
    			'fecha_matriculado' => date('Y-m-d H:i:s')
    	);
    	$array = array('id_convocatoria' => $id_convocatoria, 'id_conv_insc' => $id_conv_insc, 'id_usuario' => $usuario, 'estado' => 'AC');
    	 
    	$this->db->where($array);
    	return $this->db->update('usuario_convocatoria', $data);
    }
    
    public function usuarioMatriculado($usuario, $id_convocatoria, $id_conv_insc) {
    	$cadena_sql = "SELECT id_usuario ";
    	$cadena_sql.= " FROM usuario_convocatoria ";
    	$cadena_sql.= " WHERE id_usuario = $usuario AND id_convocatoria = $id_convocatoria AND id_conv_insc = $id_conv_insc AND matriculado='NO' "; 
    
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
    
    public function reporteHistorico($operativo, $encuesta, $rol, $experiencia, $ciudades, $cedula, $nombreC) { 
    	
    	$experiencia_meses = $experiencia*30;
    	$cadena_sql = "SELECT DISTINCT id_usu_conv, usu.id_usuario, usu.nombres, usu.apellidos,  usu.nume_iden, inv.nombre_inv, mun.nom_mpio ,req.operativo, rol.nombre_rol_inv, "; 
    	$cadena_sql.= "CASE WHEN usuconv.doc_estado = 1 THEN 'verde' WHEN usuconv.doc_estado = 2 THEN 'Naranja' WHEN usuconv.doc_estado = 3 THEN 'Rojo' ELSE 'Sin Estado' END AS doc_estado, ";
    	$cadena_sql.= "CASE WHEN usuconv.estado = 'AC' THEN 'Activo' WHEN usuconv.estado = 'IN' THEN 'Inactivo' END AS estado, ";
    	$cadena_sql.= "usuconv.observaciones, usuconv.fecha_doc_estado, usuconv.fecha_aplica AS fecha_aplicaA, invit.fecha_aplico AS fecha_aplicaC, ";
    	$cadena_sql.= "CASE WHEN con.tipo_conv = 'A' THEN 'Abierta' WHEN con.tipo_conv = 'C' THEN 'Cerrada' END AS tipo_convocatoria  ";
    	//$cadena_sql.= "(SELECT DATEDIFF(fecha_retiro, fecha_ingreso) FROM us_experiencia WHERE usu.id_usuario = id_usuario GROUP BY id_usuario) ";
    	$cadena_sql.= "FROM usuario_convocatoria usuconv ";
    	$cadena_sql.= "JOIN convocatorias con ON usuconv.id_convocatoria = con.id_convocatoria ";
    	$cadena_sql.= "JOIN usuario usu ON usuconv.id_usuario = usu.id_usuario ";
    	$cadena_sql.= "LEFT JOIN requisitos req ON req.id_convocatoria = usuconv.id_convocatoria ";
    	$cadena_sql.= "LEFT JOIN invitaciones invit ON usu.id_usuario = invit.id_usuario ";
    	$cadena_sql.= "JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
    	$cadena_sql.= "JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
    	$cadena_sql.= "JOIN convocatorias_inscritos ci ON usuconv.id_conv_insc = ci.id_conv_insc ";  
    	$cadena_sql.= "JOIN param_mpios mun ON ci.id_ciudad = mun.id_mpio ";
    	$cadena_sql.= "WHERE 1=1 "; 
     
    	if ($operativo!=""){
    		$cadena_sql.= "AND operativo =  '".$operativo."' ";
    	}
    	if ($encuesta!=""){
    		$cadena_sql.= "AND con.id_investigacion IN ( ".$encuesta." ) ";
    	}
    	if ($rol!=""){
    		$cadena_sql.= "AND con.id_rol IN ( ".$rol." ) ";
    	}
    	if ($ciudades!=""){
    		$cadena_sql.= "AND ci.id_ciudad IN ( ".$ciudades." ) ";
    	}
    	if ($experiencia!=""){
    		$cadena_sql.= "AND (SELECT DATEDIFF(fecha_retiro, fecha_ingreso) FROM us_experiencia WHERE usu.id_usuario = id_usuario GROUP BY id_usuario) >= $experiencia_meses ";
    	}
    	if ($cedula!=""){
    		$cadena_sql.= "AND usu.nume_iden = $cedula ";
    	}
    	if ($nombreC!=""){
    		$cadena_sql.= "AND concat_ws( ' ', usu.nombres, usu.apellidos) = '$nombreC' "; 
    	} 
    	
        //echo "<pre>".$cadena_sql."</pre>";exit;
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
    
    public function reporteConvCerradas($operativo, $encuesta, $rol, $ciudades, $cedula, $nombreC) {
    	 
    	$cadena_sql= "select DISTINCT nombres, apellidos, tipo_iden, nume_iden, pinv.nombre_inv, ";
    	$cadena_sql.="prol.nombre_rol_inv, mpio.nom_mpio, inv.aplico, inv.fecha_aplico, operativo ";
		$cadena_sql.="from invitaciones inv ";
		$cadena_sql.="JOIN usuario usr ON inv.id_usuario = usr.id_usuario ";
		$cadena_sql.="JOIN param_mpios mpio ON mpio.id_mpio = inv.id_ciudad ";
		$cadena_sql.="JOIN convocatorias convo ON convo.id_convocatoria = inv.id_convocatoria ";
		$cadena_sql.="LEFT JOIN param_investigacion pinv ON  pinv.id_investigacion = convo.id_investigacion "; 
		$cadena_sql.="LEFT JOIN param_rol_inv prol ON prol.id_rol_inv = convo.id_rol ";
		$cadena_sql.="LEFT JOIN requisitos req ON req.id_convocatoria = inv.id_convocatoria ";
    	$cadena_sql.="WHERE 1=1 ";
    	 
    	if ($operativo!=""){ 
    		$cadena_sql.= "AND operativo =  '".$operativo."' ";
    	}
    	if ($encuesta!=""){
    		$cadena_sql.= "AND convo.id_investigacion IN ( ".$encuesta." ) ";
    	}
    	if ($rol!=""){
    		$cadena_sql.= "AND convo.id_rol IN ( ".$rol." ) ";
    	}
    	if ($ciudades!=""){
    		$cadena_sql.= "AND inv.id_ciudad IN ( ".$ciudades." ) ";
    	}  
    	if ($cedula!=""){
    		$cadena_sql.= "AND usr.nume_iden = $cedula ";
    	}
    	if ($nombreC!=""){
    		$cadena_sql.= "AND concat_ws( ' ', usr.nombres, usr.apellidos) = '$nombreC' ";
    	}
    	 
    	//echo "<pre>".$cadena_sql."</pre>";exit; 
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
    
    
    public function reporteHistoricoAdmin($operativo, $encuesta, $rol, $experiencia, $cedula, $nombreC, $ciudad) {
    	
    	$experiencia_meses = $experiencia*30; 
    	$cadena_sql = "SELECT DISTINCT id_usu_conv, usu.id_usuario, usu.nombres, usu.apellidos,  usu.nume_iden, inv.nombre_inv, mun.nom_mpio ,req.operativo, rol.nombre_rol_inv, ";
    	$cadena_sql.= "CASE WHEN usuconv.doc_estado = 1 THEN 'verde' WHEN usuconv.doc_estado = 2 THEN 'Naranja' WHEN usuconv.doc_estado = 3 THEN 'Rojo' ELSE 'Sin Estado' END AS doc_estado, ";
    	$cadena_sql.= "CASE WHEN usuconv.estado = 'AC' THEN 'Activo' WHEN usuconv.estado = 'IN' THEN 'Inactivo' END AS estado, ";
    	$cadena_sql.= "usuconv.observaciones, usuconv.fecha_doc_estado, usuconv.fecha_aplica AS fecha_aplicaA, invit.fecha_aplico AS fecha_aplicaC, ";
    	$cadena_sql.= "CASE WHEN con.tipo_conv = 'A' THEN 'Abierta' WHEN con.tipo_conv = 'C' THEN 'Cerrada' END AS tipo_convocatoria  ";
    	$cadena_sql.= "FROM usuario_convocatoria usuconv ";
    	$cadena_sql.= "JOIN convocatorias con ON usuconv.id_convocatoria = con.id_convocatoria ";
    	$cadena_sql.= "JOIN usuario usu ON usuconv.id_usuario = usu.id_usuario ";
    	$cadena_sql.= "LEFT JOIN requisitos req ON req.id_convocatoria = usuconv.id_convocatoria ";
    	$cadena_sql.= "LEFT JOIN invitaciones invit ON usu.id_usuario = invit.id_usuario ";
    	$cadena_sql.= "JOIN param_investigacion inv ON inv.id_investigacion = con.id_investigacion ";
    	$cadena_sql.= "JOIN param_rol_inv rol ON rol.id_rol_inv = con.id_rol ";
    	$cadena_sql.= "JOIN convocatorias_inscritos ci ON usuconv.id_conv_insc = ci.id_conv_insc ";
    	$cadena_sql.= "JOIN param_mpios mun ON ci.id_ciudad = mun.id_mpio ";
    	$cadena_sql.= "WHERE 1=1 ";
    	 
    	if ($operativo!=""){
    		$cadena_sql.= "AND operativo =  '".$operativo."' ";
    	}
    	if ($encuesta!=""){
    		$cadena_sql.= "AND con.id_investigacion IN ( ".$encuesta." ) ";
    	}
    	if ($rol!=""){
    		$cadena_sql.= "AND con.id_rol IN ( ".$rol." ) ";
    	}
    	if ($ciudad!=""){
    		$cadena_sql.= "AND ci.id_ciudad IN ( ".$ciudad." ) ";
    	}
    	if ($experiencia!=""){
    		$cadena_sql.= "AND (SELECT DATEDIFF(fecha_retiro, fecha_ingreso) FROM us_experiencia WHERE usu.id_usuario = id_usuario GROUP BY id_usuario) >= $experiencia_meses ";
    	}
    	if ($cedula!=""){
    		$cadena_sql.= "AND usu.nume_iden = $cedula ";
    	}
    	if ($nombreC!=""){
    		$cadena_sql.= "AND concat_ws( ' ', usu.nombres, usu.apellidos) = '$nombreC' ";
    	}
    	 
    	//echo "<pre>".$cadena_sql."</pre>";exit;
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
    
    public function reporteConvCerradasAdmin($operativo, $encuesta, $rol, $cedula, $nombreC, $ciudad) {
    
    	$cadena_sql= "select DISTINCT nombres, apellidos, tipo_iden, nume_iden, pinv.nombre_inv, ";
    	$cadena_sql.="prol.nombre_rol_inv, mpio.nom_mpio, inv.aplico, inv.fecha_aplico, operativo ";
    	$cadena_sql.="from invitaciones inv ";
    	$cadena_sql.="JOIN usuario usr ON inv.id_usuario = usr.id_usuario ";
    	$cadena_sql.="JOIN param_mpios mpio ON mpio.id_mpio = inv.id_ciudad ";
    	$cadena_sql.="JOIN convocatorias convo ON convo.id_convocatoria = inv.id_convocatoria ";
    	$cadena_sql.="LEFT JOIN param_investigacion pinv ON  pinv.id_investigacion = convo.id_investigacion ";
    	$cadena_sql.="LEFT JOIN param_rol_inv prol ON prol.id_rol_inv = convo.id_rol ";
    	$cadena_sql.="LEFT JOIN requisitos req ON req.id_convocatoria = inv.id_convocatoria ";
    	$cadena_sql.="WHERE 1=1 ";
    
    	if ($operativo!=""){
    		$cadena_sql.= "AND operativo =  '".$operativo."' ";
    	}
    	if ($encuesta!=""){
    		$cadena_sql.= "AND convo.id_investigacion IN ( ".$encuesta." ) ";
    	}
    	if ($rol!=""){
    		$cadena_sql.= "AND convo.id_rol IN ( ".$rol." ) ";
    	}
    	if ($ciudad!=""){
    		$cadena_sql.= "AND inv.id_ciudad IN ( ".$ciudad." ) ";
    	}
    	if ($cedula!=""){
    		$cadena_sql.= "AND usr.nume_iden = $cedula ";
    	}
    	if ($nombreC!=""){
    		$cadena_sql.= "AND concat_ws( ' ', usr.nombres, usr.apellidos) = '$nombreC' ";
    	}
    
    	//echo "<pre>".$cadena_sql."</pre>";exit;
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
    
    public function mover_invitacion($id_usuario, $id_usuario_ok) {
    	$data = array(
    			'id_usuario' => $id_usuario_ok
    	);
    	$this->db->where('id_usuario', $id_usuario);
    	return $this->db->update('invitaciones', $data);
    }
    
    function cambiarMaximoMatricular($id_convocatoria, $id_conv_insc, $maximo_matricular)
    {
    	$data = array(
    			'max_inscri' => $maximo_matricular
    	);
    	$array = array('id_convocatoria' => $id_convocatoria, 'id_conv_insc' => $id_conv_insc);
    	$this->db->where($array);
    	return $this->db->update('convocatorias_inscritos', $data);
    	
    }
    
    function archivarConvocatoria($id_convocatoria)
    {
    	$data = array(
    			'archivado' => '1',
    			'fecha_archivado' => date('Y-m-d H:i:s'),
    	);
    
    	$array = array('id_convocatoria' => $id_convocatoria);
    	$this->db->where($array);
    	return $this->db->update('convocatorias', $data);
    
    }
    
    function liberarUsuarios_convArchivada($id_convocatoria)
    {
    	$data = array(
    			'estado' => 'IN'
    	);
    
    	$array = array('id_convocatoria' => $id_convocatoria);
    	$this->db->where($array);
    	return $this->db->update('usuario_convocatoria', $data);
    
    }
    
    public function consultaActividad($id_usuario) {
    	 
    	$cadena_sql = "SELECT id_usuario,id_convocatoria,id_conv_insc,doc_estado,observaciones,estado ";
    	$cadena_sql.= "FROM usuario_convocatoria ";
    	$cadena_sql.= "WHERE id_usuario = '".$id_usuario."' AND estado='AC' ";
    	$query = $this->db->query($cadena_sql);
    
    	$result = $query->result();
    
    	return $result;
    }
    
    function activarUsuarioConvocatoria($id_usu_conv)
    {
    	$data = array(
    			'estado' => 'AC',
    			'doc_estado' => '0',
    			'observaciones' => ''
    	);
    
    	$array = array('id_usu_conv' => $id_usu_conv);
    	$this->db->where($array);
    	return $this->db->update('usuario_convocatoria', $data);
    
    } 
    
    function reiniciarSemaforo($id_usu_conv)
    {
    	$data = array(
    			'estado' => 'AC',
    			'doc_estado' => '0',
    			'para_matricula' => 'NO',
    			'ord_matricula' => '',
    			'observaciones' => ''
    	);
    
    	$array = array('id_usu_conv' => $id_usu_conv);
    	$this->db->where($array);
    	return $this->db->update('usuario_convocatoria', $data);
    
    }
    
}
