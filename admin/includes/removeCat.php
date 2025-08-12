<?php
    include 'categoryController/Category.php';
    $users = new Category();

    if(isset($_GET['removeCat'])){
    $id = $_GET['removeCat'];
       
    $err_msg = "";
    $data = $users->removeCat($id);
    if($data === true){
        $err_msg = '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert">X</button>
                          <strong>Success!</strong>Deleted Successfully.
                        </div>';
        header('Location: adminDashboard.php?category');
    }
 }
