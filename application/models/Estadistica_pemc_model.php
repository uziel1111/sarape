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
        $query = 'select count(obj.num_objetivos) total_obj, obj.municipio, obj.num_objetivos  from (SELECT COUNT(DISTINCT o.id_objetivo) as num_objetivos, m.municipio
        FROM rm_tema_prioritarioxcct tp
        INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
        LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
        INNER JOIN escuela e on e.id_cct = tp.id_cct
        INNER JOIN municipio m on e.id_municipio = m.id_municipio
        where m.zona_economica = 5 and e.id_municipio = '.$municipio.'';
        if ($nivel != 0) {
        $query .=' and e.id_nivel = '.$nivel.'';
        }
        $query .= ' GROUP BY tp.id_tprioritario  ORDER by tp.orden) as obj group by obj.num_objetivos;';
        
     // echo '<pre>'; print_r($query);
      return $this->db->query($query)->result_array();

     
   
 }

 function municipios()
 {
  $this->db->select('id_municipio, municipio');
  $this->db->from('municipio');
  $this->db->where('zona_economica', '5');

  return  $this->db->get()->result_array();
}

 function get_total($nivel, $municipio){
    $query = 'select sum(total.cct) as total from  (select count(obj.num_objetivos), obj.municipio, obj.num_objetivos, count(obj.id_cct) as cct ,obj.id_cct  from (SELECT COUNT(DISTINCT o.id_objetivo) as num_objetivos, m.municipio, e.id_cct
        FROM rm_tema_prioritarioxcct tp
        INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
        LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
        LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
        INNER JOIN escuela e on e.id_cct = tp.id_cct
        INNER JOIN municipio m on e.id_municipio = m.id_municipio
        where m.zona_economica = 5 and e.id_municipio = '.$municipio.'';
        if ($nivel != 0) {
          $query .=' and e.id_nivel = '.$nivel.'';
        }
        $query .= ' GROUP BY tp.id_cct  ORDER by tp.orden) as obj group by obj.num_objetivos, obj.id_cct) as total;';

        return $this->db->query($query)->result_array();
}

  function get_escuelasMun($nivel, $id_municipio)
 {
  $this->db->select('count(*) as total');
  $this->db->from('escuela');
  $this->db->where('id_municipio', $id_municipio);
   if ($nivel != 0) {
  $this->db->where('id_nivel', $nivel);
    }
  $this->db->group_by('id_municipio');

  return  $this->db->get()->result_array();
 }

 function get_region(){
   $this->db->select('m.municipio, m.id_municipio, r.region, r.id_region');
  $this->db->from('municipio as m');
  $this->db->join('region as r', 'r.id_region = m.id_region');
  $this->db->where('m.zona_economica',5);
  $this->db->order_by('m.id_region');

  return  $this->db->get()->result_array();
 }

 function get_municipios($region){
   $this->db->select('m.municipio, m.id_municipio, r.region, r.id_region');
  $this->db->from('municipio as m');
  $this->db->join('region as r', 'r.id_region = m.id_region');
  $this->db->where('zona_economica',5);
  if ($region != 0) {
  $this->db->where('m.id_region',$region);
  }
  $this->db->order_by('m.id_region');

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
   inner join municipio m on m.id_municipio = e.id_municipio
   WHERE m.zona_economica = 5  and m.id_municipio = '.$municipio.'';
   if ($nivel != 0) {
    $query .= ' and e.id_nivel = '.$nivel. '';
  }

  $query .= ' GROUP BY tp.orden  ORDER by tp.orden';

   // echo '<pre>'; print_r($query); die();

  return $this->db->query($query)->result_array();
}

 function get_obj_acc_lae_zona_sost($nivel, $zona, $sostenimiento)
 {
   $query = 'SELECT tp.orden, COUNT(DISTINCT o.id_objetivo) as num_objetivos, COUNT(DISTINCT a.id_accion) as num_acciones
   FROM rm_tema_prioritarioxcct tp
   INNER JOIN rm_c_prioridad p on tp.id_prioridad=p.id_prioridad
   LEFT JOIN rm_objetivo o ON tp.id_tprioritario=o.id_tprioritario
   LEFT JOIN rm_accionxtproritario a on o.id_objetivo=a.id_objetivos
   inner join escuela e on e.id_cct = tp.id_cct
   inner join municipio m on m.id_municipio = e.id_municipio
   inner join subsostenimiento s on s.id_subsostenimiento = e.id_subsostenimiento
   inner join supervision su on su.id_supervision = e.id_supervision
   WHERE m.zona_economica = 5  ';
   if ($nivel != 0) {
    $query .= ' and e.id_nivel = '.$nivel. '';
  }
   if ($zona != 0) {
     $query .= ' and su.zona_escolar = '.$zona.'';
   }
    if ($sostenimiento != 0) {
     $query .= ' and s.id_sostenimiento = '.$sostenimiento.'';
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
   inner join municipio m on m.id_municipio = e.id_municipio
   WHERE m.zona_economica = 5';
   if ($region =! 0) {
       $query .= ' and m.id_region = '.$region.'';
   }
   if ($municipio =! 0) {
     $query .= ' and m.id_municipio = '.$municipio.'';
   }
   if ($nivel != 0) {
    $query .= ' and e.id_nivel = '.$nivel. '';
  }

  $query .= ' GROUP BY tp.orden  ORDER by tp.orden';

   // echo '<pre>'; print_r($query); die();

  return $this->db->query($query)->result_array();
}

 function allzonas(){
      $this->db->select('su.id_supervision, su.zona_escolar');
      $this->db->from('supervision as su');
      $this->db->join('escuela as es','su.id_supervision = es.id_supervision');
      $this->db->group_by("su.zona_escolar");
      return  $this->db->get()->result_array();
    }// all()
    
/*BK201 E*/
  function getall_xest_ind(){
    $this->db->select('mu.id_municipio, mu.municipio');
    $this->db->from('municipio mu');
    $this->db->join('escuela as es', 'mu.id_municipio = es.id_municipio');
    $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
    $this->db->group_by('mu.id_municipio');
    return  $this->db->get()->result_array();
  }// getall_xest_ind()


  function get_xparams($id_municipio,$id_nivel,$id_sostenimiento,$nombre_escuela){
    // echo $id_municipio."\n";
    // echo $id_nivel."\n";
    // echo $id_sostenimiento."\n";
    // echo $nombre_escuela."\n";
    // die();
    $this->db->select('es.id_cct, es.cve_centro, tu.turno_single, es.nombre_centro,ni.nivel,sso.subsostenimiento, mo.modalidad,mu.municipio,loc.localidad,es.domicilio, es.latitud, es.longitud, es.id_nivel, s.zona_escolar, so.sostenimiento');
    $this->db->from('escuela as es');
    $this->db->join('turno_single as tu', 'es.id_turno_single = tu.id_turno_single');
    $this->db->join('nivel as ni', 'es.id_nivel = ni.id_nivel');
    $this->db->join('subsostenimiento as sso', 'es.id_subsostenimiento = sso.id_subsostenimiento');
    $this->db->join('sostenimiento as so', 'sso.id_sostenimiento = so.id_sostenimiento');
    $this->db->join('modalidad as mo', 'es.id_modalidad = mo.id_modalidad');
    $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
    $this->db->join('supervision as s', 'es.id_supervision = s.id_supervision');
    $this->db->join('localidad as loc', 'mu.id_municipio = loc.id_municipio AND es.id_localidad = loc.cve_localidad');
      $where_au = "(es.id_estatus !=2 AND es.id_estatus !=3)";
    $this->db->where($where_au);
    $this->db->where('es.latitud !=',0);
    $this->db->where('es.latitud !=','');
    $this->db->where('es.latitud !=','#VALUE!');
    if($id_municipio>0){
      $this->db->where('es.id_municipio', $id_municipio);
    }
    if($id_nivel>0){
      $this->db->where('es.id_nivel', $id_nivel);
    }
    if($id_sostenimiento>0){
      $this->db->where('so.id_sostenimiento', $id_sostenimiento);
    }
    if($nombre_escuela!=''){
      $this->db->like('es.nombre_centro', $nombre_escuela);
    }

    $this->db->group_by("es.id_cct");
    $this->db->order_by("ni.id_nivel");
    return  $this->db->get()->result_array();
  }// get_xparams()
}