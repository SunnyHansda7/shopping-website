<?php

include("config.php");
$msg="";
if(isset($_POST['submit']))
{
    if($_POST['admin_pass'] !== 'admin123') {
        echo "<script>alert('Invalid Admin Password!');</script>";
    } else {
        $p_name=$_POST['pName'];
         $p_price=$_POST['pPrice'];
         $p_category=$_POST['pCategory'];
        $target_dir="image/";
       $target_file=$target_dir.basename($_FILES['pImage']["name"]);
       
       // Note: move_uploaded_file does NOT work on Vercel Serverless Functions. 
       // You will need to replace this with Cloudinary/AWS S3 SDK to upload images.
     move_uploaded_file($_FILES['pImage']["tmp_name"],$target_file);
     
    $stmt = mysqli_prepare($conn, "INSERT INTO product(product_name,product_price,product_image,category) VALUES(?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "ssss", $p_name, $p_price, $target_file, $p_category);
    
    if(mysqli_stmt_execute($stmt))
    {
    // echo $msg="Product added to database successfull";
     echo "<script>alert('Product added to database successfull');</script>";
    
    }
    else{
     echo "<script>alert('Faled to add database successfull');</script>";
    
        // echo $msg="Faled to add database successfull";
    }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-light mt-5 rounded">
                <h2 class="text-center p-2">Add product page</h2>
                <form method="post" class="p-2" enctype="multipart/form-data" id="form-box">
                    <div class="form-group">
                        <input type="text" name="pName" class="form-control" placeholder="Product Name" required>

                    </div>
                    <div class="form-group">
                        <input type="text" name="pPrice" class="form-control" placeholder="Product Price" required>

                    </div>
                    <div class="form-group">
                        <select name="pCategory" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="Men\'s Clothing">Men's Clothing</option>
                            <option value="Women\'s Clothing">Women's Clothing</option>
                            <option value="Laptops">Laptops</option>
                            <option value="Mobiles">Mobiles</option>
                            <option value="General">General</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="password" name="admin_pass" class="form-control" placeholder="Admin Password (admin123)" required>
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="pImage" class="form-control" id="customFile" required>
                          
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-danger btn-block" value="Add Product"
                            required>

                    </div>
                    <div class="form-group">
                        <h4 class="text-center"><?php// echo $msg;?></h4>

                    </div>

                </form>







            

            </div>

        </div>


        <div class="row justify-content-center">
            <div class="col-md-6 mt-3 bg-light rounded p-4">
                <a href="index.php" class="btn btn-warning btn-block btn-lg">Go to Product page</a>

            </div>

        </div>

    </div>
</body>

</html>