<div>
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