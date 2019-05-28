<?php
class Riesgo_alumn_esc_bim_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_riesgo_pie_xidct($id_cct,$bimestre,$ciclo, $id_nivel){
      // return  $this->db->get('nivel')->result_array();
      $nivel = ($id_nivel == 4)? "primaria":"secundaria";
      $str_query = "SELECT
      COUNT(curp) total,
      IFNULL(SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)), 0) as muy_alto,
      IFNULL(SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))=2,1,0)), 0) as alto,
      IFNULL(SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))=1,1,0)), 0) as medio,
      IFNULL(SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))=0,1,0)), 0) as bajo
      FROM alumnos_riesgo_{$nivel} WHERE id_cct=".$id_cct." AND ciclo='".$ciclo."'
      ";
      // echo $str_query; die();
      $query = $this->db->query($str_query);
        return $query->result_array();

    }// get_riesgo_pie_xidct()

    function get_riesgo_bar_grados_xidct($id_cct,$bimestre,$ciclo, $id_nivel){
      // return  $this->db->get('nivel')->result_array();
      $nivel = ($id_nivel == 4)? "primaria":"secundaria";
      $str_query = "SELECT id_cct,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE id_cct=".$id_cct." AND ciclo='".$ciclo."') as muyalto_t,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE id_cct=".$id_cct." AND ciclo='".$ciclo."' AND grado=1) as muyalto_1,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE id_cct=".$id_cct." AND ciclo='".$ciclo."' AND grado=2) as muyalto_2,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE id_cct=".$id_cct." AND ciclo='".$ciclo."' AND grado=3) as muyalto_3,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE id_cct=".$id_cct." AND ciclo='".$ciclo."' AND grado=4) as muyalto_4,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE id_cct=".$id_cct." AND ciclo='".$ciclo."' AND grado=5) as muyalto_5,
      (SELECT SUM(IF(((IF(extraedad>1,1,0)) + (IF(falta_bim".$bimestre.">7, 2,IF(falta_bim".$bimestre.">3, 1,0))) + (IF(espanol_b".$bimestre."<6 AND espanol_b".$bimestre.">0,1,0)) + (IF(matematicas_b".$bimestre."<6 and matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} WHERE id_cct=".$id_cct." AND ciclo='".$ciclo."' AND grado=6) as muyalto_6
      FROM alumnos_riesgo_{$nivel} WHERE id_cct=".$id_cct." AND ciclo='".$ciclo."' GROUP BY id_cct
      ";
      // echo $str_query; die();
      $query = $this->db->query($str_query);
        return $query->result_array();

    }// get_riesgo_pie_xidct()

    function get_riesgo_pie_xidmuni($id_municipio,$id_nivel,$bimestre,$ciclo){
      $nivel = ($id_nivel == 4)? "primaria":"secundaria";
      $var_aux="";
      if ($id_municipio>0) {
        $var_aux="esc.id_municipio=".$id_municipio." AND";
      }

      $str_query = "SELECT
      COUNT(rie.curp) total,
      IFNULL(SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)), 0) as muy_alto,
      IFNULL(SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))=2,1,0)), 0) as alto,
      IFNULL(SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))=1,1,0)), 0) as medio,
      IFNULL(SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))=0,1,0)), 0) as bajo
      FROM alumnos_riesgo_{$nivel} rie
      INNER JOIN escuela esc ON rie.id_cct = esc.id_cct
      WHERE ".$var_aux." esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."'
      ";

      $query = $this->db->query($str_query);
        return $query->result_array();

    }// get_riesgo_pie_xidmuni()

    function get_riesgo_bar_grados_xidmuni($id_municipio,$id_nivel,$bimestre,$ciclo){
      // return  $this->db->get('nivel')->result_array();
      $nivel = ($id_nivel == 4)? "primaria":"secundaria";

      if ($id_municipio>0) {
        $str_query1 = "
        SELECT esc.id_municipio,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_municipio=".$id_municipio." AND esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."') as muyalto_t,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_municipio=".$id_municipio." AND esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=1) as muyalto_1,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_municipio=".$id_municipio." AND esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=2) as muyalto_2,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_municipio=".$id_municipio." AND esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=3) as muyalto_3,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_municipio=".$id_municipio." AND esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=4) as muyalto_4,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_municipio=".$id_municipio." AND esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=5) as muyalto_5,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_municipio=".$id_municipio." AND esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=6) as muyalto_6
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN escuela esc ON rie.id_cct = esc.id_cct
        WHERE esc.id_municipio=".$id_municipio." AND esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' GROUP BY esc.id_municipio
        ";
        // echo "municipio...";
        // echo $str_query1; die();
        $query = $this->db->query($str_query1);
      }
      else {
        $str_query1 = "
        SELECT esc.id_municipio,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."') as muyalto_t,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=1) as muyalto_1,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=2) as muyalto_2,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=3) as muyalto_3,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=4) as muyalto_4,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=5) as muyalto_5,
        (SELECT SUM(IF(((IF(rie.extraedad>1,1,0)) + (IF(rie.falta_bim".$bimestre.">7, 2,IF(rie.falta_bim".$bimestre.">3, 1,0))) + (IF(rie.espanol_b".$bimestre."<6 AND rie.espanol_b".$bimestre.">0,1,0)) + (IF(rie.matematicas_b".$bimestre."<6 and rie.matematicas_b".$bimestre.">0,1,0)))>2,1,0)) as muy_alto FROM alumnos_riesgo_{$nivel} rie INNER JOIN escuela esc ON rie.id_cct = esc.id_cct WHERE esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' AND rie.grado=6) as muyalto_6
        FROM alumnos_riesgo_{$nivel} rie
        INNER JOIN escuela esc ON rie.id_cct = esc.id_cct
        WHERE esc.id_nivel=".$id_nivel." AND rie.ciclo='".$ciclo."' limit 1
        ";
        // echo "estado...";
        // echo $str_query1; die();
        $query = $this->db->query($str_query1);
      }

        return $query->result_array();

    }// get_riesgo_bar_grados_xidmuni()


    function get_numero_bajas($id_cct, $id_nivel, $bimestre){
      $nivel = ($id_nivel == 4)? "primaria":"secundaria";
      $str_query = "SELECT COUNT(id_cct) total FROM alumnos_bajas_{$nivel} WHERE id_cct = {$id_cct} AND bimestre = {$bimestre}" ;
      $query = $this->db->query($str_query);
      return $query->result_array();
    }

    function get_riesgo_totalb_xidmuni($id_municipio,$id_nivel, $id_bim){
      $nivel = ($id_nivel == 4)? "primaria":"secundaria";
      $where = "";
      if($id_municipio != 0 ){
        $where = " AND e.id_municipio = {$id_municipio}";
      }
      $str_query = "SELECT COUNT(ab.id_cct) AS total FROM alumnos_bajas_{$nivel} ab
                    INNER JOIN escuela e ON e.id_cct = ab.id_cct
                    WHERE e.id_nivel = {$id_nivel} AND ab.bimestre = {$id_bim} {$where}";
                    // echo $str_query; die();
      $query = $this->db->query($str_query);

      return $query->result_array();
    }



}// Riesgo_alumn_esc_bim_model
