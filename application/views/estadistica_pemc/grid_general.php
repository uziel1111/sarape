<div class="row">
	<div class="col-md-12">
		<div id="piechart"></div>
		<div>
				<table>	
					<thead>	
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


						<?php foreach ($result['datos'] as $key => $value) {  //echo '<pre>'; print_r($value); die(); ?>
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