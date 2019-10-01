 <div class="container">
   <div class="row">
    <div class="col-md-4 form-group form-group-style-1">
      <label for="nivel_educativo_zona">Seleccione un nivel educativo</label>
      <select id="nivel_educativo_zona" class="form-control">
        <option value="0">Todos los niveles</option>
        <option value="1">Especial</option>
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
              <option value="1">Publico</option>
              <option value="2">Privado</option>
              <option value="3">Autonomo</option>
                   </select></label>
         </div>
         <div class="col-md-4 form-group form-group-style-1 div_zona">
           <label for="zona_zona">Seleccione una zona</label>
            <select id="zona_zona" class="form-control">
              <option value="0">Todas las zonas</option>
              <?php foreach ($zonas as $key => $value) { ?>
                <option value="<?= $value['zona_escolar'] ?>"><?= $value['zona_escolar'] ?></option>
              <?php } ?>
                   </select></label>
         </div>
       </div>
     </div>


<div class="col-md-12 offset-md-4">
	<table class="table table-striped table-bordered w-auto">
		<thead class="thead-dark">
			<tr>
				<th>Zona</th>
				<th>LAE 1</th>
				<th>LAE 2</th>
				<th>LAE 3</th>
				<th>LAE 4</th>
				<th>LAE 5</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($zonas as $key => $value) { ?>
				<tr>
					<td>
						<?=$value['zona_escolar']?>
					</td>
					<?php if ($value['zona_escolar'] == 502){ ?> 
						<td>40%</td>
						<td>40%</td>
						<td>10%</td>
						<td>20%</td>
						<td>60%</td>
					<?php } ?>
					<?php if ($value['zona_escolar'] == 405){ ?> 
						<td>60%</td>
						<td>70%</td>
						<td>30%</td>
						<td>10%</td>
						<td>30%</td>
					<?php } ?>
					<?php if ($value['zona_escolar'] == 517){ ?> 
						<td>10%</td>
						<td>20%</td>
						<td>30%</td>
						<td>50%</td>
						<td>40%</td>
					<?php } ?>
					<?php if ($value['zona_escolar'] == 502){ ?> 
						<td>10%</td>
						<td>20%</td>
						<td>30%</td>
						<td>40%</td>
						<td>80%</td>
					<?php } ?>
					<?php if ($value['zona_escolar'] == 516){ ?> 
						<td>80%</td>
						<td>90%</td>
						<td>30%</td>
						<td>40%</td>
						<td>70%</td>
					<?php } else { ?>
						<td>0%</td>
						<td>0%</td>
						<td>0%</td>
						<td>0%</td>
						<td>0%</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>