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
		// $str_query = "SELECT respuesta, idaplicar, sostenimiento, nombre, paterno, materno, area_departamento, ntelefono, email from cuda
		// where idusuario = {$idusuario} and idpregunta = 1 and estatus = 1 order by respuesta ASC;";
		$str_query = "SELECT * from aplicar a
		inner join respuesta r on r.idaplicar = a.idaplicar
		inner join usuario u on u.idusuario = a.idusuario
		where a.idusuario = {$idusuario} and r.idpregunta = 1  and a.estatus = 1;
		";
		// return $this->db->query($str_query)->result_array();
		return $this->ci_db->query($str_query)->result_array();
	}

	public function getObjetivos($idsubsecretria)
	{
		// $str_query = "SELECT idusuario, idsubsecretaria,direccion from cuda
		// where idsubsecretaria = {$idsubsecretria} and estatus = 1 and idusuario <> 12 group by idusuario;";
		$str_query = "SELECT u.* from usuario u
		inner join aplicar a on a.idusuario = u.idusuario
		where u.idsubsecretaria ={$idsubsecretria}  and a.estatus = 1 and a.idusuario <> 12 group by a.idusuario;";

		// return $this->db->query($str_query)->result_array();
		return $this->ci_db->query($str_query)->result_array();
	}

	public function getDetalles($idaplicar)
	{

		// $str_query = "SELECT respuesta, url_comple, pregunta, idaplicar, GROUP_CONCAT(complemento) AS complemento,
		// idpregunta, otroResponsable, responsableDocumento, tema, sostenimiento, direccion, idusuario
		// FROM cuda WHERE idaplicar = {$idaplicar} GROUP BY idpregunta;";
		$str_query = "SELECT r.respuesta, r.url_comple, p.pregunta, r.idaplicar, group_concat(r.complemento) as complemento, r.idpregunta, a.otroResponsable, a.responsableDocumento, a.tema, a.sostenimiento, u.direccion, u.idusuario from respuesta r
		left JOIN pregunta p on p.idpregunta = r.idpregunta
		INNER JOIN aplicar a on a.idaplicar = r.idaplicar
        INNER JOIN usuario u on a.idusuario = u.idusuario
		where r.idaplicar = {$idaplicar}  and a.estatus = 1
		group by r.idpregunta";
		// echo "<pre>";print_r($str_query);die();
		// return $this->db->query($str_query)->result_array();
		return $this->ci_db->query($str_query)->result_array();
	}
	public function getDocumentoDescarga($idaplicar)
	{
		// $str_query = "SELECT url_comple from cuda
		// where idaplicar = {$idaplicar} and url_comple is not null limit 1; ";
		$str_query = "SELECT r.url_comple from respuesta r
		where r.idaplicar = {$idaplicar} and r.url_comple is not null; ";

		// return $this->db->query($str_query)->result_array();
		return $this->ci_db->query($str_query)->result_array();
	}

	public function getContacto($idusuario)
	{
		// $str_query = "SELECT idusuario, nombre, paterno, materno, area_departamento, ntelefono, email
		// from cuda where idusuario = {$idusuario} limit 1;";
		$str_query = "SELECT * from usuario where idusuario = {$idusuario} ";

		// return $this->db->query($str_query)->result_array();
		return $this->ci_db->query($str_query)->result_array();
	}

	public function getEstadisticaUsuario($idusuario)
	{
		// $str_query = "SELECT count(idaplicar) as encuestasUsuario from cuda
		// where idusuario = {$idusuario} and estatus = 1 and idpregunta = 1;";
		$str_query = "SELECT count(a.idaplicar) as encuestasUsuario from aplicar a
		inner join usuario u on u.idusuario = a.idusuario
		where u.idusuario = {$idusuario} and a.estatus = 1;";

		// return $this->db->query($str_query)->result_array();
		return $this->ci_db->query($str_query)->result_array();
	}
	public function getEstadisticaGeneral($idsubsecretaria)
	{
		// $str_query = "SELECT count(idaplicar) as total from cuda
		// where idsubsecretaria = {$idsubsecretaria} and estatus = 1 and idpregunta = 1;";
		$str_query = "SELECT count(a.idaplicar) as total from aplicar a
		inner join usuario u on u.idusuario = a.idusuario
		where u.idsubsecretaria = {$idsubsecretaria} and a.estatus = 1;";

		// return $this->db->query($str_query)->result_array();
		return $this->ci_db->query($str_query)->result_array();
	}

	public function getEstadisticaGlobal()
	{
		// $str_query = "SELECT count(idaplicar) as global from cuda where estatus = 1  and idpregunta = 1;";
		$str_query = "SELECT count(a.idaplicar) as global from aplicar a where a.estatus = 1";

		// return $this->db->query($str_query)->result_array();
		return $this->ci_db->query($str_query)->result_array();
	}

	public function idEncuestaNivel($nivel,$mes)
	{

		$querynivel = "SELECT tema, idaplicar from cuda
		where estatus = 1 and complemento ='{$nivel}'";

		$querymes = "SELECT tema, idaplicar from cuda
		where complemento ='{$mes}'  and estatus = 1";

		$querynivelmes = "SELECT * from ({$querynivel}) as nivel
		inner join ({$querymes}) as mes on nivel.idaplicar = mes.idaplicar";

		if ($nivel != 'No' && $mes == 'No') {

			return $this->db->query($querynivel)->result_array();
		}else {
			if ($nivel == 'No' && $mes != 'No') {

				return $this->db->query($querymes)->result_array();
			} else {

				if ($nivel != 'No' && $mes != 'No') {

					return $this->db->query($querynivelmes)->result_array();
				}
			}
		}


	}

	public function getFormatoTema($tema, $nivel)
	{
		// $str_query = "SELECT * from cuda
		// where tema = {$tema} and complemento = '{$nivel}'  and estatus = 1";
		$str_query = "SELECT * from aplicar a
		inner join respuesta r on r.idaplicar = a.idaplicar
		where a.tema = {$tema} and r.complemento = '{$nivel}'  and a.estatus = 1;";

		// return $this->db->query($str_query)->result_array();
		return $this->ci_db->query($str_query)->result_array();

	}

	public function getFormatoTemaMes($idaplicar, $mes)
	{
		// $str_query= "SELECT idaplicar from cuda
		// where idaplicar = {$idaplicar} and complemento = '{$mes}' and estatus = 1 ;";
		$str_query= "SELECT r.idaplicar from respuesta r
		where r.idaplicar = {$idaplicar} and r.complemento = '{$mes}';";

		// return $this->db->query($str_query)->result_array();

	return $this->ci_db->query($str_query)->result_array();
	}

	public function EncuestaNivel($idaplicar)
	{
		$str_query = "SELECT * from respuesta where idaplicar = {$idaplicar};";
		return $this->ci_db->query($str_query)->result_array();
	}

}// Cuda_model class
