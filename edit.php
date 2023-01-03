<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("db.php");
$title = '';
$author_id = '';
$errors = array();
$books = array();
$id = '';

if (!empty($_POST)) {
    if (!empty($_POST['save']) && !empty($_POST['edit_id']) && is_numeric($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $title = isset($_POST['title']) ? test_input($_POST['title']) : '';
        $author_id = (!empty($_POST['author_id']) && is_numeric($_POST['author_id'])) ? $_POST['author_id'] : '';
        if ($title == '') {
            $errors[] = "Title is required";
        }
        if ($author_id == '') {
            $errors[] = "Author is required";
        }

        if (empty($errors)) {
            $sql = "UPDATE `books` SET `title` = '$title', `author_id` = '$author_id'  WHERE `books`.`id` = '$id';";
            mysqli_query($conn, $sql);
            header('Location: index.php');
            exit();
        }
    } else {

        if (!empty($_POST['edit_id']) && is_numeric($_POST['edit_id'])) {

            $id = $_POST['edit_id'];
            $sql_books = 'SELECT * FROM `books` WHERE `id`=' . $id;
            // die($sql_books);
            $result = mysqli_query($conn, $sql_books);
            if (mysqli_num_rows($result) == 1) {
                $books = mysqli_fetch_assoc($result);

                $title = $books['title'];
                $author_id = $books['author_id'];
            }
            if (empty($books)) {
                header('Location: index.php');
                exit();
            }
        }
    }
} else {
    header('Location: index.php');
    exit();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$sql_author = 'SELECT `id`,`name`,`surname` FROM `authors`;';
$result = mysqli_query($conn, $sql_author);
$author_list = array();
if (mysqli_num_rows($result) > 0) {
    $author_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <?php

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="mb-3">' . $error . '</div>';
            }
        }

        ?>
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card">
                    <?php
                    require 'menu.php';
                    ?>
                    <div class="card-body">
                        <form action="edit.php" method="post">
                            <div class="mb-3 mt-3">
                                <label for="city_name" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" placeholder="Enter book title" name="title" value="<?php echo $title; ?>">
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="form-label" for="">Author</label>
                                <select name="author_id" class="form-select">
                                    <?php foreach ($author_list as $author) {
                                        echo "<option value='" . $author['id'] . "' " . ($author_id == $author['id'] ? " selected" : "") . ">" . $author['name'] ." ".$author['surname']. "</option>";
                                    } ?>
                                </select>
                            </div>
                            <input type="hidden" value="<?= $id ?>" name="edit_id">
                            <input type="submit" class="btn btn-success" name="save" value="Update Book">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>