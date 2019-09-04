
<?php $i=0; $j =0;
foreach ($temas as $key => $dato){
	$i++;
	?>
	<div class="accordion accordion-style-1" id="accordionExample">
		<div class="card mb-3">
			<div class="card-header collapsed" id="headingOne" data-toggle="collapse" data-target="#collapse<?=$i?>" aria-expanded="false" aria-controls="collapse" style="cursor: pointer;">
				<i class="fas fa-clipboard-list mr-2"></i> <span class="second-txt"><?= $dato?></span>
			</div>
			
			<div id="collapse<?= $i?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				<div class="card-body p-0">
					<div class="tab-content tab-content-style-1" id="myTabContent">
						<div class="tab-pane fade show active" id="encuestas" role="tabpanel" aria-labelledby="encuestas-tab">
							<div class="row">
								<div class="col">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th scope="col">#</th>
												<th scope="col">Nombre del documento</th>
												<th scope="col">Ver</th>
											</tr>
										</thead>
										<tbody id="tabla_documentos">
											<?php foreach ($temaid as $key => $value) {
												foreach ($formato as $key => $f) {
													if ($f['tema']== $formato[$j][0]['tema']) {
													
													$j++;?>
													

													<tr>
														<td><?=$j?></td>
														<td><?=$formato[$j][0]['idaplicar']?></td>
														<td><?=$formato[$j][0]['respuesta']?></td>
														<td>
															<span data-toggle='modal' data-target='#verDocumento'>
																<button type='button' data-toggle='tooltip' title='Ver documento' onclick='documento(<?=$formato[$j][0]['idaplicar']?>)' class='btn btn-sm btn-secondary'><i class='fas fa-file-alt mx-1'></i></button>
															</span>


															<span data-toggle='modal' data-target='#verDetalle'>
																<button type='button' data-toggle='tooltip' title='Ver detalle' onclick='detalle(<?=$formato[$j][0]['idaplicar']?>)' class='btn btn-sm btn-success'><i class='fas far fa-eye'></i></button>
															</span>


														</td>
													</tr>


													<?php	
												}

												}
											} ?>
												
										</tbody>
									</table>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>