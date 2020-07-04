<div class="container">
  <form class="form-group" id="fr_diagnostico" method="post" action="<?= base_url('Pemc/guarda_diagnostico') ?>">
  <label class="my-1 mr-2" for="in_diag">Redacte su diagnóstico:</label>
   <textarea class="form-control" name="in_diag" id="in_diag" rows="3"><?=$diagnostico?></textarea>

  <button type="submit" class="btn btn-primary my-1  float-right">Grabar</button>
</form>
</div>
