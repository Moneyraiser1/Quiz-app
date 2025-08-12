<?php
       if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once "../Model/Database.php";
    require_once "../Abstract/UserInterface.php";


    class Users implements UserInterface{
        private $username;
        private $lname;
        private $role;
        private $fname;
        private $userPassword;
        private $phone;
        private $db;

        public function __construct(){
            $this->db =  new Database();
        }
        private function validateName($name) {
    return preg_match('/^[a-zA-Z]+$/', $name);
}

        public function Login($username, $userPassword) {
            if (empty($username) || empty($userPassword)) {
                $_SESSION['msg'] = "All fields required";
                $_SESSION['msg_type'] = "error";
                return false;
            }
            
            $this->db->query('SELECT * FROM users WHERE username = :uem');
            $this->db->bind(':uem', $username);
            $row = $this->db->singleRecord();

            if (is_array($row)) {
                $dbpwd = $row['password'];

                if (password_verify($userPassword, $dbpwd)) {
                   
                    // Redirect based on role
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['fname'] = $row['fname'];
                    $_SESSION['role_as'] = $row['role'];


                    // Redirect based on role
                    if ($row['role'] == "admin") {
                        header('Location: ../admin/adminDashboard');
                        exit();
                    } elseif ($row['role'] == "student") {
                        header('Location: ../index?home');
                        exit();
                    }
             else {
                        return 'Unknown user role';
                    }
                }
            }
           

            $_SESSION['msg'] = "Passsword or username wrong";
            $_SESSION['msg_type'] = "error";
                return false;// No match or password error
        }

private function validatePassword($password) {
    if (strlen($password) < 6) return false;
    if (!preg_match('/[A-Z]/', $password)) return false;
    if (!preg_match('/[a-z]/', $password)) return false;
    if (!preg_match('/[0-9]/', $password)) return false;
    return true;
}

        
        public function Register($username, $fname, $lname, $userPassword, $phone, $rPass) {
    $this->username = trim($username);
    $this->fname = trim($fname);
    $this->lname = trim($lname);
    $this->userPassword = $userPassword;
    $this->phone = trim($phone);

   if (empty($this->fname) || empty($this->lname) || empty($this->username) || empty($this->userPassword) || empty($this->phone) || empty(trim($rPass))) {
    var_dump($this->fname, $this->lname, $this->username, $this->userPassword, $this->phone, $rPass); // Debug
    $_SESSION['msg'] = "All fields are required!";
    $_SESSION['msg_type'] = "error";
    return false;
}


    // Password match
    if ($this->userPassword !== $rPass) {
         $_SESSION['msg'] = "Passwords dont match";
          $_SESSION['msg_type'] = "error";
          return false;
    }

    // Password strength validation
    if (!$this->validatePassword($this->userPassword)) {
          $_SESSION['msg'] = "Password must be at least 6 characters, contain at least one uppercase letter, one lowercase letter, and one number.";
          $_SESSION['msg_type'] = "error";
          return false;
    }

    // Name validation
    if (!$this->validateName($fname) || !$this->validateName($lname)) {
           $_SESSION['msg'] = "First and Last names should only contain letters.";
          $_SESSION['msg_type'] = "error";
        return false;
    }

    // Phone number validation (11 digits)
    if (!preg_match('/^\d{11}$/', $this->phone)) {
         $_SESSION['msg'] = "Phone number must be exactly 11 digits.";
          $_SESSION['msg_type'] = "error";
return false;
    }

    // Check if user already exists
    $this->db->query("SELECT * FROM users WHERE phone = :ph");
    $this->db->bind(':ph', $this->phone);
    $row = $this->db->singleRecord();

    if ($row) {
         $_SESSION['msg'] = "User already exists in records.";
          $_SESSION['msg_type'] = "error";
return false;
    }

    // All good, hash password and insert
    $this->userPassword = password_hash($this->userPassword, PASSWORD_DEFAULT);

    $this->db->query('INSERT INTO users(fname, lname, username, password, phone) VALUES(:fname, :lname, :username, :password, :phone)');
    $this->db->bind(':fname', $this->fname);
    $this->db->bind(':lname', $this->lname);
    $this->db->bind(':username', $this->username);
    $this->db->bind(':password', $this->userPassword);
    $this->db->bind(':phone', $this->phone);

    if ($this->db->execute()) {
        return true;
    }

    return "Registration failed. Try again later.";
}

        public function Logout(){
            $_SESSION['msg'] = "Logged out successfully.";
          $_SESSION['msg_type'] = "success";
            unset($_SESSION['username']);
            unset($_SESSION['id']);
            unset($_SESSION['phone']);
            unset($_SESSION['fname']);
            unset($_SESSION['role_as']) ;
        }

          public function showUsers(){
            $this->db->query('SELECT * FROM users WHERE role = "student" ORDER BY created_at DESC ');
            $rows = $this->db->resultSetObj();

            if(count($rows) > 0){
                return $rows;
            }else{
                return false;
            }

        }
           public function remove($id){
            //$this->role = $role;
            $this->db->query('DELETE FROM users WHERE id=:uid');
            $this->db->bind(':uid', $id);
            
            if($this->db->execute()){
                header('Location: adminDashboard.php?users');
                return 'User removed successfully';
            }else{
                return false;
            }
        }
       public function changePassword($id, $fname, $lname, $username, $phone, $oldPass, $newPass, $rPass) {
        // Fetch user by ID instead of username
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->singleRecord();

        if (!$row) {
            return "User not found!";
        }
        if ($newPass !== $rPass) {
            return 'Passwords do not match';
        }

    // Password strength validation
    if (!$this->validatePassword($newPass)) {
          return "Password must be at least 6 characters, contain at least one uppercase letter, one lowercase letter, and one number.";

    }

    // Name validation
    if (!$this->validateName($fname) || !$this->validateName($lname)) {
           return "First and Last names should only contain letters.";
    }

    // // Phone number validation (11 digits)
    // if (!preg_match('/^\d{10}$/', $this->phone)) {
    //      return "Phone number must be exactly 11 digits.";

    // }

    $dbpwd = $row['password'];

    if (!password_verify($oldPass, $dbpwd)) {
        return "Old password is incorrect!";
    }

    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);

    $this->db->query("UPDATE users SET fname=:fn, lname=:ln, username=:un, phone=:ph, password=:newpass WHERE id=:id");
    $this->db->bind(':fn', $fname);
    $this->db->bind(':ln', $lname);
    $this->db->bind(':un', $username);
    $this->db->bind(':ph', $phone);
    $this->db->bind(':newpass', $hashedPass);
    $this->db->bind(':id', $id);

    if ($this->db->execute()) {
        // Re-fetch updated user and reset session
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->singleRecord();
        $_SESSION['username'] = $row['username'];
        $_SESSION['id'] = $row['id'];
        return "Password changed successfully!";
    } else {
        return "Failed to update password.";
    }
}

        public function showAdmin(){
            $this->db->query('SELECT * FROM users WHERE role_as = "admin" ORDER BY created_at DESC ');
            $rows = $this->db->resultSet();

            if(count($rows) > 0){
                return $rows;
            }else{
                return false;
            }
        }
    }
  

