<?php
    session_start();
    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        include "../config/connection.php";
        include "functions.php";

        $username = $_POST['loginuser'];
        $password = $_POST['loginpassword'];

        $errors = 0;
        $regPass = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
        $regUsername = "/^[0-9A-Za-z]{6,16}$/";
        
        if(!preg_match($regPass,$password)){
            $errors++;
            $response = ["msg" => "Please provide a valid password."];
            $statuscode = 400;
        }
        if(!preg_match($regUsername,$username)){
            $errors++;
            $response = ["msg" => "Please provide a valid username."];
            $statuscode = 400;
        }

        if($errors == 0){
            $pass = md5($password);
            $user = loginCheck($username,$pass);

            if($user){
                $_SESSION['user'] = $user;
                if($user->role_name == "Admin"){
                    $response = ["msg" => "admin"];
                    $statuscode = 200;

                }else{
                    $response = ["msg" => "user"];
                    $statuscode = 200;
                }
            }else{
                $response = ["msg" => "User does not exist."];
                $statuscode = 404;
            }
        }else{
                $response = ["msg" => "Problem."];
                $statuscode = 404;
        }

        echo json_encode($response);
        http_response_code(200);

    }else{
        http_response_code(404);
    }
?>