<?php
require_once 'Config.php';

    Class Database extends Config {
       
        private $dbh;
        private $stmt;
        private $error;

        public function __construct() {
            $config = new Config(); 

            $dsn = 'mysql:host='. $config->host. ';dbname=' . $config->dbName;

            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            try{
                $this->dbh = new PDO($dsn, $config->user, $config->password, $options);
            }
            catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        //Query method
        public function query($query){
            $this->stmt = $this->dbh->prepare($query);
        }

        //Bind values
        public function bind($param, $value, $type=null){
            if(is_null($type)){

                switch(true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                    break;
                    
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                    break;

                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                    break;

                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        //Execute query
        public function execute(){
           return $this->stmt->execute();
        }

        //Result set
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function resultSetObj(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        //Single Record
        public function singleRecord(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function singleRecordObj(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        public function rowCount(){
            return $this->stmt->rowCount();
            
        }


    }