
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOTES</title>
    <link rel="stylesheet" href="note.css">
    <style>
        
        #dlt{
            border:2px solid yellow;
            color:yellow;
            background-color: red;
            border-radius: 20px;
            padding:10px;
            width:100px;
            text-align: center;
            cursor: pointer;
        }
        #dlt:hover{
            border:2px solid red;
            color:red;
            background-color: yellow;
        }
        #edit{
            border:2px solid greenyellow;
            color:greenyellow;
            background-color: green;
            width:100px;
            border-radius:20px;
            padding:10px;
            text-align: center;
            cursor: pointer;
        }
        #edit:hover{
            border:2px solid green;
            color:green;
            background-color: greenyellow;
        }
        #read{
            border:2px solid wheat;
            color:wheat;
            background-color: black;
            width:150px;
            border-radius:20px;
            padding:10px;
            text-align: center;
            cursor: pointer;
        }
        #read:hover{
            border:2px solid black;
            color:black;
            background-color: wheat;
        }
        #cancel{
            border:2px solid wheat;
            color:wheat;
            background-color: black;
            width:150px;
            border-radius:20px;
            padding:10px;
            text-align: center;
            cursor: pointer;
            margin-top: 10px;
        }
        #cancel:hover{
            border:2px solid black;
            color:black;
            background-color: wheat;
        }
        #desc{
            height:200px;
            text-align: left;
        }
        #alter{
            display:none;
        }
        #switch{
            margin:10px;
            padding:10px;
            display: flex;
            justify-content: center;
        }
        #table{
            display: none;
            width:80%;
            text-align: center;
            margin:auto;
        }
        tr{
            width:100%;
        }
        th{
            width:25%;
        }
        #dltform,#edform{
            width:50%;
            margin:auto;
            margin-top: 20px;
        }
        #edform{
            width:80%;
            margin:auto;
            margin-top: 80px;
        }
        #delete{
            text-align: center;
            width:100%;
        }
        
        #edtitle{
            border:2px solid black;
            border-radius: 10px;
            margin-top: 10px;
            width:80%;
            height:50px;
            text-align: center;
            font-size: 25px;
        }
        #edesc{
            border:2px solid black;
            border-radius: 10px;
            width:80%;
            height:200px;
            font-size: 20px;
        }
        .edlebel{
            color:gold;
            font-size: 20px;
        }
        .cls{
            margin:10px;
        }
    </style>
</head>
<body>
    <?php
    require 'config.php';
    session_start();
    $user=$_SESSION['username'];
    echo '<nav id="navbar">
        <h1><em>^_^ NOTES /.</em></h1>
        <h2>WELCOME <u>'.$user.
        '</u></h2><a href="index.html" class="navlink">LOG OUT</a>
    </nav>';

    // INSERTING DATA
    if(isset($_POST['title'])){
        
        $title=$_POST['title'];
        $description=$_POST['desc'];

        $sql="INSERT INTO `notes` (`username`, `title`, `description`) VALUES ('$user','$title','$description')";
        $result=mysqli_query($conn,$sql);
        if($result){
            echo "<script>alert('NOTE SUCCESSFULLY INSERTED....')</script>";
        }
        else{
            echo "<script>alert('FAILED TO INSERT NOTE....')</script>";
        }
    }
    ?>
    <!-- MAIN FORM BODY -->
    <form id="container" method="post" action="note.php">
        <div id="notetitle">
            <h2>-: NOTE TITLE :-</h2>
            <input type="text" id="title" name="title" placeholder="NOTE TITLE" required>
        </div>
        <div id="notedesc">
            <h2>-: NOTE DESCRIPTION :-</h2>
            <textarea name="desc" id="desc" required></textarea>
        </div>
        <input type="submit" name="submit" id="submit" value="ADD NOTE">
    </form>

    <!-- READ, DELETE, UPDATE SWITCHES -->
    <nav id="switch">
        
        <form action="note.php" method="post">
            <input type="submit" class="cls" name="dlt" value="DELETE" id="dlt">
        </form>
        <button id="read" class="cls" onclick="display()">SHOW NOTES</button>
        <form action="note.php" method="post">
            <input type="submit" class="cls" name="edit" value="UPDATE" id="edit">
        </form>
    </nav>

    <!-- DELETEING & UPDATING DATA  -->
    <div id=delete>
    <?php
    if(isset($_POST["dlt"]))
    {
        echo '<script>document.getElementById("switch").style="display:none"</script>';
        echo "<form method='post' id='dltform' onsubmit='return check()'>
        <input type='text' name='dltitle' id='title' placeholder='TITLE OF THE NOTE TO BE DELETED'>
        <input type='submit' name='dlt' value='DELETE' id='dlt'>
        </form>";

        echo "<form method='post' id='cancelform'>
        <input type='submit' name='cancel' value='CANCEL' id='cancel'>
        </form>";

        require 'config.php';
        $query="SELECT * FROM `notes` WHERE `username`='$user'";
        $data=mysqli_query($conn,$query);
        if(!$data){
            die("error");
        }
        $total=mysqli_num_rows($data);
        // DELETING DATA
        if(isset($_POST['dltitle']))
        {
            $flag=false;
            while($total>0){
                echo "<script>document.getElementById('dltform').style='display:none'</script>";
                echo "<script>document.getElementById('cancelform').style='display:none'</script>";
                $R=mysqli_fetch_assoc($data);
                // echo "R=".$R['title']."<br>";
                $title=$_POST['dltitle'];
                
                if(strcmp($title,$R['title'])==0){
                    // echo "deletion start";
                    $flag=true;                 
                    $sql="DELETE FROM `notes` WHERE `title`='$title' AND `username`= '$user'";
                    $result=mysqli_query($conn,$sql);
                    if($result){
                        echo "<script>alert('SUCCESSFULLY DELETED....')</script>";
                    }
                    else{
                        echo "<script>alert('DELETETION FAILED....')</script>";
                    }
                    break;
                    
                }
                $total-=1;
            }
            if(!$flag){
                echo "<script>alert('NO MATCH FOUND....')</script>";
            }
            if(isset($_POST['cancel'])){
                echo "<script>document.getElementById('dltform').style='display:none'</script>";
                echo "<script>document.getElementById('cancelform').style='display:none'</script>";
            }
            echo '<script>document.getElementById("switch").style="display:flex;justify-content:center"</script>';
        }
    }
    // UPDATING DATA
    if(isset($_POST['edit'])){
        echo '<script>document.getElementById("switch").style="display:none"</script>';
        echo '<script>document.getElementById("container").style="display:none"</script>';
        echo "<form method='post' id='edform' onsubmit='return checkupdate()'>
        <h2 class='edlebel'>THIS WILL OVERWRITE YOUR PREVIOUS NOTE WITH THE SAME TITLE<br></h2><h2 class='edlebel'>-: ENTER TITLE ( It should already exist .. ) :-</h2>
        <input type='text' name='edtitle' id='edtitle' placeholder='TITLE OF THE NOTE TO BE EDITED'><br>
        <h2 class='edlebel'>-: ENTER NOTE :-</h2>
        <textarea name='edesc' id='edesc' required></textarea><br>
        <input type='submit' name='edit' value='UPDATE' id='edit'>
        </form>";

        echo "<form method='post' id='cancelform'>
        <input type='submit' name='cancel' value='CANCEL' id='cancel'>
        </form>";

        require 'config.php';
        $query="SELECT * FROM `notes` WHERE `username`='$user'";
        $data=mysqli_query($conn,$query);
        if(!$data){
            die("error");
        }
        $total=mysqli_num_rows($data);
        if(isset($_POST['edtitle']))
        {
            $flag=false;
            while($total>0){
                echo "<script>document.getElementById('edform').style='display:none'</script>";
                echo "<script>document.getElementById('cancelform').style='display:none'</script>";
                $R=mysqli_fetch_assoc($data);
                // echo "R=".$R['title']."<br>";
                $title=$_POST['edtitle'];
                $des=$_POST['edesc'];
                
                if(strcmp($title,$R['title'])==0){
                    // echo "deletion start";
                    $flag=true;                 
                    $sql="UPDATE `notes` SET `description`='$des', `date/time`=current_timestamp() WHERE `title`='$title' AND `username`= '$user'";
                    $result=mysqli_query($conn,$sql);
                    if($result){
                        echo "<script>alert('SUCCESSFULLY UPDATED....')</script>";
                    }
                    else{
                        echo "<script>alert('UPDATION FAILED....')</script>";
                    }
                    break;
                    
                }
                $total-=1;
            }
            if(!$flag){
                echo "<script>alert('NO MATCH FOUND....')</script>";
            }
            if(isset($_POST['cancel'])){
                echo "<script>document.getElementById('dltform').style='display:none'</script>";
                echo "<script>document.getElementById('cancelform').style='display:none'</script>";
            }
            echo '<script>document.getElementById("switch").style="display:flex;justify-content:center"</script>';
            echo '<script>document.getElementById("container").style="display:block"</script>';
        }
    }
    ?>
    </div>
    
    <!-- READING DATA -->
    <table id="table">
            <tr id="head">
                <th>SERIAL</th>
                <th>TITLE</th>
                <th>NOTE</th>
                <th>DATE/TIME</th>
            </tr>
            <?php
            require 'config.php';
            $query="SELECT * FROM `notes`";
            $data=mysqli_query($conn,$query);
            $total=mysqli_num_rows($data);
            $count=1;
            while($total>0){
                $R=mysqli_fetch_assoc($data);
                if(strcmp($user,$R['username'])==0)
                {
                    echo "<tr id='row'><th>".$count."</th><th>".$R['title']."</th><th>".$R['description']."</th><th>".$R['date/time']."</th>";
                    $count+=1;
                }
                $total-=1;
                
            }
            ?>
     </table>
     <!-- JAVASCRIPT -->
    <script>
        function check()
        {
            
            return confirm("ARE YOU SURE?");
        }
        function display(){
            let table=document.getElementById("table");
            let ele=document.getElementById("read");
            if(table.style.display=="none"){
                table.style="display:block";
                ele.innerHTML="HIDE NOTES";
            }
            else{
                table.style="display:none";
                ele.innerHTML="SHOW NOTES";
            }
        }
        function checkupdate()
        {
            return confirm("THIS WILL OVERWRITE YOUR PREVIOUS NOTE WITH THIS TITLE.....ARE YOU SURE YOU WANT THAT?");
        }
    </script>
</body>
</html>