<?php
class CentrosE_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->ce_db = $this->load->database('ce_db', TRUE);
    }

    function sostenimientos(){
      $query="SELECT a.* FROM (
                SELECT sostenimiento  AS id_sostenimiento,
                  CASE  WHEN (desc_sostenimiento LIKE '%FEDERAL%')
                      OR (desc_sostenimiento LIKE '%ESTATAL%')
                      OR (desc_sostenimiento LIKE '%PUBLICA%')
                      OR (desc_sostenimiento LIKE '%MUNICIPAL%')
                      OR (desc_sostenimiento LIKE '%INSTITUTO%')
                      OR (desc_sostenimiento LIKE '%ESTADO%')
                      OR (desc_sostenimiento LIKE '%SECRETARIA%')
                      THEN 'PUBLICO'
                    WHEN desc_sostenimiento LIKE '%PARTICULAR%' THEN 'PRIVADO'
                    WHEN desc_sostenimiento LIKE '%AUTONOMO%' THEN 'AUTONOMO'
                    END AS sostenimiento
                FROM vista_cct
                  WHERE (`status`= 1 OR `status` = 4) AND tipo_centro=9
                    GROUP BY
                    (CASE   WHEN (desc_sostenimiento LIKE '%FEDERAL%')
                      OR (desc_sostenimiento LIKE '%ESTATAL%')
                      OR (desc_sostenimiento LIKE '%PUBLICA%')
                      OR (desc_sostenimiento LIKE '%MUNICIPAL%')
                      OR (desc_sostenimiento LIKE '%INSTITUTO%')
                      OR (desc_sostenimiento LIKE '%ESTADO%')
                      OR (desc_sostenimiento LIKE '%SECRETARIA%')
                      THEN 'PUBLICO'
                      WHEN desc_sostenimiento LIKE '%PARTICULAR%' THEN 'PRIVADO'
                      WHEN desc_sostenimiento LIKE '%AUTONOMO%' THEN 'AUTONOMO'
                    END)
                ) AS a WHERE a.sostenimiento IS NOT NULL ORDER BY FIELD(a.sostenimiento,'PUBLICO','PRIVADO','AUTONOMO')";
      return $this->ce_db->query($query)->result_array();
    }// all()

    function niveles(){
      $query="SELECT
              CASE
                  WHEN a.nivel = 'ESPECIAL' THEN '1'
                  WHEN a.nivel = 'INICIAL' THEN '2'
                  WHEN a.nivel = 'PREESCOLAR' THEN '3'
                  WHEN a.nivel = 'PRIMARIA' THEN '4'
                  WHEN a.nivel = 'SECUNDARIA' THEN '5'
                  WHEN a.nivel = 'MEDIA SUPERIOR' THEN '6'
                  WHEN a.nivel = 'SUPERIOR' THEN '7'
                  WHEN a.nivel = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN a.nivel = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN a.nivel = 'NO APLICA'  THEN '10'
                  END AS id_nivel,a.nivel
               FROM (
              SELECT nivel_educativo,
                CASE  WHEN desc_nivel_educativo = 'NO APLICA'  THEN 'NO APLICA'
                  WHEN desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN 'FORMACION PARA EL TRABAJO'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN 'OTRO NIVEL EDUCATIVO'
                  END AS nivel
                FROM vista_cct
                WHERE (`status`= 1 OR `status` = 4) AND tipo_centro=9
                GROUP BY CASE   WHEN desc_nivel_educativo = 'NO APLICA' THEN 'NO APLICA'
                  WHEN desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN 'FORMACION PARA EL TRABAJO'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN 'OTRO NIVEL EDUCATIVO'
                  END

                  ) AS a ORDER BY FIELD(a.nivel,'ESPECIAL','INICIAL','PREESCOLAR','PRIMARIA','SECUNDARIA','MEDIA SUPERIOR','SUPERIOR','FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')";
      return $this->ce_db->query($query)->result_array();
    }

    function municipios(){
      $query="SELECT municipio as id_municipio,nombre_de_municipio as municipio FROM vista_cct
                WHERE  municipio IS NOT NULL
                GROUP BY municipio,nombre_de_municipio";
      return $this->ce_db->query($query)->result_array();
    }

    function filtro_escuela($municipio,$nivel,$sostenimiento,$nombre_escuela){
      // echo $municipio."\n";
      // echo $nivel."\n";
      // echo $sostenimiento."\n";
      // echo $nombre_escuela."\n";
      // die();

      $auxiliar="";
      if($municipio!=-1 && $municipio!=0){
        // $auxiliar.= " AND v.nombre_de_municipio LIKE'%".$municipio."%'";
        $auxiliar.= " AND v.municipio= {$municipio} ";
      }
      if($nivel!=-1 && $nivel!=0){
        if($nivel==1 ||  $nivel=='1'){
          $nivel_des="CAM";
        }else if($nivel==2 || $nivel=='2'){
          $nivel_des="INICIAL";
        }else if($nivel==3 || $nivel=='3'){
          $nivel_des="PREESCOLAR";
        }else if($nivel==4 || $nivel=='4'){
          $nivel_des="PRIMARIA";
        }else if($nivel==5 || $nivel=='5'){
          $nivel_des="SECUNDARIA";
        }else if($nivel==6 || $nivel=='6'){
          $nivel_des="MEDIA SUPERIOR";
        }else if($nivel==7 || $nivel=='7'){
          $nivel_des="SUPERIOR";
        }else if($nivel==8 || $nivel=='8'){
          $nivel_des="FORMACION PARA EL TRABAJO";
        }else if($nivel==9 || $nivel=='9'){
          $nivel_des="OTRO NIVEL EDUCATIVO";
        }else if($nivel==10 || $nivel=='10'){
          $nivel_des="NO APLICA";
        }
        $auxiliar.= " AND v.desc_nivel_educativo LIKE'%".trim($nivel_des)."%'";
        // echo $auxiliar;
        // die();
      }
      if($sostenimiento!=-1 && $sostenimiento!=0){
        // echo $sostenimiento; die();
        if($sostenimiento==11){
          $auxiliar.=" AND (
                      (v.desc_sostenimiento LIKE '%FEDERAL%')
                            OR (v.desc_sostenimiento LIKE '%ESTATAL%')
                            OR (v.desc_sostenimiento LIKE '%PUBLICA%')
                            OR (v.desc_sostenimiento LIKE '%MUNICIPAL%')
                            OR (v.desc_sostenimiento LIKE '%INSTITUTO%')
                            OR (v.desc_sostenimiento LIKE '%ESTADO%')
                            OR (v.desc_sostenimiento LIKE '%SECRETARIA%')
                      )";
        }else if($sostenimiento==61){
          $auxiliar.=" AND (
                      (v.desc_sostenimiento LIKE '%PARTICULAR%')
                      OR (v.desc_sostenimiento LIKE '%PRIVADO%')
                    )";
        }else if($sostenimiento==51){
          $auxiliar.=" AND (
                      v.desc_sostenimiento LIKE '%AUTONOMO%'
                    )";
        }

      }
      if($nombre_escuela!=''){
        $auxiliar.= " AND nombre LIKE '%".$nombre_escuela."%'";
      }

      $query="SELECT  v.cct,v.turno,v.desc_turno, v.nombre,
              CASE  WHEN v.desc_nivel_educativo = 'NO APLICA'  THEN 'NO APLICA'
                  WHEN v.desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN 'FORMACION PARA EL TRABAJO'
                  WHEN v.desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN 'OTRO NIVEL EDUCATIVO'
                  END AS nivel,
              CASE  WHEN (v.desc_sostenimiento LIKE '%FEDERAL%')
              OR (v.desc_sostenimiento LIKE '%ESTATAL%')
              OR (v.desc_sostenimiento LIKE '%PUBLICA%')
              OR (v.desc_sostenimiento LIKE '%MUNICIPAL%')
              OR (v.desc_sostenimiento LIKE '%INSTITUTO%')
              OR (v.desc_sostenimiento LIKE '%ESTADO%')
              OR (v.desc_sostenimiento LIKE '%SECRETARIA%')
              THEN 'PUBLICO'
              WHEN desc_sostenimiento LIKE '%PARTICULAR%' THEN 'PRIVADO'
              WHEN desc_sostenimiento LIKE '%AUTONOMO%' THEN 'AUTONOMO'
              END AS desc_sostenimiento,
              v.sostenimiento,v.status,v.municipio as id_municipio, v.nombre_de_municipio as municipio,v.localidad as id_localidad,v.nombre_de_localidad as localidad,
              v.latitud, v.longitud,v.nombre_vialidad_principal as domicilio,v.zona_escolar,'' as turno_n,'' AS turno_single
              FROM vista_cct AS v

              WHERE (v.status != 2 AND v.status != 3)
              /*AND v.latitud != 0
                AND v.latitud != ''*/
              AND desc_tipo_centro='ESCUELA' {$auxiliar}
               and municipio is not null
              GROUP BY v.cct,v.desc_turno
              ORDER BY v.desc_nivel_educativo";
        // echo $query; die();
        return $this->ce_db->query($query)->result_array();
    }

    function get_info_escuela($cct,$turno){

      if (strlen($turno)>3) {
        $where_turno = " v.desc_turno like '%{$turno}%'";
      }else{
        $where_turno = " v.turno={$turno}";
      }
      // echo $where_turno;
      // die();
      $query="SELECT  v.cct as cve_centro,v.turno,v.desc_turno, v.nombre as nombre_centro, v.des_region as region,concat_ws(' ',v.nombre_director,v.apellido_paterno_director,v.apellido_materno_director) as nombre_director,
              CASE  WHEN v.desc_nivel_educativo = 'NO APLICA'  THEN 'NO APLICA'
                  WHEN v.desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN 'FORMACION PARA EL TRABAJO'
                  WHEN v.desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN 'OTRO NIVEL EDUCATIVO'
                  END AS nivel,
              IF(status in(1,4),'ACTIVA','') as estatus
                  ,
              CASE  WHEN (v.desc_sostenimiento LIKE '%FEDERAL%')
              OR (v.desc_sostenimiento LIKE '%ESTATAL%')
              OR (v.desc_sostenimiento LIKE '%PUBLICA%')
              OR (v.desc_sostenimiento LIKE '%MUNICIPAL%')
              OR (v.desc_sostenimiento LIKE '%INSTITUTO%')
              OR (v.desc_sostenimiento LIKE '%ESTADO%')
              OR (v.desc_sostenimiento LIKE '%SECRETARIA%')
              THEN 'PUBLICO'
              WHEN desc_sostenimiento LIKE '%PARTICULAR%' THEN 'PRIVADO'
              WHEN desc_sostenimiento LIKE '%AUTONOMO%' THEN 'AUTONOMO'
              END AS desc_sostenimiento,
              v.sostenimiento,v.status,v.municipio as id_municipio, v.nombre_de_municipio as municipio,v.localidad as id_localidad,
              v.nombre_de_localidad as localidad,
              v.latitud, v.longitud,v.nombre_vialidad_principal as domicilio,v.zona_escolar,'' as turno_n,'' AS turno_single,
             v.desc_servicio AS modalidad
              FROM vista_cct AS v

              WHERE (v.status != 2 AND v.status != 3)
              /*AND v.latitud != 0
                AND v.latitud != ''*/
              AND (v.desc_tipo_centro='ESCUELA' or v.desc_tipo_centro='APOYO A LA EDUCACION' or v.desc_tipo_centro='PLANTEL (MEDIA SUPERIOR)')  and v.cct='{$cct}' and {$where_turno}
              AND municipio is not null
              GROUP BY v.cct,v.desc_turno
              ORDER BY v.desc_nivel_educativo";
        // echo $query; die();
        return $this->ce_db->query($query)->result_array();
    }

    function get_planea_xidcct($cct,$turno,$periodo){
      // echo $cct."\n";
      // echo $turno."\n";
      // echo $periodo."\n";
      // die();
      // echo "id_cct= ". $id_cct;
      $this->db->select('lyc_i, lyc_ii, lyc_iii, lyc_iv, mat_i, mat_ii, mat_iii, mat_iv');
      $this->db->from('planeaxescuela');
      $this->db->where('cct', $cct);
      $this->db->where('id_turno', $turno);
      $this->db->where('periodo', $periodo);
      $this->db->limit(1);//MODIFICACION LS para corregir error reportado LV comentar con ALEX
        // $str = $this->db->last_query();
    // echo $str; die();
      return  $this->db->get()->result_array();

    }// get_planea_xidcct()

    function get_indicpeso_xidcct($cct,$id_turno_single,$id_ciclo){
        $this->db->select('
          ROUND(`Bajo-peso`*100,1) as `bajo`,
          ROUND(`Normal`*100,1) as Normal,
          ROUND(`Sobrepeso`*100,1) as Sobrepeso,
          ROUND(`Obesidad`*100,1) as Obesidad,
          ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1) as predom,
          IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Bajo-peso`*100,1),1,0) as t_bajo,
          IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Normal`*100,1),1,0) as t_normal,
          IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Sobrepeso`*100,1),1,0) as t_sobrepeso,
          IF(ROUND(GREATEST(`Bajo-peso`,Normal,Sobrepeso,Obesidad)*100,1)=ROUND(`Obesidad`*100,1),1,0) as t_obesidad
        ');
        $this->db->from('pesoxcct');
        $this->db->where('cve_centro', $cct);
        $this->db->where('id_turno_single', $id_turno_single);
        $this->db->where('id_ciclo', $id_ciclo);
        //  $this->db->get();
        // $str = $this->db->last_query();
        // echo $str; die();
        return  $this->db->get()->result_array();
    }// get_indicpeso_xidcct()

    function get_xcvecentro($cve_centro){
      $query="SELECT cct,nivel_educativo,turno,desc_turno,'' as turno_n,'' AS turno_single FROM vista_cct WHERE cct='{$cve_centro}'
      and (status != 2 AND status != 3)  and desc_tipo_centro='ESCUELA' and municipio is not null";
      // echo $query;
      // die();
      return $this->ce_db->query($query)->result_array();
    }
}
