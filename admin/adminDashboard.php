<?php
 include 'includes/header.php';
 
 if(empty($_SERVER['QUERY_STRING'])){
    header('location: adminDashboard?users');
    exit();
}
 ?>

<body>
  <div class="container-fluid">
  <div class="row">
    <div class="col-md-2 bg-dark">
      <?php require 'includes/sidebar.php'; ?>
    </div>

 <div class="col-md-10">
  
  <div class="main-content">
 <?php    if(isset($_GET['users'])){
                require 'includes/users.php';
            }elseif(isset($_GET['category'])){
                require 'includes/category.php';
            }
            elseif(isset($_GET['remove'])){
                require 'includes/remove.php';
            }
            elseif(isset($_GET['questions'])){
                require 'includes/questions.php';
            }
            elseif(isset($_GET['editCat'])){
                require 'includes/editCat.php';
            }
            elseif(isset($_GET['removeCat'])){
                require 'includes/removeCat.php';
            }
            elseif(isset($_GET['removequestion'])){
                require 'includes/removeQuestion.php';
            }
            elseif(isset($_GET['changePass'])){
                require 'includes/changePass.php';
            }
            elseif(isset($_GET['subject_id'])){
                require 'includes/leaderboard.php';
            }
            
            elseif(isset($_GET['leaderboard'])){
                require 'includes/leaderboard.php';
            }
            
           
    ?>
  </div>
    </div>
  </div>
 </div>


</body>
</html>
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
  $('.content').richText({
      imageUpload:false,
  fileUpload:false,
  // media
  Embed:false,
 
  // link
  urls:false
  // tables
  });


</script>