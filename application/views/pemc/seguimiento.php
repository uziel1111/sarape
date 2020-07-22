<div class="container">
  <?php $idobjetivo = 0;?>
  <?php foreach ($seguimiento as $key => $value): ?>

    <?php if ($idobjetivo != $value['idobjetivo']): ?>
      <?php if ($idobjetivo != 0): ?>
      </div>
    </div>
      <?php endif; ?>
      <div class="row">
        <div class="col-10">
        </div>
        <div class="col-2 text-light text-right">
  				<a tabindex="0" class="btn btn-lg btn-dark" role="button" data-toggle="popover" data-trigger="focus" title="Seguimiento:" data-content="Es pieza clave en el desarrollo del PEMC, ya que la información que ofrece permite establecer si mediante la implementación del conjunto de acciones se favorece la incorporación de prácticas educativas y de gestión para el logro de los aprendizajes y reconocer la brecha entre lo planeado y lo que realmente se implementa."><i class="fa fa-info-circle"></i></a>
  			</div>
      </div>
      <div class="card bg-light mb-3">
        <div class="card-header" style="background-color: #FFCC80; ">
          <b>Objetivo:</b> <?=$value['objetivo'];?>
        </div>
        <div class="card-body">
          <div class="row" style="background-color: #bee5eb; ">
            <div class="col-12">
              <b>Meta:</b> <?=$value['meta'];?>
            </div>
          </div>
          <div class="row" style="background-color: #c3e6cb; ">
            <div class="col-12">
              <b>Comentarios generales:</b> <?=$value['comentario_general'];?>
            </div>
          </div>
          <br>

        <?php endif; ?>
            <div class="row">
              <div class="col-12">
                <div class="table">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 31%;">Acción</th>
                        <th style="width: 22%;">Ámbito</th>
                        <th style="width: 11%;">Fecha inicio</th>
                        <th style="width: 10%;">Fecha fin</th>
                        <th style="width: 26%;">Marque el avance</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?=$value['accion'] ?></td>
                        <td><?=str_replace(',', ', ', $value['ambitos']) ?></td>
                        <td><?=$value['finicio'] ?></td>
                        <td><?=$value['ffin'] ?></td>
                        <td>
                          <div class="row">
                            <div class="col-12 text-center">
                              <label>Avance actual:</label> <output name="ageOutputName<?=$value['idaccion']?>" id="ageOutputId<?=$value['idaccion']?>"><?=($value['avance']=='')?0:$value['avance'] ?></output><label>%</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <input type="range" onchange="Seguimiento_pemc.guarda_avance(this, this.value,<?=$value['idaccion']?>,<?=($value['avance']=='')?0:$value['avance']?>, ageOutputId<?=$value['idaccion']?>)" class="form-control-range" name="ageInputName<?=$value['idaccion']?>" id="ageInputId<?=$value['idaccion']?>" max="100" min="0" step="5" value="<?=($value['avance']=='')?0:$value['avance'] ?>" oninput="ageOutputId<?=$value['idaccion']?>.value = ageInputId<?=$value['idaccion']?>.value">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4 text-left">0%</div>
                            <div class="col-4 text-center">50%</div>
                            <div class="col-4 text-right">100%</div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col  text-center">
                              <button type="button" onclick="Seguimiento_pemc.ver_avance(<?=$value['idaccion']?>)" class="btn btn-info">Ver historial</button>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>


        <!-- <?php if ($idobjetivo != $value['idobjetivo']): ?>
          </div>
        </div>
        <?php endif; ?> -->

    <?php $idobjetivo = $value['idobjetivo'];?>
  <?php endforeach; ?>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modal_generico_avance" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header">
	        <h5 class="modal-title">Avances</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	    </div>
	    <div class="modal-body">
	        <div id="contenedor_modal_avance"></div>
	     </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function() {
      $('[data-toggle="popover"]').popover();
    });
</script>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/seguimiento.js') ?>"></script>
