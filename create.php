<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("db.php");
$title = '';
$author_id = '';
$pages = '';
$isbn = '';
$short_description = '';
$errors = array();
if (!empty($_POST)) {
    $title = isset($_POST['title']) ? test_input($_POST['title']) : '';
    $author_id = (!empty($_POST['author_id']) && is_numeric($_POST['author_id'])) ? $_POST['author_id'] : '';
    $pages = (!empty($_POST['pages']) && is_numeric($_POST['pages'])) ? $_POST['pages'] : '';
    $isbn = isset($_POST['isbn']) ? test_input($_POST['isbn']) : '';
    $short_description = isset($_POST['short_description']) ? test_input($_POST['short_description']) : '';
    if ($title == '') {
        $errors[] = "Title is required";
    }
    if ($author_id == '') {
        $errors[] = "Author is required";
    }
    if ($pages == '') {
        $errors[] = "Pages is required";
    }
    if ($isbn == '') {
        $errors[] = "ISBN is required";
    }
    if ($short_description == '') {
        $errors[] = "Description is required";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO `books` (`title`, `author_id`, `pages`, `isbn`, `short_description`) VALUES ('$title', '$author_id', '$pages', '$isbn', '$short_description');";
        mysqli_query($conn, $sql);
        header('Location: index.php');
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
    <title>Add new Book</title>
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
                        <form action="create.php" method="post">
                            <div class="mb-3 mt-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" value="<?php echo $title; ?>">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="pages" class="form-label">Pages:</label>
                                <input type="number" class="form-control" id="pages" placeholder="Enter Amount of Pages" name="pages" value="<?php echo $pages; ?>">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="isbn" class="form-label">ISBN:</label>
                                <input type="text" class="form-control" id="isbn" placeholder="Enter ISBN" name="isbn" value="<?php echo $isbn; ?>">
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="form-label" for="">Author</label>
                                <select name="author_id" class="form-select">
                                    <?php
                                    foreach ($author_list as $author) { ?>
                                        <option value="<?php echo $author['id'] ?>"><?php echo $author['name'] .' '.$author['surname'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="short_description" class="form-label">Short description:</label>
                                <textarea name="short_description" id="short_description" cols="30" rows="10" class="form-control" value="<?php echo $short_description; ?>"></textarea>
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