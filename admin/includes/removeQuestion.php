<?php
    include 'questionController/Questions.php';
    $users = new Questions();

    if(isset($_GET['removequestion'])){
    $id = $_GET['removequestion'];
       
    $err_msg = "";
    $data = $users->removequestion($id);
    if($data === true){
        $err_msg = '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert">X</button>
                          <strong>Success!</strong>Deleted Successfully.
                        </div>';
        header('Location: adminDashboard.php?category');
    }
 }
