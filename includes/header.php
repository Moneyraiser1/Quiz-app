<?php 
     if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
  ob_start();
  define('APPURL', 'http://localhost/Quiz-app');

   if(isset($_SESSION['id'])){
    if ($_SESSION['role_as'] == 'admin') {
          $_SESSION['msg'] = "Admin not allowed";
          $_SESSION['msg_type'] = "error";
          header("Location: admin/adminDashboard.php?home");
          exit();
    }
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
  <link rel="stylesheet" href="<?= APPURL?>/includes/css/alertify.min.css"/>
<link rel="stylesheet" href="<?= APPURL?>/includes/css/default.min.css"/>
<link rel="stylesheet" href="includes/css/bootstrap.min.css">
<link rel="stylesheet" href="includes/css/custom.css">

 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
 
<script src="<?= APPURL?>/includes/js/jquery/jquery.min.js"></script>
<script src="<?= APPURL?>/includes/js/bootstrap.min.js"></script>

<script src="<?= APPURL?>/includes/js/alertify.min.js"></script>

  <?php include 'navbar.php' ?>
  <?php include 'alertify.php' ?>

