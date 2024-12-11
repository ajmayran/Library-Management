<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Manage Borrowing</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php include_once './includes/admin_link.php'; ?>
</head>
<style>
    .table-responsive {
        overflow-x: auto;
    }
    .table th {
        white-space: nowrap;
        font-size: 12px;
    }
    .table td {
        font-size: 10px;
    }
</style>

<body>
    <?php
    require_once '../classes/book.borrowing.class.php';
    require_once __DIR__ . '/../includes/functions.php';
    $bookObj = new Books();
    $records = $bookObj->showReturnedRecords();

    ?>
    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php';  ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php';  ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <div class="d-flex justify-content-start">
                <h1><i class="bi bi-bookmark-check-fill" style="margin-right: 8px;"></i>Returned Book Records</h1>
            </div>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Return Books</h5>
                    <div class="table-responsive">
                        <table id="issuedTable" class="display table table-striped">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Student Name</th>
                                    <th>Grade Level</th>
                                    <th>Section</th>
                                    <th>Date Issued</th>
                                    <th>Expected Return Date</th>
                                    <th>Actual Return Date</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records as $arr) : ?>
                                    <tr>
                                        <td><?= $arr['title']; ?></td>
                                        <td><?= $arr['student_name']; ?></td>
                                        <td><?= $arr['grade_lvl']; ?></td>
                                        <td><?= $arr['section_name']; ?></td>
                                        <td><?= $arr['borrow_date']; ?></td>
                                        <td><?= $arr['return_date']; ?></td>
                                        <td><?= $arr['actual_return_date']; ?></td>
                                        <td><?= $arr['remarks']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <?php include_once './includes/admin_script.php';  ?>
    <script>
        $(document).ready(function() {
            // Initialize DataTables with responsive option and disable ordering
            $('#issuedTable').DataTable({
                ordering: false, // Disable ordering/sorting
                responsive: true // Enable responsiveness
            });
        });
    </script>
</body>

</html>