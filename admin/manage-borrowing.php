<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
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
    /* Ensuring table takes full width and prevents compression */
    .table-responsive {
        overflow-x: auto;
    }

    .table th {
        white-space: nowrap;
        /* Ensures text stays on one line */
    }

    .table td {
        font-size: smaller;
    }
</style>

<body>
    <?php
    require_once '../classes/book.borrowing.class.php';
    require_once __DIR__ . '/../includes/functions.php';
    $bookObj = new Books();
    $issued = $bookObj->showIssuedBooks();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return'])) {
        $transaction_id = intval($_POST['transaction_id']);
    $remarks = $_POST['remarks'];

    // Assuming the method returnBook has been modified to accept remarks
    $success = $bookObj->returnBook($transaction_id, $remarks); // Now passing remarks
    $message = $success ? "Book returned successfully!" : "Failed to return the book.";
    echo "<script>alert('$message');</script>";
    }
    ?>
    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php';  ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php';  ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <div class="d-flex justify-content-between">
                <h1>Management</h1>
                <a href="return-records.php" class="text-primary">Check Records</a>
            </div>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../admin/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Issued</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Issued Books</h5>
                    <div class="table-responsive">
                        <table id="issuedTable" class="display table table-striped">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Student Name</th>
                                    <th>Grade Level</th>
                                    <th>Section</th>
                                    <th>Date Borrowed</th>
                                    <th>Expected Return Date</th>
                                    <th>Remarks</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($issued as $arr) : ?>
                                    <tr>
                                        <td><?= $arr['title']; ?></td>
                                        <td><?= $arr['student_name']; ?></td>
                                        <td><?= $arr['grade_lvl']; ?></td>
                                        <td><?= $arr['section_name']; ?></td>
                                        <td><?= date('F j, Y', strtotime($arr['borrow_date'])) ?></td>
                                        <td><?= date('F j, Y', strtotime($arr['return_date'])) ?></td>
                                        <td><?= $arr['remarks'];?></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal"
                                                onclick="setTransactionId(<?= $arr['id']; ?>)">
                                                Return
                                            </button>
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

    <!-- Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnModalLabel">Return Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden Input for Transaction ID -->
                        <input type="hidden" name="transaction_id" id="transaction_id">

                        <!-- Textarea for Remarks -->
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="return" class="btn btn-success">Return</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

        function setTransactionId(transactionId) {
            document.getElementById('transaction_id').value = transactionId;
        }
    </script>
</body>

</html>