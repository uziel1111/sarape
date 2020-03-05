<?php
class Reportepdf_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function get_rutasxcct($cct, $turno){
      $charaux='\n';
      $str_query = "SELECT
      	rtp.id_tprioritario,
      	rtp.orden,
      	rtp.otro_problematica,
      	rtp.otro_evidencia,
      	rtp.obs_direc,
      	rtp.obs_supervisor,
        rtp.ambito,
        p.prioridad AS tema,
    	o.id_objetivo,
    	o.objetivo AS objetivo
      FROM
      	rm_tema_prioritarioxcct rtp
      INNER JOIN rm_c_prioridad p ON p.id_prioridad = rtp.id_prioridad
      LEFT JOIN rm_objetivo o ON rtp.id_tprioritario=o.id_tprioritario
      WHERE rtp.cct = '{$cct}' AND rtp.turno = {$turno}
      ORDER BY orden ASC";

      return $this->db->query($str_query)->result_array();
    }

    function get_acciones($id_tprioritario, $tipo){
      if ($tipo == 'S') {
        $where = "acc.id_tprioritario = {$id_tprioritario}";
      }else{
         $where = "acc.id_objetivos = {$id_tprioritario}";
      }
      $str_query = "SELECT
acc.id_accion,
acc.accion,
acc.accion_f_inicio,
acc.accion_f_termino,
acc.mat_insumos,
-- CONCAT(IFNULL(av.cte5, '0'), '%') AS avance1,

CONCAT(
IF (ISNULL(av.cte8) OR (av.cte8=0),
IF (ISNULL(av.cte7) OR (av.cte7=0),
IF (ISNULL(av.cte6) OR (av.cte6=0),
IF (ISNULL(av.cte5) OR (av.cte5=0),
IF (ISNULL(av.cte4) OR (av.cte4=0),
IF (ISNULL(av.cte3) OR (av.cte3=0),
IF (ISNULL(av.cte2) OR (av.cte2=0),
IF (ISNULL(av.cte1) OR (av.cte1=0),'0',av.cte1)
,av.cte2)
,av.cte3)
,av.cte4)
,av.cte5)
,av.cte6)
,av.cte7)
,av.cte8)
,'%'
) AS avance,
acc.ids_responsables,
acc.otro_responsable,
acc.main_resp,
acc.id_objetivos
FROM
rm_accionxtproritario acc
LEFT JOIN rm_avance_xcctxtpxaccion av ON av.id_accion = acc.id_accion
AND acc.id_tprioritario = av.id_tprioritario
WHERE
	{$where}";
     
        return $this->db->query($str_query)->result_array();
    }

    function get_ciclo(){
      $str_query = "SELECT ciclo FROM ciclo WHERE estatus = 1";

      return $this->db->query($str_query)->result();
    }
}// Rutamejora_model
