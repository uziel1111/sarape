<?php
class Prog_apoyo_xcct_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_prog_apoyo_xcct($cct,$turno){
      // echo $turno."\n";
      // die();
     
      $str_query = "SELECT (@cnt := @cnt + 1) AS rowNumber,
          t2.descripcion, t2.programa_apoyo, t3.ciclo
          FROM prog_apoyo_xcct t1
          CROSS JOIN (SELECT @cnt := 0) AS dummy
          INNER JOIN programa_apoyo t2 ON t1.id_prog_apoyo =t2.id_programa_apoyo
          INNER JOIN ciclo t3 ON t1.id_ciclo = t3.id_ciclo
          WHERE  t1.id_turno_single={$turno} ";
          // echo $str_query; die();
        return $this->db->query($str_query)->result_array();
    }// get_prog_apoyo_xcct()

    function get_prog_apoyo_xcctxciclo($id_cct ,$id_ciclo){
      $str_query = "SELECT
          t2.id_programa_apoyo, t2.descripcion
          FROM prog_apoyo_xcct t1
          INNER JOIN programa_apoyo t2 ON t1.id_prog_apoyo =t2.id_programa_apoyo
          INNER JOIN ciclo t3 ON t1.id_ciclo = t3.id_ciclo
          WHERE t1.id_ciclo={$id_ciclo}";
          // echo $str_query; die();
        return $this->db->query($str_query)->result_array();
    }// get_prog_apoyo_xcct()


}// Prog_apoyo_xcct_model
