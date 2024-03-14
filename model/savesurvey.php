<?php
    session_start();
    if(isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        include "../config/connection.php";
        include "functions.php";

        try{
            $conn->beginTransaction();

            $answer = $_POST['answer'];
            $id = $_SESSION['user']->id_user;
            
            $table = "survey";
            $columns = "answer,id_user";
            $values = [$answer,$id];
            $insert = insert($table,$columns,$values);
            if($insert){
                $response = ["msg" => "Your answer has been saved."];
                $statuscode = 201;
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