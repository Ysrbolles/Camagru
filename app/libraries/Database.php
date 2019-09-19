<?php
    class Database{
        private $host = DB_HOST;
        private $usr = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;
        private $cn;
        private $req;
        private $error;

        public function __construct()
        {
            $chaine = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            try{
                $this->cn = new PDO($chaine, $this->usr, $this->pass);
            }catch (PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        public function query($sql)
        {
            $this->req = $this->cn->prepare($sql);
        }

        public function bind($param, $value, $type = null)
        {
            if(is_null($type)){
                switch (true) {
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
                        break;
                }

            }
            $this->req->bindvalue($param, $value, $type);
        }

        public function execute(){
            return $this->req->execute();
          }

        public function resultSet()
        {
            $this->execute();
            return $this->req->fetchAll(PDO::FETCH_OBJ);
        }

        public function single()
        {
            $this->execute();
            return $this->req->fetch(PDO::FETCH_OBJ);
        }

        public function rowCount()
        {
            return $this->req->rowCount();
        }
    }