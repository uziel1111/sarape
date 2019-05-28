<?php
class Planeaxescuela_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }


    function get_planea_xidcct($id_cct,$periodo){
      // echo "id_cct= ". $id_cct;

      $this->db->select('lyc_i, lyc_ii, lyc_iii, lyc_iv, mat_i, mat_ii, mat_iii, mat_iv');
      $this->db->from('planeaxescuela');
      $this->db->where('id_cct', $id_cct);
      $this->db->where('periodo', $periodo);
      $this->db->limit(1);//MODIFICACION LS para corregir error reportado LV comentar con ALEX
      return  $this->db->get()->result_array();

    }// get_planea_xidcct()

    function get_planeaarribai_xidcct($id_cct,$periodo){
      $str_query = "SELECT ROUND(lyc_ii+lyc_iii+lyc_iv,2) as lyc, ROUND(mat_ii+mat_iii+mat_iv,2) as mat
                          FROM planeaxescuela
                          WHERE id_cct = {$id_cct}  AND periodo = {$periodo}";
        return $this->db->query($str_query)->result_array();

    }// get_planea_xidcct()

}// Planeaxescuela_model
