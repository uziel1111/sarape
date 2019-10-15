  <link rel="stylesheet" href="<?= base_url('assets/css/jquery-gantt.css'); ?>">
  <div id="demo"></div>
  <br>
  <script src="<?= base_url('assets/js/jquery-gantt.js') ?>"></script>
  <script>
$(function() {
  //////////////////
  // Los tooltips //
  /////////////////
  $('[data-toggle="tooltip"]').tooltip();

  $('[data-toggle="popover"]').popover({
    html: true,
    container: 'body',
    trigger:'hover'
  });

});
</script>

