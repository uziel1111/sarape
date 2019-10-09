<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SARAPE - Bienvenido</title>
	<link href="<?= base_url('assets/bootstrap-411/css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css">
	<script src="<?= base_url('assets/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?= base_url('assets/bootstrap-411/js/bootstrap.min.js'); ?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.2/dist/sweetalert2.all.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Boogaloo" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed:400,400i,500,500i,800,800i" rel="stylesheet">   
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
    <link href="<?= base_url('assets/fonts/fontawesome5/css/all.css') ?>" rel="stylesheet" media="screen">
    <script src="<?= base_url('assets/js/messages.js'); ?>"></script>
	<script>
    $(function() {
      base_url = live_url = "<?= base_url(); ?>";
      base_url = base_url + "index.php/";
    });
  </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a href="<?= base_url() ?>" class="smooth"><img class="img-fluid" src="<?= base_url('assets/img/logo-dark.png'); ?>" alt=""></a>
<div class="float-right text-right text-white">
    <i class="fas fa-user color-2"></i>&nbsp; <?=$nombreuser?>
  &nbsp;<i class="fas fa-caret-right color-3"></i>&nbsp;<?=$nivel?><br>
  <a class="btn btn-secondary btn-sm mt-2" href="<?= site_url("login/cerrar_sesion")?>">Cerrar Sesión</a>
</div>
  </div>
</nav>