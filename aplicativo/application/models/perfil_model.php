<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class Perfil_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function datos_usuario($id_usuario) {
        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, tipo_iden, nume_iden, fecha_naci, us.sexo as genero, desc_gene, nacionalidad, desc_pais,  ";
        $cadena_sql.= "telefono, celular, email2, sigep, usuario, id_avatar, arc1.ruta as rutaA, arc1.nombre as nombA,  ";
        $cadena_sql.= " id_docIden, arc2.ruta as rutaDI, arc2.nombre as nombDI, ";
        $cadena_sql.= " id_docLib, arc3.ruta as rutaLM, arc3.nombre as nombLM ";
        $cadena_sql.= " FROM login lo ";
        $cadena_sql.= "JOIN usuario us ON usuario_id_usuario = us.id_usuario ";
        $cadena_sql.= "LEFT JOIN param_paises pp ON pp.codi_pais = us.nacionalidad ";
        $cadena_sql.= "LEFT JOIN param_genero pg ON pg.codi_gene = us.sexo ";
		$cadena_sql.= "LEFT JOIN archivos arc1 ON arc1.id_archivo = id_avatar ";
		$cadena_sql.= "LEFT JOIN archivos arc2 ON arc2.id_archivo = id_docIden ";
		$cadena_sql.= "LEFT JOIN archivos arc3 ON arc3.id_archivo = id_docLib ";
        $cadena_sql.= "WHERE us.id_usuario = '" . $id_usuario . "' ";

        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function modalidades() {
        $cadena_sql = "SELECT id_modalidad, desc_modalidad ";
        $cadena_sql.= "FROM param_modalidad ";
        $cadena_sql.= "WHERE estado = 'AC'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
    public function niveles() {
        $cadena_sql = "SELECT id_nivel, descripcion ";
        $cadena_sql.= "FROM param_nivel_formacion ";
        $cadena_sql.= "WHERE estado = '1'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function areas() {
		$cadena_sql = "SELECT id_areacono, desc_areacono ";
		$cadena_sql.= "FROM param_areacono ";
		$cadena_sql.= "WHERE estado = 'AC'";
		
		$query = $this->db->query($cadena_sql);
		
		$result = $query->result();
		
		return $result;
	}
		
	public function programaAcademico($area, $nivel) {
        $cadena_sql = "SELECT id_programa, desc_programa ";
        $cadena_sql.= "FROM param_programa ";
        $cadena_sql.= "WHERE estado = 'AC'";
        $cadena_sql.= " AND id_areacono = '".$area."'";
		$cadena_sql.= " AND id_nivel = '".$nivel."'";
        $cadena_sql.= " ORDER BY 2 ";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function formacionUsuario($usuario) {
        $cadena_sql = "SELECT id_formacion, id_modalidad, semestres, form.id_nivel, niv.descripcion, form.id_areacono, are.desc_areacono, form.id_programa, prg.desc_programa, ";
        $cadena_sql.= "graduado, fechaTermina, fechaTarje, id_docFormacion, arc1.ruta as rutaF, arc1.nombre as nombF, id_docTarjeta, arc2.ruta as rutaT, arc2.nombre as nombT ";
        $cadena_sql.= "FROM us_form_acade form ";
        $cadena_sql.= "JOIN param_nivel_formacion niv ON niv.id_nivel = form.id_nivel ";
        $cadena_sql.= "LEFT JOIN param_areacono are ON are.id_areacono = form.id_areacono ";
        $cadena_sql.= "LEFT JOIN param_programa prg ON prg.id_programa = form.id_programa ";
        $cadena_sql.= "LEFT JOIN archivos arc1 ON arc1.id_archivo = form.id_docFormacion ";
        $cadena_sql.= "LEFT JOIN archivos arc2 ON arc2.id_archivo = form.id_docTarjeta ";
        $cadena_sql.= "WHERE form.estado = 'AC'";
        $cadena_sql.= " AND id_usuario = ".$usuario;
        $cadena_sql.= " ORDER BY form.id_nivel desc ";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function formacionMod($id_formacion) {
        $cadena_sql = "SELECT id_formacion, id_modalidad, semestres, form.id_nivel, niv.descripcion, form.id_areacono, are.desc_areacono, form.id_programa, prg.desc_programa, ";
        $cadena_sql.= "graduado, fechaTermina, fechaTarje, id_docFormacion, arc1.ruta as rutaF, arc1.nombre as nombF, id_docTarjeta, arc2.ruta as rutaT, arc2.nombre as nombT ";
        $cadena_sql.= "FROM us_form_acade form ";
        $cadena_sql.= "JOIN param_nivel_formacion niv ON niv.id_nivel = form.id_nivel ";
        $cadena_sql.= "LEFT JOIN param_areacono are ON are.id_areacono = form.id_areacono ";
        $cadena_sql.= "LEFT JOIN param_programa prg ON prg.id_programa = form.id_programa ";
        $cadena_sql.= "LEFT JOIN archivos arc1 ON arc1.id_archivo = form.id_docFormacion ";
        $cadena_sql.= "LEFT JOIN archivos arc2 ON arc2.id_archivo = form.id_docTarjeta ";
        $cadena_sql.= "WHERE form.estado = 'AC'";
        $cadena_sql.= " AND id_formacion = ".$id_formacion;
        $cadena_sql.= " ORDER BY form.id_nivel desc ";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function paises() {
		$cadena_sql = "SELECT codi_pais, desc_pais ";
		$cadena_sql.= "FROM param_paises ";
		$cadena_sql.= "ORDER BY 2 ";
		
		$query = $this->db->query($cadena_sql);
		
		$result = $query->result();
		
		return $result;
	}
	
	
	public function departamentos($pais) {
		$cadena_sql = "SELECT id_depto, nom_depto ";
		$cadena_sql.= "FROM param_deptos ";
		$cadena_sql.= "WHERE id_pais = '".$pais."' ";
		$cadena_sql.= "ORDER BY 2 ";
		
		$query = $this->db->query($cadena_sql);
		
		$result = $query->result();
		
		return $result;
	}
	
	
	public function municipios($dpto) {
		$cadena_sql = "SELECT id_mpio, nom_mpio ";
		$cadena_sql.= "FROM param_mpios ";
		$cadena_sql.= "WHERE fk_depto = '".$dpto."' ";
		$cadena_sql.= "ORDER BY 2 ";
		
		$query = $this->db->query($cadena_sql);
		
		$result = $query->result();
		
		return $result;
	}
	
	
	public function insertarArchivo($param) {
        $this->db->trans_start();
        $this->db->insert('archivos', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
	
	public function registraFormacion($param) {
        $this->db->trans_start();
        $this->db->insert('us_form_acade', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

	public function registraExperiencia($param) {
        $this->db->trans_start();
        $this->db->insert('us_experiencia', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
	
	public function experienciaUsuario($usuario) {
        $cadena_sql = "SELECT id_experiencia, empresa, cargo, dependencia, direccion, telefono, fecha_ingreso, fecha_retiro,  ";
        $cadena_sql.= "id_doc_soporte, arc1.ruta as rutaE, arc1.nombre as nombE ";
        $cadena_sql.= "FROM us_experiencia form ";
        $cadena_sql.= "LEFT JOIN archivos arc1 ON arc1.id_archivo = form.id_doc_soporte ";
        $cadena_sql.= "WHERE form.estado = 'AC'";
        $cadena_sql.= " AND id_usuario = ".$usuario;
        $cadena_sql.= " ORDER BY form.fecha_ingreso desc ";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function experienciaMod($id_experiencia) {
        $cadena_sql = "SELECT id_experiencia, empresa, cargo, tipo_empresa, dependencia, codi_pais, id_depto, id_mpio,   ";
        $cadena_sql.= " direccion, telefono, correo, fecha_ingreso, fecha_retiro, ";
        $cadena_sql.= "id_doc_soporte, arc1.ruta as rutaE, arc1.nombre as nombE ";
        $cadena_sql.= "FROM us_experiencia form ";
        $cadena_sql.= "LEFT JOIN archivos arc1 ON arc1.id_archivo = form.id_doc_soporte ";
        $cadena_sql.= "WHERE form.estado = 'AC'";
        $cadena_sql.= " AND id_experiencia = ".$id_experiencia;
        $cadena_sql.= " ORDER BY form.fecha_ingreso desc ";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
	
	public function borrarExperiencia($id_experiencia)
	{
		$data = array(
            'estado' => 'IN'
        );
        $this->db->where('id_experiencia', $id_experiencia);
        return $this->db->update('us_experiencia', $data);
	}

	public function borrarFormacion($id_formacion)
	{
		$data = array(
            'estado' => 'IN'
        );
        $this->db->where('id_formacion', $id_formacion);
        return $this->db->update('us_form_acade', $data);
	}

    public function menu_padre_user($rol) {
        $query = $this->db->query("SELECT * FROM menu WHERE rol = '" . $rol. "' AND es_padre = '1' AND estado = '1' ORDER BY prioridad");
        $result = $query->result();
        return $result;
    }
    
    public function menu_hijos_user($rol) {
        $query = $this->db->query("SELECT * FROM menu WHERE id_padre = '" . $rol. "' AND estado = '1'  ORDER BY prioridad");
        $result = $query->result();
        return $result;
    }
    
    function actualizar_pass($usuario, $clave)
    {
        $data = array(
            'clave' => $clave
        );
        $this->db->where('usuario', $usuario);
        return $this->db->update('login', $data);
        
    }

    function actualizarAvatar($usuario, $idAvatar)
    {
        $data = array(
            'id_avatar' => $idAvatar
        );
        $this->db->where('id_usuario', $usuario);
        return $this->db->update('usuario', $data);
        
    }
	
	function actualizarDatos($datosInfo)
    {		
        $data = array(
            'nombres' => $datosInfo['nombres'],
            'apellidos' => $datosInfo['apellidos'],
            'email2' => $datosInfo['email2'],
            'telefono' => $datosInfo['telefono'],
            'celular' => $datosInfo['celular'],
            'fecha_naci' => $datosInfo['fecha_naci'],
            'sexo' => $datosInfo['sexo'],
            'nacionalidad' => $datosInfo['nacionalidad'],
            'sigep' => $datosInfo['sigep'],
            'id_docIden' => $datosInfo['id_docIden'],
            'id_docLib' => $datosInfo['id_docLib']
        );
        $this->db->where('id_usuario', $datosInfo['id_usuario']);
        return $this->db->update('usuario', $data);
        
    }

	function actualizaFormacion($datosInfo)
    {		
        $data = array(
            'id_modalidad' => $datosInfo['id_modalidad'],
            'semestres' => $datosInfo['semestres'],
            'id_nivel' => $datosInfo['id_nivel'],
            'id_areacono' => $datosInfo['id_areacono'],
            'id_programa' => $datosInfo['id_programa'],
            'graduado' => $datosInfo['graduado'],
            'fechaTermina' => $datosInfo['fechaTermina'],
            'fechaTarje' => $datosInfo['fechaTarje'],
            'id_docFormacion' => $datosInfo['id_docFormacion'],
            'id_docTarjeta' => $datosInfo['id_docTarjeta']
        );
        $this->db->where('id_formacion', $datosInfo['id_formacion']);
        return $this->db->update('us_form_acade', $data);
        
    }

	function actualizarExperiencia($datosInfo)
    {		
        $data = array(
            'empresa' => $datosInfo['empresa'],
            'tipo_empresa' => $datosInfo['tipo_empresa'],
            'dependencia' => $datosInfo['dependencia'],
            'cargo' => $datosInfo['cargo'],
            'codi_pais' => $datosInfo['codi_pais'],
            'id_depto' => $datosInfo['id_depto'],
            'id_mpio' => $datosInfo['id_mpio'],
            'direccion' => $datosInfo['direccion'],
            'telefono' => $datosInfo['telefono'],
            'correo' => $datosInfo['correo'],
            'fecha_ingreso' => $datosInfo['fecha_ingreso'],
            'fecha_retiro' => $datosInfo['fecha_retiro'],
            'id_doc_soporte' => $datosInfo['id_doc_soporte']
        );
        $this->db->where('id_experiencia', $datosInfo['id_experiencia']);
        return $this->db->update('us_experiencia', $data);
        
    }
    
    function actualizarUsuario($id_usuario, $nombres, $apellidos, $identificacion)
    {
    	$data = array(
    			'nombres' => utf8_encode($nombres),
    			'apellidos' => utf8_encode($apellidos),
    			'nume_iden' => $identificacion,
    	);
    	$this->db->where('id_usuario', $id_usuario);
    	return $this->db->update('usuario', $data);
    }
    
    function actualizarCorreo($id_usuario, $correo)
    {
    	$data = array(
    			'usuario' => utf8_encode($correo)
    	);
    	$this->db->where('usuario_id_usuario', $id_usuario);
    	return $this->db->update('login', $data);    
    }
    
    function eliminar_usuario($id_usuario)
    {
    	$query = $this->db->query("SELECT * FROM usuario_convocatoria WHERE id_usuario= $id_usuario AND estado='AC' ");
    	$result = $query->result();
    	
    	if(count($result)==0){
    		
    		$this->db->where('id_usuario',$id_usuario);
    		$this->db->delete('usuario_convocatoria');
    		
    		
    		$this->db->where('id_usuario',$id_usuario);
    		$this->db->delete('usuario_rol');
    		
    		$this->db->where('id_usuario',$id_usuario);
    		$this->db->delete('us_form_acade');
    		
    		$this->db->where('id_usuario',$id_usuario);
    		$this->db->delete('invitaciones');
    		
    		$this->db->where('id_usuario',$id_usuario);
    		$this->db->delete('invitaciones');
    		
    		$this->db->where('usuario_id_usuario',$id_usuario);
    		$this->db->delete('login');
    		
    		$this->db->where('id_usuario',$id_usuario);
    		$this->db->delete('usuario');
    		
    		return true;
    	}else{
    		return false;
    	}
    }

}
