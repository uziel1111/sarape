<?php
class Planeaxesc_reactivo_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->ce_db = $this->load->database('ce_db', TRUE);
    }


    function get_planea_xconttem_reac($cct,$turno,$periodo,$idcampodis){
      // echo $turno."\n";
      // echo $periodo."\n"; 
      // die();
      $this->db->select('t3.id_contenido, t3.contenido as contenidos,GROUP_CONCAT(t2.n_reactivo) as reactivos, COUNT(t3.id_contenido) as total_reac_xua, SUM(t1.n_aciertos) as total, t1.n_almn_eval as alumnos_evaluados,
ROUND((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)),1)as porcen_alum_respok');
      $this->db->from('planeaxesc_reactivo t1');
      $this->db->join('planea_reactivo t2', 't1.id_reactivo=t2.id_reactivo');
      $this->db->join('planea_contenido t3', 't2.id_contenido= t3.id_contenido');
      $this->db->join('planea_unidad_analisis t4', 't3.id_unidad_analisis=t4.id_unidad_analisis');
      $this->db->join('planea_camposdisciplinares t5', 't4.id_campodisiplinario=t5.id_campodisiplinario');
      $this->db->where('t1.cct', $cct);
      // $this->db->where('t1.turno_single', $turno);
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
      $this->db->where('t2.id_reactivo !=', 422);
      $this->db->where('t3.id_contenido !=', 424);
      $this->db->where('t2.id_reactivo !=', 426);
      $this->db->where('t2.id_reactivo !=', 433);
      $this->db->where('t2.id_reactivo !=', 440);
      $this->db->where('t2.id_reactivo !=', 455);
      $this->db->where('t2.id_reactivo !=', 471);
      $this->db->where('t2.id_reactivo !=', 475);
      $this->db->where('t2.id_reactivo !=', 477);
      $this->db->group_by("t3.id_contenido");
     //  $this->db->get();
     // $str = $this->db->last_query();
     // echo $str; die();
      return  $this->db->get()->result_array();

    }// get_planea_xconttem_reac()

    function get_reactivos_xcctxcont($cct,$turno,$nivel,$id_cont,$periodo,$idcampodis){
      // echo $turno; die();

      $this->db->select('t1.id_reactivo,t2.n_reactivo,
      CONCAT(
      IF(t4.id_nivel=4,"primaria",IF(t4.id_nivel=5,"secundaria",IF(t4.id_nivel=6,"ms","nada"))),
      IF(t4.id_periodo=1,"2016",IF(t4.id_periodo=2,"2017",IF(t4.id_periodo=3, "2018", IF(t4.id_periodo=4, "2019", "nada")))),
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
      $this->db->where('t1.cct', $cct);
      $this->db->where('t1.turno_single', $turno);
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
      $this->db->where('t2.id_reactivo !=', 422);
      $this->db->where('t3.id_contenido !=', 424);
      $this->db->where('t2.id_reactivo !=', 426);
      $this->db->where('t2.id_reactivo !=', 433);
      $this->db->where('t2.id_reactivo !=', 440);
      $this->db->where('t2.id_reactivo !=', 455);
      $this->db->where('t2.id_reactivo !=', 471);
      $this->db->where('t2.id_reactivo !=', 475);
      $this->db->where('t2.id_reactivo !=', 477);
      $this->db->where('(((t1.n_aciertos*100)/t1.n_almn_eval)<100)');
      $this->db->group_by('t2.id_reactivo');
     //  $this->db->get();
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
      // echo $nivel;
      $where = "";
      if($municipio != 0 ){
        $where = " AND e.municipio = {$municipio}";
      }
      $str_query = "SELECT id_contenido, contenidos, reactivos, total_reac_xua, total, alumnos_evaluados, ROUND((total* 100)/(total_reac_xua * alumnos_evaluados), 1)AS porcen_alum_respok FROM (
              SELECT *, SUM(n_aciertos) AS total, SUM(n_almn_eval) AS alumnos_evaluados FROM (SELECT t3.id_contenido, t3.`contenido` AS contenidos,
              GROUP_CONCAT(t2.n_reactivo) AS reactivos, COUNT(t3.id_contenido) AS total_reac_xua, t1.n_aciertos, t1.n_almn_eval
              FROM centros_educativos.vista_cct e 
              INNER JOIN sarape.planeaxesc_reactivo t1 ON t1.cct = e.cct
              JOIN sarape.planea_reactivo t2 ON t1.id_reactivo=t2.id_reactivo
              JOIN sarape.planea_contenido t3 ON t2.id_contenido= t3.id_contenido
              JOIN sarape.planea_unidad_analisis t4 ON t3.id_unidad_analisis=t4.id_unidad_analisis
              JOIN sarape.planea_camposdisciplinares t5 ON t4.id_campodisiplinario=t5.id_campodisiplinario
              WHERE e.desc_nivel_educativo LIKE '%{$nivel}%'  AND t1.id_periodo= {$periodo}
              AND(t2.id_reactivo!=118 and t2.id_reactivo!=123 and t2.id_reactivo!=126)
              AND(t2.id_reactivo!=176 and t2.id_reactivo!=152 and t2.id_reactivo!=197)
              AND(t2.id_reactivo!=300 and t2.id_reactivo!=319 and t2.id_reactivo!=328 and t2.id_reactivo!=330 and t2.id_reactivo!=346)
              AND(t2.id_reactivo!=350 and t2.id_reactivo!=374 and t2.id_reactivo!=422 and t3.id_contenido!=424 and t2.id_reactivo!=426 and t2.id_reactivo!=433)
              AND(t2.id_reactivo!=440 and t2.id_reactivo!=455 and t2.id_reactivo!=471 and t2.id_reactivo!=475 and t2.id_reactivo!=477)
              AND t5.id_campodisiplinario = {$idcampodis} {$where}
              GROUP BY t3.id_contenido, e.cct) AS datos
              GROUP BY id_contenido
            ) AS datos2";
                        // echo $str_query; die();
        return $this->db->query($str_query)->result_array();
    }

    function estadisticas_x_region($zona, $nivel, $periodo, $idcampodis){
      // echo $zona."\n";
      // echo $nivel."\n";
      // echo $periodo."\n";
      // echo $idcampodis."\n";
      // die();
      $filtro = "";
      $filtro_nivel = "";
      if($nivel=="PREESCOLAR"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PREESCOLAR%' AND supervisiones.tipo='FZP',TRUE,FALSE)";
        $filtro_nivel .= " AND desc_nivel_educativo LIKE '%PREESCOLAR%'";
      }else if($nivel=="PRIMARIA"){
        $filtro .= " AND IF(escuelas.desc_servicio LIKE '%PRIMARIA%' AND supervisiones.tipo='FIZ',TRUE,FALSE)";
        $filtro_nivel .= " AND desc_nivel_educativo LIKE '%PRIMARIA%'";
      }else if($nivel=="SECUNDARIA"){
        $filtro .= "  AND
              IF((escuelas.desc_servicio='SECUNDARIA GENERAL' OR escuelas.desc_servicio='SECUNDARIA COMUNITARIA'
              OR(escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='ESTATAL')
              OR (escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='PARTICULAR')
              ) AND supervisiones.tipo='FIS',TRUE,
              IF(((escuelas.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')
              OR (escuelas.desc_servicio='SECUNDARIA TECNICA AGROPECUARIA' AND escuelas.desc_sostenimiento='FEDERAL TRANSFERIDO')) AND supervisiones.tipo='FZT',TRUE,
              IF(escuelas.desc_servicio='TELESECUNDARIA' AND supervisiones.tipo='FTV', TRUE, FALSE) ))";
        $filtro_nivel .= " AND desc_nivel_educativo LIKE '%SECUNDARIA%'";
      }
      $where = "";
      if($zona != 0 ){
        $where = " AND supervisiones.cct = '{$zona}'";
      }
      $str_query = "SELECT id_contenido, contenidos, reactivos, total_reac_xua, total, alumnos_evaluados, 
                    ROUND((total* 100)/(total_reac_xua * alumnos_evaluados), 1)AS porcen_alum_respok 
                    FROM (
                      SELECT *, SUM(n_aciertos) AS total, SUM(n_almn_eval) AS alumnos_evaluados 
                        FROM (
                          SELECT t3.id_contenido, t3.`contenido` AS contenidos,GROUP_CONCAT(t2.n_reactivo) AS reactivos, COUNT(t3.id_contenido) AS total_reac_xua, t1.n_aciertos, t1.n_almn_eval                       
                          FROM centros_educativos.vista_cct  escuelas            
                          INNER JOIN (
                            SELECT cct, zona_escolar, sostenimiento,
                                    SUBSTRING(cct, 3, 3) AS tipo
                                 FROM centros_educativos.vista_cct 
                                 WHERE (status = 1 OR status = 4) AND tipo_centro = 1
                          ) AS supervisiones ON escuelas.zona_escolar = supervisiones.zona_escolar
                          AND escuelas.sostenimiento = supervisiones.sostenimiento
                          {$filtro}      
                          INNER JOIN sarape.planeaxesc_reactivo t1 ON t1.cct = escuelas.cct
                          INNER JOIN sarape.planea_reactivo t2 ON t1.id_reactivo=t2.id_reactivo
                          INNER JOIN sarape.planea_contenido t3 ON t2.id_contenido= t3.id_contenido
                          INNER JOIN sarape.planea_unidad_analisis t4 ON t3.id_unidad_analisis=t4.id_unidad_analisis
                          INNER JOIN sarape.planea_camposdisciplinares t5 ON t4.id_campodisiplinario=t5.id_campodisiplinario
                          WHERE escuelas.desc_nivel_educativo LIKE '%{$nivel}%'  AND t1.id_periodo = {$periodo}
                          AND(t2.id_reactivo!=118 AND t2.id_reactivo!=123 AND t2.id_reactivo!=126)
                          AND(t2.id_reactivo!=176 AND t2.id_reactivo!=152 AND t2.id_reactivo!=197)
                          AND(t2.id_reactivo!=300 AND t2.id_reactivo!=319 AND t2.id_reactivo!=328 AND t2.id_reactivo!=330 AND t2.id_reactivo!=346)
                          AND(t2.id_reactivo!=350 AND t2.id_reactivo!=374 AND t2.id_reactivo!=422 AND t3.id_contenido!=424 AND t2.id_reactivo!=426 AND t2.id_reactivo!=433)
                          AND(t2.id_reactivo!=440 AND t2.id_reactivo!=455 AND t2.id_reactivo!=471 AND t2.id_reactivo!=475 AND t2.id_reactivo!=477)
                          AND t5.id_campodisiplinario = {$idcampodis} 
                          {$where}
                            GROUP BY t3.id_contenido,escuelas.cct) AS datos
                            GROUP BY id_contenido
                          ) AS datos2";
        // echo $str_query; die();
        return $this->db->query($str_query)->result_array();
    }


    function get_reactivos_xcctxcont_municipio($id_municipio,$id_cont,$periodo,$idcampodis){
      $where = "";
      if($id_municipio != 0 || $id_municipio != '0'){
        $where = "AND e.municipio = {$id_municipio}";
      }
      $str_query = "SELECT *,((SUM(n_aciertos)*100)/SUM(n_almn_eval))AS porcen, IF(((SUM(n_aciertos)*100)/SUM(n_almn_eval)) <100, 'si','no') AS mostrar, n_reactivo FROM(SELECT t1.n_almn_eval, t1.n_aciertos, t1.id_reactivo, t2.n_reactivo,
        CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017',IF(t4.id_periodo=3, '2018', IF(t4.id_periodo=4, '2019', 'nada')))), '/reactivo_', IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/r', t2.n_reactivo, '.JPG') as path_react,
       CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017', IF(t4.id_periodo=3, '2018', IF(t4.id_periodo=4, '2019', 'nada')))), '/apoyo_', IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/apoyo', t2.apoyo, '.JPG') as path_apoyo,
       t2.url_especificacion,
       t2.url_argumento,
       (
      		COUNT(DISTINCT t6.idrecurso)
      	) AS n_material,
      	(
      		COUNT(DISTINCT t7.id_propuesta)
      	) AS n_prop
        FROM centros_educativos.vista_cct e 
        INNER JOIN sarape.planeaxesc_reactivo t1 ON t1.cct = e.cct
        JOIN sarape.planea_reactivo t2 ON t1.id_reactivo=t2.id_reactivo
        JOIN sarape.planea_contenido t3 ON t2.id_contenido= t3.id_contenido
        JOIN sarape.planea_unidad_analisis t4 ON t3.id_unidad_analisis=t4.id_unidad_analisis
        JOIN sarape.planea_camposdisciplinares t5 ON t4.id_campodisiplinario=t5.id_campodisiplinario
        LEFT JOIN sarape.recursos_apoyo t6 ON t2.id_reactivo = t6.id_reactivo
        LEFT JOIN sarape.prop_mapoyo t7 ON t2.id_reactivo = t7.id_reactivo
        WHERE t3.id_contenido = {$id_cont}  AND t1.id_periodo = {$periodo} {$where}
        AND(t2.id_reactivo!=118 and t2.id_reactivo!=123 and t2.id_reactivo!=126)
        AND(t2.id_reactivo!=176 and t2.id_reactivo!=152 and t2.id_reactivo!=197)
        AND(t2.id_reactivo!=300 and t2.id_reactivo!=319 and t2.id_reactivo!=328 and t2.id_reactivo!=330 and t2.id_reactivo!=346)
        AND(t2.id_reactivo!=350 and t2.id_reactivo!=374 and t2.id_reactivo!=422 and t3.id_contenido!=424 and t2.id_reactivo!=426 and t2.id_reactivo!=433)
        AND(t2.id_reactivo!=440 and t2.id_reactivo!=455 and t2.id_reactivo!=471 and t2.id_reactivo!=475 and t2.id_reactivo!=477)
        AND `t5`.`id_campodisiplinario` = {$idcampodis} GROUP BY `t2`.`id_reactivo`) datos GROUP BY id_reactivo
        ";
        // echo $str_query; die();
      return $this->db->query($str_query)->result_array();

    }// get_reactivos_xcctxcont()


    function get_reactivos_xcctxcont_zona($id_zona,$id_cont,$periodo,$idcampodis){
      $where = "";
      if($id_zona != 0 || $id_zona != '0'){
        $where = " AND s.cct = '{$id_zona}'";
      }
      // $str_query = "SELECT *,((SUM(n_aciertos)*100)/SUM(n_almn_eval))AS porcen, IF(((SUM(n_aciertos)*100)/SUM(n_almn_eval)) <100, 'si','no') AS mostrar, n_reactivo FROM(SELECT t1.n_almn_eval, t1.n_aciertos, t2.n_reactivo, t1.id_reactivo,
      //   CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017',  IF(t4.id_periodo=3, '2018', IF(t4.id_periodo=4, '2019', 'nada')))), '/reactivo_', IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/r', t2.n_reactivo, '.JPG') as path_react,
      //  CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017',  IF(t4.id_periodo=3, '2018', IF(t4.id_periodo=4, '2019', 'nada')))), '/apoyo_', IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/apoyo', t2.apoyo, '.JPG') as path_apoyo,
      //  t2.url_especificacion,
      //  t2.url_argumento,
      //  (
      // 		COUNT(DISTINCT t6.idrecurso)
      // 	) AS n_material,
      // 	(
      // 		COUNT(DISTINCT t7.id_propuesta)
      // 	) AS n_prop
      //   FROM supervision s
      //             INNER JOIN escuela e ON e.id_supervision = s.id_supervision
      //             INNER JOIN nivel n ON n.id_nivel = e.id_nivel
      //             INNER JOIN planeaxesc_reactivo t1 ON t1.`id_ct` = e.`id_cct`
      //             JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
      //             JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
      //             JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
      //             JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
      //             LEFT JOIN `recursos_apoyo` `t6` ON `t2`.`id_reactivo` = `t6`.`id_reactivo`
      //             LEFT JOIN `prop_mapoyo` `t7` ON `t2`.`id_reactivo` = `t7`.`id_reactivo`
      //             WHERE t3.id_contenido = {$id_cont}  AND t1.id_periodo = {$periodo} {$where}
      //             AND(t2.id_reactivo!=118 and t2.id_reactivo!=123 and t2.id_reactivo!=126)
      //             AND(t2.id_reactivo!=176 and t2.id_reactivo!=152 and t2.id_reactivo!=197)
      //             AND(t2.id_reactivo!=300 and t2.id_reactivo!=319 and t2.id_reactivo!=328 and t2.id_reactivo!=330 and t2.id_reactivo!=346)
      //             AND(t2.id_reactivo!=350 and t2.id_reactivo!=374 and t2.id_reactivo!=422 and t3.id_contenido!=424 and t2.id_reactivo!=426 and t2.id_reactivo!=433)
        
      //             AND `t5`.`id_campodisiplinario` = {$idcampodis} GROUP BY`t2`.`id_reactivo`) datos GROUP BY id_reactivo
      //              ";
      $str_query = "SELECT *,((SUM(n_aciertos)*100)/SUM(n_almn_eval))AS porcen, IF(((SUM(n_aciertos)*100)/SUM(n_almn_eval)) <100, 'si','no') AS mostrar, n_reactivo 
        FROM(SELECT t1.n_almn_eval, t1.n_aciertos, t2.n_reactivo, t1.id_reactivo,
              CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), 
              IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017', 
              IF(t4.id_periodo=3, '2018', IF(t4.id_periodo=4, '2019', 'nada')))), '/reactivo_',
              IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/r', t2.n_reactivo, '.JPG') AS path_react,
              CONCAT(IF(t4.id_nivel=4, 'primaria', IF(t4.id_nivel=5, 'secundaria', IF(t4.id_nivel=6, 'ms', 'nada'))), 
              IF(t4.id_periodo=1, '2016', IF(t4.id_periodo=2, '2017',  IF(t4.id_periodo=3, '2018', 
              IF(t4.id_periodo=4, '2019', 'nada')))), '/apoyo_', IF(t4.id_campodisiplinario=1, 'lyc', IF(t4.id_campodisiplinario=2, 'mat', 'nada')), '/apoyo', t2.apoyo, '.JPG') AS path_apoyo,
                   t2.url_especificacion,
                   t2.url_argumento,
                   (
                      COUNT(DISTINCT t6.idrecurso)
                    ) AS n_material,
                    (
                      COUNT(DISTINCT t7.id_propuesta)
                    ) AS n_prop
            FROM centros_educativos.vista_cct AS e
            INNER JOIN (SELECT cct, zona_escolar, sostenimiento,SUBSTRING(cct, 3, 3) AS tipo
                        FROM centros_educativos.vista_cct 
                        WHERE (STATUS = 1 OR STATUS = 4) AND tipo_centro = 1
            ) AS s ON e.zona_escolar = s.zona_escolar
            AND e.sostenimiento = s.sostenimiento
            AND IF( (e.desc_servicio='SECUNDARIA GENERAL' OR e.desc_servicio='SECUNDARIA COMUNITARIA'
              OR (e.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND e.desc_sostenimiento='ESTATAL') 
              OR (e.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND e.desc_sostenimiento='PARTICULAR') ) 
              AND s.tipo='FIS',TRUE,
              IF( ((e.desc_servicio='SECUNDARIA TECNICA INDUSTRIAL' AND e.desc_sostenimiento='FEDERAL TRANSFERIDO')
              OR (e.desc_servicio='SECUNDARIA TECNICA AGROPECUARIA' AND e.desc_sostenimiento='FEDERAL TRANSFERIDO')) 
              AND s.tipo='FZT',TRUE,
              IF(e.desc_servicio='TELESECUNDARIA' AND s.tipo='FTV', TRUE, 
              IF(e.desc_servicio LIKE '%PRIMARIA%' AND s.tipo='FIZ',TRUE, 
              IF(e.desc_servicio LIKE '%PREESCOLAR%' AND s.tipo='FZP',TRUE, 
              IF(e.desc_servicio LIKE '%INICIAL%' AND s.tipo='FCJ',TRUE,
              IF(e.desc_servicio LIKE '%CAM%' AND s.tipo='FSE',TRUE,FALSE)  ) ) ) ) ) )
              INNER JOIN sarape.planeaxesc_reactivo t1 ON t1.`cct` = e.`cct`
              JOIN sarape.planea_reactivo `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
              JOIN sarape.planea_contenido `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
              JOIN sarape.planea_unidad_analisis `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
              JOIN sarape.planea_camposdisciplinares `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
              LEFT JOIN sarape.recursos_apoyo `t6` ON `t2`.`id_reactivo` = `t6`.`id_reactivo`
              LEFT JOIN sarape.prop_mapoyo `t7` ON `t2`.`id_reactivo` = `t7`.`id_reactivo`
              WHERE t3.id_contenido = {$id_cont}  AND t1.id_periodo = {$periodo} {$where}
              AND(t2.id_reactivo!=118 AND t2.id_reactivo!=123 AND t2.id_reactivo!=126)
              AND(t2.id_reactivo!=176 AND t2.id_reactivo!=152 AND t2.id_reactivo!=197)
              AND(t2.id_reactivo!=300 AND t2.id_reactivo!=319 AND t2.id_reactivo!=328 AND t2.id_reactivo!=330 AND t2.id_reactivo!=346)
              AND(t2.id_reactivo!=350 AND t2.id_reactivo!=374 AND t2.id_reactivo!=422 AND t3.id_contenido!=424 AND t2.id_reactivo!=426 AND t2.id_reactivo!=433)
              AND `t5`.`id_campodisiplinario` = {$idcampodis} GROUP BY`t2`.`id_reactivo`) datos GROUP BY id_reactivo";
                  // echo $str_query; die();
                  return $this->db->query($str_query)->result_array();

    }// get_reactivos_xcctxcont()

    function zonaxnivel($nivel, $idsubsostenimiento){
      // $str_query = "SELECT s.zona_escolar, s.id_supervision FROM escuela e
      //               INNER JOIN supervision s ON e.id_supervision = s.id_supervision
      //               WHERE e.id_nivel = {$nivel} AND e.id_subsostenimiento = {$idsubsostenimiento}
      //               GROUP BY s.id_supervision
      //               ORDER BY s.zona_escolar
      //               ";
      //               // echo $str_query; die();
      // return $this->db->query($str_query)->result_array();

      $filtro= "";
       if($idsubsostenimiento=="2"){
          $filtro.=" AND sostenimiento in('61','41','92','96')";
        }else if($idsubsostenimiento=="3"){
          $filtro.="AND sostenimiento in(51)";
        }else {
          $filtro.="AND sostenimiento NOT IN('61','41','92','96','51')";
        }

      $query="SELECT cct as id_supervision,zona_escolar
              FROM vista_cct
              WHERE (`status`= 1 OR `status` = 4) 
              AND tipo_centro=1 
             -- AND desc_nivel_educativo LIKE '%{$nivel}%'
              {$filtro} ";
      // echo $query;
      // die();
      return $this->ce_db->query($query)->result_array();
    }

     function subsostenimientoxnivel($nivel){
      // $str_query = "SELECT s.id_subsostenimiento, s.subsostenimiento FROM escuela e
      //             INNER JOIN subsostenimiento s ON e.id_subsostenimiento = s.id_subsostenimiento
      //             WHERE e.id_nivel = {$nivel}
      //             GROUP BY s.id_subsostenimiento";
      $filtro ="";
      if($nivel!="TODOS"){
        $filtro.=" and v.desc_nivel_educativo LIKE '%{$nivel}%' ";
      }

      $query="SELECT (SELECT CASE  
              WHEN v.sostenimiento IN  ('51') THEN '3' 
              WHEN v.sostenimiento IN ('61','41','92','96') THEN '2'
              ELSE '1'
              END) as id_sostenimiento,
              (SELECT CASE  
              WHEN v.sostenimiento IN  ('51') THEN 'AUTONOMO' 
              WHEN v.sostenimiento IN ('61','41','92','96') THEN 'PRIVADO'
              ELSE 'PUBLICO'
              END) AS sostenimiento2
              FROM vista_cct v 
              WHERE v.status IN ('1','4') AND v.tipo_centro='9'
              {$filtro}
              GROUP BY id_sostenimiento";
      // echo $query;
      // die();
      return $this->ce_db->query($query)->result_array();
     }

}// Planeaxesc_reactivo_model
