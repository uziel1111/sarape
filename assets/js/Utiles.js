$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

var Utiles = {
  path_docs : "http://www.sarape.gob.mx/assets/docs/",

  showPDF : function(idModal, urlPdf){
    var dom = '<iframe src="https://docs.google.com/viewerng/viewer?url='+this.path_docs+urlPdf+'&embedded=true" width="100%" height="500" style="border: none;"></iframe>';
    $("#"+idModal +" .modal-body").empty();
    $("#"+idModal +" .modal-body").html(dom);
    $("#"+idModal).modal("show");
  }

};
