<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/auth2.css"/>
    <link rel="website icon" href="./images/03.jpg"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Log in</title>
</head>
<body>
    <form method="POST" action="index.php">
        <h2>MEGA <br/>DISPLAY</h2>
        <p class="error"></p>
        <label class="black">Username or Email</label><br/>
        <div>
            <i style="color:black;position:absolute;font-size:25px;" class='bx bxs-user-circle'></i>
            <input style="padding-left:23px" type="text" name="username"/>
        </div>
        <label class="black">Password</label><br/>
        <div>
            <i style="color:black;position:absolute;font-size:23px;" class='bx bxs-lock'></i>
            <input style="padding-left:22px" type="password" name="password"/><br/>
        </div>        
        <a href="./pages/signup.php">Sign up..</a><br/><br/>
        <input class="btn" type="submit" value="Login">
    </form>
</body>
<?php
    $conn = mysqli_connect("localhost","root","");
    if(!$conn){
        echo "<script>Connection to the database engine failled</script>";
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST["username"];
        $pass = md5($_POST["password"]);
        mysqli_query($conn,"USE MegaDisplay");
        $users = mysqli_query($conn,"SELECT username,password,email FROM users");
        while($user = mysqli_fetch_row($users)){
            if(($username == $user[0] && $pass == $user[1]) || ($username == $user[2] && $pass == $user[1])){
                echo "<script>alert('login successfull')</script>";
                header('location: ./pages/homepage.php');
            }
        }
            echo "<script>document.querySelector('.error').innerHTML = 'Invalid Username or Password'</script>"; 
            echo "<script>document.querySelector('.error').classList.add('error2')</script>"; 
    }
    mysqli_close($conn);
?>
</html>