<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username === 'admin' && $password === 'password') {
        header("Location: create.php");
        exit;
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>System Login</title>
</head>

<body style=" font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #006989;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh; ">
    <div class="container" style="background-color: #005C78;
      width: 400px;
      padding: 50px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      border-radius: 8px; ">
        <h1 style=" color: #fff;
      margin-bottom: 30px;">Login</h1>
        <form action="login.php" method="post">
            <div class="form-group" style="margin-bottom: 20px;
      text-align: left">
                <label for="username" style="display: block;
      color: #fff;
      margin-bottom: 5px;">Username:</label>
                <input type="text" id="username" name="username" required style="width: calc(100% - 22px); 
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;
      text-align: left">
                <label for="password" style="display: block;
      color: #fff;
      margin-bottom: 5px;">Password:</label>
                <input type="password" id="password" name="password" required style="width: calc(100% - 22px); 
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;">
            </div>
            <div class="form-group">
                <button type="submit" style="background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-align: center;">Login</button>
            </div>
            <?php

            if (isset($error)) {
                echo '<div class="error-message">' . $error . '</div>';
            }
            ?>
        </form>
    </div>
    <style>
        button:hover {
            background-color: #45A049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</body>

</html>
