<?php
    if(isset($_POST['userid'])){
        require 'config.php';
        $flag=true;
        $user=$_POST['userid'];
        $query="SELECT * FROM `account`";
        $data=mysqli_query($conn,$query);
        $total=mysqli_num_rows($data);
        while($total>0){
            $R=mysqli_fetch_assoc($data);
            if(strcmp($user,$R['username'])==0){
                $flag=false;
                break;
            }
            $total-=1;
            echo "<script>console.log($total)</script>";
        }
        if($flag)
        {
            echo "<script>console.log('PHP STARTED')</script>";
        
            $pass=$_POST['pass'];
            $sql="INSERT INTO `account`(`username`,`password`,`date/time`) VALUES('$user','$pass',current_timestamp())";
            $result=mysqli_query($conn,$sql);
            if($result){
                echo "<script>alert('YOUR ACCOUNT HAS BEEN CREATED....')</script>";
                session_start();
                $_SESSION['username']=$user;
                header('location:note.php');
            }
            else{
                echo "<script>alert('ERROR OCCURED....SORRY...')</script>";
            }
        }
        else{
            echo "<script>alert('USERNAME ALREADY EXIST.....')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOTES</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="index.css">
    
</head>
<body>
    <nav id="navbar">
        <h1><em>^_^ NOTES /.</em></h1>
        <a href="index.html" class="navlink">HOME</a>
        <a href="login.php" class="navlink">LOG IN</a>
    </nav>
    <div id="container">
        <div id="frame">
            <div id="signup">
                <h1>SIGN UP</h1>
                <form action="signup.php" id="signup_form" method="post" onsubmit="return check()">
                    <lebel class="signup_lebel">USERNAME :- <input type="text" id="userid" name="userid" placeholder="USERNAME" required></lebel><br>
                    <lebel class="signup_lebel">PASSWORD :- <input type="password" id="pass" name="pass" placeholder="PASSWORD" required><br><u id="errorpass" style="color:red;background-color:gold"></u></lebel><br>
                    <lebel class="signup_lebel">PASSWORD :- <input type="password" id="confirm" name="confirm" placeholder="CONFIRM PASSWORD" required><br><u id="confirmerror" style="color:red;background-color:gold"></u></lebel>
                    <br><input type="submit" class="submit" value="SIGN UP"><br>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function check(){
            let password = document.getElementById('pass').value;
            let confirm = document.getElementById('confirm').value;
            // console.log(password);
            // console.log(confirm);
            if(password.length<8){
                document.getElementById('errorpass').innerHTML="*PASSWORD LENGTH SHOULD BE AT LEAST 8 CHARECTERS.......";
                document.getElementById('pass').style="border:2px solid red";
                return false;
            } 
            else{
                document.getElementById('errorpass').innerHTML="";
                document.getElementById('pass').style="border:2px solid black";
            }
            // let val=password.localeCompare(confirm);
            // console.log(val);
            if(password.localeCompare(confirm)!=0){
                document.getElementById('confirmerror').innerHTML="*PLEASE ENTER PASSWORD CORRECTLY......";
                document.getElementById('confirm').style="border:2px solid red";
                return false;
            }
            else{
                document.getElementById('confirmerror').innerHTML="";
                document.getElementById('confirm').style="border:2px solid black";
            }
            return true;
        }
    </script>
</body>
</html>