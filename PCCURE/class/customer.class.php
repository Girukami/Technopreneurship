<?php
    include_once 'database.php';

    class Customer{
        protected $db;

        function __construct(){
            $this->db = new Database;
        }

        function login($email, $password){
            $sql = 'SELECT * FROM customer WHERE email = :email AND password = :password;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $password);

            if($query->execute()){
                $data = $query->fetch();
            }

            return $data;
        }

        function signup($fname, $mname, $lname, $email, $cnum, $address, $password){
            $sql = 'INSERT INTO customer(first_name, middle_name, last_name, email, contact_num, address, password) 
                    VALUES(:fname, :mname, :lname, :email, :cnum, :address, :password);';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':fname', $fname);
            $query->bindParam(':lname', $lname);
            $query->bindParam(':mname', $mname);
            $query->bindParam(':email', $email);
            $query->bindParam(':cnum', $cnum);
            $query->bindParam(':address', $address);
            $query->bindParam(':password', $password);

            if($query->execute()){
                // Get the customer id of newly created account
                $sql = 'SELECT * FROM customer WHERE email = :email AND password = :password;';
                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':email', $email);
                $query->bindParam(':password', $password);

                if($query->execute()){
                    // Insert a new data for user table in database which is the newly created account
                    $data = $query->fetch();

                    $sql = 'INSERT INTO user(customer_id, user_type) VALUES(:customer_id, "customer");';
    
                    $query = $this->db->connect()->prepare($sql);
                    $query->bindParam(':customer_id', $data['customer_id']);

                    if($query->execute()){
                        return true;
                    }
                }
            }

            return false;
        }

        function getInfo($customer_id){
            $sql = 'SELECT * FROM customer WHERE customer_id = :customer_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id', $customer_id);

            if($query->execute()){
                $data = $query->fetch();
            }

            return $data;
        }

        // ---------- Admin side ----------
        // For rendering all customers
        function getAll(){
            $sql = 'SELECT * FROM customer ORDER BY created_at DESC';

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

        // For deleting account
        function delete($customer_id){
            $sql = 'DELETE FROM user WHERE customer_id = :customer_id; DELETE FROM customer WHERE customer_id = :customer_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id', $customer_id);

            if($query->execute()){
                return true;
            }

            return false;
        }

        // For saving edit account info
        function saveEdit($fname, $mname, $lname, $contact_num, $address, $customer_id){
            $sql = 'UPDATE customer SET first_name = :fname, middle_name = :mname, last_name = :lname, contact_num = :contact_num, address = :address 
                    WHERE customer_id = :customer_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':fname', $fname);
            $query->bindParam(':mname', $mname);
            $query->bindParam(':lname', $lname);
            $query->bindParam(':contact_num', $contact_num);
            $query->bindParam(':address', $address);
            $query->bindParam(':customer_id', $customer_id);

            if($query->execute()){
                return true;
            }

            return false;
        }
    }
?>