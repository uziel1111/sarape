$("#btn_reconocimientosEstatales_candelaria").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/MEDALLAS-30-2019-2020.pdf");
});

$("#btn_reconocimientosEstatales_felix").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/MEDALLAS-40-2019-2020.pdf");
});

$("#btn_reconocimientosEstatales_ignacio").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/MEDALLAS-50-2019-2020.pdf");
});



$('#modal_reconocimientosEstatales').on('hidden.bs.modal', function (e) {
});

$('#modal_reconocimientosEstatalesPdf').on('hidden.bs.modal', function (e) {
});
