<?php
    session_start();
    if(isset($_SESSION['user']) && $_SESSION['user']->role_name == 'Admin' && $_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../config/connection.php";
        include "functions.php";
        try{
            $conn->beginTransaction();
            $name = $_POST['category'];
            $errors = 0;

            if($name == ""){
                $errors++;
            }

            if($errors == 0){
                $table = "categories";
                $columns = "category_name";
                $values = [$name];
                $insert = insert($table,$columns,$values);
                if($insert){
                    $response = ["msg" => "Successfully added new category."];
                    $statuscode = 201;
                }
            }
                $conn->commit();
                echo json_encode($response);
                http_response_code($statuscode);
        }catch(Exception $ex){
            $conn->rollBack();
            $response = ["msg" => "Failed to add a new category to the database."];
            echo json_encode($response);
            http_response_code(500);
        }
    }else{
        http_response_code(404);
    }
?>