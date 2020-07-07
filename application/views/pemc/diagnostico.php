<div class="container">
  <form class="form-group" name="fr_diagnostico" id="fr_diagnostico">
  <label class="my-1 mr-2" for="in_diag">Redacte su diagnóstico:</label>
   <textarea class="form-control" name="in_diag" id="in_diag" rows="3" required><?=$diagnostico?></textarea>
<button class="btn btn-primary my-1  float-right" id="btn_guardar_diagnostico_pemc">Grabar</button>
</form>

</div>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/diagnostico.js') ?>"></script>
