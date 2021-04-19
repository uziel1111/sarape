 <div class="container">
   <div class="row">
    <div class="col-md-4 form-group form-group-style-1">
      <label for="nivel_educativo_zona">Seleccione un nivel educativo</label>
      <select id="nivel_educativo_zona" class="form-control">
        <option value="0">Todos los niveles</option>
        <option value="2">Inicial</option>
        <option value="3">Preescolar</option>
        <option value="4">Primaria</option>
        <option value="5">Secundaria</option>
      </select></label>
    </div>


    <!-- por Zona -->
    <div class="col-md-4 form-group form-group-style-1 div_zona">
     <label for="sostenimiento_zona">Seleccione un sostenimiento</label>
     <select id="sostenimiento_zona" class="form-control">
      <option value="0">Todos los sostenimientos</option>
      <option value="1">Público</option>
      <option value="2">Privado</option>
    </select></label>
  </div>
  <div class="col-md-4 form-group form-group-style-1 div_zona">
   <label for="zona_zona" >Seleccione una zona</label>
   <select id="zona_zona" class="form-control" disabled>
    <option value="0">Todas las zonas</option>
    <?php foreach ($zonas as $key => $zona) { ?>
      <option value="<?= $zona['zona_escolar'] ?>"><?= $zona['zona_escolar'] ?></option>
    <?php } ?>
  </select></label>
</div>
</div>
</div>


<div class="col-md-12">
	<table class="table table-striped table-bordered w-auto">
		<thead class="thead-dark">
			<tr>
				<th>Zona</th>
        <th>Nivel</th>
        <th>Sostenimiento</th>
        <th>LAE 1</th>
        <th>LAE 2</th>
        <th>LAE 3</th>
        <th>LAE 4</th>
        <th>LAE 5</th>
      </tr>
    </thead>
    <tbody>
     <?php foreach ($tabla as $key => $value) { ?>
      <tr>

        <td><?=$value['zona_escolar']?></td>
        <td><?=$value['nivel']?></td>
        <td><?=$value['sostenimiento']?></td>
        <td><?=$value['lae1']?>%</td>
        <td><?=$value['lae2']?>%</td>
        <td><?=$value['lae3']?>%</td>
        <td><?=$value['lae4']?>%</td>
        <td><?=$value['lae5']?>%</td>

      </tr>
    <?php } ?>
  </tbody>
</table>
</div>


<script src="<?= base_url('assets/js/estadistica_pemc/selectEducativo.js') ?>"></script>
