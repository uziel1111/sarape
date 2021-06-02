$("#btn_reconocimientosEstatales_30").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/MEDALLAS30.pdf");
});

$("#btn_reconocimientosEstatales_40").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/MEDALLAS40.pdf");
});

$("#btn_reconocimientosEstatales_50").click(function(e){
  e.preventDefault();
  Utiles.showPDF("modal_reconocimientosEstatalesPdf", "index/reconocimientosEstatales/MEDALLAS50.pdf");
});


$('#modal_reconocimientosEstatales').on('hidden.bs.modal', function (e) {
});

$('#modal_reconocimientosEstatalesPdf').on('hidden.bs.modal', function (e) {
});
