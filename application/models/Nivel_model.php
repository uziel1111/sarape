<?php
class Nivel_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->ce_db = $this->load->database('ce_db', TRUE);
    }

    function all(){
      return  $this->db->get('nivel')->result_array();
    }// all()


    function get_xidmunicipio($id_municipio){
      /*$this->db->select('ni.id_nivel, ni.nivel');
      $this->db->from('nivel as ni');
      $this->db->join('vista_cct as es', 'ni.id_nivel = es.id_nivel');
      $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');*/
      if($id_municipio>0){
        $where = "where municipio = {$id_municipio}";
      }
      else{
        $where = ' ';
      }
      $str_query = "SELECT CASE  
                  WHEN desc_nivel_educativo = 'CAM' THEN '1'
                  WHEN desc_nivel_educativo = 'ESPECIAL' THEN '1'
                  WHEN desc_nivel_educativo = 'INICIAL' THEN '2'
                  WHEN desc_nivel_educativo = 'PREESCOLAR' THEN '3'
                  WHEN desc_nivel_educativo = 'PRIMARIA' THEN '4'
                  WHEN desc_nivel_educativo = 'SECUNDARIA' THEN '5'
                  WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN '6'
                  WHEN desc_nivel_educativo = 'SUPERIOR' THEN '7'
                  WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN '8'
                  WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN '9'
                  WHEN desc_nivel_educativo = 'NO APLICA' THEN '10'
                  END AS id_nivel, desc_nivel_educativo as nivel
        from centros_educativos.vista_cct 
        {$where}
        GROUP by id_nivel";

      return $this->ce_db->query($str_query)->result_array();
    }// get_xidmunicipio()

    function get_xidmunicipio_vista_cct($id_municipio){
      $filtro="";
      if($id_municipio>0){
        $filtro=" and municipio={$id_municipio}";
      }

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
                    END AS nivel FROM vista_cct
                  WHERE (`status`= 1 OR `status` = 4) AND tipo_centro=9
                  {$filtro}
                  GROUP BY (CASE   
                              WHEN desc_nivel_educativo = 'NO APLICA' THEN 'NO APLICA'
                              WHEN desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                              WHEN desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                              WHEN desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                              WHEN desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                              WHEN desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                              WHEN desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                              WHEN desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                              WHEN desc_nivel_educativo = 'FORMACION PARA EL TRABAJO' THEN 'FORMACION PARA EL TRABAJO'
                              WHEN desc_nivel_educativo = 'OTRO NIVEL EDUCATIVO' THEN 'OTRO NIVEL EDUCATIVO'
                              END)   
                  ) AS a ORDER BY FIELD(a.nivel,'ESPECIAL','INICIAL','PREESCOLAR','PRIMARIA','SECUNDARIA','MEDIA SUPERIOR','SUPERIOR','FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')";
      return $this->ce_db->query($query)->result_array();
    }

    function get_xidnivel_vista_cct($id_nivel){
      $filtro="";
      if($id_nivel>0){
        if($id_nivel==1){
          $nivel="CAM";
        }else if($id_nivel==2){
          $nivel="INICIAL";
        }else if($id_nivel==3){
          $nivel="PREESCOLAR";
        }else if($id_nivel==4){
          $nivel="PRIMARIA";
        }else if($id_nivel==5){
          $nivel="SECUNDARIA";
        }else if($id_nivel==6){
          $nivel="MEDIA SUPERIOR";
        }else if($id_nivel==7){
          $nivel="SUPERIOR";
        }else if($id_nivel==8){
          $nivel="FORMACION PARA EL TRABAJO";
        }else if($id_nivel==9){
          $nivel="OTRO NIVEL EDUCATIVO";
        }else if($id_nivel==10){
          $nivel="NO APLICA";
        }

        $filtro=" AND desc_nivel_educativo = '".$nivel."'";
      }

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
                  {$filtro}
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
    }

    function getall_est_ind(){
      // $this->db->select('ni.id_nivel, ni.nivel');
      // $this->db->from('nivel as ni');
      // $this->db->join('escuela as es', 'ni.id_nivel = es.id_nivel');
      // $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
      // $this->db->where('ni.id_nivel <',8);
      // $this->db->group_by('ni.id_nivel');
      // return  $this->db->get()->result_array();
       $query="SELECT 
              CASE  
                  WHEN a.nivel = 'ESPECIAL' THEN '1'
                  WHEN a.nivel = 'INICIAL' THEN '2'
                  WHEN a.nivel = 'PREESCOLAR' THEN '3'
                  WHEN a.nivel = 'PRIMARIA' THEN '4'
                  WHEN a.nivel = 'SECUNDARIA' THEN '5'
                  WHEN a.nivel = 'MEDIA SUPERIOR' THEN '6'
                  WHEN a.nivel = 'SUPERIOR' THEN '7'
                  END AS id_nivel,a.nivel
               FROM (
              SELECT v.nivel_educativo,
                CASE  
                  WHEN v.desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  END AS nivel
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct es ON es.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                GROUP BY CASE  
                  WHEN v.desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  END
                  ) AS a ORDER BY FIELD(a.nivel,'ESPECIAL','INICIAL','PREESCOLAR','PRIMARIA','SECUNDARIA','MEDIA SUPERIOR','SUPERIOR')";
      return $this->db->query($query)->result_array();
    }// getall_est_ind()

    function getall_est_indz(){
      // $this->db->select('ni.id_nivel, ni.nivel');
      // $this->db->from('nivel as ni');
      // $this->db->join('escuela as es', 'ni.id_nivel = es.id_nivel');
      // $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
      // $this->db->or_where('ni.id_nivel =',3);
      // $this->db->or_where('ni.id_nivel =',4);
      // $this->db->or_where('ni.id_nivel =',5);
      // $this->db->group_by('ni.id_nivel');
      // return  $this->db->get()->result_array();
       $query="SELECT 
              CASE  
                  WHEN a.nivel = 'PREESCOLAR' THEN '3'
                  WHEN a.nivel = 'PRIMARIA' THEN '4'
                  WHEN a.nivel = 'SECUNDARIA' THEN '5'
                  END AS id_nivel,a.nivel
               FROM (
              SELECT v.nivel_educativo,
                CASE  
                  WHEN v.desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  END AS nivel
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct es ON es.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 AND v.desc_nivel_educativo  IN('PREESCOLAR','PRIMARIA','SECUNDARIA')
                
                GROUP BY CASE  
                  WHEN v.desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  END
                  ) AS a ORDER BY FIELD(a.nivel,'PREESCOLAR','PRIMARIA','SECUNDARIA')";
      return $this->db->query($query)->result_array();
    }// getall_est_indz()

    function getall_est_indxmuni($id_municipio){
      // $this->db->select('ni.id_nivel, ni.nivel');
      // $this->db->from('nivel as ni');
      // $this->db->join('escuela as es', 'ni.id_nivel = es.id_nivel');
      // $this->db->join('estadistica_e_indicadores_xcct as  est', 'es.id_cct = est.id_cct');
      // $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
      $concat="";
      if($id_municipio>0){
        $this->db->where('mu.id_municipio', $id_municipio);
        $concat.=" AND  v.municipio={$id_municipio}";
      }
      // $this->db->where('ni.id_nivel <',8);
      // $this->db->group_by('ni.id_nivel');
      // return  $this->db->get()->result_array();
      $query="SELECT 
              CASE  
                  WHEN a.nivel = 'ESPECIAL' THEN '1'
                  WHEN a.nivel = 'INICIAL' THEN '2'
                  WHEN a.nivel = 'PREESCOLAR' THEN '3'
                  WHEN a.nivel = 'PRIMARIA' THEN '4'
                  WHEN a.nivel = 'SECUNDARIA' THEN '5'
                  WHEN a.nivel = 'MEDIA SUPERIOR' THEN '6'
                  WHEN a.nivel = 'SUPERIOR' THEN '7'
                  END AS id_nivel,a.nivel
               FROM (
              SELECT v.nivel_educativo,
                CASE  
                  WHEN v.desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  END AS nivel
                FROM vista_cct v
                INNER JOIN estadistica_e_indicadores_xcct es ON es.cct=v.cct
                WHERE (v.status= 1 OR v.status = 4) AND v.tipo_centro=9 AND v.desc_nivel_educativo NOT IN('FORMACION PARA EL TRABAJO','OTRO NIVEL EDUCATIVO','NO APLICA')
                {$concat}
                GROUP BY CASE  
                  WHEN v.desc_nivel_educativo = 'CAM' THEN 'ESPECIAL'
                  WHEN v.desc_nivel_educativo = 'INICIAL' THEN 'INICIAL'
                  WHEN v.desc_nivel_educativo = 'PREESCOLAR' THEN 'PREESCOLAR'
                  WHEN v.desc_nivel_educativo = 'PRIMARIA' THEN 'PRIMARIA'
                  WHEN v.desc_nivel_educativo = 'SECUNDARIA' THEN 'SECUNDARIA'
                  WHEN v.desc_nivel_educativo = 'MEDIA SUPERIOR' THEN 'MEDIA SUPERIOR'
                  WHEN v.desc_nivel_educativo = 'SUPERIOR' THEN 'SUPERIOR'
                  END
                  ) AS a ORDER BY FIELD(a.nivel,'ESPECIAL','INICIAL','PREESCOLAR','PRIMARIA','SECUNDARIA','MEDIA SUPERIOR','SUPERIOR')";
      return $this->db->query($query)->result_array();

    }// getall_est_ind()

    function get_nivel($id_nivel){
      if ($id_nivel==0) {
        return "TODOS";
      }
      else {
        $this->db->select('ni.nivel');
        $this->db->from('nivel as ni');
        $this->db->where('ni.id_nivel', $id_nivel);
        return  $this->db->get()->row('nivel');
      }

    }// get_nivel()

    function get_xidmunicipio_riesgo($id_municipio){
      // $this->db->select('ni.id_nivel, ni.nivel');
      // $this->db->from('nivel as ni');
      // $this->db->join('escuela as es', 'ni.id_nivel = es.id_nivel');
      // $this->db->join('municipio as mu', 'es.id_municipio = mu.id_municipio');
      // $this->db->where('ni.id_nivel', 4);
      // $this->db->or_where('ni.id_nivel', 5);
      $auxiliar="";
      if($id_municipio>0){
        $auxiliar.= " AND v.municipio= {$id_municipio} ";
      }
      // $this->db->group_by('ni.id_nivel');
      $query="SELECT 
              CASE  
                  WHEN a.nivel = 'PRIMARIA' THEN '4'
                  WHEN a.nivel = 'SECUNDARIA' THEN '5'        
                  END AS id_nivel,a.nivel
              FROM (
                    SELECT  desc_nivel_educativo AS nivel FROM vista_cct
                    WHERE desc_nivel_educativo in('PRIMARIA','SECUNDARIA')
                    AND (status= 1 OR status = 4) AND tipo_centro=9
                     {$auxiliar}
                    GROUP BY  desc_nivel_educativo   
                  ) AS a ORDER BY FIELD(a.nivel,'PRIMARIA','SECUNDARIA')";

      return $this->ce_db->query($query)->result_array();
    }// get_xidmunicipio()


}// Nivel_model
