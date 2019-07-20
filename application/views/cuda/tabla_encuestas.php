<?php  $i = 0;
foreach ($array_encuestas as $key => $encuestas){ 
	$i++; ?>

	<tr>
		<th scope='row'><?=$i?></th>
		<td><?=$encuestas['respuesta']?></td>
		<td><?=$encuestas['idaplicar']?></td>
		<td>
			<span data-toggle='modal' data-target='#verDocumento'>
				<button type='button' data-toggle='tooltip' title='Ver documento' onclick='documento(<?=$encuestas['idaplicar']?>)' class='btn btn-sm btn-secondary'><i class='fas fa-file-alt mx-1'></i></button>
			</span>


			<span data-toggle='modal' data-target='#verDetalle'>
				<button type='button' data-toggle='tooltip' title='Ver detalle' onclick='detalle(<?=$encuestas['idaplicar']?>)' class='btn btn-sm btn-success'><i class='fas far fa-eye'></i></button>
			</span>


		</td>
	</tr>
<?php } ?> 
