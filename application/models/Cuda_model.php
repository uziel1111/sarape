<?php
class Cuda_model extends CI_Model
{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->ci_db = $this->load->database('ci_db', TRUE);
	}	

	public function getEncuesta($idusuario)
	{
		$str_query = "SELECT * from aplicar a
		inner join respuesta r on r.idaplicar = a.idaplicar
		inner join usuario u on u.idusuario = a.idusuario
		where a.idusuario = {$idusuario} and r.idpregunta = 1;
		";
		return $this->ci_db->query($str_query)->result_array();
	}

	public function getObjetivos($idsubsecretria)
	{
		$str_query = "SELECT * from usuario where idusuario not in (1,2) and idsubsecretaria ={$idsubsecretria} ";

		return $this->ci_db->query($str_query)->result_array();
	}

	public function getDetalles($idaplicar)
	{

		$str_query = "SELECT r.respuesta, r.url_comple, p.pregunta, r.idaplicar, r.complemento from respuesta r 
		INNER JOIN pregunta p on p.idpregunta = r.idpregunta
		where r.idaplicar = {$idaplicar}; ";

		return $this->ci_db->query($str_query)->result_array();
	}
	public function getDocumentoDescarga($idaplicar)
	{
		$str_query = "SELECT r.url_comple from respuesta r 
		where r.idaplicar = {$idaplicar} and r.url_comple is not null; ";

		return $this->ci_db->query($str_query)->result_array();
	}

	public function getContacto($idusuario)
	{
		$str_query = "SELECT * from usuario where idusuario = {$idusuario} ";

		return $this->ci_db->query($str_query)->result_array();
	}

	public function getEstadisticaUsuario($idusuario)
	{
		$str_query = "SELECT count(a.idaplicar) as encuentasUsuario from aplicar a
		inner join usuario u on u.idusuario = a.idusuario
		where u.idusuario = {$idusuario};";

		return $this->ci_db->query($str_query)->result_array();
	}
	public function getEstadisticaGeneral($idsubsecretaria)
	{
		$str_query = "SELECT count(a.idaplicar) as total from aplicar a
		inner join usuario u on u.idusuario = a.idusuario
		where u.idsubsecretaria = {$idsubsecretaria};";

		return $this->ci_db->query($str_query)->result_array();
	}

}// Cuda_model class
