<?php
class Pemc_model extends CI_Model
{
  function __construct(){
    parent::__construct();
    date_default_timezone_set('America/Mexico_City');
    $this->pemc_db = $this->load->database('pemc_db', TRUE);
  }


 function getdatoscct($cct, $turno){

    $str_query = "SELECT
    e.cct as cve_centro,
    e.nombre as nombre_centro,
    e.turno as id_turno_single,
    e.desc_turno as turno_single,
    e.desc_nivel_educativo as nivel,
    CONCAT_WS(' ', e.nombre_director, e.apellido_paterno_director, e.apellido_materno_director) as nombre_director
    FROM
    vista_cct e
    WHERE
    e.cct ='{$cct}'
    AND e.turno like '%{$turno}%'";
    return $this->pemc_db->query($str_query)->result_array();

  }

    //FUNCIONAMIENTO Y VALIDACION PARA SUPERVISOR BY LUIS SANCHEZ... all reserved rights

function valida_supervisor($cct){
 $str_query = "SELECT * FROM vista_cct WHERE cct = '{$cct}' and tipo_centro = 1";
 return $this->pemc_db->query($str_query)->result_array();
}

function obtener_idpemc_xescuela($cct, $turno){
  $str_query = "SELECT idpemc FROM r_pemcxescuela WHERE cct ='{$cct}' AND id_turno_single = {$turno}";
  $idpemc = $this->pemc_db->query($str_query)->row('idpemc');
  if ($idpemc=='') {
    date_default_timezone_set('America/Monterrey');
		setlocale(LC_TIME, 'es_MX.UTF-8');
		$fecha = date("Y-m-d H:i:s");
		$data_req = array(
			'cct' =>$cct,
			'id_turno_single' =>$turno,
			'fcreacion' =>$fecha
		);
      $this->pemc_db->insert('r_pemcxescuela', $data_req);
			$idpemc = $this->pemc_db->insert_id();
  }
  return $idpemc;
}


function obtener_diagnostico_xidpemc($idpemc){
 $str_query = "SELECT diagnostico FROM r_pemc_diagnostico WHERE idpemc={$idpemc}";
 return $this->pemc_db->query($str_query)->row('diagnostico');
}


}// Rutamejora_model
