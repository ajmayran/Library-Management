<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Books</title>
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
    <?php
    require_once './classes/book.class.php';
    require_once './includes/functions.php';
    $bookObj = new Books();
    $array = $bookObj->fetchOverdues($student_id);
    ?>
    <div class="container">
        <div class="d-flex justify-content-start align-items-center mb-3">
            <h4 class="text-secondary">Overdue Books and Penalties</h4>
        </div>
    </div>

    <!-- Grid Card to Display Overdue Books Count -->
    <div class="row" style="margin-left: 2rem;">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Overdue Books</h5>
                    <h3 class="card-text text-danger">
                        <?php
                        // Get overdue count
                        $overdueCount = $bookObj->countOverdueBooksForStudent($student_id);
                        echo $overdueCount;
                        ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- End Grid Card -->
    <div class="table-responsive">
        <table id="booksTable" class="table  table-hover align-middle shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Book Title</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Borrowed Date</th>
                    <th scope="col">Expected Returned Date</th>
                    <th scope="col">Days Overdue</th>
                    <th scope="col">Fines</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($array)) {
                ?>
                    <tr>
                        <td colspan="7">
                            <p class="text-center text-muted" style="padding: 10rem;">No Books found that is Overdue.</p>
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
                            <td><?= $arr['borrow_date'] ?></td>
                            <td><?= $arr['return_date'] ?></td>
                            <td>
                                <?php if ($arr['overdue_days'] > 0) { ?>
                                    <?= $arr['overdue_days'] ?> days
                                <?php } else { ?>
                                    <span class="text-success">No overdue</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($arr['overdue_days'] > 0) { ?>
                                    $<?= $arr['fine'] ?>
                                <?php } else { ?>
                                    <span class="text-success">No fine</span>
                                <?php } ?>
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