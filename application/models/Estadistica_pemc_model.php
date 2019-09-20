<?php 

class Estadistica_pemc_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

     function get_datos_sesion($usuario, $contrasena){
        $this->db->select('u.id_usuario, u.nombre, u.paterno, u.materno');
        $this->db->from('est_pemc_seguridad as s');
        $this->db->join('est_pemc_usuario as u', 'u.id_usuario = s.id_usuario');
        $this->db->where('s.user', $usuario);
        $this->db->where('s.clave', $contrasena);
         return  $this->db->get()->result_array();
    }// get_datos_sesion()

}