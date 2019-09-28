<style type="text/css">
  td {border: 1px #DDD solid; padding: 5px; cursor: pointer;}

.selected {
    background-color: #9ccc65;
    color: #FFF;
}
.popover-body {
    padding: .5rem .75rem;
    color: #212529;
}
.popover{
    max-width:600px;
}

.contenedorbtn{
  position: fixed;
  width: 55px;
  height: 55px;
  top: 220px;
  left: 30px;
  z-index: 50px;
  z-index: 100;
}
.botonF1{	
  width:60px;
  height:60px;
  border-radius:100%;
  background:#F44336;
  right:0;
  bottom:0;
  position:absolute;
  margin-right:16px;
  margin-bottom:16px;
  border:none;
  outline:none;
  color:#FFF;
  font-size:36px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  transition:.3s;
}
span{
  transition:.5s;
}
.botonF1:hover span{
  transform:rotate(360deg);
}
.botonF1:active{
  transform:scale(1.1);
}
.btnespe{
  width:40px;
  height:40px;
  border-radius:100%;
  border:none;
  color:#FFF;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  font-size:28px;
  outline:none;
  position:absolute;
  right:0;
  bottom:0;
  margin-right:26px;
  transform:scale(0);
}
.botonF2{
  background:#2196F3;
  margin-bottom:85px;
  transition:0.5s;
}
.botonF3{
  background:#673AB7;
  margin-bottom:130px;
  transition:0.7s;
}
.botonF4{
  background:#009688;
  margin-bottom:175px;
  transition:0.9s;
}
.botonF5{
  background:#FF5722;
  margin-bottom:220px;
  transition:0.99s;
}
.animacionVer{
  transform:scale(1);
}

.ir-arriba{
  display:none;
  background-repeat:no-repeat;	
  font-size:20px;
  color:black;
  cursor:pointer;
  position:fixed;
  bottom:10px;
  right:10px;
  z-index:2;
}

.ir-abajo{
  display:none;
  background-repeat:no-repeat;	
  font-size:20px;
  color:black;
  cursor:pointer;
  position:fixed;
  top:140px;
  right:10px;
  z-index:2;
}
</style>

<a class="ir-arriba"  javascript:void(0) title="Volver arriba">
  	<span class="fa-stack">
	    <i class="fa fa-circle fa-stack-2x"></i>
	    <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
  	</span>
</a>

<a class="ir-abajo"  javascript:void(0) title="Desplazarse abajo">
  	<span class="fa-stack">
	    <i class="fa fa-circle fa-stack-2x"></i>
	    <i class="fa fa-arrow-down fa-stack-1x fa-inverse"></i>
  	</span>
</a>
<!-- Start Main Area -->
<!-- <section class="main-area"> -->
<br>
<div class="container">
    <div class="alert alert-success text-center" role="alert" style="margin-bottom: 30px;">
        <h3>Programa Escolar de Mejora Continua (PEMC)</h3>
    </div>
	<div class="row justify-content-center flex-column mb-3">
		<nav>
			<div class="nav nav-tabs nav-tabs-style-1" id="nav-tab" role="tablist">
				<a class="nav-item nav-link nav-link-style-1 active" id="nav-ruta-tab" data-toggle="tab" href="#nav-ruta" role="tab" aria-controls="nav-ruta" aria-selected="true">PEMC</a>
				<a class="nav-item nav-link nav-link-style-1" id="nav-avances-tab" data-toggle="tab" href="#nav-avances" role="tab" aria-controls="nav-avances" aria-selected="false">Seguimiento</a>
				<a class="nav-item nav-link nav-link-style-1" id="nav-ayuda-tab" data-toggle="tab" href="#nav-ayuda" role="tab" aria-controls="nav-ayuda" aria-selected="false">Ayuda</a>
				<a class="nav-item nav-link nav-link-style-1" id="nav-resultados-tab" data-toggle="tab" href="#nav-resultados" role="tab" aria-controls="nav-resultados" aria-selected="false">Resultados</a>
			</div>
		</nav>
		<div class="tab-content tab-content-style-1" id="nav-tabContent">
			<div class="tab-pane fade show active" id="nav-ruta" role="tabpanel" aria-labelledby="nav-ruta-tab">
				<div class="row">
					<div class="col-md-12 " style="">
						<span class="text-danger">*Antes de agregar objetivos o acciones, seleccione la línea de acción estratégica (LAE) o ámbito. </span>
						<span data-toggle="modal" data-target="#prioridad">
						<button type="" id="btn_prioridad" style="margin-left: 75px" data-toggle="tooltip" title="Agregar Objetivos" class="btn btn-lg btn-primary" data-target="#myModal" data-dismiss="modal"><i class="fas fa-plus-square" ></i></button>
						</span>		
						<span data-toggle="modal" data-target="#actividades">
						<button type="button" style="margin-left: 90px" id="btn_rutamejora_acciones" title="Agregar Acciones" data-toggle="tooltip" title="Agregar Acciones" class="btn btn-lg btn-primary" ><i class="fas fa-tasks"></i></button>
						</span>
					</div>
				</div>
				<div class="row mt-15">
	              	<div class="col-12">
						<div id="contenedor_tabla" style="display: table;"></div>
	              	</div>
				</div>
			</div> <!-- Ruta mejora -->

			<div class="tab-pane fade" id="nav-avances" role="tabpanel" aria-labelledby="nav-avances-tab">
				<?= $vista_avance ?>
			</div> <!-- Avances -->
			<div class="tab-pane fade" id="nav-ayuda" role="tabpanel" aria-labelledby="nav-ayuda-tab">
				<?= $vista_ayuda ?>
			</div> <!-- Ayuda -->
			<div class="fade" id="nav-resultados" role="tabpanel" aria-labelledby="nav-resultados-tab">
				<br>
				<h1 align="center">Avances de acciones por escuela</h1>
				<br>
				<input type="text" name="id_cct_rm" id="id_cct_rm" value="<?=$id_cct_rm?>" hidden>
				<div id="chart_div"></div>
				<br>
				<h1 align="center">% de avance de Escuela.</h1>
				<div id="div_acc_graf"></div>
				<br>
				<h1 align="center">% de Acciones</h1>
				<div id="div_obj_graf"></div>
				<br>
				<h1 align="center">% de LAE</h1>
				<div id="div_lae_graf"></div>
			</div> <!-- Resultados -->

		</div> <!-- tab-content -->
	</div> <!-- row -->
</div> <!-- container -->
<div class="contenedorbtn">
	<?php if (isset($tipo_usuario_pemc)): ?>
		<input type="text" name="tipou_pemc" id="tipou_pemc" hidden>
	<?php else: ?>
	<button class="botonF1 ">
	   	<span><i class="fas fa-wrench fa-xs"></i></span>
	</button>
	<?php endif; ?>
	<br><br><br>
	<span width="800px" >El momento vigente es: CTE 1</span>
	<button class="btnespe botonF2" id="btn_mision" data-toggle="tooltip" title="Misión">
	  	<span><i class="fas fa-flag fa-xs"></i></span>
	</button>
	<a class="btnespe botonF3" id="btn_get_reporte_1" title="Generar reporte" target="_blank" href="<?= base_url('index.php/Reporte/get_reporte') ?>">
	  	<center><i class="fas fa-print fa-xs"></i></center>
	</a>
</div>

<!-- </section> -->
<!-- modal -->
<div id="myModal" class="modal fade" role="dialog" aria-labelledby="prioridad_modal" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;" >
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-style-1" style="width: 130% !important; align:center !important;">
			<div class="modal-header bg-dark">
				<h5 class="modal-title text-white" id="prioridad_modal"><i class="far fa-lightbulb"></i> </h5>
				<button type="button" class="close" id="close" data-target="#myModal" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" >
				<div id="div_generico">
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="exampleModalacciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-style-1">
			<div class="modal-header bgcolor-2">
				<h5 class="modal-title text-white" id="exampleModalLabel">Actividades por prioridad del Sistema Básico de Mejora</h5>
				<button type="button" class="close" id="cerrar_modal_acciones" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info" role="alert">
					Escuela: <span class="fw800"><label id="label_escuela"></label></span><br>

					<!-- Línea de acción: <span class="fw800"><label id="label_prioridad"></label></span><br> -->

					Problemática(s): <span class="fw800"><label id="label_problematica"></label></span><br>

					Evidencia(s): <span class="fw800"><label id="label_evidencia"></label></span>
				</div>
				<div class="card mb-3 card-style-1">
					<div class="card-header card-1-header bg-light">Acciones</div>
					<div class="card-body">
						<div class="card-block">
							<div class="form-group form-group-style-1">
				                <div class="row mt-15">
				                  	<div class="col-md-12">
					                    <label><label style="color:red;">*</label>Seleccione un objetivo/meta:</label>
										<select class="form-control" id="id_objetivos" required="true">
					                        <option value="0">SELECCIONE</option>
					                    </select>
									</div>
				                </div>
                	
								<div class="row mt-15">
									<div class="col-md-6">
										<label><label style="color:red;">*</label>Agregar acción:</label>
										<textarea id="txt_rm_meta" class="form-control" rows="5" maxlength="150" required="true"></textarea>
									</div>
									<div class="col-md-6">
										<label><label style="color:red;">*</label>Recursos:</label>
										<textarea id="txt_rm_obs" class="form-control" rows="5" maxlength="150" required="true"></textarea>
									</div>
								</div>

				                <div class="row mt-15">
				                  	<div class="col-md-12">
					                    <label><label style="color:red;">*</label>Responsable</label>
					                    <select class="selectpicker form-control" id="main_responsable" title="SELECCIONA" required>
					                    	<?= $responsables?>
					                    </select>
					                    <br>
					                    <textarea id="new_resp" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true" required="true"></textarea>
				                  	</div>
				                </div>
                				<div class="row mt-15">
									<div class="col-md-12" id="main_resp_2">
										<label>Otro responsable:</label>
										<input type="text" name="otro_resp" id="otro_resp" class="form-control" placeholder="Escribe el nombre del responsable">
									</div>
								</div>

								<div class="row mt-15">
									<div class="col-md-12">
										<label><label style="color:red;">*</label>Profesores que apoyan</label>
										<select class="selectpicker form-control" multiple data-selected-text-format="count > 3" id="slc_responsables" title="SELECCIONA">
										<?= $responsables?>
										</select>
										<br>
										<textarea id="txt_rm_otropa" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true"></textarea>
									</div>
								</div>
								<div class="row mt-15">
									<div class="col-md-12" id="div_otro_responsable">
										<label>Otro responsable:</label>
										<input type="text" name="otro_responsable" id="otro_responsable" class="form-control">
									</div>
								</div>

								<div class="row mt-15">
									<div class="col-md-6">
										<label><label style="color:red;">*</label>Fecha de inicio</label>
										<input id="datepicker1" disabled data-date-format="dd/mm/yyyy"/>
										<script>
											$('#datepicker1').datepicker({
												uiLibrary: 'bootstrap4'
											});
										</script>
									</div>

									<div class="col-md-6">
										<label><label style="color:red;">*</label>Fecha de término</label>
										<input id="datepicker2" data-date-format="mm/dd/yyyy" disabled/>
										<script>
											$('#datepicker2').datepicker({
												uiLibrary: 'bootstrap4'
											});
										</script>
									</div>
								</div>

								<!-- <div class="row mt-15"> -->
								<div class="row mt-15">
									<div class="col-md-12">
										<label style="color:red;">*</label>Datos obligatorios
									</div>
								</div>
								<div class="row mt-15 float-right">
									<div class="col-12 ">
										<?php if (isset($tipo_usuario_pemc)): ?>
										<?php else: ?>
											<button type="button" class="btn btn-primary btn-style-1 ml-20" id="btn_agregar_accion">Agregar acción</button>
											<button type="button" class="btn btn-primary btn-style-1 ml-20" id="btn_editando_accion">Editar</button>
										<?php endif; ?>
                    					<button type="button" id="saliract" class="btn btn-success btn-style-1 mr-10">Regresar</button>
									</div>
								</div>
							</div>
						</div><!-- card -->
						<br>
						<div class="row mt-15">
							<div class="col-12">
								<button id="id_btn_edita_accion" type="button" title="Editar" class="btn btn-primary"><i class="fas fa-edit"></i></button>
								<?php if (isset($tipo_usuario_pemc)): ?>

								<?php else: ?>
									<button id="id_btn_elimina_accion" type="button" title="Eliminar" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button>
								<?php endif; ?>
							</div>
						</div>
						<div class="row mt-15">
							<div class="col-12">
								<div id="contenedor_acciones_id"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- fin modal -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/btn_delete_tp.js') ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/rm_table_operation.js'); ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/rutademejora.js'); ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/rm_tp.js'); ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/rm_edith_tp.js'); ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/acciones.js'); ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/avances.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/ruta.js') ?>"></script>




<script type="text/javascript">
	$('.botonF1').click(function(){
	  	$('.btnespe').addClass('animacionVer');
	  	setTimeout(function(){
	        $('.btnespe').removeClass('animacionVer');
	    }, 4000)
	    $('#id_objetivos').val('0');
	});

	$(document).ready(function(){ //Hacia arriba
	  irArriba();
	});

	function irArriba(){
	  	$('.ir-arriba').click(function(){ $('body,html').animate({ scrollTop:'0px' },1000); });
	  	$(window).scroll(function(){
	    	if($(this).scrollTop() > 0){ $('.ir-arriba').slideDown(600); }else{ $('.ir-arriba').slideUp(600); }
	  	});
	  	$('.ir-abajo').click(function(){ $('body,html').animate({ scrollTop:'1000px' },1000); });
	}

	function irAbajo(){
	  	$('.ir-abajo').click(function(){ $('body,html').animate({ scrollTop:'0px' },1000); });
	  	$(window).scroll(function(){
	    	if($(this).scrollTop() > 0){ 
	    		$('.ir-arriba').slideDown(600); 
	    	}else{ 
	    		$('.ir-abajo').slideUp(600); 
	    	}
	  	});
	  $('.ir-abajo').click(function(){ $('body,html').animate({ scrollTop:'1000px' },1000); });
	}

	function subirImg(id_objetivos, imagen) {
		swal({
			title: '¿Está seguro de subir evidencia?',
			text: "Usted cargará una nueva imagen",
			type: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Cargar',
			cancelButtonText: 'Cancelar'
		})
		.then((result) => {
			if (result.value) {
				if (imagen == 1) {
					$('#imgIni').trigger("click");			
				}else{
					$('#imgFin').trigger("click");	
				}
			}
		});

		return true;
	}
</script>

