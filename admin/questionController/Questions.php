<?php
       if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ ."/../../Model/Database.php";
    class Questions{
        private $username;
        private $db;
        private $imageFolder = "../../uploads/";

        public function __construct(){
            $this->db =  new Database();
        }

          public function showQuestions(){
            $this->db->query('SELECT * FROM questions ORDER BY created_at DESC ');
            $rows = $this->db->resultSetObj();

            if(count($rows) > 0){
                return $rows;
            }else{
                return false;
            }

        }
        public function showsinglequestion($id){
            $this->db->query('SELECT * FROM questions WHERE post_id=:id');
            $this->db->bind(':id', $id);
            $rows = $this->db->singleRecord();

                return $rows;


        }
        public function removequestion($id){

            // Step 3: Delete the post from the database
            $this->db->query('DELETE FROM questions WHERE id = :uid');
            $this->db->bind(':uid', $id);

            if ($this->db->execute()) {
                header('Location: adminDashboard.php?questions');
                return 'Post removed successfully';
            } else {
                return false;
            }
           

        }
        Public function InsertPost($question, $option_a, $option_b, $option_c, $option_d, $correct_option, $subject){
      
            if(empty($question) || empty($option_a) || empty($option_b) || empty($option_c) || empty($option_d) || empty($correct_option) || empty($subject)){
                  $_SESSION['msg'] = "All fields are required";
                  $_SESSION['msg_type'] = "error";
            }
     
                // Save filename in DB
                $this->db->query('INSERT INTO questions(subject, question, option_a, option_b, option_c, option_d, correct_option) VALUES(:sub, :quest, :opt_a, :opt_b, :opt_c, :opt_d, :cor_opt)');
                $this->db->bind(':sub', $subject); 
                $this->db->bind(':quest', $question); 
                $this->db->bind(':opt_a', $option_a); 
                $this->db->bind(':opt_b', $option_b); 
                $this->db->bind(':opt_c', $option_c); 
                $this->db->bind(':opt_d', $option_d); 
                $this->db->bind(':cor_opt', $correct_option); 

                if($this->db->execute()){
                    return true;
                }
            }

            
public function showPostsByCategoryName($categoryName) {
    $this->db->query("SELECT * FROM post WHERE category = :category ORDER BY created_at DESC");
    $this->db->bind(':category', $categoryName);
    $rows = $this->db->resultSet();
    return count($rows) > 0 ? $rows : false;
}
        }



    


    
