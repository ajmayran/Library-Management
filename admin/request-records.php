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

    .status-approved {
        color: green;
        font-weight: bold;
    }

    .status-denied {
        color: red;
        font-weight: bold;
    }
</style>

<body>
    <?php
    require_once '../classes/book.borrowing.class.php';
    require_once __DIR__ . '/../includes/functions.php';
    $bookObj = new Borrow();
    $records = $bookObj->showRequestedRecords();


    ?>
    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php';  ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php';  ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <div class="d-flex justify-content-start">
                <h1><i class="bi bi-bookmark-check-fill" style="margin-right: 8px;"></i>Request Records</h1>
            </div>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Requested Books</h5>
                    <div class="table-responsive">
                        <table id="requestsTable" class="display table table-striped">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Student Name</th>
                                    <th>Grade Level</th>
                                    <th>Section</th>
                                    <th>Date Requested</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records as $arr) : ?>
                                    <tr>
                                        <td><?= $arr['title']; ?></td>
                                        <td><?= $arr['student_name']; ?></td>
                                        <td><?= $arr['grade_lvl']; ?></td>
                                        <td><?= $arr['section_name']; ?></td>
                                        <td><?= $arr['request_date']; ?></td>
                                        <td class="text-center">
                                            <div class="status-cell" data-status="<?= $arr['status']; ?>">
                                                <?= $arr['status']; ?>
                                            </div>
                                        </td>
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
            $('#requestsTable').DataTable({
                ordering: false, // Disable ordering/sorting
                responsive: true // Enable responsiveness
            });
        });

        $(document).ready(function() {
            $('#requestsTable').DataTable(); // Initialize DataTables

            // Loop through each status cell and apply the styles
            $('#requestsTable tbody').find('.status-cell').each(function() {
                const status = $(this).data('status'); // Get the status from the data attribute

                if (status === 'Approved') {
                    $(this).css({
                        'background-color': 'green',
                        'margin-left': '10px',
                        'margin-right': '10px',
                        'border-radius': '10px',
                        'padding': '5px',
                        'color': 'white',
                        'font-size': '12px',
                        'font-weight': 'bold'
                    });
                } else if (status === 'Denied') {
                    $(this).css({
                        'background-color': 'red',
                        'margin-left': '10px',
                        'margin-right': '10px',
                        'border-radius': '10px',
                        'padding': '5px',
                        'color': 'white',
                        'font-size': '12px',
                        'font-weight': 'bold'
                    });
                }
            });
        });
    </script>
</body>

</html>