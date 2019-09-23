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

    /*BK201 S*/
    function get_cantidad_datos($nivel, $municipio){
      
       $this->db->select('tp.id_cct, e.cve_centro, tp.orden, e.id_nivel, m.nombre, m.idmunicipio, COUNT(DISTINCT o.id_objetivo) as num_objetivos#, COUNT(DISTINCT a.id_accion) as num_acciones');
       $this->db->from('rm_tema_prioritarioxcct as tp');
       $this->db->join('rm_c_prioridad as p', 'tp.id_prioridad=p.id_prioridad');
       $this->db->join('rm_objetivo as o', 'tp.id_tprioritario=o.id_tprioritario', 'left');
       // $this->db->join('rm_accionxtproritario as a', 'o.id_objetivo=a.id_objetivos', 'left');
       $this->db->join('escuela as e', 'e.id_cct = tp.id_cct');
       $this->db->join('municipio as m', 'm.idmunicipio=e.id_municipio');
       if ($nivel != 0) {
        $this->db->where('e.id_nivel', $nivel);
       }
       if ($municipio != 0) {
        $this->db->where('e.id_municipio', $municipio);
       }
       $this->db->where('m.identidad', 5);
    // $this->db->group_by('tp.id_cct');
    $this->db->group_by('m.idmunicipio');
    $this->db->order_by('tp.orden');
   /* $this->db->get(); 
    echo $this->db->last_query(); die();*/
    return  $this->db->get()->result_array();
}

    function get_total($nivel, $municipio){
        $this->db->select('count(*) as total');
        $this->db->from('rm_tema_prioritarioxcct as tp');
        $this->db->join('escuela as e', 'tp.id_cct = e.id_cct');
        $this->db->join('municipio as m', 'm.idmunicipio = e.id_municipio');
         if ($nivel != 0) {
        $this->db->where('e.id_nivel', $nivel);
       }
        if ($municipio != 0) {
        $this->db->where('e.id_municipio', $municipio);
       }
        $this->db->where('m.identidad', 5);
        $this->db->group_by('tp.id_cct');
     return  $this->db->get()->result_array();
    }
/*BK201 E*/
}