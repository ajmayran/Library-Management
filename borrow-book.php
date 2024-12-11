<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Books</title>
    <link rel="stylesheet" href="./css/headerstyles.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/table-style.css">
    <?php include_once './includes/header-link.php'; ?>
</head>
<style>
    #booksTable td{
        padding: 1rem;
    }
    #booksTable th{
        padding: 1rem;
    }    
</style>
<body>
    <?php include_once './includes/student_navbar.php'; ?>
    <br>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-secondary">Request to Borrow Books</h4>
        </div>
    </div>
    <?php
    require_once './classes/book.class.php';
    require_once './includes/functions.php';
    ?>

    <?php
    $student_id = $_SESSION['student_id'];
    $bookObj = new Books();
    $array = $bookObj->fetchAvailableBooks();
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
        $book_id = intval($_POST['book_id']);

        // Check if the student has already requested or borrowed the book
        if ($bookObj->hasAlreadyBorrowed($student_id, $book_id)) {
            $message = "You have already borrowed or requested this book.";
            echo "<script>alert('$message');</script>";
        } else {
            $success = $bookObj->book_request($student_id, $book_id);
            if ($success) {
                $message = "Book request sent successfully!";
                echo "<script>alert('$message');</script>";
            } else {
                $message = "Failed to send the request.";
                echo "<script>alert('$message');</script>";
            }
        }
    }

    ?>
    <div class="table-responsive">
        <table id="booksTable" class="table  table-hover align-middle shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Book Title</th>
                    <th scope="col">Authors</th>
                    <th scope="col">Publishers</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Year</th>
                    <th scope="col">No. of Copies</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($array)) {
                ?>
                    <tr>
                        <td colspan="7">
                            <p class="text-center text-muted" style="padding: 10rem;">No Books found.</p>
                        </td>
                    </tr>
                    <?php
                } else {
                    foreach ($array as $arr) {
                    ?>
                        <tr>
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
                            <td class="text-center"><?= $arr['no_of_copies'] ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="book_id" value="<?= $arr['id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm"
                                        <?= $bookObj->hasAlreadyBorrowed($student_id, $arr['id']) ? 'disabled' : '' ?>>
                                        Request Book
                                    </button>
                                </form>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap and DataTables JS -->
    <?php include_once './includes/table-script.php'; ?>
</body>
<?php include_once './includes/footer.php'; ?>

</html>