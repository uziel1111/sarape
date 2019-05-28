<!-- Modal -->
<div id="modal_informese" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header  bgcolor-2">
        <h5 class="modal-title color-6" id="exampleModalLongTitle">Edición #<?= $num_ed[0]?>
          <?php if ($num_ed[0]==1): ?> septiembre<?php endif; ?>
          <?php if ($num_ed[0]==2): ?> octubre<?php endif; ?>
          <?php if ($num_ed[0]==3): ?> noviembre<?php endif; ?>
          <?php if ($num_ed[0]==4): ?> diciembre<?php endif; ?>
          <?php if ($num_ed[0]==5): ?> enero<?php endif; ?>
        </h5>
        <button type="button" class="close color-6" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
