<div class="row">
	<div class="col-md-12">
		<div class="col-md-12">
			<h1>TOTAL DE ESCUELAS POR ESTADO: <b><?=$result['total']?></b></h1>
		</div>

		<div class="col-md-12">
			<select id="nivel_educativo_grid_general" class="form-control">
				<option value="0">Todos los niveles</option>
				<option value="1">Especial</option>
				<option value="2">Inicial</option>
				<option value="3">Preescolar</option>
				<option value="4">Primaria</option>
				<option value="5">Secundaria</option>
			</select>
		</div>

		<div id="piechart" style="width: 800px; height: 500px;"></div>
	</div>

	<div class="col-sm-12">
		<table class="table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th>Municipio</th>
					<th>Total de Escuelas</th>
					<th colspan="4"><center>Objetivos capturados</center></th>
				</tr>
				<tr>			
					<th></th>
					<th></th>
					<th>0</th>
					<th>1</th>
					<th>2-3</th>
					<th>4 o más</th>
				</tr>
			</thead>
			<tbody>	

				<?=$result['tabla']?>
				
		</tbody>
	</table>
</div>		
</div>
</div>


<script src="<?= base_url('assets/js/estadistica_pemc/selectEducativo.js') ?>"></script>
