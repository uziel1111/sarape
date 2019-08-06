<h4>Porcentaje comparativo</h4>
<p class="text-muted font-italic font-weight-bold">Total de documentos por Subsecretaría / Secretaría</p>
<hr/>

									<div class="row">
											<div class="col">
												<div class="wrimagecard wrimagecard-topimage">

													<div class="wrimagecard-topimage_header">
														<center><i class="fas fa-file-alt" data-toggle="tooltip" title="Total de documentos por usuario" style="font-size: 30px"></i>
														</center>
													</div>
													<div class="wrimagecard-topimage_title">
														<center>
														<h4><?=$propio;?></h4>
														</center>
													</div>

												</div>
											</div>
											<div class="col-sm-10">
												<div class="box box-especial">
													<div class="box-body no-padding">
														<table class="table">
															<tr>
																<td style="width:10%" nowrap data-toggle="tooltip" title="Total de documentos por subsecretaría"><i class="fas fa-square"></i> &nbsp;Subsecretaría
																</td>
																<td style="width: 20%"><?=$sub;?></td>
																<td style="width: 65%">
																	<div class="progress">
																		<div class="progress-bar bg-info" role="progressbar" style="width:<?=$grafica1;?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</td>
																<td style="width: 10%"><span class="badge badge-secondary" style="font-size: 16px"><?=$grafica1;?> %</span>
																</td>
															</tr>
															<tr>
																<td data-toggle="tooltip" title="Total de documentos en el sistema"><i class="fas fa-sitemap"></i> Secretaría
																</td>
																<td><?=$universo;?></td>
																<td>
																	<div class="progress">
																		<div class="progress-bar" role="progressbar" style="width: <?=$grafica2;?>%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</td>
																<td><span class="badge badge-primary" style="font-size: 16px"><?=$grafica2;?> %</span>
																</td>
															</tr>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>