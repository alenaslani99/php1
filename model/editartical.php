<?php
session_start();    
if(isset($_SESSION['user']) && $_SESSION['user']->role_name == "Admin" && $_SERVER['REQUEST_METHOD'] == "POST"){
    include "../config/connection.php";
    include "functions.php";
    try{
        $conn->beginTransaction();
        $title = $_POST['title'];
        $category = $_POST['category'];
        $text = $_POST['text'];
        $articleid = $_POST['id'];
        if(isset($_FILES['image'])){
            $img = $_FILES['image'];
            $imgprev = $_POST['imgprev'];
        }else{
            $img = "";
            $imgprev = "";
        }
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
                    $update = updateArticle($title,$text,$category,$articleid);
                    if($update){
                        if($img != ""){
                            $updateprev = updateImageStatus($imgprev,"archive");
                            if($updateprev){
                            $table = 'images';
                            $columns = 'src,id_article,created_at,status_image';
                            $nameimg = time()."_".$img['name'];
                            $src = '../assets/images/'.$nameimg;
                            $tmp = $img['tmp_name'];
                            move_uploaded_file($tmp,$src);
                            $time = date("Y-m-d h:i:s");
                            $values = [$nameimg,$articleid,$time,"ok"];
                            $insert = insert($table,$columns,$values);
                                if($insert){
                                $response = ["msg" => "Successfully updated article."];
                                $statuscode = 201;
                                }
                            }
                        }else{
                            $response = ["msg" => "Successfully updated article."];
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