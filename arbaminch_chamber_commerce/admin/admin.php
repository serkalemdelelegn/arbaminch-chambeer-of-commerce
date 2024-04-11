<?php
session_start();
if(isset($_SESSION['email'])){
  $user_type = $_SESSION['type'];
  if($user_type != 1){
    header('location: ./login.php');
    exit;
  }
}
else{
    header('location: ./login.php');
    exit;
}
include_once('./database.php');
    $sql = "SELECT * FROM users WHERE type = 1";
    $admin = mysqli_query($con, $sql); 
    $totalAdmin = mysqli_num_rows($admin);
    $sql = "SELECT * FROM users";
    $user = mysqli_query($con, $sql); 
    $totalUser = mysqli_num_rows($user);
    $sql = "SELECT * FROM products";
    $product = mysqli_query($con, $sql); 
    $totalProduct = mysqli_num_rows($product);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./adminStyle.css">
    <title>Dashboard</title>
    <style>
     .project_tit {
  margin-top: 200px;
  display: flex;
  justify-content: space-between; /* Distribute space between columns */
}

.column {
  width: 48%; /* Adjust as needed */
}

.project_tit a {
  display: block;
  margin: 10px 0;
  padding: 12px 24px;
  text-decoration: none;
  color: var(--primary-color);
  background-color: var(--secondary-color);
  border-radius: 5px;
  font-size: 1.6rem;
  font-weight: 500;
  transition: background-color 0.3s ease;
}

.project_tit a:hover {
  background-color: var(--secondary-color-hover);
  color: var(--primary-color-hover);
}

.projects__title {
  text-align: center;
  font-size: 4rem;
  font-weight: 500;
  color: var(--title-color);
  margin-bottom: 20px;
}



    </style>
</head>
<body>
    
    <main class="main">
        <section class="projects">
            <h2 class="projects__title subtitle">Admin Dashboard</h2>

            <ul class="projects__list">
            <li class="projects__item">
  <div class="project-card">
    <div class="project-card__text-group">
      <h3 class="project-card__title">Total user</h3>
      <p class="project-card__description" style="align-items: center; justify-content: center; font-size: 100px;">
        <?php echo $totalUser ?>
      </p>
    </div>
  </div>
</li>

                <li class="projects__item">
                    <div class="project-card">
                        <div class="project-card__text-group">
                            <h3 class="project-card__title">Total Admin</h3>
                            <p class="project-card__description" style="align-items: center; justify-content: center; font-size: 100px;">
                            <?php echo $totalAdmin ?>
                            </p>
                        </div>
                    </div>
                </li>
                <li class="projects__item">
                    <div class="project-card">
                        <div class="project-card__text-group">
                            <h3 class="project-card__title">Total Product</h3>
                            <p class="project-card__description" style="align-items: center; justify-content: center; font-size: 100px;">
                            <?php echo $totalProduct ?>
                            </p>
                            
                        </div>
                        
                    </div>
                </li>
            </ul>
            <br>
            <div class="project_tit">
                        <a href="./productTable.php" class="projects__title subtitle">View</a><br>
                            <a href="./productForm.php" class="projects__title subtitle">Add</a><br>
                            <a href="./userList.php" class="projects__title subtitle">Users</a><br>
                            <a href="./product_display.php" class="projects__title subtitle">Customer description </a><br>
                            <a href="./login.php" class="projects__title subtitle">Back to login page</a>
                        </div>
        </section>
    </main>
</body>
</html>
