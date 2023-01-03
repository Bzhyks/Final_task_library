<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("db.php");

if (!empty($_POST['delete_id']) && is_numeric($_POST['delete_id'])) {
    $sql = 'DELETE FROM books WHERE `books`.`id`=' . $_POST['delete_id'];
    mysqli_query($conn, $sql);
    header('Location: index.php');
    exit();
}


$sql = "SELECT `books`.*,`authors`.`name`,`authors`.`surname` FROM `books` LEFT JOIN `authors` ON `books`.`author_id`=`authors`.`id` ORDER BY `books`.title;";
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
    <title>Books list</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <?php
                require 'menu.php';
                ?>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Pages</th>
                                    <th>ISBN</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($books_list as $book) { ?>
                                    <tr>
                                        <td><a class="text-decoration-none text-dark" href="description.php?id=<?= $book["id"] ?>" ><?= $book["title"] ?></a></td>
                                        <td><a class="text-decoration-none text-dark" href="authorbooks.php?id=<?= $book["author_id"] ?>" ><?= $book["name"].' '.$book["surname"] ?></a></td>
                                        <td><a class="text-decoration-none text-dark" ><?= $book["pages"] ?></a></td>
                                        <td><a class="text-decoration-none text-dark" ><?= $book["isbn"] ?></a></td>
                                        <td>
                                            <form method="POST" action="edit.php">
                                                <input type="hidden" value="<?= $book["id"] ?>" name="edit_id">
                                                <input type="submit" class="btn btn-success float-end" value="Update Book">
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" value="<?= $book["id"] ?>" name="delete_id">
                                                <input type="submit" class="btn btn-danger  float-end" value="Delete Book">
                                            </form>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>