<?php
    include_once 'database.php';

    class Admin{
        protected $db;

        function __construct(){
            $this->db = new Database;
        }

        function login($email, $password){
            $sql = 'SELECT * FROM admin WHERE email = :email AND password = :password;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $password);

            if($query->execute()){
                $data = $query->fetch();
            }

            return $data;
        }

        function getInfo($admin_id){
            $sql = 'SELECT * FROM admin WHERE admin_id = :admin_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':admin_id', $admin_id);

            if($query->execute()){
                $data = $query->fetch();
            }

            return $data;
        }
    }
?>