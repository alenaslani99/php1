<?php
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        include "../config/connection.php";
        include "functions.php";
        try{
            $conn->beginTransaction();
            $name = $_POST['fname'];
        $lastname = $_POST['lname'];
        $username = $_POST['user'];
        $email = $_POST['mail'];
        $password = $_POST['pass'];
        $confirmpassword = $_POST['confirmpassword'];
        $errors = 0;
        $regName = "/^[A-ZŠĐČĆŽ][a-zšđžčć]{2,}/";
        $regUsername = "/^[0-9A-Za-z]{6,16}$/";
        $regPass = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

        if(!preg_match($regName,$name)){
            $errors++;
            $response = ["msg" => "Please provide a valid name."];
            $statuscode = 400;
        }
        if(!preg_match($regName,$lastname)){
            $errors++;
            $response = ["msg" => "Please provide a valid last name."];
            $statuscode = 400;
        }
        if(!preg_match($regUsername,$username)){
            $errors++;
            $response = ["msg" => "Please provide a valid username."];
            $statuscode = 400;
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors++;
            $response = ["msg" => "Please provide a valid email."];
            $statuscode = 400;
        }
        if(!preg_match($regPass,$password)){
            $errors++;
            $response = ["msg" => "Please provide a valid password."];
            $statuscode = 400;
        }
        if($password != $confirmpassword){
            $errors++;
            $response = ["msg" => "Passwords do not match."];
            $statuscode = 400;
        }

        if($errors == 0){
            $exist = userExistCheck("users","username",$username);
            
            if($exist){
                $response = ["msg" => "User already exist."];
                $statuscode = 409;
            }else{
                $hashpassword = md5($password);
                $table = "users";
                $columns = "name,last_name,username,email,password,id_role";
                $values = [$name,$lastname,$username,$email,$hashpassword,"2"];
                $result = insert($table,$columns,$values);
                if($result){
                    $_SESSION['msgregister'] = "Congratulations! You have successfully registered. Welcome!";
                    $response = ["msg" => "Congratulations! You have successfully registered. Welcome!"];
                    $statuscode = 201;
                }
            }
                $conn->commit();
                echo json_encode($response);
                http_response_code($statuscode);
        }
        }catch(Exception $ex){
            $conn->rollBack();
            $response = ["msg" => "Failed to add a new user to the database."];
            echo json_encode($response);
            http_response_code(500);
        }

    }else{
        http_response_code(404);
    }
?>