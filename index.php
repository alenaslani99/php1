<?php
    session_start();
    include "model/functions.php";
    include "config/connection.php";
    include "views/fixed/head.php";
    include "views/fixed/header.php";
    if(isset($_GET['page'])){
        switch ($_GET['page']){
            case 'home':
                include "views/pages/home.php";
                break;
            case 'login':
                include "views/pages/login.php";
                break;
            case 'register':
                include "views/pages/register.php";
                break;   
            case 'admin':
                include "views/pages/admin.php";
                break;
            case 'singleartical':
                include "views/pages/singleartical.php";
                break;
            case 'editarticle':
                include "views/pages/editarticle.php";
                break;
            case 'contact':
                include "views/pages/contact.php";
                break;
            case 'author':
                include "views/pages/author.php";
                break;
            default:
                include "views/pages/home.php";
        }
    }else{
        include "views/pages/home.php";
    }
    include "views/fixed/footer.php";
?>