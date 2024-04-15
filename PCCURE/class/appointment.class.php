<?php
    include_once 'database.php';

    class Appointment{
        protected $db;

        function __construct(){
            $this->db = new Database;
        }

        function addAppointment($customer_id){
            $sql = 'INSERT INTO `appointment` (customer_id, status) VALUES (:customer_id, "pending");';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id', $customer_id);

            if($query->execute()){
                $sql = 'SELECT appointment_id FROM `appointment` ORDER BY appointment_date DESC LIMIT 1;';

                $query = $this->db->connect()->prepare($sql);

                if($query->execute()){
                    $data = $query->fetch();
                }

                return $data;
            }

            return false;
        }

        function addAppointmentService($customer_id, $service_id, $address, $contact_num){
            if(!$appointment_id = $this->addAppointment($customer_id)){
                return false;
            }

            $sql = 'INSERT INTO appointment_service (appointment_id, customer_id, service_id, address, contact_num) VALUES (:appointment_id, :customer_id, :service_id, :address, :contact_num);';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':appointment_id', $appointment_id[0]);
            $query->bindParam(':customer_id', $customer_id);
            $query->bindParam(':service_id', $service_id);
            $query->bindParam(':address', $address);
            $query->bindParam(':contact_num', $contact_num);

            if($query->execute()){
                return $appointment_id;
            }

            return false;
        }

        function getCheckoutInfo($order_id){
            $sql = 'SELECT product.product_id, product.image, product.name, product.price, product.stock, order_item.order_item_id, order_item.quantity, `order`.`delivery` FROM product, 
                    `order`, order_item WHERE `order`.`order_id` = :order_id AND product.product_id = order_item.product_id AND 
                    `order`.order_id = order_item.order_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':order_id', $order_id);

            if($query->execute()){
                $data = $query->fetch();
            }

            return $data;
        }

        function placeOrder($customer_id, $delivery, $order_item_id, $changed, $quantity, $order_id, $amount, $product_id){
            $sql = 'UPDATE `order` SET delivery = :delivery, status = "pending" WHERE order_id = :order_id AND customer_id = :customer_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':customer_id', $customer_id);
            $query->bindParam(':order_id', $order_id);
            $query->bindParam(':delivery', $delivery);

            if($query->execute()){
                if($changed === true){
                    $sql = 'UPDATE order_item SET quantity = :quantity WHERE order_item_id = :order_item_id;';

                    $query = $this->db->connect()->prepare($sql);
                    $query->bindParam(':order_item_id', $order_item_id);
                    $query->bindParam(':quantity', $quantity);

                    if(!$query->execute()){
                        return false;
                    }
                }

                $sql = 'INSERT INTO payment (order_id, amount, method, status) VALUES (:order_id, :amount, "Cash on delivery", "unpaid");';

                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':order_id', $order_id);
                $query->bindParam(':amount', $amount);

                if($query->execute()){
                    $sql = 'UPDATE product SET stock = (stock - :quantity) WHERE product_id = :product_id;';

                    $query = $this->db->connect()->prepare($sql);
                    $query->bindParam(':quantity', $quantity);
                    $query->bindParam(':product_id', $product_id);

                    if($query->execute()){
                        return true;
                    }
                }
            }
            
            return false;
        }

        function getAllStatus($customer_id){
            if($customer_id !== 'admin'){
                $sql = 'SELECT status from `appointment` WHERE customer_id = :customer_id GROUP BY status;';
    
                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':customer_id', $customer_id);
            }
            else{
                $sql = 'SELECT status from `appointment` WHERE status != "reviewing" GROUP BY status;';

                $query = $this->db->connect()->prepare($sql);
            }

            if($query->execute()){
                if($query->rowCount() < 1){
                    $data = 'empty';
                }
                else{
                    $data = $query->fetchAll();
                }

                return $data;
            }
        }

        function getAllByStatus($customer_id, $status){
            if($customer_id !== 'admin'){
                $sql = 'SELECT appointment.appointment_id, service.image, service.name, service.price, 
                        DATE_FORMAT(STR_TO_DATE(appointment.appointment_date, "%Y-%m-%d %H:%i:%s"), "%h:%i %p | %a | %M %d, %Y") AS date, appointment.status FROM appointment, appointment_service, 
                        service WHERE appointment.customer_id = :customer_id AND appointment.status = :status AND service.service_id = appointment_service.service_id AND 
                        appointment_service.appointment_id = appointment.appointment_id ORDER BY date;';

                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':customer_id', $customer_id);
            }
            else{
                $sql = 'SELECT appointment.appointment_id, service.image, service.name, service.price, 
                        DATE_FORMAT(STR_TO_DATE(appointment.appointment_date, "%Y-%m-%d %H:%i:%s"), "%h:%i %p | %a | %M %d, %Y") AS date, appointment.status FROM appointment, appointment_service, 
                        service WHERE appointment.status = :status AND service.service_id = appointment_service.service_id AND 
                        appointment_service.appointment_id = appointment.appointment_id ORDER BY date;';

                $query = $this->db->connect()->prepare($sql);
            }
            
            $query->bindParam(':status', $status);

            if($query->execute()){
                $data = $query->fetchAll();
            }

            return $data;
        }

        function getAppointmentInfo($customer_id, $appointment_id){
            if($customer_id !== 'admin'){
                $sql = 'SELECT service.image, service.name, service.price, appointment.status, appointment_service.address, appointment_service.contact_num 
                        FROM service, appointment_service, appointment WHERE appointment.customer_id = :customer_id AND appointment.appointment_id = :appointment_id AND 
                        service.service_id = appointment_service.service_id AND appointment_service.appointment_id = appointment.appointment_id;';
    
                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':customer_id', $customer_id);
            }
            else{
                $sql = 'SELECT service.image, service.name, service.price, appointment.status, appointment_service.address, appointment_service.contact_num, customer.first_name, 
                        customer.middle_name, customer.last_name FROM service, appointment_service, appointment, customer, 
                        payment WHERE appointment.appointment_id = :appointment_id AND service.service_id = appointment_service.service_id AND appointment_service.appointment_id = appointment.appointment_id 
                        AND appointment.customer_id = customer.customer_id;';

                $query = $this->db->connect()->prepare($sql);
            }

            $query->bindParam(':appointment_id', $appointment_id);

            if($query->execute()){
                $data = $query->fetch();
            }

            return $data;
        }

        function deleteOrder($order_id){
            $sql = 'DELETE FROM order_item WHERE order_id = :order_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':order_id', $order_id);

            if($query->execute()){
                $sql = 'DELETE FROM `order` WHERE order_id = :order_id;';

                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':order_id', $order_id);

                if($query->execute()){
                    return true;
                }
            }

            return false;
        }

        function updateAppointmentStatus($appointment_id, $status){
            $sql = 'UPDATE appointment SET status = :status WHERE appointment_id = :appointment_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':appointment_id', $appointment_id);
            $query->bindParam(':status', $status);

            if($query->execute()){
                return true;
            }

            return false;
        }

        function markAsPaid($order_id){
            $sql = 'UPDATE payment SET status = "paid" WHERE order_id = :order_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':order_id', $order_id);
            
            if($query->execute()){
                return true;
            }

            return false;
        }

        function markclaimed($order_id){
            $sql = 'UPDATE `order` SET status = "claimed" WHERE order_id = :order_id;';

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':order_id', $order_id);

            if($query->execute()){
                return true;
            }

            return false;
        }
    }
?>