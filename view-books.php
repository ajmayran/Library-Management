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
<style>
    #booksTable td {
        padding: 1rem;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    #booksTable th {
        padding: 1rem;
    }
</style>

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
                    <th scope="col">ISBN</th>
                    <th scope="col">Book Title</th>
                    <th scope="col">Authors</th>
                    <th scope="col">Publishers</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Year</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($array)) {
                ?>
                    <tr>
                        <td colspan="6">
                            <p class="text-center text-muted">No Books found.</p>
                        </td>
                    </tr>
                    <?php
                } else {
                    foreach ($array as $arr) {
                    ?>
                        <tr>
                            <td><?= $arr['isbn'] ?></td>
                            <td><?= $arr['title'] ?></td>
                            <td>
                                <?php
                                // Check if authors are available and split if needed
                                if (isset($arr['authors']) && !empty($arr['authors'])):
                                    $authors = explode(', ', $arr['authors']);
                                    foreach ($authors as $author):
                                ?>
                                        <span><?= $author; ?></span>
                                    <?php endforeach;
                                else: ?>
                                    <span>No authors listed</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                // Check if authors are available and split if needed
                                if (isset($arr['publishers']) && !empty($arr['publishers'])):
                                    $publishers = explode(', ', $arr['publishers']);
                                    foreach ($publishers as $publisher):
                                ?>
                                        <span><?= $publisher; ?></span>
                                    <?php endforeach;
                                else: ?>
                                    <span>No publishers listed</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $arr['subject_name'] ?></td>
                            <td><?= $arr['year'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php include_once './includes/table-script.php'; ?>
</body>
<?php include_once './includes/footer.php'; ?>

</html>