$(function () {
 this_buscador = new Buscador();
});


$("#slc_busquedalista_municipio").change(function (){
  $("input[name=hidden_municipio]").val( $('option:selected',this).text() );

  let cve_municipio = $('#slc_busquedalista_municipio').val();
  if(cve_municipio=='-1'){
    $("#slc_busquedalista_nivel").empty();
    $("#slc_busquedalista_nivel").append('<option value=-1> TODOS </option>');
  }else{
      $("#slc_busquedalista_sostenimiento").empty();
      $("#slc_busquedalista_sostenimiento").append('<option value=-1> TODOS </option>');
      this_buscador.get_niveles(cve_municipio);
  }
});

$("#slc_busquedalista_nivel").change(function (){
  $("input[name=hidden_nivel]").val( $('option:selected',this).text() );

  let cve_nivel = $('#slc_busquedalista_nivel').val();
  $("#slc_busquedalista_sostenimiento").empty();
  if(cve_nivel=='-a'){
    $("#slc_busquedalista_sostenimiento").append('<option value=-1> TODOS </option>');
  }else{
      $("#slc_busquedalista_sostenimiento").append('<option value=-1> TODOS </option>');
      this_buscador.get_sostenimientos(cve_nivel);
  }
});

$("#slc_busquedalista_sostenimiento").change(function (){
  $("input[name=hidden_sostenimiento]").val( $('option:selected',this).text() );
});

$("#itxt_busquedalista_cct").keyup(function() {
  if($(this).val().length==8){
      let obj_re = new Regularexpression();
      let valid = obj_re.cct(this.value);
      if(valid){
        this_buscador.get_xcvecentro(this.value);
      }
  }
  else if ($(this).val().length>8) {
    alert('longitud incorrecta');
    this.value = this.value.substring(0, this.value.length - 1);
  }
});

function Buscador(){
}

Buscador.prototype.get_niveles = function(cve_municipio){
  let ruta = base_url+"Catalogos/getniveles_xcvemunicipio";
      $.ajax({
        url: ruta,
        method: 'POST',
        data: {'cve_municipio':cve_municipio},
        beforeSend: function(xhr) {
    	        Notification.loading("");
    	    },
      })
      .done(function( data ) {
        $("#slc_busquedalista_nivel").empty();
        $("#slc_busquedalista_nivel").append(data.str_select);
      })
      .fail(function(e) {
        console.error("Error in get_niveles()"); console.table(e);
      })
      .always(function() {
        swal.close();
    	});

};

Buscador.prototype.get_sostenimientos = function(cve_nivel){
  let ruta = base_url+"Catalogos/getsostenimientos_xcvenivel";
      $.ajax({
        url: ruta,
        method: 'POST',
        data: {'cve_nivel':cve_nivel},
        beforeSend: function(xhr) {
    	        Notification.loading("");
    	  },
      })
      .done(function( data ) {
        $("#slc_busquedalista_sostenimiento").empty();
        $("#slc_busquedalista_sostenimiento").append(data.str_select);
      })
      .fail(function(e) {
        console.error("Error in get_sostenimientos()"); console.table(e);
      })
      .always(function() {
        swal.close();
    	});
};

Buscador.prototype.get_xcvecentro = function(cve_centro){
    let ruta = base_url+"Busqueda_xlista/escuelas_xcvecentro";
      $.ajax({
        url: ruta,
        method: 'POST',
        data: {'cve_centro':cve_centro},
        beforeSend: function(xhr) {
    	        Notification.loading("");
    	  },
      })
      .done(function( data ) {
         // alert('khe pex?');
        if(data.total_escuelas==0){
          alert('sin resultados');
        }
        if(data.total_escuelas==1){
          this_buscador.form(data.cct,data.turno,data.turno_single);
        }
        else if (data.total_escuelas>1) {
          $("#cct").empty();
          $("#cct").append(data.str_select);
          $("#busquedalista_modal").modal("show");
        }
      })
      .fail(function(e) {
        console.error("Error in get_xcvecentro()"); console.table(e);
      })
      .always(function() {
        swal.close();
    	});
};

Buscador.prototype.form = function(cct,turno,turno_single){
  var form = document.createElement("form");
  form.name = "form_getinfo";
  form.id = "form_getinfo";
  form.method = "POST";
  form.target = "_self";
  form.action = base_url+"info/index/";

  var element1 = document.createElement("input");
  var element2 = document.createElement("input");
  var element3 = document.createElement("input");

  element1.type = "hidden";
  element1.name="id_cct";
  element1.value = cct;

  element2.type = "hidden";
  element2.name="turno";
  element2.value = turno;

  element3.type = "hidden";
  element3.name="turno_single";
  element3.value = turno_single;
  form.appendChild(element1);
  form.appendChild(element2);
  form.appendChild(element3);
  document.body.appendChild(form);
  form.submit();
};

$('#busquedalista_modal').on('hidden.bs.modal', function (e) {
  $("#cct").empty();
})
