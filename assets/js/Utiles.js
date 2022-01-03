// $(function () {
//   $('[data-toggle="tooltip"]').tooltip();
// });

var Utiles = {
  path_docs : "https://www.sarape.gob.mx/assets/docs/",

  showPDF : function(idModal, urlPdf){
    var dom = '<iframe src="'+this.path_docs+urlPdf+'" width="100%" height="500" style="border: none;"></iframe>';
    $("#"+idModal +" .modal-body").empty();
    $("#"+idModal +" .modal-body").html(dom);
    $("#"+idModal).modal("show");
  },

  get_colores_trumbowyg : () => {

    let colorLabels = {
    '#000': ' ',
    '#555': ' ',
    '#008F39': ' ',
    '#FF0000': ' ',
    '#FFFF00': ' ',
    '#FF8000': ' ',
    '#0000FF': ' ',
    '#ff1493': ' ',
    };

    $.each(colorLabels, function(colorHexCode, colorLabel) {
        $.trumbowyg.langs.en[colorHexCode] = colorLabel;
    });
    
    return {
        foreColorList: [
          '000',
          '555',
          '008F39',
          'FF0000',
          'FFFF00',
          'FF8000',
          '0000FF',
          'ff1493'
        ],
        backColorList: [
          '000',
          '555',
          '008F39',
          'FF0000',
          'FFFF00',
          'FF8000',
          '0000FF',
          'ff1493'
        ]
    };
  },

  get_botones_trumbowyg : () => {
    return  [
              ['undo', 'redo'], // Only supported in Blink browsers
              ['formatting'],
              ['foreColor', 'backColor'],
              ['strong', 'em', 'del'],
              ['superscript', 'subscript'],
              ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
              ['unorderedList', 'orderedList'],
              ['horizontalRule'],
              ['removeformat'],
              ['fullscreen'],
              ['link']
            ];
  }

};
