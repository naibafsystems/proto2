<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class expertos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function grupos() {
        $query = $this->db->query("SELECT id_grupo, nombre_grupo, objetivo, email, estado "
                                . "FROM grupo_trabajo "
                                . "JOIN usuario ON usuario.id_usuario = grupo_trabajo.id_coordinador "
                                . "WHERE estado = 'AC'");
        $result = $query->result();
        return $result;
    }

    function expertosRegistrados($id_usuario) {
        $this->load->database();

        $cadena_sql = "SELECT id_experto, nombre, apellidos, ex.codi_pais, desc_pais, institucion, link, correo, experiencia ";
        $cadena_sql.= "FROM experto ex ";
        $cadena_sql.= "JOIN param_paises pp ON pp.codi_pais = ex.codi_pais ";
        $cadena_sql.= "WHERE id_usuario = ".$id_usuario;
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
	
    function expertosRegistradosTodos() {
        $this->load->database();

        $cadena_sql = "SELECT ex.id_usuario, us.email as emailUsuario, us.codi_pais as paisUsuario, id_experto, ex.nombre, ex.apellidos, ex.codi_pais, desc_pais, institucion, link, correo, experiencia ";
        $cadena_sql.= "FROM experto ex ";
        $cadena_sql.= "JOIN param_paises pp ON pp.codi_pais = ex.codi_pais ";
        $cadena_sql.= "JOIN usuario us ON us.id_usuario = ex.id_usuario ";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
	
	function temasExperto($id_experto) {
        $this->load->database();

        $cadena_sql = "SELECT id_experto, ex.id_categoria, ex.id_fase, pf.descripcion ";
        $cadena_sql.= "FROM experto_categoria ex ";
        $cadena_sql.= "JOIN param_fases_exp pf ON pf.id_fase = ex.id_fase ";
        $cadena_sql.= "JOIN param_tipo_clasificacion pt ON pt.id_tipo_clasificacion = ex.id_categoria ";
        $cadena_sql.= "WHERE id_experto = ".$id_experto;
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
	function formacionExperto($id_experto) {
        $this->load->database();

        $cadena_sql = "SELECT id_experto, id_nivel_formacion, pnf.descripcion, campo_estudio, universidad ";
        $cadena_sql.= "FROM experto_formacion ex ";
        $cadena_sql.= "JOIN param_nivel_formacion pnf ON pnf.id_nivel = ex.id_nivel_formacion ";
        $cadena_sql.= "WHERE id_experto = ".$id_experto;
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
    
    function fases() {
        $this->load->database();

        $cadena_sql = "SELECT id_fase, descripcion ";
        $cadena_sql.= "FROM param_fases_exp ";
        $cadena_sql.= "WHERE estado = '1' ";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    function categoria() {
        $this->load->database();

        $cadena_sql = "SELECT id_tipo_clasificacion, descripcion_es ";
        $cadena_sql.= "FROM param_tipo_clasificacion ";
        $cadena_sql.= "WHERE estado = 'AC' ";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    function nivel_formacion() {
        $this->load->database();

        $cadena_sql = "SELECT id_nivel, descripcion ";
        $cadena_sql.= "FROM param_nivel_formacion ";
        $cadena_sql.= "WHERE estado = '1' ";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    function temas() {
        $this->load->database();

        $cadena_sql = "SELECT id_tema, descripcion ";
        $cadena_sql.= "FROM param_temas_exp ";
        $cadena_sql.= "WHERE estado = '1' ";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
	    
    public function insertarExperto($param) {
        $this->db->trans_start();
        $this->db->insert('experto', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
	    
    public function insertarFormacion($param) {
        $this->db->trans_start();
        $this->db->insert('experto_formacion', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
        
    public function insertarTema($param) {
        $this->db->trans_start();
        $this->db->insert('experto_categoria', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
     
	
    function eliminar_experto($id)
    {
        $this->db->where('id_experto',$id);
        $this->db->delete('experto');
    }
	 
    function eliminar_evento($id)
    {
        $this->db->where('id_evento',$id);
        $this->db->delete('eventos');
    }
    
    function eliminar_evento_necesidad($id)
    {
        $this->db->where('id_evento',$id);
        $this->db->delete('eventos_necesidad');
    }
    
    
    function aprobar_evento($id)
    {
        $data = array(
            'estado' => 2
        );
        $this->db->where('id_evento', $id);
        return $this->db->update('eventos', $data);
        
    }
    
    function aprobar_evento_necesidad($id)
    {
        $data = array(
            'estado' => 2
        );
        $this->db->where('id_evento', $id);
        return $this->db->update('eventos_necesidad', $data);
        
    }
    
}
