<?php
function getConnection(){
    $username="id258940_susy79";
    $password="andspe79";
    //$database="id258940_susy_league_2019-20";
    $database="id258940_susy_league_2022-23";
    $localhost = "localhost";


    // Create connection
    if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function cleanQuery($string) {
    // $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    // $string = preg_replace('/[^A-Za-z0-9]/', '', $string); // Removes special chars.
 
    // return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    return preg_replace('/\s+/S', " ", $string);
 }
// //tophost
// $username="susyleag16215";
// $password="*q3G99i&w24J";
// $database="susyleag16215";
// $localhost = "sql.susyleague.it";

//host poco
// $username="susyleag_admin";
// $password="$75(GDCeN*G*";
// //$database="id258940_susy_league_2019-20";
// $database="susyleag_db";
// $localhost = "localhost";

// //awardspace
// $username="3532779_susyleague";
// $password="[uwGLAkx3u97hPGX";
// //$database="id258940_susy_league_2019-20";
// $database="3532779_susyleague";
// $localhost = "fdb30.awardspace.net";

//FTP
//username: 3532779_susyleague
//password: M=aawUrI1KWDi1B/
?>