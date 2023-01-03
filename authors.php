<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("db.php");

if (!empty($_POST['delete_id']) && is_numeric($_POST['delete_id'])) {
    $sql = 'DELETE FROM authors WHERE `authors`.`id`=' . $_POST['delete_id'];
    mysqli_query($conn, $sql);
    header('Location: authors.php');
    exit();
}


$sql = "SELECT * FROM `authors`;";
$result = mysqli_query($conn, $sql);

$authors_list = array();
if (mysqli_num_rows($result) > 0) {
    $authors_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors list</title>
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
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($authors_list as $author) { ?>
                                    <tr>
                                        <td><a class="text-decoration-none text-dark"><?= $author["name"] ?></a></td>
                                        <td><a class="text-decoration-none text-dark"><?= $author["surname"] ?></a></td>
                                        <td>
                                            <form method="POST" action="editauthor.php">
                                                <input type="hidden" value="<?= $author["id"] ?>" name="edit_id">
                                                <input type="submit" class="btn btn-success float-end" value="Update Author">
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" value="<?= $author["id"] ?>" name="delete_id">
                                                <input type="submit" class="btn btn-danger  float-end" value="Delete Author">
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