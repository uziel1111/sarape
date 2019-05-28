<?php
class Planeaxesc_reactivo_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }


    function get_planea_xconttem_reac($id_cct,$periodo, $idcampodis){

      $this->db->select('t3.id_contenido, t3.contenido as contenidos,GROUP_CONCAT(t2.n_reactivo) as reactivos, COUNT(t3.id_contenido) as total_reac_xua, SUM(t1.n_aciertos) as total, t1.n_almn_eval as alumnos_evaluados,
ROUND((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)),1)as porcen_alum_respok');
      $this->db->from('planeaxesc_reactivo t1');
      $this->db->join('planea_reactivo t2', 't1.id_reactivo=t2.id_reactivo');
      $this->db->join('planea_contenido t3', 't2.id_contenido= t3.id_contenido');
      $this->db->join('planea_unidad_analisis t4', 't3.id_unidad_analisis=t4.id_unidad_analisis');
      $this->db->join('planea_camposdisciplinares t5', 't4.id_campodisiplinario=t5.id_campodisiplinario');
      $this->db->where('t1.id_ct', $id_cct);
      $this->db->where('t1.id_periodo', $periodo);
      $this->db->where('t5.id_campodisiplinario', $idcampodis);

      $this->db->where('t2.id_reactivo !=', 118);
      $this->db->where('t2.id_reactivo !=', 123);
      $this->db->where('t2.id_reactivo !=', 126);
      $this->db->where('t2.id_reactivo !=', 176);
      $this->db->where('t2.id_reactivo !=', 152);
      $this->db->where('t2.id_reactivo !=', 197);
      $this->db->where('t2.id_reactivo !=', 300);
      $this->db->where('t2.id_reactivo !=', 319);
      $this->db->where('t2.id_reactivo !=', 328);
      $this->db->where('t2.id_reactivo !=', 330);
      $this->db->where('t2.id_reactivo !=', 346);
      $this->db->where('t2.id_reactivo !=', 350);
      $this->db->where('t2.id_reactivo !=', 374);
      $this->db->group_by("t3.id_contenido");
     //  $this->db->get();
     // $str = $this->db->last_query();
     // echo $str; die();
      return  $this->db->get()->result_array();

    }// get_planea_xconttem_reac()

    function get_reactivos_xcctxcont($id_cct,$id_cont,$periodo,$idcampodis){

      $this->db->select('t1.id_reactivo,t2.n_reactivo,
      CONCAT(
      IF(t4.id_nivel=4,"primaria",IF(t4.id_nivel=5,"secundaria",IF(t4.id_nivel=6,"ms","nada"))),
      IF(t4.id_periodo=1,"2016",IF(t4.id_periodo=2,"2017",IF(t4.id_periodo=3,"2018","nada"))),
      "/reactivo_",
      IF(t4.id_campodisiplinario=1,"lyc",IF(t4.id_campodisiplinario=2,"mat","nada")),
      "/r",
      t2.n_reactivo,
      ".JPG") as path_react,
      CONCAT(
      IF(t4.id_nivel=4,"primaria",IF(t4.id_nivel=5,"secundaria",IF(t4.id_nivel=6,"ms","nada"))),
      IF(t4.id_periodo=1,"2016",IF(t4.id_periodo=2,"2017", IF(t4.id_periodo=3,"2018","nada"))),
      "/apoyo_",
      IF(t4.id_campodisiplinario=1,"lyc",IF(t4.id_campodisiplinario=2,"mat","nada")),
      "/apoyo",
      t2.apoyo,
      ".JPG") as path_apoyo,
      t2.url_argumento,
      t2.url_especificacion,
      (COUNT( DISTINCT t6.idrecurso)) AS n_material,
	    (COUNT( DISTINCT t7.id_propuesta)) as n_prop,pr.id_planea_result,pr.a,pr.b,pr.c,pr.d,pr.res_ok,pr.n_alum_eval,
      TRUNCATE((pr.n_alum_eval-(pr.a+pr.b+pr.c+pr.d)),1) as tr_sin_contestar,TRUNCATE(((pr.a*100)/pr.n_alum_eval),1) as porcen_a,
      TRUNCATE(((pr.b*100)/pr.n_alum_eval),1) as porcen_b,TRUNCATE(((pr.c*100)/pr.n_alum_eval),1) as porcen_c,TRUNCATE(((pr.d*100)/pr.n_alum_eval),1) as porcen_d,
      TRUNCATE(((pr.n_alum_eval-(pr.a+pr.b+pr.c+pr.d))*100/pr.n_alum_eval),1) as porcen_sin_res
      ');
      $this->db->from('planeaxesc_reactivo t1');
      $this->db->join('planea_reactivo t2', 't1.id_reactivo=t2.id_reactivo');
      $this->db->join('planea_contenido t3', 't2.id_contenido= t3.id_contenido');
      $this->db->join('planea_unidad_analisis t4', 't3.id_unidad_analisis=t4.id_unidad_analisis');
      $this->db->join('planea_camposdisciplinares t5', 't4.id_campodisiplinario=t5.id_campodisiplinario');
      $this->db->join('recursos_apoyo t6', 't2.id_reactivo=t6.id_reactivo','left');
      $this->db->join('prop_mapoyo t7', 't2.id_reactivo = t7.id_reactivo','left');
      $this->db->join('paneaxescxinciso pr', 'pr.id_cct = t1.id_ct and t2.id_reactivo=pr.id_reactivo','left');
      $this->db->where('t1.id_ct', $id_cct);
      $this->db->where('t3.id_contenido', $id_cont);
      $this->db->where('t1.id_periodo', $periodo);
      $this->db->where('t5.id_campodisiplinario', $idcampodis);
      $this->db->where('t2.id_reactivo !=', 118);
      $this->db->where('t2.id_reactivo !=', 123);
      $this->db->where('t2.id_reactivo !=', 126);
      $this->db->where('t2.id_reactivo !=', 176);
      $this->db->where('t2.id_reactivo !=', 152);
      $this->db->where('t2.id_reactivo !=', 197);
      $this->db->where('t2.id_reactivo !=', 300);
      $this->db->where('t2.id_reactivo !=', 319);
      $this->db->where('t2.id_reactivo !=', 328);
      $this->db->where('t2.id_reactivo !=', 330);
      $this->db->where('t2.id_reactivo !=', 346);
      $this->db->where('t2.id_reactivo !=', 350);
      $this->db->where('t2.id_reactivo !=', 374);
      $this->db->where('(((t1.n_aciertos*100)/t1.n_almn_eval)<100)');
      $this->db->group_by('t2.id_reactivo');
      // $this->db->get();
     // $str = $this->db->last_query();
     // echo $str; die();
      return  $this->db->get()->result_array();

    }// get_reactivos_xcctxcont()

    function get_apoyos_academ_xidreact($id_reactivo){

      $this->db->select('idtipo, ruta, titulo, fuente');
      $this->db->from('recursos_apoyo');
      $this->db->where('id_reactivo', $id_reactivo);
     //  $this->db->get();
     // $str = $this->db->last_query();
     // echo $str; die();
      return  $this->db->get()->result_array();

    }// get_reactivos_xcctxcont_apoyo()

    function estadisticas_x_estadomunicipio($municipio, $nivel, $periodo, $idcampodis){
      $where = "";
      if($municipio != 0 ){
        $where = " AND m.`id_municipio` = {$municipio}";
      }
      $str_query = "SELECT id_contenido, contenidos, reactivos, total_reac_xua, total, alumnos_evaluados, ROUND((total* 100)/(total_reac_xua * alumnos_evaluados), 1)AS porcen_alum_respok FROM (

                          SELECT *, SUM(n_aciertos) AS total, SUM(n_almn_eval) AS alumnos_evaluados FROM (SELECT t3.id_contenido, t3.`contenido` AS contenidos,
                          GROUP_CONCAT(t2.n_reactivo) AS reactivos, COUNT(t3.id_contenido) AS total_reac_xua, t1.n_aciertos, t1.n_almn_eval
                          FROM municipio m
                          INNER JOIN escuela e ON e.id_municipio = m.id_municipio
                          INNER JOIN nivel n ON n.id_nivel = e.id_nivel
                          INNER JOIN planeaxesc_reactivo t1 ON t1.`id_ct` = e.`id_cct`
                          JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
                          JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
                          JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
                          JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`

                          WHERE n.id_nivel = {$nivel}  AND `t1`.`id_periodo` = {$periodo}
                          AND(t2.id_reactivo!=118 and t2.id_reactivo!=123 and t2.id_reactivo!=126)
                          AND(t2.id_reactivo!=176 and t2.id_reactivo!=152 and t2.id_reactivo!=197)
                          AND(t2.id_reactivo!=300 and t2.id_reactivo!=319 and t2.id_reactivo!=328 and t2.id_reactivo!=330 and t2.id_reactivo!=346)
                          AND(t2.id_reactivo!=350 and t2.id_reactivo!=374)
                          AND `t5`.`id_campodisiplinario` = {$idcampodis} {$where}
                          GROUP BY t3.`id_contenido`, e.id_cct) AS datos
                          GROUP BY id_contenido
                        ) AS datos2";
                        // echo $str_query; die();
        return $this->db->query($str_query)->result_array();
    }

    function estadisticas_x_region($zona, $nivel, $periodo, $idcampodis){
      $where = "";
      if($zona != 0 ){
        $where = " AND s.id_supervision = {$zona}";
      }
      $str_query = "SELECT id_contenido, contenidos, reactivos, total_reac_xua, total, alumnos_evaluados, ROUND((total* 100)/(total_reac_xua * alumnos_evaluados), 1)AS porcen_alum_respok FROM (

                          SELECT *, SUM(n_aciertos) AS total, SUM(n_almn_eval) AS alumnos_evaluados FROM (SELECT t3.id_contenido, t3.`contenido` AS contenidos,
                          GROUP_CONCAT(t2.n_reactivo) AS reactivos, COUNT(t3.id_contenido) AS total_reac_xua, t1.n_aciertos, t1.n_almn_eval
                          FROM supervision s
                          INNER JOIN escuela e ON e.id_supervision = s.id_supervision
                          INNER JOIN nivel n ON n.id_nivel = e.id_nivel
                          INNER JOIN planeaxesc_reactivo t1 ON t1.`id_ct` = e.`id_cct`
                          JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
                          JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
                          JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
                          JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`

                          WHERE n.id_nivel = {$nivel}  AND `t1`.`id_periodo` = {$periodo}
                          AND(t2.id_reactivo!=118 and t2.id_reactivo!=123 and t2.id_reactivo!=126)
                          AND(t2.id_reactivo!=176 and t2.id_reactivo!=152 and t2.id_reactivo!=197)
                          AND(t2.id_reactivo!=300 and t2.id_reactivo!=319 and t2.id_reactivo!=328 and t2.id_reactivo!=330 and t2.id_reactivo!=346)
                          AND(t2.id_reactivo!=350 and t2.id_reactivo!=374)
                          AND `t5`.`id_campodisiplinario` = {$idcampodis} {$where}
                          GROUP BY t3.`id_contenido`, e.id_cct) AS datos
                          GROUP BY id_contenido
                        ) AS datos2";
        // echo $str_query; die();
        return $this->db->query($str_query)->result_array();
    }


    function get_reactivos_xcctxcont_municipio($id_municipio,$id_cont,$periodo,$idcampodis){
      $where = "";
      if($id_municipio != 0 || $id_municipio != '0'){
        $where = "AND m.id_municipio = {$id_municipio}";
      }
      $str_query = "SELECT *,((SUM(n_aciertos)*100)/SUM(n_almn_eval))AS porcen, IF(((SUM(n_aciertos)*100)/SUM(n_almn_eval)) <100, 'si','no') AS mostrar, n_reactivo FROM(SELECT t1.n_almn_eval, t1.n_aciertos, t1.id_reactivo, t2.n_reactivo,
        CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017', IF(t4.id_periodo=3, '2018', 'nada'))), '/reactivo_', IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/r', t2.n_reactivo, '.JPG') as path_react,
       CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017', IF(t4.id_periodo=3, '2018', 'nada'))), '/apoyo_', IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/apoyo', t2.apoyo, '.JPG') as path_apoyo,
       t2.url_especificacion,
       t2.url_argumento,
       (
      		COUNT(DISTINCT t6.idrecurso)
      	) AS n_material,
      	(
      		COUNT(DISTINCT t7.id_propuesta)
      	) AS n_prop
        FROM municipio m
        INNER JOIN escuela e ON e.id_municipio = m.id_municipio
        INNER JOIN nivel n ON n.id_nivel = e.id_nivel
        INNER JOIN planeaxesc_reactivo t1 ON t1.`id_ct` = e.`id_cct`
        JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
        JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
        JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
        JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
        LEFT JOIN `recursos_apoyo` `t6` ON `t2`.`id_reactivo` = `t6`.`id_reactivo`
        LEFT JOIN `prop_mapoyo` `t7` ON `t2`.`id_reactivo` = `t7`.`id_reactivo`
        WHERE t3.id_contenido = {$id_cont}  AND t1.id_periodo = {$periodo} {$where}
        AND(t2.id_reactivo!=118 and t2.id_reactivo!=123 and t2.id_reactivo!=126)
        AND(t2.id_reactivo!=176 and t2.id_reactivo!=152 and t2.id_reactivo!=197)
        AND(t2.id_reactivo!=300 and t2.id_reactivo!=319 and t2.id_reactivo!=328 and t2.id_reactivo!=330 and t2.id_reactivo!=346)
        AND(t2.id_reactivo!=350 and t2.id_reactivo!=374)
        AND `t5`.`id_campodisiplinario` = {$idcampodis} GROUP BY `t2`.`id_reactivo`) datos GROUP BY id_reactivo
        ";
        // echo $str_query; die();
      return $this->db->query($str_query)->result_array();

    }// get_reactivos_xcctxcont()


    function get_reactivos_xcctxcont_zona($id_zona,$id_cont,$periodo,$idcampodis){
      $where = "";
      if($id_zona != 0 || $id_zona != '0'){
        $where = "AND s.id_supervision = ${id_zona}";
      }
      $str_query = "SELECT *,((SUM(n_aciertos)*100)/SUM(n_almn_eval))AS porcen, IF(((SUM(n_aciertos)*100)/SUM(n_almn_eval)) <100, 'si','no') AS mostrar, n_reactivo FROM(SELECT t1.n_almn_eval, t1.n_aciertos, t2.n_reactivo, t1.id_reactivo,
        CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017',  IF(t4.id_periodo=3, '2018', 'nada'))), '/reactivo_', IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/r', t2.n_reactivo, '.JPG') as path_react,
       CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017',  IF(t4.id_periodo=3, '2018', 'nada'))), '/apoyo_', IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/apoyo', t2.apoyo, '.JPG') as path_apoyo,
       t2.url_especificacion,
       t2.url_argumento,
       (
      		COUNT(DISTINCT t6.idrecurso)
      	) AS n_material,
      	(
      		COUNT(DISTINCT t7.id_propuesta)
      	) AS n_prop
        FROM supervision s
                  INNER JOIN escuela e ON e.id_supervision = s.id_supervision
                  INNER JOIN nivel n ON n.id_nivel = e.id_nivel
                  INNER JOIN planeaxesc_reactivo t1 ON t1.`id_ct` = e.`id_cct`
                  JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
                  JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
                  JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
                  JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
                  LEFT JOIN `recursos_apoyo` `t6` ON `t2`.`id_reactivo` = `t6`.`id_reactivo`
                  LEFT JOIN `prop_mapoyo` `t7` ON `t2`.`id_reactivo` = `t7`.`id_reactivo`
                  WHERE t3.id_contenido = {$id_cont}  AND t1.id_periodo = {$periodo} {$where}
                  AND(t2.id_reactivo!=118 and t2.id_reactivo!=123 and t2.id_reactivo!=126)
                  AND(t2.id_reactivo!=176 and t2.id_reactivo!=152 and t2.id_reactivo!=197)
                  AND(t2.id_reactivo!=300 and t2.id_reactivo!=319 and t2.id_reactivo!=328 and t2.id_reactivo!=330 and t2.id_reactivo!=346)
                  AND(t2.id_reactivo!=350 and t2.id_reactivo!=374)
                  AND `t5`.`id_campodisiplinario` = {$idcampodis} GROUP BY`t2`.`id_reactivo`) datos GROUP BY id_reactivo
                   ";
                  // echo $str_query; die();
                  return $this->db->query($str_query)->result_array();

    }// get_reactivos_xcctxcont()

     function zonaxnivel($nivel, $idsubsostenimiento){
      $str_query = "SELECT s.zona_escolar, s.id_supervision FROM escuela e
                    INNER JOIN supervision s ON e.id_supervision = s.id_supervision
                    WHERE e.id_nivel = {$nivel} AND e.id_subsostenimiento = {$idsubsostenimiento}
                    GROUP BY s.id_supervision
                    ORDER BY s.zona_escolar
                    ";
                    // echo $str_query; die();
      return $this->db->query($str_query)->result_array();
     }

     function subsostenimientoxnivel($nivel){
      $str_query = "SELECT s.id_subsostenimiento, s.subsostenimiento FROM escuela e
                  INNER JOIN subsostenimiento s ON e.id_subsostenimiento = s.id_subsostenimiento
                  WHERE e.id_nivel = {$nivel}
                  GROUP BY s.id_subsostenimiento";
      return $this->db->query($str_query)->result_array();
     }

}// Planeaxesc_reactivo_model
