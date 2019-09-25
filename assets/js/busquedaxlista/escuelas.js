$("#itxt_busquedalista_nombreescuela").keyup(function() {
    $("#itxt_busquedalista_nombreescuela_reporte").val($(this).val());
});

/*$(document).on("click", "#table_escuelas tbody tr", function(e) {
    var idescuela = $(this).data('idescuela');

    var form = document.createElement("form");
    var element1 = document.createElement("input");

    element1.type = "hidden";
    element1.name="id_cct";
    element1.value = idescuela;

    form.name = "form_escuelas_getinfo";
    form.id = "form_escuelas_getinfo";
    form.method = "POST";
    // form.target = "_self";
    form.action = base_url+"info/index/";

    document.body.appendChild(form);
    form.appendChild(element1);
    form.submit();
});*/
