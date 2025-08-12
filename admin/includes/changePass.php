<?php 
include __DIR__ . '/../../Controller/Users.php';
$user = new Users();
    if(isset($_POST['update'])){
    $id = $_SESSION['id'];
    $username = trim(htmlspecialchars(stripslashes($_POST['username'])));
    $fname = trim(htmlspecialchars(stripslashes($_POST['fname'])));
    $lname = trim(htmlspecialchars(stripslashes($_POST['lname'])));
    $phone = trim(htmlspecialchars(stripslashes($_POST['phone'])));
    $oldPass = trim(htmlspecialchars(stripslashes($_POST['oldpass'])));
    $newPass = trim(htmlspecialchars(stripslashes($_POST['newpass'])));
    $rPass = trim(htmlspecialchars(stripslashes($_POST['rPass'])));
    $result = $user->changePassword($id, $fname, $lname, $username, $phone, $oldPass, $newPass, $rPass);
    $change_msg = '';
        if ($result === "Password changed successfully!") {
    $change_msg = '<div class="alert alert-success alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert">X</button>
        <strong>Success!</strong> ' . $result . '
    </div>';
    header('Location: adminDashboard.php');
} else {
    $change_msg = '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert">X</button>
        <strong>Failed!</strong> ' . $result . '
    </div>';
}

    }
?>

<div class="col-md-8">
<div class="card">
    <?= isset($change_msg) ? $change_msg : ''; ?>
    <div class="card-header">
        <h1>Edit info</h1>
    </div>
<div class="card-body">
            <div class="form-group">
                <form action="" method="post">
                 
                        <div class="form-group">
                            <input type="text" placeholder="First name" class="form-control" name="fname">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Last name" class="form-control" name="lname">
                        </div>
                        <div class="form-group">
                            <input type="number" placeholder="Phone number" class="form-control" name="phone">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Username" class="form-control" name="username">
                        </div>
                       <input type="password" placeholder="Old password" class="form-control" name="oldpass">
                        <input type="password" placeholder="New Password" class="form-control" name="newpass">
                        <input type="password" placeholder="Repeat Password" class="form-control" name="rPass">

                    </div>

                    
                       
         
                    <button type="submit" class=" ms-5 btn btn-primary" name="update">Update Password</button>   
                </form>
            </div>
        </div>
</div>
