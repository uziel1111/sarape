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
        $query = 'select count(obj.num_objetivos) total_obj, obj.nombre, obj.num_objetivos  from (SELECT COUNT(DISTINCT o.id_objetivo) as num_objetivos, m.nombre
        FROM rm_tema_prioritarioxcct tp
        INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
        LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
        INNER JOIN escuela e on e.id_cct = tp.id_cct
        INNER JOIN municipio m on e.id_municipio = m.idmunicipio
        where m.identidad = 5 and e.id_municipio = '.$municipio.'';
        if ($nivel != 0) {
        $query .=' and e.id_nivel = '.$nivel.'';
        }
        $query .= ' GROUP BY tp.id_tprioritario  ORDER by tp.orden) as obj group by obj.num_objetivos;';
        
     // echo '<pre>'; print_r($query);
      return $this->db->query($query)->result_array();

     
   
 }

 function municipios()
 {
  $this->db->select('idmunicipio, nombre');
  $this->db->from('municipio');
  $this->db->where('identidad', '5');

  return  $this->db->get()->result_array();
}

 function get_total($nivel, $municipio){
    $query = 'select sum(total.cct) as total from  (select count(obj.num_objetivos), obj.nombre, obj.num_objetivos, count(obj.id_cct) as cct ,obj.id_cct  from (SELECT COUNT(DISTINCT o.id_objetivo) as num_objetivos, m.nombre, e.id_cct
        FROM rm_tema_prioritarioxcct tp
        INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
        LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
        INNER JOIN escuela e on e.id_cct = tp.id_cct
        INNER JOIN municipio m on e.id_municipio = m.idmunicipio
        where m.identidad = 5 and e.id_municipio = '.$municipio.'';
        if ($nivel != 0) {
          $query .=' and e.id_nivel = '.$nivel.'';
        }
        $query .= ' GROUP BY tp.id_cct  ORDER by tp.orden) as obj group by obj.num_objetivos, obj.id_cct) as total;';

        return $this->db->query($query)->result_array();
}

  function get_escuelasMun($nivel, $idmunicipio)
 {
  $this->db->select('count(*) as total');
  $this->db->from('escuela');
  $this->db->where('id_municipio', $idmunicipio);
   if ($nivel != 0) {
  $this->db->where('id_nivel', $nivel);
    }
  $this->db->group_by('id_municipio');

  return  $this->db->get()->result_array();
 }

 function get_region(){
   $this->db->select('m.nombre, m.idmunicipio, r.region, r.id_region');
  $this->db->from('municipio as m');
  $this->db->join('region as r', 'r.id_region = m.region');
  $this->db->where('identidad',5);
  $this->db->order_by('m.region');

  return  $this->db->get()->result_array();
 }

 function get_municipios($region){
   $this->db->select('m.nombre, m.idmunicipio, r.region, r.id_region');
  $this->db->from('municipio as m');
  $this->db->join('region as r', 'r.id_region = m.region');
  $this->db->where('identidad',5);
  if ($region != 0) {
  $this->db->where('id_region',$region);
  }
  $this->db->order_by('m.region');

  return  $this->db->get()->result_array();
 }


 function get_obj_acc_lae($nivel, $municipio)
 {
   $query = 'SELECT tp.orden, COUNT(DISTINCT o.id_objetivo) as num_objetivos, COUNT(DISTINCT a.id_accion) as num_acciones
   FROM rm_tema_prioritarioxcct tp
   INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
   LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
   LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
   inner join escuela e on e.id_cct = tp.id_cct
   inner join municipio m on m.idmunicipio = e.id_municipio
   WHERE m.identidad = 5  and m.idmunicipio = '.$municipio.'';
   if ($nivel != 0) {
    $query .= ' and e.id_nivel = '.$nivel. '';
  }

  $query .= ' GROUP BY tp.orden  ORDER by tp.orden';

   // echo '<pre>'; print_r($query); die();

  return $this->db->query($query)->result_array();
}

function get_filtros($nivel, $municipio, $region)
 {
   $query = 'SELECT tp.orden, COUNT(DISTINCT o.id_objetivo) as num_objetivos, COUNT(DISTINCT a.id_accion) as num_acciones
   FROM rm_tema_prioritarioxcct tp
   INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
   LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
   LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
   inner join escuela e on e.id_cct = tp.id_cct
   inner join municipio m on m.idmunicipio = e.id_municipio
   WHERE m.identidad = 5';
   if ($region =! 0) {
       $query .= ' and m.region = '.$region.'';
   }
   if ($municipio =! 0) {
     $query .= ' and m.idmunicipio = '.$municipio.'';
   }
   if ($nivel != 0) {
    $query .= ' and e.id_nivel = '.$nivel. '';
  }

  $query .= ' GROUP BY tp.orden  ORDER by tp.orden';

   // echo '<pre>'; print_r($query); die();

  return $this->db->query($query)->result_array();
}
/*BK201 E*/
}