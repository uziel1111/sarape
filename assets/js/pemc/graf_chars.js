
if (typeof google !== 'undefined') {
  google.charts.load('current', {'packages':['bar']});

  // google.charts.setOnLoadCallback(graficaBarObj_jefsector);
  // google.charts.setOnLoadCallback(graficaBarAcc_jefsector);
  // google.charts.setOnLoadCallback(graficaBarObj_super);
  // google.charts.setOnLoadCallback(graficaBarAcc_super);
  // google.charts.setOnLoadCallback(graficaPiesuper);
  // google.charts.setOnLoadCallback(graficaPie);
  
  google.charts.load('current', {'packages':['corechart']});
}

if ($('#slct_supervision option:selected').val() === undefined) 
{
  //SUPERVISOR
  function graficaBarObj_super(objetivos) {
    if (objetivos != undefined){
      obj1 = parseInt(objetivos[0]['obj']);
      obj2 = parseInt(objetivos[1]['obj']);
      obj3 = parseInt(objetivos[2]['obj']);
      obj4 = parseInt(objetivos[3]['obj']);
      obj5 = parseInt(objetivos[4]['obj']);
      
      // if (google.visualization !== undefined)
      // {
        data = google.visualization.arrayToDataTable([
                ['Líneas de Acción Estratégicas', 'Objetivos'],
                ['LAE-1', obj1],
                ['LAE-2', obj2],
                ['LAE-3', obj3],
                ['LAE-4', obj4],
                ['LAE-5', obj5],
              ]);
        var options = {
          chart: {
            title: 'Objetivos por LAE',
            subtitle: '',
          }
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_material_super'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      // }
    }
  }

function graficaBarAcc_super(acciones) {
    if (acciones != undefined){

    acc1 = parseInt(acciones[0]['acc']);
    acc2 = parseInt(acciones[1]['acc']);
    acc3 = parseInt(acciones[2]['acc']);
    acc4 = parseInt(acciones[3]['acc']);
    acc5 = parseInt(acciones[4]['acc']);
    
    //   if (google.visualization !== undefined)
    // {
        var data = google.visualization.arrayToDataTable([
                ['Líneas de Acción Estratégicas', 'Acciones'],
                ['LAE-1', acc1],
                ['LAE-2', acc2],
                ['LAE-3', acc3],
                ['LAE-4', acc4],
                ['LAE-5', acc5],
              ]);

        var options = {
          chart: {
            title: 'Acciones por LAE',
            subtitle: '',
            height: 250,
            width: 400,
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_acciones_super'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      // }
    }
  };

   function graficaPiesuper(capturado, no_capturado) {
    // google.visualization !== undefined
    
    if (google.visualization !== undefined) {
      var data = google.visualization.arrayToDataTable([
        ['Porcentaje', 'Captura por escuela'],
        ['Capturado',     capturado],
        ['No Capturado',      no_capturado]
        ]);
    
    var options = {
      chart:{
        title: 'Porcentaje de escuelas que han capturado'
      },
      height: 400,
      width: 700,
       legend: {position: 'labeled'},
    }
      var chart = new google.visualization.PieChart($('#piechart_super')[0]);
      chart.draw(data, options);
    }    
  };
}
else
{
  //JEFE DE SECTOR
 function graficaBarObj_jefsector(objetivos) {
  if (objetivos != undefined){
    obj1 = parseInt(objetivos[0]['obj']);
    obj2 = parseInt(objetivos[1]['obj']);
    obj3 = parseInt(objetivos[2]['obj']);
    obj4 = parseInt(objetivos[3]['obj']);
    obj5 = parseInt(objetivos[4]['obj']);
    
    if (google.visualization !== undefined)
    {
      var data = google.visualization.arrayToDataTable([
          ['Líneas de Acción Estratégicas', 'Objetivos'],
          ['LAE-1', obj1],
          ['LAE-2', obj2],
          ['LAE-3', obj3],
          ['LAE-4', obj4],
          ['LAE-5', obj5],
        ]);

      var options = {
        chart: {
          title: 'Objetivos por LAE',
          subtitle: '',
        }
      };
      var chart = new google.charts.Bar(document.getElementById('columnchart_material_xjefesector'));
      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  }
}

function graficaBarAcc_jefsector(acciones) {
  if (acciones != undefined){

  acc1 = parseInt(acciones[0]['acc']);
  acc2 = parseInt(acciones[1]['acc']);
  acc3 = parseInt(acciones[2]['acc']);
  acc4 = parseInt(acciones[3]['acc']);
  acc5 = parseInt(acciones[4]['acc']);
  
  if (google.visualization !== undefined)
  {
    var data = google.visualization.arrayToDataTable([
          ['Líneas de Acción Estratégicas', 'Acciones'],
          ['LAE-1', acc1],
          ['LAE-2', acc2],
          ['LAE-3', acc3],
          ['LAE-4', acc4],
          ['LAE-5', acc5],
        ]);

    var options = {
      chart: {
        title: 'Acciones por LAE',
        subtitle: '',
        height: 250,
        width: 400,
      }
    };
    var chart = new google.charts.Bar(document.getElementById('columnchart_material_acciones_xjefesector'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  }
 }

   function graficaPie(capturado, no_capturado) {
    
      if (google.visualization !== undefined) 
      {
     var data = google.visualization.arrayToDataTable([
       ['Porcentaje', 'Captura por escuela'],
       ['Capturado',     capturado],
       ['No Capturado',      no_capturado]
       ]);
      
     var options = {
       chart:{
         title: 'Porcentaje de escuelas que han capturado'
       },
       height: 400,
       width: 700,
        legend: {position: 'labeled'},
     }
      var chart = new google.visualization.PieChart($('#piechart_js')[0]);
      chart.draw(data, options);
     }
   };

   //SUPERVISOR
   function graficaBarObj_super(objetivos) {
    if (objetivos != undefined){
      obj1 = parseInt(objetivos[0]['obj']);
      obj2 = parseInt(objetivos[1]['obj']);
      obj3 = parseInt(objetivos[2]['obj']);
      obj4 = parseInt(objetivos[3]['obj']);
      obj5 = parseInt(objetivos[4]['obj']);
      
      if (google.visualization !== undefined)
      {
        data = google.visualization.arrayToDataTable([
                ['Líneas de Acción Estratégicas', 'Objetivos'],
                ['LAE-1', obj1],
                ['LAE-2', obj2],
                ['LAE-3', obj3],
                ['LAE-4', obj4],
                ['LAE-5', obj5],
              ]);
        var options = {
          chart: {
            title: 'Objetivos por LAE',
            subtitle: '',
          }
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_material_super'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    }
  }

function graficaBarAcc_super(acciones) {
    if (acciones != undefined){

    acc1 = parseInt(acciones[0]['acc']);
    acc2 = parseInt(acciones[1]['acc']);
    acc3 = parseInt(acciones[2]['acc']);
    acc4 = parseInt(acciones[3]['acc']);
    acc5 = parseInt(acciones[4]['acc']);
    
      if (google.visualization !== undefined)
    {
        var data = google.visualization.arrayToDataTable([
                ['Líneas de Acción Estratégicas', 'Acciones'],
                ['LAE-1', acc1],
                ['LAE-2', acc2],
                ['LAE-3', acc3],
                ['LAE-4', acc4],
                ['LAE-5', acc5],
              ]);

        var options = {
          chart: {
            title: 'Acciones por LAE',
            subtitle: '',
            height: 250,
            width: 400,
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_acciones_super'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    }
  };

   function graficaPiesuper(capturado, no_capturado) {
    // google.visualization !== undefined
    
    if (google.visualization !== undefined) {
      var data = google.visualization.arrayToDataTable([
        ['Porcentaje', 'Captura por escuela'],
        ['Capturado',     capturado],
        ['No Capturado',      no_capturado]
        ]);
    
    var options = {
      chart:{
        title: 'Porcentaje de escuelas que han capturado'
      },
      height: 400,
      width: 700,
       legend: {position: 'labeled'},
    }
      var chart = new google.visualization.PieChart($('#piechart_super')[0]);
      chart.draw(data, options);
    }    
  };
}
