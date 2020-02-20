<?php
class Modalidad_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }


    function getmodali_xidmun_idnivel_idsost($id_municipio,$nivel,$sostenimiento){

      $filtro="";
      if($id_municipio>0){
        $filtro.=" AND municipio={$id_municipio}";
      }
      if($nivel!="TODOS"){
        $filtro.=" AND desc_nivel_educativo = '{$nivel}'";
      }
      if($sostenimiento!="TODOS"){
        if($sostenimiento=="PRIVADO"){
          $filtro.=" AND sostenimiento in('61','41','92','96')";
        }else if($sostenimiento=="AUTONOMO"){
          $filtro.="AND sostenimiento in(51)";
        }else {
          $filtro.="AND sostenimiento NOT IN('61','41','92','96','51')";
        }
      }

      $query="SELECT cct,nivel_educativo AS nivel,desc_nivel_educativo,
              servicio AS id_modalidad,desc_servicio AS modalidad
              FROM vista_cct WHERE status IN ('1','4')
              AND tipo_centro='9'
               {$filtro}
              GROUP BY desc_servicio";
      return $this->db->query($query)->result_array();

    }// getmodali_xidmun_idnivel_idsost()


    function get_modalidad($id_modalidad,$nivel){
      if ($id_modalidad==0) {
        return "TODOS";
      }
      else {

        $query = "SELECT desc_servicio as modalidad FROM vista_cct
                  WHERE  servicio={$id_modalidad}
                  AND desc_nivel_educativo = '{$nivel}'";

        return $this->db->query($query)->row('modalidad');
      }

    }// get_modalidad()

}// Sostenimiento_model
