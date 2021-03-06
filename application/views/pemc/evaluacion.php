<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-10">
        <a  href="<?= base_url('index.php/Pemc/reporte_pemc/').$idpemc ?>" target="_blank"><button type="button" class="btn btn-a2">Imprime PEMC</button></a>
      </div>
      <div class="col-2 text-light text-right">
        <a tabindex="0" class="btn btn-lg btn-dark" role="button" data-toggle="popover" data-trigger="focus" title="Evaluación:" data-content="Implica realizar una revisión crítica, al final del ciclo escolar, sobre el impacto de las acciones implementadas por ámbito."><i class="fa fa-info-circle"></i></a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="container">
      <form class="form-group" name="<?=(($es_fin && (!$esta_cerrado_ciclo) && ($tipo_usuario=="escuela"))?'fr_evaluacion':'')?>" 
        id="<?=(($es_fin && (!$esta_cerrado_ciclo) && ($tipo_usuario=="escuela"))?'fr_evaluacion':'')?>">
      <label class="my-1 mr-2" for="in_eval">Redacte su evaluación:</label>
       <textarea <?= ($es_fin && ($tipo_usuario=="escuela"))? '': 'disabled'?> class="form-control in_eval" name="in_eval" id="in_eval" rows="10" required <?=(($es_fin && (!$esta_cerrado_ciclo) && ($tipo_usuario=="escuela"))?'':'disabled')?>><?=$evaluacion?></textarea>

    <?php if ($es_fin && ($tipo_usuario=="escuela")): ?>
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
          <button class="btn btn-primary my-1  float-right" id="btn_guardar_cierre_pemc_" disabled>Cierre ciclo escolar</button>
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
            <tr>
            <td class="text-center">2020-07-22</td>
            <td class="text-center">2019-2020</td>
            <td class="text-center">
              <?php if ($n_acciones_pemc_ant>0): ?>
                <a  href="<?= base_url("pemcv1_masivos/".$cve_centro."_".$id_turno_single.".pdf") ?>" target="_blank"><button type="button" class="btn btn-a2">Ver reporte</button></a>
              <?php endif; ?>
              <?php if ($n_acciones_pemc_ant==0): ?>
                Escuela sin actividad de PEMC en el ciclo anterior
              <?php endif; ?>
            </td>
          </tr>

              <?php foreach ($evaluaciones as $key => $value): ?>
                <tr>
                <!-- <td class="text-center"><?=$value['evaluacion'];?></td> -->
                <td class="text-center"><?=$value['fcreacion'];?></td>
                <td class="text-center"><?=$value['ciclo_escolar'];?></td>
                <td class="text-center"><a  href="<?= base_url($value['url_reporte']) ?>" target="_blank"><button type="button" class="btn btn-a2">Ver reporte</button></a></td>
                </tr>
              <?php endforeach; ?>

          </tbody>
        </table>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-10">
        <h3>Observación Supervisor</h3>
      </div>
    </div>    
  </div>
  <div class="card-body">
    <div class="container">
      <form class="form-group" name="<?=(($tipo_usuario=="supervision")?'fr_observacion_'.$idpemc.$id_turno_single:'')?>" id="<?=(($tipo_usuario=="supervision")?'fr_observacion_'.$idpemc.$id_turno_single:'')?>">
      <label class="my-1 mr-2" for="in_obser">Redacte su observación:</label>
       <input type="hidden"  id="idpemc" name="idpemc" value="<?= $idpemc?>">
       <textarea  class="form-control in_obser" name="in_obser" id="in_obser" rows="10" required  <?=(($tipo_usuario=="supervision")?'':'disabled')?>><?=$observacion?></textarea>
    <?php if (($tipo_usuario=="supervision")): ?>
      <button class="btn btn-a1 my-1  float-right" onclick="Observacion_pemc. observacion_supervalidate('<?=$idpemc?>','<?=$id_turno_single?>')">Grabar</button>
    <?php endif; ?>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function() {
      $('[data-toggle="popover"]').popover();
    });
</script>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/evaluacion.js') ?>"></script>
