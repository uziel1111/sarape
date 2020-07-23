<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-10">
        <a  href="<?= base_url('Pemc/ver_reporte_xidpemc/').$idpemc ?>" target="_blank"><button type="button" class="btn btn-info">Imprime PEMC</button></a>
      </div>
      <div class="col-2 text-light text-right">
        <a tabindex="0" class="btn btn-lg btn-dark" role="button" data-toggle="popover" data-trigger="focus" title="Evaluación:" data-content="Implica realizar una revisión crítica, al final del ciclo escolar, sobre el impacto de las acciones implementadas por ámbito."><i class="fa fa-info-circle"></i></a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="container">
      <form class="form-group" name="<?=(($es_fin && (!$esta_cerrado_ciclo))?'fr_evaluacion':'')?>" id="<?=(($es_fin && (!$esta_cerrado_ciclo))?'fr_evaluacion':'')?>">
      <label class="my-1 mr-2" for="in_eval">Redacte su evaluación:</label>
       <textarea class="form-control" name="in_eval" id="in_eval" rows="10" required <?=(($es_fin && (!$esta_cerrado_ciclo))?'':'disabled')?>><?=$evaluacion?></textarea>

    <?php if ($es_fin && (!$esta_cerrado_ciclo)): ?>
      <button class="btn btn-primary my-1  float-right" id="btn_guardar_evaluacion_pemc">Grabar</button>
    <?php endif; ?>
    </form>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-10">
        <h3>Historial de PEMC</h3>
      </div>
      <div class="col-2">
        <?php if ($es_fin && (!$esta_cerrado_ciclo)): ?>
          <button class="btn btn-primary my-1  float-right" id="btn_guardar_cierre_pemc">Cierre ciclo escolar</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="container">
      <table class="table table-borderless">
          <thead>
            <tr>
              <!-- <th class="text-center">Evaluaciones</th> -->
              <th class="text-center">Fechas</th>
              <th class="text-center">Ciclo escolar</th>
              <th class="text-center">Reportes PDF</th>
            </tr>
          </thead>
          <tbody>

              <?php foreach ($evaluaciones as $key => $value): ?>
                <tr>
                <!-- <td class="text-center"><?=$value['evaluacion'];?></td> -->
                <td class="text-center"><?=$value['fcreacion'];?></td>
                <td class="text-center"><?=$value['ciclo_escolar'];?></td>
                <td class="text-center"><a  href="<?= base_url($value['url_reporte']) ?>" target="_blank"><button type="button" class="btn btn-info">Ver reporte</button></a></td>
                </tr>
              <?php endforeach; ?>

          </tbody>
        </table>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function() {
      $('[data-toggle="popover"]').popover();
    });
</script>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/evaluacion.js') ?>"></script>
