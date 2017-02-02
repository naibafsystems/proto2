<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class productos_model extends CI_Model {

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

    public function productosGrupos($id_grupo) {
        
        $query = $this->db->query("SELECT id_producto, pa.id_actividad, observacion, pa.fecha, ar.id_archivo, ruta, nombre, ar.fecha, tags, es_publico, ar.estado "
                                . "FROM producto_actividad pa "
                                . "JOIN archivos ar ON ar.id_archivo = pa.id_archivo "
                                . "JOIN actividades_gt act ON act.id_actividad = pa.id_actividad "
                                . "WHERE es_publico = 1 " 
                                . "AND act.id_grupo = ".$id_grupo );
        $result = $query->result();
        return $result;
    }
    
    
    public function participantesGrupo($id_grupo) {
        $query = $this->db->query("SELECT id_miembros_gt, mgt.id_usuario, id_grupo, fecha_ingreso, fecha_fin, nombres, apellidos, email, us.codi_pais, desc_pais "
                                . "FROM miembros_gt mgt "
                                . "JOIN usuario us ON us.id_usuario = mgt.id_usuario "
                                . "JOIN param_paises pa ON pa.codi_pais = us.codi_pais "
                                . "WHERE mgt.estado = 'AC' "
                                . "AND mgt.id_grupo = ".$id_grupo." ");
        $result = $query->result();
        return $result;
    }
    
    public function coordinadorGrupo($id_grupo) {
        $query = $this->db->query("SELECT nombres, apellidos, email, us.codi_pais, desc_pais "
                                . "FROM grupo_trabajo gt "
                                . "JOIN usuario us ON us.id_usuario = gt.id_coordinador "
                                . "JOIN param_paises pa ON pa.codi_pais = us.codi_pais "
                                . "WHERE gt.estado = 'AC' "
                                . "AND gt.id_grupo = ".$id_grupo." ");
        $result = $query->result();
        return $result;
    }
    
    
    function coordinadores() {
        $this->load->database();

        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, email ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "WHERE rol='2' ";
        $query = $this->db->query($cadena_sql);

        return $query->result();
    }

    public function insertarGrupo($param) {
        $this->db->trans_start();
        $this->db->insert('grupo_trabajo', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function gruposCoordinador($id_usuario) {
        $query = $this->db->query("SELECT id_grupo, nombre_grupo, objetivo, email, estado "
                                . "FROM grupo_trabajo "
                                . "JOIN usuario ON usuario.id_usuario = grupo_trabajo.id_coordinador "
                                . "WHERE estado = 'AC' "
                                . "AND id_coordinador = ".$id_usuario." ");
        $result = $query->result();
        return $result;
    }
    
    public function miembrosGrupo($id_grupo) {
        $query = $this->db->query("SELECT id_miembros_gt, mgt.id_usuario, id_grupo, fecha_ingreso, fecha_fin, nombres, apellidos, email, desc_pais "
                                . "FROM miembros_gt mgt "
                                . "JOIN usuario us ON us.id_usuario = mgt.id_usuario "
                                . "JOIN param_paises pa ON pa.codi_pais = us.codi_pais "
                                . "WHERE mgt.estado = 'AC' "
                                . "AND mgt.id_grupo = ".$id_grupo." ");
        $result = $query->result();
        return $result;
    }
    
    public function miembrosNoGrupo($id_grupo) {
        $query = $this->db->query("SELECT us.id_usuario, nombres, apellidos, email, desc_pais "
                                . "FROM usuario us "
                                . "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario "
                                . "JOIN param_paises pa ON pa.codi_pais = us.codi_pais "
                                . "WHERE us.id_usuario NOT IN (SELECT mgt.id_usuario FROM miembros_gt mgt WHERE id_grupo = ".$id_grupo." ) "
                                . "AND rol='3' ");

        $result = $query->result();
        return $result;
    }
    
    public function datosGrupo($id_grupo) {
        $query = $this->db->query("SELECT id_grupo, nombre_grupo, objetivo, email, estado "
                                . "FROM grupo_trabajo "
                                . "JOIN usuario ON usuario.id_usuario = grupo_trabajo.id_coordinador "
                                . "WHERE estado = 'AC' "
                                . "AND id_grupo = ".$id_grupo." ");
        $result = $query->result();
        return $result;
    }
    
    public function insertarMiembro($param) {
        $this->db->trans_start();
        $this->db->insert('miembros_gt', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    public function actividadesPendientes($id_grupo) {
        $query = $this->db->query("SELECT id_actividad, id_grupo, descripcion, fecha_inicial, fecha_final, requerimiento, solucion, estado "
                                . "FROM actividades_gt  "
                                . "WHERE id_grupo = ".$id_grupo." "
                                . "AND estado = 'PE' ");
        $result = $query->result();
        return $result;
    }
    
    
    public function actividadesResueltas($id_grupo) {
        $query = $this->db->query("SELECT id_actividad, id_grupo, descripcion, fecha_inicial, fecha_final, requerimiento, solucion, estado "
                                . "FROM actividades_gt  "
                                . "WHERE id_grupo = ".$id_grupo." "
                                . "AND estado = 'SO' ");
        $result = $query->result();
        return $result;
    }
    
    public function insertarActividad($param) {
        $this->db->trans_start();
        $this->db->insert('actividades_gt', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    public function insertarUsuarioActividad($param) {
        $this->db->trans_start();
        $this->db->insert('usuario_actividad', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
       
    
    public function datosActividad($id_actividad) {
        $query = $this->db->query("SELECT id_actividad, id_grupo, descripcion, fecha_inicial, fecha_final, requerimiento, solucion, estado "
                                . "FROM actividades_gt  "
                                . "WHERE id_actividad = ".$id_actividad );
        $result = $query->result();
        return $result;
    }
    
    public function miembrosActividad($id_actividad) {
        $query = $this->db->query("SELECT id_usuario_actividad, id_usuario, id_actividad "
                                . "FROM usuario_actividad  "
                                . "WHERE id_actividad = ".$id_actividad );
        $result = $query->result();
        return $result;
    }
    
    public function observaciones($id_actividad) {
        $query = $this->db->query("SELECT id_actividad, observaciones, fecha "
                                . "FROM actividades_seguimiento  "
                                . "WHERE id_actividad = ".$id_actividad );
        $result = $query->result();
        return $result;
    }
    
    public function insertarObservacion($param) {
        $this->db->trans_start();
        $this->db->insert('actividades_seguimiento', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    public function productos($id_actividad) {
        $query = $this->db->query("SELECT id_producto, id_actividad, observacion, pa.fecha, ar.id_archivo, ruta, nombre, ar.fecha, tags, es_publico, estado "
                                . "FROM producto_actividad pa "
                                . "JOIN archivos ar ON ar.id_archivo = pa.id_archivo "
                                . "WHERE id_actividad = ".$id_actividad );
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
   
    public function insertarProductos($param) {
        $this->db->trans_start();
        $this->db->insert('producto_actividad', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    function eliminar_actividad($id)
    {
        $this->db->where('id_actividad',$id);
        $this->db->delete('usuario_actividad');
            
        $this->db->where('id_actividad',$id);
        $this->db->delete('actividades_gt');
    }
    
    function actualizarActividad($id_grupo, $id_actividad, $descripcion, $fechaIni, $fechaFin, $requerimiento)
    {
        $data = array(
            'descripcion' => $descripcion,
            'fecha_inicial' => $fechaIni,
            'fecha_final' => $fechaFin,
            'requerimiento' => $requerimiento
        );
        $this->db->where('id_actividad', $id_actividad);
        return $this->db->update('actividades_gt', $data);
    }
    
    function limpiarResponsables($id_actividad)
    {
        $this->db->where('id_actividad',$id_actividad);
        $this->db->delete('usuario_actividad');            
    }
    
    function desasociarMiembro($id_usuario,$id_grupo)
    {
        $this->db->where('id_usuario',$id_usuario);
        $this->db->where('id_grupo',$id_grupo);
        return $this->db->delete('miembros_gt');            
    }
    
    public function forosGrupo($id_grupo) {
        $query = $this->db->query("SELECT id_foro, ft.id_grupo, foro_tema, foro_descripcion, fc.id_categoria, fc.descripcion, foro_fecha,  "
                                . " foro_tipo, ft.id_archivo, ar.ruta, ar.nombre, id_autor, us.nombres, us.apellidos, us.email "
                                . "FROM foro_tema ft "
                                . "LEFT JOIN foro_categoria fc ON fc.id_categoria = ft.id_categoria "
                                . "LEFT JOIN archivos ar ON ar.id_archivo = ft.id_archivo "
                                . "LEFT JOIN usuario us ON us.id_usuario = ft.id_autor "
                                . "WHERE ft.id_grupo = ".$id_grupo );
        
        $result = $query->result();
        return $result;
    }
    
    public function ultRespuesta($id_foro) {
        $query = $this->db->query("SELECT max(respuesta_fecha) as respuesta_fecha, respuesta_nombre, respuesta_email "
                                . "FROM foro_respuesta "
                                . "WHERE id_foro = ".$id_foro );
        $result = $query->result();
        return $result;
    }
    
    public function totalRespuesta($id_foro) {
        $query = $this->db->query("SELECT count(respuesta_fecha) as total "
                                . "FROM foro_respuesta "
                                . "WHERE id_foro = ".$id_foro );
        $result = $query->result();
        return $result;
    }
    
    public function detalleForo($id_foro) {
        $query = $this->db->query("SELECT id_foro, ft.id_grupo, foro_tema, foro_descripcion, fc.id_categoria, fc.descripcion, foro_fecha,  "
                                . " foro_tipo, ft.id_archivo, ar.ruta, ar.nombre, id_autor, us.nombres, us.apellidos, us.email "
                                . "FROM foro_tema ft "
                                . "LEFT JOIN foro_categoria fc ON fc.id_categoria = ft.id_categoria "
                                . "LEFT JOIN archivos ar ON ar.id_archivo = ft.id_archivo "
                                . "LEFT JOIN usuario us ON us.id_usuario = ft.id_autor "
                                . "WHERE ft.id_foro = ".$id_foro );
        
        $result = $query->result();
        return $result;
    }
    
    public function respuestasForo($id_foro) {
        $query = $this->db->query("SELECT respuesta_fecha, respuesta_nombre, respuesta, respuesta_email, fr.id_archivo, ar.ruta, ar.nombre "
                                . "FROM foro_respuesta fr "
                                . "LEFT JOIN archivos ar ON ar.id_archivo = fr.id_archivo "
                                . "WHERE id_foro = ".$id_foro ." "
                                . "ORDER BY respuesta_fecha desc ");
        $result = $query->result();
        return $result;
    }
    
    public function insertarRespuestaForo($param) {
        $this->db->trans_start();
        $this->db->insert('foro_respuesta', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    public function categoriasForo() {
        $query = $this->db->query("SELECT id_categoria, descripcion, estado "
                                . "FROM foro_categoria ");
        $result = $query->result();
        return $result;
    }
    
    public function insertarForo($param) {
        $this->db->trans_start();
        $this->db->insert('foro_tema', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
}
