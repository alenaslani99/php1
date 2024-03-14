<?php
    session_start();
    if(isset($_SESSION['user']) && $_SESSION['user']->role_name == 'Admin' && $_SERVER['REQUEST_METHOD'] == "POST"){
        include "../config/connection.php";
        include "functions.php";
        try{
            $conn->beginTransaction();
            $id = $_POST['id'];
        
            $delete = deletemessage($id);
            if($delete){
                $_SESSION['msg'] = "Successfully deleted message.";
                $response = ["msg" => "Successfully deleted message."];
                $statuscode = 201;
            }

            $conn->commit();
            echo json_encode($response);
            http_response_code($statuscode);
        }catch(Exception $ex){
            $conn->rollBack();
            $response = ["msg" => "Failed to delete message to the database."];
            echo json_encode($response);
            http_response_code(500);
        }

    }else{
        http_response_code(404);
    }
?>