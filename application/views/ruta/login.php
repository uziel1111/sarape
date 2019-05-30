<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SARAPE - Login</title>
    <link href="http://fonts.googleapis.com/css?family=Boogaloo" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Fira+Sans+Condensed:400,400i,500,500i,800,800i" rel="stylesheet">
	<link href="<?= base_url('assets/bootstrap-411/css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen">
	<link href="<?= base_url('assets/css/login.css'); ?>" rel="stylesheet" media="screen">
</head>
<body>
    <div class="container-login" style="background-image: url('<?= base_url('assets/img/bg-01.jpg');?>');">
      <div class="wrap-login">
          <div class="login-form validate-form">
              <div class="card">
            <div class="card-body">
              <center>
                <img class="img-fluid" src="<?= base_url('assets/img/logo.png'); ?>" alt="">
                <h5 class="card-title mt-3">Planeación Estratégica</h5>
                <h4 class="card-title mt-3">Iniciar Sesión</h4>
              </center>
              <center class="mensaje-terminado"><?=$this->session->flashdata(MESSAGEREQUEST);?></center>
              <?= form_open('Rutademejora/acceso');?>
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
                                <option value="5">Mixto</option>
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
    </div><!-- /container -->
    <script src="<?= base_url('assets/jquery-3.3.1.min.js'); ?>"></script>
  	<script src="<?= base_url('assets/bootstrap-411/js/bootstrap.min.js'); ?>"></script>

  </body>
  </html>
