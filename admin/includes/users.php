<div class="row justify-content-center mt-2" >
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">USERS DATA</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Username</th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Phone number</th>
                  <th>Joined on</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
<?php 
    require '../Controller/Users.php';
    $users = new Users();
    $items = $users->showUsers();
    if(!empty($items)):

        foreach( $items as $item):
            // if($item->Class == ['JSS1, JSS2, JSS3, SSS1, SSS2, SSS3'])
?>
                <tr>
                  <td><?= $item->username ?></td>
                  <td><?= $item->fname ?></td>
                  <td><?= $item->lname ?> </td>
                  <td> <?= $item->phone ?> </td>
                  <td> <?= $item->created_at ?> </td>
                  <td> 
            
                      <a href="adminDashboard.php?remove= <?= $item->id; ?>"  class="btn btn-danger">Remove</a>  
                    
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