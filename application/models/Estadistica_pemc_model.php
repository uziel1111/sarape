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

    function getdatoscct_pemc($cct, $turno){
        $this->db->select('e.id_cct, e.cve_centro, e.nombre_centro, e.id_turno_single, ts.turno_single, n.nivel, e.nombre_director,"upemc" as tipo_usuario_pemc');
      $this->db->from('escuela e');
      $this->db->join('turno_single AS ts ',' e.id_turno_single = ts.id_turno_single');
      $this->db->join('nivel AS n ', 'n.id_nivel = e.id_nivel');
      $this->db->where("e.cve_centro = '{$cct}'");
      $this->db->where("ts.id_turno_single = {$turno}");
      // $this->db->get();
      // echo $this->db->last_query();die();
      return  $this->db->get()->result_array();
    }

}