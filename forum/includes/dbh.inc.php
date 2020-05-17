<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "nerdtalks";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}


//$servername = "sql207.byethost.com";
//$dBUsername = "b7_25034283";
//$dBPassword = "p8kwzq97";
//$dBName = "b7_25034283_forum";
//
//$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
//
//if (!$conn) {
//    die("Connection failed: " . mysqli_connect_error());
//}