<?php  $i = 0;
if (sizeof($array_encuestas) > 0 ) {

	foreach ($array_encuestas as $key => $encuestas){ 
		$i++; 
		?>

		<tr>
			<th scope='row'><?=$i?></th>
			<td><?=strtoupper($encuestas['respuesta'])?></td>
			<!-- <td><?php//$encuestas['fcreacion']?></td> -->
			<td width="130px">
				<span data-toggle='modal' data-target='#verDocumento'>
					<button type='button' data-toggle='tooltip' title='Ver documento' onclick='documento(<?=$encuestas['idaplicar']?>)' class='btn btn-sm btn-secondary'><i class='fas fa-file-alt mx-1'></i></button>
				</span>


				<span data-toggle='modal' data-target='#verDetalle'>
					<button type='button' data-toggle='tooltip' title='Ver detalle' onclick='detalle(<?=$encuestas['idaplicar']?>)' class='btn btn-sm btn-success'><i class='fas far fa-eye'></i></button>
				</span>


			</td>
		</tr>
	<?php } ?> 

	<?php foreach ($array_usuario as $key => $dato): ?>
		<div class="row">
			<div class="col">
				<div class="wrimagecard wrimagecard-topimage">

					<div class="wrimagecard-topimage_header">
						<center><i class="fas fa-user-tie"></i>
						</center>
					</div>
					<div class="wrimagecard-topimage_title">
						<h4><?= $dato['nombre']. ' ' .$dato['paterno'] .' '. $dato['materno']?></h4>
					</div>

				</div>
			</div>
			<div class="col">
				<p>

					<ul class="fa-ul">
						<li class="text-muted"><span class="fa-li"><i class="far fa-building"></i></span><?= $dato['area_departamento']?></li>
						<!-- <li><span class="fa-li text-danger"><i class="fas fa-map-marker-alt"></i></span>Coordinación General de Educación Normal y Actualización Docente</li> -->
						<li><span class="fa-li text-danger"><i class="fas fa-phone"></i></span><?=$dato['ntelefono']?></li>
						<li><span class="fa-li text-danger"><i class="fas fa-envelope"></i></span><a href="#" target="_blank"><?= $dato['email']?></a>
						</li>
					</ul>
				</p>
			</div>
		</div>
	<?php endforeach;

} else{?>
	<center><h4>Sin datos para mostrar.</h4></center>
	<?php } ?>