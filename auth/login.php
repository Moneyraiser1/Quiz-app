<?php
     if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    ob_start();
    define('APPURL', 'http://localhost/Quiz-app/');

    include_once '../Controller/Users.php';
    $users = new Users();

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $userPassword = $_POST['userpassword'];
        $log_msg = "";
        $result = $users->Login($username, $userPassword);
        if(!$users->Login($username, $userPassword)){
              
        }
    }
    if(isset($_SESSION['username'])): 
        header('index.php?home');
    endif;

?>


<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>FLCS</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Bootstrap  & CSS -->
  <link rel="stylesheet" href="<?= APPURL?>/includes/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= APPURL?>/includes/css/custom.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
 
    <script src="<?= APPURL?>/includes/js/jquery/jquery.min.js"></script>
  <script src="<?= APPURL?>/includes/js/bootstrap.min.js"></script>

  <script src="<?= APPURL?>/includes/js/alertify.min.js"></script>
  <link rel="stylesheet" href="<?= APPURL?>/includes/css/alertify.min.css"/>
  <link rel="stylesheet" href="<?= APPURL?>/includes/css/default.min.css"/>




  <?php include '../includes/navbar.php' ?>
  <?php include '../includes/alertify.php' ?>



<div class="container">
    <?php 
        if(isset($log_msg)){
            echo $log_msg;
        }
    ?>
    <div class="row mt-5 p-2 justify-content-center">
        <div class="col-md-6">
            <div class="card">
                
                    <h3 class="  text-mute text-dark text-center mt-3">Login Here</h3>
                
                <div class="card-body">
                    <form action="" method="post">
                        <div class="input-group p-3">
                           <div class="icons bg-warning">
                                <i class="fa fa-user text-light p-3" ></i>
                           </div> 

                            <input type="text" class="form-control p-2" placeholder="Username" name="username">
                        </div>
                        <div class="input-group p-3">

                        <div class="icons bg-warning">
                                <i class="fa fa-lock text-light p-3" ></i>
                           </div> 

                            <input type="password" class="form-control p-2" placeholder="password" name="userpassword">
                        </div>

                        <button type="submit" name="submit" class="w-100 btn btn-lg btn-warning mt-4 mb-4 ">Login</button>
                    </form>
                    <p class="mt-2 p-2 text-center">Don't have an account? <a class="text-decoration-none" href="register">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

