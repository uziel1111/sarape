<?php
class Sostenimiento_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function all(){
      return  $this->db->get('sostenimiento')->result_array();
    }// all()

    function getsost_xidmun_idnivel($id_municipio,$nivel){

      $filtro="";
      if($id_municipio>0){
        $filtro.=" and v.municipio={$id_municipio} ";
      }
      if($nivel!="TODOS"){
        $filtro.=" and v.desc_nivel_educativo = '{$nivel}' ";
      }

      $query="SELECT (SELECT CASE
              WHEN v.sostenimiento IN  ('51') THEN '3'
              WHEN v.sostenimiento IN ('61','41','92','96') THEN '2'
              ELSE '1'
              END) as id_sostenimiento,
              (SELECT CASE
              WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO'
              WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
              ELSE 'PUBLICO'
              END) AS sostenimiento
              FROM centros_educativos.vista_cct v
              INNER JOIN  sarape.estadistica_e_indicadores_xcct est ON est.cct=v.cct
              WHERE v.status IN ('1','4') AND v.tipo_centro='9'
              {$filtro}
              GROUP BY sostenimiento;";

      return $this->db->query($query)->result_array();


    }// get_xcvenivel()

    function get_sostenimiento($id_sostenimiento){
      if ($id_sostenimiento==0) {
        return "TODOS";
      }
      else {
        $this->db->select('so.sostenimiento');
        $this->db->from('sostenimiento as so');
        $this->db->where('so.id_sostenimiento', $id_sostenimiento);
        return  $this->db->get()->row('sostenimiento');
      }

    }// get_sostenimiento()

}// Sostenimiento_model
