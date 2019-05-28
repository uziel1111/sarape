<div class='table-responsive'>
	 <table id='id_tabla_rutas' class='table table-condensed table-hover  table-bordered'>
		<thead>
			<tr class=info>
				<th id='idrutamtema' hidden><center>id</center></th>
				<th id='orden' style='width:4%'><center>Orden</center></th>
				<th id='tema' style='width:20%'><center>Temas Prioritarios</center></th>
				<th id='problemas' style='width:31%'><center>Problemáticas</center></th>
				<th id='evidencias' style='width:31%'><center>Evidencias</center></th>
				<th id='n_actividades' style='width:4%'><center>Actividades</center></th>
				<th id='objetivo' style='width:6%'><center>Objetivo</center></th>
				<th id='objetivo' style='width:6%'><center>Observación</center></th>
				<!-- <th id='objetivo' style='width:6%'><center>Archivo evidencia</center></th> -->
			</tr>
		</thead>

		<tbody id='id_tbody_demo'>

			<?php foreach ($rutas as $ruta): ?>
				<tr>
					<td id='id_tprioritario' hidden><center><?php echo $ruta['id_tprioritario'] ?></center></td>
					<td id='orden' data='1'><?php echo $ruta['orden'] ?></td>
					<td id='tema' data='Normalidad mínima'><?php echo $ruta['prioridad'] ?></td>
					<td id='problemas' data='Asistencia de profesores' ><?php echo $ruta['otro_problematica'] ?></td>
					<td id='evidencias' data='SISAT'><?php echo $ruta['otro_evidencia'] ?></td>
					<td id='n_actividades' data='0'><?php echo $ruta['n_acciones'] ?></td>
					<td id=''><center><i class='fas fa-check-circle'></i></center></td>
					<td id=''><center><i class='{$ruta['obs_supervisor']}'></i></center></td>
					<!-- <td id=''><center><button  style='display:{$ruta['trae_path']};' type='button' class='btn btn-primary btn-style-1 mr-1' onclick=obj_rm_tp.ver_archivo_evidencia('{$ruta['path_evidencia']}')>Ver</button></center>
					</td> -->
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/rutademejora/drag.js') ?>"></script>
