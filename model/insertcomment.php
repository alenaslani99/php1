<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && $_SESSION['user']->role_name == "User"){
        include "../config/connection.php";
        include "functions.php";
        try{
        $conn->beginTransaction();
        $comment = $_POST['comm'];
        $user = $_POST['id'];
        $article = $_POST['artid'];

        $errors = 0;

        if($comment == ""){
            $errors++;
            $response = ["msg" => "Please provide a valid comment."];
            $statuscode = 400;
        }
        if($user == ""){
            $errors++;
        }

        if($errors == 0){
            $table = "comments";
            $columns = "comment,created_at,comment_status,id_user";
            $time = date("Y-m-d h:i:s");
            $values = [$comment,$time,"ok",$user];
            $insert = insert($table,$columns,$values);
            if($insert){
                $lid = $conn->lastInsertId();
                $table1 = "articles_comments";
                $columns1 = "id_article,id_comment";
                $values1 = [$article,$lid];
                $insert1 = insert($table1,$columns1,$values1);
                if($insert1){
                    $response = ["msg" => "Successfully added new comment."];
                    $statuscode = 201;
                }
            }
        }
                $conn->commit();
                echo json_encode($response);
                http_response_code($statuscode);
        }catch(Exception $ex){
            $conn->rollBack();
            var_dump($ex);
            $response = ["msg" => "Failed to add a new comment to the database."];
            echo json_encode($response);
            http_response_code(500);
        }
        
    }else{
        http_response_code(404);
    }
?>