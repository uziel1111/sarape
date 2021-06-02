$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

var Utiles = {
  path_docs : "https://www.sarape.gob.mx/assets/docs/",

  showPDF : function(idModal, urlPdf){
    var dom = '<iframe src="'+this.path_docs+urlPdf+'" width="100%" height="500" style="border: none;"></iframe>';
    $("#"+idModal +" .modal-body").empty();
    $("#"+idModal +" .modal-body").html(dom);
    $("#"+idModal).modal("show");
  }

};
