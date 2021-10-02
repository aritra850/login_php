<?php
if(isset($_POST['username'])){
    include 'config.php';
    $user=$_POST['username'];
    $pass=$_POST['password'];
    $sql="SELECT * FROM `account`";
    $result=mysqli_query($conn,$sql);
    $flag=false;
    if($result){
        $total=mysqli_num_rows($result);
        while($total>0){
            $R=mysqli_fetch_assoc($result);
            if(strcmp($user,$R['username'])==0 && strcmp($pass,$R['password'])==0){
                $flag=true;
                break;
            }
            $total-=1;
        }
        echo "<script>console.log('flag')</script>";
        if($flag){
            session_start();
            $_SESSION['username']=$user;
            header('location:note.php');
        }
        else{
            echo "<script>alert('USERNAME OR PASSWORD OR BOTH DOES NOT MATCH....PLEASE ENTER CAREFULLY....')</script>";
        }
    }
    else{
        echo "<script>alert('ERROR....')</script>";
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
        <a href="signup.php" class="navlink">SIGN UP</a>
    </nav>
    <div id="container">
        <div id="frame">
            <div id="login">
                <h1>LOG IN</h1>
                <form action="login.php" id="login_form" method="post">
                    <lebel class="lebel">USERNAME :- <input type="text" id="username" name="username" placeholder="USERNAME" required></lebel><br>
                    <lebel class="lebel">PASSWORD :- <input type="password" id="password" name="password" placeholder="PASSWORD" required></lebel><br>
                    <input type="submit" class="submit" value="LOG IN"><br>
                </form>
            </div>
            
        </div>
    </div>
</body>
</html>