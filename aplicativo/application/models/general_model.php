<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class general_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function rol_usuario($rol) {
        $query = $this->db->query("SELECT descripcion FROM roles WHERE id_rol = ".$rol);
		$result = $query->row(); 
        return $result;
    }

    function menuPrincipal($rol) {
        $this->load->database();
        
        $cadena_sql = "SELECT us.id_usuario, tipo_iden, nume_docu, nombres, apellidos, email ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "WHERE rol='1' ";
        $query = $this->db->query($cadena_sql);
                
        return $query->result();
    }
    
    function obtener_datosRol2() {
        $this->load->database();
        
        $cadena_sql = "SELECT us.id_usuario, tipo_iden, nume_docu, nombres, apellidos, email ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "WHERE rol='2' ";
        $query = $this->db->query($cadena_sql);
        
        return $query->result();
    }
    
    function obtener_datosRol3() {
        $this->load->database();
        
        $cadena_sql = "SELECT us.id_usuario, tipo_iden, nume_docu, nombres, apellidos, email ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "WHERE rol='3' ";
        
        $query = $this->db->query($cadena_sql);
        
        return $query->result();
    }
    
    function datosUsuario($id_usuario) {
        $this->load->database();
        
        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, email ";
        $cadena_sql.= "FROM usuario us ";
        $cadena_sql.= "WHERE id_usuario = ".$id_usuario;
        
        $query = $this->db->query($cadena_sql);
        
        return $query->result();
    }

    function cambiarPassword($param) {
        $this->db->trans_start();
        $this->db->insert('login', $param);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }
    
    function actualizarPass($id_usuario, $pass)
    {
        $data = array(
            'clave' => $pass
        );
        $this->db->where('usuario_id_usuario', $id_usuario);
        return $this->db->update('login', $data);
    }
}
