<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("db.php");
$name = '';
$surname = '';
$errors = array();
if (!empty($_POST)) {
    $name = isset($_POST['name']) ? test_input($_POST['name']) : '';
    $surname = isset($_POST['surname']) ? test_input($_POST['surname']) : '';
    if ($name == '') {
        $errors[] = "Name is required";
    }
    if ($surname == '') {
        $errors[] = "Surname is required";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO `authors` (`name`, `surname`) VALUES ('$name', '$surname');";
        mysqli_query($conn, $sql);
        header('Location: authors.php');
        exit();
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
    <title>Add new Author</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card">
                    <?php
                    require 'menu.php';
                    ?>
                    <div class="card-body">
                    <?php

                        if (!empty($errors)) {
                        foreach ($errors as $error) {
                             echo '<div class="alert alert-danger">' . $error . '</div>';
                             }
                        }

                    ?>
                        <form action="createauthor.php" method="post">
                            <div class="mb-3 mt-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="<?php echo $name; ?>">
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="form-label" for="">Surname:</label>
                                <input type="text" class="form-control" id="surname" placeholder="Enter Surname" name="surname" value="<?php echo $surname; ?>">
                            </div>
                            <button type="submit" class="btn btn-success">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>