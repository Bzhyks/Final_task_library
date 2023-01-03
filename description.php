<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("db.php");
?>
<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("location: index.php");
    die();
}

$sql = "SELECT * FROM `books` WHERE `id`=$id;";
$result = mysqli_query($conn, $sql);

$books_list = array();
if (mysqli_num_rows($result) > 0) {
    $books_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Description</title>
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
                        }?>
                        <?php if (!empty($books_list)) { ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Description:</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($books_list as $book) { ?>
                                        <tr>
                                            <td class="mt-2"><?= $book["short_description"] ?></td>
                                            <td><a class="btn btn-success mt-2" href="index.php">Go Back</a></td>
                                        </tr>
                                    <?php } }?>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>