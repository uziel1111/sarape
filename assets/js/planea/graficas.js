
function Graficasm(){
    obj_graficas = this;
    $("#div_contenedor_operaciones").hide();
    $("#div_contenedor_operaciones_files").hide();
    obj_graficas.ocultamesaje_link();
    obj_graficas.ocultamesaje_file();
  }

  function showMessage(message){
      $(".messages").html("").show();
      $(".messages").html(message);
  }

      //////////////////////////////////////////////////////////// Por Unidades de Análisis
      //////////////////////////////////////////////////////////// Por Unidades de Análisis
      Graficasm.prototype.graficoplanea_ud_prim_lyc = function(arr_lyc,id_filtro, va_por, periodo){
        if (periodo == 1) {
            colores = ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900', '#FF9900','#FF9900','#FF9900','#FF9900',
                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'];
        }else{
            colores = ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900',
                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'];
        }
        arr_lyc.sort(function (a, b) {
            return (a.porcen_alum_respok - b.porcen_alum_respok)
        });
          Highcharts.theme = {
                colors: colores,
                chart: {
                    backgroundColor: {
                        linearGradient: [0, 0, 0, 0],
                        stops: [
                            [0, 'rgb(255, 255, 255)'],
                            [1, 'rgb(255, 255, 255)']
                        ]
                    },
                    width: ($(document).width()/10)*5,
                    height: ($(document).width()/10)*15
                },
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 18px'
                    }
                },
                subtitle: {
                    style: {
                        color: 'blue'
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

          var arr_lyc_aux = new Array();;
          for (var i = 0; i < arr_lyc.length; i++){
             arr_lyc_aux.push({'id_cont': arr_lyc[i]['id_contenido'],'name': arr_lyc[i]['contenidos'],'y': parseFloat(arr_lyc[i]['porcen_alum_respok']),'drilldown': arr_lyc[i]['total_reac_xua']});
          }

          // Apply the theme
          Highcharts.setOptions(Highcharts.theme);
          // Codigo para graficar la seccion estadistica de la escuela
          var estadPreescolar = new Highcharts.chart('div_graficas_masivo', {
              lang: {
                  //drillUpText: '◁ Regresar a {series.name}'
              },
              credits: {
                  enabled: false
              },
              chart: {
                  type: 'bar'
              },
              title: {
                  text: '<b style="font-size: 2.3vh;">PLANEA 2018 Lenguaje y comunicación</b>'
              },
              subtitle: {
                  text: '<b style="font-size: 1.5vh;"> Total de alumnos evaluados: '+parseInt(arr_lyc[0]['alumnos_evaluados'])+'</b>'
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: '<div style="font-size: 1.1vh;">Porcentaje de alumnos con respuestas correctas</div>'
                  }
              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                    events: {
                      click: function (event) {
                        // nada...
                      }
              },
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.1f}%'
                      }
                  },

                  // agregamos a la columna la propiedad para el clik y enviar el nombre a una función
                  bar :{
                       point:{
                           events:{
                               click:function(){
                                  obj_graficas.get_reactivos_xunidad_de_analisis(this.name,this.id_cont,id_filtro,3,1, va_por);
                               }
                           }
                       }
                   }
                  //
              },

              tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><b>{point.y}%</b><br>',
                pointFormat: '<span style="font-size:11px">Total de preguntas en el contenido temático: </span><b>{point.drilldown}</b><br><span style="color:{point.color}">{point.name}</span>'
              },

              series: [{
                  name: 'Porcentaje de alumnos con respuestas correctas: ',
                  colorByPoint: true,
                  data: arr_lyc_aux
              }],

          });

          $(".highcharts-background").css("fill","#FFF");

      }// graficoplanea_ud_prim_lyc()

      Graficasm.prototype.graficoplanea_ud_prim_mate = function(arr_mate,id_filtro, va_por, periodo){
        if (periodo == 1) {
            colores = ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'];
        }else{
            colores = ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'];
        }
        arr_mate.sort(function (a, b) {
            return (a.porcen_alum_respok - b.porcen_alum_respok)
        });
          Highcharts.theme = {
                colors: colores,
                chart: {
                    backgroundColor: {
                        linearGradient: [0, 0, 0, 0],
                        stops: [
                            [0, 'rgb(255, 255, 255)'],
                            [1, 'rgb(255, 255, 255)']
                        ]
                    },
                    width: ($(document).width()/10)*5,
                    height: ($(document).width()/10)*12
                },
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 18px'
                    }
                },
                subtitle: {
                    style: {
                        color: 'blue',
                        font: 'bold 20px'
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
          var arr_mate_aux = new Array();;
          for (var i = 0; i < arr_mate.length; i++){
             arr_mate_aux.push({'id_cont': arr_mate[i]['id_contenido'],'name': arr_mate[i]['contenidos'],'y': parseFloat(arr_mate[i]['porcen_alum_respok']),'drilldown': arr_mate[i]['total_reac_xua']});
          }
          // Apply the theme
          Highcharts.setOptions(Highcharts.theme);
          // Codigo para graficar la seccion estadistica de la escuela
          var estadPreescolar = new Highcharts.chart('div_graficas_masivo', {
              lang: {
                  //drillUpText: '◁ Regresar a {series.name}'
              },
              credits: {
                  enabled: false
              },
              chart: {
                  type: 'bar'
                  // width: 1000
              },
              title: {
                  text: '<b style="font-size: 2.3vh;">PLANEA 2018 Matemáticas</b>'
              },
              subtitle: {
                  text: '<b style="font-size: 1.5vh;"> Total de alumnos evaluados: '+parseInt(arr_mate[0]['alumnos_evaluados'])+'</b>'
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: '<div style="font-size: 1.1vh;">Porcentaje de alumnos con respuestas correctas</div>'
                  }
              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                    events: {
                      click: function (event) {
                        // nada...
                      }
              },
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.1f}%'
                      }
                  },
                  // agregamos a la columna la propiedad para el clik y enviar el nombre a una función
                  bar :{
                       point:{
                           events:{
                               click:function(){
                                 console.info(this);
                                  obj_graficas.get_reactivos_xunidad_de_analisis(this.name,this.id_cont,id_filtro,3,2, va_por);
                               }
                           }
                       }
                   }
              },
              tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><b>{point.y}%</b><br>',
                pointFormat: '<span style="font-size:11px">Total de preguntas en el contenido temático: </span><b>{point.drilldown}</b><br><span style="color:{point.color}">{point.name}</span>'

              },
              series: [{
                  name: 'Porcentaje de alumnos con respuestas correctas: ',
                  colorByPoint: true,
                  data: arr_mate_aux
              }],
          });

          $(".highcharts-background").css("fill","#FFF");

      }// graficoplanea_ud_prim_mate()

      Graficasm.prototype.graficoplanea_ud_secu_lyc = function(arr_lyc,id_cct, va_por){
        // console.info(arr_lyc);
        arr_lyc.sort(function (a, b) {
            return (a.porcen_alum_respok - b.porcen_alum_respok)
        });
          Highcharts.theme = {
                colors: ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',


                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'],

                legend: {
                    itemStyle: {
                        font: '9pt',
                        color: 'black'
                    },
                    itemHoverStyle:{
                        color: 'gray'
                    },
                    enabled: false
                }
          };

          Highcharts.setOptions(Highcharts.theme);

          var arr_lyc_aux = new Array();;
          for (var i = 0; i < arr_lyc.length; i++){
             arr_lyc_aux.push({'id_cont': arr_lyc[i]['id_contenido'],'name': arr_lyc[i]['contenidos'],'y': parseFloat(arr_lyc[i]['porcen_alum_respok']),'drilldown': arr_lyc[i]['total_reac_xua']});
          }

          // Apply the theme

          // Codigo para graficar la seccion estadistica de la escuela
          var estadPreescolar = new Highcharts.chart('div_graficas_masivo', {
              lang: {
                  //drillUpText: '◁ Regresar a {series.name}'
              },
              credits: {
                  enabled: false
              },
              chart: {
                  type: 'bar',
                  backgroundColor: {
                      linearGradient: [0, 0, 0, 0],
                      stops: [
                          [0, 'rgb(255, 255, 255)'],
                          [1, 'rgb(255, 255, 255)']
                      ]
                  },
                  width: ($(document).width()/10)*6,
                  height: ($(document).width()/10)*12
              },
              title: {
                  text: '<b style="font-size: 2.3vh;">PLANEA 2017</b>'
              },
              subtitle: {
                  text: '<b style="font-size: 1.5vh;"> Total de alumnos evaluados: '+arr_lyc[0]['alumnos_evaluados']+'</b>'
              },
              xAxis: {
                  type: 'category'
              },

              yAxis: {
                  title: {
                      text: '<div style="font-size: 1.1vh;">Porcentaje de alumnos con respuestas correctas</div>'
                      // text: '<div>Porcentaje de alumnos con respuestas correctas</div>'
                  },
              },

              plotOptions: {
                  series: {
                    events: {
                      click: function (event) {
                        // nada...
                      }
                     },
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.1f}%'

                      }
                  },

                  // agregamos a la columna la propiedad para el clik y enviar el nombre a una función
                  bar :{
                       point:{
                           events:{
                               click:function(){
                                var periodo = $('#slt_periodo_planeaxm option:selected').val();
                                console.log(periodo);
                                  obj_graficas.get_reactivos_xunidad_de_analisis(this.name,this.id_cont,id_cct,periodo,1, va_por);
                               }
                           }
                       }
                   }
                  //
              },

              tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><b>{point.y}%</b><br>',
                pointFormat: '<span style="font-size:11px">Total de preguntas en el contenido temático: </span><b>{point.drilldown}</b><br><span style="color:{point.color}">{point.name}</span>'
              },

              series: [{
                  name: 'Porcentaje de alumnos con respuestas correctas: ',
                  colorByPoint: true,
                  data: arr_lyc_aux
              }],

          });


          $(".highcharts-background").css("fill","#FFF");

      }// graficoplanea_ud_secu_lyc()

      Graficasm.prototype.graficoplanea_ud_secu_mate = function(arr_mate,id_cct, va_por){
        // console.info(arr_mate);
        arr_mate.sort(function (a, b) {
            return (a.porcen_alum_respok - b.porcen_alum_respok)
        });
          Highcharts.theme = {
                colors: ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900',
                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'],
                chart: {
                    backgroundColor: {
                        linearGradient: [0, 0, 0, 0],
                        stops: [
                            [0, 'rgb(255, 255, 255)'],
                            [1, 'rgb(255, 255, 255)']
                        ]
                    },
                    width: ($(document).width()/10)*6,
                    height: ($(document).width()/10)*12
                },
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 18px'
                    }
                },
                subtitle: {
                    style: {
                        color: 'blue',
                        font: 'bold 20px'
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
          var arr_mate_aux = new Array();;
          for (var i = 0; i < arr_mate.length; i++){
             arr_mate_aux.push({'id_cont': arr_mate[i]['id_contenido'],'name': arr_mate[i]['contenidos'],'y': parseFloat(arr_mate[i]['porcen_alum_respok']),'drilldown': arr_mate[i]['total_reac_xua']});
          }
          // Apply the theme
          Highcharts.setOptions(Highcharts.theme);
          // Codigo para graficar la seccion estadistica de la escuela
          // Create the chart
          var defaultSubtitle = "Total de alumnos evaluados: "+parseFloat(arr_mate[0]['alumnos_evaluados'])
          var estadPreescolar = new Highcharts.chart('div_graficas_masivo', {
              lang: {
                  //drillUpText: '◁ Regresar a {series.name}'
              },
              credits: {
                  enabled: false
              },
              chart: {
                  type: 'bar'
                  // width: 1000
              },
              title: {
                  text: '<b style="font-size: 2.3vh;">PLANEA 2017</b>'
              },
              subtitle: {
                  text:  '<b style="font-size: 1.5vh;"> Total de alumnos evaluados: '+arr_mate[0]['alumnos_evaluados']+'</b>'
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: '<div style="font-size: 1.1vh;">Porcentaje de alumnos con respuestas correctas</div>'
                  }
              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                    events: {
                      click: function (event) {
                        // nada...
                      }
              },
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.1f}%'
                      }
                  },
                  // agregamos a la columna la propiedad para el clik y enviar el nombre a una función
                  bar :{
                       point:{
                           events:{
                               click:function(){
                                 //console.info(this);
                                  obj_graficas.get_reactivos_xunidad_de_analisis(this.name,this.id_cont,id_cct,2,2, va_por);
                               }
                           }
                       }
                   }
              },
              tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><b>{point.y}%</b><br>',
                pointFormat: '<span style="font-size:11px">Total de preguntas en el contenido temático: </span><b>{point.drilldown}</b><br><span style="color:{point.color}">{point.name}</span>'

              },
              series: [{
                  name: 'Porcentaje de alumnos con respuestas correctas: ',
                  colorByPoint: true,
                  data: arr_mate_aux
              }],
          });

          $(".highcharts-background").css("fill","#FFF");

      }// graficoplanea_ud_secu_mate()

      // Planea 2019 I
        Graficasm.prototype.graficoplanea_ud_secu_lyc19 = function(arr_lyc,id_cct, va_por){

        arr_lyc.sort(function (a, b) {
            return (a.porcen_alum_respok - b.porcen_alum_respok)
        });
          Highcharts.theme = {
                colors: ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',

                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',


                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'],

                legend: {
                    itemStyle: {
                        font: '9pt',
                        color: 'black'
                    },
                    itemHoverStyle:{
                        color: 'gray'
                    },
                    enabled: false
                }
          };

          Highcharts.setOptions(Highcharts.theme);

          var arr_lyc_aux = new Array();;
          for (var i = 0; i < arr_lyc.length; i++){
             arr_lyc_aux.push({'id_cont': arr_lyc[i]['id_contenido'],'name': arr_lyc[i]['contenidos'],'y': parseFloat(arr_lyc[i]['porcen_alum_respok']),'drilldown': arr_lyc[i]['total_reac_xua']});
          }

          // Apply the theme

          // Codigo para graficar la seccion estadistica de la escuela
          var estadPreescolar = new Highcharts.chart('div_graficas_masivo', {
              lang: {
                  //drillUpText: '◁ Regresar a {series.name}'
              },
              credits: {
                  enabled: false
              },

              chart: {
                  type: 'bar',
                  backgroundColor: {
                      linearGradient: [0, 0, 0, 0],
                      stops: [
                          [0, 'rgb(255, 255, 255)'],
                          [1, 'rgb(255, 255, 255)']
                      ]
                  },
                  width: ($(document).width()/10)*6,
                  height: ($(document).width()/10)*12
              },
              title: {
                  text: '<b style="font-size: 2.3vh;">PLANEA 2019</b>'
              },
              subtitle: {
                  text: '<b style="font-size: 1.5vh;"> Total de alumnos evaluados: '+arr_lyc[0]['alumnos_evaluados']+'</b>'
              },
              xAxis: {
                  type: 'category'
              },

              yAxis: {
                  title: {
                      text: '<div style="font-size: 1.1vh;">Porcentaje de alumnos con respuestas correctas</div>'

                  },
              },
              plotOptions: {
                  series: {
                    events: {
                      click: function (event) {
                        // nada...
                      }
                     },
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.1f}%'

                      }
                  },

                  // agregamos a la columna la propiedad para el clik y enviar el nombre a una función
                  bar :{
                       point:{
                           events:{
                               click:function(){
                                var periodo = $('#slt_periodo_planeaxm option:selected').val();
                                 // console.log($('#slt_tipo').val());
                                /*if ($('#slt_tipo').val()!=undefined) {
                                  var tipo = 'zona';
                                  console.log(tipo);
                                }
                                else {
                                    console.log(tipo);
                                  var tipo = 'municipio';
                                }*/


                                // console.log(periodo);
                                  obj_graficas.get_reactivos_xunidad_de_analisis(this.name,this.id_cont,id_cct,periodo,1, va_por);
                               }
                           }
                       }
                   }

              },

              tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><b>{point.y}%</b><br>',
                pointFormat: '<span style="font-size:11px">Total de preguntas en el contenido temático: </span><b>{point.drilldown}</b><br><span style="color:{point.color}">{point.name}</span>'
              },

              series: [{
                  name: 'Porcentaje de alumnos con respuestas correctas: ',
                  colorByPoint: true,
                  data: arr_lyc_aux
              }],

          });


          $(".highcharts-background").css("fill","#FFF");

      }// graficoplanea_ud_secu_lyc()

      Graficasm.prototype.graficoplanea_ud_secu_mate19 = function(arr_mate,id_cct, va_por){
        // console.info(arr_mate);
        arr_mate.sort(function (a, b) {
            return (a.porcen_alum_respok - b.porcen_alum_respok)
        });
          Highcharts.theme = {
                colors: ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900',
                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'],
                chart: {
                    backgroundColor: {
                        linearGradient: [0, 0, 0, 0],
                        stops: [
                            [0, 'rgb(255, 255, 255)'],
                            [1, 'rgb(255, 255, 255)']
                        ]
                    },
                    width: ($(document).width()/10)*6,
                    height: ($(document).width()/10)*12
                },
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 18px'
                    }
                },
                subtitle: {
                    style: {
                        color: 'blue',
                        font: 'bold 20px'
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
          var arr_mate_aux = new Array();;
          for (var i = 0; i < arr_mate.length; i++){
             arr_mate_aux.push({'id_cont': arr_mate[i]['id_contenido'],'name': arr_mate[i]['contenidos'],'y': parseFloat(arr_mate[i]['porcen_alum_respok']),'drilldown': arr_mate[i]['total_reac_xua']});
          }
          // Apply the theme
          Highcharts.setOptions(Highcharts.theme);
          // Codigo para graficar la seccion estadistica de la escuela
          // Create the chart
          var defaultSubtitle = "Total de alumnos evaluados: "+parseFloat(arr_mate[0]['alumnos_evaluados'])
          var estadPreescolar = new Highcharts.chart('div_graficas_masivo', {
              lang: {
                  //drillUpText: '◁ Regresar a {series.name}'
              },
              credits: {
                  enabled: false
              },
              chart: {
                  type: 'bar'
                  // width: 1000
              },
              title: {
                  text: '<b style="font-size: 2.3vh;">PLANEA 2019</b>'
              },
              subtitle: {
                  text:  '<b style="font-size: 1.5vh;"> Total de alumnos evaluados: '+arr_mate[0]['alumnos_evaluados']+'</b>'
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: '<div style="font-size: 1.1vh;">Porcentaje de alumnos con respuestas correctas</div>'
                  }
              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                    events: {
                      click: function (event) {
                        // nada...
                      }
              },
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.1f}%'
                      }
                  },
                  // agregamos a la columna la propiedad para el clik y enviar el nombre a una función
                  bar :{
                       point:{
                           events:{
                               click:function(){
                                  obj_graficas.get_reactivos_xunidad_de_analisis(this.name,this.id_cont,id_cct,2,2, va_por);
                               }
                           }
                       }
                   }
              },
              tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><b>{point.y}%</b><br>',
                pointFormat: '<span style="font-size:11px">Total de preguntas en el contenido temático: </span><b>{point.drilldown}</b><br><span style="color:{point.color}">{point.name}</span>'

              },
              series: [{
                  name: 'Porcentaje de alumnos con respuestas correctas: ',
                  colorByPoint: true,
                  data: arr_mate_aux
              }],
          });

          $(".highcharts-background").css("fill","#FFF");


      }// graficoplanea_ud_secu_mate()

      // Planea 2019 F

      Graficasm.prototype.get_reactivos_xunidad_de_analisis = function(nombre,id_cont,id_filtro,periodo,idcampodis, tipo_filtro, va_por){

          var periodo = $('#slt_periodo_planeaxm option:selected').val();
            if ((periodo == 1 || periodo == 2 || periodo == 4) && tipo_filtro == 'zona' ) {

                var periodo = $('#slt_periodo_planeaxz option:selected').val();
             }
          var ruta = base_url+"planea/planea_xcont_xmunicipio";
          $.ajax({
            url: ruta,
            method: 'POST',
            data: { 'id_cont':id_cont,'id_xzona_o_municipio':id_filtro,'periodo':periodo,'idcampodis':idcampodis, 'tipo_filtro': tipo_filtro
                  },
            beforeSend: function( xhr ) {
              Notification.loading("");
            }
          })
          .done(function( data ) {
            // obj_loader.hide();
            swal.close();
              var result = data.graph_cont_reactivos_xcctxcont;

              var html = "<div style='text-align:left !important;'>";
              if (result.length==0) {
              }
              else {
                html += "    <div class='container'>";
                for (var i = 0; i < result.length; i++) {
                  html += "    <div class='row'>";
                  html += "      <div class='col-2'>";
                  html += "      <h5><span class='h3 badge badge-secondary text-white'>"+result[i]['n_reactivo']+"</span></h5>";
                  html += "      </div>";
                  html += "      <div class='col-10'>";
                  if (result[i]['path_apoyo']!=null) {
                    html += "      <center><a style='color:blue;' href='#' onclick=obj_graficas.apoyo_reactivo('"+result[i]['path_apoyo']+"')>Texto/imagen (apoyo)</a></center>";
                  }
                  html += "      </div>";
                  html += "    </div>";
                  html += "    <div class='row'>";
                  html += "      <div class='col-12'>";
                  html += "<img style='cursor: zoom-in;' onclick=obj_graficas.modal_reactivo('"+result[i]['path_react']+"') class='img-fluid' src='http://www.sarape.gob.mx/assets/docs/planea_reactivos/"+result[i]['path_react']+"' class='img-responsive center-block' />";
                  html += "      </div>";
                  html += "    </div>";
                  html += "    <div class='row'>";
                  html += "      <div class='col-md-3 col-sm-12'>";
                  html += "      </div>";
                  html += "      <div class='col-md-3 col-sm-12'>";
                  html += "      </div>";
                  html += "      <div class='col-md-3 col-sm-12'>";
                  html += "      </div>";
                  html += "      <div class='col-md-3 col-sm-12'>";
                  html += "      <center><a style='color:black;' >Numero de propuestas: <b id='n_propcont'>"+result[i]['n_prop']+"</b></a></center>";
                  html += "      </div>";
                  html += "    </div>";

                  html += "    <div class='row'>";
                  html += "      <div class='col-md-3 col-sm-12'>";
                  html += "      <center>";
                  if (periodo!='1') {
                    html += "      <button hidden='true' data-toggle='tooltip' title='Explicación de respuesta correcta' type='button' class='btn btn-style-1 color-6 bgcolor-2 mb-2' onclick=obj_graficas.argumento_reactivo('"+result[i]['url_argumento']+"')>Argumento</button>";
                  }
                  html += "      </center>";
                  html += "      </div>";
                  html += "      <div class='col-md-3 col-sm-12'>";
                  html += "      <center>";
                  if (periodo!='1') {
                  html += "      <button hidden='true' type='button' class='btn btn-style-1 color-6 bgcolor-3 mb-2' onclick=obj_graficas.especificacion_reactivo('"+result[i]['url_especificacion']+"')>Especificación</button>";
                  }
                  html += "      </center>";
                  html += "      </div>";
                  html += "      <div class='col-md-3 col-sm-12'>";
                  html += "      <center>";
                  if (result[i]['n_material']!="0") {
                    html += "      <button type='button' class='btn btn-style-1 color-6 bgcolor-4 mb-2' onclick=obj_graficas.apoyosacadem('"+result[i]['id_reactivo']+"')>Apoyos académicos</button>";
                  }
                  html += "      </center>";
                  html += "      </div>";

                  html += "      <div class='col-md-3 col-sm-12'>";
                  html += "      <center>";
                  if (result[i]['n_prop']<"5") {
                    html += "      <button id='btn_prop' type='button' class='btn btn-style-1 color-6 bgcolor-1 mb-2' onclick=obj_graficas.propmapoyo('"+result[i]['id_reactivo']+"')>Proponer material</button>";
                  }
                  html += "      </center>";
                  html += "      </div>";

                  html += "      </div>";
                  html += "    </div>";
                }
                html += "    </div>";
              }


              $('#modal_visor_reactivos .modal-body #div_reactivos').empty();
              $('#modal_visor_reactivos .modal-body #div_reactivos').html(html);

              $("#modal_reactivos_title").empty();
              $("#modal_reactivos_title").html("Contenido temático: "+nombre);

              $("#modal_visor_reactivos").modal("show");

          })
          .fail(function(e) {
            swal.close();
              console.error("Error in get_reactivos_xunidad_de_analisis()"); console.table(e);
          });
      }// get_reactivos_xunidad_de_analisis()


      Graficasm.prototype.graficoplanea_ud_ms_lyc = function(arr_lyc,id_cct, va_por){
        arr_lyc.sort(function (a, b) {
            return (a.porcen_alum_respok - b.porcen_alum_respok)
        });
          Highcharts.theme = {
                colors: ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900',
                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'],

                legend: {
                    itemStyle: {
                        font: '9pt',
                        color: 'black'
                    },
                    itemHoverStyle:{
                        color: 'gray'
                    },
                    enabled: false
                }
          };

          Highcharts.setOptions(Highcharts.theme);

          var arr_lyc_aux = new Array();;
          for (var i = 0; i < arr_lyc.length; i++){
             arr_lyc_aux.push({'id_cont': arr_lyc[i]['id_contenido'],'name': arr_lyc[i]['contenidos'],'y': parseFloat(arr_lyc[i]['porcen_alum_respok']),'drilldown': arr_lyc[i]['total_reac_xua']});
          }

          // Apply the theme

          // Codigo para graficar la seccion estadistica de la escuela
          var estadPreescolar = new Highcharts.chart('div_graficas_masivo', {
              lang: {
                  //drillUpText: '◁ Regresar a {series.name}'
              },
              credits: {
                  enabled: false
              },

              chart: {
                  type: 'bar',
                  backgroundColor: {
                      linearGradient: [0, 0, 0, 0],
                      stops: [
                          [0, 'rgb(255, 255, 255)'],
                          [1, 'rgb(255, 255, 255)']
                      ]
                  },
                  width: ($(document).width()/10)*6,
                  height: ($(document).width()/10)*12
              },
              title: {
                  text: '<b style="font-size: 2.3vh;">PLANEA 2017</b>'
              },
              subtitle: {
                  text: '<b style="font-size: 1.5vh;"> Total de alumnos evaluados: '+arr_lyc[0]['alumnos_evaluados']+'</b>'
              },
              xAxis: {
                  type: 'category'
              },

              yAxis: {
                  title: {
                      text: '<div style="font-size: 1.1vh;">Porcentaje de alumnos que contestó correctamente</div>'
                      // text: '<div>Porcentaje de alumnos con respuestas correctas</div>'
                  },
              },
              plotOptions: {
                  series: {
                    events: {
                      click: function (event) {
                        // nada...
                      }
                     },
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.1f}%'

                      }
                  },

                  // agregamos a la columna la propiedad para el clik y enviar el nombre a una función
                  bar :{
                       point:{
                           events:{
                               click:function(){
                                var periodo = $('#slt_periodo_planeaxm option:selected').val();
                                console.log(periodo);
                                  obj_graficas.get_reactivos_xunidad_de_analisis(this.name,this.id_cont,id_cct,periodo,1, va_por);
                               }
                           }
                       }
                   }
                  //
              },

              tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><b>{point.y}%</b><br>',
                pointFormat: '<span style="font-size:11px">Total de preguntas en el contenido temático: </span><b>{point.drilldown}</b><br><span style="color:{point.color}">{point.name}</span>'
              },

              series: [{
                  name: 'Porcentaje de alumnos que contestó correctamente: ',
                  colorByPoint: true,
                  data: arr_lyc_aux
              }],

          });

          if (screen.width<600){
            estadPreescolar.setSize(
                ($(document).width()/10)*5,
                500,
               false
            );
          }
          else {
            estadPreescolar.setSize(
                ($(document).width()/10)*5,
                900,
               false
            );
          }
      }// graficoplanea_ud_ms_lyc()

      Graficasm.prototype.graficoplanea_ud_ms_mate = function(arr_mate,id_cct, va_por){
        arr_mate.sort(function (a, b) {
            return (a.porcen_alum_respok - b.porcen_alum_respok)
        });
          Highcharts.theme = {
                colors: ['#FF0000','#FF0000', '#FF0000', '#FF0000','#FF0000',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                 '#FF9900','#FF9900','#FF9900','#FF9900','#FF9900',
                  '#3CB371','#3CB371','#3CB371','#3CB371','#3CB371'],
                chart: {
                    backgroundColor: {
                        linearGradient: [0, 0, 0, 0],
                        stops: [
                            [0, 'rgb(255, 255, 255)'],
                            [1, 'rgb(255, 255, 255)']
                        ]
                    },
                    width: ($(document).width()/10)*6,
                    height: ($(document).width()/10)*12
                },
                title: {
                    style: {
                        color: '#000',
                        font: 'bold 18px'
                    }
                },
                subtitle: {
                    style: {
                        color: 'blue',
                        font: 'bold 20px'
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
          var arr_mate_aux = new Array();;
          for (var i = 0; i < arr_mate.length; i++){
             arr_mate_aux.push({'id_cont': arr_mate[i]['id_contenido'],'name': arr_mate[i]['contenidos'],'y': parseFloat(arr_mate[i]['porcen_alum_respok']),'drilldown': arr_mate[i]['total_reac_xua']});
          }
          // Apply the theme
          Highcharts.setOptions(Highcharts.theme);
          // Codigo para graficar la seccion estadistica de la escuela
          // Create the chart
          var defaultSubtitle = "Total de alumnos evaluados: "+parseFloat(arr_mate[0]['alumnos_evaluados'])
          var estadPreescolar = new Highcharts.chart('div_graficas_masivo', {
              lang: {
                  //drillUpText: '◁ Regresar a {series.name}'
              },
              credits: {
                  enabled: false
              },
              chart: {
                  type: 'bar'
                  // width: 1000
              },
              title: {
                  text: '<b style="font-size: 2.3vh;">PLANEA 2017</b>'
              },
              subtitle: {
                  text:  '<b style="font-size: 1.5vh;"> Total de alumnos evaluados: '+arr_mate[0]['alumnos_evaluados']+'</b>'
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: '<div style="font-size: 1.1vh;">Porcentaje de alumnos que contestó correctamente</div>'
                  }
              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                    events: {
                      click: function (event) {
                        // nada...
                      }
              },
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true,
                          format: '{point.y:.1f}%'
                      }
                  },
                  // agregamos a la columna la propiedad para el clik y enviar el nombre a una función
                  bar :{
                       point:{
                           events:{
                               click:function(){
                                  var periodo = $('#slt_periodo_planeaxm option:selected').val();
                                console.log(periodo);
                                  obj_graficas.get_reactivos_xunidad_de_analisis(this.name,this.id_cont,id_cct,periodo,2, va_por);
                               }
                           }
                       }
                   }
              },
              tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><b>{point.y}%</b><br>',
                pointFormat: '<span style="font-size:11px">Total de preguntas en el contenido temático: </span><b>{point.drilldown}</b><br><span style="color:{point.color}">{point.name}</span>'

              },
              series: [{
                  name: 'Porcentaje de alumnos que contestó correctamente: ',
                  colorByPoint: true,
                  data: arr_mate_aux
              }],
          });

          $(".highcharts-background").css("fill","#FFF");
          // $("#container_chartFreqAtaTailNum").highcharts().setSize(200, 200, false);
          if (screen.width<600){
            estadPreescolar.setSize(
                ($(document).width()/10)*5,
                500,
               false
            );
          }
          else {
            estadPreescolar.setSize(
                ($(document).width()/10)*5,
                1000,
               false
            );
          }

      }// graficoplanea_ud_ms_mate()


         Graficasm.prototype.argumento_reactivo = function(url_argumento){

           var html = "<div style='text-align:left !important;'><ul>";
             html += "<table class='table table-condensed'>";
             html += "<tbody> <center>";


             html += "</center></tbody>";
             html += "</table>";

             html += "</div>";

             $('#modal_visor_pdfc2 .modal-header #exampleModalLabel').empty();
             $('#modal_visor_pdfc2 .modal-header #exampleModalLabel').html("");

           $('#modal_visor_pdfc2 .modal-body #div_listalinks').empty();
           $('#modal_visor_pdfc2 .modal-body #div_listalinks').html(html);

           Utiles.showPDF("modal_visor_pdfc2", url_argumento);
           $("#modal_visor_pdfc2").modal("show");

            // window.open("http://www.sarape.gob.mx/assets/docs/info/arg_r1_lyc_17_sec.pdf", "_blank");

         }
         Graficasm.prototype.especificacion_reactivo = function(url_especificacion){

             var html = "<div style='text-align:left !important;'><ul>";
               html += "<table class='table table-condensed'>";
               html += "<tbody> <center>";


               html += "</center></tbody>";
               html += "</table>";

               html += "</div>";

               $('#modal_visor_pdfc3 .modal-header #exampleModalLabel').empty();
               $('#modal_visor_pdfc3 .modal-header #exampleModalLabel').html("");

             $('#modal_visor_pdfc3 .modal-body #div_listalinks').empty();
             $('#modal_visor_pdfc3 .modal-body #div_listalinks').html(html);

             Utiles.showPDF("modal_visor_pdfc3", url_especificacion);
             $("#modal_visor_pdfc3").modal("show");
             // window.open("http://www.sarape.gob.mx/assets/docs/info/esp_r1_lyc_17_sec.pdf", "_blank");
         }

         Graficasm.prototype.apoyosacadem = function(id_reactivo){
             swal.close();
             var ruta = base_url+"Planea/apoyos_academxid_reac";
             $.ajax({
               url: ruta,
               method: 'POST',
               data: { 'id_reactivo':id_reactivo
                     },
               beforeSend: function( xhr ) {
                 // obj_loader.show();
               }
             })
             .done(function( data ) {
               // obj_loader.hide();
                 swal.close();
                 var result = data.arr_apoyosacade_xidreact;
                 // console.table(result);
                 var html = "<div style='text-align:left !important;'><ul>";
                   html += "<table class='table table-condensed'>";
                   html += "<tbody>";

                 result.forEach(function(result, index) {
                   html += "    <tr>";
                   html += "      <td class='text-center'><h5><span class='h3 badge badge-secondary text-white'>"+(1+index)+"</span></h5></td>";
                   switch (result.idtipo) {
                     case '1':
                         html += "      <td><a class='btn btn-style-1 color-6 bgcolor-4' href='#'  onclick=obj_graficas.material_reactivo('"+result.ruta+"')>"+result.titulo+"</a><li>Tipo: PDF.    Fuente: "+result.fuente+"</li></td>";
                       break;
                     case '2':
                         html += "      <td><a class='btn btn-style-1 color-6 bgcolor-4' href='#'  onclick=obj_graficas.material_reactivo('"+result.ruta+"')>"+result.titulo+"</a><li>Tipo: IMAGEN.   Fuente: "+result.fuente+"</li></td>";
                       break;
                     case '3':
                         html += "      <td><a class='btn btn-style-1 color-6 bgcolor-4' href='"+result.ruta+"' target='_blank'>"+result.titulo+"</a><li>Tipo: LINK.     Fuente: "+result.fuente+"</li></td>";
                       break;
                     case '4':
                         html += "      <td><a class='btn btn-style-1 color-6 bgcolor-4' href='"+result.ruta+"' target='_blank'>"+result.titulo+"</a><li>Tipo: VIDEO.     Fuente: "+result.fuente+"</li></td>";
                       break;
                     default:
                       break;
                   }
                   html += "    </tr>";

                 console.log("Persona " + index + " | tipo: " + result.idtipo + " ruta: " + result.ruta)
                 });


                   html += "</tbody>";
                   html += "</table>";

                 html += "</div>";

                 $('#modal_visor_apoyos_academ .modal-body #div_listalinks').empty();
                 $('#modal_visor_apoyos_academ .modal-body #div_listalinks').html(html);

                 $("#modal_apoyos_academ_title").empty();
                 $("#modal_apoyos_academ_title").html("Pregunta: 1, campo disciplinario: lenguaje y comunicación, periodo: 2016.");

                 $("#modal_visor_apoyos_academ").modal("show");


             })
             .fail(function(e) {
                 console.error("Error in get_reactivos_xunidad_de_analisis()"); console.table(e);
             });
         }

         Graficasm.prototype.propmapoyo = function(id_reactivo){
           swal.close();
               $("#modal_operacion_recursos").modal("show");
               $("#idreactivoform_pub").val(id_reactivo);
               $("#idreactivofileform_pub").val(id_reactivo);
               $("#input_id_reactivo").val(id_reactivo);

         }

         Graficasm.prototype.envia_url_pub =function(){

           obj_graficas.ocultamesaje_link();
           if (!obj_graficas.valida_url($("#inputcampourl").val())) {
             $("#mensaje_alertaur2").show();
           }
           else if($("#inputtitulo").val() ==""){
             $("#mensaje_alertattitulo").show();
           }else if($("#inputcampourl").val() ==""){
               $("#mensaje_alertaurl").show();
           }else if($("#inputcampofuente").val() ==""){
               $("#mensaje_alertafuente").show();
           }else{
             $.ajax({
               url: base_url+'info/envia_url',
               type: 'POST',
               dataType: 'JSON',
               data: {id_reactivo: $("#idreactivoform_pub").val(), url: $("#inputcampourl").val(), titulo: $("#inputtitulo").val(), tipo: $("#tipodematerial").val(), fuenteurlvideo: $("#inputcampofuente").val() },
               beforeSend: function(xhr) {
                     Notification.loading("");
                 },
             })
             .done(function(result) {
             swal.close();
               $("#modal_operacion_recursos").modal('hide');

                       $("#div_contenedor_operaciones").hide();
                        $("#div_contenedor_operaciones_files").hide();
                         $("#tipodematerial").val('0');
                        $(".formulario")[0].reset();
                         obj_graficas.getn_prop();
              
               swal(
                   'Listo!',
                   result.response,
                   'success'
                 );
             })
             .fail(function(e) {
               console.error("Error in envia_url_pub()"); console.table(e);
             })
             .always(function() {

             });
           }

         }

         Graficasm.prototype.getn_prop =function(){

           $.ajax({
             url: base_url+'info/get_nprop',
             type: 'POST',
             dataType: 'JSON',
             data: {id_reactivo: $("#idreactivoform_pub").val()},
             beforeSend: function(xhr) {

               },
           })
           .done(function(result) {
             if (result.n_prop>4) {
               $("#btn_prop").hide();
             }
             $("#n_propcont").html(result.n_prop);

           })
           .fail(function(e) {
             console.error("Error in getn_prop()"); console.table(e);
           })
           .always(function() {

           });

         }

         Graficasm.prototype.modal_reactivo = function(path_react){
             swal.close();

             var html = "<div style='text-align:left !important;'>";
               html += "<table class='table table-condensed'>";
               html += "<tbody> ";
               html += "    <tr>";
               html += "      <td><center>";
                 html += "<img style='width: 100%;' src='http://www.sarape.gob.mx/assets/docs/planea_reactivos/"+path_react+"' class='img-responsive center-block' />";
                 html += "      </center></td>";
                 html += "    </tr>";
             html += "</tbody>";
               html += "</table>";

               html += "</div>";

             $('#modal_visor_reactivos_zom .modal-body #div_listalinks').empty();
             $('#modal_visor_reactivos_zom .modal-body #div_listalinks').html(html);


             $("#modal_visor_reactivos_zom").modal("show");
         }

         Graficasm.prototype.apoyo_reactivo = function(path_apoyo){
             swal.close();


             var html = "<div style='text-align:left !important;'>";
               html += "<table class='table table-condensed'>";
               html += "<tbody> ";
               html += "    <tr>";
               html += "      <td><center>";
                 html += "<img style='width: 100%;' src='http://www.sarape.gob.mx/assets/docs/planea_reactivos/"+path_apoyo+"' class='img-responsive center-block' />";
                 html += "      </center></td>";
                 html += "    </tr>";
             html += "</tbody>";
               html += "</table>";

               html += "</div>";

             $('#modal_visor_apoyos_reactivos .modal-body #div_listalinks').empty();
             $('#modal_visor_apoyos_reactivos .modal-body #div_listalinks').html(html);


             $("#modal_visor_apoyos_reactivos").modal("show");
         }

         Graficasm.prototype.material_reactivo = function(url){
             swal.close();

             var html = "<div class='embed-responsive embed-responsive-16by9'>";
             html += "  <iframe class='embed-responsive-item' src='"+"http://www.sarape.gob.mx/"+url+"' allowfullscreen></iframe>";
             html += "</div>";



             $('#modal_visor_material_reactivos .modal-body #div_listalinks').empty();
             $('#modal_visor_material_reactivos .modal-body #div_listalinks').html(html);


             $("#modal_visor_material_reactivos").modal("show");
         }
         $("#md_close_iframe").click(function(){
         $('#modal_visor_material_reactivos .modal-body #div_listalinks').empty();
         $("#modal_visor_material_reactivos").modal("hide");
         });

         Graficasm.prototype.subir_recurso = function(){

             var formData = new FormData($(".formulario")[0]);
             var message = "";
             //hacemos la petición ajax

             $.ajax({
                 url: base_url+'info/set_file',
                 type: 'POST',
                 // Form data
                 //datos del formulario
                 data: formData,
                 //necesario para subir archivos via ajax
                 cache: false,
                 contentType: false,
                 processData: false,
                 //mientras enviamos el archivo
                 beforeSend: function(){
                     message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                     showMessage(message)
                 })
                 //una vez finalizado correctamente
                 .done(function(data){
                 	swal(
         		      'Listo!',
         		      'Su archivo se subio correctamente',
         		      'success'
         		    );
                 	$("#modal_operacion_recursos").modal('hide');
                 	$("#idseleccionadofile").val("false");//regresa false la varible que valida si ya se a seleccionado un archivo
                 	$("#validaexixtente").val("false");//regresa en false la valicacion del archivo exixtente
                   $("#div_contenedor_operaciones").hide();
               	    $("#div_contenedor_operaciones_files").hide();
                     $("#tipodematerial").val('0');
               	    $(".formulario")[0].reset();
                     obj_graficas.getn_prop();
                 })
                 //si ha ocurrido un error
                 .fail(function(){
                     message = $("<span class='error'>Ha ocurrido un error.</span>");
                     showMessage(message);
                 })
                 .always(function() {
                    swal.close();
                });
         }

         Graficasm.prototype.ocultamesaje_link = function(){
         	$("#mensaje_alertattitulo").hide();
             $("#mensaje_alertaurl").hide();
             $("#mensaje_alertaur2").hide();
             $("#mensaje_alertafuente").hide();
         }
         Graficasm.prototype.ocultamesaje_file = function(){
         	$("#mensaje_alertatitulo_file").hide();
         	$("#mensaje_alertafile").hide();
         	$("#mensaje_alertafuente_file").hide();
         }
         Graficasm.prototype.clean_campos = function(){
         	$("#inputtitulo").val("");
             $("#inputcampourl").val("");
             $("#inputcampofuente").val("");
         }

         Graficasm.prototype.genera_campo_url = function(idtipo, idreactivo){
         	$("#div_contenedor_operaciones").show();
         	$("#div_contenedor_operaciones_files").hide();
         }

         Graficasm.prototype.genera_campo_file = function(idtipo, idreactivo){
         	$("#div_contenedor_operaciones").hide();
         	$("#div_contenedor_operaciones_files").show();
         }


         Graficasm.prototype.valida_url = function(url){
           var expression = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/ ;
         var regex = new RegExp(expression);
         if (url.match(regex)) {

           var expression_adul = /porn|xxx|gay|redtube|porin|lesbian|culo|pinga|verga|pelos|teta|titi|chichi/;
           var regex_a = new RegExp(expression_adul);
           if (url.match(regex_a)) {
             return false;
           }
           else {
             return true;
           }
         } else {
           return false;
         }
         }


   //al enviar el formulario
   $('#btn_subir_pdf_imagen_pub').click(function(){

     if(fileSize < 5000000){
       obj_graficas.ocultamesaje_file();
       if($("#titulofile").val() == ""){
         $("#mensaje_alertatitulo_file").show();
       }else if($("#idseleccionadofile").val()== "false"){
         $("#mensaje_alertafile").show();
       }else if($("#inputcampofuentefile").val() == ""){
         $("#mensaje_alertafuente_file").show();
       }else if($("#validaexixtente").val() == "true"){
         swal({
         title: '¿Esta seguro de remplazar el archivo?',
         text: "Puede que algunos recursos no se visualicen correctamente",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Si, reemplazar!',
         cancelButtonText: 'Cancelar'
       }).then((result) => {
         if (result.value) {
           obj_graficas.subir_recurso();
         }
       })
       }else{
         obj_graficas.subir_recurso();
       }
     }else{
       swal(
         'Su archivo es demaciado grande!',
         'Solo archivos menores de 5Mb',
         'warning'
       );
     }
   });


   $(':file').change(function()
   {
     $("#idseleccionadofile").val("true");
       //obtenemos un array con los datos del archivo
       var file = $("#imagen")[0].files[0];
       //obtenemos el nombre del archivo
       var fileName = file.name;
       //obtenemos la extensión del archivo
       fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
       //obtenemos el tamaño del archivo
       fileSize = file.size;
       //obtenemos el tipo de archivo image/png ejemplo
       var fileType = file.type;
       //mensaje con la información del archivo
       showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
       // obj_recursos.validaExisteArchivo(fileName);
   });


   $("#md_close_operacion_recursos").click(function(){
   	$("#modal_operacion_recursos").modal('hide');
   })
   $("#tipodematerial").change(function(){
   		obj_graficas.clean_campos();
   	$("#idtipofileform").val($("#tipodematerial").val());
   	$("#idreactivofileform").val($("#input_id_reactivo").val());
   	$("#idreactivoform").val($("#input_id_reactivo").val());
   	var id_reactivo = parseInt($("#input_id_reactivo").val());
   	var tipo_contenido = $("#tipodematerial").val();
   	switch(tipo_contenido){
   		case "1":
   		obj_graficas.genera_campo_file(tipo_contenido);
   		$(':file').attr("accept", ".pdf");
   		break;
   		case "2":
   		obj_graficas.genera_campo_file(tipo_contenido);
   		$(':file').attr("accept", "image/*");
   		break;
   		case "3":
   		obj_graficas.genera_campo_url(tipo_contenido, id_reactivo);
   		break;
   		case "4":
   		obj_graficas.genera_campo_url(tipo_contenido, id_reactivo);
   		break;
   	}
   });
