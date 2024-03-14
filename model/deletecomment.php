<?php
session_start();
    if(isset($_SESSION['user']) && isset($_POST['id'])){
        include "../config/connection.php";
        include "functions.php";
        try{
            $conn->beginTransaction();
            $id = $_POST['id'];

            $delete = delete($id,"comment");
            if($delete){
                $_SESSION['msg'] = "Successfully deleted comment.";
                $response = ["msg" => "Successfully deleted comment."];
                $statuscode = 201;
            }else{
                $response = ["msg" => "Problem with server.Please try again later."];
                $statuscode = 500;
            }

            $conn->commit();
            echo json_encode($response);
            http_response_code($statuscode);
        }catch(Exception $ex){
            $conn->rollBack();
            var_dump($ex);
            $response = ["msg" => "Failed to delete comment."];
            echo json_encode($response);
            http_response_code(500);
        }
    }else{
        http_response_code(404);
    }
?>