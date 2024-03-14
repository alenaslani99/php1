<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        try{
            include "../config/connection.php";
            include "functions.php";
            $conn->beginTransaction();
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $message = $_POST['message'];
    
            $errors = 0;
            $regName = "/^[A-ZŠĐČĆŽ][a-zšđžčć]{2,}/";
            if(!preg_match($regName,$fname)){
                $errors++;
                $response = ["msg" => "Please provide a valid name."];
                $statuscode = 400;
            }
            if(!preg_match($regName,$lname)){
                $errors++;
                $response = ["msg" => "Please provide a valid last name."];
                $statuscode = 400;
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errors++;
                $response = ["msg" => "Please provide a valid email."];
                $statuscode = 400;
            }
            if($message ==""){
                $errors++;
                $response = ["msg" => "Please provide a valid message."];
                $statuscode = 400;
            }
    
            if($errors == 0){
                $table = "messages";
                $columns = "first_name_mess,last_name_mess,email_mess,message";
                $values = [$fname,$lname,$email,$message];
                $insert = insert($table,$columns,$values);

                if($insert){
                    $response = ["msg" => "You have successfully sent your message."];
                    $statuscode = 201;
                }
            }
                $conn->commit();
                echo json_encode($response);
                http_response_code($statuscode);
        }catch(Exception $ex){
            $conn->rollBack();
            $response = ["msg" => "Failed to add a new article to the database."];
            echo json_encode($response);
            http_response_code(500);
        }
        
    }else{
        http_response_code(404);
    }
?>