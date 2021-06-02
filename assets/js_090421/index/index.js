$("#btn_index_reconocimientosEstatales").click(function(e){
  e.preventDefault();
  Index.getReconocimientosEstatales();
});

$("#btn_index_materialesUtiles").click(function(e){
  e.preventDefault();
  Index.getMaterialesUtiles();
});

$("#btn_index_calendarioEscolar").click(function(e){
  e.preventDefault();
  Index.getCalendarioEscolar();
});

$("#btn_index_guiaspadres").click(function(e){
  e.preventDefault();
  Index.getguiaparapadres();
});

$("#btn_index_modeloeducativo").click(function(e){
  e.preventDefault();
  Index.getmodeloeducativo();
});

var Index = {

  getReconocimientosEstatales : function() {
    var ruta = base_url+"Index/getReconocimientosEstatales";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'folder':1, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      $("#modal_reconocimientosEstatales").modal("show");
    })
    .fail(function(e) {
      console.error("Error in getReconocimientosEstatales()"); console.table(e);
    })
    .always(function() {
			swal.close();
		});
	},

  getMaterialesUtiles : function() {
    var ruta = base_url+"Index/getMaterialesUtiles";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'folder':1, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      Utiles.showPDF("modal_materialesUtiles", "index/materialesUtiles/ListadetilesescolaresCicloescolar2018-2019-VERSINFINAL.pdf");
    })
    .fail(function(e) {
      console.error("Error in getMaterialesUtiles()"); console.table(e);
    })
    .always(function() {
			swal.close();
		});
	},

  getCalendarioEscolar : function() {
    var ruta = base_url+"Index/getCalendarioEscolar";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'folder':1, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      Utiles.showPDF("modal_calendarioEscolar", "index/calendarioEscolar/Calendario_2019.pdf");
    })
    .fail(function(e) {
      console.error("Error in getCalendarioEscolar()"); console.table(e);
    })
    .always(function() {
			swal.close();
		});
	},

  getmsjsarape : function() {
    var ruta = base_url+"Index/sarapemsj";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'folder':1, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      Utiles.showPDF("modal_msjsarape", "index/SARAPE.pdf");
    })
    .fail(function(e) {
      console.error("Error in sarapemsj()"); console.table(e);
    })
    .always(function() {
			swal.close();
		});
	},

  getguiaparapadres : function() {
    var ruta = base_url+"Index/guiaparapadres";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'folder':1, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      Utiles.showPDF("modal_guiaparapadres", "index/1GUIA-PARA-PADRES-EDUC-INCIAL.pdf");
    })
    .fail(function(e) {
      console.error("Error in guiaparapadres()"); console.table(e);
    })
    .always(function() {
			swal.close();
		});
	},

  getmodeloeducativo : function() {
    var ruta = base_url+"Index/modeloeducativo";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'folder':1, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      Utiles.showPDF("modal_modeloeducativo", "index/1.-_Resumen_Ejecutivo__1_.pdf");
    })
    .fail(function(e) {
      console.error("Error in modeloeducativo()"); console.table(e);
    })
    .always(function() {
      swal.close();
    });
  },
  getRevistaEscolar : function() {
    var ruta = base_url+"Index/getRevistaEscolar";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'folder':1, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      $("#modal_revistaEscolar").modal("show");
    })
    .fail(function(e) {
      console.error("Error in getCalendarioEscolar()"); console.table(e);
    })
    .always(function() {
      swal.close();
    });
  },

  getinformese : function(num_ed) {
    var ruta = base_url+"Index/getinformese";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'num_ed':num_ed, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico2").empty();
      $("#div_generico2").append(data.strView);
      $("#modal_informese").modal("show");

      Utiles.showPDF("modal_informese", "index/revistaEscolar/InformeSE_Coahuila"+num_ed+"ed.pdf");
    })
    .fail(function(e) {
      console.error("Error in getCalendarioEscolar()"); console.table(e);
    })
    .always(function() {
      swal.close();
    });
  }, 

  getVideotutoriales : function() { 
    var ruta = base_url+"Index/getVideotutoriales";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'folder':1, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      $("#modal_revistaEscolar").modal("show");
      Utiles.showPDF("modal_videotutoriales", "index/videotutoriales");
    })
    .fail(function(e, data) {
      console.log(data);
      console.error("Error"); console.table(e);
    })
    .always(function() {
      swal.close();
    });
  },

    getAprendeencasa : function() {
    var ruta = base_url+"Index/getAprendeencasa";
    $.ajax({
      url: ruta,
      method: 'POST',
      data: { 'folder':1, 'file':1 },
      beforeSend: function(xhr) {
        Notification.loading("");
      }
    })
    .done(function( data ) {
      $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      $("#modal_aprendeencasa").modal("show");
    })
    .fail(function(e) {
      console.error("Error in getCalendarioEscolar()"); console.table(e);
    })
    .always(function() {
      swal.close();
    });
  },


};
