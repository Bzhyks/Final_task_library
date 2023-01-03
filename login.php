<?php
session_start();
require_once('db.php');
$user_name = $user_password = "";
$errors = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = test_input($_POST["user_name"]);
    $user_password = test_input($_POST["user_password"]);
    if (empty($user_name)) {
        $errors[] = 'User name is required';
    }
    if (empty($user_password)) {
        $errors[] = 'Password is required';
    }
    if (empty($errors)) {
        $user_password = sha1($user_password);
        $sql_user = "SELECT `id` FROM `users` WHERE `name`='$user_name' AND `password`='$user_password' ;";
        $result = mysqli_query($conn, $sql_user);
        $user = array();
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $user['id'];
            header('Location: index.php');
            exit();
        }
    }
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>Login</title>
</head>

<body>

    <div class="container">
        <div class="row d-flex justify-content-center align-items-center" style="height:50vh">
            <div class="col-md-4 mt-3">
                <?php

                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                }

                ?>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="user_name">Username:</label>
                        <input type="text" class="form-control" name="user_name">
                    </div>
                    <div class="form-group">
                        <label for="user_password">Password:</label>
                        <input type="password" class="form-control" name="user_password">
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Login</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>