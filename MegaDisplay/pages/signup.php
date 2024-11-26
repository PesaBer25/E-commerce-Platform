<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="../styles/auth2.css" rel="stylesheet">
    <link rel="website icon" href="../images/03.jpg"/>
</head>
<?php
    $conn = mysqli_connect("localhost","root","");
    if(!$conn){
        echo "<script>Connection to the database engine failled</script>";
    }
    mysqli_query($conn,"USE MegaDisplay");
    $users = mysqli_query($conn,"SELECT email FROM users");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $error_code = 0;
        $name = $_POST['name'];
        $username = $_POST['username'];
        $pass = md5($_POST['password']);
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        while($user = mysqli_fetch_row($users)){
            if($email == $user[0]){
                $error_code = 1;
            }
        }
    }
    
?>
<body>
    <form action="signup.php" method="POST">
        <p class="h"><b>MEGA DISPLAY</b><br> <i>Your shopping center</i>,<br> Register Today</p>
        <?php 
            if($_SERVER['REQUEST_METHOD'] == 'POST' && $error_code == 1){
                echo "<p class='error'>User already exists</p>";
            };
            $pattern =  "/^[a-z ]*$/i";
            if($_SERVER['REQUEST_METHOD'] == 'POST' && !preg_match($pattern,$name)){
                echo "<p class='error'>Name can only contain letters and a space</p>";
                $error_code = 2;
            };
        ?>
        <input name="name" required placeholder="Enter Full Name" type="text" min-length="4"><br>
        <?php 
             $pattern =  "/^[a-z0-9_]*$/i";
             if($_SERVER['REQUEST_METHOD'] == 'POST' && !preg_match($pattern,$username)){
                echo "<p class='error'>Username can only contain letters,numbers and underscore</p>";
                $error_code = 2;
             };
        ?>
        <input name="username" required placeholder="Username" type="text"><br>
        <input name="password" class="password1" required placeholder="Enter Password" type="password"><br>
        <p class="error password"></p>
        <input name="confirmPassword" class="password2" placeholder="Confirm Password" type="password"><br>
        <?php 
            $pattern =  "/^07|\+254|01/i";
            if($_SERVER['REQUEST_METHOD'] == 'POST' && !preg_match($pattern,$contact)){
                echo "<p class='error'>Number must begin with 07, +254 or 01</p>";
                $error_code = 2;
            };
        ?>
        <input name="contact" required placeholder="Phone Number" type="text"><br>
        <input name="email" required placeholder="Email" type="email"><br>
        <p class="h">Already have an account? <a href="../index.php">Login</a><br>
        <input class="btn" type="submit" value="Register">
    </form>
    <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST' && $error_code == 0){
                $statement =  "INSERT INTO users(name,username,password,contact,email) VALUES('$name','$username','$pass','$contact','$email') ";
                mysqli_query($conn,$statement);
                echo "<script>alert('Registrantion Success, Back to Login')</script>";
                header('location: ../index.php');
            }
            mysqli_close($conn);
    ?>
    <script src="../js/signup.js"></script>
</body>
</html>