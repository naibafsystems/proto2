<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login_user($username, $password) {
        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, usuario, rol, lo.usuario as email, lo.estado FROM login lo ";
        $cadena_sql.= "JOIN usuario us ON usuario_id_usuario = us.id_usuario ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "WHERE usuario = '" . $username . "' AND clave = '" . $password . "'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }
    
    public function login_recupera($username) {
        $cadena_sql = "SELECT us.id_usuario, nombres, apellidos, usuario, rol FROM login lo ";
        $cadena_sql.= "JOIN usuario us ON usuario_id_usuario = us.id_usuario ";
        $cadena_sql.= "JOIN usuario_rol ur ON ur.id_usuario = us.id_usuario ";
        $cadena_sql.= "WHERE usuario = '" . $username . "'";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
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
	
	public function coordinadores($username) {
        $cadena_sql = "SELECT nombres, apellidos, email, estado, id_ciudad ";
        $cadena_sql.= "FROM coordinadores ";
        $cadena_sql.= "WHERE email = '" . $username . "' ";
        
        $query = $this->db->query($cadena_sql);
        
        $result = $query->result();
        
        return $result;
    }

}
