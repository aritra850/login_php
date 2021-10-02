<?php
$server = "localhost";
$password = "";
$username = "root";
$db = "aritra";
$conn=mysqli_connect($server,$username,$password,$db);
if(!$conn){
     die("CONNECTION FALIED".mysqli_connect_error());
}
else{
    echo "<script>console.log('CONFIGURED')</script>";
}
?>