<?php
    include_once 'database.php';

    class User{
        protected $db;

        function __construct(){
            $this->db = new Database;
        }

        function getInfo($id, $user_type){
            $sql = 'SELECT * FROM user WHERE (admin_id = :id OR customer_id = :id) AND user_type = :user_type;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $id);
            $query->bindParam(':user_type', $user_type);

            if($query->execute()){
                $data = $query->fetch();
            }

            return $data;
        }
    }
?>