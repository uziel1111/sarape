<?php
class Propuestas_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }


    function inserta_url($idreactivo, $url, $idtipo, $titulo, $fuente){
    	date_default_timezone_set('America/Mexico_City');
    	$fecha= date("Y-m-d H:i:s");
    	$data = array(
		        'id_reactivo' => $idreactivo,
		        'idtipo' => $idtipo,
		        'ruta' => $url,
		        'fcreacion' => $fecha,
		        'titulo' => $titulo,
		        'fuente' => $fuente
		);

		return $this->db->insert('prop_mapoyo', $data);
    }

    function n_propxreact($idreactivo){
      $this->db->select('COUNT(id_reactivo) as n_prop');
      $this->db->from('prop_mapoyo');
      $this->db->where('id_reactivo', $idreactivo);

      return  $this->db->get()->row()->n_prop;
}

}// Propuestas_model
