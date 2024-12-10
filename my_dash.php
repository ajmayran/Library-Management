<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
            <h4 class="text-secondary">My Dashboard</h4>
            <a href="record-request.php" class="btn btn-primary">View Requests</a>
        </div>
    </div>
    <?php
    require_once './classes/book.class.php';
    require_once './includes/functions.php';
    $bookObj = new Books();
    $keyword = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $keyword = clean_input($_POST['keyword']);
    }
    $array = $bookObj->showBorrowed($student_id);
    ?>

    <div class="table-responsive">
        <table id="booksTable" class="table  table-hover align-middle shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Book Title</th>
                    <th scope="col">Book Author</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Borrowed Date</th>
                    <th scope="col">Return Date</th>
                    <th scope="col">Status</th>
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
                            <td><?= $arr['id'] ?></td>
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
                            <td><?= $arr['subject_name'] ?></td>
                            <td><?= date('F j, Y', strtotime($arr['borrow_date'])) ?></td>
                            <td><?= $arr['return_date'] ?></td>
                            <td><?= $arr['status'] ?></td>
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