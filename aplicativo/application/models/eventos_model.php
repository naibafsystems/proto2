<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class eventos_model extends CI_Model {

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

    function eventosMiembro($id_usuario) {
        $this->load->database();

        $cadena_sql = "SELECT ev.id_evento, ev.descripcion, ev.tipo_actividad, tact.descripcion_es AS desc_acti_es, tact.descripcion_en  AS desc_acti_en, ev.fecha_inicio, ev.fecha_fin, ev.tipo_clasificacion, tcla.descripcion_es  AS desc_clas_es, tcla.descripcion_en  AS desc_clas_en, ev.estado, ruta, nombre ";
        $cadena_sql.= "FROM eventos ev ";
        $cadena_sql.= "JOIN archivos ar ON ar.id_archivo = ev.id_archivo ";
        $cadena_sql.= "JOIN param_tipo_clasificacion tcla ON ev.tipo_clasificacion = tcla.id_tipo_clasificacion ";
        $cadena_sql.= "JOIN param_tipo_actividad tact ON ev.tipo_actividad = tact.id_tipo_actividad ";
        $cadena_sql.= "WHERE id_usuario = ".$id_usuario;
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }

    function eventosMiembroNecesidad($id_usuario) {
        $this->load->database();

        $cadena_sql = "SELECT ev.id_evento, ev.descripcion, ev.tipo_actividad, tact.descripcion_es AS desc_acti_es, tact.descripcion_en  AS desc_acti_en, ev.fecha_inicio, ev.fecha_fin, ev.tipo_clasificacion, tcla.descripcion_es  AS desc_clas_es, tcla.descripcion_en  AS desc_clas_en, ev.estado, ruta, nombre ";
        $cadena_sql.= "FROM eventos_necesidad ev ";
        $cadena_sql.= "JOIN archivos ar ON ar.id_archivo = ev.id_archivo ";
        $cadena_sql.= "JOIN param_tipo_clasificacion tcla ON ev.tipo_clasificacion = tcla.id_tipo_clasificacion ";
        $cadena_sql.= "JOIN param_tipo_actividad tact ON ev.tipo_actividad = tact.id_tipo_actividad ";
        $cadena_sql.= "WHERE id_usuario = ".$id_usuario;
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    function eventosPendientes() {
        $this->load->database();

        $cadena_sql = "SELECT ev.id_evento, ev.descripcion, ev.tipo_actividad, tact.descripcion_es AS desc_acti_es, tact.descripcion_en  AS desc_acti_en, ev.fecha_inicio, ev.fecha_fin, ev.tipo_clasificacion, tcla.descripcion_es  AS desc_clas_es, tcla.descripcion_en  AS desc_clas_en, ev.estado, ruta, nombre, usu.codi_pais, ev.paises ";
        $cadena_sql.= "FROM eventos ev ";
        $cadena_sql.= "JOIN archivos ar ON ar.id_archivo = ev.id_archivo ";
        $cadena_sql.= "JOIN param_tipo_clasificacion tcla ON ev.tipo_clasificacion = tcla.id_tipo_clasificacion ";
        $cadena_sql.= "JOIN param_tipo_actividad tact ON ev.tipo_actividad = tact.id_tipo_actividad ";
        $cadena_sql.= "JOIN usuario usu ON ev.id_usuario = usu.id_usuario ";
        $cadena_sql.= "WHERE ev.estado = 1";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    
    function eventosPublicados() {
        $this->load->database();

        $cadena_sql = "SELECT ev.id_evento, ev.descripcion, ev.tipo_actividad, tact.descripcion_es AS desc_acti_es, tact.descripcion_en  AS desc_acti_en, ev.fecha_inicio, ev.fecha_fin, ev.tipo_clasificacion, tcla.descripcion_es  AS desc_clas_es, tcla.descripcion_en  AS desc_clas_en, ev.estado, ruta, nombre, usu.codi_pais, ev.contacto, ev.link, ev.paises  ";
        $cadena_sql.= "FROM eventos ev ";
        $cadena_sql.= "JOIN archivos ar ON ar.id_archivo = ev.id_archivo ";
        $cadena_sql.= "JOIN param_tipo_clasificacion tcla ON ev.tipo_clasificacion = tcla.id_tipo_clasificacion ";
        $cadena_sql.= "JOIN param_tipo_actividad tact ON ev.tipo_actividad = tact.id_tipo_actividad ";
        $cadena_sql.= "JOIN usuario usu ON ev.id_usuario = usu.id_usuario ";
        $cadena_sql.= "WHERE ev.estado = 2";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    function infoEvento($id_evento) {
        $this->load->database();

        $cadena_sql = "SELECT ev.id_evento, ev.descripcion, ev.tipo_actividad, tact.descripcion_es AS desc_acti_es, tact.descripcion_en  AS desc_acti_en, ev.fecha_inicio, ev.fecha_fin, ev.tipo_clasificacion, tcla.descripcion_es  AS desc_clas_es, tcla.descripcion_en  AS desc_clas_en, ev.estado, ruta, nombre, usu.codi_pais, ev.contacto, ev.link, ev.paises, ev.id_archivo  ";
        $cadena_sql.= "FROM eventos ev ";
        $cadena_sql.= "JOIN archivos ar ON ar.id_archivo = ev.id_archivo ";
        $cadena_sql.= "JOIN param_tipo_clasificacion tcla ON ev.tipo_clasificacion = tcla.id_tipo_clasificacion ";
        $cadena_sql.= "JOIN param_tipo_actividad tact ON ev.tipo_actividad = tact.id_tipo_actividad ";
        $cadena_sql.= "JOIN usuario usu ON ev.id_usuario = usu.id_usuario ";
        $cadena_sql.= "WHERE ev.id_evento = ".$id_evento;
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    function infoEventoNecesidad($id_evento) {
       $this->load->database();

        $cadena_sql = "SELECT ev.id_evento, ev.descripcion, ev.tipo_actividad, tact.descripcion_es AS desc_acti_es, tact.descripcion_en  AS desc_acti_en, ev.fecha_inicio, ev.fecha_fin, ev.tipo_clasificacion, tcla.descripcion_es  AS desc_clas_es, tcla.descripcion_en  AS desc_clas_en, ev.estado, ruta, nombre, usu.codi_pais, ev.contacto, ev.link, ev.id_archivo ";
        $cadena_sql.= "FROM eventos_necesidad ev ";
        $cadena_sql.= "JOIN archivos ar ON ar.id_archivo = ev.id_archivo ";
        $cadena_sql.= "JOIN param_tipo_clasificacion tcla ON ev.tipo_clasificacion = tcla.id_tipo_clasificacion ";
        $cadena_sql.= "JOIN param_tipo_actividad tact ON ev.tipo_actividad = tact.id_tipo_actividad ";
        $cadena_sql.= "JOIN usuario usu ON ev.id_usuario = usu.id_usuario ";
        $cadena_sql.= "WHERE ev.id_evento = ".$id_evento;
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    function eventosComun($tipo_actividad, $tipo_clasificacion) {
        $this->load->database();

        $cadena_sql = "SELECT ev.id_evento, ev.descripcion, ev.tipo_actividad, tact.descripcion_es AS desc_acti_es, tact.descripcion_en  AS desc_acti_en, ev.fecha_inicio, ev.fecha_fin, ev.tipo_clasificacion, tcla.descripcion_es  AS desc_clas_es, tcla.descripcion_en  AS desc_clas_en, ev.estado, ruta, nombre, usu.codi_pais, ev.contacto, ev.link  ";
        $cadena_sql.= "FROM eventos ev ";
        $cadena_sql.= "JOIN archivos ar ON ar.id_archivo = ev.id_archivo ";
        $cadena_sql.= "JOIN param_tipo_clasificacion tcla ON ev.tipo_clasificacion = tcla.id_tipo_clasificacion ";
        $cadena_sql.= "JOIN param_tipo_actividad tact ON ev.tipo_actividad = tact.id_tipo_actividad ";
        $cadena_sql.= "JOIN usuario usu ON ev.id_usuario = usu.id_usuario ";
        $cadena_sql.= "WHERE ev.estado = 2 ";
        $cadena_sql.= "AND ev.tipo_actividad = '".$tipo_actividad."' ";
        $cadena_sql.= "AND ev.tipo_clasificacion = '".$tipo_clasificacion."' ";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    
    function eventosPendientesNecesidad() {
        $this->load->database();

        $cadena_sql = "SELECT ev.id_evento, ev.descripcion, ev.tipo_actividad, tact.descripcion_es AS desc_acti_es, tact.descripcion_en  AS desc_acti_en, ev.fecha_inicio, ev.fecha_fin, ev.tipo_clasificacion, tcla.descripcion_es  AS desc_clas_es, tcla.descripcion_en  AS desc_clas_en, ev.estado, ruta, nombre, usu.codi_pais ";
        $cadena_sql.= "FROM eventos_necesidad ev ";
        $cadena_sql.= "JOIN archivos ar ON ar.id_archivo = ev.id_archivo ";
        $cadena_sql.= "JOIN param_tipo_clasificacion tcla ON ev.tipo_clasificacion = tcla.id_tipo_clasificacion ";
        $cadena_sql.= "JOIN param_tipo_actividad tact ON ev.tipo_actividad = tact.id_tipo_actividad ";
        $cadena_sql.= "JOIN usuario usu ON ev.id_usuario = usu.id_usuario ";
        $cadena_sql.= "WHERE ev.estado = 1";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    
    function eventosPublicadosNecesidad() {
        $this->load->database();

        $cadena_sql = "SELECT ev.id_evento, ev.descripcion, ev.tipo_actividad, tact.descripcion_es AS desc_acti_es, tact.descripcion_en  AS desc_acti_en, ev.fecha_inicio, ev.fecha_fin, ev.tipo_clasificacion, tcla.descripcion_es  AS desc_clas_es, tcla.descripcion_en  AS desc_clas_en, ev.estado, ruta, nombre, usu.codi_pais, ev.contacto, ev.link  ";
        $cadena_sql.= "FROM eventos_necesidad ev ";
        $cadena_sql.= "JOIN archivos ar ON ar.id_archivo = ev.id_archivo ";
        $cadena_sql.= "JOIN param_tipo_clasificacion tcla ON ev.tipo_clasificacion = tcla.id_tipo_clasificacion ";
        $cadena_sql.= "JOIN param_tipo_actividad tact ON ev.tipo_actividad = tact.id_tipo_actividad ";
        $cadena_sql.= "JOIN usuario usu ON ev.id_usuario = usu.id_usuario ";
        $cadena_sql.= "WHERE ev.estado = 2";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }
    
    
    public function tipo_clasificacion() {
        $query = $this->db->query("SELECT id_tipo_clasificacion, descripcion_es, descripcion_en "
                                . "FROM param_tipo_clasificacion ");
        $result = $query->result();
        return $result;
    }
   
    public function tipo_actividad() {
        $query = $this->db->query("SELECT id_tipo_actividad, descripcion_es, descripcion_en, grupo "
                                . "FROM param_tipo_actividad "
                                . "ORDER BY 1 ");
        $result = $query->result();
        return $result;
    }
    
    public function paises() {
        $query = $this->db->query("SELECT codi_pais, desc_pais "
                                . "FROM param_paises ");
        $result = $query->result();
        return $result;
    }
    
    
    public function infoPais($codi_pais) {
        $query = $this->db->query("SELECT desc_pais "
                                . "FROM param_paises "
                                . "WHERE codi_pais = '".$codi_pais."' ");
        $result = $query->result();
        return $result;
    }
    
    public function insertarEventos($param) {
        $this->db->trans_start();
        $this->db->insert('eventos', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    public function insertarEventos_necesidad($param) {
        $this->db->trans_start();
        $this->db->insert('eventos_necesidad', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
	public function actualizarEventos($id_evento, $descripcion, $tipo_actividad, $fecha_inicio, $fecha_fin, $tipo_clasificacion, $contacto, $link,$paises, $archivo)
	{
		$data = array(
            'descripcion' => $descripcion,
            'tipo_actividad' => $tipo_actividad,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'tipo_clasificacion' => $tipo_clasificacion,
            'contacto' => $contacto,
            'link' => $link,
            'id_archivo' => $archivo,
            'paises' => $paises,
        );
        $this->db->where('id_evento', $id_evento);
        return $this->db->update('eventos', $data);
	}
	
	public function actualizarEventosNecesidad($id_evento, $descripcion, $tipo_actividad, $fecha_inicio, $fecha_fin, $tipo_clasificacion, $contacto, $link, $archivo)
	{
		$data = array(
            'descripcion' => $descripcion,
            'tipo_actividad' => $tipo_actividad,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'tipo_clasificacion' => $tipo_clasificacion,
            'contacto' => $contacto,
            'link' => $link,
            'id_archivo' => $archivo
        );
        $this->db->where('id_evento', $id_evento);
        return $this->db->update('eventos_necesidad', $data);
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
