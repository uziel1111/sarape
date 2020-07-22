<div class="container">
  <?php $idobjetivo = 0;?>
  <?php foreach ($seguimiento as $key => $value): ?>

    <?php if ($idobjetivo != $value['idobjetivo']): ?>
      <?php if ($idobjetivo != 0): ?>
      </div>
    </div>
      <?php endif; ?>
      <div class="card bg-light mb-3">
        <div class="card-header" style="background-color: #FFCC80; ">
          <b>Objetivo:</b> <?=$value['objetivo'];?>
        </div>
        <div class="card-body">
          <div class="row" style="background-color: #bee5eb; ">
            <div class="col-12">
              <b>Meta(s):</b> <?=$value['meta'];?>
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
              <div class="col-9">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 31%;">Acción</th>
                        <th style="width: 17%;">Ámbito</th>
                        <th style="width: 13%;">Fecha inicio</th>
                        <th style="width: 13%;">Fecha fin</th>
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
                              <input type="range" onchange="Seguimiento_pemc.guarda_avance(this, this.value,<?=$value['idaccion']?>,<?=($value['avance']=='')?0:$value['avance']?>, ageOutputId<?=$value['idaccion']?>)" class="form-control-range" name="ageInputName<?=$value['idaccion']?>" id="ageInputId<?=$value['idaccion']?>" max="100" min="0" step="10" value="<?=($value['avance']=='')?0:$value['avance'] ?>" oninput="ageOutputId<?=$value['idaccion']?>.value = ageInputId<?=$value['idaccion']?>.value">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4 text-left">0%</div>
                            <div class="col-4 text-center">50%</div>
                            <div class="col-4 text-right">100%</div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-3 text-center">
                <br><br>
                <button type="button" onclick="Seguimiento_pemc.ver_avance(<?=$value['idaccion']?>)" class="btn btn-info">Ver historial de avances</button>
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

<script type="text/javascript" src="<?= base_url('assets/js/pemc/seguimiento.js') ?>"></script>
