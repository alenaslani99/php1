<?php
    session_start();

    if($_SERVER['REQUEST_METHOD'] =="POST" && isset($_SESSION['user']) && ($_SESSION['user']->role_name == "Admin" || $_SESSION['user']->role_name == "Editor")){
        include "../config/connection.php";
        include "functions.php";
        
        try{
            $conn->beginTransaction();
            $title = $_POST['title'];
            $category = $_POST['category'];
            $text = $_POST['text'];
            $img = $_FILES['image'];
            
            $errors = 0;

            if($title == ""){
                $errors++;
                $response = ["msg" => "Please provide a valid title."];
                $statuscode = 400;
            }
            if($category == "0"){
                $errors++;
                $response = ["msg" => "Please provide a valid category."];
                $statuscode = 400;
            }
            if($text == ""){
                $errors++;
                $response = ["msg" => "Please provide a valid title."];
                $statuscode = 400;
            }

            if($errors == 0){
                $id = $_SESSION['user']->id_user;
                $nameimg = time()."_".$img['name'];
                $src = '../assets/images/'.$nameimg;
                $tmp = $img['tmp_name'];
                    $table = "articles";
                    $columns = "title,article_text,created_at,id_category,id_article_status,id_user";
                    $time = date("Y-m-d h:i:s");
                    $values = [$title,$text,$time,$category,1,$id];
                    $insert = insert($table,$columns,$values);
                    if($insert){
                        $lid = $conn->lastInsertId();
                        move_uploaded_file($tmp,$src);
                        $imgtable = "images";
                        $imgcolumns = "src,id_article,created_at,status_image";
                        $imgvalue = [$nameimg,$lid,$time,"ok"];
                        $imginsert = insert($imgtable,$imgcolumns,$imgvalue);
                        if($imginsert){
                            $response = ["msg" => "Successfully added new article."];
                            $statuscode = 201;
                        }
                    }else{
                        $response = ["msg" => "Problem with server.Please try again later."];
                        $statuscode = 500;
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