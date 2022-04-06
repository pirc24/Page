<?php
//Povezava z bazo
function dbConnect() {
    $db;
    $db = new mysqli("localhost", "mojl11_mojl11", "geslo1234R", "mojl11_baza");
    if (!$db){
        die("connection failed: " . $db->connect_error);}
    else{
   // echo "dela";
    }
    
    //$db->close();
    return $db;
}