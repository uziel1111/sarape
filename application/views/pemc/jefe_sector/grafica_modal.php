<div>
  <div class="col-md-12">
    <center><h4>TOTAL DE ESCUELAS: <b><?=number_format($n_esc)?></b></h4></center>
  </div>
  <div class="col-md-12 ">
    <div class="d-flex justify-content-center" id="piechart_js" style="width: 900px; height: 300px;"></div>
  </div>
</div>

<div>
 <br>
 <div id="columnchart_material_xjefesector" class="float-left mt-4"></div>
 <div id="columnchart_material_acciones_xjefesector"  class="float-right mt-4"></div>
 <br>
</div>

<div class="col-md-12 table-responsive mt-4" >
 <div class="d-flex justify-content-center float-none mt-4">
  <p>
    <b>LAE-1 </b>EQUIPAMIENTO E INFRAESTRUCTURA DE ALTA CALIDAD <br>
    <b>LAE-2 </b>ASEGURAR ALTOS ÍNDICES DE APRENDIZAJES A TODA LA POBLACIÓN EDUCATIVA <br>
    <b>LAE-3 </b>CONTAR CON PERSONAL COMPETITIVO A NIVEL INTERNACIONAL <br>
    <b>LAE-4 </b>GENERAR AMBIENTES DE COLABORACIÓN Y CORRESPONSABILIDAD CON LOS PADRES DE FAMILIA <br>
    <b>LAE-5 </b>CONSOLIDAR EL LIDERAZGO DE DIRECTIVOS Y DOCENTES <br>
    <br>
    <strong>Nota:</strong><span style="color:red;"> Las escuelas no aparecen en la tabla no han ingresado a la plataforma de <strong>Programa Escolar de Mejora Continua</strong></span>
  </p>
</div>
<br>
<table class="table table-striped table-bordered w-auto">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Escuela</th>
      <th scope="col">CCT</th>
      <th scope="col" colspan="2"><center>LAE 1</center></th>
      <th scope="col" colspan="2"><center>LAE 2</center></th>
      <th scope="col" colspan="2"><center>LAE 3</center></th>
      <th scope="col" colspan="2"><center>LAE 4</center></th>
      <th scope="col" colspan="2"><center>LAE 5</center></th>
    </tr>
    <tr>
      <th></th>
      <th></th>
      <th>Obj</th>
      <th>Acc</th>
      <th>Obj</th>
      <th>Acc</th>
      <th>Obj</th>
      <th>Acc</th>
      <th>Obj</th>
      <th>Acc</th>
      <th>Obj</th>
      <th>Acc</th>
    </tr>
  </thead>
  <tbody id='tablabody'>
    <?php foreach ($tabla as $key => $value) { ?>
      <tr>
        <td><?=$value['nombre_centro']?></td>
        <td><?=$value['cve_centro']?></td>
        <td><?=$value['obj1']?></td>
        <td><?=$value['acc1']?></td>
        <td><?=$value['obj2']?></td>
        <td><?=$value['acc2']?></td>
        <td><?=$value['obj3']?></td>
        <td><?=$value['acc3']?></td>
        <td><?=$value['obj4']?></td>
        <td><?=$value['acc4']?></td>
        <td><?=$value['obj5']?></td>
        <td><?=$value['acc5']?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
</div>

</div>
</div>
