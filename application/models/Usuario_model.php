<?php
class Usuario_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }


    function get_datos_sesion($usuario, $contrasena){
        $this->db->select('u.idusuario, u.nombre, u.paterno, u.materno, u.id_nivel');
        $this->db->from('seguridad as s');
        $this->db->join('usuario as u', 'u.idusuario = s.idusuario');
        $this->db->where('s.username', $usuario);
        $this->db->where('s.clave', $contrasena);
         return  $this->db->get()->result_array();
    }// get_datos_sesion()

}// Sostenimiento_model
