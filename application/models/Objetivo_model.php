<?php
class Objetivo_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->pemc_db = $this->load->database('pemc_db', TRUE);
        $this->load->helper('date');
    }

    function get_objetivos_x_idpemc($idpemc){
    	$str_query = "SELECT * FROM r_pemc_objetivo WHERE idpemc = ?";
    	return $this->pemc_db->query($str_query, array($idpemc))->result_array();
    }

    function save_objetivo($idpemc, $objetivo, $meta, $comentarios, $orden){
    	$norden = (int)$orden + 1;
    	$data = array(
			'idpemc' => $idpemc,
		    'orden' => $norden,
		    'objetivo' => $objetivo,
		    'meta' => $meta,
		    'comentario_general' => $comentarios,
		    'fcreacion' => NOW()
		);
		return $this->pemc_db->insert('r_pemc_objetivo', $data);
    }// get_prioridades()

}// Objetivo_model
