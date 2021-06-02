$("#btn_reconocimientosEstatales_candelaria").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/CANDELARIA.pdf");
});

$("#btn_reconocimientosEstatales_felix").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/FELIX.pdf");
});

$("#btn_reconocimientosEstatales_ignacio").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/IGNACIO.pdf");
});

$("#btn_reconocimientosEstatales_leopoldo").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/LEOPOLDO.pdf");
});

$("#btn_reconocimientosEstatales_rafael").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/RAFAEL.pdf");
});

$('#modal_reconocimientosEstatales').on('hidden.bs.modal', function (e) {
});

$('#modal_reconocimientosEstatalesPdf').on('hidden.bs.modal', function (e) {
});
