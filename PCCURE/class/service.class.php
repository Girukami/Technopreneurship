<?php
    include_once 'database.php';

    class Service{
        protected $db;

        function __construct(){
            $this->db = new Database;
        }

        function saveNewService($image, $name, $price, $description){
            $sql = 'INSERT INTO service (image, name, price, description) 
                    VALUES (:image, :name, :price, :description);';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':image', $image);
            $query->bindParam(':name', $name);
            $query->bindParam(':price', $price);
            $query->bindParam(':description', $description);

            if($query->execute()){
                return true;
            }

            return false;
        }

        function saveEdit($service_id, $image, $name, $price, $description){
            if($image === 'empty'){
                $sql = 'UPDATE service SET name = :name, price = :price, description = :description 
                        WHERE service_id = :service_id;';

                $query = $this->db->connect()->prepare($sql);
            }
            else{
                $sql = 'UPDATE service SET image = :image, name = :name, price = :price, 
                        description = :description WHERE service_id = :service_id;';

                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':image', $image);
            }

            $query->bindParam(':service_id', $service_id);
            $query->bindParam(':name', $name);
            $query->bindParam(':price', $price);
            $query->bindParam(':description', $description);

            if($query->execute()){
                return true;
            }

            return false;
        }

        function deleteservice($service_id){
            $sql = 'DELETE FROM service WHERE service_id = :service_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':service_id', $service_id);

            if($query->execute()){
                return true;
            }

            return false;
        }

        function getAll(){
            $sql = 'SELECT * FROM service ORDER BY name DESC;';

            $query = $this->db->connect()->prepare($sql);
            
            if($query->execute()){
                if($query->rowCount() < 1){
                    $data = 'empty';
                }
                else{
                    $data = $query->fetchAll();
                }
            }

            return $data;
        }

        function getOne($service_id){
            $sql ='SELECT * FROM service WHERE service_id = :service_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':service_id', $service_id);

            if($query->execute()){
                $data = $query->fetch();
            }

            return $data;
        }
    }
?>