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
		where a.idusuario = {$idusuario} and r.idpregunta = 1  and a.estatus = 1;
		";

		return $this->ci_db->query($str_query)->result_array();
	}

	public function getObjetivos($idsubsecretria)
	{
		$str_query = "SELECT u.* from usuario u
		inner join aplicar a on a.idusuario = u.idusuario
		where u.idsubsecretaria ={$idsubsecretria}  and a.estatus = 1 and a.idusuario <> 12 group by a.idusuario;";
		
		return $this->ci_db->query($str_query)->result_array();
	}

	public function getDetalles($idaplicar)
	{

		$str_query = "SELECT r.respuesta, r.url_comple, p.pregunta, r.idaplicar, group_concat(r.complemento) as complemento, r.idpregunta, a.otroResponsable, a.responsableDocumento, a.tema, a.sostenimiento, u.direccion, u.idusuario from respuesta r 
		LEFT JOIN pregunta p on p.idpregunta = r.idpregunta
		INNER JOIN aplicar a on a.idaplicar = r.idaplicar
        INNER JOIN usuario u on a.idusuario = u.idusuario
		where r.idaplicar = {$idaplicar}  and a.estatus = 1
		group by r.idpregunta;";

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
		$str_query = "SELECT count(a.idaplicar) as encuestasUsuario from aplicar a
		inner join usuario u on u.idusuario = a.idusuario
		where u.idusuario = {$idusuario} and a.estatus = 1;";
		
		return $this->ci_db->query($str_query)->result_array();
	}
	public function getEstadisticaGeneral($idsubsecretaria)
	{
		$str_query = "SELECT count(a.idaplicar) as total from aplicar a
		inner join usuario u on u.idusuario = a.idusuario
		where u.idsubsecretaria = {$idsubsecretaria} and a.estatus = 1;";
		
		return $this->ci_db->query($str_query)->result_array();
	}

	public function getEstadisticaGlobal()
	{
		$str_query = "SELECT count(a.idaplicar) as global from aplicar a where a.estatus = 1";
		
		return $this->ci_db->query($str_query)->result_array();
	}

	public function idEncuestaNivel($nivel,$mes)
	{
			$querynivel = "SELECT 
			a.tema, COUNT(a.tema) AS total_tema,
			CASE  
			WHEN a.tema ='0'  THEN 'Sin tema asignado'
			WHEN a.tema ='1'  THEN 'Administración de Personal'
			WHEN a.tema ='2' THEN 'Participación Social'
			WHEN a.tema ='3' THEN 'Gestión Escolar'
			WHEN a.tema ='4' THEN 'Recursos Materiales'
			WHEN a.tema ='5' THEN 'Planeación y Estadística'
			WHEN a.tema ='6' THEN 'Protección Civil'
			WHEN a.tema ='7' THEN 'Recursos Financieros'
			WHEN a.tema ='8' THEN 'Programas Federales'
			WHEN a.tema ='9' THEN 'Control Escolar'
			WHEN a.tema ='10' THEN 'Cooperativas y Tiendas Escolares '
			END AS nombre_tema,
			(select count(a.idaplicar) from aplicar a
			inner join respuesta r on r.idaplicar = a.idaplicar
			where a.estatus = 1 AND r.complemento = '{$nivel}'  AND a.tema > 0 ) as total_general
		FROM
			aplicar a
			inner join respuesta r on r.idaplicar = a.idaplicar
		WHERE
			a.estatus = 1 AND r.complemento = '{$nivel}' AND tema > 0
		GROUP BY tema;
			
        ";

		$querymes = "SELECT 
		a.tema, COUNT(a.tema) AS total_tema,
		CASE  
		WHEN a.tema ='0'  THEN 'Sin tema asignado'
		WHEN a.tema ='1'  THEN 'Administración de Personal'
		WHEN a.tema ='2' THEN 'Participación Social'
		WHEN a.tema ='3' THEN 'Gestión Escolar'
		WHEN a.tema ='4' THEN 'Recursos Materiales'
		WHEN a.tema ='5' THEN 'Planeación y Estadística'
		WHEN a.tema ='6' THEN 'Protección Civil'
		WHEN a.tema ='7' THEN 'Recursos Financieros'
		WHEN a.tema ='8' THEN 'Programas Federales'
		WHEN a.tema ='9' THEN 'Control Escolar'
		WHEN a.tema ='10' THEN 'Cooperativas y Tiendas Escolares '
		END AS nombre_tema,
		(select count(a.idaplicar) from aplicar a
		inner join respuesta r on r.idaplicar = a.idaplicar
		where a.estatus = 1 AND r.complemento = '{$mes}'  AND a.tema > 0 ) as total_general
	FROM
		aplicar a
		inner join respuesta r on r.idaplicar = a.idaplicar
	WHERE
		a.estatus = 1 AND r.complemento = '{$mes}' AND tema > 0
	GROUP BY tema;
        ";

		$querynivelmes = "SELECT 
			nivel.idaplicar,
			nivel.tema,
			COUNT(nivel.tema) AS total_tema,
			CASE
				WHEN nivel.tema = '0' THEN 'Sin tema asignado'
				WHEN nivel.tema = '1' THEN 'Administración de Personal'
				WHEN nivel.tema = '2' THEN 'Participación Social'
				WHEN nivel.tema = '3' THEN 'Gestión Escolar'
				WHEN nivel.tema = '4' THEN 'Recursos Materiales'
				WHEN nivel.tema = '5' THEN 'Planeación y Estadística'
				WHEN nivel.tema = '6' THEN 'Protección Civil'
				WHEN nivel.tema = '7' THEN 'Recursos Financieros'
				WHEN nivel.tema = '8' THEN 'Programas Federales'
				WHEN nivel.tema = '9' THEN 'Control Escolar'
				WHEN nivel.tema = '10' THEN 'Cooperativas y Tiendas Escolares '
			END AS nombre_tema,
			(SELECT 
					COUNT(nivel.idaplicar)
				FROM
					(SELECT 
						a.idaplicar, a.tema
					FROM
						aplicar a 
					INNER JOIN respuesta r on r.idaplicar = a.idaplicar
					WHERE
						r.complemento = '{$nivel}' AND a.estatus = 1
							AND a.tema > 0) AS nivel
						INNER JOIN
					(SELECT 
						a.idaplicar, a.tema
					FROM
						aplicar a 
					INNER JOIN respuesta r on r.idaplicar = a.idaplicar
					WHERE
						r.complemento = '{$mes}' AND a.estatus = 1
							AND a.tema > 0) AS mes ON nivel.idaplicar = mes.idaplicar) AS total_general
		FROM
			(SELECT 
				a.idaplicar, a.tema
			FROM
				aplicar a 
			INNER JOIN respuesta r on r.idaplicar = a.idaplicar
			WHERE
				r.complemento = '{$nivel}' AND a.estatus = 1
					AND a.tema > 0) AS nivel
				INNER JOIN
			(SELECT 
				a.idaplicar, a.tema
			FROM
				aplicar a 
			INNER JOIN respuesta r on r.idaplicar = a.idaplicar
			WHERE
				r.complemento = '{$mes}' AND a.estatus = 1
					AND a.tema > 0) AS mes ON nivel.idaplicar = mes.idaplicar
		GROUP BY nivel.tema;";

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

	public function getFormatoTema($tema, $nivel)
	{
		$str_query = "SELECT a.idaplicar from aplicar a
		inner join respuesta r on r.idaplicar = a.idaplicar
		where a.tema = {$tema} and r.complemento = '{$nivel}'  and a.estatus = 1;";
		
		return $this->ci_db->query($str_query)->result_array();

	}

	public function getFormatoTemaMes($tema,$nivel,$mes)
	{
		$str_query= "SELECT 
		nivel.idaplicar
		FROM
					(SELECT 
						a.idaplicar, a.tema
					FROM
						aplicar a 
					INNER JOIN respuesta r on r.idaplicar = a.idaplicar
					WHERE
						r.complemento = '{$nivel}' AND a.estatus = 1 AND a.tema = {$tema}
							AND a.tema > 0) AS nivel
						INNER JOIN
					(SELECT 
						a.idaplicar, a.tema
					FROM
						aplicar a 
					INNER JOIN respuesta r on r.idaplicar = a.idaplicar
					WHERE
						r.complemento = '{$mes}' AND a.estatus = 1 AND a.tema = {$tema}
							AND a.tema > 0) AS mes ON nivel.idaplicar = mes.idaplicar;";
		
	
	return $this->ci_db->query($str_query)->result_array();
	}

	public function EncuestaNivel($idaplicar)
	{
		$str_query = "SELECT * from respuesta where idaplicar = {$idaplicar};";
		return $this->ci_db->query($str_query)->result_array();
	}

}// Cuda_model class