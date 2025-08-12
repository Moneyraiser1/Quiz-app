<?php
    include_once '../Controller/Users.php';
    $users = new Users();

    if(isset($_POST['submit'])){
        
        $username = trim(htmlspecialchars(stripslashes($_POST['username'])));
        $fname = trim(htmlspecialchars(stripslashes($_POST['fname'])));
        $lname = trim(htmlspecialchars(stripslashes($_POST['lname'])));
        $userPassword = trim(htmlspecialchars(stripslashes($_POST['password'])));
        $phone = trim(htmlspecialchars(stripslashes($_POST['phone'])));
        $rPass = trim(htmlspecialchars(stripslashes($_POST['rpassword'])));
        $reg_msg = "";

            $result = $users->Register($username, $fname, $lname, $userPassword, $phone, $rPass);
            if($result !== true){
                
            }else{
                    $_SESSION['msg'] = "Registration successful please login";
                    $_SESSION['msg_type'] = "success";
            
            }
        }
  if(isset($_SESSION['username'])): 
        header('index.php?home');
    endif;
?>

<?php require '../includes/header.php'; ?>

<div class="container">
    <?php 
        if(isset($reg_msg)){
            echo $reg_msg;
        }
    ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="POST" class="form-control mt-5">

    <h4 class="text-center mt-3">Register</h4>

    <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" autocomplete="username" required>
    </div>

    <div class="mb-3">
        <label for="fname" class="form-label">First name:</label>
        <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First name" autocomplete="given-name" required>
    </div>

    <div class="mb-3">
        <label for="lname" class="form-label">Last name:</label>
        <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last name" autocomplete="family-name" required>
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Phone number:</label>
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone number" autocomplete="tel" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="*******" autocomplete="new-password" required>
    </div>

    <div class="mb-3">
        <label for="rpassword" class="form-label">Repeat Password:</label>
        <input type="password" class="form-control" id="rpassword" name="rpassword" placeholder="*******" autocomplete="new-password" required>
    </div>

    <button type="submit" name="submit" style="background-color: orange;" class="w-100 btn btn-lg mt-4 mb-4">Register</button>

    <p class="mt-2 p-2 text-center">Have an account? <a class="text-decoration-none" href="login">Login</a></p>
</form>

        </div>
    </div>
</div>
</div>

