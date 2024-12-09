<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="./css/headerstyles.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/table-style.css">
    <?php include_once './includes/header-link.php'; ?>
</head>

<body>
    <?php include_once './includes/student_navbar.php'; ?>
    <br>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-secondary">Explore Books in the Library</h4>
            <a href="borrow-book.php" class="btn btn-primary">Request Book</a>
        </div>
    </div>

    <?php
    require_once './classes/book.class.php';
    require_once './includes/functions.php';

    $bookObj = new Books();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $keyword = clean_input($_POST['keyword']);
    }

    $array = $bookObj->showAllBooks();
    ?>
    <div class="table-responsive">
        <table id="booksTable" class="table  table-hover align-middle shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Book Title</th>
                    <th scope="col">Book Author</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Year</th>
                    <th scope="col">Book Publisher</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($array)) {
                ?>
                    <tr>
                        <td colspan="5">
                            <p class="text-center text-muted">No Books found.</p>
                        </td>
                    </tr>
                    <?php
                } else {
                    foreach ($array as $arr) {
                    ?>
                        <tr>
                            <td><?= $arr['id'] ?></td>
                            <td><?= $arr['title'] ?></td>
                            <td><?= $arr['author'] ?></td>
                            <td><?= $arr['subject_name'] ?></td>
                            <td><?= $arr['year'] ?></td>
                            <td><?= $arr['publisher_name'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php include_once './includes/table-script.php';?>
</body>
<?php include_once './includes/footer.php'; ?>

</html>