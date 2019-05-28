<?php
class Planea_nacionalxnivel_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }


    function get_planea_xnac($nivel,$periodo){

      $this->db->select('lyc_i, lyc_ii, lyc_iii, lyc_iv, mat_i, mat_ii, mat_iii, mat_iv');
      $this->db->from('planea_nacionalxnivel');
      $this->db->where('nivel', $nivel);
      $this->db->where('periodo', $periodo);
      return  $this->db->get()->result_array();

    }// get_planea_xnac()

}// Planea_nacionalxnivel_model
