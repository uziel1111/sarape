<!DOCTYPE html>
<html lang="es" class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Favicon-->
  <link rel="icon" type="image/png" href="https://coahuila.gob.mx/images/favicon-electoral.png">
  <!-- Meta Description -->
  <meta name="description" content="">
  <!-- Meta Keyword -->
  <meta name="keywords" content="">
  <!-- meta character set -->
  <meta charset="UTF-8">
  <!-- Site Title -->
    <title>SARAPE</title>
    <!-- Site Title -->
    <link href="https://fonts.googleapis.com/css?family=Boogaloo" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed:400,400i,500,500i,800,800i" rel="stylesheet">
  <!-- CSS -->
    <link href="<?= base_url('assets/css/main.css'); ?>" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="<?= base_url('assets/css/linearicons.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/multiselect/css/bootstrap-select.min.css') ?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link href="<?= base_url('assets/bootstrap-411/css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen">

  <link href="<?= base_url('assets/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" media="screen">

  <link href="<?= base_url('assets/fonts/fontawesome5/css/all.css') ?>" rel="stylesheet" media="screen">
  <link href="<?= base_url('assets/css/loader.css') ?>" rel="stylesheet" media="screen">
  <link href="<?= base_url('assets/css/src_up.css') ?>" rel="stylesheet" media="screen">




    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">

  <script src="<?= base_url('assets/jquery-3.3.1.min.js'); ?>"></script>
  <script src="<?= base_url('assets/jquery.validate.js'); ?>"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="<?= base_url('assets/bootstrap-411/js/bootstrap.min.js'); ?>"></script>
  <script src="<?= base_url('assets/sweetalert2/sweetalert2.min.js'); ?>"></script>

  <script src="<?= base_url('assets/js/messages.js') ?>"></script>
  <script src="<?= base_url('assets/js/Utiles.js') ?>"></script>
  <script src="<?= base_url('assets/js/loader.js') ?>"></script>
  <script src="https://www.gstatic.com/charts/loader.js"></script>

<script src="<?= base_url('assets/js/src_up.js') ?>"></script>
  <script>
    $(function() {
      base_url = live_url = "<?= base_url(); ?>";
      base_url = base_url + "index.php/";
    });
  </script>
</head>
    <body>
        <div id="top"></div>
        <!-- Start Header Area -->
        <header>
            <div class="sticky-header" style="background-color: #000000!important;">
                <div class="container">
                    <div class="header-content d-flex justify-content-between align-items-center">
                        <div class="logo">
                          <a href="<?= base_url() ?>" class="smooth"><img class="img-fluid" src="<?= base_url('assets/img/logo.png'); ?>" alt=""></a>

                        </div>
                        <div class="right-bar d-flex align-items-center">
                        </div>
                        <div class="float-right text-right text-white">
    <i class="fas fa-caret-right color-1"></i>&nbsp;<b>CENTRAL</b><br>
  <a class="btn btn-secondary btn-sm mt-2" href="<?= site_url("estadistica_pemc/cerrar_sesion")?>">Cerrar Sesión</a>
</div>
                    </div>
                </div>
            </div>
        </header>
        <!-- End Header Area -->

<!-- Modal -->
<div class="modal fade" id="idmodalloader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
  <center><div class="loader"></div></center>
  </div>
</div>

<script src="<?= base_url('assets/js/index/index.js') ?>"></script>
<script src="<?= base_url('assets/multiselect/js/bootstrap-select.js'); ?>"></script>
