<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" href="../images/03.jpg"/>
    <link rel="stylesheet" href="../styles/Products.css"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Home page</title>
</head>
<body>
<section class="header">
    <img class="logo" src="../images/03.jpg" alt="MegaDisplay Logo">
    <h1> MEGA<br/> DISPLAY </h1>
    <a class="cart" style="position: relative;" href="./cart.php"><sub><i style="font-size:30px;padding-top:4px;" class='bx bx-cart'></i></sub><sup style="position: absolute;background-color:red; padding:0 3px;border-radius:33%;">10</sup></a>
</section>
<form action="homepage.php" method="POST"> 
    <span class="menu"><i class='bx bx-menu'></i></span>
    <div class="srch">
        <input type="text" name="search" value="<?php $_SERVER['REQUEST_METHOD'] == 'POST'? print $_POST['search'] : ""?>" class="search" placeholder="Search for items..."/>
        <button class="btn" type="submit"><i class='bx bx-search'>search</i></button>
    </div>
    <label><?php isset($_SESSION['email']) ?  print "Welcome, ".$_SESSION['email'] : print "<a style='color:black;' href='../index.php'>Login</a>" ?></label>
</form>
<div class="products">
    <?php
        $conn = mysqli_connect("localhost","root","");
        if(!$conn){
            echo "<script>alert('Connection to the database engine Failed')</script>";
        }
        mysqli_query($conn,"USE MegaDisplay");
        $products;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $regexp = $_POST['search'];
            $products = $products = mysqli_query($conn,"SELECT * FROM products WHERE name REGEXP '$regexp'");
        }else{
            $products = mysqli_query($conn,"SELECT * FROM products");
        }
        
        while($row = mysqli_fetch_row($products)){
            $available = "Out of Stock";
            if($row[4] > 0){
                $available = "In Stock";
            }
            $item = '<div class="product">'.
                    '<span style="color:green;width:100%;text-align:end;">'.$available.'</span>'.
                    '<img class="image" src="../uploads/'.$row[3].'"/>'.
                    '<span>'.$row[1].'</span>'.
                    '<span>Ksh '.$row[2].'</span>'.
                    '<span class="adj"><button>-</button><label>1</label><button>+</button></span>'.
                    '<button class="add">Add to Cart</button>'.
                    '</div>';
            echo $item;
        }
        mysqli_close($conn);
    ?>
</div>
<footer>
    <p>&copy;2009 - <?php echo date('Y')?> <i>All rights reserved, Mega Display Coporations</i></p>
</footer>
</body>
</html>