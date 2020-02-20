<?php
class Inegixmuni_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_rezago_xmunciclo($id_municipio, $id_ciclo){

        $this->db->select('SUM(P_3A5_M) as P_3A5_M,SUM(P_3A5_F) as P_3A5_F,SUM(P_6A11_M) as P_6A11_M,SUM(P_6A11_F) as P_6A11_F,SUM(P_12A14_M) as P_12A14_M,SUM(P_12A14_F) as P_12A14_F,SUM(P_15A17_M) as P_15A17_M,SUM(P_15A17_F) as P_15A17_F,SUM(P_18A24_M) as P_18A24_M,SUM(P_18A24_F) as P_18A24_F,
  SUM(P3A5_NOA_M) as P3A5_NOA_M,SUM(P3A5_NOA_F) as P3A5_NOA_F,SUM(P6A11_NOAM) as P6A11_NOAM,SUM(P6A11_NOAF) as P6A11_NOAF,SUM(P12A14NOAM) as P12A14NOAM,SUM(P12A14NOAF) as P12A14NOAF,SUM(P15A17A_M) as P15A17A_M,SUM(P15A17A_F) as P15A17A_F,SUM(P18A24A_M) as P18A24A_M,SUM(P18A24A_F) as P18A24A_F');
        $this->db->from('inegixmuni');
        if($id_municipio>0){
          $this->db->where('id_muni', $id_municipio);
        }
      $this->db->where('periodo', $id_ciclo);
      return  $this->db->get()->result_array();

    }// get_rezago_xmunciclo



    function get_analf_xmunciclo($id_municipio, $id_ciclo){

        $this->db->select('SUM(P8A14AN_M) as P8A14AN_M,SUM(P8A14AN_F) as P8A14AN_F,
  SUM(P15YM_AN_M) as P15YM_AN_M,SUM(P15YM_AN_F) as P15YM_AN_F');
        $this->db->from('inegixmuni');
        if($id_municipio>0){
          $this->db->where('id_muni', $id_municipio);
        }
      $this->db->where('periodo', $id_ciclo);
      return  $this->db->get()->result_array();

    }// get_analf_xmunciclo

    function get_ciclo_inegi($id_ciclo){
      $query="SELECT periodo_inegi FROM relacion_ciclo WHERE id_ciclo_est={$id_ciclo}";
      return $this->db->query($query)->row('periodo_inegi');
    }// get_ciclo_inegi


}// Inegixmuni_model
