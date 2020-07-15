<?php
class Objetivo_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->pemc_db = $this->load->database('pemc_db', TRUE);
        $this->load->helper('date');
    }

    function get_objetivos_x_idpemc($idpemc){
    	$str_query = "SELECT obj.*, COUNT(acc.idaccion) AS num_acciones FROM r_pemc_objetivo obj
LEFT JOIN r_pemc_objetivo_accion acc ON acc.idobjetivo = obj.idobjetivo
WHERE idpemc = ?
GROUP BY obj.idobjetivo";
    	return $this->pemc_db->query($str_query, array($idpemc))->result_array();
    }

    function get_ambitos(){
    	$str_query = "SELECT * FROM c_pemc_ambito";
    	return $this->pemc_db->query($str_query)->result_array();
    }

    function get_objetivo_x_idobjetivo($idobjetivo){
    	$str_query = "SELECT * FROM r_pemc_objetivo WHERE idobjetivo = ?";
    	return $this->pemc_db->query($str_query, array($idobjetivo))->row();
    }

    function save_objetivo($idpemc, $objetivo, $meta, $comentarios, $orden){
    	$norden = (int)$orden + 1;
    	$data = array(
			'idpemc' => $idpemc,
		    'orden' => $norden,
		    'objetivo' => $objetivo,
		    'meta' => $meta,
		    'comentario_general' => $comentarios,
		    'fcreacion' => date('Y-m-d')
		);
		return $this->pemc_db->insert('r_pemc_objetivo', $data);
    }// get_prioridades()

    function get_acciones_x_idobjetivo($idobjetivo){
    	$str_query = "SELECT * FROM r_pemc_objetivo_accion WHERE idobjetivo = ?";
    	return $this->pemc_db->query($str_query, array($idobjetivo))->result_array();
    }

    function update_accion($idaccion, $idobjetivo, $accion, $recurso, $ambitos, $responsables, $otro_responsable, $finicio, $ffin){
    	// echo $responsables;
    	// die();
    	$str_query = "UPDATE r_pemc_objetivo_accion 
					SET accion = ?, recurso = ?, idambitos = ?, responsables= ?, otros_responsables = ?, finicio = ?, ffin = ?, fmodificacion = NOW()
					WHERE idaccion = ? AND idobjetivo = ?";
		return $this->pemc_db->query($str_query, array($accion, $recurso, $ambitos, $responsables, $otro_responsable, $finicio, $ffin, $idaccion, $idobjetivo));
    }

    function insert_accion($idobjetivo, $orden, $accion, $recurso, $cad_ambitos, $cad_responsables, $otro_responsable, $finicio, $ffin){
    	$norden = (int)$orden + 1;
    	$data = array(
			'idobjetivo' => $idobjetivo,
		    'orden' => $norden,
		    'accion' => $accion,
		    'recurso' => $recurso,
		    'idambitos' => $cad_ambitos,
		    'responsables' => $cad_responsables,
		    'otros_responsables' => $otro_responsable,
		    'finicio' => $finicio,
		    'ffin' => $ffin,
		    'fcreacion' => date('Y-m-d')
		);
		return $this->pemc_db->insert('r_pemc_objetivo_accion', $data);
    }

    function inserta_ruta($idobjetivo, $ruta, $tipo_evidencia){
    	switch ($tipo_evidencia) {
    		case '1':
    			$campo = "url_evidencia_antes";
    			break;
    		
    		case '1':
    			$campo = "url_evidencia_antes";
    			break;
    	}
    	$data = array(
		        $campo => $ruta,
		        'fmodificacion' => date('Y-m-d')
		);

		$this->pemc_db->where('idobjetivo', $idobjetivo);
		return $this->pemc_db->update('r_pemc_objetivo', $data);
    }

}// Objetivo_model
