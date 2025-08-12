<?php 
include 'includes/header.php';
 if(empty($_SERVER['QUERY_STRING'])){
    header('location: index?home');
    exit();
}

?>
 <?php if(isset($_GET['home'])){ 
    require 'includes/home.php';
 }elseif(isset($_GET['quiz'])){ 
    require 'includes/quiz.php';
 }  ?>
</body>
</html>
