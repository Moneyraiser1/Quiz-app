<?php
include '../Controller/Users.php';
    $users = new Users();

    if(isset($_GET['remove'])){
    $id = $_GET['remove'];
       
    $err_msg = "";
    $data = $users->remove($id);
    if($data === true){
        $_SESSION['msg'] = "Deleted successfully.";
          $_SESSION['msg_type'] = "success";
        header('Location: adminDashboard.php?users');
    }
    }
