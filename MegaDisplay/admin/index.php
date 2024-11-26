<!--inteliphp-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" href="../images/03.jpg"/>
    <link rel="stylesheet" href="../styles/admin.css"/>
    <title>Admin Page</title>
</head>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $exists = 0;
        $error_code = 0;
        $dir = '../uploads/';
        $image = $_FILES['image'];
        $targetFile = $dir . basename($image['name']);
        //$file_type = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        $check = getimagesize($image['tmp_name']);
        if($check == false){
            $error_code = 1;
        }
        if(file_exists($targetFile)){
            $exists = 1;
        }
        $error_code == 0 && $exists == 0 && move_uploaded_file($image['tmp_name'],$targetFile);
    }
?>
<body>
    <header>
        <img class="logo" src="../images/03.jpg" alt="MegaDisplay Logo">
        <h1> MEGA<br/> DISPLAY </h1>
        <label>Welcome,Tonnie</label>
    </header>
    <div class="navigator">
        <ul>
            <li><a href="../pages/homepage.php">View Products</a></li>
            <li>Update Catalogue</li>
            <li>View Orders</li>
        </ul>
    </div>
    <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST' && $error_code == 1){
            echo "<p style='text-align:center;background-color:lightgreen;color:white;color:red;'>Upload Failed!!</p>";
        }else if($_SERVER['REQUEST_METHOD'] == 'POST' && $error_code == 0){
            echo "<p style='text-align:center;background-color:lightgreen;color:white;color:red;'>Upload Success</p>";
        }
    ?>
    <form action="index.php" enctype="multipart/form-data" method="POST">
        <h2>Update products Catalogue</h2>
        <label>Product Name:</label> <input type="text" required placeholder="eg. Itel P37" name="name"/>
        <label>Product Price:</label> <input type="number" required placeholder="eg. 12000" name="price"/>
        <label>Product Quantity:</label> <input type="number" required value="1" placeholder="eg. 8" name="quantity"/>
        <label>Product Image:</label> <input type="file" required name="image"/>
        <button type="submit">Update</button>
    </form>
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $conn = mysqli_connect('localhost','root','');
            if(!$conn){
                echo "<script>alert('Connection to the database engine Failed')</script>";
            }
            mysqli_query($conn,"USE MegaDisplay");
            $name =  $_POST['name'];
            $price = $_POST['price'];
            $quantity =  $_POST['quantity'];
            $targetFile = basename($image['name']);
            mysqli_query($conn,"CREATE TABLE IF NOT EXISTS products(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255),price INT,image_name VARCHAR(255),quantity INT)");
            function update($error_code,$conn,$name,$price,$quantity,$targetFile){
                if($error_code == 0){
                    $products = mysqli_query($conn,"Select name,price,id,quantity FROM products");
                    while($row =  mysqli_fetch_row($products)){
                        if(strtolower($row[0]) == strtolower($name) && (int)$row[1] == (int)$price){
                            $quantity = $quantity + (int)$row[3];
                            mysqli_query($conn,"UPDATE products SET quantity = '$quantity',image_name = '$targetFile' WHERE id = $row[2]");
                            return;
                        }
                    }
                    mysqli_query($conn,"INSERT INTO products(name,price,image_name,quantity) VALUES('$name','$price','$targetFile','$quantity')");
                }
            }
            update($error_code,$conn,$name,$price,$quantity,$targetFile);        
            mysqli_close($conn);
        };
    ?>
</body>
</html>