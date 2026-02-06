<?php
$conn = new mysqli("localhost","root","root","chem_platform",8889);
$conn->set_charset("utf8mb4");
if($conn->connect_error){
    die(json_encode(["db"=>"fail"]));
}
?>
