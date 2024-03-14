<?php
    define ("envFile",__DIR__."/.env");
    define("SERVER", env("SERVER"));
    define("DATABASE", env("DATABASE"));
    define("USERNAME", env("USERNAME"));
    define("PASSWORD", env("PASSWORD"));

    function env($mark){
        $niz = file(envFile);
        $vrednost1 = "";

        foreach($niz as $red){
            $red = trim($red);
            list($id, $vrednost0) = explode("=", $red);

            if($id == $mark){
                $vrednost1 = $vrednost0;
                break;
            }
        }
        return $vrednost1;
    }
?>