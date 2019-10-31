<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .margintop{
        margin-top: 10px;
      }
    </style>
    <!-- BUSCADOR IMPLEMENTADO EN OTRA VISTA -->
 <section class="main-area">
<div class="container">
    <div class="card mb-3 card-style-1">
    <div class="card-header card-1-header bg-light">Busca tu escuela</div>
    <div class="card-body pb-1 pt-1">
      <div><?=$buscador;?> </div>
      <div id="contenedor_mapa_id"></div>
    </div><!-- card-body -->
  </div><!-- card -->


   <div class="card mb-1 card-style-1">
    <div class="card-header card-1-header bgcolor-2 text-white">Mapa</div>
    <div class="card-body">
      <div>


    <!-- DIV DE IMAGENES -->
    <div class="container-fluid pb-1 pt-1">
      <div class="row">
        <div class="col-12 alert alert-dark pb-0 pt-2" role="alert">
            <div class="row">
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#000000;">place</i> Especial</label>
        </div>
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#810000;">place</i> Inicial</label>
        </div>
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#0101ff;">place</i> Preescolar</label>
        </div>
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#6b8f1e;">place</i> Primaria</label>
        </div>
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#2ece2e;">place</i> Secundaria</label>
        </div>
        </div>
        <div class="row">
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#9471dc;">place</i> Media superior</label>
        </div>
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#ff8d00;">place</i> Superior</label>
        </div>
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#ff0000;">place</i> Formación para el trabajo</label>
        </div>
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#ff00ff;">place</i> Otro nivel educativo</label>
        </div>
        <div class="col-sm mb-1">
            <label class="d-inline-flex fw500"><i class="material-icons" style="color:#ffff00;">place</i> No aplica</label>
        </div>
       </div>
     </div>
      </div>
    </div>

<!-- CONTENEDOR DEL MAPA -->
<div class="row">
    <div class="col-12">
        <div class="p-3" style="height: 400px" id="map"></div>
    </div>
</div>
      </div>
    </div><!-- card-body -->
  </div><!-- card -->



  </div>
</section>

    <script src="https://jawj.github.io/OverlappingMarkerSpiderfier/bin/oms.min.js"></script>
    <script src="<?= base_url('assets/js/mapa/mapa.js') ?>"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBORp5ivGEk1dyiq2_6K5c85IbDOzuYymQ&callback=initMap" async defer>
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <!-- es la key de escuelapoblana -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBORp5ivGEk1dyiq2_6K5c85IbDOzuYymQ&callback=myMap&libraries=geometry"></script> -->
