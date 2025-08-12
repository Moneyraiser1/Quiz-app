<?php
include 'categoryController/Category.php';
    $users = new Category();

    if(isset($_GET['editCat'])){
        if(isset($_POST['submit'])){

            $id = $_GET['editCat'];
            $category = $_POST['category'];
            
            $err_msg = "";
            $data = $users->editCat($id, $category);
            if($data === true){
               $_SESSION['msg'] = "Successful.";
          $_SESSION['msg_type'] = "success";
                header('Location: adminDashboard.php?category');
            }
        }
    }
    ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" class="form-control mt-5" method="POST" enctype="multipart/form-data">
                <h4 class="text-center mt-3">Edit catgory</h4>

                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Category:</label>
                    <div class="">
                        <input type="text" class="form-control" id=""  placeholder="Category" name="category">
                    </div>
                </div>
                <div class="">
                <button type="submit" name="submit" class="w-100 btn btn-lg btn-primary mt-4 mb-4 ">Insert</button>
                
            </form>
        </div>
    </div>
</div>