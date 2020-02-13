<?php
class Riesgo_alumn_esc_bim_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->ce_db = $this->load->database('ce_db', TRUE);
    }

    function get_riesgo_pie_xidct($cct,$id_turno_single,$bimestre,$ciclo, $id_nivel){

      $nivel = ($id_nivel == 4)? "primaria":"secundaria";
      $str_query = "SELECT
      COUNT(curp) total,
      IFNULL(SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)), 0) as muy_alto,
      IFNULL(SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))=2,1,0)), 0) as alto,
      IFNULL(SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))=1,1,0)), 0) as medio,
      IFNULL(SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))=0,1,0)), 0) as bajo
      FROM alumnos_riesgo_{$nivel} WHERE cct='{$cct}' AND id_turno_single={$id_turno_single}  AND ciclo='".$ciclo."'
      ";

      $query = $this->db->query($str_query);
        return $query->result_array();

    }// get_riesgo_pie_xidct()

    function get_riesgo_bar_grados_xidct($cct,$id_turno_single,$bimestre,$ciclo, $id_nivel){

      $nivel = ($id_nivel == 4)? "primaria":"secundaria";
      $str_query = "SELECT cct,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE cct='".$cct."' AND id_turno_single={$id_turno_single} AND ciclo='".$ciclo."') as muyalto_t,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE cct='".$cct."' AND id_turno_single={$id_turno_single} AND ciclo='".$ciclo."' AND grado=1) as muyalto_1,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE cct='".$cct."' AND id_turno_single={$id_turno_single} AND ciclo='".$ciclo."' AND grado=2) as muyalto_2,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE cct='".$cct."' AND id_turno_single={$id_turno_single} AND ciclo='".$ciclo."' AND grado=3) as muyalto_3,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE cct='".$cct."' AND id_turno_single={$id_turno_single} AND ciclo='".$ciclo."' AND grado=4) as muyalto_4,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE cct='".$cct."' AND id_turno_single={$id_turno_single} AND ciclo='".$ciclo."' AND grado=5) as muyalto_5,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE cct='".$cct."' AND id_turno_single={$id_turno_single} AND ciclo='".$ciclo."' AND grado=6) as muyalto_6
      FROM alumnos_riesgo_{$nivel} WHERE cct='{$cct}' AND id_turno_single={$id_turno_single}   AND ciclo='".$ciclo."' GROUP BY cct
      ";

      $query = $this->db->query($str_query);
        return $query->result_array();

    }// get_riesgo_pie_xidct()

    function get_riesgo_pie_xidmuni($id_municipio,$id_nivel,$bimestre,$ciclo){
      $nivel = ($id_nivel == 4)? "primaria":"secundaria";
      $var_aux="";
      if ($id_municipio>0) {
        $var_aux="esc.municipio=".$id_municipio." AND";
      }

      $str_query = "SELECT
      COUNT(rie.curp) total,
      IFNULL(SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)), 0) as muy_alto,
      IFNULL(SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))=2,1,0)), 0) as alto,
      IFNULL(SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))=1,1,0)), 0) as medio,
      IFNULL(SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))=0,1,0)), 0) as bajo
      FROM sarape.alumnos_riesgo_{$nivel} rie
      INNER JOIN centros_educativos.vista_cct esc ON rie.cct = esc.cct AND (esc.status= 1 OR esc.status = 4) AND esc.tipo_centro=9
      WHERE ".$var_aux." esc.desc_nivel_educativo = '{$nivel}' AND rie.ciclo='".$ciclo."'";


      $query = $this->db->query($str_query);
        return $query->result_array();

    }// get_riesgo_pie_xidmuni()

    function get_riesgo_bar_grados_xidmuni($id_municipio,$id_nivel,$bimestre,$ciclo){

      $nivel = ($id_nivel == 4)? "primaria":"secundaria";

      if ($id_municipio>0) {

        $str_query1 = "
        SELECT esc.id_municipio,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
          FROM alumnos_riesgo_{$nivel} rie
          INNER JOIN (SELECT  CASE
                    WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
          WHERE esc.id_municipio={$id_municipio} AND esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}') as muyalto_t,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_municipio={$id_municipio} AND esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=1) as muyalto_1,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_municipio={$id_municipio} AND esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=2) as muyalto_2,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_municipio={$id_municipio} AND esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=3) as muyalto_3,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN  (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_municipio={$id_municipio} AND esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=4) as muyalto_4,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_municipio={$id_municipio} AND esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=5) as muyalto_5,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_municipio={$id_municipio} AND esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=6) as muyalto_6
        FROM sarape.alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_municipio={$id_municipio} AND esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' GROUP BY esc.id_municipio
        ";

        // echo $str_query1; die();
        $query = $this->db->query($str_query1);
      }
      else {
         $str_query1 = "
        SELECT esc.id_municipio,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}') as muyalto_t,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=1) as muyalto_1,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=2) as muyalto_2,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=3) as muyalto_3,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=4) as muyalto_4,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN  (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=5) as muyalto_5,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim{$bimestre}>7, 2,IF(rie.falta_bim{$bimestre}>3, 1,0))) + (IF(rie.espanol_b{$bimestre}<6 AND rie.espanol_b{$bimestre}>0,1,0)) + (IF(rie.matematicas_b{$bimestre}<6 and rie.matematicas_b{$bimestre}>0,1,0)))>2,1,0)) as muy_alto
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN  (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' AND rie.grado=6) as muyalto_6
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN (SELECT  CASE
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) esc ON rie.cct = esc.cct
        WHERE esc.id_nivel={$id_nivel} AND rie.ciclo='{$ciclo}' limit 1
        ";
        // echo $str_query1; die();
        $query = $this->db->query($str_query1);
      }

        return $query->result_array();

    }// get_riesgo_bar_grados_xidmuni()


    function get_numero_bajas($cct,$turno, $id_nivel, $bimestre){
      $nivel = ($id_nivel == 4)? "prima":"secu";
      $str_query = "SELECT COUNT(cct) total FROM sarape_bajas_y_motivos_{$nivel} WHERE cct = '{$cct}' AND id_turno_single={$turno} AND periodo_evaluacion = {$bimestre} AND motivo_abandono <> 'FALLECIMIENTO'" ;
      $query = $this->db->query($str_query);
      return $query->result_array();
    }

    function get_riesgo_totalb_xidmuni($id_municipio,$id_nivel, $id_bim){
      $nivel = ($id_nivel == 4)? "prima":"secu";
      $where = "";
      if($id_municipio != 0 ){
        $where = " AND e.id_municipio = {$id_municipio}";
      }
      $str_query = "SELECT COUNT(ab.cct) AS total FROM sarape_bajas_y_motivos_{$nivel} ab
                    INNER JOIN (SELECT  CASE
                              WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA'  THEN '10'
                  END AS id_nivel,municipio as id_municipio,cct
                  FROM centros_educativos.vista_cct) e ON ab.cct = e.cct
                    WHERE e.nivel_educativo = {$id_nivel} AND ab.periodo_evaluacion = {$id_bim} {$where} AND motivo_abandono <> 'FALLECIMIENTO'";

      $query = $this->db->query($str_query);

      return $query->result_array();
    }



}// Riesgo_alumn_esc_bim_model
