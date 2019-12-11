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
          <?=$buscador;?>
      <div class="container">
         <div class="card mb-3 card-style-1 mt-3">
            <div class="card-header card-1-header bgcolor-2 text-white">Resultados de búsqueda</div>
                <div class="card-body">
      <div id="dv_graf_riesgo_mun_zona" class="table-responsive"></div>
      <div class="table-responsive" id="dv_tabla_riesgo_mun_zona"></div>
      <div id="dv_tab_riesgo_mun_zona" class="table-responsive"></div>
      <div class="table-responsive" id="dv_tablam_riesgo_mun_zona"></div>
            </div><!-- card-body -->
        </div>


    </div>
 </section>
