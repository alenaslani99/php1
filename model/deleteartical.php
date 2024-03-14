<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['user']->role_name == 'Admin' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
    include "../config/connection.php";
    include "functions.php";

    try{
        $conn->beginTransaction();
        $id = $_POST['id'];

        $delete = delete($id,"article");
        if($delete){
            $_SESSION['msg'] = "Successfully deleted article.";
            $response = ["msg" => "Successfully deleted article."];
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
        $response = ["msg" => "Failed to delete article."];
        echo json_encode($response);
        http_response_code(500);
    }

}else{
    http_response_code(404);
}
?>