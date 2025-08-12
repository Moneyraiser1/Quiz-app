<?php 
     if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
  ob_start();
  define('APPURL', 'http://localhost/Quiz-app');


    if ($_SESSION['role_as'] == 'user') {
        header("Location: ../index.php");
        exit();
  }
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>FLCS</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Bootstrap  & CSS -->
  <link rel="stylesheet" href="<?= APPURL?>/includes/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= APPURL?>/admin/css/custom.css">
  <link rel="stylesheet" href="<?= APPURL?>/admin/css/richtext.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
 
<script src="<?= APPURL?>/includes/js/jquery/jquery.min.js"></script>
<script src="<?= APPURL?>/includes/js/bootstrap.min.js"></script>

<script src="<?= APPURL?>/admin/includes/jquery/dist/jquery.min.js"></script>
<script src="<?= APPURL?>/admin/includes/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= APPURL?>/admin/includes/texteditor/jquery.richtext.min.js"></script>

<script src="<?= APPURL?>/admin/includes/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


  <style>
    body{
      font-family: cursive;
    }
  
  </style>

  <?php include 'navbar.php' ?>
  <?php include '../includes/alertify.php' ?>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
  $('.content').richText();

</script>