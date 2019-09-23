<div class="row">
	<div class="col-md-12">
		<div class="col-md-12">
			<h1>TOTAL DE ESCUELAS: <b><?=$result['total']?></b></h1>
		</div>

		<div class="col-md-12">
			<select id="nivel_educativo_grid_general" class="form-control">
				<option value="0">Todos los niveles</option>
				<option value="1">Especial</option>
				<option value="2">Inicial</option>
				<option value="3">Preescolar</option>
				<option value="4">Primaria</option>
			</select>
		</div>

		<div id="piechart" style="width: 800px; height: 500px;"></div>
	</div>

	<div class="col-sm-12">
		<table class="table">
			<thead class="thead-dark">
				<tr>			
					<th>Municipio</th>
					<th>Total de Escuelas</th>
					<th>0</th>
					<th>1</th>
					<th>2-3</th>
					<th>4 o más</th>
				</tr>
			</thead>
			<tbody>	


				<?php foreach ($result['datos'] as $key => $value) {  //echo '<pre>'; print_r($result); die(); ?>
				<tr>	
					<td><?=$value['nombre']?></td>
					<td><?=$result['total']?></td>
					<td><?=$result['obj0']?></td>
					<td><?=$result['obj1']?></td>
					<td><?=$result['obj2']?></td>
					<td><?=$result['obj4']?></td> 
				</tr>
			<?php } ?>

		</tbody>
	</table>
</div>		
</div>
</div>


<script src="<?= base_url('assets/js/estadistica_pemc/selectEducativo.js') ?>"></script>
