<div class="container">
	<div class="row justify-content-md-center">
				<div class="col-md-2 form-group form-group-style-1">
					<label for="nivel_educativo_grid_general">Seleccione un Nivel</label>
				</div>
				<div class="col-md-10  form-group form-group-style-1">
					<select id="nivel_educativo_grid_general" class="form-control">
						<option value="0" selected="">Todos los niveles</option>
						<option value="1">Especial</option>
						<!-- <option value="2">Inicial</option> -->
						<option value="3">Preescolar</option>
						<option value="4">Primaria</option>
						<option value="5">Secundaria</option>
					</select>
				</div>

			<div class="col-md-12">
				<h1>TOTAL DE ESCUELAS EN EL ESTADO: <b><?=number_format($result['total'])?></b></h1>
			</div>

			<div class="col-md-12 offset-md-4">
				<div id="piechart" style="width: 800px; height: 400px;"></div>
			</div>

	</div>

	<div class="col-md-12">
		<table class="table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th>Municipio</th>
					<th colspan="3"><center>Total de Escuelas</center></th>
					<th colspan="4"><center>Objetivos capturados</center></th>
				</tr>
				<tr>
					<th></th>
					<th>Existentes</th>
					<th>Con captura</th>
					<th>% captura</th>
					<th>0</th>
					<th>1</th>
					<th>2-3</th>
					<th>4 o más</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($result['tabla'] as $key => $value): ?>
					<tr>
						<td><?=$value['municipio']?></td>
						<td><?=number_format($value['n_escxmuni'])?></td>
						<td><?=number_format($value['esc_que_capt'])?></td>
						<td><?=$value['porcentaje']."%"?></td>
						<td><?=number_format($value['esc_con0obj'])?></td>
						<td><?=number_format($value['esc_con1obj'])?></td>
						<td><?=number_format($value['esc_con2y3obj'])?></td>
						<td><?=number_format($value['esc_conmasde4obj'])?></td>
					</tr>
				<?php endforeach; ?>

		</tbody>
	</table>
</div>
</div>
</div>


<script src="<?= base_url('assets/js/estadistica_pemc/selectEducativo.js') ?>"></script>
