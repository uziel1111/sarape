<?php if (isset($espacio)) {
    echo $espacio;
} ?>
<div class="container">   
    <div class="card card-style-1">
        <div class="row-mb-2">
            <br>
            <nav>
                <div class="nav nav-tabs nav-tabs-style-1" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link nav-link-style-1" id="nav-aprov_prim" data-toggle="tab" href="#aprov_prim" role="tab" aria-controls="nav-aprov_prim" aria-selected="">Primaria</a>
                    <a class="nav-item nav-link nav-link-style-1 " id="nav-aprov_secu" data-toggle="tab" href="#aprov_secu" role="tab" aria-controls="nav-aprov_secu" aria-selected="false">Secundaria</a>
                </div>
            </nav>
        </div>
        <div class="tab-content tab-content-style-1" id="nav-tabContent">
           <div class="row-mb-2" id="">
             <div class="tab-pane fade" id="aprov_prim" role="tabpanel" aria-labelledby="aprov_prim" style="display: block;">
                 <?= $aprov_prim?>
             </div>
             <div class="row-mb-2" id="">
               <div class="tab-pane fade" id="aprov_secu" role="tabpanel" aria-labelledby="aprov_secu" style="display: none;">
                 <?= $aprov_secu?>
             </div>
         </div>
     </div>
 </div>
</div>
</div>
<br>

<script>
  $(document).ready(function(){
        $('#nav-aprov_prim').trigger("click");
    });

    $('#nav-aprov_secu').click(function(e){
        e.preventDefault();
        $('#aprov_secu').show();
        $('#aprov_prim').hide();
        
    })

  $('#nav-aprov_prim').click(function(e){
        e.preventDefault();
        $('#aprov_prim').show();
        $('#aprov_secu').hide();
    })


</script>