$(function() {
    obj_info = new Info_esc();
    graf = new HaceGraficas();
    grafr = new GraficasRiesgo();
});

function goBack() {
  window.history.back();
}

function Info_esc(){
  _thisinfo = this;
}

$("#slt_ciclo_ries").change(function(){
  // console.log($("#slt_ciclo_ries").val());
  if($("#slt_ciclo_ries").val()=='2018-2019'){
    $("#slt_bimestre_ries").empty();
    $('#slt_bimestre_ries').append('<option value="1">1er Periodo</option>');
    $('#slt_bimestre_ries').append('<option value="2">2do Periodo</option>');
    $('#slt_bimestre_ries').append('<option value="3">3er Periodo</option>');

  }else{
    $("#slt_bimestre_ries").empty();
    $('#slt_bimestre_ries').append('<option value="1">1er Bimestre</option>');
    $('#slt_bimestre_ries').append('<option value="2">2do Bimestre</option>');
    $('#slt_bimestre_ries').append('<option value="3">3er Bimestre</option>');
    $('#slt_bimestre_ries').append('<option value="4">4to Bimestre</option>');
    $('#slt_bimestre_ries').append('<option value="5">5to Bimestre</option>');
  }

});

$("#btn_indice_peso").click(function(e){
              e.preventDefault();
              let cct = $("#in_cct").val();
              let turno = $("#in_turno").val();
              let nivel = $("#in_nivel").val();

  							$.ajax({
  				        url:  base_url+"info/get_indice_peso",
  				        method: 'POST',
  				        data: {'cct':cct,'turno':turno,'nivel':nivel},
  				        beforeSend: function(xhr) {
  				        	Notification.loading("");
  					  	  },
  				      })
  				      .done(function( data ) {
                  $("#div_contenedor_indpeso").empty();
                  $("#div_contenedor_indpeso").html(data.dom_view_indice_peso);
                  $("#modal_ind_peso").modal("show");
  				      })
  				      .fail(function(e) {
  				        console.error("Error in "); console.table(e);
  				      })
  				      .always(function() {
  							swal.close();
  						});
            });

$("#btn_info_asist").click(function(e){
              e.preventDefault();
              obj_info.get_alumn_doc_grup();
              obj_info.get_indica_asist();
              $( "#est_alumn_escolar_colaps" ).trigger( "click" );


            });
$("#btn_info_perma").click(function(e){
              e.preventDefault();
              obj_info.get_riesgo();
              obj_info.get_indica_perma();
              obj_info.get_prog_apoyo();

            });
$("#btn_info_aprendiz").click(function(e){
              e.preventDefault();
              obj_info.get_planea();
              obj_info.get_ete();
            });

$("#btn_buscar_ries_esc").click(function(e){
              e.preventDefault();
              obj_info.get_riesgo2();

            });

Info_esc.prototype.get_alumn_doc_grup =function(){
						$("#dv_info_aprendizaje").attr('hidden',true);
						$("#dv_info_permanencia").attr('hidden',true);
						$("#dv_info_asistencia").removeAttr('hidden');
						let cct = $("#in_cct").val();
            let turno = $("#in_turno").val();
            let nivel = $("#in_nivel").val();
							$.ajax({
				        url:  base_url+"info/info_estadistica_graf",
				        method: 'POST',
				        data: {'cct':cct,'turno':turno,'nivel':nivel},
				        beforeSend: function(xhr) {
				        	Notification.loading("");
					  	},
				      })
				      .done(function( data ) {
							let nivel = data.nivel;

							if (data.estadis_alumnos_escuela.length>0) {
						    var a_g1 =  parseInt(data.estadis_alumnos_escuela[0]['alumn_t_1']);//5;
						    var a_g2 =  parseInt(data.estadis_alumnos_escuela[0]['alumn_t_2']);//5;
						    var a_g3 =  parseInt(data.estadis_alumnos_escuela[0]['alumn_t_3']);//7;
						    var a_g4 =  parseInt(data.estadis_alumnos_escuela[0]['alumn_t_4']);//8;
						    var a_g5 =  parseInt(data.estadis_alumnos_escuela[0]['alumn_t_5']);//8;
						    var a_g6 =  parseInt(data.estadis_alumnos_escuela[0]['alumn_t_6']);//8;
						    var t_alumnos  =  parseInt(data.estadis_alumnos_escuela[0]['alumn_t_t']);//10;
						    }
						    if (data.estadis_grupos_escuela.length>0) {
						    var g_g1 =  parseInt(data.estadis_grupos_escuela[0]['grupos_1']);//3;
						    var g_g2 =  parseInt(data.estadis_grupos_escuela[0]['grupos_2']);//3;
						    var g_g3 =  parseInt(data.estadis_grupos_escuela[0]['grupos_3']);//3;
						    var g_g4 =  parseInt(data.estadis_grupos_escuela[0]['grupos_4']);//3;
						    var g_g5 =  parseInt(data.estadis_grupos_escuela[0]['grupos_5']);//3;
						    var g_g6 =  parseInt(data.estadis_grupos_escuela[0]['grupos_6']);//3;
						    var t_grupos   =  g_g1+g_g2+g_g3+g_g4+g_g5+g_g6;//10;
						  }
						    if (data.estadis_docentes_escuela.length>0) {
						    var d_g1 =  parseInt(data.estadis_docentes_escuela[0]['docentes_1_g']);//3;
						    var d_g2 =  parseInt(data.estadis_docentes_escuela[0]['docentes_2_g']);//3;
						    var d_g3 =  parseInt(data.estadis_docentes_escuela[0]['docentes_3_g']);//3;
						    var d_g4 =  parseInt(data.estadis_docentes_escuela[0]['docentes_4_g']);//3;
						    var d_g5 =  parseInt(data.estadis_docentes_escuela[0]['docentes_5_g']);//3;
						    var d_g6 =  parseInt(data.estadis_docentes_escuela[0]['docentes_6_g']);//3;
						    var t_docentes =  d_g1+d_g2+d_g3+d_g4+d_g5+d_g6;//10;
						  }



								switch(nivel) {
									case 3:
                        if (a_g1+a_g2+a_g3!=0 && (!isNaN(a_g1+a_g2+a_g3))) {
                          graf.GraficoEstadisticaSecundaria_alumn(a_g1,a_g2,a_g3,a_g1+a_g2+a_g3);
                        }
                        if (g_g1+g_g2+g_g3!=0 && (!isNaN(g_g1+g_g2+g_g3))) {
                          graf.GraficoEstadisticaSecundaria_grupos(g_g1,g_g2,g_g3,g_g1+g_g2+g_g3);
                        }
                        if (d_g1+d_g2+d_g3!=0 && (!isNaN(d_g1+d_g2+d_g3))) {
                          graf.GraficoEstadisticaSecundaria_docentes(d_g1,d_g2,d_g3,d_g1+d_g2+d_g3);
                        }

									break;
									case 4:
                          if (t_alumnos!=0 && (!isNaN(t_alumnos))) {
                            graf.GraficoEstadisticaPrimaria_alumn(a_g1,a_g2,a_g3,a_g4,a_g5,a_g6,t_alumnos);
                          }
                          if (t_grupos!=0 && (!isNaN(t_grupos))) {
                            graf.GraficoEstadisticaPrimaria_grupos(g_g1,g_g2,g_g3,g_g4,g_g5,g_g6,t_grupos);
                          }
                          if (t_docentes!=0 && (!isNaN(t_docentes))) {
                            graf.GraficoEstadisticaPrimaria_docentes(d_g1,d_g2,d_g3,d_g4,d_g5,d_g6,t_docentes);
                          }
									break;
									case 5:

                          if (a_g1+a_g2+a_g3!=0 && (!isNaN(a_g1+a_g2+a_g3))) {
                            graf.GraficoEstadisticaSecundaria_alumn(a_g1,a_g2,a_g3,a_g1+a_g2+a_g3);
                          }
                          if (g_g1+g_g2+g_g3!=0 && (!isNaN(g_g1+g_g2+g_g3))) {
                            graf.GraficoEstadisticaSecundaria_grupos(g_g1,g_g2,g_g3,g_g1+g_g2+g_g3);
                          }
                          if (d_g1+d_g2+d_g3!=0 && (!isNaN(d_g1+d_g2+d_g3))) {
                            graf.GraficoEstadisticaSecundaria_docentes(d_g1,d_g2,d_g3,d_g1+d_g2+d_g3);
                          }
									break;

									default:
													graf.GraficoEstadisticaOtros(t_alumnos,t_grupos,t_docentes);
									break;

								}


				      })
				      .fail(function(e) {
				        console.error("Error in "); console.table(e);
				      })
				      .always(function() {
							swal.close();
						});
},

Info_esc.prototype.get_indica_asist =function(){
            $("#dv_info_graf_Cobertura").empty();
            $("#dv_info_graf_Absorcion").empty();
            $("#lb_ind_asisten").empty();
						let cct = $("#in_cct").val();
            let turno = $("#in_turno").val();
            let nivel = $("#in_nivel").val();
							$.ajax({
				        url:  base_url+"info/info_indica_asis",
				        method: 'POST',
				        data: {'cct':cct,'turno':turno,'nivel':nivel},
				        beforeSend: function(xhr) {
				        	Notification.loading("");
					  	  },
				      })
				      .done(function( data ) {
							let nivel = data.nivel;
              if (nivel==4) {
                $("#lb_ind_asisten").text("Ciclo escolar: FIN- 2017-2019");
              }
              else if (nivel==5 || nivel==6) {
                $("#lb_ind_asisten").text("Ciclo escolar: FIN- 2017-2019");
              }
							if (data.indica_asisten.length>0) {
						    var a_cob =  (data.indica_asisten[0]['cobertura']);//5;
						    var a_abs =  (data.indica_asisten[0]['absorcion']);//5;
                graf.DibujarRadialProgressBarcobertura(a_cob);
                graf.DibujarRadialProgressBarabsorcion(a_abs);
                }



				      })
				      .fail(function(e) {
				        console.error("Error in "); console.table(e);
				      })
				      .always(function() {
							swal.close();
						});
},

Info_esc.prototype.get_indica_perma =function(){
            $("#dv_info_graf_Retencion").empty();
            $("#dv_info_graf_Aprobacion").empty();
            $("#dv_info_graf_Eficiencia_Terminal").empty();
            $("#lb_ind_perma").empty();
						let cct = $("#in_cct").val();
            let turno = $("#in_turno").val();
            let nivel = $("#in_nivel").val();
							$.ajax({
				        url:  base_url+"info/info_indica_perma",
				        method: 'POST',
				        data: {'cct':cct,'turno':turno,'nivel':nivel},
				        beforeSend: function(xhr) {
				        	Notification.loading("");
					  	},
				      })
				      .done(function( data ) {
							let nivel = data.nivel;
              if (nivel==4) {
                $("#lb_ind_perma").text("Ciclo escolar: FIN- 2015-2016");
              }
              else if (nivel==5 || nivel==6) {
                $("#lb_ind_perma").text("Ciclo escolar: FIN- 2016-2017");
              }
							if (data.indica_perma.length>0) {
                $("#indiperma").removeAttr('hidden');
						    var a_ret =  (data.indica_perma[0]['retencion']);//5;
						    var a_apr =  (data.indica_perma[0]['aprobacion']);//5;
                var a_efi =  (data.indica_perma[0]['et']);//5;

                graf.DibujarRadialProgressBarretencion(a_ret);
                graf.DibujarRadialProgressBaraprobacion(a_apr);
                graf.DibujarRadialProgressBaraefi(a_efi);
                }
                else{
    							$("#indiperma").attr('hidden',true);
                }




				      })
				      .fail(function(e) {
				        console.error("Error in "); console.table(e);
				      })
				      .always(function() {
							swal.close();
						});
},

Info_esc.prototype.get_prog_apoyo =function(){
            $("#tab_prog_apoyo").empty();
						let cct = $("#in_cct").val();
            let turno = $("#in_turno").val();
            let nivel = $("#in_nivel").val();

							$.ajax({
				        url:  base_url+"info/info_prog_apoyo",
				        method: 'POST',
				        data: {'cct':cct,'turno':turno,'nivel':nivel},
				        beforeSend: function(xhr) {
				        	Notification.loading("");
					  	},
				      })
				      .done(function( data ) {
							let programas = data.programs;
              var str_view_table='';

              str_view_table+="<div class='col'>";
            str_view_table+="<div class='table-responsive'>";

            str_view_table+="<table id='tabla_planea' class='table table-gray table-hover'>";
            str_view_table+="<thead>";
            str_view_table+="<tr>";
            str_view_table+="<th class='text-center'>";
            str_view_table+="<br><span style='font-weight:normal'>No.</span></th>";
            str_view_table+="<th class='text-center'>";
            str_view_table+="<br><span style='font-weight:normal'>Nombre del programa</span>";
            str_view_table+="</th>    <th class='text-center'>";
            str_view_table+="<br><span style='font-weight:normal'>Nombre corto</span></th>";
            str_view_table+="<th class='text-center'>";
            str_view_table+="<br><span style='font-weight:normal'>Ciclo escolar</span></th>";
            str_view_table+="</tr>";
      		str_view_table+="</thead>";
      			str_view_table+="<tbody>";
            programas.forEach(function(value, index) {
              str_view_table+="<tr>";
              str_view_table+="<th class='text-center'>";
              str_view_table+=""+value.rowNumber+"</th>";
              str_view_table+="<th class='text-center'>";
              str_view_table+=""+value.descripcion+"";
              str_view_table+="</th>    <th class='text-center'>";
              str_view_table+=""+value.programa_apoyo+"</th>";
              str_view_table+="<th class='text-center'>";
              str_view_table+=""+value.ciclo+"</th>";
              str_view_table+="</tr>";
            });


            str_view_table+="</tbody>";
            str_view_table+="</table>";
            str_view_table+="</div>";
      			str_view_table+="</div>";

            $("#tab_prog_apoyo").empty();

            $("#tab_prog_apoyo").append(str_view_table);
            if (programas.length>0) {
              $("#prog_apoyo").removeAttr('hidden');
              }
              else{
                $("#prog_apoyo").attr('hidden',true);
              }


				      })
				      .fail(function(e) {
				        console.error("Error in "); console.table(e);
				      })
				      .always(function() {
							swal.close();
						});
},

Info_esc.prototype.get_riesgo =function(){
	$("#dv_info_asistencia").attr('hidden',true);
	$("#dv_info_permanencia").removeAttr('hidden');
	$("#dv_info_aprendizaje").attr('hidden',true);
	let cct = $("#in_cct").val();
  let turno = $("#in_turno").val();
  let nivel = $("#in_nivel").val();
  let ciclo=$("#slt_ciclo_ries").val();
  let id_bim = $("#slt_bimestre_ries").val();

  if(ciclo=='2018-2019' && id_bim==3){
    alert("Periodo no disponible");
  }else{

		$.ajax({
			url:  base_url+"info/info_riesgo_graf",
			method: 'POST',
			data: {'cct':cct,'turno':turno,'nivel':nivel,'id_bim':id_bim,'ciclo':ciclo},
			beforeSend: function(xhr) {
				Notification.loading("");
			}
		})
		.done(function( data ) {

			var nivel = data.nivel;
      if (data.graph_pie_riesgo.length>0) {
				var q1 = parseInt(data.graph_pie_riesgo[0]['muy_alto']);
  			var q2 = parseInt(data.graph_pie_riesgo[0]['alto']);
  			var q3 = parseInt(data.graph_pie_riesgo[0]['medio']);
  			var q4 = parseInt(data.graph_pie_riesgo[0]['bajo']);
      }

      if (data.graph_bar_riesgo.length>0) {
				var t1 = parseInt(data.graph_bar_riesgo[0]['muyalto_1']);
			  var t2 = parseInt(data.graph_bar_riesgo[0]['muyalto_2']);
			  var t3 = parseInt(data.graph_bar_riesgo[0]['muyalto_3']);
			  var t4 = parseInt(data.graph_bar_riesgo[0]['muyalto_4']);
			  var t5 = parseInt(data.graph_bar_riesgo[0]['muyalto_5']);
			  var t6 = parseInt(data.graph_bar_riesgo[0]['muyalto_6']);
      }

      if (q1==0) {
        $("#dv_barras_muyaltor").attr('hidden',true);
      }
      else {
        $("#dv_barras_muyaltor").removeAttr('hidden');
      }

								switch(nivel) {

								case 4:
                          $("#total_bajas").text(data.numero_bajas[0]['total']);
													$("#dv_riesgo_esc_pie").empty();
													$("#dv_riesgo_esc_bar").empty();
													grafr.TablaPieGraficaPie(q1,q2,q3,q4);

													grafr.TablaPieGraficaBarPrimaria(t1,t2,t3,t4,t5,t6);
                          $("#dv_riesgtab_esc_bar").empty();
                          var html_tbm_riego='';
                          html_tbm_riego += '<div class="col-sm-6">';
                          html_tbm_riego += '                    <table id="tabla_bar_info" class="table table-gray table-hover">';
                          html_tbm_riego += '                      <thead>';
                          html_tbm_riego += '                        <tr>';
                          html_tbm_riego += '                          <th class="text-center"></th>';
                          html_tbm_riego += '                          <th class="text-center">1°</th>';
                          html_tbm_riego += '                          <th class="text-center">2°</th>';
                          html_tbm_riego += '                          <th class="text-center">3°</th>';
                          html_tbm_riego += '                          <th class="text-center">4°</th>';
                          html_tbm_riego += '                          <th class="text-center">5°</th>';
                          html_tbm_riego += '                          <th class="text-center">6°</th>';
                          html_tbm_riego += '                        </tr>';
                          html_tbm_riego += '                      </thead>';
                          html_tbm_riego += '                      <tbody>';
                          html_tbm_riego += '                        <tr>';
                          html_tbm_riego += '                          <th class="text-center">Muy alto</th>';
                          html_tbm_riego += '                          <td class="text-center">'+(t1)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t2)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t3)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t4)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t5)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t6)+'</td>';
                          html_tbm_riego += '                        </tr>';
                          html_tbm_riego += '                      </tbody>';
                          html_tbm_riego += '                    </table>';
                          html_tbm_riego += '';
                          html_tbm_riego += '                  </div>';

                      $("#dv_riesgtab_esc_bar").append(html_tbm_riego);

                      $("#dv_riesgotab_esc_pie").empty();
                      var html_tb_riego='';
                      html_tb_riego +='<div class="row">';
                      html_tb_riego +='  <div class="col-sm-6">';
                      html_tb_riego+='    <table id="tabla_pie_info" class="table table-gray table-hover">';
                      html_tb_riego+='      <thead>';
                      html_tb_riego+='        <tr>';
                      html_tb_riego+='          <th class="text-center">Total</th>';
                      html_tb_riego+='          <th class="text-center">Muy alto</th>';
                      html_tb_riego+='          <th class="text-center">Alto</th>';
                      html_tb_riego+='          <th class="text-center">Medio</th>';
                      html_tb_riego+='          <th class="text-center">Bajo</th>';
                      html_tb_riego+='        </tr>';
                      html_tb_riego+='      </thead>';
                      html_tb_riego+='      <tbody>';
                      html_tb_riego+='        <tr>';
                      html_tb_riego+='          <td class="text-center" style="font-size:1.2em; font-weight:500;">'+(q1+q2+q3+q4)+'</td>';
                      html_tb_riego+='          <td class="text-center" style="background-color:#FF0000; color:white; font-size:1.2em; font-weight:600;">'+(q1)+'</td>';
                      html_tb_riego+='          <td class="text-center" style="background-color:#FF9900; font-size:1.2em; font-weight:500;">'+(q2)+'</td>';
                      html_tb_riego+='          <td class="text-center" style="background-color:#FFFF00; font-size:1.2em; font-weight:500;">'+(q3)+'</td>';
                      html_tb_riego+='          <td class="text-center" style="background-color:#3CB371; font-size:1.2em; font-weight:500;">'+(q4)+'</td>';
                      html_tb_riego+='        </tr>';
                      html_tb_riego+='      </tbody>';
                      html_tb_riego+='    </table>';
                    html_tb_riego+='</div>';
                  html_tb_riego+='</div>';

                  $("#dv_riesgotab_esc_pie").append(html_tb_riego);

								break;
								case 5:
                          $("#total_bajas").text(data.numero_bajas[0]['total']);
													$("#dv_riesgo_esc_pie").empty();
													$("#dv_riesgo_esc_bar").empty();
													grafr.TablaPieGraficaPie(q1,q2,q3,q4);
													grafr.TablaPieGraficaBarSecundaria(t1,t2,t3);
                          $("#dv_riesgtab_esc_bar").empty();
                          var html_tbm_riego='';
                          html_tbm_riego += '<div class="col-sm-6">';
                          html_tbm_riego += '                    <table id="tabla_bar_info" class="table table-gray table-hover">';
                          html_tbm_riego += '                      <thead>';
                          html_tbm_riego += '                        <tr>';
                          html_tbm_riego += '                          <th class="text-center"></th>';
                          html_tbm_riego += '                          <th class="text-center">1°</th>';
                          html_tbm_riego += '                          <th class="text-center">2°</th>';
                          html_tbm_riego += '                          <th class="text-center">3°</th>';
                          html_tbm_riego += '                        </tr>';
                          html_tbm_riego += '                      </thead>';
                          html_tbm_riego += '                      <tbody>';
                          html_tbm_riego += '                        <tr>';
                          html_tbm_riego += '                          <th class="text-center">Muy alto</th>';
                          html_tbm_riego += '                          <td class="text-center">'+(t1)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t2)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t3)+'</td>';
                          html_tbm_riego += '                        </tr>';
                          html_tbm_riego += '                      </tbody>';
                          html_tbm_riego += '                    </table>';
                          html_tbm_riego += '';
                          html_tbm_riego += '                  </div>';

                      $("#dv_riesgtab_esc_bar").append(html_tbm_riego);

                      $("#dv_riesgotab_esc_pie").empty();
                      var html_tb_riego='';
                      html_tb_riego +='<div class="row">';
                      html_tb_riego +='  <div class="col-sm-6">';
                      html_tb_riego+='    <table id="tabla_pie_info" class="table table-gray table-hover">';
                      html_tb_riego+='      <thead>';
                      html_tb_riego+='        <tr>';
                      html_tb_riego+='          <th class="text-center">Total</th>';
                      html_tb_riego+='          <th class="text-center">Muy alto</th>';
                      html_tb_riego+='          <th class="text-center">Alto</th>';
                      html_tb_riego+='          <th class="text-center">Medio</th>';
                      html_tb_riego+='          <th class="text-center">Bajo</th>';
                      html_tb_riego+='        </tr>';
                      html_tb_riego+='      </thead>';
                      html_tb_riego+='      <tbody>';
                      html_tb_riego+='        <tr>';
                      html_tb_riego+='          <td class="text-center" style="font-size:1.2em; font-weight:500;">'+(q1+q2+q3+q4)+'</td>';
                      html_tb_riego+='          <td class="text-center" style="background-color:#FF0000; color:white; font-size:1.2em; font-weight:600;">'+(q1)+'</td>';
                      html_tb_riego+='          <td class="text-center" style="background-color:#FF9900; font-size:1.2em; font-weight:500;">'+(q2)+'</td>';
                      html_tb_riego+='          <td class="text-center" style="background-color:#FFFF00; font-size:1.2em; font-weight:500;">'+(q3)+'</td>';
                      html_tb_riego+='          <td class="text-center" style="background-color:#3CB371; font-size:1.2em; font-weight:500;">'+(q4)+'</td>';
                      html_tb_riego+='        </tr>';
                      html_tb_riego+='      </tbody>';
                      html_tb_riego+='    </table>';
                    html_tb_riego+='</div>';
                  html_tb_riego+='</div>';

                  $("#total_bajas").text("4");

                  $("#dv_riesgotab_esc_pie").append(html_tb_riego);
								break;

								default:

								break;

								}


				      })
				      .fail(function(e) {
				        console.error("Error in "); console.table(e);
				      })
				      .always(function() {
							swal.close();
						});
  }
},

Info_esc.prototype.get_planea =function(){

	$("#dv_info_asistencia").attr('hidden',true);
							$("#dv_info_permanencia").attr('hidden',true);
							$("#dv_info_aprendizaje").removeAttr('hidden');
							let cct = $("#in_cct").val();
              let turno = $("#in_turno").val();
              let nivel = $("#in_nivel").val();
							$.ajax({
								url:  base_url+"info/info_plaea_graf",
								method: 'POST',
								data: {'cct':cct,'turno':turno,'nivel':nivel},
								beforeSend: function(xhr) {
							        Notification.loading("");
							    },
							})
							.done(function( data ) {
								let nivel = data.nivel;

								if (data.planea15_escuela.length>0) {
								var lyc1_15  = parseFloat(data.planea15_escuela[0]['lyc_i']);
								var lyc2_15  = parseFloat(data.planea15_escuela[0]['lyc_ii']);
								var lyc3_15  = parseFloat(data.planea15_escuela[0]['lyc_iii']);
								var lyc4_15  = parseFloat(data.planea15_escuela[0]['lyc_iv']);
								var mat1_15  = parseFloat(data.planea15_escuela[0]['mat_i']);
								var mat2_15  = parseFloat(data.planea15_escuela[0]['mat_ii']);
								var mat3_15  = parseFloat(data.planea15_escuela[0]['mat_iii']);
								var mat4_15  = parseFloat(data.planea15_escuela[0]['mat_iv']);
							}

						if (data.planea16_escuela.length>0) {
								var lyc1_16  = parseFloat(data.planea16_escuela[0]['lyc_i']);
								var lyc2_16  = parseFloat(data.planea16_escuela[0]['lyc_ii']);
								var lyc3_16  = parseFloat(data.planea16_escuela[0]['lyc_iii']);
								var lyc4_16  = parseFloat(data.planea16_escuela[0]['lyc_iv']);
								var mat1_16  = parseFloat(data.planea16_escuela[0]['mat_i']);
								var mat2_16  = parseFloat(data.planea16_escuela[0]['mat_ii']);
								var mat3_16  = parseFloat(data.planea16_escuela[0]['mat_iii']);
								var mat4_16  = parseFloat(data.planea16_escuela[0]['mat_iv']);
							}

              if (data.planea17_escuela.length>0) {
  								var lyc1_17  = parseFloat(data.planea17_escuela[0]['lyc_i']);
  								var lyc2_17  = parseFloat(data.planea17_escuela[0]['lyc_ii']);
  								var lyc3_17  = parseFloat(data.planea17_escuela[0]['lyc_iii']);
  								var lyc4_17  = parseFloat(data.planea17_escuela[0]['lyc_iv']);
  								var mat1_17  = parseFloat(data.planea17_escuela[0]['mat_i']);
  								var mat2_17  = parseFloat(data.planea17_escuela[0]['mat_ii']);
  								var mat3_17  = parseFloat(data.planea17_escuela[0]['mat_iii']);
  								var mat4_17  = parseFloat(data.planea17_escuela[0]['mat_iv']);
  							}
                if (data.planea18_escuela.length>0) {
    								var lyc1_18  = parseFloat(data.planea18_escuela[0]['lyc_i']);
    								var lyc2_18  = parseFloat(data.planea18_escuela[0]['lyc_ii']);
    								var lyc3_18  = parseFloat(data.planea18_escuela[0]['lyc_iii']);
    								var lyc4_18  = parseFloat(data.planea18_escuela[0]['lyc_iv']);
    								var mat1_18  = parseFloat(data.planea18_escuela[0]['mat_i']);
    								var mat2_18  = parseFloat(data.planea18_escuela[0]['mat_ii']);
    								var mat3_18  = parseFloat(data.planea18_escuela[0]['mat_iii']);
    								var mat4_18  = parseFloat(data.planea18_escuela[0]['mat_iv']);
    							}
                 if (data.planea19_escuela.length>0) {
                    var lyc1_19  = parseFloat(data.planea19_escuela[0]['lyc_i']);
                    var lyc2_19  = parseFloat(data.planea19_escuela[0]['lyc_ii']);
                    var lyc3_19  = parseFloat(data.planea19_escuela[0]['lyc_iii']);
                    var lyc4_19  = parseFloat(data.planea19_escuela[0]['lyc_iv']);
                    var mat1_19  = parseFloat(data.planea19_escuela[0]['mat_i']);
                    var mat2_19  = parseFloat(data.planea19_escuela[0]['mat_ii']);
                    var mat3_19  = parseFloat(data.planea19_escuela[0]['mat_iii']);
                    var mat4_19  = parseFloat(data.planea19_escuela[0]['mat_iv']);
                  }

                if ((lyc1_16+lyc2_16+lyc3_16+lyc4_16+mat1_16+mat2_16+mat3_16+mat4_16)>0) {
                  $("#dv_lyc_mat_esc_nl").removeAttr('hidden');}
                else {
                  $("#dv_lyc_mat_esc_nl").attr('hidden',true);
                }

                if (data.graph_cont_tema_lyc.length>0) {
                  $("#dv_lyc_esc").removeAttr('hidden');
                }
                else{
                  $("#dv_lyc_esc").attr('hidden',true);
                }
               // Por Unidades de Análisis lyc
               if (data.graph_cont_tema_mate.length>0) {
                 $("#dv_mat_esc").removeAttr('hidden');
                }
                else{
                  $("#dv_mat_esc").attr('hidden',true);
                }

								switch(nivel) {

									case 3:

													if (data.graph_cont_tema_lyc.length==0) {
															$("#dv_info_aprendizaje").empty();
														}
													 // Por Unidades de Análisis lyc
													 if (data.graph_cont_tema_mate.length==0) {
															$("#dv_info_graf_contmat").empty();
															$("#dv_info_graf_contmat").append('<input type="text" value="No se encontraron datos">');
														}
									break;
									case 4:

														if (data.graph_cont_tema_lyc.length>0) {
															graf.graficoplanea_ud_prim_lyc(data.graph_cont_tema_lyc,data.cct,data.turno,data.nivel);
														}
														else{
															$("#dv_info_graf_contlyc").empty();
															$("#dv_info_graf_contlyc").append('<input type="text" value="No se encontraron datos">');
														}
													 // Por Unidades de Análisis lyc
													 if (data.graph_cont_tema_mate.length>0) {
															graf.graficoplanea_ud_prim_mate(data.graph_cont_tema_mate,data.cct,data.turno,data.nivel);
														}
														else{
															$("#dv_info_graf_contmat").empty();
															$("#dv_info_graf_contmat").append('<input type="text" value="No se encontraron datos">');
														}

                            if (data.planea16_escuela.length>0 && data.planea18_escuela.length>0) {
            									graf.PieDrilldownPlanea05y06(lyc1_16,lyc2_16,lyc3_16,lyc4_16,mat1_16,mat2_16,mat3_16,mat4_16,lyc1_18,lyc2_18,lyc3_18,lyc4_18,mat1_18,mat2_18,mat3_18,mat4_18);
            								}
            								else{
            									$("#tabla_planea").empty();
            									$("#dv_info_graf_nlogrolyc").empty();
            										$("#dv_info_graf_nlogrolyc").append('<input type="text" value="No se encontraron datos">');
            										$("#dv_info_graf_nlogromat").empty();
            								}

									break;
									case 5:

														if (data.graph_cont_tema_lyc.length>0) {
															graf.graficoplanea_ud_secu_lyc(data.graph_cont_tema_lyc,data.cct,data.turno,data.nivel);
														}
														else{
															$("#dv_info_graf_contlyc").empty();
															$("#dv_info_graf_contlyc").append('<input type="text" value="No se encontraron datos">');
														}
													 // Por Unidades de Análisis lyc
													 if (data.graph_cont_tema_mate.length>0) {
															graf.graficoplanea_ud_secu_mate(data.graph_cont_tema_mate,data.cct,data.turno,data.nivel);
														}
														else{
															$("#dv_info_graf_contmat").empty();
															$("#dv_info_graf_contmat").append('<input type="text" value="No se encontraron datos">');
														}

                            if (data.planea16_escuela.length>0 && data.planea17_escuela.length>0) {

            									graf.PieDrilldownPlanea05y06(lyc1_16,lyc2_16,lyc3_16,lyc4_16,mat1_16,mat2_16,mat3_16,mat4_16,lyc1_17,lyc2_17,lyc3_17,lyc4_17,mat1_17,mat2_17,mat3_17,mat4_17);
            								}
            								else{
            									$("#tabla_planea").empty();
            									$("#dv_info_graf_nlogrolyc").empty();
            										$("#dv_info_graf_nlogrolyc").append('<input type="text" value="No se encontraron datos">');
            										$("#dv_info_graf_nlogromat").empty();
            								}

                              if (data.planea16_escuela.length>0 && data.planea17_escuela.length>0 && data.planea19_escuela.length>0) {
                              graf.PieDrilldownPlanea05y06y07(lyc1_16,lyc2_16,lyc3_16,lyc4_16,mat1_16,mat2_16,mat3_16,mat4_16,lyc1_17,lyc2_17,lyc3_17,lyc4_17,mat1_17,mat2_17,mat3_17,mat4_17,lyc1_19,lyc2_19,lyc3_19,lyc4_19,mat1_19,mat2_19,mat3_19,mat4_19);
                            }
                            else{
                              $("#tabla_planea").empty();
                              $("#dv_info_graf_nlogrolyc").empty();
                                $("#dv_info_graf_nlogrolyc").append('<input type="text" value="No se encontraron datos">');
                                $("#dv_info_graf_nlogromat").empty();
                            }



									break;

                  case 6:

                  if (data.graph_cont_tema_lyc.length>0) {
                    graf.graficoplanea_ud_ms_lyc(data.graph_cont_tema_lyc,data.cct,data.turno,data.nivel);
                  }
                  else{
                    $("#dv_info_graf_contlyc").empty();
                    $("#dv_info_graf_contlyc").append('<input type="text" value="No se encontraron datos">');
                  }
                 // Por Unidades de Análisis lyc
                 if (data.graph_cont_tema_mate.length>0) {
                    graf.graficoplanea_ud_ms_mate(data.graph_cont_tema_mate,data.cct,data.turno,data.nivel);
                  }
                  else{
                    $("#dv_info_graf_contmat").empty();
                    $("#dv_info_graf_contmat").append('<input type="text" value="No se encontraron datos">');
                  }

                  if (data.planea16_escuela.length>0 && data.planea17_escuela.length>0) {
                    graf.PieDrilldownPlanea05y06(lyc1_16,lyc2_16,lyc3_16,lyc4_16,mat1_16,mat2_16,mat3_16,mat4_16,lyc1_17,lyc2_17,lyc3_17,lyc4_17,mat1_17,mat2_17,mat3_17,mat4_17);
                  }
                  else{
                    $("#tabla_planea").empty();
                    $("#dv_info_graf_nlogrolyc").empty();
                      $("#dv_info_graf_nlogrolyc").append('<input type="text" value="No se encontraron datos">');
                      $("#dv_info_graf_nlogromat").empty();
                  }

                  break;

									default:
													$("#dv_info_aprendizaje").empty();
									break;


								}
                let cont_lyc = data.graph_cont_tema_lyc;
                let auxsum_lyc=0;
                for (var i = 0; i < cont_lyc.length; i++){
                   auxsum_lyc+=parseFloat(cont_lyc[i]['porcen_alum_respok'])
                }
                if (auxsum_lyc==0) {
                  $("#dv_info_graf_contlyc").empty();
                  $("#dv_info_graf_contlyc").append('<input type="text" value="Información no disponible">');
                }

                let cont_mate = data.graph_cont_tema_mate;
                let auxsum_mate=0;
                for (var i = 0; i < cont_mate.length; i++){
                   auxsum_mate+=parseFloat(cont_mate[i]['porcen_alum_respok'])
                }

                if (auxsum_mate==0) {
                  $("#dv_info_graf_contmat").empty();
                  $("#dv_info_graf_contmat").append('<input type="text" value="Información no disponible">');
                }


							})
							.fail(function(e) {
								console.error("Error in "); console.table(e);
							})
							.always(function() {
							swal.close();
						});
},

Info_esc.prototype.get_ete =function(){

            $("#containerRPB03ete").empty();
            $("#lb_ind_efi").empty();
            $("#lb_ind_planea").empty();
							let cct = $("#in_cct").val();
              let turno = $("#in_turno").val();
              let nivel = $("#in_nivel").val();
							$.ajax({
								url:  base_url+"info/info_ete",
								method: 'POST',
								data: {'cct':cct,'turno':turno,'nivel':nivel},
								beforeSend: function(xhr) {
							        Notification.loading("");
							    },
							})
							.done(function( data ) {
								let nivel = data.nivel;
                if (nivel==4) {
                  $("#lb_ind_efi").text("ET_Ciclo escolar: FIN- 2015-2016");
                  $("#lb_ind_planea").text("PLANEA 2016");
                }else if (nivel==5 || nivel==6) {
                  $("#lb_ind_efi").text("ET_Ciclo escolar: FIN- 2018-2019");
                  $("#lb_ind_planea").text("PLANEA 2019");
                }if (data.ete>0) {
                  $("#dv_ete_esc").removeAttr('hidden');
  								var a_ete  = (data.ete);

                  graf.DibujarRadialProgressBarET(a_ete);
							  }else {

                  $("#dv_ete_esc").attr('hidden',true);
                }

							})
							.fail(function(e) {
								console.error("Error in "); console.table(e);
							})
							.always(function() {
							swal.close();
						});
},

Info_esc.prototype.get_riesgo2 =function(){
	let id_bim = $("#slt_bimestre_ries").val();
	let ciclo = $("#slt_ciclo_ries").val();
	let cct = $("#in_cct").val();
  let turno = $("#in_turno").val();
  let nivel = $("#in_nivel").val();

  if(ciclo=='2018-2019' && id_bim==3){
    alert("Periodo no disponible");
  }else{
							$.ajax({
				        url:  base_url+"info/info_riesgo_graf",
				        method: 'POST',
				        data: {'cct':cct,'id_bim':id_bim,'ciclo':ciclo,'turno':turno,'nivel':nivel},
				        beforeSend: function(xhr) {
							        Notification.loading("");
							    },
				      })
				      .done(function( data ) {

				      	$("#total_bajas").text(data.numero_bajas[0]['total']);
								let nivel = data.nivel;
                let q1 = 0;
                let q2 = 0;
                let q3 = 0;
                let q4 = 0;
                let t1 = 0;
                let t2 = 0;
                let t3 = 0;
                let t4 = 0;
                let t5 = 0;
                let t6 = 0;
                if(data.graph_bar_riesgo.length>0){
  							  q1 = parseInt(data.graph_pie_riesgo[0]['muy_alto']);
  								q2 = parseInt(data.graph_pie_riesgo[0]['alto']);
  								q3 = parseInt(data.graph_pie_riesgo[0]['medio']);
  								q4 = parseInt(data.graph_pie_riesgo[0]['bajo']);
  							  t1 = parseInt(data.graph_bar_riesgo[0]['muyalto_1']);
  								t2 = parseInt(data.graph_bar_riesgo[0]['muyalto_2']);
  								t3 = parseInt(data.graph_bar_riesgo[0]['muyalto_3']);
  								t4 = parseInt(data.graph_bar_riesgo[0]['muyalto_4']);
  								t5 = parseInt(data.graph_bar_riesgo[0]['muyalto_5']);
  								t6 = parseInt(data.graph_bar_riesgo[0]['muyalto_6']);
                }
                if (q1==0) {
                  $("#dv_barras_muyaltor").attr('hidden',true);
                }
                else {
                  $("#dv_barras_muyaltor").removeAttr('hidden');
                }
								switch(nivel) {

								case 4:
													$("#dv_riesgo_esc_pie").empty();
													$("#dv_riesgo_esc_bar").empty();
													grafr.TablaPieGraficaPie(q1,q2,q3,q4);

													grafr.TablaPieGraficaBarPrimaria(t1,t2,t3,t4,t5,t6);
                          $("#dv_riesgtab_esc_bar").empty();
                          var html_tbm_riego='';
                          html_tbm_riego += '<div class="col-sm-6">';
                          html_tbm_riego += '                    <table id="tabla_bar_info" class="table table-gray table-hover">';
                          html_tbm_riego += '                      <thead>';
                          html_tbm_riego += '                        <tr>';
                          html_tbm_riego += '                          <th class="text-center"></th>';
                          html_tbm_riego += '                          <th class="text-center">1°</th>';
                          html_tbm_riego += '                          <th class="text-center">2°</th>';
                          html_tbm_riego += '                          <th class="text-center">3°</th>';
                          html_tbm_riego += '                          <th class="text-center">4°</th>';
                          html_tbm_riego += '                          <th class="text-center">5°</th>';
                          html_tbm_riego += '                          <th class="text-center">6°</th>';
                          html_tbm_riego += '                        </tr>';
                          html_tbm_riego += '                      </thead>';
                          html_tbm_riego += '                      <tbody>';
                          html_tbm_riego += '                        <tr>';
                          html_tbm_riego += '                          <th class="text-center">Muy alto</th>';
                          html_tbm_riego += '                          <td class="text-center">'+(t1)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t2)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t3)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t4)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t5)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t6)+'</td>';
                          html_tbm_riego += '                        </tr>';
                          html_tbm_riego += '                      </tbody>';
                          html_tbm_riego += '                    </table>';
                          html_tbm_riego += '';
                          html_tbm_riego += '                  </div>';

                      $("#dv_riesgtab_esc_bar").append(html_tbm_riego);

								break;
								case 5:
													$("#dv_riesgo_esc_pie").empty();
													$("#dv_riesgo_esc_bar").empty();
													grafr.TablaPieGraficaPie(q1,q2,q3,q4);
													grafr.TablaPieGraficaBarSecundaria(t1,t2,t3);
                          $("#dv_riesgtab_esc_bar").empty();
                          var html_tbm_riego='';
                          html_tbm_riego += '<div class="col-sm-6">';
                          html_tbm_riego += '                    <table id="tabla_bar_info" class="table table-gray table-hover">';
                          html_tbm_riego += '                      <thead>';
                          html_tbm_riego += '                        <tr>';
                          html_tbm_riego += '                          <th class="text-center"></th>';
                          html_tbm_riego += '                          <th class="text-center">1°</th>';
                          html_tbm_riego += '                          <th class="text-center">2°</th>';
                          html_tbm_riego += '                          <th class="text-center">3°</th>';
                          html_tbm_riego += '                        </tr>';
                          html_tbm_riego += '                      </thead>';
                          html_tbm_riego += '                      <tbody>';
                          html_tbm_riego += '                        <tr>';
                          html_tbm_riego += '                          <th class="text-center">Muy alto</th>';
                          html_tbm_riego += '                          <td class="text-center">'+(t1)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t2)+'</td>';
                          html_tbm_riego += '                          <td class="text-center">'+(t3)+'</td>';
                          html_tbm_riego += '                        </tr>';
                          html_tbm_riego += '                      </tbody>';
                          html_tbm_riego += '                    </table>';
                          html_tbm_riego += '';
                          html_tbm_riego += '                  </div>';

                      $("#dv_riesgtab_esc_bar").append(html_tbm_riego);
								break;


								default:

								break;

								}

                $("#dv_riesgotab_esc_pie").empty();
                var html_tb_riego='';
                html_tb_riego +='<div class="row">';
                html_tb_riego +='  <div class="col-sm-6">';
                html_tb_riego+='    <table id="tabla_pie_info" class="table table-gray table-hover">';
                html_tb_riego+='      <thead>';
                html_tb_riego+='        <tr>';
                html_tb_riego+='          <th class="text-center">Total</th>';
                html_tb_riego+='          <th class="text-center">Muy alto</th>';
                html_tb_riego+='          <th class="text-center">Alto</th>';
                html_tb_riego+='          <th class="text-center">Medio</th>';
                html_tb_riego+='          <th class="text-center">Bajo</th>';
                html_tb_riego+='        </tr>';
                html_tb_riego+='      </thead>';
                html_tb_riego+='      <tbody>';
                html_tb_riego+='        <tr>';
                html_tb_riego+='          <td class="text-center" style="font-size:1.2em; font-weight:500;">'+(q1+q2+q3+q4)+'</td>';
                html_tb_riego+='          <td class="text-center" style="background-color:#FF0000; color:white; font-size:1.2em; font-weight:600;">'+(q1)+'</td>';
                html_tb_riego+='          <td class="text-center" style="background-color:#FF9900; font-size:1.2em; font-weight:500;">'+(q2)+'</td>';
                html_tb_riego+='          <td class="text-center" style="background-color:#FFFF00; font-size:1.2em; font-weight:500;">'+(q3)+'</td>';
                html_tb_riego+='          <td class="text-center" style="background-color:#3CB371; font-size:1.2em; font-weight:500;">'+(q4)+'</td>';
                html_tb_riego+='        </tr>';
                html_tb_riego+='      </tbody>';
                html_tb_riego+='    </table>';
              html_tb_riego+='</div>';
            html_tb_riego+='</div>';


            $("#dv_riesgotab_esc_pie").append(html_tb_riego);

				      })
				      .fail(function(e) {
				        console.error("Error in "); console.table(e);
				      })
						.always(function() {
							swal.close();
						});
  }

}
