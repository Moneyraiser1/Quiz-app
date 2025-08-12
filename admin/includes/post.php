<?php
    require 'postController/Post.php';
    require 'commentController/Comment.php';
    $post = new POST();
    $comment = new Comment;
    require 'categoryController/Category.php';
    $id = $_GET['post'] ;
    $data = $comment->countComment($id);


$cat = new Category;

    if(isset($_POST['submit'])){
        $post_title = trim(htmlspecialchars(stripslashes($_POST['post_title'])));
        $post_text = strip_tags(trim($_POST['post_text']), '<p><div><strong><em><br>');

        $file = $_FILES['cover'];
        $category = trim(htmlspecialchars(stripslashes($_POST['category'])));
        $reg_msg = "";

     
            $result = $post->InsertPost($post_title, $post_text, $file, $category);
            if($result !== true){
                //  echo "Error! Credentials Failed";
                $reg_msg = '<div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert">X</button>
                            <strong>Failed!</strong> '.$result.'.
                            </div>';
            }else{
            $reg_msg = '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Success!</strong>Posted Successfully.
                        </div>';
            
            }
        }

?>

<div class="row justify-content-center mt-2" >
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">POST DATA</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>	

                  <th>post_title</th>
                  <th>post_text</th>
                  <th>category</th>
                  <th>Comments</th>
                  <th>Likes</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
<?php 
$items = $post->showPOST();
if (!empty($items)):
    foreach ($items as $item):
        $commentCount = $comment->countComment($item->post_id);
        $LikeCount = $comment->countLikes($item->post_id);  // call here
?>
<tr>
    <td><a class="text-decoration-none text-dark" href="?single=<?= $item->post_id; ?>"><?= $item->post_text ?></a></td>
    <td><?= $item->post_title ?></td>
    <td><?= $item->category ?></td>
    <td><?= $commentCount->num_comments ?></td>
    <td><?= $LikeCount->num_likes ?></td>
    <td><?= $item->created_at ?> </td>
    <td>
        <a href="?removePost=<?= $item->post_id; ?>" class="btn btn-danger">Remove</a>
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
        if(isset($_GET['removePost'])){
            
        }
    ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" class="form-control mt-5" method="POST" enctype="multipart/form-data">
                <h4 class="text-center mt-3">Register</h4>
                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Post Title:</label>
                    <div class="">
                        <input type="text" class="form-control" id=""  placeholder="Post Title" name="post_title">
                    </div>
                </div>
                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Category:</label>
                    <div class="">
                        <?php 
                               $items = $cat->showCat();
                                if(!empty($items)):

                                    foreach( $items as $item):
                        ?>
                        <select name="category" id="" class="form-control">
                            <option class="disable selected" value="">Select a category</option>
                            <option class="form-control" value="<?= $item->category ?>"><?= $item->category ?></option>
                        </select>
                        <?php
     endforeach; 
    endif;  
?>
                    </div>
                </div>
                <div>
                <label for="" class="col-sm-4 col-form-label">Cover Image:</label>
                <input type="file" name="cover" class="form-control" >
                </div>
                <div class="">
                    <label for="" class="col-sm-4 col-form-label">Post Text:</label>
                    <div class="">
                        <textarea name="post_text" class="form-control content" cols="40" rows="10"></textarea>
                    </div>
                </div>

                <button type="submit" name="submit" class="w-100 btn btn-lg btn-primary mt-4 mb-4 ">Insert</button>
                
            </form>
        </div>
    </div>
</div>
</div>

