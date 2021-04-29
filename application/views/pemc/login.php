<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SARAPE - Login</title>
  <link href="https://fonts.googleapis.com/css?family=Boogaloo" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed:400,400i,500,500i,800,800i" rel="stylesheet">
  <link href="<?= base_url('assets/bootstrap-411/css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen">
  <link href="<?= base_url('assets/css/login.css'); ?>" rel="stylesheet" media="screen">
  <link href="<?= base_url('assets/fonts/fontawesome5/css/all.css') ?>" rel="stylesheet" media="screen">
  <link href="https://fonts.googleapis.com/css?family=Boogaloo" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed:400,400i,500,500i,800,800i" rel="stylesheet">
</head>
<body>
  <style>
      .vt {
    /* cambia estos dos valores para definir el tamaño de tu círculo */
    height: 200px;
    width: 200px !important;
    /* los siguientes valores son independientes del tamaño del círculo */
    background-repeat: no-repeat;
    background-position: 50%;
    border-radius: 50%;
    background-size: 100% auto;
  }
  .li {
    position: relative;
    display: inline-block;
    width: 23%;
    margin: 1%;
    text-align: left;
    font-size: 12px;
  }

  li .link i {
    z-index: 4;
    opacity: 0;
    position: absolute;
    left: 210%;
    bottom: 0%;
    margin: 0px 0px -24px -24px;
    width: 48px !important;
    height: 48px;
    background: url(https://i.imgur.com/FZaEYsL.png) no-repeat center center;
    border-radius: 50%;
    box-shadow: 0px 0px 40px rgba(0, 0, 0, 1);
    transition: all 0.20s ease-out;
  }

  li .link img {

    transition: all 0.20s ease-out;
    margin-top: -2%;
    margin-bottom: -15%;
  }

  li:hover .link i {
    opacity: .8;
    bottom: 50%;
  }

  li:hover .link img {
    transform: rotate(0deg) xscale(1.03);
  }

  /** Float btn **/
.float-btn {
  font-family: 'Fira Sans Condensed', sans-serif !important;
  font-size: 16px;
margin: 0px 0px 0px -47px;;
  border-radius: 10px 10px 0 0px;
-moz-border-radius: 10px 10px 0 0px;
-webkit-border-radius: 10px 10px 0 0px;
border: 0px solid #000000;
-webkit-box-shadow: 3px 3px 12px -4px rgba(0,0,0,0.75);
-moz-box-shadow: 3px 3px 12px -4px rgba(0,0,0,0.75);
box-shadow: 3px 3px 12px -4px rgba(0,0,0,0.75);
background-color: rgba(0,0,0,0.5);

-webkit-transform: rotate(90deg);
     -moz-transform: rotate(90deg);
     -ms-transform: rotate(90deg);
     -o-transform: rotate(90deg);
     filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
     position: absolute;
     color: #FFF;

     font-weight: bold;

     transition: all 0.5s ease;
}
.float-btn:hover {
color: #fff;
background-color: rgba(0,0,0,1.0);

}
  /** end Float btn **/

  </style>
  <div class="container-login" style="background-image: url('<?= base_url('assets/img/bg-01.jpg');?>');">
    <div class="row">
     <div class="col-md-12">
        <div class="wrap-login">
         <div class="login-form validate-form">
           <div class="card">
             <div class="card-body">
               <center>
                 <img class="img-fluid" src="<?= base_url('assets/img/logo.png'); ?>" alt="">
                 <h5 class="card-title mt-3">Programa Escolar de Mejora Continua (PEMC)</h5>
                 <h4 class="card-title mt-3">Iniciar Sesión</h4>
                 <h6>Utilice el usuario y contraseña proporcionados para utilizar SIECEC</h6>
               </center>
               <center class="mensaje-terminado"><?=$this->session->flashdata(MESSAGEREQUEST);?></center>
               <?= form_open('Pemc/acceso');?>
               <div class="form-group">
                 <label for="usuario">CCT</label>               <input type="text" name="usuario" value="" id="usuario" class="form-control" required="required" autofocus="autofocus">
               </div>
               <div class="form-group">
                 <label for="password">Turno</label>
                 <select class="form-control" name="turno_id">
                   <option value="0">Seleccionar turno</option>
                   <option value="1">Matutino</option>
                   <option value="2">Vespertino</option>
                   <option value="3">Nocturno</option>
                   <option value="4">Discontinuo</option>
                   <option value="5">Continuo</option>
									 <!-- <option value="6">Complementario</option> -->
                 </select>
               </div>
               <div class="form-group">
                 <label for="password">Contraseña</label><input type="password" name="password" value="" id="password" class="form-control">

               </div>
               <div class="text-center">
                 <button type="submit" class="btn btn-primary btn-login center">Iniciar Sesión</button>
               </div></form>
             </div>
           </div>

         </div>
       </div>
     </div>
    </div>

    <div class="row">
    <div class="col">
    <!-- <a class="btn float-btn" href="#" role="button" data-toggle="modal" data-target="#T1_SARAPE_"><i class="far fa-play-circle"></i> Iniciar Sesión</a> -->
    </div>

    </div>
  </div><!-- /container -->
  <div class="modal fade bd-example-modal-lg" id="T1_SARAPE" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="height: 1200px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Tutorial 1</h4>
          <button type="button" class="close" id='cerrar' data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12" id="VTL1">
              <iframe width="100%" height="415" src="https://www.youtube.com/embed/S5HT3mqxs3w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= base_url('assets/jquery-3.3.1.min.js'); ?>"></script>
  <script src="<?= base_url('assets/bootstrap-411/js/bootstrap.min.js'); ?>"></script>
  <script>
    $('#cerrar').click(function(event) {
      $('#VTL1').empty();
      $('#VTL1').html('<iframe width="100%" height="415" src="https://www.youtube.com/embed/S5HT3mqxs3w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
    });
  </script>

</body>
</html>
