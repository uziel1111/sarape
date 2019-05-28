// $(function() {
//     obj_grafica = new Grafica();
// });

function Grafica(){
  _this = this;
}

// $("#btn_buscar_ries_muni").click(function() {
//   var id_minicipio = $("#slt_municipio_ries").val();
//   var id_nivel = $("#slt_nivel_ries").val();
//   var id_bimestre = $("#slt_bimestre_ries").val();
//   var id_ciclo = $("#slt_ciclo_ries").val();
//
//   // alert(id_minicipio);
//   // obj_riesgo.get_Niveles();
// });


Grafica.prototype.TablaPieGraficaPie = function(q1,q2,q3,q4){
  // var q1 = parseInt(10);
  // var q2 = parseInt(5);
  // var q3 = parseInt(3);
  // var q4 = parseInt(2);

      Highcharts.theme = {
          //colors: ['#50B432', '#07A4B5', '#ED561B', '#006080', '#24CBE5', '#64E572',
          colors: ['#FF0000', '#FF9900', '#FFFF00', '#3CB371', '#24CBE5', '#64E572',
                   '#FF9655', '#FFF263', '#058DC7'],
          chart: {
              backgroundColor: {
                  linearGradient: [0, 0, 500, 500],
                  stops: [
                      [0, 'rgb(255, 255, 255)'],
                      [1, 'rgb(240, 240, 255)']
                  ]
              },
          },
          title: {
              style: {
                  color: '#000',
                  font: 'bold 12px'
              }
          },
          subtitle: {
              style: {
                  color: '#666666',
                  font: 'bold 12px'
              }
          },

          legend: {
              itemStyle: {
                  font: '9pt',
                  color: 'black'
              },
              itemHoverStyle:{
                  color: 'gray'
              }
          }
      };

      // Apply the theme
      Highcharts.setOptions(Highcharts.theme);

      // Build the chart
      estadPrimaria= new Highcharts.chart('dv_graf_riesgo_mun_zona', {
          credits: {
              enabled: false
          },
          chart: {
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'pie'
          },
          title: {
              text: '<b style="font-size: 2.3vw;"><br>Proporciones de acuerdo a matrícula</b>'
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: true,
                      format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                      style: {
                          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                      }
                  },
                  showInLegend: false /*Ocultamos o Muy ALto  o Alto o Medio o Bajo*/
              }
          },
          series: [{
              name: 'Porcentaje',
              colorByPoint: true,
              data: [{
                  name: 'Muy alto',
                  y: q1,
                  sliced: true,
                  selected: true
              }, {
                  name: 'Alto',
                  y: q2
              }, {
                  name: 'Medio',
                  y: q3
              }, {
                  name: 'Bajo',
                  y: q4
              }]
          }]
      });

      $(".highcharts-background").css("fill","#FFF");
      if (screen.width<600){
        estadPrimaria.setSize(
            ($(document).width()/10)*5,
            400,
           false
        );
      }
      else {
        estadPrimaria.setSize(
            ($(document).width()/10)*7,
            400,
           false
        );
      }
    }

    Grafica.prototype.TablaPieGraficaBarPrimaria= function(t1,t2,t3,t4,t5,t6){

      // var t1 = parseInt(10);
      // var t2 = parseInt(5);
      // var t3 = parseInt(6);
      // var t4 = parseInt(8);
      // var t5 = parseInt(5);
      // var t6 = parseInt(3);

            Highcharts.theme = {
                colors: ['#FF0000','#FF0000','#FF0000','#FF0000','#FF0000','#FF0000',
                         '#FF0000', '#FF0000', '#FF0000'],
                chart: {
                    backgroundColor: {
                        linearGradient: [0, 0, 500, 500],
                        stops: [
                            [0, 'rgb(255, 255, 255)'],
                            [1, 'rgb(240, 240, 255)']
                        ]
                    },
                },
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 16px'
                    }
                },
                subtitle: {
                    style: {
                        color: '#666666',
                        font: 'bold 12px'
                    }
                },

                legend: {
                    itemStyle: {
                        font: '9pt',
                        color: 'black'
                    },
                    itemHoverStyle:{
                        color: 'gray'
                    }
                }
            };

            // Apply the theme
            Highcharts.setOptions(Highcharts.theme);

            // Gráfica opcion 2 para distribucion por grado Riesgo de abandono escolar
            estadPrimaria = new Highcharts.chart('dv_tab_riesgo_mun_zona', {
                credits: {
                    enabled: false
                },
                chart: {
                    type: 'column'
                },
                title: {
                    text: '<b style="font-size: 2.3vw;"><br>Distribución por grado</b>'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [
                        '1er °',
                        '2do °',
                        '3er °',
                        '4to °',
                        '5to °',
                        '6to °'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Alumnos'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        showInLegend: false /*Ocultamos a la vista del usuario   o Alumnos*/
                    }
                },
                series: [{
                    name: 'Alumnos',
                    data: [t1,t2,t3,t4,t5,t6]
                }]
            });

            // Apply background-color
            $(".highcharts-background").css("fill","#FFF");
            if (screen.width<600){
              estadPrimaria.setSize(
                  ($(document).width()/10)*5,
                  400,
                 false
              );
            }
            else {
              estadPrimaria.setSize(
                  ($(document).width()/10)*7,
                  400,
                 false
              );
            }

          }



    Grafica.prototype.TablaPieGraficaBarSecundaria= function(t1,t2,t3){
      // var t1 = parseInt(10);
      // var t2 = parseInt(5);
      // var t3 = parseInt(6);

            Highcharts.theme = {
                colors: ['#FF0000','#FF0000','#FF0000','#FF0000','#FF0000','#FF0000',
                         '#FF0000', '#FF0000', '#FF0000'],
                chart: {
                    backgroundColor: {
                        linearGradient: [0, 0, 500, 500],
                        stops: [
                            [0, 'rgb(255, 255, 255)'],
                            [1, 'rgb(240, 240, 255)']
                        ]
                    },
                },
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 16px'
                    }
                },
                subtitle: {
                    style: {
                        color: '#666666',
                        font: 'bold 12px'
                    }
                },

                legend: {
                    itemStyle: {
                        font: '9pt',
                        color: 'black'
                    },
                    itemHoverStyle:{
                        color: 'gray'
                    }
                }
            };

            // Apply the theme
            Highcharts.setOptions(Highcharts.theme);

            // Gráfica opcion 2 para distribucion por grado Riesgo de abandono escolar
            estadPrimaria = new Highcharts.chart('dv_tab_riesgo_mun_zona', {
                credits: {
                    enabled: false
                },
                chart: {
                    type: 'column'
                },
                title: {
                    text: '<b style="font-size: 2.3vw;">Distribución por grado</b>'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [
                        '1er °',
                        '2do °',
                        '3er °'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Alumnos'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        showInLegend: false
                    }
                },
                series: [{
                    name: 'Alumnos',
                    data: [t1,t2,t3]
                }]
            });

            // Apply background-color
            $(".highcharts-background").css("fill","#FFF");
            if (screen.width<600){
              estadPrimaria.setSize(
                  ($(document).width()/10)*5,
                  400,
                 false
              );
            }
            else {
              estadPrimaria.setSize(
                  ($(document).width()/10)*7,
                  400,
                 false
              );
            }

          }
