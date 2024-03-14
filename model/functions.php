<?php

    function insert($table,$columns,$values){
        global $conn;

        $qm = "";
        for($i = 0; $i < count($values); $i++){
            if($i == 0){
                $qm = "?";
            }else{
                $qm .=",?";
            }
        }
        $query = "INSERT INTO $table($columns) VALUES($qm)";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute($values);

        return $result;
    }

    function userExistCheck($table, $where, $value){
        global $conn;

        $query = "SELECT * FROM $table WHERE $where=:v";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":v",$value);
        $stmt->execute();
        $res = $stmt->fetch();
    
        return $res;
    }

    function loginCheck($user,$password){
        global $conn;
    
        $query = "SELECT * FROM users u JOIN roles r ON u.id_role=r.id_role WHERE u.username=:u AND u.password=:p";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":u",$user);
        $stmt->bindParam(":p",$password);
        $stmt->execute();
        $res = $stmt->fetch();
    
        return $res;
    }

    function getOneTable($table){
        global $conn;

        $query = "SELECT * FROM $table";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    }

    function getArticles($id){
        global $conn;
        if($id){
            $query = "SELECT a.*,c.*,arts.article_status_name,i.*,u.name,u.last_name FROM articles a JOIN categories as c ON a.id_category=c.id_category JOIN article_status as arts ON a.id_article_status=arts.id_article_status JOIN images i ON a.id_article=i.id_article JOIN users u ON a.id_user=u.id_user WHERE arts.article_status_name='ok' AND a.id_article=:id ORDER BY i.created_at DESC";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            $result = $stmt->fetch();
        }else{
            $query = "SELECT a.*,c.*,arts.article_status_name,i.*,u.name,u.last_name FROM articles a JOIN categories as c ON a.id_category=c.id_category JOIN article_status as arts ON a.id_article_status=arts.id_article_status JOIN images i ON a.id_article=i.id_article JOIN users u ON a.id_user=u.id_user WHERE arts.article_status_name='ok' AND i.status_image = 'ok' ORDER BY a.created_at DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();
        }

        return $result;
    }

    function getComments($id){
        global $conn;

        $query = "SELECT c.*,u.username FROM comments c JOIN articles_comments ac ON c.id_comment=ac.id_comment JOIN articles a ON ac.id_article=a.id_article JOIN users u ON c.id_user=u.id_user WHERE a.id_article=:id AND c.comment_status = 'ok' ORDER BY c.created_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    function updateArticle($title,$text,$category,$id){
        global $conn;
        $query = "UPDATE articles SET title = :t, article_text = :att, id_category = :cat WHERE id_article = :id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":t",$title);
        $stmt->bindParam(":att",$text);
        $stmt->bindParam(":cat",$category);
        $stmt->bindParam(":id",$id);
        $result = $stmt->execute();
        
        return $result;
    }

    function delete($id,$type){
        global $conn;
        if($type == "article"){
            $query = "UPDATE articles SET id_article_status=2 WHERE id_article=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id);
            $result = $stmt->execute();
        }elseif($type == "comment"){
            $query = "UPDATE comments SET comment_status='deleted' WHERE id_comment=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id",$id);
            $result = $stmt->execute();
        }
        
        return $result;
    }

    function updateImageStatus($id,$status){
        global $conn;

        $query = "UPDATE images SET status_image = :st WHERE id_image = :id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':st',$status);
        $stmt->bindParam(':id',$id);
        $result = $stmt->execute();
        
        return $result;
    }

    function deletemessage($id){
        global $conn;

        $query = "DELETE FROM messages WHERE id_message = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $result = $stmt->execute();

        return $result;
    }
?>