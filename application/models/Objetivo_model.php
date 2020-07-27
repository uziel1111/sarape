<?php
class Objetivo_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->pemc_db = $this->load->database('pemc_db', TRUE);
        $this->load->helper('date');
    }

    function get_objetivos_x_idpemc($idpemc){
    	$str_query = "SELECT obj.*, COUNT(acc.idaccion) AS num_acciones FROM r_pemc_objetivo obj
        LEFT JOIN r_pemc_objetivo_accion acc ON acc.idobjetivo = obj.idobjetivo
        WHERE idpemc = ?
        GROUP BY obj.idobjetivo
        ORDER BY obj.idobjetivo ASC";
    	return $this->pemc_db->query($str_query, array($idpemc))->result_array();
    }

    function update_orden_objetivos($idobjetivo, $idpemc, $orden){
        $data = array(
            'orden' => $orden,
        );
        $where = array(
            'idobjetivo'=> $idobjetivo,
            'idpemc'=> $idpemc
        );
        $this->pemc_db->where($where);
        return $this->pemc_db->update('r_pemc_objetivo', $data);
    }

    function delete_accion($idaccion, $idobjetivo){
        $this->pemc_db->trans_start();
            $delete_seguimiento = "DELETE FROM r_pemc_accion_seguimiento WHERE idaccion ={$idaccion}";
        $this->pemc_db->query($delete_seguimiento);
        $delete_acciones = "DELETE FROM r_pemc_objetivo_accion WHERE idaccion = {$idaccion} AND idobjetivo = {$idobjetivo}";
        $this->pemc_db->query($delete_acciones);
        return $this->pemc_db->trans_complete();
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
		    'objetivo' => UPPER($objetivo),
		    'meta' => UPPER($meta),
		    'comentario_general' => UPPER($comentarios),
		    'fcreacion' => date('Y-m-d')
		);
		return $this->pemc_db->insert('r_pemc_objetivo', $data);
    }// get_prioridades()

    function update_objetivo($idpemc, $text_objetivo_c, $text_meta_c, $text_comentariosG_c, $idobjetivo){
    	$data = array(
		    'objetivo' => UPPER($text_objetivo_c),
		    'meta' => UPPER($text_meta_c),
		    'comentario_general' => UPPER($text_comentariosG_c),
		    'fmodificacion' => date('Y-m-d')
		);
		$where = array(
		    'idobjetivo'=> $idobjetivo,
		    'idpemc'=> $idpemc
		);
		$this->pemc_db->where($where);
		return $this->pemc_db->update('r_pemc_objetivo', $data);
    }

    function delete_linea_objetivo($idsacciones, $idobjetivo, $idpemc){
    	$this->pemc_db->trans_start();
    	// echo"Acciones: ". $idsacciones; die();
    	if($idsacciones != ''){
    		$delete_seguimiento = "DELETE FROM r_pemc_accion_seguimiento WHERE idaccion IN({$idsacciones})";
		$this->pemc_db->query($delete_seguimiento);
		$delete_acciones = "DELETE FROM r_pemc_objetivo_accion WHERE idaccion IN({$idsacciones}) AND idobjetivo = {$idobjetivo}";
		$this->pemc_db->query($delete_acciones);
    	}

		$delete_objetivo = "DELETE FROM r_pemc_objetivo WHERE idobjetivo = {$idobjetivo} AND idpemc = {$idpemc}";
		$this->pemc_db->query($delete_objetivo);


		return $this->pemc_db->trans_complete();

    }

    function get_acciones_x_idobjetivo($idobjetivo){
    	$str_query = "SELECT * FROM r_pemc_objetivo_accion WHERE idobjetivo = ? ORDER BY idaccion ASC";
    	return $this->pemc_db->query($str_query, array($idobjetivo))->result_array();
    }

    function update_accion($idaccion, $idobjetivo, $accion, $recurso, $ambitos, $responsables, $otro_responsable, $finicio, $ffin){
    	// echo $responsables;
    	// die();
    	$str_query = "UPDATE r_pemc_objetivo_accion
					SET accion = UPPER(?), recurso = UPPER(?), idambitos = ?, responsables= ?, otros_responsables = UPPER(?), finicio = ?, ffin = ?, fmodificacion = NOW()
					WHERE idaccion = ? AND idobjetivo = ?";
		return $this->pemc_db->query($str_query, array($accion, $recurso, $ambitos, $responsables, $otro_responsable, $finicio, $ffin, $idaccion, $idobjetivo));
    }

    function update_orden_accion($idaccion, $idobjetivo, $orden){
        $str_query = "UPDATE r_pemc_objetivo_accion
                    SET orden = ?
                    WHERE idaccion = ? AND idobjetivo = ?";
        return $this->pemc_db->query($str_query, array($orden, $idaccion, $idobjetivo));
    }

    function insert_accion($idobjetivo, $orden, $accion, $recurso, $cad_ambitos, $cad_responsables, $otro_responsable, $finicio, $ffin){
    	$norden = (int)$orden + 1;
    	$data = array(
			'idobjetivo' => $idobjetivo,
		    'orden' => $norden,
		    'accion' => UPPER($accion),
		    'recurso' => UPPER($recurso),
		    'idambitos' => $cad_ambitos,
		    'responsables' => $cad_responsables,
		    'otros_responsables' => UPPER($otro_responsable),
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

    		case '2':
    			$campo = "url_evidencia_despues";
    			break;
    	}
    	$data = array(
		        $campo => $ruta,
		        'fmodificacion' => date('Y-m-d')
		);

		$this->pemc_db->where('idobjetivo', $idobjetivo);
		return $this->pemc_db->update('r_pemc_objetivo', $data);
    }

    function get_url($idobjetivo, $tipo_evidencia){
        switch ($tipo_evidencia) {
            case '1':
                $campo = "url_evidencia_antes";
                break;

            case '2':
                $campo = "url_evidencia_despues";
                break;
        }
        $str_query = "SELECT {$campo} AS url FROM r_pemc_objetivo WHERE idobjetivo = ?";
        return $this->pemc_db->query($str_query, array($idobjetivo))->row();
    }

}// Objetivo_model
