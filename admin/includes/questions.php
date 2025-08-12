<?php
    require  'questionController/Questions.php';
    $Question = new Questions();
    include 'categoryController/Category.php';
    $id = $_GET['questions'] ;
    $cat = new Category;

    if(isset($_POST['submit'])){
        $question = strip_tags(trim(stripslashes($_POST['question'])));
        $option_a = trim(htmlspecialchars(stripslashes($_POST['option_a'])));
        $option_b = trim(htmlspecialchars(stripslashes($_POST['option_b'])));
        $option_c = trim(htmlspecialchars(stripslashes($_POST['option_c'])));
        $option_d = trim(htmlspecialchars(stripslashes($_POST['option_d'])));
        $correct_option = trim(htmlspecialchars(stripslashes($_POST['correct_option'])));
        $subject = trim(htmlspecialchars(stripslashes($_POST['subject'])));
        $reg_msg = "";     
        $result = $Question->InsertPost($question, $option_a, $option_b, $option_c, $option_d, $correct_option, $subject);
    
        if($result !== true){
        $reg_msg = '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Failed!</strong>.
                    </div>';
        
        }else{
            $reg_msg = '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Success!</strong>.
                    </div>';
        
        }
    }

?>

<div class="row justify-content-center mt-2" >
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Questions DATA</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>	
                  <th>Question</th>
                  <th>Option A</th>
                  <th>Option B</th>
                  <th>Option C</th>
                  <th>Option D</th>
                  <th>Correct Option</th>
                  <th>Subject</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
<?php 
    $items = $Question->showQuestions();
    if(!empty($items)):
        $i = 0;
        foreach( $items as $item):
            $i++
?>
                <tr>
                   <!-- $question, $option_a, $option_b, $option_c, $option_d, $correct_option, $subject -->
                  <td><?= $i ?></td>
                  <td><?= $item->question ?></td>
                  <td><?= $item->option_a ?></td>
                  <td><?= $item->option_b ?></td>
                  <td><?= $item->option_c ?></td>
                  <td><?= $item->option_d ?></td>
                  <td><?= $item->correct_option ?></td>
                  <td>  
                      <a href="?removequestion= <?= $item->id; ?>"  class="btn btn-danger">Remove</a>  
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
    <?php 
        if(isset($reg_msg)){
            echo $reg_msg;
        }
        
    ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" class="form-control mt-5" method="POST" enctype="multipart/form-data">
                <h4 class="text-center mt-3">Register</h4>
                  <div class="">
                    <label for="" class="col-sm-4 col-form-label">Question:</label>
                    <div class="">
                        <textarea name="question" class="form-control content" cols="40" rows="10"></textarea>
                    </div>
                </div>
                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Question_A:</label>
                    <div class="">
                        <input type="text" class="form-control" id=""  placeholder="option A" name="option_a">
                    </div>
                </div>
                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Question_B:</label>
                    <div class="">
                        <input type="text" class="form-control" id=""  placeholder="option B" name="option_b">
                    </div>
                </div>
                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Question_C:</label>
                    <div class="">
                        <input type="text" class="form-control" id=""  placeholder="option c" name="option_c">
                    </div>
                </div>
                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Question_D:</label>
                    <div class="">
                        <input type="text" class="form-control" id=""  placeholder="option D" name="option_d">
                    </div>
                </div>
                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Correct Option:</label>
                    <div class="">
                        <input type="text" class="form-control" id=""  placeholder="Correct Option" name="correct_option">
                    </div>
                </div>
                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Category:</label>
                    <div class="">
                         <select name="subject" id="" class="form-control">
                            <option class="disable selected" value="">Select a category</option>
                        <?php 
                               $items = $cat->showCat();
                                if(!empty($items)):

                                    foreach( $items as $item):
                        ?>
                       
                            <option class="form-control" value="<?= $item->category ?>"><?= $item->category ?></option>
                    
                        <?php endforeach; ?>
                            </select>
   <?php endif; ?>
                    </div>
                </div>
                <div>
              
              

                <button type="submit" name="submit" class="w-100 btn btn-lg btn-primary mt-4 mb-4 ">Insert</button>
                
            </form>
        </div>
    </div>
</div>
</div>

