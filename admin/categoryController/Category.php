<?php
       if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ ."/../../Model/Database.php";
    class Category{
        private $username;
        private $db;

        public function __construct(){
            $this->db =  new Database();
        }

          public function showCat(){
            $this->db->query('SELECT * FROM category ');
            // comment.comment_id AS comment_id, 
            //         comment.comment AS comment, 
            //         comment.user_id AS user_id, 
            //         user.username AS username,
            //         post.post_id,
            //         post.post_title,
            //         post.post_text,
            //         post.category,
            //         post.post_image,
            //         post.created_at
            //     FROM comment 
            //     INNER JOIN post ON comment.post_id = post.post_id
            //     INNER JOIN user ON comment.user_id = user.id
            $rows = $this->db->resultSetObj();

            if(count($rows) > 0){
                return $rows;
            }else{
                return false;
            }

        }
        public function removeCat($id){

                $this->db->query('DELETE FROM category WHERE id = :uid');
                $this->db->bind(':uid', $id);

                if ($this->db->execute()) {
                    header('Location: adminDashboard.php?category');
                    return 'Category removed successfully';
                } else {
                    return false;
                }
           
        }
        Public function InsertCat( $category){
                // Save filename in DB
                 $this->db->query("SELECT * FROM category WHERE category=:cat");
                $this->db->bind(':cat', $category);
                $row = $this->db->singleRecord();
                if($row){
                    return "Category already in Records";
                }

                $this->db->query('INSERT INTO category(category) VALUES(:cat)');
                $this->db->bind(':cat', $category); 
  
                if($this->db->execute()){
                    return true;
                }
            
        }
        public function editCat($id, $category){
            $this->db->query("UPDATE category SET category =:cat WHERE id = :id");
            $this->db->bind(":id", $id);
            $this->db->bind(":cat", $category);
         
        
            return $this->db->execute() ? true : "Failed to update user details.";
        }
       
    }

    
