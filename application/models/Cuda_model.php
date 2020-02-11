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
		$str_query = "SELECT respuesta, idaplicar, sostenimiento, nombre, paterno, materno, area_departamento, ntelefono, email from cuda
		where idusuario = {$idusuario} and idpregunta = 1 and estatus = 1 order by respuesta ASC;";
		
		return $this->db->query($str_query)->result_array();
	}

	public function getObjetivos($idsubsecretria)
	{
		$str_query = "SELECT idusuario, idsubsecretaria,direccion from cuda
		where idsubsecretaria = {$idsubsecretria} and estatus = 1 and idusuario <> 12 group by idusuario;";

		return $this->db->query($str_query)->result_array();
	}

	public function getDetalles($idaplicar)
	{

		$str_query = "SELECT respuesta, url_comple, pregunta, idaplicar, GROUP_CONCAT(complemento) AS complemento, 
		idpregunta, otroResponsable, responsableDocumento, tema, sostenimiento, direccion, idusuario 
		FROM cuda WHERE idaplicar = {$idaplicar} GROUP BY idpregunta;";

		return $this->db->query($str_query)->result_array();
	}
	public function getDocumentoDescarga($idaplicar)
	{
		$str_query = "SELECT url_comple from cuda
		where idaplicar = {$idaplicar} and url_comple is not null; ";

		return $this->db->query($str_query)->result_array();
	}

	public function getContacto($idusuario)
	{
		$str_query = "SELECT idusuario, nombre, paterno, materno, area_departamento, ntelefono, email 
		from cuda where idusuario = {$idusuario} limit 1;";

		return $this->db->query($str_query)->result_array();
	}

	public function getEstadisticaUsuario($idusuario)
	{
		$str_query = "SELECT count(idaplicar) as encuestasUsuario from cuda
		where idusuario = {$idusuario} and estatus = 1 and idpregunta = 1;";

		return $this->db->query($str_query)->result_array();
	}
	public function getEstadisticaGeneral($idsubsecretaria)
	{
		$str_query = "SELECT count(idaplicar) as total from cuda
		where u.idsubsecretaria = {$idsubsecretaria} and estatus = 1 and idpregunta = 1;";

		return $this->db->query($str_query)->result_array();
	}

	public function getEstadisticaGlobal()
	{
		$str_query = "SELECT count(idaplicar) as global from cuda where estatus = 1  and idpregunta = 1;";

		return $this->db->query($str_query)->result_array();
	}

	public function idEncuestaNivel($nivel,$mes)
	{
		
		$querynivel = "SELECT a.tema, r.idaplicar from respuesta r
		inner join aplicar a on a.idaplicar = r.idaplicar
		where a.estatus = 1 and r.complemento ='{$nivel}'";

		$querymes = "SELECT a.tema, r.idaplicar from respuesta r
		inner join aplicar a on a.idaplicar = r.idaplicar
		where r.complemento ='{$mes}'  and a.estatus = 1";

		$querynivelmes = "SELECT * from ({$querynivel}) as nivel
		inner join ({$querymes}) as mes on nivel.idaplicar = mes.idaplicar";

		if ($nivel != 'No' && $mes == 'No') {
			
			return $this->ci_db->query($querynivel)->result_array();	
		}else {
			if ($nivel == 'No' && $mes != 'No') {
				
				return $this->ci_db->query($querymes)->result_array();	
			} else {

				if ($nivel != 'No' && $mes != 'No') {
					
					return $this->ci_db->query($querynivelmes)->result_array();	
				}
			}
		}

		
	}

	/*public function EncuestaNivel($idaplicar)
	{
		$str_query = "SELECT * from respuesta where idaplicar = {$idaplicar};";
		return $this->ci_db->query($str_query)->result_array();
	}*/

	public function getFormatoTema($tema, $nivel)
	{
		$str_query = "SELECT * from cuda
		where tema = {$tema} and complemento = '{$nivel}'  and estatus = 1 ";
		
		return $this->db->query($str_query)->result_array();

	}

	public function getFormatoTemaMes($idaplicar, $mes)
	{
		$str_query= "SELECT idaplicar from cuda 
		where idaplicar = {$idaplicar} and complemento = '{$mes}' ;";

		return $this->db->query($str_query)->result_array();
	}


}// Cuda_model class