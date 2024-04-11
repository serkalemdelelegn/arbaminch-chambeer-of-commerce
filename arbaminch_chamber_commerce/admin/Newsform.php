<?php
include_once('./database.php');
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST["title"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Check if file is uploaded
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        // File uploaded successfully
        $fileName = $_FILES["image"]["name"];
        $fileTmpName = $_FILES["image"]["tmp_name"];
        $fileSize = $_FILES["image"]["size"];
        $fileType = $_FILES["image"]["type"];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check file extension
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileExt, $allowedExtensions)) {
            // Generate unique file name
            $newFileName = uniqid() . "." . $fileExt;
            $destination = "image/" . $newFileName;
            // Move uploaded file to destination
            move_uploaded_file($fileTmpName, $destination);

            // Check conection
            if ($con->connect_error) {
                die("Conection failed: " . $con->connect_error);
            }

            // Prepare and execute SQL statement to insert product data into the database
            $sql = "INSERT INTO products (title, price, description, image) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sdss", $title, $price, $description, $destination);
            if ($stmt->execute()) {
                echo "Product added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }

            // Close statement and connection
            $stmt->close();
            $con->close();
        } else {
            echo "Invalid file extension. Allowed extensions are jpg, jpeg, png, gif.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  outline: none;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
body{
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 10px;
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(115deg, #56d8e4 10%, #9f01ea 90%);
}
.container{
  max-width: 800px;
  background: #fff;
  width: 800px;
  padding: 25px 40px 10px 40px;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
}
.container .text{
  text-align: center;
  font-size: 41px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  background: -webkit-linear-gradient(right, #56d8e4, #9f01ea, #56d8e4, #9f01ea);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.container form{
  padding: 30px 0 0 0;
}
.container form .form-row{
  display: flex;
  margin: 32px 0;
}
form .form-row .input-data{
  width: 100%;
  height: 40px;
  margin: 0 20px;
  position: relative;
}
form .form-row .textarea{
  height: 70px;
}
.input-data input,
.textarea textarea{
  display: block;
  width: 100%;
  height: 100%;
  border: none;
  font-size: 17px;
  border-bottom: 2px solid rgba(0,0,0, 0.12);
}
.input-data input:focus ~ label, .textarea textarea:focus ~ label,
.input-data input:valid ~ label, .textarea textarea:valid ~ label{
  transform: translateY(-20px);
  font-size: 14px;
  color: #3498db;
}
.textarea textarea{
  resize: none;
  padding-top: 10px;
}
.input-data label{
  position: absolute;
  pointer-events: none;
  bottom: 10px;
  font-size: 16px;
  transition: all 0.3s ease;
}
.textarea label{
  width: 100%;
  bottom: 40px;
  background: #fff;
}
.input-data .underline{
  position: absolute;
  bottom: 0;
  height: 2px;
  width: 100%;
}
.input-data .underline:before{
  position: absolute;
  content: "";
  height: 2px;
  width: 100%;
  background: #3498db;
  transform: scaleX(0);
  transform-origin: center;
  transition: transform 0.3s ease;
}
.input-data input:focus ~ .underline:before,
.input-data input:valid ~ .underline:before,
.textarea textarea:focus ~ .underline:before,
.textarea textarea:valid ~ .underline:before{
  transform: scale(1);
}
.submit-btn .input-data{
  overflow: hidden;
  height: 45px!important;
  width: 25%!important;
}
.submit-btn .input-data .inner{
  height: 100%;
  width: 300%;
  position: absolute;
  left: -100%;
  background: -webkit-linear-gradient(right, #56d8e4, #9f01ea, #56d8e4, #9f01ea);
  transition: all 0.4s;
}
.submit-btn .input-data:hover .inner{
  left: 0;
}
.submit-btn .input-data input{
  background: none;
  border: none;
  color: #fff;
  font-size: 17px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  position: relative;
  z-index: 2;
}
@media (max-width: 700px) {
  .container .text{
    font-size: 30px;
  }
  .container form{
    padding: 10px 0 0 0;
  }
  .container form .form-row{
    display: block;
  }
  form .form-row .input-data{
    margin: 35px 0!important;
  }
  .submit-btn .input-data{
    width: 40%!important;
  }
}
    </style>
</head>
<body>
<div class="container">
<a href="./admin.php" class="back-button">Back to Admin</a>
      <div class="text">
        
         Contact us Form
      </div>
      <form action="./productForm.php" method="post" enctype="multipart/form-data" >
         <div class="form-row">
            <div class="input-data">
               <input type="text" name="title"required>
               <div class="underline"></div>
               <label for="">Name</label>
            </div>
            <div class="input-data">
               <input type="number" name="price" required>
               <div class="underline"></div>
               <label for="">Price</label>
            </div>
         </div>
         <div class="form-row">
         <label for="image">Image</label>
            <div class="input-data">
               <input type="file" name="image" required>
               <div class="underline"></div>
            </div>
           
         </div>
         <div class="form-row">
         <div class="input-data textarea">
            <textarea rows="8" cols="80" name="description" required></textarea>
            <br />
            <div class="underline"></div>
            <label for="">Description</label>
            <br />
            <div class="form-row submit-btn">
               <div class="input-data">
                  <div class="inner"></div>
                  <input type="submit" value="submit">
                  
               </div>
            </div>
      </form>
      </div>
</body>
</html>