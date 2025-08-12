<?php 
require 'categoryController/Category.php'; 
$cat = new Category;
if(isset($_POST['submit'])){

   $category = $_POST['category'];
   $result = $cat->InsertCat($category);
   $reg_msg = "";
   if($result !== true){
       $_SESSION['msg'] = "Inserted successfully.";
          $_SESSION['msg_type'] = "success";
   }else{
         $_SESSION['msg'] = "Failed.";
          $_SESSION['msg_type'] = "error";
   }
}

?>
<div class="row justify-content-center mt-2" >
    <div class="box">
        <?php 
             if(isset($reg_msg)){
                echo $reg_msg;
            }
        ?>
            <div class="box-header">
              <h3 class="box-title">Category Data</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>	

                  <th>id</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
<?php 
    $items = $cat->showCat();
    if(!empty($items)):
        $i = 0;
        foreach( $items as $item):
            $i++
?>
                <tr>
                  
                  <td><?= $i ?></td>
                  <td><?= $item->category ?></td>
                  <td> 
                      <a href="?editCat= <?= $item->id; ?>"  class="btn btn-primary">Edit</a>  
                      <a href="?removeCat= <?= $item->id; ?>"  class="btn btn-danger">Remove</a>  
                    </td>
                </tr>
<?php
     endforeach; 
    endif;  
?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" class="form-control mt-5" method="POST" enctype="multipart/form-data">
                <h4 class="text-center mt-3">Add catgory</h4>

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