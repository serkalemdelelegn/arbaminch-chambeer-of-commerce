
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Arbaminch_chamber_of_commerce</title>
    <link rel="stylesheet" href="./styles.css"> <!-- Link to your CSS file for styling -->
<style>
   
   .container1 {
    width: 300px;
    margin: 100px auto;
    background-color: rgb(217, 216, 233);
    padding: 20px;
    border-radius: 5px;
    border-color: #0056b3;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
   }
h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

p {
    text-align: center;
    margin-top: 20px;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

</style>
</head>
<body>
<?php
// Start session
session_start();
$message = '';
include_once('./database.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate form data (you can add more validation as needed)
    if (empty($email) || empty($password)) {
        $message = "All fields are required.";
        exit;
    }
    // Prepare and execute SQL statement to fetch user data from the database
    $sql = "SELECT email,username,type, password FROM users WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Password is correct, log in user
            $_SESSION["email"] = $row["email"];
            $_SESSION["username"] = $row["username"];
            if($row['type'] == '1'){
            $_SESSION['type'] = $row['type'];
            header("Location: admin.php"); 
             }// Redirect to admin 
            else{
                $_SESSION['type'] = $row['type'];
                header("Location: home.php"); 
            }
           
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "Invalid email or password.";
    }

    // Close statement and connection
    $stmt->close();
    $con->close();
}
?>

    <header>
        <div class="container">
            <h1>Arbaminch City Chamber Of Commerce</h1>
          
            
            </div>
        </div>
    </header>

    <div class="container1">
        <form action="./login.php" method="post">
            <h2>Login</h2>
            <p><?php echo $message;  ?></p>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="username" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <p>Don't have an account? <a href="./sign.php">Sign up</a>.</p>
        </form>
    </div>
</body>
</html>
