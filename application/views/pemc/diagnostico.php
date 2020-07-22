<div class="container">
  <form class="form-group" name="fr_diagnostico" id="fr_diagnostico">
    <div class="row">
      <div class="col-10">
        <label class="my-1 mr-2" for="in_diag">Redacte su diagnóstico:</label>
      </div>
      <div class="col-2 text-light text-right">
				<a tabindex="0" class="btn btn-lg btn-dark" role="button" data-toggle="popover" data-trigger="focus" title="Diagnóstico:" data-content="Es el punto de partida para la elaboración del PEMC. Es el momento en que la escuela hace un examen de su situación y la problemática que vive; se apoya en información que a su colectivo docente le permite analizar, reflexionar, identificar y priorizar las necesidades educativas para tomar decisiones consensuadas que favorezcan su atención."><i class="fa fa-info-circle"></i></a>
			</div>
    </div>

   <textarea class="form-control" name="in_diag" id="in_diag" rows="18" required><?=$diagnostico?></textarea>
<button class="btn btn-primary my-1  float-right" id="btn_guardar_diagnostico_pemc">Grabar</button>
</form>
</div>
<script type="text/javascript">
$(function() {
      $('[data-toggle="popover"]').popover();
    });
</script>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/diagnostico.js') ?>"></script>
